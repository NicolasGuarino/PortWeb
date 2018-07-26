$(function(){
	loader = new Loader();

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
		var campos_preenchidos = validar_campos_texto(".form_txt") && validar_radio(".radio_prefixo");		

		if(campos_preenchidos) {
			var numero_inicial = $("#txt_num_inicial").val();
			var numero_final   = $("#txt_num_final").val();
			var prefixo 	   = $(".radio_prefixo:checked").val();

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("numero_inicial", numero_inicial);
			formData.append("numero_final", numero_final);
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
		}
			
	});
});

function tratar_resultado_envio(resultado){
	if(resultado == 1) {
		loader.encerrar("img/icones/ic_okay.png", "Documento cadastrado com sucesso");

    	$(".form_txt").val("");
    	$(".radio_prefixo").prop("checked", false);
    	$(".fake_checkbox").removeClass("fake_checkbox_active");
    }else{
    	loader.encerrar("img/icones/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}
