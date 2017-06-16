<?php

################################################################
#
# index.php    
# Simple Vault: online password manager  // John Mod 1.5Mod 0.2
#
#   Author:  Rolf Brugger
#    Email:  mail at rolfb dot ch
#
# Versions - History:
#	     1.5mod3 Apr2010 Jon Mod 4 : BGcolor same as text color
#	     1.5  Apr 2010 : Jon Mod 3: Added a retype passphrase
#           1.5  Jan 10: Ignore empty lines in bulk decrypt tool.
#                        Font and screen size adaped to iPhone.
#                        Import from text file.
#                        Internally restructured according to MVC model, and support for templates added.
#                        iPhone template added.
#                        Option added that the same pass phrase must be used in the entire vault ($forcesamepf='a') or in a category ($forcesamepf='c')
#           1.4  Feb 08: Prevent forms form autocompleting fields.
#                        When an entry is saved, it is checked if the passphrase was used for other entries too.
#                        New tools area.
#                        New functions: bulk decrypt, bulk change passphrase.
#           1.3  Jan 08: More secure handling of special characters in title tags
#           1.2  Nov 07: Editing entires improved
#           1.1  Oct 07: Edit entires
#           1.0  Sep 07: Initial release
# 
################################################################

$version_num="1.5-mod4 Apr2010 Jon Mod 4 ";

// ----------------------------------------------------------------------------------------
// *** Settings
// ----------------------------------------------------------------------------------------

// date format string as used by php function 'date'
//$dateformat = 'm.d.y G:i';    // "09.19.07 15:44"
//$dateformat = 'M jS Y g:ia';  // "Sep 19th 2007 3:44pm"
//$dateformat = 'd-M-Y G:i';    // "09-Sep-2007 15:44"
$dateformat = 'd-M-Y';          // "09-Sep-2007"

// Checks if the pass phrase that was entered to encode an entry has already
// been used to encode other entries. Depending on the usage scenario a re-used
// pass phrase may be wanted or unwanted. 
// 1 to enable check, 0 to disable check.
$checkexistingpf = 1;

// Restictions to be applied for a pass phrase when an entry is saved. ********
// 0: No restrictions. Any entry can be saved with any pass phrase
// a: An entry can only be saved with a pass phrase that has been used to encode
//    all other entries. All entries will have the same pass phrase.
// c: An entry can only be saved with a pass phrase that has been used to encode
//    all other entries of the same category. All entries in a category will have the same 
//    pass phrase.
$forcesamepf = '0';

// ----------------------------------------------------------------------------------------
// *** Look and Feel / Templates
// ----------------------------------------------------------------------------------------

if (strpos( $_SERVER["HTTP_USER_AGENT"], 'iPhone' )){
  // 
  $defaulttemplate = 'tpl-iphone';
}
else{
  $defaulttemplate = 'tpl-std2'; //orig is tpl-std   // tpl-captcha  tpl-std2 hides text using same color&bgcolor
}

// ----------------------------------------------------------------------------------------
// *** Constants
// ----------------------------------------------------------------------------------------

$vaultdir   = "vault";
$vaultfile  = "simplevaultutf8.txt";
$cipher     = 'rijndael-192'; // rijndael-256 normal , sch.gr ONLY supports *** rijndael-192

//Crypted text display color (put same values so that the user has to display the text to see it - it's a very basic hide trick)
$text_bg_table_color="grey";
$text_ps_color		="grey";
$text_notes_color	="grey";

// ----------------------------------------------------------------------------------------
// *** Constants - Do not change!
// ----------------------------------------------------------------------------------------
$preamble    = "svpwdmanag";
$nbfields    = 10;
$nbencfields = 10;


// ----------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------

// *** Initializations

$template = $defaulttemplate;

$vlt = explode("\n", file_get_contents("$vaultdir/$vaultfile"));
if(count($vlt)==1 and strlen($vlt[0])==0){$vlt=array();} // fix php-explode bug of an empty file
$cats = categories($vlt);

$myfname = basename($_SERVER["PHP_SELF"]);
$infomsg = array();
$errormsg= array();

// ----------------------------------------------------------------------------------------
// *** Actions
// ----------------------------------------------------------------------------------------

