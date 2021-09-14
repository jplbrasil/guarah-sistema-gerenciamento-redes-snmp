<?php
include_once("registro.php");
include_once("texto.php");
	
class sgbd {

	var $base_atual;
	var $conexao;
	var $sql;
	var $registro;

	function sgbd() {
		$this->base_atual="";
		$this->conexao="";
		$this->sql=new texto();
		$this->registro=new registro();
		$this->limpar_sql();
	}
	
	function conectar() {
		if($this->conexao=mysql_connect($_SESSION['BDSERV'],$_SESSION['BDUSER'],$_SESSION['BDSENHA'])) {
			$this->base_atual=$_SESSION['BDNOME'];
			return 1;
		}
		else
			return 0;	
	}

	function desconectar() {
		mysql_close($this->conexao);
	}

	function adicionar_sql($string) {
		$this->sql->adicionar($string);
	}

	function limpar_sql() {
		$this->sql->limpar();
	}
	
	function requisitar() {
		if(!$this->conectar())
			return 0;
		if($this->registro->retorno_banco=mysql_db_query($this->base_atual,$this->sql->valor,$this->conexao)) {
			$this->desconectar();
			return 1;
		}
		else {
			$this->desconectar();
			return 0;
		}
	}

	function executar() {
		if(!$this->conectar())
			return 0;
		if(mysql_db_query($this->base_atual,$this->sql->valor,$this->conexao)) {
			$this->desconectar();
			return 1;
		}
		else {
			$this->desconectar();
			return 0;
		}
	}
}
?>
