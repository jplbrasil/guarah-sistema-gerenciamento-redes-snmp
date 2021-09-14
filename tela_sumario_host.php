<?php

/*
o arquivo cabecalho.php ja' inclui:
	menu.php
	texto.php
	controle_sistema.php
*/	

include_once("cabecalho.php");
include_once("classes/controle_operacional.php");

$ctr_ope=new controle_operacional();
$comunidade=$ctr_ope->retornar_comunidade_rede_atual();

if(!isset($numero_ip) || ($numero_ip=="")) {

	$ini=$ctr_ope->retornar_ip_inteiro_rede_atual("inicial");
	$fim=$ctr_ope->retornar_ip_inteiro_rede_atual("final");
	$inicio_ip=$ctr_ope->retornar_inicio_ip_rede_atual();

	print "<FORM ACTION=\"tela_sumario_host.php\" METHOD=\"POST\">\n";

	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD>\n";
				print "<B>Escolha um número IP &nbsp</B>\n";
			print "</TD>\n";
			print "<TD>\n";

			print "<SELECT NAME=\"numero_ip\">\n";

			for($i=$ini;$i<=$fim;$i++) {

			$numero_ip=$inicio_ip.$i;

			print "<OPTION VALUE=\"$numero_ip\">$numero_ip</OPTION>\n";

			}
			print "</SELECT>\n";

			print "</TD>\n";
		print "</TR>\n";
	print "</TABLE>\n";

	print "<BR>\n";

	print "<INPUT TYPE=\"SUBMIT\" VALUE=\"Continuar\">\n";

	print "</FORM>\n";
}

