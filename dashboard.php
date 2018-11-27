<?php
	session_start(); 
	include "api/verifica_permissao.php";
	
	$nome = $_SESSION['usuario']['nome'];
	$email = $_SESSION['usuario']['email'];
	$foto = $_SESSION['usuario']['foto'];
	$usuario_id = $_SESSION['usuario']['usuario_id'];

	if(!$foto) {
		$foto = "img/icones/ic_noImage.png";
	}
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
		<script type="text/javascript">
			var tipo_usuario_id = "<?php echo($_SESSION['usuario']['tipo_usuario_id']); ?>"
			localStorage.setItem("tipo_usuario_id", tipo_usuario_id);
		</script>

		<div id="principal">
			<header>
				<div id="logo"></div>
				<label class="tit"> Dashboard </label>
			</header>

			<div id="perfil_responsavel" name="<?php echo($_SESSION['usuario']['tipo_usuario_id']); ?>">
				<div id="foto"
					style="background:url(<?php echo $foto; ?>) center / cover no-repeat">
					
				</div>
				<div id="info">
					<span id="nome"> <?php echo $nome; ?> </span>
					<span id="email"> <?php echo $email ?> </span>
					
					<a href="login.php?m=alsl&id=<?php echo $usuario_id;?>" class="btn alterar"> Alterar senha </a>
					<a href="api/logout.php" class="btn logout"> Logout </a>
				</div>

			</div>
			
			<div id="opcoes">
				<div class="card_opcao" id="usuario">
					<div class="icone fa fa-users"></div>
					<span class="tit_card"> Gerenciamento de usuário </span>
				</div>

				<div class="card_opcao" id="empresa">
					<div class="icone fa fa-building-o"></div>
					<span class="tit_card"> Gerenciamento de empresas </span>
				</div>

				<?php 
					if($_SESSION['usuario']['tipo_usuario_id'] == 8) {
				?>
					<div class="card_opcao" id="documentos">
						<div class="icone fa fa-file-text-o"></div>
						<span class="tit_card"> Gerenciamento de documentos </span>
					</div>
				<?php } ?>

				<div class="card_opcao" id="lista_acesso">
					<div class="icone fa fa-building-o"></div>
					<span class="tit_card">Lista de acessos</span>
				</div>
			</div>
		</div>
	</body>
</html>