// *** save an entry
if(isset($_POST['entrysave'])){

  if (!isset($_POST['cat']) or strlen($_POST['cat'])<1){ $_POST['cat']=$_POST['catdl']; $_REQUEST['cat']=$_POST['catdl']; } // take category from dropdown list? category in text field has precedence.

  // *** make checks
  if(!isset($_POST['cat']) or strlen($_POST['cat'])==0){
    $errormsg[] = "Could not save entry: no category set.</span></p>";
  }
  else if(!isset($_POST['t1']) or strlen($_POST['t1'])==0){
    $errormsg[] = "Could not save entry: no title set.</span></p>";
  }
  else if ($forcesamepf == 'a' and count($vlt)>=1 and svcountdecodeableentries($_POST['pf'], "")==0){
    $errormsg[] = "Could not save entry!";
    $errormsg[] = "You have entered an invalid pass phrase. All entries have to be encoded with the same pass phrase. Go back an use the same pass phrase that was used to encode the other entries.";
  }

  else if ($forcesamepf == 'c' and svcountcatentries($_POST['cat'])>=1 and svcountdecodeableentries($_POST['pf'], $_POST['cat'] )==0){
    $errormsg[] = "Could not save entry!";
    $errormsg[] = "You have entered an invalid pass phrase. All entries in a category have to be encoded with the same pass phrase. Go back an use the same pass phrase that was used to encode the other entries in the category {$_POST['cat']}.";
  }
  else if($_POST['pf']!=$_POST['pf2']) {
	$errormsg[] = "Error - Passphrases are not identical !!!";
  }// Added by JON (checks if re-type password is correct)
  // *** everything checked - save the entry now  
  else{
    if(isset($_POST['mode']) and $_POST['mode']=="modify"){
      // we were editing an existing entry. Delete original entry before saving the modified entry.
      $i = entry_index($vlt, $_POST['defcat'], $_POST['deft1'], $_POST['deft2']);
      if ($i >= 0){
        delete_entry($vlt, $i, $cats);
      }
    }

    // for security reasons, strip off all html special characters
    $_POST['cat'] = strip_titletags($_POST['cat']);
    $_POST['t1']  = strip_titletags($_POST['t1']);
    $_POST['t2']  = strip_titletags($_POST['t2']);
    if(entry_index($vlt, $_POST['cat'], $_POST['t1'], $_POST['t2']) <0){
      // *** create new entry
      $encpart  = svencrypt($_POST['pf'], $preamble, $_POST['newp1'], $_POST['newp2'], $_POST['newp3'], $_POST['newp8'], $_POST['newp9'], $_POST['newnote']);
      $newentry = $_POST['cat']."\t".$_POST['t1']."\t".$_POST['t2']."\t".time()."\t\t\t\t\t\t".$encpart;
    
      // append it to the vault file
      array_push($vlt, $newentry);
      sort($vlt);
      while($vlt[0]==""){array_shift($vlt);};
    
      file_put_contents("$vaultdir/$vaultfile", implode("\n", $vlt));
      $cats = categories($vlt);
      $infomsg[] = "Entry ".$_POST['t1']."/".$_POST['t2']." saved.";

      if ($checkexistingpf){
        if (svcountdecodeableentries($_POST['pf'], "") > 1){ // has the passphrase already been used to encode other entries?
          $infomsg[] = "This passphrase has already been used to encode other entries.";
        }
        else{
          $infomsg[] = "This is a new passphrase.";
        }
      }
    }
    else{
      $errormsg[] = "Could not save entry: an entry with this category and title already exists.";
    }
  }  
}


// *** Bulk change passphrase
if(isset($_POST['bulkchangepf'])){
  $i=0;
  $count = 0;
  $logmsg = "re-encrypting: ";
  while ($i < count($vlt)){
    $recfields = explode ("\t", $vlt[$i], $nbfields);
    $decfields = svdecrypt($_POST['oldpf'], $recfields[$nbfields-1]);
    if ($decfields[0] == $preamble){
      $encpart  = svencrypt($_POST['newpf'], $preamble, $decfields[1], $decfields[2], $decfields[3], $decfields[8], $decfields[9], $decfields[$nbencfields]);
      $vlt[$i] = $recfields[0]."\t".$recfields[1]."\t".$recfields[2]."\t".time()."\t\t\t\t\t\t".$encpart;
      $logmsg .= $recfields[0]."-".$recfields[1]."-".$recfields[2]."(note".$decfields[$nbencfields]."), &nbsp; ";
      $count++;
    }
    $i++;
  }
  file_put_contents("$vaultdir/$vaultfile", implode("\n", $vlt));  
  $infomsg[] = $logmsg;
  $infomsg[] = "$count of ".count($vlt)." entries were re-encrypted with the new passphrase.";
}


