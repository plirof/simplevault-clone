<?php if (isset($_POST['filter'])){include "$template/searchresults.php"; exit(); } // use another template for serach results ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
               "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MobileSimpleVault</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<style type="text/css" media="screen">@import "tpl-iphone/tpl.css";</style>
<style type="text/css" media="screen">@import "tpl-iphone/iui/iui.css";</style>
<script type="application/x-javascript" src="tpl-iphone/iui/iui.js"></script>
<meta name="robots" content="noarchive,nofollow" />
<!-- script type="text/javascript" src="sv.js"></script -->  
</head>
<body style="overflow:hidden;">

<div class='toolbar'>
<h1 id='pageTitle'></h1>
<a id='backButton' class='button' href='#'></a>
<a class='button' href='#searchForm'>Search</a>
</div>

<ul id="home" title="SimpleVault" selected="true">
  <!-- li><a href="index.php?test">Test</a></li -->
  <?php foreach ($cats as $currcat){ // 1st level: categories ?>
    <li><a href='#<?php echo strtr($currcat, " ", "_"); ?>'><?php echo $currcat; ?></a></li>
  <?php } ?>
</ul>

<?php
  // 2nd level: item titles
  $currcat = "";
  foreach ($vlt as $record){
    $recfields = explode ("\t", $record, $nbfields);
    if($currcat != $recfields[0]){ // new category has started
      if($currcat != ""){print "</ul>\n";} 
      print "<ul id='".strtr($recfields[0], " ", "_")."' title='{$recfields[0]}'>\n";
      $currcat = $recfields[0];
    }
    $subtitle = "";
    if ($recfields[2]){ $subtitle = " - ".$recfields[2];}
    print "  <li><a href='#".strtr($recfields[0].$recfields[1].$recfields[2]," ","_")."'>{$recfields[1]} $subtitle</a></li>\n";
  }
  print "</ul>";
?>

<?php
  // 3rd level: items
  foreach ($vlt as $record){
    $recfields = explode ("\t", $record, $nbfields);
?>

<form id="<?php echo strtr($recfields[0].$recfields[1].$recfields[2]," ","_"); ?>" title="Decrypt" class="panel" method="post" action="index.php">
  <h2>Category: <?php echo $recfields[0]; ?></h2>
  <fieldset>
    <div class="row"><label>Title</label><p class="prow"><?php echo $recfields[1]; ?></p></div>
    <div class="row"><label>Subtitle</label><p class="prow"><?php echo $recfields[2]; ?></p></div>
  </fieldset>
  <h2>decrypt</h2>
  <fieldset>
    <div class="row"><label>Password</label><input type="password" name="pf" value="" /></div>
  </fieldset>
  <input name='cat' type='hidden' value='<?php echo $recfields[0]; ?>'/>
  <input name='t1'  type='hidden' value='<?php echo $recfields[1]; ?>'/>
  <input name='t2'  type='hidden' value='<?php echo $recfields[2]; ?>'/>
  <input type='submit' name='entrydecrypt' value='decrypt' />
  <!-- a class="whiteButton" type="submit" name='entrydecrypt'>Decrypt</a -->
</form>
<?php } ?>


<form id="searchForm" class="dialog" method="post" action="index.php">
    <fieldset>
        <h1>Music Search</h1>
        <a class="button leftButton" type="cancel">Cancel</a>
        <a class="button blueButton" type="submit">Search</a>
        
        <label>Search:</label>
        <input type='text' name='filter' value='' />
        <!-- input type='submit' name='filterbutton' value='Search' / -->
    </fieldset>
</form>

</body>
</html>
