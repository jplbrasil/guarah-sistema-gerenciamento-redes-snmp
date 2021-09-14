<?php

#include_once("texto.php");
	
class snmp {

	function definir_valor($numero_ip,$comunidade,$objeto,$tipo,$valor) {
		/*
		a variavel $tipo define o tipo do valor que o objeto da MIB II
		espera receber. Seus valores possiveis sao:
		i - INTEGER
		u - unsigned INTEGER
		t - TIMETICKS
		a - IPADDRESS
		o - OBJID
		s - STRING
		x - HEX STRING
		d - DECIMAL STRING
		b - BITS
		U - unsigned int64
		I - signed int64
		F - float
		D - double
		*/
		$info="";
		if(exec("snmpset -v 1 $numero_ip -c $comunidade $objeto $tipo:$valor",$info))
			return 1;
		else
			return 0;
	}
	
	function requisitar_valor($numero_ip,$comunidade,$objeto) {
		//$info="";
		//exec("snmpget -v 1 $numero_ip -c $comunidade  -Oqv -t 0 $objeto",$info);

		$piece=explode(".",$numero_ip);
		if($piece[3]%2==0)
			$info[0]="Microsoft Windows 98 SE";
		else	
			$info[0]="Conectiva Linux 8.0";
		
		return $info;
	}
	
	function informar_trafego_host($numero_ip,$comunidade,$protocolo) {
		$info=array();
		exec("snmpnetstat -v 1 $numero_ip -c $comunidade -s -P $protocolo",$info);
		//transforma o retorno do sistema operacional em um vetor estruturado
		reset($info);
		next($info);
		while(list($chave,$valor)=each($info)) {
			$divisor=strpos($valor," ");
			$tamanho=strlen($valor);
			$dado=substr($valor,0,$divisor);
			$descricao=substr($valor,$divisor,$tamanho);
			if(is_numeric($dado))
				$resultado[$descricao]=$dado;
		}
		return $resultado;
	}

	function informar_conexoes_host($numero_ip,$comunidade,$traduz) {

		/*
		a variavel $traduz define se os enderecos IP devem
		ser traduzidos para nomes ou nao. E' booleana.
		*/

		$texto=new texto();
		$piece=array();
		$resultado=array();
		$info="";
		if($traduz)
			exec("snmpnetstat -v 1 $numero_ip -c $comunidade -a",$info);
		else	
			exec("snmpnetstat -v 1 $numero_ip -c $comunidade -an",$info);
		//transforma o retorno do sistema operacional em um vetor estruturado
		reset($info);
		while(list($chave,$valor)=each($info)) {
			$texto->limpar();
			$texto->adicionar($valor);
			$piece=$texto->dividir(" ");
			if(!strcmp($piece[0],"tcp")) {
				for($i=0;$i<4;$i++)
					$resultado[]=$piece[$i];
			}
			else if(!strcmp($piece[0],"udp")) {
				for($i=0;$i<2;$i++)
					$resultado[]=$piece[$i];
				for($i=2;$i<4;$i++)
					$resultado[]="-";
			}			
		}
		return $resultado;
	}
	
	function informar_rotas_host($numero_ip,$comunidade) {
		$texto=new texto();
		$piece=array();
		$resultado=array();
		$info="";
		exec("snmpnetstat -v 1 $numero_ip -c $comunidade -rn",$info);
		//transforma o retorno do sistema operacional em um vetor estruturado
		reset($info);
		next($info);
		next($info);
		while(list($chave,$valor)=each($info)) {
			$texto->limpar();
			$texto->adicionar($valor);
			$piece=$texto->dividir(" ");
			for($i=0;$i<5;$i++)
				$resultado[]=$piece[$i];
		}
		return $resultado;
	}

	function informar_interfaces_host($numero_ip,$comunidade) {
		$texto=new texto();
		$piece=array();
		$resultado=array();
		$info="";
		exec("snmpnetstat -v 1 $numero_ip -c $comunidade -i",$info);
		//transforma o retorno do sistema operacional em um vetor estruturado
		reset($info);
		next($info);
		while(list($chave,$valor)=each($info)) {
			$texto->limpar();
			$texto->adicionar($valor);
			$piece=$texto->dividir(" ");
			for($i=0;$i<2;$i++)
				$resultado[]=$piece[$i];
		}
		return $resultado;
	}
}

?>
