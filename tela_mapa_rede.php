<?php

/*
o arquivo cabecalho.php ja' inclui:
	menu.php
	texto.php
	controle_sistema.php
*/	

include_once("cabecalho.php");
include_once("classes/controle_operacional.php");

$vetor=array();
$locais=array();
$hosts=array();
$ctr_ope=new controle_operacional();

//recebe um vetor cujas chaves sao os hosts e os valores sao suas localizacoes fisicas
$vetor=$ctr_ope->retornar_mapa_rede_atual();

while(list($host,$local)=each($vetor)) {
	if(($host<>"")&&($local<>"")) {
		$locais[$local]=$local;
		$hosts[$local][]=$host;
	}
}

sort($locais);

while(list($cont1,$local)=each($locais)) {
	print "<TABLE BORDER=1>\n";
	print "<TR><TD WIDTH=400><B>Local: $local</B></TD>\n";
	print "</TR>\n";
	sort($hosts[$local]);
	while(list($cont2,$host)=each($hosts[$local]))
		print "<TR><TD>$host</TD></TR>\n";
	print "</TABLE>\n";
	print "<BR>\n";
}

include_once("rodape.php");
	
?>
