<div class='logo'><a href='index.php'><img src='img/logo.png' alt='simplevault logo'/></a></div>

<form action='index.php' method='post'>
<div class='topbar'>
  <div class='leftblock'>
    <span>
    <a href='index.php'><b>Home</b></a> &nbsp;  &nbsp; 
    <a href='index.php?all'>all</a> &nbsp;  &nbsp; 
    <input type='text' name='filter' value='' size ='7' id='inpfield' />
    <input type='image' src='img/go-arr.png' name='image'  title='run filter' />
    </span>
  </div>
  <div class='rightblock'><span><a href='?tools'>Tools</a></span></div>
</div>
<div class='catbar'>
  <span>Categories: &nbsp; 
    <?php foreach ($cats as $currcat){ ?>
      <a href='?cat=<?php echo $currcat; ?>'><?php echo $currcat; ?></a> <?php echo " (".svcountcatentries($currcat).")"; ?> &nbsp; 
    <?php } ?>
  </span>
</div>
</form>

<?php foreach($errormsg as $msg){ ?>
<p><span class='warning'><?php echo $msg ?></span></p>
<?php } ?>

<?php foreach($infomsg as $msg){ ?>
<p><span class='info'><?php echo $msg ?></span></p>
<?php } ?>

