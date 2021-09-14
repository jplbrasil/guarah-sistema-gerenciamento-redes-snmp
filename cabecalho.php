<?php

session_start();

if(!isset($login)&&!isset($senha)&&!isset($_SESSION['SYSUSER']))
	header("Location: index.php");

if(!isset($nao_verificar_rede)) {	
	if(!isset($_SESSION['REDEATUAL']))
		header("Location: tela_selecao_rede.php");
}
	
include_once("classes/menu.php");
include_once("classes/texto.php");
include_once("classes/controle_sistema.php");
	
if( (isset($login) && isset($senha)) || !isset($_SESSION['SYSUSER']) ) {

	$_SESSION=Array();
	
	$arquivo=fopen("guara.ini","r");

	$string=new texto();
	$string->adicionar(trim(fgets($arquivo)));
	$string->decript();
	$_SESSION['BDSERV']=$string->retornar();
	//---
	$string->limpar();
	$string->adicionar(trim(fgets($arquivo)));
	$string->decript();
	$_SESSION['BDNOME']=$string->retornar();
	//---
	$string->limpar();
	$string->adicionar(trim(fgets($arquivo)));
	$string->decript();
	$_SESSION['BDUSER']=$string->retornar();
	//---
	$string->limpar();
	$string->adicionar(trim(fgets($arquivo)));
	$string->decript();
	$_SESSION['BDSENHA']=$string->retornar();
	
	$ctr_sis=new controle_sistema();
	if($ctr_sis->verificar_senha($login,$senha)) {
		$_SESSION['SYSUSER']=$login;
		$ctr_sis->registrar_log("Efetuou login no sistema.");
	}
}

if(isset($_SESSION['SYSUSER'])) {
	
	//Carrega as opcoes do menu do sistema
	$menu=new menu();

	if($_SESSION['SYSUSER']=="administrador") {
		$menu->adicionar_grupo("Cadastros");
		$menu->adicionar_item("Redes","tela_redes.php");
		$menu->adicionar_item("Usuários","tela_usuarios.php");
		$menu->adicionar_item("Usuários x Redes","tela_usuarios_redes.php");
		$menu->adicionar_grupo("Utilitários");
		$menu->adicionar_item("Log do Sistema","tela_logs.php");
		$menu->adicionar_item("Sair do Guará","index.php");
	}
	else {
		$menu->adicionar_grupo("Gerência");
		$menu->adicionar_item("Seleção de Rede","tela_selecao_rede.php");
		$menu->adicionar_item("Sumário de Rede","tela_sumario_rede.php");
		$menu->adicionar_item("Sumário de Host","tela_sumario_host.php");
		$menu->adicionar_item("Mapa de Rede","tela_mapa_rede.php");
		$menu->adicionar_item("Notificações","tela_notificacoes.php");
		$menu->adicionar_grupo("Utilitários");
		$menu->adicionar_item("Sair do Guará","index.php");
	}
		
	$menu->borda=1;
		

	//Define as cores padrao do sistema
	$COR_FUNDO="#BBCCDD";
	$COR_ALINK="BLUE";
	$COR_VLINK="BLUE";
	$COR_LINK="BLUE";
	//Cabecalho de tabelas
	$COR_CAB="#EEEEEE";
	//Linhas impares de tabelas
	$COR_LIN1="";
	//Linhas pares de tabelas
	$COR_LIN2="#CCDDEE";

	print "<HTML>\n";

	print "<HEAD><TITLE>Guará - Sistema de Gerenciamento de Redes</TITLE></HEAD>\n";

	print "<BODY BGCOLOR=\"$COR_FUNDO\" ALINK=\"$COR_ALINK\" VLINK=\"$COR_VLINK\" LINK=\"$COR_LINK\">\n";

	print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
	print "<TR>\n";

	print "<TD BGCOLOR=\"$COR_CAB\" WIDTH=50 ALIGN=\"CENTER\">\n";
	print "<A HREF=\"index.php\"><IMG SRC=\"logo_m.gif\" BORDER=0></A>\n";
	print "</TD>\n";

	print "<TD BGCOLOR=\"$COR_CAB\" WIDTH=750 ALIGN=\"CENTER\">\n";
	print "<BR><H4>Guará - Sistema de Gerenciamento de Redes</H4>\n";
	print "</TD>\n";
	print "</TR>\n";
	print "</TABLE>\n";

	print "<BR>\n";

	$menu->exibir();

	print "<TABLE BORDER=0 ALIGN=\"CENTER\">\n";
	print "<TR>\n";
	print "<TD WIDTH=600 ALIGN=\"CENTER\">\n";
}

else
	header("Location: index.php?login_incorreto=1");


?>
