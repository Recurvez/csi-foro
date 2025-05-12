<?php

require ('global.php');
$utilidad_fonts = 1;
include "Templates/Head.php";
include "Templates/Alertas.php";
include "Templates/Nav.php"; 

$font_map_url = "$url/utilities/utilidad-fonts/"; /*Vul hier de link in van da map waar de fonts instaan.*/
 ?>
<div class="container">
<div id="content" style="max-width:928px; margin:0 auto;">
<script type="text/javascript">
function fontName(font_id) {
var message = document.getElementById('message').value;
if(message!='Vul hier je tekst in.') {
var newmessage = message.replace(/ /g, "%20");
var newmessage = message.replace("?", "%3F");
document.getElementById('scan_result').innerHTML = '<img src="<?php echo $font_map_url ?>' + font_id + '/' + message + '.gif" />';
document.getElementById('link').value = '<?php echo $font_map_url ?>' + font_id + '/' + newmessage + '.gif';
}else{
document.getElementById('scan_result').innerHTML = '<br /><br /><center><h3>Rellene el texto que desea utilizar.</h3></center>';
document.forms['text_form'].elements['message'].focus();
document.getElementById('message').value = '';
}
document.getElementById('font_naam').value = font_id;
}
function change() {
var message = document.getElementById('message').value;
var newmessage = message.replace(/ /g, "%20");
var newmessage = message.replace("?", "%3F");
var font = document.getElementById('font_naam').value;
if(newmessage=='') {
document.getElementById('message').value = 'Introduzca el texto aquí.';
document.getElementById('link').value = 'Aquí está el enlace.';
document.getElementById('scan_result').innerHTML = '<br /><br /><center><h3>Haga clic en un tipo de letra, escriba aparecerá el texto y la fuente!</h3></center>';
}else if(font!='') {
document.getElementById('link').value = '<?php echo $font_map_url ?>' + font + '/' + newmessage + '.gif';
document.getElementById('scan_result').innerHTML = '<img src="<?php echo $font_map_url ?>' + font + '/' + message + '.gif" />';
}else{
document.getElementById('scan_result').innerHTML = '<br /><br /><center><h3>Seleccione la fuente que desea utilizar.</h3></center>';
}
}
function Save()
{
$temp = document.getElementById('link').value;
window.location = $temp
}
</script>

<div style="width:918px; float:left;">
<div class="box_top box_top_918"></div>
<div class="box_center box_center_918">

	<div id="scan_result" style="width:896px; _width:906px; color:#666666; padding:5px; overflow:auto; height:125px; _height:135px; vertical-align:middle;" align="center"><br /><br /><center><h3>Haga clic en un tipo de letra, escriba aparecerá el texto y la fuente!</h3></center></div>

</div>
<div class="box_bottom box_bottom_918"></div>
</div>

<div style="width:918px; float:left;">
<div class="box_top box_top_918"></div>
<div class="box_center box_center_918">
<form target="_parent" id="text_form" method="post">
<input type="text" id="message" name="message" value="Introduzca el texto aquí." style="width:861px; _width:906px; padding:5px; padding-left:40px; font-size:20px; background-image:url(https://habbu.com.ve/font/basic/habbu%20font.gifs); background-color:#F3F3F3; background-position:10px center; background-repeat:no-repeat; border:none; margin:0; box-shadow: 0px 5px 5px #F8F8F8;" onDblClick="this.value='';" onChange="change();" onblur="change();" />
<input type="text" id="link" name="link" disabled value="Aquí está el enlace." style="width:859px; _width:904px; padding:5px; padding-left:40px; font-size:10px; background-image:url(https://habbu.com.ve/font/basic/habbu%20font.gifs); background-color:#FFF; color:#999; background-position:10px center; background-repeat:no-repeat; border:none; margin:0; margin-top:5px;" />
<input type="hidden" name="font" id="font_naam" class="scan_form" value="" onChange="change();" onblur="change();" />
</form>
</div>
<div class="box_bottom box_bottom_918"></div>
</div>

<div style="width:924px; float:left; margin-left:-6px;">

<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('volter');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">Volter</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>volter/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('accessoires');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">accessoires</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>accessoires/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('agenda');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">agenda</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>agenda/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('arctic');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">arctic</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>arctic/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('badkamer');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">badkamer</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>badkamer/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('basic');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">basic</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>basic/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('battle');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">battle</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>battle/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('battleball');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">battleball</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>battleball/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('battlebanzai');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">battlebanzai</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>battlebanzai/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('bensalem');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">bensalem</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>bensalem/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('bensalem_sea');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">bensalem_sea</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>bensalem_sea/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('beta');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">beta</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>beta/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('beta_groot');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">beta_groot</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>beta_groot/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('beta_klein');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">beta_klein</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>beta_klein/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('bling');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">bling</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>bling/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('botjes');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">botjes</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>botjes/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('font1');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">font2</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>font1/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('font2');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">font2</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>font2/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('bots');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">bots</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>bots/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('buttons');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">buttons</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>buttons/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('candy');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">candy</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>candy/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('chinees');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">chinees</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>chinees/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('dieren');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">dieren</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>dieren/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('explore');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">explore</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>explore/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('exploreklein');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">exploreklein</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>exploreklein/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('faq');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">faq</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>faq/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('festival');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">festival</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>festival/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('goldentemple');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">goldentemple</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>goldentemple/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('habbo');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">habbo</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>habbo/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('habbo_groot');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">habbo groot</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>habbo_groot/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('habbo_klein');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">habbo klein</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>habbo_klein/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('habbowood');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">habbowood</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>habbowood/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('halloween');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">halloween</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>halloween/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('halloween_2');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">halloween 2</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>halloween_2/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('halloween_3r');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">halloween 3</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>halloween_3/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('hc');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">hc</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>hc/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('hc_goldr');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">hc gold</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>hc_gold/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('hma');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">hma</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>hma/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('iced');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">iced</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>iced/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('kleden');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">kleden</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>kleden/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('lido');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">lido</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>lido/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('neonblauw');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">neonblauw</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>neonblauw/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('neongroen');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">neongroen</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>neongroen/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('neonroze');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">neonroze</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>neonroze/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('plastic');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">plastic</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>plastic/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('plastic_1');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">plastic 1</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>plastic_1/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('recycle');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">recycle</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>recycle/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('red');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">red</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>red/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('simpel');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">simpel</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>simpel/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('teleport');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">teleport</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>teleport/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('trofee');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">trofee</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>trofee/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('uitverkoop');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">uitverkoop</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>uitverkoop/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('valentijn');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">valentijn</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>valentijn/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('vlaggen');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">vlaggen</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>vlaggen/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('voetbal');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">voetbal</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>voetbal/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('wall');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">wall</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>wall/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('zilver');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">zilver</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>zilver/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>
<div style="width:148px; float:left; margin-left:6px;">
<div class="box_top box_top_148"></div>
<div class="box_center box_center_148" style="cursor:pointer;" onClick="fontName('zomer');scroll(0,0);">
	<div class="top_148 top_bg_10" style="text-align:center;">zomer</div>
	<div style="width:136px; height:80px; background:url(<?php echo $font_map_url ?>zomer/abc.gif) no-repeat center center;"></div>
</div>
<div class="box_bottom box_bottom_148"></div>
</div>

</div>
<div style="width:100%; text-align:center; padding:30px; float:left;"></div></div>
</div>

</body>
</html>

<?php

include "Templates/Footer.php"; 

?>