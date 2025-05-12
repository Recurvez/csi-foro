<?php

/*
###############################################################################################
#					 _   _                     _           _           _ _   				  #
#					| |_| |__  _   _ _ __   __| | ___ _ __| |__   ___ | | |_ 				  #
#					| __| '_ \| | | | '_ \ / _` |/ _ \ '__| '_ \ / _ \| | __|				  #
#					| |_| | | | |_| | | | | (_| |  __/ |  | |_) | (_) | | |_ 				  #
# 					 \__|_| |_|\__,_|_| |_|\__,_|\___|_|  |_.__/ \___/|_|\__|				  #
#                                                                                          	  #
#                                                             							 	  #
#         						© ThunderBold ~ Made by Tonny       				  		  #
#   				This cms is made for habbo related retro hotels/sites.    				  #
#   			  Please, don't claim this Control Management System as your    			  #
#                      					own made cms.                          				  #
#                                                             								  #
###############################################################################################
*/

$error_tekst = 'Error';
$default_tekst = 'generator';
$default_map = 'volter';

$t = filterText();
$m = getMap();
$r = getSpace($m);

$l_count = strlen($t);
$img_w = 0;

$y_r = 21;
$w_r = 5; // default space
$g_r = 1;

for($i = 0; $i < $l_count; $i++)
{
	$l = substr($t, $i, 1);
	if (preg_match("/[a-zA-Z ]/", $l)) 
	{
		($l == ' ' ? $l = '+' : $l);
		
		$l_img = imagecreatefromgif($m.'/'.$l.'.gif'); 
		
		$l_img_w = getWidth($l_img); $l_img_h = getHeight($l_img);
		$y = $y_r - $l_img_h;
		$img_w = $img_w + $l_img_w + $r;
	}
	else
	{
		$img_w = $img_w + $w_r;
	}
}

$img_w = $img_w - $r + $g_r;

$img = imagecreate($img_w, $l_img_h + 1);
$bg = imagecolorallocatealpha($img, 0, 255, 0, 0);
imagecolortransparent($img, $bg);

$o_img_h = $l_img_h;
$x = 0;

for ($i = 0; $i < $l_count; $i++)
{
	$l = substr($t, $i, 1);
	if (preg_match("/[a-zA-Z ]/", $l)) 
	{
		($l == ' ' ? $l = '+' : $l);
		
		$l_img = imagecreatefromgif($m.'/'.$l.'.gif'); 
		$l_img_w = getWidth($l_img); $l_img_h = getHeight($l_img);
		
		$y = $o_img_h - $l_img_h;
		imagecopy($img, $l_img, $x, $y, 0, 0, $l_img_w, $l_img_h); 
		$x = $x + $l_img_w + $r;
	}
	else
	{
		$x = $x + $w_r;
	}
}

getResult($img);

function filterText()
{
	global $error_tekst, $default_tekst;
	
	$characters = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");

	(isset($_GET['tekst']) ? $tekst = $_GET['tekst'] : $tekst = $default_tekst);
	(empty($_GET['tekst']) ? $tekst = $default_tekst : $tekst =  $_GET['tekst']);
	(preg_match('/^[a-zA-Z0-9]+$/i', $tekst) == 0 ? $tekst = str_replace(array_keys($characters), "", $tekst) : $tekst);
	(preg_match('/^[a-zA-Z0-9 ]+$/i', $tekst) == 0 ? $tekst = $error_tekst : $tekst);
	(strlen($tekst) == 1 ? $tekst = $error_tekst : $tekst);
	(strlen(str_replace(" ", "", $tekst)) == 1 ? $tekst = $error_tekst : $tekst);
	
	return strtolower($tekst);
}

function getMap()
{
	global $default_map;
	
	(isset($_GET['map']) ? $map = $_GET['map'] : $map = $default_map);
	(empty($_GET['map']) ? $map = $default_map : $map = $_GET['map']);
	(preg_match('/^[a-zA-Z0-9._]+$/i', $map) ? $map : $map = $default_map);
	(!is_dir($map) ? $map = $default_map : $map);
	
	return $map;
}

function getSpace($map)
{
	$space = array( "habbo_groot" => "-10", "goldentemple" => "-1", "badkamer" => "-1", "battleball" => "-1", "beta" => "-1", "zilver" => "-1", "faq" => "-1", "botjes" => "0", "font1" => "-1", "font2" => "-1", "kleden" => "-1", "chinees" => "-1", "plastic_1" => "1", "agenda" => "-1", "festival" => "-1", "voetbal" => "-1", "uitverkoop" => "-1", "hc" => "-1", "halloween" => "-1", "halloween_2" => "-1", "halloween_3" => "-1", "habbowood" => "-1", "iced" => "-1", "buttons" => "-1", "lido" => "-1", "valentijn" => "-1", "habbo" => "-5", "dieren" => "-1", "plastic" => "0", "recycle" => "-7", "wall" => "0", "simpel" => "-1", "habbo_klein" => "-1", "explore" => "-1", "exploreklein" => "-1", "zomer" => "0", "red" => "-1", "teleport" => "-2", "trofee" => "-1", "accessoires" => "-1", "arctic" => "-1", "basic" => "-1", "battle" => "-1", "battlebanzai" => "-4", "beta_groot" => "-1", "bensalem_sea" => "-1", "bensalem" => "-1", "beta_klein" => "-1", "bling" => "-1", "bots" => "-1", "candy" => "-1", "checkin" => "-1", "volter" => "-5", "hma" => "-3", "hc_gold" => "-1", "vlaggen" => "-2", "marktplaats" => "0" , "neonblauw" => "0", "neonroze" => "0", "neongroen" => "0");
	
	return $space[$map];
}

function getWidth($l_img)
{
	return ImageSX($l_img);
}

function getHeight($l_img)
{
	return ImageSY($l_img);
}

function getResult($image)
{
	header('Content-type: image/gif');
	return imagegif($image);
}

?>