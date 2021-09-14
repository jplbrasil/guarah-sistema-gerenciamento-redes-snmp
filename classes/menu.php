<?php

class menu_item {
	var $nome="";
	var $referencia="";

	function adicionar($nome,$referencia) {
		$this->nome=$nome;
		$this->referencia=$referencia;
	}
}
	
class menu_grupo {
	var $item;
	var $itens=0;
	var $nome="";

	function adicionar($nome) {
		$this->nome=$nome;
	}
	
	function adicionar_item($nome,$referencia) {
		$this->itens++;
		$this->item[$this->itens]=new menu_item();
		$this->item[$this->itens]->nome=$nome;
		$this->item[$this->itens]->referencia=$referencia;
	}
}

class menu {

	var $grupo;
	var $grupos=0;
	var $borda=0;

	function adicionar_grupo($nome) {
		$this->grupos++;
		$this->grupo[$this->grupos]=new menu_grupo();
		$this->grupo[$this->grupos]->adicionar($nome);
	}

	function adicionar_item($nome,$referencia) {
		$this->grupo[$this->grupos]->adicionar_item($nome,$referencia);
	}
	
	function exibir() {
		print "<TABLE BORDER=$this->borda ALIGN=\"LEFT\">\n";
		for($i=1;$i<$this->grupos+1;$i++) {
			print "<TR><TD BGCOLOR=\"#EEEEEE\">";
			print "<B>".$this->grupo[$i]->nome."</B>";
			print "</TD></TR>\n";
			
			for($j=1;$j<$this->grupo[$i]->itens+1;$j++) {
				print "<TR><TD BGCOLOR=\"#EEEEEE\">";
				print "<A HREF=\"".$this->grupo[$i]->item[$j]->referencia."\">";
				print $this->grupo[$i]->item[$j]->nome;
				print "</A>";
				print "</TD></TR>\n";
			}
		}
		print "</TABLE>\n";
	}
	
}

?>