else {
	
	print "<TABLE BORDER=1>\n";

	print "<TR>\n";
	print "<TD>\n";
	print "<B>Nome do Host</B>\n";
	print "</TD>\n";
	print "<TD>\n";
	print $ctr_ope->snmp_requisitar_valor($numero_ip,$comunidade,"system.sysName.0");
	print "</TD>\n";
	print "</TR>\n";

	print "<TR>\n";
	print "<TD>\n";
	print "<B>Localização Física</B>\n";
	print "</TD>\n";
	print "<TD>\n";
	print $ctr_ope->snmp_requisitar_valor($numero_ip,$comunidade,"system.sysLocation.0");
	print "</TD>\n";
	print "</TR>\n";

	print "<TR>\n";
	print "<TD>\n";
	print "<B>Sistema Operacional</B>\n";
	print "</TD>\n";
	print "<TD>\n";
	print $ctr_ope->snmp_requisitar_valor($numero_ip,$comunidade,"system.sysDescr.0");
	print "</TD>\n";
	print "</TR>\n";
	
	print "<TR>\n";
	print "<TD>\n";
	print "<B>Pessoa de Contato</B>\n";
	print "</TD>\n";
	print "<TD>\n";
	print $ctr_ope->snmp_requisitar_valor($numero_ip,$comunidade,"system.sysContact.0");
	print "</TD>\n";
	print "</TR>\n";
	
	print "</TABLE>\n";
	
	print "<BR><HR><BR>\n";
	
	//-----------------------------------------------------------------------------------
	//			TRAFEGO DE PACOTES IP
	//-----------------------------------------------------------------------------------
	$vetor=$ctr_ope->snmp_informar_trafego_host($numero_ip,$comunidade,"ip");
	print "<BR>\n";
	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD COLSPAN=2 ALIGN=CENTER>\n";
				print "<B>Tráfego de Pacotes IP</B>";
			print "</TD>\n";
		print "</TR>\n";
		reset($vetor); 
		while(list($chave,$valor)=each($vetor)) {
			print "<TR>\n";
			print "<TD>$chave</TD>\n";
			print "<TD>$valor</TD>\n";
			print "</TR>\n";
		}
	print "</TABLE>\n";
	
	//-----------------------------------------------------------------------------------
	//			TRAFEGO DE PACOTES ICMP
	//-----------------------------------------------------------------------------------
	$vetor=$ctr_ope->snmp_informar_trafego_host($numero_ip,$comunidade,"icmp");
	print "<BR>\n";
	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD COLSPAN=2 ALIGN=CENTER>\n";
				print "<B>Tráfego de Pacotes ICMP</B>";
			print "</TD>\n";
		print "</TR>\n";
		reset($vetor); 
		while(list($chave,$valor)=each($vetor)) {
			print "<TR>\n";
			print "<TD>$chave</TD>\n";
			print "<TD>$valor</TD>\n";
			print "</TR>\n";
		}
	print "</TABLE>\n";
	
	//-----------------------------------------------------------------------------------
	//			TRAFEGO DE PACOTES TCP
	//-----------------------------------------------------------------------------------
	$vetor=$ctr_ope->snmp_informar_trafego_host($numero_ip,$comunidade,"tcp");
	print "<BR>\n";
	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD COLSPAN=2 ALIGN=CENTER>\n";
				print "<B>Tráfego de Pacotes TCP</B>";
			print "</TD>\n";
		print "</TR>\n";
		reset($vetor); 
		while(list($chave,$valor)=each($vetor)) {
			print "<TR>\n";
			print "<TD>$chave</TD>\n";
			print "<TD>$valor</TD>\n";
			print "</TR>\n";
		}
	print "</TABLE>\n";
	
	//-----------------------------------------------------------------------------------
	//			TRAFEGO DE PACOTES UDP
	//-----------------------------------------------------------------------------------
	$vetor=$ctr_ope->snmp_informar_trafego_host($numero_ip,$comunidade,"udp");
	print "<BR>\n";
	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD COLSPAN=2 ALIGN=CENTER>\n";
				print "<B>Tráfego de Pacotes UDP</B>";
			print "</TD>\n";
		print "</TR>\n";
		reset($vetor); 
		while(list($chave,$valor)=each($vetor)) {
			print "<TR>\n";
			print "<TD>$chave</TD>\n";
			print "<TD>$valor</TD>\n";
			print "</TR>\n";
		}
	print "</TABLE>\n";
	
	//-----------------------------------------------------------------------------------
	//			CONEXOES ABERTAS NO HOST
	//-----------------------------------------------------------------------------------
	$vetor=$ctr_ope->snmp_informar_conexoes_host($numero_ip,$comunidade,1);
	print "<BR>\n";
	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD ALIGN=CENTER COLSPAN=4>\n";
				print "<B>Conexões Abertas no Host</B>";
			print "</TD>\n";
		print "</TR>\n";
		print "<TR>\n";
			print "<TD><B>Protocolo</B></TD>\n";
			print "<TD><B>Endereço Local</B></TD>\n";
			print "<TD><B>Endereço Remoto</B></TD>\n";
			print "<TD><B>Estado</B></TD>\n";
		print "</TR>\n";
		reset($vetor);
		while(list($chave,$valor)=each($vetor)) {
			print "<TR>\n";
				print "<TD>$valor</TD>\n";
				list($chave,$valor)=each($vetor);
				print "<TD>$valor</TD>\n";
				list($chave,$valor)=each($vetor);
				print "<TD>$valor</TD>\n";
				list($chave,$valor)=each($vetor);
				print "<TD>$valor</TD>\n";
			print "</TR>\n";
		}
	print "</TABLE>\n";
	
	
	//-----------------------------------------------------------------------------------
	//			TABELA DE ROTAS DO HOST
	//-----------------------------------------------------------------------------------

		$vetor=$ctr_ope->snmp_informar_rotas_host($numero_ip,$comunidade);
	print "<BR>\n";
	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD ALIGN=CENTER COLSPAN=4>\n";
				print "<B>Tabela de Rotas do Host</B>";
			print "</TD>\n";
		print "</TR>\n";
		print "<TR>\n";
			print "<TD><B>Destino</B></TD>\n";
			print "<TD><B>Gateway</B></TD>\n";
			print "<TD><B>Flags</B></TD>\n";
			print "<TD><B>Interface</B></TD>\n";
		print "</TR>\n";
		reset($vetor);
		while(list($chave,$valor)=each($vetor)) {
			print "<TR>\n";
				print "<TD>$valor</TD>\n";
				list($chave,$valor)=each($vetor);
				print "<TD>$valor</TD>\n";
				list($chave,$valor)=each($vetor);
				print "<TD>$valor</TD>\n";
				print "<TD>\n";
					list($chave,$valor)=each($vetor);
					print "$valor";
					list($chave,$valor)=each($vetor);
					print " $valor";
				print "</TD>\n";
			print "</TR>\n";
		}
	print "</TABLE>\n";
	
	//-----------------------------------------------------------------------------------
	//			INTERFACES DE COMUNICACAO DO HOST
	//-----------------------------------------------------------------------------------
	$vetor=$ctr_ope->snmp_informar_interfaces_host($numero_ip,$comunidade);
	print "<BR>\n";
	print "<TABLE BORDER=1>\n";
		print "<TR>\n";
			print "<TD ALIGN=CENTER>\n";
				print "<B>Interfaces de Comunicação do Host</B>";
			print "</TD>\n";
		print "</TR>\n";
		reset($vetor);
		while(list($chave,$valor)=each($vetor)) {
			print "<TR>\n";
				print "<TD>\n";
					print "$valor";
					list($chave,$valor)=each($vetor);
					print " $valor";
				print "</TD>\n";
			print "</TR>\n";
		}
	print "</TABLE>\n";

} //fim do else isset $numero_ip
	
include_once("rodape.php");
	
?>
