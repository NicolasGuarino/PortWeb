<?php
	// Gera uma imagem oculta de acordo com o valor do parâmetro
	function gerar_imagem_oculta($valor_ini, $caminho_img){

		$img_largura = 118;		// Largura da imagem do caracter
		$img_altura  = 118;		// Altura da imagem do caracter

		$qtd_coluna	   	= 13;
		$qtd_linha 		= 7;
		$lim_caractere 	= $qtd_coluna * $qtd_linha;	// Limite de caracteres na imagem

		$nome = $valor_ini;
		$nome = ajustar_valor($nome, 3 * $qtd_coluna);
		
		$pin = "";
		$pin = ajustar_valor($pin, (3 * $qtd_coluna));
		// $pin .= "12345";
		// $pin .= ajustar_valor("", (1 * $qtd_coluna) + 4);

		$enigma = "PRIMI  ENIGMA";
		$enigma = ajustar_valor($enigma, 1 * $qtd_coluna);

		$valor = $nome . $pin . $enigma;

		// Quantidade de caracteres do valor
		$qtd_caractere = strlen($valor);

		// Criando a imagem base
		$img_base = imagecreatetruecolor($img_largura * $qtd_coluna, $img_altura * $qtd_linha);

		// Adicionando transparência a imagem base
		imagesavealpha($img_base, true);

		// Adicionando cor transparente a imagem base
		$color = imagecolorallocatealpha($img_base, 0, 0, 0, 127);
		imagefill($img_base, 0, 0, $color);

		$linha = 0;

		for($i=0; $i<$qtd_caractere; $i++){

			for($x=0; $x<$qtd_coluna; $x++){

				if($i != $qtd_caractere){
					
					// Criando a imagem respectiva ao caractere
					if($valor[$i] == " ") $caminho_arq = $caminho_img . "VAZIO.png";
					else $caminho_arq = $caminho_img . $valor[$i] . ".png";
					
					$img_criada = imagecreatefrompng($caminho_arq);

					// Juntando a imagem base com a imagem criada
					imagecopymerge($img_base, $img_criada, $img_largura * $x, $img_altura * $linha, 0, 0, $img_largura, $img_altura, 100);

					if($x != $qtd_coluna-1) $i++;
				}
			}
			
			$linha ++;
		}

		return $img_base;
	}

	function ajustar_valor($valor, $tamanho){

		// Capturando somento os caracteres numericos e pertencentes ao alfabeto
		$valor = remover_char_especial($valor);

		// Recortando a quantidade limite de caracteres
		$valor = substr($valor, 0, $tamanho);

		// Completando os espaços vazios até o limite de caracteres
		$valor = str_pad($valor, $tamanho, " ", STR_PAD_RIGHT);

		return $valor;
	}

	// Retorna os caracteres numericos e pertencentes ao alfabeto da "$string"
	function remover_char_especial($string){
		$resultado = null;

		// Removendo os caracteres diferentes de A até Z e de 0 até 9
		$pattern   = "/[^a-zA-Z0-9\s]+/";
		$resultado = preg_replace($pattern, "", $string);

		return $resultado;
	}
?>