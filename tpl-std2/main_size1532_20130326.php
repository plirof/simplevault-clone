<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include "$template/incl-head.php"; ?>
</head>

<body  onload="document.forms.enterpf.pf.focus()">

<?php include "$template/incl-titlebar.php"; ?>

<h1>Browse</h1>
<table class='entry'>
<?php foreach ($records as $record){?>
  <tr><td><?php echo $record['cat']?></td><td><?php echo $record['t1']?></td><td><?php echo $record['t2']?></td><td><?php echo date($dateformat,$record['mdate']) ?></td><td><a href='?dec=1&amp;cat=<?php echo $record['cat']; ?>&amp;t1=<?php echo $record['t1']; ?>&amp;t2=<?php echo $record['t2']; ?>'><img src='img/decrypt.png'  title='decrypt' alt='decrypt'/></a></td><td><a href='?edt=1&amp;cat=<?php echo $record['cat']; ?>&amp;t1=<?php echo $record['t1']; ?>&amp;t2=<?php echo $record['t2']; ?>'><img src='img/edit.png'  title='edit' alt='edit'/></a></td><td><a href='?del=1&amp;cat=<?php echo $record['cat']; ?>&amp;t1=<?php echo $record['t1']; ?>&amp;t2=<?php echo $record['t2']; ?>'><img src='img/del.png'  title='delete' alt='delete'/></a></td></tr>
<?php }?>
</table>
<p><a href='?new=1&amp;cat=<?php echo $defcat ?>'><img class='button' src='img/add.png' title='add new entry' alt='add new entry' /> add new entry</a>
</p>

<?php if(count($records)==0){ ?>
  <div class='footer'><span>Password manager powered by <a href='http://simplevault.sourceforge.net'>SimpleVault</a></span></div>
<?php } ?>

</body>
</html>
