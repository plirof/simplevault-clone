
<div class="panel" title="Item decrypted">
  <h2><?php echo $_POST['cat']; ?></h2>
  <fieldset>
    <div class="row"><label>Title</label><p class="prow"><?php echo $_POST['t1']; ?></p></div>
    <div class="row"><label>Subtitle</label><p class="prow"><?php echo $_POST['t2']; ?></p></div>
  </fieldset>
  <fieldset>
    <div class="row"><label>URL</label><p class="prow"><?php echo print_url($decfields[2]) ?></p></div>
    <div class="row"><label>Login</label><p class="prow"><?php echo $decfields[1]  ?></p></div>
    <div class="row"><label>Password</label><p class="prow"><?php echo $decfields[3]  ?></p></div>
    <?php  if(strlen($decfields[8]) > 0){ ?>
      <div class="row"><label><?php echo $decfields[8] ?></label><p class="prow"><?php echo $decfields[9] ?></p></div>
        <tr><td>:</td><td></td></tr>
    <?php  } ?>
    <?php  if(strlen($decfields[$nbencfields]) > 0){ ?>
      <p class="ptext"><pre><?php echo $decfields[$nbencfields] ?></pre></p>
    <?php  } ?>
  </fieldset>
</div>

