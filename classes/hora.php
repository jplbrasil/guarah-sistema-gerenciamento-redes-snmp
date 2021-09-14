<?php

class hora {
	
	var $hora;

	function hora() {
		$this->hora="";
	}
	
	function agora() {
		$this->hora=date("H").":".date("i").":".date("s");
	}
}

?>