// *** Bulk import entries
if(isset($_POST['bulkimportentries'])){
  $count = 0;
  $logmsg = "";
  $errmsg = "";
  //print "<p>importing: '".$_FILES['importfile']['tmp_name']."'";  
  $importcat = strip_titletags($_POST['importcat']);
  // read file line by line
  $handle = fopen ($_FILES['importfile']['tmp_name'], "r");
  $title=""; $subtitle=""; $url=""; $login=""; $password=""; $note="";
  while (!feof($handle)) {
    $line = fgets($handle); // get next line
    if (preg_match("/^Title:\s*(\S.*)$/", $line, $matches) or feof($handle)){
      if ($title!=""){
        // save the entry
        //print "SAVE ENTRY $title - $subtitle - $url - $login - $password - $note <br>";
        $title  = strip_titletags($title);
        $subtitle  = strip_titletags($subtitle);
        if(entry_index($vlt, $importcat, $title, $subtitle) <0){
          // *** create new entry
          $encpart  = svencrypt($_POST['pf'], $preamble, $login, $url, $password, "", "", $note);
          $newentry = $importcat."\t".$title."\t".$ubtitle."\t".time()."\t\t\t\t\t\t".$encpart;
          // append it to the vault file
          array_push($vlt, $newentry);
          sort($vlt);
          $logmsg .= "Entry $title $subtitle saved.";
          $count++;
        }
        else{
          $errmsg .= "Could not save entry '$title': an entry with this category and title already exists.";
        }
        
        $title=""; $subtitle=""; $url=""; $login=""; $password=""; $note="";
      }
      $title = trim($matches[1]);
    }
    elseif (preg_match("/^Subtitle:\s*(\S.*)$/", $line, $matches)){
      $subtitle = trim($matches[1]);
    }
    elseif (preg_match("/^URL:\s*(\S.*)$/", $line, $matches)){
      $url = trim($matches[1]);
    }
    elseif (preg_match("/^Login:\s*(\S.*)$/", $line, $matches)){
      $login = trim($matches[1]);
    }
    elseif (preg_match("/^Password:\s*(\S.*)$/", $line, $matches)){
      $password = trim($matches[1]);
    }
    elseif (preg_match("/^Note:(.*)$/", $line, $matches)){
      $note = $matches[1];
    }
    else{
      $note .= $line;
    }
  }
  fclose ($handle);
  
  // save vaultfile
  while($vlt[0]==""){array_shift($vlt);};
  file_put_contents("$vaultdir/$vaultfile", implode("\n", $vlt));
  $cats = categories($vlt);
  $infomsg[] = $logmsg;
  $infomsg[] = "$count entries have been imported.";
  $errormsg[] = $errmsg;
}



// ----------------------------------------------------------------------------------------
// *** Main Pages
// ----------------------------------------------------------------------------------------

// *** Show one entry
if (                isset($_POST['entrysave'])    ){ $decrmode = "decrypt"; }
if ($_GET['dec'] or isset($_POST['entrydecrypt']) ){ $decrmode = "decrypt"; }
if ($_GET['del'] or isset($_POST['entrydelete'] ) ){ $decrmode = "delete"; }
if ($_GET['edt'] or isset($_POST['entryedit']   ) ){ $decrmode = "edit"; }

if(isset($decrmode)) {
  // decrypt the specified entry

  // for security reasons, strip off all html special characters
  $pf  = strip_titletags($_POST['pf']);
  $cat = strip_titletags($_REQUEST['cat']);
  $t1  = strip_titletags($_REQUEST['t1']);
  $t2  = strip_titletags($_REQUEST['t2']);

  if (isset($_POST['entrydecrypt']) or isset($_POST['entrydelete']) or isset($_POST['entryedit'])){
    // find and decrypt it
    $i = entry_index($vlt, $cat, $t1, $t2);

    if ($i >= 0){
      $recfields = explode ("\t", $vlt[$i], $nbfields);
      $decfields = svdecrypt($pf, $recfields[$nbfields-1]);
      if ($decfields[0] == $preamble){
        // decryption suceeded
        $encfields = $decfields;
        if ($decrmode == "decrypt"){
          // passphrase is ok, show decrypted entry
          $pgtitle = "Decrypt Entry";
          $mode = "modify";
          include "$template/entry.php";
        }
        elseif ($decrmode == "delete"){
          // passphrase is ok, delete entry with index $i
          delete_entry($vlt, $i, $cats);
          $entrydeleted = 1;
          include "$template/decryptform.php";
        }
        elseif ($decrmode == "edit"){
          // passphrase is ok, fill in form default values
          $pgtitle = "Decrypt Entry";
          $mode = "modify";
          include "$template/entryform.php";
        }
        else{
          $errormsg[] = "<p><span class='warning'>Internal Error: wrong mode.";
        }
      }
      else{
        // decryption failed
        $pwdmsg = 'Wrong passphrase!';
        include "$template/decryptform.php";
      }
    }
    else{
      $errormsg[] =  "Internal Error: Could not find an entry to decrypt.";
    }
  }
  else{
    // the entry has just been saved - offer possibility to decrypt it right away
    include "$template/decryptform.php";
  }
}


