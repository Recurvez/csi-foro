<?php

$local_map = 'habboclub_nieuw';
$map = 'habboclub_nieuw';

$get_item = array(
	"0" => "+",
	"1" => "a",
	"2" => "b",
	"3" => "c",
	"4" => "d",
	"5" => "e",
	"6" => "f",
	"7" => "g",
	"8" => "h",
	"9" => "i",
	"10" => "j",
	"11" => "k",
	"12" => "l",
	"13" => "m",
	"14" => "n",
	"15" => "o",
	"16" => "p",
	"17" => "q",
	"18" => "r",
	"19" => "s",
	"20" => "t",
	"21" => "u",
	"22" => "v",
	"23" => "w",
	"24" => "x",
	"25" => "y",
	"26" => "z",
);

for($i = 0; $i < 26; $i++)
{
	
	$url = 'http://www.algemeenhabbo.nl/font/'.$map.'/'.$get_item[$i].'[].gif';
	if($get_item[$i] == '%20')
	{
		$name = '+';
	}
	else
	{
		$name = $get_item[$i];
	}
	$img = $local_map.'/'.$name.'.gif';
	file_put_contents($img, file_get_contents($url));
	
}

?>