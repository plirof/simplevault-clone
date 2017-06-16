<?php
/**
* OSOLCaptcha Plugin for Joomla 1.5 ver 1.0.2 MOD 9b (option to show only numbers ,added &nbsp )
* @version $Id: osolcaptcha.php $
* @package: OSOLCaptcha 
* ===================================================
* @author
* Name: Sreekanth Dayanand, www.outsource-online.net (modified by Trister)
* Email: joomla@outsource-online.net
* Url: http://www.outsource-online.net
* ===================================================
* @copyright (C) 2010 Sreekanth Dayanand, Outsource Online (www.outsource-online.net). All rights reserved.
* @license see http://www.gnu.org/licenses/gpl-2.0.html  GNU/GPL.
* You can use, redistribute this file and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation.
*/




/*class plgSystemOSOLCaptcha //extends JPlugin
{

*/
		$bgColorOSOL = "#000000";
		$textColorOSOL = "#FFFFFF";
		$length=5 ; // length of CAPTCHA
		$imageFunction ='Plane';
		$osolTableWidth='40%';
		$global_totalCaptchas=$_GET["instanceNo"];

		if($_GET["showCaptcha"]==true) display();
		
	function jon_debug_filewrite($debug_text){ //john debug 
		$debug_mode=true;
		if($debug_mode)
			{
					$myFile = "plgSystemOSOLCaptcha_DEBUGXXXXX.txt"; 
					$fh = fopen($myFile, 'a') or die("can't open file");
					//$stringData = "plgSystemOSOLCaptcha_DEBUG : $debug_text\n CSS path =".file_get_contents('/'.'osolCaptcha/captchaStyle.css');
					//$stringData = $stringData.$tmp_debug_text."/nQUERY new user stiings : ".$queryInsertNewUserSetting;
					fwrite($fh, $stringData);
					fclose($fh);
			}
	} //function jon_debug_filewrite(){

	
    function display($code="hello from display")
		{
			global $imageFunction;
			//$imageFunction = $imageFunction;
			//$imageFunction = ((!method_exists($this,$imageFunction)))?'create_imageAdv':$imageFunction;
		    //echo $this->params->get('imageFunction');exit;
			 
		   //$imageFunction();
		   create_imagePlane($code);
		   exit;
		

		return true;
	}
	

			
	function setColors()
	{
			global $bgColorOSOL,$textColorOSOL;
			$bgColorOSOL  = $bgColorOSOL;
			$textColorOSOL  = $textColorOSOL;
	}
	

	function get_random_string(){
		//$this->jon_debug_filewrite("ccc");
	
		// ################ Random keystring (taken from create_imageADV)  JON
		$random_string='';
		//$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz";
		$allowed_symbols = "23456789abcdeghkmnpqsuvxyz";
		
		//global $this->$length ; // length of string
		
		while(true){
				
				for($i=0;$i<$this->length;$i++){
					$random_string.=$allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
				}
				if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $random_string)) break;
			} //while(true){
		
		jon_debug_filewrite("get_randomString".$random_string);

		return $random_string;
		
		// ################ END Random keystring (taken from create_imageADV)  JON	

	}  //function make_random_string(){

	
	// generates distorted letters ,this is a revised version of a method used in kcaptcha
	#http://www.phpclasses.org/browse/package/3193.html
		
	# Copyright by Kruglov Sergei, 2006, 2007, 2008
	# www.captcha.ru, www.kruglov.ru
	
	# System requirements: PHP 4.0.6+ w/ GD
	
	// generates plain letters
	function create_imagePlane($security_code="hello from create iamge pane")
	{
		
		global $textColorOSOL,$bgColorOSOL,$textColorOSOL;
		$bgColorOSOL = "#010010";
		$textColorOSOL = "#FFFFFF";



		//$security_code="hell2sfdsfsfs";

		$width = 120+strlen($security_code)*5;//100;
		$height = 40;//20;
		$image = imagecreate($width, $height);  
		//setColors();
		$foreground_color = HexToRGB($textColorOSOL) ;//array(255,255,255);//array(180, 180, 180);//array(255,255,255);//
		$background_color = HexToRGB($bgColorOSOL) ;
		//We are making three colors, white, black and gray
		$white = imagecolorallocate ($image, $foreground_color[0],$foreground_color[1],$foreground_color[2]);//255, 255, 255);
		$black = imagecolorallocate ($image,$background_color[0],$background_color[1],$background_color[2]);//44,127,7);// imagecolorallocate ($image, 0, 0, 0);
		$grey  = imagecolorallocate ($image, 204, 204, 204);
		
		//Make the background black 
		imagefill($image, 0, 0, $black); 
		imagestring($image, 3, 30, 3, $security_code, $white);
		$size = 10;
		$ly = (int)(2.4 * $size);
		$x = 20;
		for($i=0;$i<strlen($security_code);$i++)
		{
			
			$angle = rand(-45,45);
			$y        = intval(rand((int)($size * 1.5), (int)($ly - ($size / 7))));
			
			@imagettftext($image, $size, $angle, $x + (int)($size / 15), $y, $white, '/'.'osolCaptcha/adlibBT.TTF', $security_code[$i]);
			$x += ($size *2);
		}
		//imageline($image, 0, $height/2, $width, $height/2, $grey); 
		//imageline($image, $width/2, 0, $width/2, $height, $grey); 
		header('Content-type: image/png');
		imagepng($image);
		//imagedestroy($image);
	}	


	//declare the system events
   //THIS creates the HTML table :
		function GetCapthcaHTML($vertical = false)
		{
		global $global_totalCaptchas,$osolTableWidth;
		$global_totalCaptchas=$_GET["instanceNo"];
		
			//JPlugin::loadLanguage( 'plg_system_osolcaptcha', JPATH_ADMINISTRATOR );
			if(!isset($global_totalCaptchas))
			{
				$global_totalCaptchas = 1;
			}
			#JHTML::_('behavior.tooltip');


$path_of_image="\"osolcaptcha.php?showCaptcha=True&instanceNo=".$global_totalCaptchas."\"";
//			$path_of_image="\"osolcaptcha.php?showCaptcha=True&instanceNo=".$global_totalCaptchas."\"";

echo "DEBUG :global_totalCaptchas=$global_totalCaptchas  <br>path_of_image=$path_of_image ";

			//$global_totalCaptchas++;
			return (
				
				"

<img src=$path_of_image ><BR>
	

	AAAAAAAAAAAAAA
	
	<img id=\"captchaCode".$global_totalCaptchas."\" src=\"".''."index.php?showCaptcha=True&instanceNo=".$global_totalCaptchas."\" alt=\"Captcha plugin for Joomla from Outsource Online\" > 
	<br>
	<img id=\"captchaCode".$global_totalCaptchas."\" src=$path_of_image alt=\"Captcha plugin for Joomla from Outsource Online\" > 
");
		}



		/*
			Usage
			<?php 
				//set the argument below to true if you need to show vertically( 3 cells one below the other)
				JFactory::getApplication()->triggerEvent('onShowOSOLCaptcha', array(false)); 
			?>
			*/
		function onShowOSOLCaptcha($isVertical)
		{
			
			echo $this->GetCapthcaHTML($isVertical);
		}
		
		function HexToRGB($hex) {
			$hex = ereg_replace("#", "", $hex);
			$color = array();
			
			if(strlen($hex) == 3) {
				$color['r'] = hexdec(substr($hex, 0, 1) . $r);
				$color['g'] = hexdec(substr($hex, 1, 1) . $g);
				$color['b'] = hexdec(substr($hex, 2, 1) . $b);
			}
			else if(strlen($hex) == 6) {
				$color['r'] = hexdec(substr($hex, 0, 2));
				$color['g'] = hexdec(substr($hex, 2, 2));
				$color['b'] = hexdec(substr($hex, 4, 2));
			}
			//echo "AAAAAAAAAAAAAAA ";print_r($color);
			return array_values($color);
		}
	
		function RGBToHex($r, $g, $b) {
			$hex = "#";
			$hex.= dechex($r);
			$hex.= dechex($g);
			$hex.= dechex($b);
			
			return $hex;
		}

/*
}
*/

echo "<h1>TEST : ".GetCapthcaHTML() ."</h1>";//.display();//.create_imagePlane("z");