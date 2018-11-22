<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Usuários cadastrados </title>

		<link rel="stylesheet" type="text/css" href="css/style.css?04">
		<link rel="stylesheet" type="text/css" href="css/registro_acesso.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<!-- <script type="text/javascript" src="js/registro_acesso.js"></script> -->
	</head>

	<body>
		<div id="principal" name="<?php echo($_SESSION['usuario']['empresa_id']); ?>">
			<header>
				<div id="logo"></div>
				<label> Usuários cadastrados </label>
				<?php include "fragments/menu.php" ?>
			</header>

			<div id="lista_usuarios">
				<div id="pesquisa">
					<input type="text" name="txt_pesquisa" id="campo_pesquisa" placheholder="Pesquisa..."/>
					<i class="fa fa-search" id="botao_pesquisa"></i>
				</div>

				<div class="seta" id="proximo"></div>
				<div class="seta" id="anterior"></div>
				
				<div id="usuarios_ativos">
					<span class="lbl_nada_encontrado"> Nada Encontrado </span>
				</div>
			</div>

			<div id="logoSextou"></div>
		</div>


	</body>
</html>