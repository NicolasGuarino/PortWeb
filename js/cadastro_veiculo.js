$(function(){
	imagem = null;
	loader = new Loader();
	notificacao = new Notificacao();

	var usuario = retorna_parametro_url("id");
	cpf = retorna_parametro_url("cpf");

	$("#voltar").click(function() { window.location = "cadastro_usuario.php?cpf=" + cpf });

	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var texto_ok = validar_campos_texto(".form_txt");
		var combobox_ok = validar_comboBox(".form_cbo");
		var img_ok = validar_campo(imagem != null, $("#nome_arquivo").parent(), "#ff2233", "#aaa");

		var placa  	  = $("#placa").val();
		var modelo 	  = $("#modelo").val();
		var marca 	  = $("#marca").val();
		var cor    	  = $("#cor").val();
		var documento = $("#documento").val();
		
		var campos_validos = validar(placa, marca, cor);
		var campos_preenchidos = texto_ok && combobox_ok;

		if(campos_preenchidos && campos_validos) {

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("placa", placa);
			formData.append("modelo", modelo);
			formData.append("marca", marca);
			formData.append("cor", cor);
			formData.append("documento", documento);
			formData.append("foto", imagem);
			formData.append("usuario", usuario);
			
			$.ajax({
				url: "api/inserir_veiculo_site.php",
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,                    
                beforeSend: loader.iniciar(),
                success: tratar_resultado_envio
			});

		}else {
			notificacao.mostrar("Erro! ", "Algum campo não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez", "erro", $("#conteudo"), 1500);
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
				notificacao.mostrar("Erro! ", "Extensão inválida", "erro", $("#conteudo"), 1500);
			}else{
				imagem = this.files[0];

				$("#nome_arquivo").text(arquivo);
			}
		}else{
			$("#nome_arquivo").text("");
			imagem = null;
		}
	});

	$("#placa").on("keyup keydown", mascara_placa);
});

function validar(placa, marca, cor){
	var existencia = true;
	if(!retorna_parametro_url("modo")) existencia = !verificaExistencia("placa", placa);

	var placa_ok = validar_campo(ePlaca(placa), $("#placa"), "#ff2233", "#aaa");
	var eCor = validar_campo(eTexto(cor), $("#cor"), "#ff2233", "#aaa");
	var eMarca = validar_campo(eTexto(marca), $("#marca"), "#ff2233", "#aaa");
	var campos_validos =  placa_ok && eCor && eMarca && existencia;


	return campos_validos;
}

function retorna_extensao(arquivo) {
	var ext = arquivo.type.toString();
	ext = ext.substring(ext.indexOf("/") + 1);

	return ext;
}

function tratar_resultado_envio(resultado){
	if(resultado == 1) {
		loader.encerrar("img/icones/ic_okay.png", "Veiculo cadastrado com sucesso");
		setTimeout(function(){ window.location = "cadastro_usuario.php?cpf=" + cpf; }, 2200);
    }else{
    	loader.encerrar("img/icones/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}

function limpar_caixas() {
	$("#nome_arquivo").text("");
	imagem = null;

	$(".form_txt").each(function(){ $(this).val(""); });
	$(".form_cbo").each(function(){ $(this).children("option:first")[0].selected = true; });
}