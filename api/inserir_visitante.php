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

		// Consultando o primeiro documento disponível
		$query  = "select documento_id from documento ";
		$query .= "where disponibilidade = 1 and numero_etiqueta like 'C%'";
		$query .= "order by documento_id asc limit 1;";

		$exec 	   	  = mysqli_query($con, $query);					// Executando a query
		$documento_id = mysqli_fetch_array($exec)['documento_id'];	// Recuperando o ID do documento

		// Atualizando a disponibilidade do documento para indisponível (0)
		$query  = "update documento set disponibilidade = '0' ";
		$query .= "where documento_id = " . $documento_id;

		$exec = mysqli_query($con, $query);		// Executando a query

		// Inserindo na tabela de 'usuário'
		$campos  = "tipo_usuario_id, documento_id, ultima_atualizacao, nome, foto, rg, ativo";								// Campos da tabela
		$valores = $tipo_usuario_id . ", " . $documento_id . ", now(), '" . $nome . "', '" . $foto_usuario . "', '" . $rg . "', 1";	// Valores a serem inseridos
		$query   = "insert into usuario(". $campos .") values(". $valores .");";								// Query completa

		mysqli_query($con, $query);				// Executando a query
		$usuario_id = mysqli_insert_id($con);	// Recuperando o ID do usuário
		

		// Consultando o primeiro documento disponível
		$query  = "select documento_id from documento ";
		$query .= "where disponibilidade = 1 and numero_etiqueta like 'A%'";
		$query .= "order by documento_id asc limit 1;";

		$exec 	   	  = mysqli_query($con, $query);					// Executando a query
		$documento_veiculo_id = mysqli_fetch_array($exec)['documento_id'];	// Recuperando o ID do documento

		// Inserindo na tabela de 'veículo'
		$campos  = "documento_id, placa, foto, ativo";											// Campos da tabela
		$valores = "'".$documento_veiculo_id."', '" . $placa . "', '" . $foto_veiculo . "', 1";					// Valores a serem inseridos
		$query   = "insert into veiculo(". $campos .") values(". $valores .");";	// Query completa

		mysqli_query($con, $query);				// Executando a query
		$veiculo_id = mysqli_insert_id($con);	// Recuperando o ID do veículo

		// Atualizando a disponibilidade do documento para indisponível (0)
		$query  = "update documento set disponibilidade = '0' ";
		$query .= "where documento_id = " . $documento_veiculo_id;

		// Inserindo na tabela de relacionamento entre usuário e veículo
		$campos  = "usuario_id, veiculo_id";													// Campos da tabela
		$valores = $usuario_id . ", " . $veiculo_id;											// Valores a serem inseridos
		$query   = "insert into rel_usuario_veiculo(". $campos .") values(". $valores .");";	// Query completa

		$exec = mysqli_query($con, $query);		// Executando a query

		// Consultando informações do usuário
		$query  = "select u.usuario_id, u.nome, u.rg, v.veiculo_id, v.placa from usuario as u ";
		$query .= "inner join rel_usuario_veiculo as uv on(u.usuario_id = uv.usuario_id) ";
		$query .= "inner join veiculo as v on(v.veiculo_id = uv.veiculo_id) ";
		$query .= "where u.usuario_id = ". $usuario_id .";";

		$exec 	 = mysqli_query($con, $query);	// Executando a query
		$usuario = mysqli_fetch_array($exec);	// Recuperando o usuário

		// Imprimindo o resultado (JSON)
		echo json_encode($usuario);

	}else echo "Nome e RG não enviado(s)";