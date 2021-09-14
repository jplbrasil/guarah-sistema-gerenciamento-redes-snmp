<?php
include_once("rede.php");
include_once("registro.php");
include_once("snmp.php");

class controle_operacional {

	var $registro;

	function controle_operacional() {
		$this->registro=new registro();
	}
	
	function cadastrar_rede($nome,$ip_inicial,$ip_final,$senha_snmp) {
		$this->registrar_log("Acionou o cadastro de rede.");
		$rede=new rede();
		if($rede->cadastrar($nome,$ip_inicial,$ip_final,$senha_snmp))
			return 1;
		else
			return 0;
	}

	function excluir_rede($id) {
		$this->registrar_log("Acionou a exclusão de rede.");
		$rede=new rede();
		if($rede->excluir($id))
			return 1;
		else
			return 0;
	}
		
	function alterar_rede($id,$nome,$ip_inicial,$ip_final,$comunidade_snmp) {
		$this->registrar_log("Acionou a alteração de rede.");
		$rede=new rede();
		if($rede->alterar($id,$nome,$ip_inicial,$ip_final,$comunidade_snmp))
			return 1;
		else
			return 0;
	}

	function pesquisar_rede($campo,$operador,$criterio,$ordem) {
		$this->registrar_log("Acionou a pesquisa de rede.");
		$rede=new rede();
		$this->registro=$rede->pesquisar($campo,$operador,$criterio,$ordem);
		if(is_object($this->registro))
			return 1;
		else
			return 0;	
	}

	function retornar_ip_inteiro_rede_atual($posicao) {
		if(!isset($_SESSION['REDEATUAL']))
			return 0;
		$this->pesquisar_rede("red_nome","=",$_SESSION['REDEATUAL'],"red_nome");
		$this->registro->proximo();
		$ip=$this->registro->valor_campo("red_ip_".$posicao);
		$piece=explode(".",$ip);
		return $piece[3];
	}

	function retornar_inicio_ip_rede_atual() {
		if(!isset($_SESSION['REDEATUAL']))
			return 0;
		$this->pesquisar_rede("red_nome","=",$_SESSION['REDEATUAL'],"red_nome");
		$this->registro->proximo();
		$ip=$this->registro->valor_campo("red_ip_inicial");
		$piece=explode(".",$ip);
		return $piece[0].".".$piece[1].".".$piece[2].".";
	}
	
	function retornar_comunidade_rede_atual() {
		if(!isset($_SESSION['REDEATUAL']))
			return 0;
		$this->pesquisar_rede("red_nome","=",$_SESSION['REDEATUAL'],"red_nome");
		$this->registro->proximo();
		return $this->registro->valor_campo("red_comunidade");
	}

	function totalizar_hosts_por_objeto_rede_atual($objeto) {
		$comunidade=$this->retornar_comunidade_rede_atual();
		$inicio_ip=$this->retornar_inicio_ip_rede_atual();
		$ini=$this->retornar_ip_inteiro_rede_atual("inicial");
		$fim=$this->retornar_ip_inteiro_rede_atual("final");
		$vetor=array();
		for($i=$ini;$i<=$fim;$i++) {
			$numero_ip=$inicio_ip.$i;
			$valor=$this->snmp_requisitar_valor($numero_ip,$comunidade,$objeto);
			if(array_key_exists($valor,$vetor))
				$vetor[$valor]++;
			else
				$vetor[$valor]=1;
		}
		return $vetor;
	}
	
	function retornar_sistemas_operacionais_rede_atual() {
		$this->registrar_log("Requisitou a quantidade de hosts por sistema operacional");
		return $this->totalizar_hosts_por_objeto_rede_atual("system.sysDescr.0");
	}

	function retornar_hosts_por_localizacao_rede_atual() {
		$this->registrar_log("Requisitou a quantidade de hosts por localizacao");
		return $this->totalizar_hosts_por_objeto_rede_atual("system.sysLocation.0");
	}

