<?php
	include "api/conexao.php";
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Cadastro de usuarios </title>
	
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/cadastro_usuario.css">
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"	></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/cadastro_usuario.js"></script>
		<script type="text/javascript" src="js/editar_usuario.js"></script>
		<script type="text/javascript" src="js/editar_escala.js"></script>
	</head>
	
	<body>
		<div id="background_escala">
			<div id="container">
				<form name="frm_escala" method="post" id="frm_escala">
					<i class="fa fa-times fechar"></i>
					<label class="tit_edicao"> Segunda</label>

					<label class="lbl_form"> Horário entrada: </label> <input type="time" name="txt_entrada" class="time_txt escala" id="entrada">
					<label class="lbl_form"> Horário saída: </label> <input type="time" name="txt_saida" class="time_txt escala" id="saida">

					<input type="submit" name="btn_salvar" value="Salvar" class="form_btn" id="btn_salvar" />
				</form>

				<form name="frm_excecao" method="post" id="frm_excecao">
					<i class="fa fa-times fechar"></i>
					<label class="tit_edicao"> Exceção </label>

					<label class="lbl_form"> Data: </label> <input type="date" name="txt_diaExcecao" class="time_txt excecao" id="diaExcecao">
					<label class="lbl_form"> Horário entrada: </label> <input type="time" name="txt_entradaExcecao" class="time_txt excecao" id="entradaExcecao">
					<label class="lbl_form"> Horário saída: </label> <input type="time" name="txt_saidaExcecao" class="time_txt excecao" id="saidaExcecao">

					<input type="submit" name="btn_adicionarExcecao" value="Adicionar" class="form_btn" id="btn_adicionarExcecao" />
				</form>
			</div>
		</div>

		<div id="principal" name="<?php echo $_SESSION['usuario']['empresa_id'] ?>">
			<!-- HEADER -->
			<header>
				<div id="logo"></div>
				<label> Gerenciamento de usuários </label>

				<?php include "fragments/menu.php" ?>
			</header>

			<div id="conteudo">
				<div class="container" id="login_container">
					<!-- <div class="container_logo"></div> -->

					<span class="container_tit"> 
						
						<i class="fa fa-chevron-circle-left" id="voltar"></i>
						<span class="texto"> Cadastro de usuário </span>
					</span>

					<form name="frm_cadastro_usuario" method="post" id="form_user">
						<div id="form_esquerda">
							<label class="lbl_container"> Nome </label>
							<input type="text" name="txt_nome" placeholder="Nome" class="form_txt" id="nome"/>

							<label class="lbl_container"> CPF </label>
							<input type="text" name="txt_cpf" placeholder="CPF" class="form_txt" id="cpf" maxlength="14" />

							<label class="lbl_container"> RG </label>
							<input type="text" name="txt_rg" placeholder="RG" class="form_txt" id="rg" maxlength="12" />

							<label class="lbl_container"> Email </label>
							<input type="email" name="txt_email" placeholder="Email" class="form_txt" id="email" />

							<label class="lbl_container"> Telefone/Celular </label>
							<input type="text" name="txt_tel" placeholder="Telefone/Celular" class="form_txt" id="tel" maxlength="14" />	
						</div>

						<div id="form_direita">
							<label class="lbl_container"> Data de nascimento </label>
							<input type="date" name="txt_dt_nascimento" placeholder="aaaa-mm-dd" class="form_txt" id="dt_nascimento"/>

							<?php 
								if($_SESSION['usuario']['tipo_usuario_id'] == 8) {
							?>
								<label class="lbl_container"> Empresa </label>
								<select name="cbo_documento" class="form_cbo" id="empresa">
									<option value="0"> Selecione uma empresa </option>

									<?php
										$conexao = conectar();

										$query  = "select * from empresa where ativo = 1;";
										$select = mysqli_query($conexao, $query);

										while($rs = mysqli_fetch_array($select)) {
									?>
										<option value="<?php echo($rs['empresa_id']);?>"> <?php echo($rs['nome']);?> </option>
									<?php
										}
									?>
								</select>

								<label class="lbl_container"> Tipo de usuário </label>
								<select name="cbo_tipo" class="form_cbo" id="tipo">
									<option value="0"> Selecione um tipo de usuario </option>

									<?php
										$query = "select * from tipo_usuario;";
										$select = mysqli_query($conexao, $query);
										session_start();
										while($rs = mysqli_fetch_array($select)) {
											if($rs['tipo_usuario_id'] != 8 || $_SESSION['usuario']['tipo_usuario_id'] == 8) {
									?>
										<option value="<?php echo($rs['tipo_usuario_id']);?>"> <?php echo($rs['nome']);?> </option>
									<?php
											}
										}
										mysqli_close($conexao);
									?>
								</select>
							<?php } ?>

							<label class="lbl_container"> Foto </label>
							<div class="upload_arquivo">
								<div id="nome_arquivo"></div>
								<i class="fa fa-cloud-upload" id="botao_upload"></i>
							</div>
							
							<input type="file" name="arquivo_foto" class="file" id="arquivo_foto"/>
						</div>

						<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
					</form>

				<?php require_once "fragments/info_usuario.php" ?>
			</div>

	</body>
</html>