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

if(isset($codigo)) {
	$ok=0;
	$ctr_ope=new controle_operacional();
	if($ctr_ope->pesquisar_usuario_rede("usu_login","=",$_SESSION['SYSUSER'],"red_nome")) {
		while($ctr_ope->registro->proximo()) {
			if($ctr_ope->registro->valor_campo("red_nome")==$codigo) {
				$_SESSION['REDEATUAL']=$codigo;
				$ok=1;
			}
		}
	}

	if(!$ok) {
		print "Você não tem permissão para selecionar a rede <B>$codigo</B>.\n";
		print "<BR><BR>\n";
	}
}	


if(!isset($_SESSION['REDEATUAL'])) {
	print "Nenhuma rede está selecionada atualmente.\n";
	print "<BR><BR>\n";
}

else {
	print "A rede <B>".$_SESSION['REDEATUAL']."</B> está selecionada atualmente.\n";
	print "<BR><BR>\n";
}

	print "Clique sobre uma rede para selecioná-la:\n";
	print "<BR><BR>\n";
	
	//desenha os icones das redes que o usuario tem acesso
	$rede=new texto();
	$vez=0;
	$ctr_ope=new controle_operacional();
	if($ctr_ope->pesquisar_usuario_rede("usu_login","=",$_SESSION['SYSUSER'],"red_nome")) {
		while($ctr_ope->registro->proximo()) {
			$rede->limpar();
			$rede->adicionar($ctr_ope->registro->valor_campo("red_nome"));

			if(!$vez) {
				print "<TABLE BORDER=0>\n";
				print "<TR>\n";
			}
			print "<TD ALIGN=\"CENTER\" WIDTH=150>\n";
			print "<A HREF=\"tela_selecao_rede.php?codigo=".$rede->retornar()."\">\n";
			print "<IMG SRC=\"rede.gif\" BORDER=0>\n";
			print "<BR>\n";
			print "<B>".$ctr_ope->registro->valor['red_nome']."</B>\n";
			print "</A>\n";		
			print "</TD>\n";
		
			if((($vez%3)==0)&&($vez)) {	
				print "</TR>\n";
				print "<TR>\n";
			}			
		
			$vez++;
		}
		if($vez) {
			print "</TR>\n";
			print "</TABLE>\n";
		}
	}
	else
		print "Ocorreu um erro na tentativa de recuperar as redes relacionadas ao usuário.";


include_once("rodape.php");
	
?>
