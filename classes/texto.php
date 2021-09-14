<?php

class texto {

	var $valor;
	
	function texto() {
		$this->limpar();
	}
	
	function adicionar($string) {
		$this->valor.=$string;
	}
	
	function retornar() {
		return $this->valor;
	}
	
	function limpar() {
		$this->valor="";
	}

	function cript() {
		for($i=0;$i<strlen($this->valor);$i++) {
			$ascii=ord($this->valor[$i])+(($i+1)*7);
			$this->valor[$i]=chr($ascii);
		}
	}

	function decript() {
		for($i=0;$i<strlen($this->valor);$i++) {
			$ascii=ord($this->valor[$i])-(($i+1)*7);
			$this->valor[$i]=chr($ascii);
		}
	}

	function dividir($divisor) {
		
		/*
		recebe uma string e a divide em partes de acordo com o divisor informado.
		A diferenca desta funcao para a 'explode()' do PHP e' que pode-se ter varios
		divisores sucessivos e eles serao entendidos como apenas um.
		Ex:
			$this->valor = "Active Internet         (tcp)   Connections";
			$divisor = " "
		Retorna o seguinte vetor:
			$piece[0] => "Active"
			$piece[1] => "Internet"
			$piece[2] => "(tcp)"
			$piece[3] => "Conections"
		*/
		
		$i=0;
		$j=-2;
		$char_ant=$divisor;
		$substr="";
		$tamanho=strlen($this->valor);
		while($i<$tamanho) {
			if(($char_ant==$divisor)&&($this->valor[$i]<>$divisor)) {
				$j++;
				$piece[$j]=$substr;
				$substr="";
			}
			if($this->valor[$i]<>$divisor) {
				$substr.=$this->valor[$i];
			}
			$char_ant=$this->valor[$i];
			$i++;	
		}
		$j++;
		$piece[$j]=$substr;			
		return $piece;
	}

}

?>
