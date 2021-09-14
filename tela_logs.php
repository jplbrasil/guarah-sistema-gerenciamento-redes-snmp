<?php

/*
o arquivo cabecalho.php ja' inclui:
	menu.php
	texto.php
	controle_sistema.php
*/	

$nao_verificar_rede=1;

include_once("cabecalho.php");
include_once("classes/data.php");

print "<CENTER><B>Log do Sistema</B></CENTER>\n";

print "<BR>\n";

print "<FORM ACTION=\"tela_logs.php\" METHOD=POST>\n";

//Formulario de pesquisa
print "<TABLE BORDER=0>\n";
	print "<TR>\n";
		print "<TD>\n";
			print "<SELECT NAME=\"campo\">\n";
				print "<OPTION VALUE=\"log_data\">Data</OPTION>\n";
				print "<OPTION VALUE=\"log_hora\">Hora</OPTION>\n";
				print "<OPTION VALUE=\"usu_login\">Login</OPTION>\n";
				print "<OPTION VALUE=\"log_ocorrencia\">Ocorrência</OPTION>\n";
			print "</SELECT>\n";
		print "</TD>\n";
		print "<TD>\n";
			print "<SELECT NAME=\"operador\">\n";
				print "<OPTION VALUE=\"like\">Contém</OPTION>\n";
				print "<OPTION VALUE=\"=\">Igual a</OPTION>\n";
				print "<OPTION VALUE=\"<>\">Diferente de</OPTION>\n";
				print "<OPTION VALUE=\">\">Maior que</OPTION>\n";
				print "<OPTION VALUE=\"<\">Menor que</OPTION>\n";
				print "<OPTION VALUE=\">=\">Maior ou igual a</OPTION>\n";
				print "<OPTION VALUE=\"<=\">Menor ou igual a</OPTION>\n";
			print "</SELECT>\n";
		print "</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" NAME=\"criterio\"></TD>\n";
		print "<TD><INPUT TYPE=\"SUBMIT\" NAME=\"PESQUISAR\" VALUE=\"Pesquisar\"></TD>\n";
	print "</TR>\n";
print "</TABLE>\n";

print "</FORM>\n";

print "<BR>\n";

//Resultado da pesquisa
if(isset($PESQUISAR)) {
	print "<TABLE BORDER=1>\n";
		print "<TR BGCOLOR=\"$COR_CAB\">\n";
			print "<TD><B>Data</B></TD>\n";
			print "<TD><B>Hora</B></TD>\n";
			print "<TD><B>Login</B></TD>\n";
			print "<TD><B>Ocorrência</B></TD>\n";
		print "</TR>\n";
	$vazio=1;
	$data=new data();
	$ctr_sis=new controle_sistema();
	$ctr_sis->pesquisar_log($campo,$operador,$criterio,"log_data,log_hora");
	$cor=$COR_LIN2;
	while($ctr_sis->registro->proximo()) {
		if($cor==$COR_LIN1)
			$cor=$COR_LIN2;
		else	
			$cor=$COR_LIN1;

		$data->atribuir($ctr_sis->registro->valor_campo("log_data"));
		$data->iso_para_brasil();
			
		print "<TR BGCOLOR=\"$cor\">\n";
			print "<TD>".$data->retornar()."</TD>\n";
			print "<TD>".$ctr_sis->registro->valor_campo("log_hora")."</TD>\n";
			print "<TD>".$ctr_sis->registro->valor_campo("usu_login")."</TD>\n";
			print "<TD>".$ctr_sis->registro->valor_campo("log_ocorrencia")."</TD>\n";
		print "</TR>\n";
		$vazio=0;
	}
	print "</TABLE>\n";
		if($vazio) {
		print "<BR>\n";
		print "Não há registros que satisfaçam ao critério pesquisado.\n";
	}
	
}

include_once("rodape.php");
?>
