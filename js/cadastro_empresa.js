$(function(){
	imagem = null;
	loader = new Loader();


	$("#telefone").on("keyup keydown", function(){
		var tel = $(this).val();
		
		if(tel.length <= 14) {
			tel = tel.replace(/\D*/g, "");
			tel = tel.replace(/(\d{2})(\d{4,5})(\d{4})/g, "($1)$2-$3");

			$(this).val(tel);	
		}else{
			$(this).val(tel.substring(0,12));
		}
		
	});

	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt") && (imagem != null);
			
		if(campos_preenchidos && eTel($("#telefone").val())) {
			var nome = $("#nome").val();
			var telefone = $("#telefone").val();
			var email = $("#email").val();
			
			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("nome", nome);
			formData.append("telefone", telefone);
			formData.append("email", email);
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
		}else{
			alert("Preencha todos os campos corretamente");
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
		loader.encerrar("img/icones/ic_okay.png", "Empresa cadastrada com sucesso");

    	$("#nome").val("");
    	$("#nome_arquivo").text("");
    	imagem = null;
    }else{
    	loader.encerrar("img/icones/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}