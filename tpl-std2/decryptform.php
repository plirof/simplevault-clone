<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include "$template/incl-head.php"; ?>
</head>

<body>

<?php include "$template/incl-titlebar.php"; ?>

<h1><?php echo ucfirst($decrmode) ?> Entry</h1>

<?php include "$template/incl-entry-title.php"; ?>

<?php if($pwdmsg){ ?>
<p><span class='warning'><?php echo $pwdmsg ?></span></p>
<?php } ?>

<?php if($entrydeleted){ ?>
  <p><span class='info'>Entry <?php echo $t1."/".$t2 ?> deleted!</span> &nbsp; <a href='index.php'>Ok</a></p>
<?php }else{ ?>
  <form name='enterpf' action='index.php' method='post'  autocomplete='off'>
  <input name='cat' type='hidden' value='<?php echo $cat ?>'/>
  <input name='t1'  type='hidden' value='<?php echo $t1 ?>'/>
  <input name='t2'  type='hidden' value='<?php echo $t2 ?>'/>
  <p>
  Passphrase: <input name='pf' type='password' value='' size='20' maxlength='200'/> 
  <input type='submit' name='entry<?php echo $decrmode ?>' value='<?php echo $decrmode ?>' />
  </p>
  </form>
<?php } ?>

</body>
</html>
