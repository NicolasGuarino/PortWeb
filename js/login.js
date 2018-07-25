$(function() {
	loader = new Loader();

	if(url_param("id")) {
		$("#login_container").fadeOut(600);
		setTimeout(function() { $("#recuperar_senha_container").css("display", 'table'); }, 600)
	}

	$(".fake_checkbox").click(function() {
		$(this).toggleClass("fake_checkbox_active");

		if($(this).hasClass("fake_checkbox_active")) {
			$("input[type='password']").addClass("ativa");
			$("input[type='password']").attr("type", "text");
		}else{
			$(".ativa").attr("type", "password");
			$("input[type='password']").removeClass("ativa");
		}
	});

	// FAZER LOGIN
	$("#btn_login").click(function(e){
		e.preventDefault();

		var email = $("#email").val();
		var senha = $("#senha").val();

		if(email != "" && senha != "") {
			loader.iniciar();	

			$.ajax({
				url: "api/autenticacao.php",
				data: {usuario: email, senha: senha}
			}).done(function(resultado_json){
				var resultado = $.parseJSON(resultado_json);

				if(tratar_retorno(resultado, "Login realizado com sucesso", "Certifique-se que digitou o usuário e senha correto")) {
					setTimeout(function(){ window.location = "menu_principal.php"; }, 2200);
				}
			});
		}else{
			alert("Por favor, preencha todos os campos");
		}
	});

	// ENVIAR EMAIL PARA ALTERAR A SENHA
	$("#btn_enviar").click(function(){
		var email_recuperar = $("#email_recuperar").val();

		if(email_recuperar != "") {
			loader.iniciar();

			$.ajax({
				url: "api/enviar_email_senha.php",
				data: {email:email_recuperar}
			}).done(function(resultado_json) {
				var resultado = $.parseJSON(resultado_json);

				if(tratar_retorno(resultado, "Email enviado com sucesso", "Ocorreu algum erro")) {
					$("#voltar").trigger("click");
				}
			});
		}else{
			alert("Por favor, preencha todos os campos");
		}
	});


	// ALTERAR SENHA
	$("#btn_alterar").click(function(){
		var nova_senha = $("#nova_senha").val();
		var confirmar_senha = $("#confirmar_senha").val();
		var usuario_id = url_param("id");

		if(nova_senha != "" && confirmar_senha != "" && nova_senha == confirmar_senha) {
			loader.iniciar();

			$.ajax({
				url: "api/alterar_senha.php",
				data: {senha:nova_senha, usuario_id:usuario_id}
			}).done(function(resultado_json){
				var resultado = $.parseJSON(resultado_json);

				if(tratar_retorno(resultado, "Senha alterada com sucesso", "Ocorreu algum erro")) {
					$("#recuperar_senha_container").fadeOut(500);
					setTimeout(function() { $("#login_container").css("display", 'table'); }, 600)
				}
			});
		}else{
			alert("Por favor, preencha todos os campos corretamente");
		}
	});


	$("#esqueceu_senha").click(function() {
		var primeiro_container = $(".container")[0];

		$(primeiro_container).fadeOut(500);
		setTimeout(function() { $(primeiro_container).next().css("display", 'table') }, 600);
		$("#email_recuperar").val($("#email").val());
	});

	$("#voltar").click(function() {
		var primeiro_container = $(".container")[0];

		$(primeiro_container).next().fadeOut(500);
		setTimeout(function() { $(primeiro_container).css("display", 'table'); }, 600)
	});
});

function tratar_retorno(retorno, texto_positivo, texto_negativo) {
	if(retorno.valor) {
		loader.encerrar("img/ic_okay.png", texto_positivo);
    }else{
    	loader.encerrar("img/ic_erro.png", texto_negativo);
    	console.log(retorno);
	}

	return retorno.valor;
}
