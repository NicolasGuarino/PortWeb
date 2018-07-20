<?php
	include "api/conexao.php";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Usuários cadastrados </title>
	
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/lista_usuarios_cadastrados.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"	></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/lista_usuarios_cadastrados.js"></script>	
	</head>
	
	<body>
		<body>
		<div id="corpo">
			<div id="background">
				<div id="caixa_detalhes">
					<div id="modal_header">
						<span class="tit"> Detalhes </span>
						<span id="fechar"></span>
					</div>

					<div id="modal_conteudo">
							<div id="foto">
								<div class="editar"></div>
								<div class="excluir"></div>
							</div>

							<span class="texto_destaque"> Nome: </span> <span class="texto">  </span>
							<span class="texto_destaque"> CPF: </span> <span class="texto">  </span>
							<span class="texto_destaque"> Email: </span> <span class="texto">  </span>
							
							<span class="texto_destaque"> Veiculos: </span> <span class="texto"> </span>
							<a class="adicionar" id="add_veiculo" href="cadastro_veiculo.php"> + </a>

							<span class="texto_destaque escala_titulo"> Escala </span> 
							<a class="adicionar" id="add_escala" href="cadastro_escala.php"> + </a>
							<div id="escala">
								<div class="dia" id="dia_0"> Seg </div>
								<div class="dia" id="dia_1"> Ter </div>
								<div class="dia" id="dia_2"> Qua </div>
								<div class="dia" id="dia_3"> Qui </div>
								<div class="dia" id="dia_4"> Sex </div>
								<div class="dia" id="dia_5"> Sab </div>
								<div class="dia" id="dia_6"> Dom </div>
							</div>
					</div>
				</div>
			</div>
			<!-- HEADER -->
			<header>
				<div id="us_info">
					<span class="us_item"> Portaria	</span>
					<span class="us_item" id="us_tipo"> Usuários cadastrados </span>
				</div>

				<div id="centro">
					<div id="logo"> <!-- Logo --> </div>
				</div>

			</header>

			<div id="conteudo">
				<div class="tit"> Lista de usuarios </div>


				<!-- Filtro de pesquisa -->
				<div id="pesquisa_texto" class="caixa_filtro filtro_pesquisa">
					<div class="img_pesq"></div>
					<input type="text" class="form_txt item_filtro" placeholder="Pesquisar" />
				</div>

				<div id="tbl_usuarios"></div>
			</div>
		</div>
	</body>
</html>