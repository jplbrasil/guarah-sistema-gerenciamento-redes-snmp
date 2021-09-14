<?php

/*
o arquivo cabecalho.php ja' inclui:
	menu.php
	texto.php
	controle_sistema.php
*/	

$nao_verificar_rede=1;

include_once("cabecalho.php");
include_once("classes/controle_operacional.php");

print "<CENTER><B>Tela de Redes</B></CENTER>\n";

print "<BR>\n";

print "<FORM ACTION=\"tela_redes.php\" METHOD=POST>\n";

if(isset($LIMPAR)) {
	$id="";
	$nome="";
	$ip_inicial="";
	$ip_final="";
	$comunidade_senha="";
}

//Se nao foi pressionado o botao Pesquisar, a tela permite cadastro
if(!isset($PESQUISAR))
{
	if(!isset($id))
		$id="";
	if(!isset($nome))
		$nome="";
	if(!isset($ip_inicial))
		$ip_inicial="";
	if(!isset($ip_final))
		$ip_final="";
	if(!isset($comunidade_snmp))
		$comunidade_snmp="";
		
	print "<INPUT TYPE=\"HIDDEN\" NAME=\"id\" VALUE=\"$id\">\n";

	print "<TABLE BORDER=0>\n";
		print "<TR>\n";
			print "<TD><B>Nome</B></TD>\n";
			print "<TD><INPUT TYPE=\"TEXT\" NAME=\"nome\" VALUE=\"$nome\" SIZE=20></TD>\n";
		print "</TR>\n";

		print "<TR>\n";
			print "<TD><B>IP Inicial</B></TD>\n";
			print "<TD><INPUT TYPE=\"TEXT\" NAME=\"ip_inicial\" VALUE=\"$ip_inicial\" SIZE=15></TD>\n";
		print "</TR>\n";
		
		print "<TR>\n";
			print "<TD><B>IP Final</B></TD>\n";
			print "<TD><INPUT TYPE=\"TEXT\" NAME=\"ip_final\" VALUE=\"$ip_final\" SIZE=15></TD>\n";
		print "</TR>\n";

		print "<TR>\n";
			print "<TD><B>Comunidade SNMP</B></TD>\n";
			print "<TD><INPUT TYPE=\"TEXT\" NAME=\"comunidade_snmp\" VALUE=\"$comunidade_snmp\" SIZE=40></TD>\n";
		print "</TR>\n";

		print "<TR>\n";
		if((!isset($ALTERAR))&&(!isset($SALVAR)))
			print "<TD COLSPAN=2><BR><INPUT TYPE=\"SUBMIT\" NAME=\"CADASTRAR\" VALUE=\"Cadastrar\"></TD>\n";
		else if(!isset($SALVAR))
			print "<TD COLSPAN=2><BR><INPUT TYPE=\"SUBMIT\" NAME=\"SALVAR\" VALUE=\"Salvar\"></TD>\n";
		else	
			print "<TD COLSPAN=2><BR><INPUT TYPE=\"SUBMIT\" NAME=\"LIMPAR\" VALUE=\"Limpar\"></TD>\n";
		print "</TR>\n";
	print "</TABLE>\n";

	print "<BR>\n";

	if(isset($CADASTRAR)) {
		$ctr_ope=new controle_operacional();
		if($ctr_ope->cadastrar_rede($nome,$ip_inicial,$ip_final,$comunidade_snmp))
			print "OK. Rede cadastrada com sucesso.\n";
		else
			print "Erro. Rede não cadastrada.\n";
	}
	else if(isset($SALVAR)) {
		$ctr_ope=new controle_operacional();
		if($ctr_ope->alterar_rede($id,$nome,$ip_inicial,$ip_final,$comunidade_snmp))
			print "OK. Dados da rede '$id' alterados com sucesso.\n";
		else
			print "Erro ao alterar os dados da rede '$id'.\n";
	}
	else
		print "<BR>\n";
	
	print "<HR>\n";
}	

//Formulario de pesquisa
print "<TABLE BORDER=0>\n";
	print "<TR>\n";
		print "<TD>\n";
			print "<SELECT NAME=\"campo\">\n";
				print "<OPTION VALUE=\"red_nome\">Nome</OPTION>\n";
				print "<OPTION VALUE=\"red_ip_inicial\">IP Inicial</OPTION>\n";
				print "<OPTION VALUE=\"red_ip_final\">IP Final</OPTION>\n";
				print "<OPTION VALUE=\"red_comunidade\">Comunidade SNMP</OPTION>\n";
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
			print "<TD><B>Id</B></TD>\n";
			print "<TD><B>Nome</B></TD>\n";
			print "<TD><B>Ip Inicial</B></TD>\n";
			print "<TD><B>Ip Final</B></TD>\n";
			print "<TD><B>Comunidade SNMP</B></TD>\n";
			print "<TD><B>Acão</B></TD>\n";
		print "</TR>\n";
	$vazio=1;
	$ctr_ope=new controle_operacional();
	$ctr_ope->pesquisar_rede($campo,$operador,$criterio,"red_id");
	$cor=$COR_LIN2;
	while($ctr_ope->registro->proximo()) {
		if($cor==$COR_LIN1)
			$cor=$COR_LIN2;
		else	
			$cor=$COR_LIN1;
		print "<TR BGCOLOR=\"$cor\">\n";
			print "<TD>".$ctr_ope->registro->valor_campo("red_id")."</TD>\n";
			print "<TD>".$ctr_ope->registro->valor_campo("red_nome")."</TD>\n";
			print "<TD>".$ctr_ope->registro->valor_campo("red_ip_inicial")."</TD>\n";
			print "<TD>".$ctr_ope->registro->valor_campo("red_ip_final")."</TD>\n";
			print "<TD>".$ctr_ope->registro->valor_campo("red_comunidade")."</TD>\n";
			print "<TD>\n";
				print "<FORM ACTION=\"tela_redes.php\" METHOD=\"POST\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"id\" VALUE=\"".$ctr_ope->registro->valor['red_id']."\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"nome\" VALUE=\"".$ctr_ope->registro->valor['red_nome']."\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"ip_inicial\" VALUE=\"".$ctr_ope->registro->valor['red_ip_inicial']."\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"ip_final\" VALUE=\"".$ctr_ope->registro->valor['red_ip_final']."\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"comunidade_snmp\" VALUE=\"".$ctr_ope->registro->valor['red_comunidade']."\">\n";
				print "<INPUT TYPE=\"SUBMIT\" NAME=\"ALTERAR\" VALUE=\"Alterar\">\n";
				print "<INPUT TYPE=\"SUBMIT\" NAME=\"EXCLUIR\" VALUE=\"Excluir\">\n";
				print "</FORM>\n";
			print "</TD>\n";
		print "</TR>\n";
		$vazio=0;
	}
	print "</TABLE>\n";
		if($vazio) {
		print "<BR>\n";
		print "Não há registros que satisfaçam ao critério pesquisado.\n";
	}
	
}

if(isset($EXCLUIR)) {
	$ctr_ope=new controle_operacional();
	if($ctr_ope->excluir_rede($id))
		print "OK. Rede '$id' excluída com sucesso.\n";
	else
		print "Erro. Rede '$id' não excluída.\n";
}



include_once("rodape.php");
?>
