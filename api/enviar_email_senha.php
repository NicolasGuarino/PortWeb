<?php  
	include("conexao.php");
	include("../../libs/EnviarEmails/funcao.php");

	$con = conectar();

	$email = addslashes($_REQUEST['email']);
	$retorno = array('valor' => false, 'mensagem' => "Email não existe no banco");

	$query  = "select * from usuario where login = '".$email."';";
	$select = mysqli_query($con, $query);
	$rs 	= mysqli_fetch_array($select);

	if($rs != null) {
		$corpo = file_get_contents("../corpo_email/email_recuperar_senha.php");
		
		$corpo = str_replace('$nome_usuario', $rs['nome'], $corpo);
		$corpo = str_replace('$id', $rs['usuario_id'], $corpo);
		$parametrosEnvio = array('email_envio' => 'enigma@primi.com.br', 'senha' => 'jeferson@1010', 'nome_envio' => 'Portaria');
		
		$retorno = enviarEmail([$email], [], "Recuperar senha", $corpo, $parametrosEnvio);
		if($retorno['status'] == 1) $retorno = array('valor' => true, 'mensagem' => "Email enviado");
		
	}

	echo json_encode($retorno);
?>
