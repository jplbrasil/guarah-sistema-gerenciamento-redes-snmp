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

print "<CENTER><B>Tela de Usuários x Redes</B></CENTER>\n";

print "<BR>\n";

print "<FORM ACTION=\"tela_usuarios_redes.php\" METHOD=POST>\n";

//Se nao foi pressionado o botao Pesquisar, a tela permite cadastro
if(!isset($PESQUISAR))
{
	if(!isset($login))
		$login="";
	if(!isset($id_rede))
		$id_rede="";

	print "<TABLE BORDER=0>\n";
		print "<TR>\n";
			print "<TD><B>Usuário</B></TD>\n";
			print "<TD>\n";
				print "<SELECT NAME=\"login\">\n";
				$ctr_sis=new controle_sistema();
				$ctr_sis->pesquisar_usuario("usu_login","LIKE","%","usu_login");
				while($ctr_sis->registro->proximo())
					print "<OPTION VALUE=\"".$ctr_sis->registro->valor_campo("usu_login")."\">".$ctr_sis->registro->valor_campo("usu_nome")."</OPTION>\n";
				print "</SELECT>\n";
			print "</TD>\n";
		print "</TR>\n";

		print "<TR>\n";
			print "<TD><B>Rede</B></TD>\n";
			print "<TD>\n";
				print "<SELECT NAME=\"id_rede\">\n";
				$ctr_ope=new controle_operacional();
				$ctr_ope->pesquisar_rede("red_id",">","0","red_id");
				while($ctr_ope->registro->proximo())
					print "<OPTION VALUE=\"".$ctr_ope->registro->valor_campo("red_id")."\">".$ctr_ope->registro->valor_campo("red_nome")."</OPTION>\n";
				print "</SELECT>\n";
			print "</TD>\n";
		print "</TR>\n";

		print "<TR>\n";
			print "<TD COLSPAN=2><BR><INPUT TYPE=\"SUBMIT\" NAME=\"RELACIONAR\" VALUE=\"Relacionar\"></TD>\n";
		print "</TR>\n";
		
	print "</TABLE>\n";

	print "<BR>\n";

	if(isset($RELACIONAR)) {
		$ctr_ope=new controle_operacional();

		if($ctr_ope->relacionar_usuario_rede($login,$id_rede))
			print "OK. Usuário '$login' e rede '$id_rede' relacionados com sucesso.\n";
		else
			print "Erro. Usuário '$login' e rede '$id_rede' não relacionados.\n";
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
				print "<OPTION VALUE=\"usu_login\">Login</OPTION>\n";
				print "<OPTION VALUE=\"red_id\">Rede</OPTION>\n";
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
			print "<TD><B>Login</B></TD>\n";
			print "<TD><B>Id da Rede</B></TD>\n";
			print "<TD><B>Nome da Rede</B></TD>\n";
			print "<TD><B>Acão</B></TD>\n";
		print "</TR>\n";
	$vazio=1;
	$ctr_ope=new controle_operacional();
	$ctr_ope->pesquisar_usuario_rede($campo,$operador,$criterio,"usu_login");
	
	$cor=$COR_LIN2;
	while($ctr_ope->registro->proximo()) {
		if($cor==$COR_LIN1)
			$cor=$COR_LIN2;
		else	
			$cor=$COR_LIN1;
		print "<TR BGCOLOR=\"$cor\">\n";
			print "<TD>".$ctr_ope->registro->valor_campo("usu_login")."</TD>\n";
			print "<TD>".$ctr_ope->registro->valor_campo("red_id")."</TD>\n";
			print "<TD>".$ctr_ope->registro->valor_campo("red_nome")."</TD>\n";
			print "<TD>\n";
				print "<FORM ACTION=\"tela_usuarios_redes.php\" METHOD=\"POST\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"login\" VALUE=\"".$ctr_ope->registro->valor_campo("usu_login")."\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"id_rede\" VALUE=\"".$ctr_ope->registro->valor_campo("red_id")."\">\n";
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
	if($ctr_ope->cancelar_usuario_rede($login,$id_rede))
		print "OK. Relacionamento do usuário '$login' com a rede '$id_rede' excluído com sucesso.\n";
	else
		print "Erro. Relacionamento do usuário '$login' com a rede '$id_rede' não excluído.\n";
}


include_once("rodape.php");
?>
