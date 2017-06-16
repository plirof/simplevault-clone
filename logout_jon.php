<?PHP
// this is my logout page from phpSecurePages. put it on root

$logout = true;
$cfgProgDir = '../../phpSecurePages/phpSecurePages/';
include($cfgProgDir . "secure.php");

 /* <A HREF="<?php echo "logout_jon.php"; ?>" target="_main" >  */
?>

<a href="index.php" >return to index page </a>

<script type="text/javascript">
<!--
window.location = "index.php"
//-->
</script>