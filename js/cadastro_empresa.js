$(function(){
	imagem = null;
	loader = new Loader();

	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt") && (imagem != null);

		if(campos_preenchidos) {
			var nome = $("#nome").val();
			
			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("nome", nome);
			formData.append("imagem", imagem);

			$.ajax({
				url: "api/inserir_empresa.php",
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,                    
                beforeSend: loader.iniciar(),
                success: tratar_resultado_envio
			});
		}
			
	});


	$("#botao_upload").click(function(e){
		e.preventDefault();
		$("#arquivo_foto").trigger("click"); 
	});

	$("#arquivo_foto").change(function(){
		var arquivo, ext, lst_ext_permitidas;
		
		if(this.files[0]) {
			arquivo = this.files[0].name;
			ext = retorna_extensao(this.files[0]);
			lst_ext_permitidas = ['png', 'jpg', 'jpeg'];

			if($.inArray(ext.toLowerCase(), lst_ext_permitidas) == -1) {
				alert("Extensão inválida");
			}else{
				imagem = this.files[0];

				$("#nome_arquivo").text(arquivo);
			}
		}else{
			$("#nome_arquivo").text("");
			imagem = null;
		}
		

	});
});

function retorna_extensao(arquivo) {
	var ext = arquivo.type.toString();
	ext = ext.substring(ext.indexOf("/") + 1);

	return ext;
}

function tratar_resultado_envio(resultado){
	if(resultado == 1) {
		loader.encerrar("img/ic_okay.png", "Empresa cadastrada com sucesso");

    	$("#nome").val("");
    	$("#nome_arquivo").text("");
    	imagem = null;
    }else{
    	loader.encerrar("img/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}