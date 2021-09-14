<?php

include_once("texto.php");
include_once("sgbd.php");

class tabela {

	function criar() {
		$banco=new sgbd();
		if(!$arquivo=fopen("tabelas.txt","r"))
			return 0;
	
		$OK=1;
		$banco->sql->limpar();
		
		while(!feof($arquivo)) {
			$linha=trim(fgets($arquivo));
			$banco->sql->adicionar($linha);
			if(strcmp($linha,");")==0) {
				if(!$banco->executar())
					$OK=0;
				$banco->sql->limpar();
			}
		}

		return $OK;
	}
}


?>
