<table class='encrbox' border=1 bgcolor=<?php echo $text_bg_table_color; ?> >
<tr><td color=red >URL:</td><td>       <?php echo print_url($decfields[2]) ?></td></tr>
<tr><td>Login:
</td><td>
		<FONT COLOR="<?php echo $text_notes_color; ?>">
		<?php echo $decfields[1]  ?>
		</FONT>
</td></tr>
<tr><td>Password:
</td><td>  
	<FONT COLOR="<?php echo $text_ps_color; ?>">
		<?php echo $decfields[3]  ?>
	</FONT>
</td></tr>
<?php  if(strlen($decfields[8]) > 0){ ?>
    <tr><td>
		<?php echo $decfields[8] ?>:
	</td><td>
		<?php echo $decfields[9] ?>
	</td></tr>
<?php  } ?>
<tr><td>Note:
</td><td>
	<FONT COLOR="<?php echo $text_notes_color; ?>">
		<pre><?php echo $decfields[$nbencfields] ?></pre>
	</FONT>
</td></tr>
</table>

Note!:If you can't see any text try selecting the text area with the mouse.