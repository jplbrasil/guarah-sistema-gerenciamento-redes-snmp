<?php
include_once("sgbd.php");

class rede {
	
	function cadastrar($nome,$ip_inicial,$ip_final,$comunidade_snmp) {
		$banco=new sgbd();
		$banco->sql->adicionar("INSERT INTO rede VALUES (");
		$banco->sql->adicionar("NULL,");
		$banco->sql->adicionar("\"$nome\",");
		$banco->sql->adicionar("\"$ip_inicial\",");
		$banco->sql->adicionar("\"$ip_final\",");
		$banco->sql->adicionar("\"$comunidade_snmp\"");
		$banco->sql->adicionar(")");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function excluir($id) {
		$banco=new sgbd();
		$banco->sql->adicionar("DELETE FROM rede WHERE red_id = \"$id\"");
		if($banco->executar())
			return 1;
		else
			return 0;
	}
		
	function alterar($id,$nome,$ip_inicial,$ip_final,$comunidade_snmp) {
		$banco=new sgbd();
		$banco->sql->adicionar("UPDATE rede SET");
		$banco->sql->adicionar(" red_nome = \"$nome\"");
		$banco->sql->adicionar(",red_ip_inicial = \"$ip_inicial\"");
		$banco->sql->adicionar(",red_ip_final = \"$ip_final\"");
		$banco->sql->adicionar(",red_comunidade = \"$comunidade_snmp\"");
		$banco->sql->adicionar(" WHERE red_id = \"$id\"");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function pesquisar($campo,$operador,$criterio,$ordem) {
		$banco=new sgbd();
		$banco->sql->adicionar("SELECT * FROM rede ");
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

	function relacionar_usuario_rede($login,$id_rede) {
		$banco=new sgbd();
		$banco->sql->adicionar("INSERT INTO usuario_rede VALUES (");
		$banco->sql->adicionar("\"$login\",");
		$banco->sql->adicionar("\"$id_rede\"");
		$banco->sql->adicionar(")");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function cancelar_usuario_rede($login,$id_rede) {
		$banco=new sgbd();
		$banco->sql->adicionar("DELETE FROM usuario_rede WHERE ");
		$banco->sql->adicionar("usu_login = \"$login\"");
		$banco->sql->adicionar(" AND red_id = \"$id_rede\"");
		if($banco->executar())
			return 1;
		else
			return 0;
	}

	function pesquisar_usuario_rede($campo,$operador,$criterio,$ordem) {
		$banco=new sgbd();
		$banco->sql->adicionar("SELECT * FROM usuario_rede,rede ");
		if($operador=="like")
			$banco->sql->adicionar("WHERE usuario_rede.$campo $operador \"%$criterio%\" ");
		else
			$banco->sql->adicionar("WHERE usuario_rede.$campo $operador \"$criterio\" ");
		$banco->sql->adicionar("AND usuario_rede.red_id = rede.red_id ");
		$banco->sql->adicionar("ORDER BY $ordem");
		if($banco->requisitar())
			return $banco->registro;
		else
			return 0;
	}
}


?>
