$(function(){
	imagem = null;
	loader = new Loader();
	notificacao = new Notificacao();


	$("#telefone").on("keyup keydown", mascara_tel);

	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt");
			
		var nome = $("#nome").val();
		var telefone = $("#telefone").val();
		var email = $("#email").val();

		var img_ok = validar_campo(imagem != null, $("#nome_arquivo").parent(), "#ff2233", "#aaa");
		var tel_ok = validar_campo(eTel(telefone), $("#telefone"), "#ff2233", "#aaa");
		var email_ok = validar_campo(eEmail(email), $("#email"), "#ff2233", "#aaa");

		if(campos_preenchidos && tel_ok && email_ok) {
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
			notificacao.mostrar("Erro! ", "Preencha todos os campos corretamente", "erro", $("#principal"), 1500);
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
				notificacao.mostrar("Erro! ", "Extensão inválida", "erro", $("#principal"), 1500);
			}else{
				imagem = this.files[0];

				$("#nome_arquivo").text(arquivo);
			}
		}else{
			$("#nome_arquivo").text("");
			imagem = null;
		}
	});

	$("#voltar").click(function(){
		window.location = "empresas_lista.php";
	});
});


function retorna_extensao(arquivo) {
	var ext = arquivo.type.toString();
	ext = ext.substring(ext.indexOf("/") + 1);

	return ext;
}

function tratar_resultado_envio(resultado){
	if(resultado == 1) {
		var texto = "Empresa cadastrada com sucesso";
		if(retorna_parametro_url("modo")) texto = "Empresa editada com sucesso";

		loader.encerrar("img/icones/ic_okay.png", "Empresa cadastrada com sucesso");

    	$(".form_txt").val("");
    	$("#nome_arquivo").text("");
    	imagem = null;

		setTimeout(function(){ window.location = "empresas_lista.php" }, 2500);
    }else{
    	loader.encerrar("img/icones/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}