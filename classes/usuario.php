<?php
include_once("sgbd.php");

class usuario {

	var $senha;

	function usuario() {
		$this->senha="";
	}
	
	function cadastrar($login,$nome,$email) {
		if(($login=="")||($nome=="")||($email==""))
			return 0;
		if(!$this->gerar_senha($login))
			return 0;
		$banco=new sgbd();
		$banco->adicionar_sql("INSERT INTO usuario VALUES (");
		$banco->adicionar_sql("\"$login\",");
		$banco->adicionar_sql("\"$nome\",");
		$banco->adicionar_sql("\"$email\",");
		$banco->adicionar_sql("\"".md5($this->senha)."\"");
		$banco->adicionar_sql(")");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function excluir($login) {
		$banco=new sgbd();
		$banco->adicionar_sql("DELETE FROM usuario WHERE usu_login = \"$login\"");
		if($banco->executar())
			return 1;
		else
			return 0;
	}
		
	function alterar($login,$nome,$email,$senha) {
		$banco=new sgbd();
		$banco->adicionar_sql("UPDATE usuario SET");
		$banco->adicionar_sql(" usu_nome = \"$nome\"");
		$banco->adicionar_sql(",usu_email = \"$email\"");
		if($senha!="")
			$banco->adicionar_sql(",usu_senha = \"".md5($senha)."\"");
		$banco->adicionar_sql(" WHERE usu_login = \"$login\"");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function pesquisar($campo,$operador,$criterio,$ordem) {
		$banco=new sgbd();
		$banco->adicionar_sql("SELECT * FROM usuario ");
		if($operador=="like")
			$banco->adicionar_sql("WHERE $campo $operador \"%$criterio%\" ");
		else
			$banco->adicionar_sql("WHERE $campo $operador \"$criterio\" ");
		$banco->adicionar_sql("ORDER BY $ordem");
		if($banco->requisitar())
			return $banco->registro;
		else
			return 0;
	}

	function gerar_senha($login) {
		srand((double)microtime()*1000000);
		$charIni=rand(0,8);
		$char=array(".","/","$");
		$subs=array("a","J","w");
		if($this->senha=str_replace($char,$subs,substr(crypt($login),$charIni,8)))
			return 1;
		else
			return 0;
	}

	function retornar_senha() {
		if($this->senha!="")
			return $this->senha;
		else
			return 0;
	}
	
}


?>
