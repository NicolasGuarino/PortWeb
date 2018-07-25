<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Usuários cadastrados </title>

		<link rel="stylesheet" type="text/css" href="css/style.css?04">
		<link rel="stylesheet" type="text/css" href="css/usuarios_cadastrados_lista.css?04">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="js/usuarios_cadastrados_lista.js?59"></script>
	</head>

	<body>
		<div id="principal">
			<header>
				<div id="logo"></div>
				<label> Usuários cadastrados </label>

				<a href="dashboard.php" id="ic_home" class="fa fa-home"> Dashboard </a>
			</header>

			<div class="container_contador">
				<div class="icone"></div>
				<label> Usuários cadastrados </label>

				<div class="qtde_usuarios">
					<label> 0 </label>
				</div>
			</div>

			<a href="cadastro_usuario.php" id="add_user" class="fa fa-plus"></a>
			

			<div id="lista_usuarios">
				<div id="pesquisa">
					<input type="text" name="txt_pesquisa" id="campo_pesquisa" placheholder="Pesquisa..."/>
					<i class="fa fa-search" id="botao_pesquisa"></i>
				</div>

				<div class="seta" id="proximo"></div>
				<div class="seta" id="anterior"></div>
				
				<div id="usuarios_ativos"></div>
			</div>

			<div id="logoSextou"></div>
		</div>


	</body>
</html>