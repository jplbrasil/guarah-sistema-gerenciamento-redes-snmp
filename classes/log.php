<?php
include_once("sgbd.php");
include_once("data.php");
include_once("hora.php");

class log {

	function cadastrar($login,$ocorrencia) {
		$dia=new data();
		$dia->hoje_iso();
		$horario=new hora();
		$horario->agora();
		$banco=new sgbd();
		$banco->sql->adicionar("INSERT INTO log VALUES (");
		$banco->sql->adicionar("NULL,");
		$banco->sql->adicionar("\"".$dia->data."\",");
		$banco->sql->adicionar("\"".$horario->hora."\",");
		$banco->sql->adicionar("\"$login\",");
		$banco->sql->adicionar("\"$ocorrencia\"");
		$banco->sql->adicionar(")");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function excluir($id) {
		$banco=new sgbd();
		$banco->sql->adicionar("DELETE FROM log WHERE log_id = \"$id\"");
		if($banco->executar())
			return 1;
		else
			return 0;
	}
		
	function alterar($campo,$valor,$id) {
		$banco=new sgbd();
		$banco->sql->adicionar("UPDATE log SET ");
		$banco->sql->adicionar("$campo = \"$valor\",");
		$banco->sql->adicionar("WHERE log_id = \"$id\"");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function pesquisar($campo,$operador,$criterio,$ordem) {
		$banco=new sgbd();
		$banco->sql->adicionar("SELECT * FROM log ");
		if($operador=="like")
			$banco->sql->adicionar("WHERE $campo $operador \"%$criterio%\" ");
		else
			$banco->sql->adicionar("WHERE $campo $operador \"$criterio\" ");
		$banco->sql->adicionar("ORDER BY $ordem");
		if($banco->requisitar())
			return $banco->registro;
		else
			return 0;
	}
	
}


?>
