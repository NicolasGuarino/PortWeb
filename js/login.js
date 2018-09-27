$(function() {
	loader = new Loader();
	notificacao = new Notificacao();

	if(retorna_parametro_url("id")) {
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
				url: "api/autenticacao_web.php",
				data: {usuario: email, senha: senha}
			}).done(function(resultado_json){
				var resultado = $.parseJSON(resultado_json);

				if(tratar_retorno(resultado, "Login realizado com sucesso", "Certifique-se que digitou o usuário e senha correto")) {
					setTimeout(function(){ window.location = "dashboard.php"; }, 2200);
				}
			});
		}else{
			notificacao.mostrar("Erro! ", "Por favor, preencha todos os campos", "erro", $("#principal"), 1500);
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
			notificacao.mostrar("Erro! ", "Por favor, preencha todos os campos", "erro", $("#principal"), 1500);
		}
	});


	// ALTERAR SENHA
	$("#btn_alterar").click(function(){
		var nova_senha = $("#nova_senha").val();
		var confirmar_senha = $("#confirmar_senha").val();
		var usuario_id = retorna_parametro_url("id");

		var campos_preenchidos = nova_senha != "" && confirmar_senha != "";
		var campos_validos 	= nova_senha == confirmar_senha;

		if(campos_preenchidos && campos_validos) {
			loader.iniciar();

			$.ajax({
				url: "api/alterar_senha.php",
				data: {senha:nova_senha, usuario_id:usuario_id}
			}).done(function(resultado_json){
				var resultado = $.parseJSON(resultado_json);

				if(tratar_retorno(resultado, "Senha alterada com sucesso", "Ocorreu algum erro")) {
					if(retorna_parametro_url("m") == "alsl") {
						window.location = "dashboard.php";
					}else{
						$("#recuperar_senha_container").fadeOut(500);
						setTimeout(function() { $("#login_container").css("display", 'table'); }, 600);
					}
				}
			});
		}else{
			if(!campos_preenchidos) notificacao.mostrar("Erro! ", "Por favor, preencha todos os campos", "erro", $("#principal"), 1500);
			else if(!campos_validos) notificacao.mostrar("Erro! ", "As senhas precisam ser iguais", "erro", $("#principal"), 1500);
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
		loader.encerrar("img/icones/ic_okay.png", texto_positivo);
    }else{
    	loader.encerrar("img/icones/ic_erro.png", texto_negativo);
    	console.log(retorno);
	}

	return retorno.valor;
}
