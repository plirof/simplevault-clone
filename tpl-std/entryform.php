<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include "$template/incl-head.php"; ?>
</head>

<body  onload="document.forms.enterpf.pf.focus()">

<?php include "$template/incl-titlebar.php"; ?>

<h1><?php echo $pgtitle ?></h1>

<form action='<?php echo $myfname ?>' method='post' onsubmit='return check_pf()' autocomplete='off'>
<div>
<input name='defcat' type='hidden' value='<?php echo $cat ?>'/>
<input name='deft1'  type='hidden' value='<?php echo $t1 ?>'/>
<input name='deft2'  type='hidden' value='<?php echo $t2 ?>'/>
<input name='mode'   type='hidden' value='<?php echo $mode ?>'/>

<table class='entry'>
  <tr><td>Category:</td><td>
    <table class='raw'><tr><td>existing:</td><td><select name='catdl' size='1'><option></option>
    <?php
      foreach ($cats as $currcat){
      print "<option".($cat==$currcat ? " selected":"").">$currcat</option>";
      }
    ?>
    </select></td></tr>
    <tr><td>or new:</td><td><input name='cat' type='text' value='' size='20' maxlength='200'/></td></tr>
    </table>
  </td></tr>
  <tr><td>Title:   </td><td><input name='t1' type='text' value='<?php echo $t1 ?>' size='20' maxlength='200'/></td></tr>
  <tr><td>Subtitle:</td><td><input name='t2' type='text' value='<?php echo $t2 ?>' size='20' maxlength='200'/></td></tr>
</table>

<p>encrypted:</p>
<table class='encrbox'>
  <tr><td>URL:</td><td>
  <input name='newp2'    type='text' value='<?php echo $encfields[2] ?>' size='20' maxlength='200'/>
  </td></tr>
  <tr><td>Login:</td><td>
  <input name='newp1'    type='text' value='<?php echo $encfields[1] ?>' size='20' maxlength='200'/>
  </td></tr>
  <tr><td>Password:</td><td>
  <input name='newp3'    type='text' value='<?php echo $encfields[3] ?>' size='20' maxlength='200'/>
  </td></tr>
  <tr><td> 
  <input name='newp8'    type='text' value='<?php echo $encfields[8] ?>' size='6' maxlength='30'/>
  :</td><td>
  <input name='newp9'    type='text' value='<?php echo $encfields[9] ?>' size='20' maxlength='200'/>
  </td></tr>
  <tr><td>Note:</td><td>
  <textarea name='newnote' cols='40' rows='6'><?php echo $encfields[$nbencfields] ?></textarea>
  </td></tr>
</table>


<p>
Passphrase: <input name='pf' type='password' value='' size='20' maxlength='200'/>
</p>
<p>
<input type='submit' name='entrysave' value='save entry' />
</p>
</div>
</form>

</body>
</html>
