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
print "<TITLE>Instalação do Sistema de Gerenciamento de Redes Guará</TITLE>\n";
print "</HEAD>\n";

print "<BODY BGCOLOR=#BBCCDD>\n";

print "<CENTER><H3><I><U>Instalação do Sistema Guará</U></I></H3></CENTER>\n";

if(!isset($CONFIRMAR)) {
	
	print "<CENTER>Bem vindo à instalação do sistema <B>Guará</B>.</CENTER>\n";

	print "<BR>\n";

	print "<CENTER>O <B>Guará</B> auxilia no gerenciamento de redes através do protocolo <A HREF=\"snmp.html\">SNMP</A>.</CENTER>\n";
	print "<CENTER>O sistema é licenciado através da <A HREF=\"gnugpl.html\">GNU GPL.</A></CENTER>\n";

	print "<BR>\n";

	print "<CENTER>Este <I>script</I> de instalação criará um arquivo chamado \"guara.ini\",</CENTER>\n";
	print "<CENTER>onde ficarão armazenadas as informações para acesso ao banco de dados.</CENTER>\n";
	print "<CENTER>Também serão criadas as tabelas necessárias para o funcionamento do sistema.</CENTER>\n";

	print "<BR>\n";

	print "<CENTER>Por favor, preencha o formulário a seguir e clique no botão \"Confirmar\":</CENTER>\n";

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
	print "<TD><B>Usuário do banco de dados</B></TD>\n";
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
	print "<CENTER>Resultado da instalação do sistema <B>Guará</B>.</CENTER>\n";

	print "<BR>\n";

	print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
	print "<TR>\n";
	print "<TD><B>Servidor de banco de dados</B></TD>\n";
	print "<TD><I>$BDSERV</I></TD>\n";	
	print "</TR><TR>\n";
	print "<TD><B>Nome da base de dados</B></TD>\n";
	print "<TD><I>$BDNOME</I></TD>\n";	
	print "</TR><TR>\n";
	print "<TD><B>Usuário do banco de dados</B></TD>\n";
	print "<TD><I>$BDUSER</I></TD>\n";	
	print "</TR><TR>\n";
	print "<TD><B>Senha do banco de dados</B></TD>\n";
	print "<TD><I>********</I></TD>\n";	
	print "</TR></TABLE>\n";

	if(!$arquivo=fopen("../guara.ini","w")) {
		print "<CENTER>\n";
		print "<B>Erro ao criar o arquivo de configuração.</B>";
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
		print "<B>Arquivo de configuração criado com sucesso.</B>";
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
	$banco->sql->adicionar("INSERT INTO usuario VALUES (\"administrador\",\"Administrador do Guará\",\"-\",\"".md5($BDSENHA)."\")");
	if($banco->executar()) {
		print "<BR>\n";
		print "<CENTER>\n";
		print "<B>Atenção: o usuário 'administrador' foi cadastrado e sua senha é a mesma do banco de dados.</B>";
		print "</CENTER>\n";
	}
	else {
		print "<BR>\n";
		print "<CENTER>\n";
		print "<B>Erro ao cadastrar o usuário 'administrador'.</B>";
		print "</CENTER>\n";
	}
		
	session_destroy();

}

print "</BODY>\n";

print "</HTML>\n";

?>
