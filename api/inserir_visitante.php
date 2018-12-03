<?php
	include "conexao.php";

	// Conexão com o DB
	$con = conectar();

	// Parâmetros
	$nome			 = $_GET['nome'];
	$rg				 = $_GET['rg'];
	$placa			 = $_GET['placa'];
	$tipo_usuario_id = 4;							// Usuário 'visitante'
	$foto_usuario	 = "img/icones/person.png";		// Imagem padrão
	$foto_veiculo	 = "img/icones/ic_carro.png";	// Imagem padrão

	
	$query = "select * from usuario where rg = '$rg';";
	$exec = mysqli_query($con, $query);
	$usuario_id = mysqli_fetch_array($exec)['usuario_id'];
	
	if($usuario_id == "" || $usuario_id == null){

		// Consultando o primeiro documento disponível para condômeno
		$query  = "select documento_id from documento ";
		$query .= "where disponibilidade = 1 and numero_etiqueta like 'C%'";
		$query .= "order by documento_id asc limit 1;";

		$exec 	   	  = mysqli_query($con, $query);					// Executando a query
		$documento_id = mysqli_fetch_array($exec)['documento_id'];	// Recuperando o ID do documento

		// Atualizando a disponibilidade do documento (para '0')
		$query  = "update documento set disponibilidade = '0' ";
		$query .= "where documento_id = " . $documento_id;

		$exec = mysqli_query($con, $query);		// Executando a query

		// Inserindo na tabela de 'usuário'
		$campos  = "tipo_usuario_id, documento_id, ultima_atualizacao, nome, foto, rg, ativo";								// Campos da tabela
		$valores = $tipo_usuario_id . ", " . $documento_id . ", now(), '" . $nome . "', '" . $foto_usuario . "', '" . $rg . "', 1";	// Valores a serem inseridos
		$query   = "insert into usuario(". $campos .") values(". $valores .");";								// Query completa

		mysqli_query($con, $query);				// Executando a query
		$usuario_id = mysqli_insert_id($con);	// Recuperando o ID do usuário

		// Inserindo veículo somente se houver placa 
		if($placa != ""){

			// Consultando o primeiro documento disponível para automovel
			$query  = "select documento_id from documento ";
			$query .= "where disponibilidade = 1 and numero_etiqueta like 'A%'";
			$query .= "order by documento_id asc limit 1;";

			$exec 	   	  		  = mysqli_query($con, $query);					// Executando a query
			$documento_veiculo_id = mysqli_fetch_array($exec)['documento_id'];	// Recuperando o ID do documento

			// Atualizando a disponibilidade do documento (para '0')
			$query  = "update documento set disponibilidade = '0' ";
			$query .= "where documento_id = " . $documento_veiculo_id;

			mysqli_query($con, $query); 	// Executando a query

			// Inserindo na tabela de 'veículo'
			$campos  = "documento_id, placa, foto, ativo";											// Campos da tabela
			$valores = "'".$documento_veiculo_id."', '" . $placa . "', '" . $foto_veiculo . "', 1";					// Valores a serem inseridos
			$query   = "insert into veiculo(". $campos .") values(". $valores .");";	// Query completa

			mysqli_query($con, $query);				// Executando a query
			$veiculo_id = mysqli_insert_id($con);	// Recuperando o ID do veículo

			// Inserindo na tabela de relacionamento entre usuário e veículo
			$campos  = "usuario_id, veiculo_id";													// Campos da tabela
			$valores = $usuario_id . ", " . $veiculo_id;											// Valores a serem inseridos
			$query   = "insert into rel_usuario_veiculo(". $campos .") values(". $valores .");";	// Query completa

			$exec = mysqli_query($con, $query);		// Executando a query
		}
	}
	
	// Consultando informações do usuário e veículo
	$query  = "select u.usuario_id, u.nome, u.rg, v.veiculo_id, v.placa from usuario as u ";
	$query .= "left join rel_usuario_veiculo as uv on(u.usuario_id = uv.usuario_id) ";
	$query .= "left join veiculo as v on(v.veiculo_id = uv.veiculo_id) ";
	$query .= "where u.usuario_id = ". $usuario_id .";";

	$exec 	 = mysqli_query($con, $query);	// Executando a query
	$usuario = mysqli_fetch_array($exec);	// Recuperando o usuário

	// Imprimindo o resultado (JSON)
	echo json_encode($usuario);