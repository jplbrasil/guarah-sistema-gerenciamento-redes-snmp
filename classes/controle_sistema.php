<?php
include_once("usuario.php");
include_once("log.php");

class controle_sistema {

	var $registro;
	var $senha;

	function controle_sistema() {
		$this->registro="";
		$this->senha="";
	}
	
	function cadastrar_usuario($login,$nome,$email) {
		$this->registrar_log("Acionou o cadastro de usuário.");
		$usuario=new usuario();
		if($usuario->cadastrar($login,$nome,$email)) {
			$this->senha=$usuario->retornar_senha();
			return 1;
		}
		else
			return 0;
	}

	function retornar_senha_usuario() {
		$this->registrar_log("Acionou o retorno de senha de usuário.");
		if($this->senha!="")
			return $this->senha;
		else
			return 0;
	}

	function excluir_usuario($login) {
		$this->registrar_log("Acionou a exclusão de usuário.");
		$usuario=new usuario();
		if($usuario->excluir($login))
			return 1;
		else
			return 0;
	}
		
	function alterar_usuario($login,$nome,$email,$senha) {
		$this->registrar_log("Acionou a alteração de usuário.");
		$usuario=new usuario();
		if($usuario->alterar($login,$nome,$email,$senha))
			return 1;
		else
			return 0;
	}

	function pesquisar_usuario($campo,$operador,$criterio,$ordem) {
		$this->registrar_log("Acionou a pesquisa de usuário.");
		$usuario=new usuario();
		$this->registro=$usuario->pesquisar($campo,$operador,$criterio,$ordem);
		if(is_object($this->registro))
			return 1;
		else
			return 0;	
	}

	function verificar_senha($login,$senha) {
		$usuario=new usuario();
		$this->registro=$usuario->pesquisar("usu_login","=",$login,"usu_login");
		if($this->registro) {
			$this->registro->proximo();
			if($this->registro->valor['usu_senha']==md5($senha))
				return 1;
			else
				return 0;			
		}
		else
			return 0;
	}
	
	function registrar_log($ocorrencia) {
		$log=new log();
		$log->cadastrar($_SESSION['SYSUSER'],$ocorrencia);
	}

	function excluir_log($id) {
		$this->registrar_log("Acionou a exclusão de log.");
		$log=new log();
		if($log->excluir($id))
			return 1;
		else
			return 0;
	}
		
	function alterar_log($campo,$valor,$id) {
		$this->registrar_log("Acionou a alteração de log.");
		$log=new log();
		if($log->alterar($campo,$valor,$id))
			return 1;
		else
			return 0;
	}

	function pesquisar_log($campo,$operador,$criterio,$ordem) {
		$this->registrar_log("Acionou a pesquisa de log.");
		$log=new log();
		$this->registro=$log->pesquisar($campo,$operador,$criterio,$ordem);
		if(is_object($this->registro))
			return 1;
		else
			return 0;	
	}
	
}


?>
