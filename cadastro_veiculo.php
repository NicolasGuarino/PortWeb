<?php
	include "api/conexao.php";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Cadastro de veiculos </title>
	
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/cadastro_veiculo.css">
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"	></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/cadastro_veiculo.js"></script>	
		<script type="text/javascript" src="js/editar_veiculo.js"></script>	
	</head>
	
	<body>
		<body>
		<div id="principal">
			<!-- HEADER -->
			<header>
				<div id="logo"></div>
				<label> Gerenciamento de usuários </label>

				<?php include "fragments/menu.php" ?>
			</header>


			<div id="conteudo">
				<div class="container" id="login_container">
					<div class="container_logo"></div>
					<span class="container_tit"> Cadastro de veiculos </span>

					<form name="frm_cadastro_veiculo" method="post" action="cadastro_veiculo.php">
						<div id="form_esquerda">
							<label class="lbl_container"> Placa </label>
							<input type="text" name="txt_placa" placeholder="Placa" class="form_txt" id="placa" maxlength="8" />

							<label class="lbl_container"> Marca </label>
							<input type="text" name="txt_marca" placeholder="Marca" class="form_txt" id="marca" />

							<label class="lbl_container"> Modelo </label>
							<input type="text" name="txt_modelo" placeholder="Modelo" class="form_txt" id="modelo" />
						</div>

						<div id="form_direita">
							<label class="lbl_container"> Cor </label>			
							<input type="text" name="txt_cor" placeholder="Cor" class="form_txt" id="cor" />

							<label class="lbl_container"> Documento </label>
							<select name="cbo_documento" class="form_cbo" id="documento">
								<option value="0"> Selecione um documento </option>

								<?php
									$conexao = conectar();
									$query  = "select *, d.documento_id as documento_id from documento as d ";
									$query .="left join usuario as u on(d.documento_id=u.documento_id) ";
									$query .="left join veiculo as v on(v.documento_id=d.documento_id) ";
									$query .="where isnull(u.usuario_id) and isnull(v.veiculo_id) and substring(numero_etiqueta, 1,1) = 'A';";

									$select = mysqli_query($conexao, $query);

									while($rs = mysqli_fetch_array($select)) {
								?>
									<option value="<?php echo($rs['documento_id']);?>"> <?php echo($rs['numero_etiqueta']);?> </option>
								<?php
									}
								?>
							</select>

							<label class="lbl_container"> Foto </label>
							<div class="upload_arquivo">
								<div id="nome_arquivo"></div>
								<i class="fa fa-cloud-upload" id="botao_upload"></i>
							</div>
							
							<input type="file" name="arquivo_foto" class="file" id="arquivo_foto"/>
						</div>

						<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>