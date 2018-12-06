<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Usuários cadastrados </title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/acesso_usuario.css?0">

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

				<div class="loader" v-on:click="atualizarLista()">
					<div class="loader_circulo"></div>
					<span>carregando</span>
				</div>

				<div id="lista">
					<div id="pesquisa">
						<input type="text" name="txt_pesquisa" id="campo_pesquisa" autofocus placeholder="Pesquise pelo nome ou data de registro"/>
						<i class="fa fa-search" id="botao_pesquisa"></i>

						<!-- <div id="lbl_tipo_usuario">Tipo de usuário</div> -->
						<select id="lista_tipo_usuario">
							<option value="">todos</option>
							<option value="4">visitantes</option>
							<option value="1">funcionários</option>
						</select>
					</div>

					<!-- Mensagem de pesquisa sem resultado -->
					<div class="nada_encontrado">Nada encontrado</div>

					<div v-for="(acesso, i) of lista_acesso" class="linha_principal">

						<!-- Data -->
						<div v-if="mostrarData(acesso.data) || i == 0" v-bind:id="i + '_data'" class="data">{{acesso.data}}</div>

						<!-- Item da lista -->
						<div class="linha" v-on:click="expandirLinha($event)" v-bind:class="liberacaoStyle(acesso.liberacao)">

							<div class="esquerda">
								<div class="img_usuario" v-bind:style="{backgroundImage: backgroundImageUrl(acesso.foto_usuario)}"></div>
								<div class="traco"></div>
								<div class="tipo_usuario">{{acesso.tipo_usuario}}</div>
							</div>

							<div class="direita">

								<div class="sub">
									<div class="item">usuário</div>
									<div class="cont nome_usuario">{{acesso.usuario}}</div>

									<div class="item">hora</div>
									<div class="cont">{{acesso.hora}}</div>

									<div class="item">empresa</div>
									<div class="cont">{{acesso.empresa}}</div>

									<div class="item">email (empresa)</div>
									<div class="cont">{{acesso.email_empresa}}</div>
								</div>

								<div class="sub">
									<div class="item">ação</div>
									<div class="cont">{{acesso.tipo_acao}}</div>

									<div class="item">tipo de locomoção</div>
									<div class="cont">{{acesso.tipo_locomocao}}</div>

									<div class="item" v-if="acesso.telefone_empresa != null">telefone (empresa)</div>
									<div class="cont">{{acesso.telefone_empresa}}</div>
								</div>
							</div>
						</div>
					</div>

					<div class="load_lista">Carregando ...</div>
				</div>

				<div id="linha_tempo">
					<div class="linha_titulo">Ir Para</div>
					<div v-for="(acesso, i) of lista_acesso" v-if="mostrarDataLinha(acesso.data)" v-bind:id="i" v-on:click="scrollData($event)" class="linha_data">{{acesso.data}}</div>
				</div>
			</div>

			<div id="logoSextou"></div>
		</div>
	</body>
</html>