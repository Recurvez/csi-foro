<?php

require ('global.php');

include "Templates/Head.php";
include "Templates/Alertas.php";
include "Templates/Nav.php"; 
?>

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="utilities/utilidad-grupos/js/general.js"></script>
		<link rel="stylesheet" href="utilities/utilidad-grupos/css/style.css"/>
		
		<div id="cont_placagrupo">
			<div class="prevplaca_box">
				<img id="placafinal">
			</div>
			<div class="cont_btx base">
				<div id="contg">
					<div id="pgrupo">
						<div class="flecha izq" onClick="cambiarBase(0)"></div>
						<div class="flecha der" onClick="cambiarBase(1)"></div>
						<div id="baseimg" class="imgprev"></div>
					</div>
					<div id="contgrupocolores">
						<div id="bascolor-01" class="boxcolor" onClick="colorBase('01')" style="background-Color:#FFD500;"></div>
						<div id="bascolor-02" class="boxcolor" onClick="colorBase('02')" style="background-Color:#EB7500;"></div>
						<div id="bascolor-03" class="boxcolor" onClick="colorBase('03')" style="background-Color:#83DD00;"></div>
						<div id="bascolor-04" class="boxcolor" onClick="colorBase('04')" style="background-Color:#579900;"></div>
						<div id="bascolor-05" class="boxcolor" onClick="colorBase('05')" style="background-Color:#4FC0FA;"></div>
						<div id="bascolor-06" class="boxcolor" onClick="colorBase('06')" style="background-Color:#006ECE;"></div>
						<div id="bascolor-07" class="boxcolor" onClick="colorBase('07')" style="background-Color:#FF97E2;"></div>
						<div id="bascolor-08" class="boxcolor" onClick="colorBase('08')" style="background-Color:#F233BE;"></div>
						<div id="bascolor-09" class="boxcolor" onClick="colorBase('09')" style="background-Color:#FF2C2C;"></div>
						<div id="bascolor-10" class="boxcolor" onClick="colorBase('10')" style="background-Color:#AE0909;"></div>
						<div id="bascolor-11" class="boxcolor" onClick="colorBase('11')" style="background-Color:#FFFFFF;"></div>
						<div id="bascolor-12" class="boxcolor" onClick="colorBase('12')" style="background-Color:#BFBFBF;"></div>
						<div id="bascolor-13" class="boxcolor" onClick="colorBase('13')" style="background-Color:#363636;"></div>
						<div id="bascolor-14" class="boxcolor" onClick="colorBase('14')" style="background-Color:#FAE6AB;"></div>
						<div id="bascolor-15" class="boxcolor" onClick="colorBase('15')" style="background-Color:#967540;"></div>
						<div id="bascolor-16" class="boxcolor" onClick="colorBase('16')" style="background-Color:#C1E9FF;"></div>
						<div id="bascolor-17" class="boxcolor" onClick="colorBase('17')" style="background-Color:#FFF064;"></div>
						<div id="bascolor-18" class="boxcolor" onClick="colorBase('18')" style="background-Color:#A9FF7C;"></div>
					</div>
				</div>
			</div>

			<div class="cont_btx comp">
				<div id="contg">
					<div id="pgrupo">
						<div class="flecha izq" onClick="cambiarObjeto(0,0)"></div>
						<div class="flecha der" onClick="cambiarObjeto(1,0)"></div>
						<div id="accimg-0" class="imgprev obj" obj="0"></div>
					</div>
					<div id="contgrupopos">
						<div id="pos-0-0" class="boxpos deselect" onClick="cambiarPos(0, 0)"></div>
						<div id="pos-0-1" class="boxpos deselect" onClick="cambiarPos(0, 1)"></div>
						<div id="pos-0-2" class="boxpos deselect" onClick="cambiarPos(0, 2)"></div>
						<div id="pos-0-3" class="boxpos deselect" onClick="cambiarPos(0, 3)"></div>
						<div id="pos-0-4" class="boxpos deselect" onClick="cambiarPos(0, 4)"></div>
						<div id="pos-0-5" class="boxpos deselect" onClick="cambiarPos(0, 5)"></div>
						<div id="pos-0-6" class="boxpos deselect" onClick="cambiarPos(0, 6)"></div>
						<div id="pos-0-7" class="boxpos deselect" onClick="cambiarPos(0, 7)"></div>
						<div id="pos-0-8" class="boxpos deselect" onClick="cambiarPos(0, 8)"></div>
					</div>
					<div id="contgrupocolores">
						<div id="bcolor-0-01" class="boxcolor" onClick="cambiarColor(0, '01')" style="background-Color:#FFD500;"></div>
						<div id="bcolor-0-02" class="boxcolor" onClick="cambiarColor(0, '02')" style="background-Color:#EB7500;"></div>
						<div id="bcolor-0-03" class="boxcolor" onClick="cambiarColor(0, '03')" style="background-Color:#83DD00;"></div>
						<div id="bcolor-0-04" class="boxcolor" onClick="cambiarColor(0, '04')" style="background-Color:#579900;"></div>
						<div id="bcolor-0-05" class="boxcolor" onClick="cambiarColor(0, '05')" style="background-Color:#4FC0FA;"></div>
						<div id="bcolor-0-06" class="boxcolor" onClick="cambiarColor(0, '06')" style="background-Color:#006ECE;"></div>
						<div id="bcolor-0-07" class="boxcolor" onClick="cambiarColor(0, '07')" style="background-Color:#FF97E2;"></div>
						<div id="bcolor-0-08" class="boxcolor" onClick="cambiarColor(0, '08')" style="background-Color:#F233BE;"></div>
						<div id="bcolor-0-09" class="boxcolor" onClick="cambiarColor(0, '09')" style="background-Color:#FF2C2C;"></div>
						<div id="bcolor-0-10" class="boxcolor" onClick="cambiarColor(0, '10')" style="background-Color:#AE0909;"></div>
						<div id="bcolor-0-11" class="boxcolor" onClick="cambiarColor(0, '11')" style="background-Color:#FFFFFF;"></div>
						<div id="bcolor-0-12" class="boxcolor" onClick="cambiarColor(0, '12')" style="background-Color:#BFBFBF;"></div>
						<div id="bcolor-0-13" class="boxcolor" onClick="cambiarColor(0, '13')" style="background-Color:#363636;"></div>
						<div id="bcolor-0-14" class="boxcolor" onClick="cambiarColor(0, '14')" style="background-Color:#FAE6AB;"></div>
						<div id="bcolor-0-15" class="boxcolor" onClick="cambiarColor(0, '15')" style="background-Color:#967540;"></div>
						<div id="bcolor-0-16" class="boxcolor" onClick="cambiarColor(0, '16')" style="background-Color:#C1E9FF;"></div>
						<div id="bcolor-0-17" class="boxcolor" onClick="cambiarColor(0, '17')" style="background-Color:#FFF064;"></div>
						<div id="bcolor-0-18" class="boxcolor" onClick="cambiarColor(0, '18')" style="background-Color:#A9FF7C;"></div>
					</div>
				</div>
			</div>

			<div class="cont_btx comp">
				<div id="contg">
					<div id="pgrupo">
						<div class="flecha izq" onClick="cambiarObjeto(0,1)"></div>
						<div class="flecha der" onClick="cambiarObjeto(1,1)"></div>
						<div id="accimg-1" class="imgprev obj" obj="1"></div>
					</div>
					<div id="contgrupopos">
						<div id="pos-1-0" class="boxpos deselect" onClick="cambiarPos(1, 0)"></div>
						<div id="pos-1-1" class="boxpos deselect" onClick="cambiarPos(1, 1)"></div>
						<div id="pos-1-2" class="boxpos deselect" onClick="cambiarPos(1, 2)"></div>
						<div id="pos-1-3" class="boxpos deselect" onClick="cambiarPos(1, 3)"></div>
						<div id="pos-1-4" class="boxpos deselect" onClick="cambiarPos(1, 4)"></div>
						<div id="pos-1-5" class="boxpos deselect" onClick="cambiarPos(1, 5)"></div>
						<div id="pos-1-6" class="boxpos deselect" onClick="cambiarPos(1, 6)"></div>
						<div id="pos-1-7" class="boxpos deselect" onClick="cambiarPos(1, 7)"></div>
						<div id="pos-1-8" class="boxpos deselect" onClick="cambiarPos(1, 8)"></div>
					</div>
					<div id="contgrupocolores">
						<div id="bcolor-1-01" class="boxcolor" onClick="cambiarColor(1, '01')" style="background-Color:#FFD500;"></div>
						<div id="bcolor-1-02" class="boxcolor" onClick="cambiarColor(1, '02')" style="background-Color:#EB7500;"></div>
						<div id="bcolor-1-03" class="boxcolor" onClick="cambiarColor(1, '03')" style="background-Color:#83DD00;"></div>
						<div id="bcolor-1-04" class="boxcolor" onClick="cambiarColor(1, '04')" style="background-Color:#579900;"></div>
						<div id="bcolor-1-05" class="boxcolor" onClick="cambiarColor(1, '05')" style="background-Color:#4FC0FA;"></div>
						<div id="bcolor-1-06" class="boxcolor" onClick="cambiarColor(1, '06')" style="background-Color:#006ECE;"></div>
						<div id="bcolor-1-07" class="boxcolor" onClick="cambiarColor(1, '07')" style="background-Color:#FF97E2;"></div>
						<div id="bcolor-1-08" class="boxcolor" onClick="cambiarColor(1, '08')" style="background-Color:#F233BE;"></div>
						<div id="bcolor-1-09" class="boxcolor" onClick="cambiarColor(1, '09')" style="background-Color:#FF2C2C;"></div>
						<div id="bcolor-1-10" class="boxcolor" onClick="cambiarColor(1, '10')" style="background-Color:#AE0909;"></div>
						<div id="bcolor-1-11" class="boxcolor" onClick="cambiarColor(1, '11')" style="background-Color:#FFFFFF;"></div>
						<div id="bcolor-1-12" class="boxcolor" onClick="cambiarColor(1, '12')" style="background-Color:#BFBFBF;"></div>
						<div id="bcolor-1-13" class="boxcolor" onClick="cambiarColor(1, '13')" style="background-Color:#363636;"></div>
						<div id="bcolor-1-14" class="boxcolor" onClick="cambiarColor(1, '14')" style="background-Color:#FAE6AB;"></div>
						<div id="bcolor-1-15" class="boxcolor" onClick="cambiarColor(1, '15')" style="background-Color:#967540;"></div>
						<div id="bcolor-1-16" class="boxcolor" onClick="cambiarColor(1, '16')" style="background-Color:#C1E9FF;"></div>
						<div id="bcolor-1-17" class="boxcolor" onClick="cambiarColor(1, '17')" style="background-Color:#FFF064;"></div>
						<div id="bcolor-1-18" class="boxcolor" onClick="cambiarColor(1, '18')" style="background-Color:#A9FF7C;"></div>
					</div>
				</div>
			</div>

			<div class="cont_btx comp">
				<div id="contg">
					<div id="pgrupo">
						<div class="flecha izq" onClick="cambiarObjeto(0,2)"></div>
						<div class="flecha der" onClick="cambiarObjeto(1,2)"></div>
						<div id="accimg-2" class="imgprev obj" obj="2"></div>
					</div>
					<div id="contgrupopos">
						<div id="pos-2-0" class="boxpos deselect" onClick="cambiarPos(2, 0)"></div>
						<div id="pos-2-1" class="boxpos deselect" onClick="cambiarPos(2, 1)"></div>
						<div id="pos-2-2" class="boxpos deselect" onClick="cambiarPos(2, 2)"></div>
						<div id="pos-2-3" class="boxpos deselect" onClick="cambiarPos(2, 3)"></div>
						<div id="pos-2-4" class="boxpos deselect" onClick="cambiarPos(2, 4)"></div>
						<div id="pos-2-5" class="boxpos deselect" onClick="cambiarPos(2, 5)"></div>
						<div id="pos-2-6" class="boxpos deselect" onClick="cambiarPos(2, 6)"></div>
						<div id="pos-2-7" class="boxpos deselect" onClick="cambiarPos(2, 7)"></div>
						<div id="pos-2-8" class="boxpos deselect" onClick="cambiarPos(2, 8)"></div>
					</div>
					<div id="contgrupocolores">
						<div id="bcolor-2-01" class="boxcolor" onClick="cambiarColor(2, '01')" style="background-Color:#FFD500;"></div>
						<div id="bcolor-2-02" class="boxcolor" onClick="cambiarColor(2, '02')" style="background-Color:#EB7500;"></div>
						<div id="bcolor-2-03" class="boxcolor" onClick="cambiarColor(2, '03')" style="background-Color:#83DD00;"></div>
						<div id="bcolor-2-04" class="boxcolor" onClick="cambiarColor(2, '04')" style="background-Color:#579900;"></div>
						<div id="bcolor-2-05" class="boxcolor" onClick="cambiarColor(2, '05')" style="background-Color:#4FC0FA;"></div>
						<div id="bcolor-2-06" class="boxcolor" onClick="cambiarColor(2, '06')" style="background-Color:#006ECE;"></div>
						<div id="bcolor-2-07" class="boxcolor" onClick="cambiarColor(2, '07')" style="background-Color:#FF97E2;"></div>
						<div id="bcolor-2-08" class="boxcolor" onClick="cambiarColor(2, '08')" style="background-Color:#F233BE;"></div>
						<div id="bcolor-2-09" class="boxcolor" onClick="cambiarColor(2, '09')" style="background-Color:#FF2C2C;"></div>
						<div id="bcolor-2-10" class="boxcolor" onClick="cambiarColor(2, '10')" style="background-Color:#AE0909;"></div>
						<div id="bcolor-2-11" class="boxcolor" onClick="cambiarColor(2, '11')" style="background-Color:#FFFFFF;"></div>
						<div id="bcolor-2-12" class="boxcolor" onClick="cambiarColor(2, '12')" style="background-Color:#BFBFBF;"></div>
						<div id="bcolor-2-13" class="boxcolor" onClick="cambiarColor(2, '13')" style="background-Color:#363636;"></div>
						<div id="bcolor-2-14" class="boxcolor" onClick="cambiarColor(2, '14')" style="background-Color:#FAE6AB;"></div>
						<div id="bcolor-2-15" class="boxcolor" onClick="cambiarColor(2, '15')" style="background-Color:#967540;"></div>
						<div id="bcolor-2-16" class="boxcolor" onClick="cambiarColor(2, '16')" style="background-Color:#C1E9FF;"></div>
						<div id="bcolor-2-17" class="boxcolor" onClick="cambiarColor(2, '17')" style="background-Color:#FFF064;"></div>
						<div id="bcolor-2-18" class="boxcolor" onClick="cambiarColor(2, '18')" style="background-Color:#A9FF7C;"></div>
					</div>
				</div>
			</div>

			<div class="cont_btx comp">
				<div id="contg">
					<div id="pgrupo">
						<div class="flecha izq" onClick="cambiarObjeto(0,3)"></div>
						<div class="flecha der" onClick="cambiarObjeto(1,3)"></div>
						<div id="accimg-3" class="imgprev obj" obj="3"></div>
					</div>
					<div id="contgrupopos">
						<div id="pos-3-0" class="boxpos deselect" onClick="cambiarPos(3, 0)"></div>
						<div id="pos-3-1" class="boxpos deselect" onClick="cambiarPos(3, 1)"></div>
						<div id="pos-3-2" class="boxpos deselect" onClick="cambiarPos(3, 2)"></div>
						<div id="pos-3-3" class="boxpos deselect" onClick="cambiarPos(3, 3)"></div>
						<div id="pos-3-4" class="boxpos deselect" onClick="cambiarPos(3, 4)"></div>
						<div id="pos-3-5" class="boxpos deselect" onClick="cambiarPos(3, 5)"></div>
						<div id="pos-3-6" class="boxpos deselect" onClick="cambiarPos(3, 6)"></div>
						<div id="pos-3-7" class="boxpos deselect" onClick="cambiarPos(3, 7)"></div>
						<div id="pos-3-8" class="boxpos deselect" onClick="cambiarPos(3, 8)"></div>
					</div>
					<div id="contgrupocolores">
						<div id="bcolor-3-01" class="boxcolor" onClick="cambiarColor(3, '01')" style="background-Color:#FFD500;"></div>
						<div id="bcolor-3-02" class="boxcolor" onClick="cambiarColor(3, '02')" style="background-Color:#EB7500;"></div>
						<div id="bcolor-3-03" class="boxcolor" onClick="cambiarColor(3, '03')" style="background-Color:#83DD00;"></div>
						<div id="bcolor-3-04" class="boxcolor" onClick="cambiarColor(3, '04')" style="background-Color:#579900;"></div>
						<div id="bcolor-3-05" class="boxcolor" onClick="cambiarColor(3, '05')" style="background-Color:#4FC0FA;"></div>
						<div id="bcolor-3-06" class="boxcolor" onClick="cambiarColor(3, '06')" style="background-Color:#006ECE;"></div>
						<div id="bcolor-3-07" class="boxcolor" onClick="cambiarColor(3, '07')" style="background-Color:#FF97E2;"></div>
						<div id="bcolor-3-08" class="boxcolor" onClick="cambiarColor(3, '08')" style="background-Color:#F233BE;"></div>
						<div id="bcolor-3-09" class="boxcolor" onClick="cambiarColor(3, '09')" style="background-Color:#FF2C2C;"></div>
						<div id="bcolor-3-10" class="boxcolor" onClick="cambiarColor(3, '10')" style="background-Color:#AE0909;"></div>
						<div id="bcolor-3-11" class="boxcolor" onClick="cambiarColor(3, '11')" style="background-Color:#FFFFFF;"></div>
						<div id="bcolor-3-12" class="boxcolor" onClick="cambiarColor(3, '12')" style="background-Color:#BFBFBF;"></div>
						<div id="bcolor-3-13" class="boxcolor" onClick="cambiarColor(3, '13')" style="background-Color:#363636;"></div>
						<div id="bcolor-3-14" class="boxcolor" onClick="cambiarColor(3, '14')" style="background-Color:#FAE6AB;"></div>
						<div id="bcolor-3-15" class="boxcolor" onClick="cambiarColor(3, '15')" style="background-Color:#967540;"></div>
						<div id="bcolor-3-16" class="boxcolor" onClick="cambiarColor(3, '16')" style="background-Color:#C1E9FF;"></div>
						<div id="bcolor-3-17" class="boxcolor" onClick="cambiarColor(3, '17')" style="background-Color:#FFF064;"></div>
						<div id="bcolor-3-18" class="boxcolor" onClick="cambiarColor(3, '18')" style="background-Color:#A9FF7C;"></div>
					</div>
				</div>
			</div>
			<div class="copy">Powered by Soyjoaquin.</div>
		</div>

<?php
include "Templates/Footer.php"; 

?>