// *** Bulk decrypt entries
elseif(isset($_POST['bulkdecrypt'])){
  $i=0;
  $count = 0;
  $entries = array();
  while ($i < count($vlt)){
    if (strlen($vlt[$i])>10){  # ignore empty lines
      $recfields = explode ("\t", $vlt[$i], $nbfields);
      $decfields = svdecrypt($_POST['pf'], $recfields[$nbfields-1]);
      if ($decfields[0] == $preamble){
        $entries[] = array('recfields' => $recfields, 'decfields' => $decfields);
        $count++;
      }
    }
    $i++;
  }
  $infomsg[] = "$count of ".count($vlt)." entries decrypted.";
  include "$template/entries.php";
}


// *** Show form to create a new entry
elseif(isset($_GET['new'])){
  $pgtitle = "Create a New Entry";
  $cat = $_GET['cat'];
  $t1 = "";
  $t2 = "";
  $encfields = array();
  $mode = "";
  include "$template/entryform.php";
}

// *** Browse for existing entries
elseif(isset($_GET['cat']) or isset($_GET['all']) or isset($_POST['filter'])){
  $records = array();
  foreach ($vlt as $record){
    $recfields = explode ("\t", $record, $nbfields);
    if (   (isset($_GET['all']))
        or (isset($_GET['cat'])     and $_GET['cat'] == $recfields[0])
        or (isset($_POST['filter']) and strlen($_POST['filter'])>1 and stripos($record, $_POST['filter']) !== false ) 
        ){
      array_push($records, array('cat'=>$recfields[0],'t1'=>$recfields[1],'t2'=>$recfields[2],'mdate'=>$recfields[3]));
    }
  }
  $defcat = $_GET['cat'];
  include "$template/main.php";
}

// *** Show admin screen
elseif(isset($_GET['tools'])){
  include "$template/tools.php";
}

else{
  $records = array();
  $defcat = $_GET['cat'];
  include "$template/main.php";
}


/* -------------------------------------------------------------------------- */
/* -------------------------------------------------------------------------- */

function svencrypt($pf, $p0, $p1, $p2, $p3, $p8, $p9, $note)
// concatenates p0..note and encrypts it with $pf
{
  global $cipher;

  $data = strip_conttags($p0)."\n".strip_conttags($p1)."\n".strip_conttags($p2)."\n".strip_conttags($p3)."\n\n\n\n\n".strip_conttags($p8)."\n".strip_conttags($p9)."\n".strip_conttags($note);

  /* Open module, and create IV */
  $td = mcrypt_module_open($cipher, '', 'ecb', '');
  $key = substr(md5($pf), 0, mcrypt_enc_get_key_size($td));
  $iv_size = mcrypt_enc_get_iv_size($td);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

  /* Initialize encryption handle */
  if (mcrypt_generic_init($td, $key, $iv) != -1) {

    /* Encrypt data */
    $c_t = mcrypt_generic($td, $data);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
  }
  return urlencode($c_t);
}

/* -------------------------------------------------------------------------- */

function svdecrypt($pf, $data)
// decrypts data and returns an array with p0..note 
{
  global $cipher;
  global $nbencfields;
  
  $td = mcrypt_module_open($cipher, '', 'ecb', '');
  $key = substr(md5($pf), 0, mcrypt_enc_get_key_size($td));
  $iv_size = mcrypt_enc_get_iv_size($td);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

  /* Initialize encryption handle */
  if (mcrypt_generic_init($td, $key, $iv) != -1) {

    /* Reinitialize buffers for decryption */
    mcrypt_generic_init($td, $key, $iv);
    $p_t = mdecrypt_generic($td, urldecode($data));

    /* Clean up */
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
  }
  $p_t = rtrim($p_t);
  return  explode ("\n", rtrim($p_t, "\0"), $nbencfields+1);
}

/* -------------------------------------------------------------------------- */
/* -------------------------------------------------------------------------- */

