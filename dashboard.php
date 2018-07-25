<?php 
	session_start(); 
	$nome = $_SESSION['usuario']['nome'];
	$email = $_SESSION['usuario']['email'];
	$foto = $_SESSION['usuario']['foto'];
	$usuario_id = $_SESSION['usuario']['usuario_id'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Dashboard </title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/dashboard.css">
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="js/dashboard.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
	</head>

	<body>
		<div id="corpo">
			<header>
				<div id="logo"></div>
				<label class="tit"> Dashboard </label>
			</header>

			<div id="perfil_responsavel">
				<div id="foto"
					style="background:url(<?php echo $foto; ?>) center / contain no-repeat">
					
				</div>
				<div id="info">
					<span id="nome"> <?php echo $nome; ?> </span>
					<span id="email"> <?php echo $email ?> </span>
					
					<a href="login.php?m=alsl&id=<?php echo $usuario_id;?>" class="btn_alterar"> Alterar senha </a>
				</div>

			</div>
			
			<div id="opcoes">
				<div class="card_opcao" id="usuario">
					<div class="icone fa fa-users"></div>
					<span class="tit_card"> Gerenciamento de usuário </span>
				</div>

				<?php 
					if($_SESSION['usuario']['tipo_usuario_id'] == 6) {
				?>
					<div class="card_opcao" id="documentos">
						<div class="icone fa fa-file-text-o"></div>
						<span class="tit_card"> Gerenciamento de documentos </span>
					</div>

					<div class="card_opcao" id="empresa">
						<div class="icone fa fa-building-o"></div>
						<span class="tit_card"> Gerenciamento de empresas </span>
					</div>
				<?php } ?>
			</div>
		</div>
	</body>
</html>