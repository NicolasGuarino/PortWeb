<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Lista de acesso</title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/acesso_usuario.css?0">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="assets/js/vue.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script defer type="text/javascript" src="js/acesso_usuario.js"></script>
	</head>

	<body>
		<div id="voltar_topo">
			topo
		</div>

		<div id="principal" name="<?php echo($_SESSION['usuario']['empresa_id']); ?>">
			<header>
				<div id="logo"></div>
				<label> Lista de acesso </label>
				<?php include "fragments/menu.php" ?>
			</header>

			<div id="lista_usuarios">

				<div id="lista">
					<div id="caixa_pesquisa">
						<div id="caixa_pesquisa_centro">

							<div id="pesquisa">
								<div>
									<input v-model="busca.filtro" type="text" name="txt_pesquisa" id="campo_pesquisa" autofocus placeholder="Nome do usuário"/>
									<i class="fa fa-search" id="botao_pesquisa"></i>
								</div>
							</div>

							<div class="btn_filtro" id="btn_ok">ok</div>
							<div v-on:click="adicionarRemoverFiltro()" class="btn_filtro" id="btn_filtro">adicionar filtro</div>
						</div>

						<div id="caixa_filtro">
							<div class="campo">
								<div class="campo_nome">Tipo</div>

								<select class="lista" id="lista_tipo_usuario" v-model="busca.tipo_usuario">
									<option value="1,3,4">todos</option>
									<option value="4">visitantes</option>
									<option value="1,3">funcionários</option>
								</select>
							</div>

							<div class="campo">
								<div class="campo_nome">De</div>
								<input v-model="busca.data_inicio" type="date" id="data_inicio" class="data_campo" />
							</div>

							<div class="campo">
								<div class="campo_nome">Até</div>
								<input v-model="busca.data_termino" type="date" id="data_termino" class="data_campo" />
							</div>

							<div class="campo">
								<div class="campo_nome">Ordenar por</div>

								<select class="lista" id="lista_tipo_usuario" v-model="busca.ordem">
									<option value="null">Nenhuma</option>
									<option value="90">data decrescente</option>
									<option value="09">data crescente</option>
									<option value="az">nome crescente</option>
									<option value="za">nome decrescente</option>
								</select>
							</div>

							<!-- <div v-on:click="limparFiltro()" class="btn_filtro" id="btn_limpar">limpar</div> -->
						</div>

						
						<div class="loader" v-on:click="atualizarLista()">
							<div class="loader_circulo"></div>
							<span>Carregando</span>
						</div>
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
								<div class="tipo_usuario">{{acesso.tipo_usuario}}</div>

								<div class="img_usuario" v-if="acesso.placa != null" v-bind:style="{backgroundImage: backgroundImageUrl(acesso.foto_carro)}"></div>
							</div>

							<div class="direita">

								<div class="sub">
									<div class="item">nome</div>
									<div class="cont nome_usuario">{{acesso.usuario}}</div>

									<div class="item">tipo de locomoção</div>
									<div class="cont">{{acesso.tipo_locomocao}}</div>

									<div v-if="acesso.placa != null"> <!-- Informações do veículo -->
										<div class="item item_tit">veículo</div>
										<div class="item">placa</div>
										<div class="cont">{{acesso.placa}}</div>

										<div class="item">marca</div>
										<div class="cont">{{acesso.marca}}</div>

										<div class="item">modelo</div>
										<div class="cont">{{acesso.modelo}}</div>
									</div>

									<!-- Aviso quando não houver veículo -->
									<div v-if="acesso.placa == null" class="sem_veiculo">Sem veículo</div>
								</div>

								<div class="sub">
									<div class="item">data</div>
									<div class="cont">{{acesso.data}}</div>

									<div class="item">hora</div>
									<div class="cont">{{acesso.hora}}</div>

									<div class="item item_tit">empresa</div>
									<div class="item">nome</div>
									<div class="cont">{{acesso.empresa}}</div>

									<div class="item" v-if="acesso.telefone_empresa != null">telefone</div>
									<div class="cont">{{acesso.telefone_empresa}}</div>

									<div class="item">email</div>
									<div class="cont">{{acesso.email_empresa}}</div>
								</div>

								<div class="sub">
									<div class="img_seta" v-bind:class="acaoClass(acesso.tipo_acao)"></div>
									<div class="texto_acao">{{acesso.tipo_acao}}</div>
								</div>
							</div>
						</div>
					</div>

					<button id="btn_ver_mais" v-if="busca.pagina < qtd_pagina" v-on:click="carregarMais()">ver mais <span>{{busca.pagina}}/{{qtd_pagina}}</span></button>
				</div>
			</div>

			<div id="logoSextou"></div>
		</div>
	</body>
</html>