function svdecodeableentry($pf, $data)
// returns ture if the entry can be sucessfully decoded with the passphrase
{
  global $preamble;
  $decfields = svdecrypt($pf, $data);
  return ($decfields[0] == $preamble);
}

/* -------------------------------------------------------------------------- */

function svcountdecodeableentries($pf, $category)
// counts how many entries can be decoded with the passphrase.
// if category is set, then only the decodable entries of the category are counted
// if category is empty, all decodable entries are counted
{
  global $vlt, $nbfields;
  $count = 0;
  foreach ($vlt as $record){
    $recfields = explode ("\t", $record, $nbfields);
    if (($category=="" or $category==$recfields[0]) and svdecodeableentry($pf, $recfields[$nbfields-1])) {$count++;}
  }
  return $count;
}

/* -------------------------------------------------------------------------- */

function svcountcatentries($category)
// counts the entries in the specified category
{
  global $vlt, $nbfields;
  $count = 0;
  foreach ($vlt as $record){
    $recfields = explode ("\t", $record, $nbfields);
    if ($category==$recfields[0]) {$count++;}
  }
  return $count;
}

/* -------------------------------------------------------------------------- */
/* -------------------------------------------------------------------------- */

function delete_entry(&$vlt, $i, &$cats)
// Delete entry with index $i. The vault ($vlt) and category ($cats) arrays are updated. The vault array is saved to the file.
{
  global $vaultdir, $vaultfile;
  
  array_splice ($vlt, $i, 1);
  file_put_contents("$vaultdir/$vaultfile", implode("\n", $vlt));
  $cats = categories($vlt);
}

/* -------------------------------------------------------------------------- */

function entry_index($vlt, $cat, $tit1, $tit2)
// Returns the index of the entry specified by category-title1-title2.
// If no matching entry was found, -1 is returned.
{
  $pattern = "$cat\t$tit1\t$tit2";
  $i = 0;
  while ($i < count($vlt) and strpos( $vlt[$i], $pattern)!==0){
    $i++;
  }
  
  if ($i < count($vlt)){
    return $i;
  }
  else{
    return -1;
  }
}

/* -------------------------------------------------------------------------- */
/* *** Forms *** */
/* -------------------------------------------------------------------------- */



/* -------------------------------------------------------------------------- */
/* -------------------------------------------------------------------------- */

function show_entry_title($cat, $t1, $t2)
{
  print "<table class='entry'>";
  print "<tr><td>Category:</td><td>$cat</td></tr>";
  print "<tr><td>Title:</td><td>$t1</td></tr>";
  print "<tr><td>Subtitle:</td><td>$t2</td></tr>";
  print "</table>";
}

/* -------------------------------------------------------------------------- */

function show_entry_body($decfields)
{
  global $nbencfields;
  print "<table class='encrbox'>";
  print "<tr><td>URL:</td><td>"      .print_url($decfields[2])."</td></tr>";
  print "<tr><td>Login:</td><td>"    .$decfields[1]."</td></tr>";
  print "<tr><td>Password:</td><td>" .$decfields[3]."</td></tr>";
  if(strlen($decfields[8]) > 0){
    print "<tr><td>".$decfields[8].":</td><td>" .$decfields[9]."</td></tr>";
  }
  print "<tr><td>Note:</td><td><pre>".$decfields[$nbencfields]."</pre></td></tr>";
  print "</table>";
  print "</p>";
}

/* -------------------------------------------------------------------------- */
/* -------------------------------------------------------------------------- */

function categories ($vault)
// returns an array of categories in the $vault
// precondition: $vault must be lexically ordered
{
  $cats = array();
  foreach($vault as $record){
    $recfields = explode ("\t", $record);
    if (count($cats)==0 or $cats[count($cats)-1]!=$recfields[0]){
      if (strlen($recfields[0])>0){array_push($cats, $recfields[0]);}
    }
  }
  return $cats;
}
/* -------------------------------------------------------------------------- */

function print_url ($string)
// checks, if the string is a URL. If yes, a html link is returned. Otherwise the $sting is returned.
{
  $pos = strpos($string, "://");
  if ($pos===false){
    return $string;
  }
  else{
    return "<a href='$string' target='_blank'>$string</a>";
  }
}

/* -------------------------------------------------------------------------- */

function strip_titletags($string)
{
  return (strtr($string, "<>&\\'\"", "......"));
}

function strip_conttags($string)
{
  return (htmlspecialchars ( $string));
}

/* -------------------------------------------------------------------------- */
/* -------------------------------------------------------------------------- */

echo "<div class='footer'>v".$version_num."<hr></div>";

?>
