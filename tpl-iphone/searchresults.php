<?php
  // 2nd level: item titles
  $currcat = "";
  print "<ul title='Search Results' selected='true'>\n";
  if(count($records)==0){
    print "<li>no item matching '".$_POST['filter']."'</li>";
  }
  foreach ($records as $recfields){
    if($currcat != $recfields['cat']){ // new category has started
      print "<li class='group'>{$recfields['cat']}</li>\n";  // category title
      $currcat = $recfields['cat'];
    }
    $subtitle = "";
    if ($recfields['t2']){ $subtitle = " - ".$recfields['t2'];}
    print "  <li><a href='#".strtr($recfields['cat'].$recfields['t1'].$recfields['t2']," ","_")."'>{$recfields['t1']} $subtitle</a></li>\n";
  }
  print "</ul>";
?>

<?php
  // 3rd level: items
  foreach ($records as $recfields){
?>

<form id="<?php echo strtr($recfields['cat'].$recfields['t1'].$recfields['t2']," ","_"); ?>" title="Decrypt" class="panel" method="post" action="index.php">
  <h2><?php echo $recfields['cat']; ?></h2>
  <fieldset>
    <div class="row"><label>Title</label><p class="prow"><?php echo $recfields['t1']; ?></p></div>
    <div class="row"><label>Subtitle</label><p class="prow"><?php echo $recfields['t2']; ?></p></div>
  </fieldset>
  <h2>more</h2>
  <fieldset>
    <div class="row"><label>Password</label><input type="password" name="pf" value="" /></div>
  </fieldset>
  <input name='cat' type='hidden' value='<?php echo $recfields['cat']; ?>'/>
  <input name='t1'  type='hidden' value='<?php echo $recfields['t1']; ?>'/>
  <input name='t2'  type='hidden' value='<?php echo $recfields['t2']; ?>'/>
  <input type='submit' name='entrydecrypt' value='decrypt' />
</form>
<?php } ?>
