<?php

/*
o arquivo cabecalho.php ja' inclui:
	menu.php
	texto.php
	controle_sistema.php
*/	

$nao_verificar_rede=1;

include_once("cabecalho.php");

print "<CENTER><B>Tela de Usuários</B></CENTER>\n";

print "<BR>\n";

print "<FORM ACTION=\"tela_usuarios.php\" METHOD=POST>\n";

if(isset($LIMPAR)) {
	$login="";
	$nome="";
	$email="";
}

//Se nao foi pressionado o botao Pesquisar, a tela permite cadastro
if(!isset($PESQUISAR))
{
	if(!isset($login))
		$login="";
	if(!isset($nome))
		$nome="";
	if(!isset($email))
		$email="";
		

	print "<TABLE BORDER=0>\n";
		print "<TR>\n";
			print "<TD><B>Login</B></TD>\n";
			print "<TD><INPUT TYPE=\"TEXT\" NAME=\"login\" VALUE=\"$login\" SIZE=20></TD>\n";
		print "</TR>\n";
		print "<TR>\n";
			print "<TD><B>Nome</B></TD>\n";
			print "<TD><INPUT TYPE=\"TEXT\" NAME=\"nome\" VALUE=\"$nome\" SIZE=50></TD>\n";
		print "</TR>\n";
		print "<TR>\n";
			print "<TD><B>Email</B></TD>\n";
			print "<TD><INPUT TYPE=\"TEXT\" NAME=\"email\" VALUE=\"$email\" SIZE=50></TD>\n";
		print "</TR>\n";

		if(isset($ALTERAR)) {
			print "<TR>\n";
				print "<TD><B>Senha</B></TD>\n";
				print "<TD><INPUT TYPE=\"PASSWORD\" NAME=\"senha\" SIZE=20></TD>\n";
			print "</TR>\n";
		}


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
		$ctr_sis=new controle_sistema();
		if($ctr_sis->cadastrar_usuario($login,$nome,$email)) {
			$senha=$ctr_sis->retornar_senha_usuario();
			print "OK. Usuário cadastrado com sucesso. Senha gerada: $senha\n";
		}
		else
			print "Erro. Usuário não cadastrado.\n";
	}
	else if(isset($SALVAR)) {
		$ctr_sis=new controle_sistema();
		if($ctr_sis->alterar_usuario($login,$nome,$email,$senha))
			print "OK. Dados do usuário '$login' alterados com sucesso.\n";
		else
			print "Erro ao alterar os dados do usuário '$login'.\n";
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
				print "<OPTION VALUE=\"usu_nome\">Nome</OPTION>\n";
				print "<OPTION VALUE=\"usu_email\">Email</OPTION>\n";
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
			print "<TD><B>Nome</B></TD>\n";
			print "<TD><B>Email</B></TD>\n";
			print "<TD><B>Acão</B></TD>\n";
		print "</TR>\n";
	$vazio=1;
	$ctr_sis=new controle_sistema();
	$ctr_sis->pesquisar_usuario($campo,$operador,$criterio,"usu_login");
	$cor=$COR_LIN2;
	while($ctr_sis->registro->proximo()) {
		if($cor==$COR_LIN1)
			$cor=$COR_LIN2;
		else	
			$cor=$COR_LIN1;
		print "<TR BGCOLOR=\"$cor\">\n";
			print "<TD>".$ctr_sis->registro->valor_campo("usu_login")."</TD>\n";
			print "<TD>".$ctr_sis->registro->valor_campo("usu_nome")."</TD>\n";
			print "<TD>".$ctr_sis->registro->valor_campo("usu_email")."</TD>\n";

			print "<TD>\n";
				print "<FORM ACTION=\"tela_usuarios.php\" METHOD=\"POST\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"login\" VALUE=\"".$ctr_sis->registro->valor['usu_login']."\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"nome\" VALUE=\"".$ctr_sis->registro->valor['usu_nome']."\">\n";
				print "<INPUT TYPE=\"HIDDEN\" NAME=\"email\" VALUE=\"".$ctr_sis->registro->valor['usu_email']."\">\n";
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
	$ctr_sis=new controle_sistema();
	if($ctr_sis->excluir_usuario($login))
		print "OK. Usuário '$login' excluído com sucesso.\n";
	else
		print "Erro. Usuário '$login' não excluído.\n";
}



include_once("rodape.php");
?>
