<?php
class registro {
	
	var $valor;
	var $retorno_banco;

	function registro() {
		$this->valor="";
		$this->retorno_banco="";
	}
	
	function proximo() {
		if($this->valor=mysql_fetch_array($this->retorno_banco))
			return 1;
		else
			return 0;
	}

	function valor_campo($string) {
		return $this->valor["$string"];
	}
}
?>
