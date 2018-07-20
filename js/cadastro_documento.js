$(function(){
	loader = new Loader();

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
		loader.encerrar("img/ic_okay.png", "Documento cadastrado com sucesso");

    	$("#nome").val("");
    	imagem = null;
    }else{
    	loader.encerrar("img/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}
