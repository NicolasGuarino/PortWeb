<?php
	include "conexao.php";

	// Verificando parâmetros necessários
	if(isset($_GET['nome']) && isset($_GET['rg']) && isset($_GET['placa'])){

		// Conexão com o DB
		$con = conectar();

		// Parâmetros
		$nome			 = $_GET['nome'];
		$rg				 = $_GET['rg'];
		$placa			 = $_GET['placa'];
		$tipo_usuario_id = 4;							// Usuário 'visitante'
		$foto_usuario	 = "img/icone/person.png";		// Imagem padrão
		$foto_veiculo	 = "img/icones/ic_carro.png";	// Imagem padrão

		// Inserindo na tabela de 'usuário'
		$campos  = "tipo_usuario_id, ultima_atualizacao, nome, foto, rg, ativo";								// Campos da tabela
		$valores = $tipo_usuario_id . ", now(), '" . $nome . "', '" . $foto_usuario . "', '" . $rg . "', 1";	// Valores a serem inseridos
		$query   = "insert into usuario(". $campos .") values(". $valores .");";								// Query completa

		// Executando a query
		mysqli_query($con, $query);

		// Recuperando o ID do usuário
		$usuario_id = mysqli_insert_id($con);

		// Inserindo na tabela de 'veículo'
		$campos  = "placa, foto, ativo";											// Campos da tabela
		$valores = "'" . $placa . "', '" . $foto_veiculo . "', 1";					// Valores a serem inseridos
		$query   = "insert into veiculo(". $campos .") values(". $valores .");";	// Query completa

		// Executando a query
		mysqli_query($con, $query);

		// Recuperando o ID do veículo
		$veiculo_id = mysqli_insert_id($con);

		// Inserindo na tabela de relacionamento entre usuário e veículo
		$campos  = "usuario_id, veiculo_id";													// Campos da tabela
		$valores = $usuario_id . ", " . $veiculo_id;											// Valores a serem inseridos
		$query   = "insert into rel_usuario_veiculo(". $campos .") values(". $valores .");";	// Query completa

		// Executando a query
		$exec = mysqli_query($con, $query);

	}else echo "Nome e RG não enviado(s)";