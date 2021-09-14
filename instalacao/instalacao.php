<?php

if(isset($CONFIRMAR)) {
	session_start();
	$_SESSION['BDSERV']=$BDSERV;
	$_SESSION['BDNOME']=$BDNOME;
	$_SESSION['BDUSER']=$BDUSER;
	$_SESSION['BDSENHA']=$BDSENHA;
}	

include_once("../classes/texto.php");
include_once("../classes/tabela.php");
include_once("../classes/sgbd.php");

print "<HTML>\n";
print "<HEAD>\n";
print "<TITLE>Instala��o do Sistema de Gerenciamento de Redes Guar�</TITLE>\n";
print "</HEAD>\n";

print "<BODY BGCOLOR=#BBCCDD>\n";

print "<CENTER><H3><I><U>Instala��o do Sistema Guar�</U></I></H3></CENTER>\n";

if(!isset($CONFIRMAR)) {
	
	print "<CENTER>Bem vindo � instala��o do sistema <B>Guar�</B>.</CENTER>\n";

	print "<BR>\n";

	print "<CENTER>O <B>Guar�</B> auxilia no gerenciamento de redes atrav�s do protocolo <A HREF=\"snmp.html\">SNMP</A>.</CENTER>\n";
	print "<CENTER>O sistema � licenciado atrav�s da <A HREF=\"gnugpl.html\">GNU GPL.</A></CENTER>\n";

	print "<BR>\n";

	print "<CENTER>Este <I>script</I> de instala��o criar� um arquivo chamado \"guara.ini\",</CENTER>\n";
	print "<CENTER>onde ficar�o armazenadas as informa��es para acesso ao banco de dados.</CENTER>\n";
	print "<CENTER>Tamb�m ser�o criadas as tabelas necess�rias para o funcionamento do sistema.</CENTER>\n";

	print "<BR>\n";

	print "<CENTER>Por favor, preencha o formul�rio a seguir e clique no bot�o \"Confirmar\":</CENTER>\n";

	print "<BR>\n";

	print "<FORM ACTION=\"instalacao.php\" METHOD=POST>\n";
	print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
	print "<TR>\n";
	print "<TD><B>Servidor de banco de dados</B></TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" NAME=\"BDSERV\"></TD>\n";
	print "</TR><TR>\n";
	print "<TD><B>Nome da base de dados</B></TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" NAME=\"BDNOME\"></TD>\n";
	print "</TR><TR>\n";
	print "<TD><B>Usu�rio do banco de dados</B></TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" NAME=\"BDUSER\"></TD>\n";
	print "</TR><TR>\n";
	print "<TD><B>Senha do banco de dados</B></TD>\n";
	print "<TD><INPUT TYPE=\"PASSWORD\" NAME=\"BDSENHA\"></TD>\n";
	print "</TR></TABLE>\n";

	print "<BR>\n";

	print "<CENTER>\n";
	print "<INPUT TYPE=\"SUBMIT\" NAME=\"CONFIRMAR\" VALUE=\"Confirmar\">\n";
	print "</CENTER>\n";

	print "</FORM>\n";
}
	
else {
	print "<CENTER>Resultado da instala��o do sistema <B>Guar�</B>.</CENTER>\n";

	print "<BR>\n";

	print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
	print "<TR>\n";
	print "<TD><B>Servidor de banco de dados</B></TD>\n";
	print "<TD><I>$BDSERV</I></TD>\n";	
	print "</TR><TR>\n";
	print "<TD><B>Nome da base de dados</B></TD>\n";
	print "<TD><I>$BDNOME</I></TD>\n";	
	print "</TR><TR>\n";
	print "<TD><B>Usu�rio do banco de dados</B></TD>\n";
	print "<TD><I>$BDUSER</I></TD>\n";	
	print "</TR><TR>\n";
	print "<TD><B>Senha do banco de dados</B></TD>\n";
	print "<TD><I>********</I></TD>\n";	
	print "</TR></TABLE>\n";

	if(!$arquivo=fopen("../guara.ini","w")) {
		print "<CENTER>\n";
		print "<B>Erro ao criar o arquivo de configura��o.</B>";
		print "</CENTER>\n";
	}
	else {
		$string=new texto();
		$string->adicionar($BDSERV);
		$string->cript();
		fwrite($arquivo,$string->retornar());
		fwrite($arquivo,"\n");
		$string->limpar();
		$string->adicionar($BDNOME);
		$string->cript();
		fwrite($arquivo,$string->retornar());
		fwrite($arquivo,"\n");
		$string->limpar();
		$string->adicionar($BDUSER);
		$string->cript();
		fwrite($arquivo,$string->retornar());
		fwrite($arquivo,"\n");
		$string->limpar();
		$string->adicionar($BDSENHA);
		$string->cript();
		fwrite($arquivo,$string->retornar());
		print "<BR>\n";
		print "<CENTER>\n";
		print "<B>Arquivo de configura��o criado com sucesso.</B>";
		print "</CENTER>\n";
		fclose($arquivo);
		$tabelas=new tabela();
		if($tabelas->criar()) {
			print "<BR>\n";
			print "<CENTER>\n";
			print "<B>Tabelas do sistema criadas no SGBD.</B>";
			print "</CENTER>\n";
		}
		else {
			print "<BR>\n";
			print "<CENTER>\n";
			print "<B>Erro ao criar tabelas do sistema no SGBD.</B>";
			print "</CENTER>\n";
		}
	}
		
	$banco=new sgbd();
	$banco->sql->adicionar("INSERT INTO usuario VALUES (\"administrador\",\"Administrador do Guar�\",\"-\",\"".md5($BDSENHA)."\")");
	if($banco->executar()) {
		print "<BR>\n";
		print "<CENTER>\n";
		print "<B>Aten��o: o usu�rio 'administrador' foi cadastrado e sua senha � a mesma do banco de dados.</B>";
		print "</CENTER>\n";
	}
	else {
		print "<BR>\n";
		print "<CENTER>\n";
		print "<B>Erro ao cadastrar o usu�rio 'administrador'.</B>";
		print "</CENTER>\n";
	}
		
	session_destroy();

}

print "</BODY>\n";

print "</HTML>\n";

?>
