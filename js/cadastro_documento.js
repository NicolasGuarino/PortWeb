$(function(){
	loader = new Loader();
	notificacao = new Notificacao();


	$(".fake_checkbox").click(function() {
		$(".fake_checkbox_active").removeClass("fake_checkbox_active");
		$(this).toggleClass("fake_checkbox_active");

		if($(this).hasClass("fake_checkbox_active")) {
			$(this).prev().prop("checked", true);
		}else{
			$(this).prev().prop("checked", false);
		}
	});


	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var textoOk = validar_campos_texto(".form_txt");
		var radioOk = validar_radio(".radio_prefixo");

		var campos_preenchidos = textoOk && radioOk;
		
		if(campos_preenchidos) {
			var qtde = $("#qtde").val();
			var prefixo = $(".radio_prefixo:checked").val();

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("qtde", qtde);
			formData.append("prefixo", prefixo);

			$.ajax({
				url: "api/inserir_documento.php",
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,                    
                beforeSend: loader.iniciar(),
                success: tratar_resultado_envio
			});
		}else{
			notificacao.mostrar("Erro! ", "Por favor preencha todos os campos", "erro", $("#conteudo"), 2500);
		}
			
	});
});

function tratar_resultado_envio(resultado){
	resultado = JSON.parse(resultado);
	if(resultado == 1) {
		loader.encerrar("img/icones/ic_okay.png", "Documento cadastrado com sucesso");

    	$(".form_txt").val("");
    	$(".radio_prefixo").prop("checked", false);
    	$(".fake_checkbox").removeClass("fake_checkbox_active");
    }else{
    	loader.encerrar("img/icones/ic_erro.png", "Ocorreu algum erro");
    }
}
