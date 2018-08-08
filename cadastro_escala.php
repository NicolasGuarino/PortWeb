<?php
	include "api/conexao.php";
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Cadastro de escala </title>
	
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/cadastro_escala.css">
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"	></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/cadastro_escala.js"></script>
	</head>
	
	<body>
		<div id="principal" name="<?php echo(@$_SESSION['usuario']['empresa_id']); ?>">
			<!-- HEADER -->
			<header>
				<div id="logo"></div>
				<label> Escala </label>

				<?php include "fragments/menu.php" ?>
			</header>

			<div id="conteudo">
				<div class="container" id="login_container">
					<div class="container_logo"></div>
					<span class="container_tit"> Cadastro de escala </span>

					<form name="frm_cadastro_escala" method="post" action="cadastro_escala.php">
						<div id="dias_da_semana">
							<div class="radio_container" id="0">
								<input type="checkbox" name="radio_dia_da_semana" value="0" />
								<div class="radio"></div>
								<label> Seg </label>
							</div>

							<div class="radio_container" id="1">
								<input type="checkbox" name="radio_dia_da_semana" value="1" />
								<div class="radio "></div>
								<label> Ter </label>
							</div>

							<div class="radio_container" id="2">
								<input type="checkbox" name="radio_dia_da_semana" value="2" />
								<div class="radio"></div>
								<label> Qua </label>
							</div>

							<div class="radio_container" id="3">
								<input type="checkbox" name="radio_dia_da_semana" value="3" />
								<div class="radio "></div>
								<label> Qui </label>
							</div>

							<div class="radio_container" id="4">
								<input type="checkbox" name="radio_dia_da_semana" value="4" />
								<div class="radio"></div>
								<label> Sex </label>
							</div>

							<div class="radio_container" id="5">
								<input type="checkbox" name="radio_dia_da_semana" value="5" />
								<div class="radio "></div>
								<label> Sáb </label>
							</div>

							<div class="radio_container" id="6">
								<input type="checkbox" name="radio_dia_da_semana" value="6" />
								<div class="radio "></div>
								<label> Dom </label>
							</div>
						</div>

						<label class="lbl_container"> Horário entrada </label> 
						<input type="time" name="txt_horario_entrada" class="form_txt" id="horario_entrada"/>

						<label class="lbl_container"> Horário saida </label> 
						<input type="time" name="txt_horario_saida" class="form_txt" id="horario_saida"/>

						<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>