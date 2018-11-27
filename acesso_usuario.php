<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Usuários cadastrados </title>

		<link rel="stylesheet" type="text/css" href="css/style.css?04">
		<link rel="stylesheet" type="text/css" href="css/acesso_usuario.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="assets/js/vue.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script defer type="text/javascript" src="js/acesso_usuario.js"></script>
	</head>

	<body>
		<div id="principal" name="<?php echo($_SESSION['usuario']['empresa_id']); ?>">
			<header>
				<div id="logo"></div>
				<label> Lista de acesso </label>
				<?php include "fragments/menu.php" ?>
			</header>

			<div id="lista_usuarios">
				<div class="loader">
					carregando ...
					<!-- <div class="circulo"></div> -->
				</div>

				<div id="pesquisa">
					<input type="text" name="txt_pesquisa" id="campo_pesquisa" autofocus placeholder="Pesquise pelo nome ou data de registro"/>
					<i class="fa fa-search" id="botao_pesquisa"></i>
					
				</div>

				<div id="lista">

					<div v-for="acesso of lista_acesso" class="linha" v-bind:class="liberacaoStyle(acesso.liberacao)">
						<div class="esquerda">
							<!-- <div class="img_usuario" v-bind:style="{backgroundImage: backgroundImageUrl(acesso.foto_usuario)}"></div> -->
							<div class="img_usuario" v-bind:style="{backgroundImage: backgroundImageUrl(acesso.foto_usuario)}"></div>
						</div>

						<div class="direita">

							<div class="sub">
								<div class="item">usuário</div>
								<div class="cont">{{acesso.usuario}}</div>

								<div class="item">empresa</div>
								<div class="cont">{{acesso.empresa}}</div>

								<div class="item">email (empresa)</div>
								<div class="cont">{{acesso.email_empresa}}</div>

								<div class="item">telefone (empresa)</div>
								<div class="cont">{{acesso.telefone_empresa}}</div>
							</div>

							<div class="sub">
								<div class="item">tipo de locomoção</div>
								<div class="cont">{{acesso.tipo_locomocao}}</div>

								<div class="item">ação</div>
								<div class="cont">{{acesso.tipo_acao}}</div>

								<div class="item">data</div>
								<div class="cont">{{acesso.data}}</div>

								<div class="item">hora</div>
								<div class="cont">{{acesso.hora}}</div>
							</div>

							<div class="sub">
								<div class="img_liberacao" v-bind:class="liberacaoClass(acesso.liberacao)"></div>
								<div v-if="acesso.liberacao" class="cont">liberado</div>
								<div v-else="acesso.liberacao" class="cont">bloqueado</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="logoSextou"></div>
		</div>
	</body>
</html>