	function retornar_mapa_rede_atual() {
		$comunidade=$this->retornar_comunidade_rede_atual();
		$inicio_ip=$this->retornar_inicio_ip_rede_atual();
		$ini=$this->retornar_ip_inteiro_rede_atual("inicial");
		$fim=$this->retornar_ip_inteiro_rede_atual("final");
		$vetor=array();
		for($i=$ini;$i<=$fim;$i++) {
			$numero_ip=$inicio_ip.$i;
			$local=$this->snmp_requisitar_valor($numero_ip,$comunidade,"system.sysLocation.0");
			$host=$this->snmp_requisitar_valor($numero_ip,$comunidade,"system.sysName.0");
			$vetor[$host]=$local;
		}
		return $vetor;
	}
	
	function relacionar_usuario_rede($login,$id_rede) {
		$this->registrar_log("Acionou o relacionamento de usuário vs rede.");
		$rede=new rede();
		if($rede->relacionar_usuario_rede($login,$id_rede))
			return 1;
		else
			return 0;
	}

	function cancelar_usuario_rede($login,$id_rede) {
		$this->registrar_log("Acionou o cancelamento de usuário vs rede.");
		$rede=new rede();
		if($rede->cancelar_usuario_rede($login,$id_rede))
			return 1;
		else
			return 0;
	}
	
	function pesquisar_usuario_rede($campo,$operador,$criterio,$ordem) {
		$this->registrar_log("Acionou a pesquisa de usuário vs rede.");
		$rede=new rede();
		$this->registro=$rede->pesquisar_usuario_rede($campo,$operador,$criterio,$ordem);
		if(is_object($this->registro))
			return 1;
		else
			return 0;	
	}

	function registrar_log($ocorrencia) {
		$ctr_sis=new controle_sistema();
		$ctr_sis->registrar_log($ocorrencia);
	}

	function snmp_definir_valor($numero_ip,$comunidade,$objeto,$tipo,$valor) {
		$this->registrar_log("Definiu de valor do objeto $objeto do host $numero_ip.");
		$snmp=new snmp();
		return $snmp->definir_valor($numero_ip,$comunidade,$objeto,$tipo,$valor);	
	}

	function snmp_requisitar_valor($numero_ip,$comunidade,$objeto) {
		$this->registrar_log("Requisitou o valor do objeto $objeto do host $numero_ip.");
		$snmp=new snmp();
		$resultado=$snmp->requisitar_valor($numero_ip,$comunidade,$objeto);
		return $resultado[0];
	}
	
	function snmp_informar_trafego_host($numero_ip,$comunidade,$protocolo) {
		$this->registrar_log("Requisitou as informacoes de trafego do host $numero_ip.");
		$snmp=new snmp();
		return $snmp->informar_trafego_host($numero_ip,$comunidade,$protocolo);	
	}

	function snmp_informar_conexoes_host($numero_ip,$comunidade,$traduz) {
		$this->registrar_log("Requisitou as conexoes do host $numero_ip.");
		$snmp=new snmp();
		return $snmp->informar_conexoes_host($numero_ip,$comunidade,$traduz);	
	}
	
	function snmp_informar_rotas_host($numero_ip,$comunidade) {
		$this->registrar_log("Requisitou as rotas do host $numero_ip.");
		$snmp=new snmp();
		return $snmp->informar_rotas_host($numero_ip,$comunidade);	
	}

	function snmp_informar_interfaces_host($numero_ip,$comunidade) {
		$this->registrar_log("Requisitou as interfaces do host $numero_ip.");
		$snmp=new snmp();
		return $snmp->informar_interfaces_host($numero_ip,$comunidade);	
	}

	function snmp_listar_notificacoes_rede_atual() {
		$comunidade=$this->retornar_comunidade_rede_atual();
		$this->registrar_log("Requisitou as notificacoes da comunidade $comunidade");
		$snmp=new snmp();
		return $snmp->listar_notificacoes($comunidade);	
	}
}


?>
