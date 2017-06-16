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

		//if($_GET["showCaptcha"]==true) display();
		
	function jon_debug_filewrite($debug_text){ //john debug 
		$debug_mode=true;
		if($debug_mode)
			{
					$myFile = "xxxOSOLCaptcha_DEBUGXXXXX.txt"; 
					$fh = fopen($myFile, 'a') or die("can't open file");
					//$stringData = "plgSystemOSOLCaptcha_DEBUG : $debug_text\n CSS path =".file_get_contents('/'.'osolCaptcha/captchaStyle.css');
					$stringData = $stringData.$debug_text;
					fwrite($fh, $stringData);
					fclose($fh);
			}
	} //function jon_debug_filewrite(){

	
	// generates distorted letters ,this is a revised version of a method used in kcaptcha
	#http://www.phpclasses.org/browse/package/3193.html
		
	# Copyright by Kruglov Sergei, 2006, 2007, 2008
	# www.captcha.ru, www.kruglov.ru
	
	# System requirements: PHP 4.0.6+ w/ GD
	
	// generates plain letters
	function create_imagePlane($security_code="hello from create image plane !@$%^&$&#")
	{
		
		global $textColorOSOL,$bgColorOSOL,$textColorOSOL;
		$bgColorOSOL = "#010010";
		$textColorOSOL = "#FFFFFF";



		//$security_code="hell2sfdsfsfs";

		$width = 120+strlen($security_code)*20;//100;
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
		imagestring($image, 33, 30, 3, $security_code, $white);
		$size = 10;
		$ly = (int)(2.4 * $size);
		$x = 20;
		
		for($i=0;$i<strlen($security_code);$i++)
		{
			
			$angle = rand(-45,45);
			$y        = intval(rand((int)($size * 1.5), (int)($ly - ($size / 7))));
			
			
			
			
			jon_debug_filewrite("\n x=$x , ly=$ly angle=$angle ,y=$y ,");
			//array imagettftext  (  resource $image  ,  float $size  ,  float $angle  ,  int $x  ,  int $y  ,  int $color  ,  string $fontfile  ,  string $text  )
			//@imagettftext($image, $size, $angle, 100 , 50, $grey,'osolCaptcha/adlibBT.TTF', $security_code[$i]);
			@imagettftext($image, $size, $angle, $x+10 + (int)($size / 15), $y, $grey,'tpl-captcha/osolCaptcha/adlibBT.TTF', $security_code[$i]);
			///	@imagettftext($image, $size, $angle, $x + (int)($size / 15), $y, $white, '/'.'osolCaptcha/adlibBT.TTF', $security_code[$i]); //ORIG
			$x += ($size *2);
		}
		//imageline($image, 0, $height/2, $width, $height/2, $grey); 
		//imageline($image, $width/2, 0, $width/2, $height, $grey); 
		header('Content-type: image/png');
		imagepng($image);
		//imagedestroy($image);
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

if($_GET["showCaptcha"]==true)create_imagePlane();
//create_imagePlane();
?>