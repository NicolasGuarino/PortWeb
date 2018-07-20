<?php
	include "api/conexao.php";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Cadastro de usuarios </title>
	
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/cadastro_usuario.css?3">

		<script type="text/javascript" src="js/jquery-2.2.2.js"	></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/cadastro_usuario.js?3"></script>	
	</head>
	
	<body>
		<body>
		<div id="corpo">
			<!-- HEADER -->
			<header>
				<div id="us_info">
					<span class="us_item"> Portaria	</span>
					<span class="us_item" id="us_tipo"> Cadastro de usuarios </span>
				</div>

				<div id="centro">
					<div id="logo"> <!-- Logo --> </div>
				</div>

			</header>

			<div id="conteudo">
				<span class="tit"> Cadastro de usuarios </span>

				<div id="formulario_cadastro">
					<form name="frm_cadastro_empresa" method="post" action="cadastro_empresa.php">

						<div id="form_esquerda">
							<h4 style="text-align:center;color:#555;display:block;margin:0 0 10px 0;"> Usuário </h4>

							<input type="text" name="txt_nome" placeholder="Nome" class="form_txt" id="nome"/>
							<input type="text" name="txt_cpf" placeholder="RG" class="form_txt" id="rg" maxlength="12" />

							<select name="cbo_documento" class="form_cbo" id="documento">
								<option value="0"> Selecione um documento </option>

								<?php
									$conexao = conectar();

									$query  = "select *, d.documento_id as documento_id from documento as d ";
									$query .="left join usuario as u on(d.documento_id=u.documento_id) ";
									$query .="left join veiculo as v on(v.documento_id=d.documento_id) ";
									$query .="where isnull(u.usuario_id) and isnull(v.veiculo_id) and substring(numero_etiqueta, 1,1) <> 'A';";
									$select = mysqli_query($conexao, $query);

									while($rs = mysqli_fetch_array($select)) {
								?>
									<option value="<?php echo($rs['documento_id']);?>"> <?php echo($rs['numero_etiqueta']);?> </option>
								<?php
									}
								?>
							</select>
						</div>

						<div id="form_direita">
							<h4 style="text-align:center;color:#555;display:block;margin:0 0 10px 0;"> Empresa </h4>

							<input type="text" name="txt_empresa" placeholder="Razão social" class="form_txt" id="empresa"/>
							<input type="email" name="txt_email" placeholder="Email" class="form_txt" id="email" />
							<input type="text" name="txt_tel" placeholder="Telefone/Celular" class="form_txt" id="tel" maxlength="14" />
						</div>
						
						<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>