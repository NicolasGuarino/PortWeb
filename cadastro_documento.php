<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Cadastro de documentos </title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/cadastro_documento.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/cadastro_documento.js"></script>	
	</head>
	
	<body>
		<div id="principal">
			<!-- HEADER -->
			<header>
				<div id="logo"></div>
				<label> Cadastro de documentos </label>

				<?php include "fragments/menu.php" ?>
			</header>

			<div id="conteudo">
				<div class="container">
					<div class="container_logo"></div>
					<div class="container_tit"> Cadastro de documentos </div>

					<form name="frm_cadastro_documento" method="post" action="cadastro_documento.php">
						<label class="lbl_container"> Quantidade de documentos </label>
						<input type="number" min='0' name="txt_qtde" placeholder="0"class="form_txt" id="qtde"/>

						<div class="radio_box">
							<div class="form_chb"> 
								<input type="radio" name="radio_prefixo" class="real_checkbox radio_prefixo" value="C"/>
								<div class="fake_checkbox" id="mostrar_senha"></div>
								<label class="lbl_checkbox"> Funcionário </label>
							</div>

							<div class="form_chb"> 
								<input type="radio" name="radio_prefixo" class="real_checkbox radio_prefixo" value="A"/>
								<div class="fake_checkbox" id="mostrar_senha"></div>
								<label class="lbl_checkbox"> Veiculo </label>
							</div>
						</div>
						

						<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>