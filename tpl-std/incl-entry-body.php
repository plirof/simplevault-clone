<table class='encrbox'>
<tr><td>URL:</td><td>       <?php echo print_url($decfields[2]) ?></td></tr>
<tr><td>Login:</td><td>     <?php echo $decfields[1]  ?></td></tr>
<tr><td>Password:</td><td>  <?php echo $decfields[3]  ?></td></tr>
<?php  if(strlen($decfields[8]) > 0){ ?>
    <tr><td><?php echo $decfields[8] ?>:</td><td><?php echo $decfields[9] ?></td></tr>
<?php  } ?>
<tr><td>Note:</td><td><pre><?php echo $decfields[$nbencfields] ?></pre></td></tr>
</table>
