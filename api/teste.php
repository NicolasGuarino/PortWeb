<?php 
	include("../../libs/EnviarEmails/funcao.php");

	$corpo = file_get_contents("../corpo_email/email_recuperar_senha.php");
		
	$corpo = str_replace('$nome_usuario', "Gabriel Navevaiko", $corpo);
	$corpo = str_replace('$id', 15, $corpo);
	$corpo = str_replace('$email', "gabriel@primi.com.br", $corpo);
	$parametrosEnvio = array('email_envio' => 'enigma@primi.com.br', 'senha' => 'jeferson@1010', 'nome_envio' => 'Portaria');
	
	$retorno = enviarEmail(["gabriel@primi.com.br"], [], "Boas vindas", $corpo, $parametrosEnvio);
	if($retorno['status'] == 1) $result = 1;
?>		
