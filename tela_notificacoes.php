<?php

/*
o arquivo cabecalho.php ja' inclui:
	menu.php
	texto.php
	controle_sistema.php
*/	

include_once("cabecalho.php");
include_once("classes/controle_operacional.php");
include_once("classes/data.php");

$ctr_ope=new controle_operacional();
	
//-----------------------------------------------------------------------------------
//			TABELA DE ROTAS DO HOST
//-----------------------------------------------------------------------------------

$vetor=$ctr_ope->snmp_listar_notificacoes_rede_atual();
print "<BR>\n";
print "<TABLE BORDER=1>\n";
	print "<TR>\n";
		print "<TD><B>Data</B></TD>\n";
		print "<TD><B>Hora</B></TD>\n";
		print "<TD><B>Host</B></TD>\n";
		//print "<TD><B>Versão</B></TD>\n";
		//print "<TD><B>Comunidade</B></TD>\n";
		//print "<TD><B>Objeto</B></TD>\n";
		print "<TD><B>Notificação</B></TD>\n";
		//print "<TD><B>Tempo de Operação</B></TD>\n";
		
	print "</TR>\n";
	$data=new data();
	reset($vetor);
	while(list($chave,$valor)=each($vetor)) {
		print "<TR>\n";
			//data
			$data->atribuir($valor);
			$data->iso_para_brasil();
			print "<TD>".$data->retornar()."</TD>\n";

			//hora
			list($chave,$valor)=each($vetor);
			print "<TD>$valor</TD>\n";

			//host
			list($chave,$valor)=each($vetor);
			$valor=str_replace("TRAP,","",$valor);
			print "<TD>$valor</TD>\n";

			//SNMP (versao)
			//print "<TD>\n";
				list($chave,$valor)=each($vetor);
				//print "$valor";
				list($chave,$valor)=each($vetor);
				//print " $valor";
			//print "</TD>\n";

			//comunity ********
			//print "<TD>\n";
				list($chave,$valor)=each($vetor);
				//print "$valor";
				list($chave,$valor)=each($vetor);
				//print " $valor";
			//print "</TD>\n";

			//objeto
			list($chave,$valor)=each($vetor);
			//print "<TD>$valor</TD>\n";

			//notificacao ex.: cold start trap (0)
			print "<TD>\n";
				list($chave,$valor)=each($vetor);
				print "$valor";
				list($chave,$valor)=each($vetor);
				print " $valor";
				list($chave,$valor)=each($vetor);
				print " $valor";
				list($chave,$valor)=each($vetor);
				print " $valor";
			print "</TD>\n";

			//uptime 00:00:00
			//print "<TD>\n";
				list($chave,$valor)=each($vetor);
				//print "$valor";
				list($chave,$valor)=each($vetor);
				//print " $valor";
			//print "</TD>\n";

		print "</TR>\n";
	}
print "</TABLE>\n";
	
include_once("rodape.php");
	
?>
