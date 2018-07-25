<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Portaria - Login </title>

		<link rel="stylesheet" type="text/css" href="css/login.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="js/login.js?0"></script>
		<script type="text/javascript" src="js/script.js"></script>
	</head>

	<body>
		<div id="corpo">
			<div class="container" id="login_container">
				<div id="logo"></div>
				<span id="login_tit"> Login </span>

				<form name="frm_login" method="post">
					<label class="lbl_login"> Email </label>
					<input type="email" name="txt_login" placeholder="nome@dominio.com" class="form_txt" id="email"/>

					<label class="lbl_login"> Senha </label>
					<input type="password" name="txt_senha" placeholder="senha" class="form_txt" id="senha" />

					<div class="form_chb"> 
						<input type="checkbox" name="cbo_mostrarSenha" class="real_checkbox"> 
						<div class="fake_checkbox" id="mostrar_senha"></div>
						<label class="lbl_checkbox"> Mostrar senha </label>
					</div>

					<input type="submit" name="btn_login" class="form_btn" id="btn_login" value="Login" />

					<label class="lbl_info" id="esqueceu_senha"> Esqueceu sua senha? </label>
				</form>
			</div>

			<div class="container" id="enviar_email_container">
				<div id="logo"></div>
				<span id="login_tit"> Recuperar senha </span>

				<form name="frm_enviarEmail" method="post">
					<label class="lbl_login"> Email </label>
					<input type="email" name="txt_email" placeholder="nome@dominio.com" class="form_txt" id="email_recuperar"/>

					<input type="submit" name="btn_enviar" class="form_btn" id="btn_enviar" value="Enviar"/>

					<label class="lbl_info" id="voltar"> <i class="fa fa-arrow-circle-left"></i> Voltar </label>
				</form>
			</div>

			<div class="container" id="recuperar_senha_container">
				<div id="logo"></div>
				<span id="login_tit"> Recuperar senha </span>

				<label class="lbl_login"> Nova senha </label>
				<input type="password" name="txt_senha" placeholder="nova senha" class="form_txt" id="nova_senha" />

				<label class="lbl_login"> Confirmar senha </label>
				<input type="password" name="txt_senhaConfirmar" placeholder="confirmar senha" class="form_txt" id="confirmar_senha" />

				<div class="form_chb"> 
					<input type="checkbox" name="cbo_mostrarSenha" class="real_checkbox"> 
					<div class="fake_checkbox" id="mostrar_senha"></div>
					<label class="lbl_checkbox"> Mostrar senhas </label>
				</div>

				<input type="submit" name="btn_alterar" class="form_btn" id="btn_alterar" value="Alterar"/>
			</div>
		</div>
	</body>
</html>