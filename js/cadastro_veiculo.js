$(function(){
	imagem = null;
	loader = new Loader();
	var usuario = retorna_parametro_url("id");
	cpf = retorna_parametro_url("cpf");

	$("#voltar").click(function() { window.location = "cadastro_usuario.php?cpf=" + cpf });

	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt") && validar_comboBox(".form_cbo") && (imagem != null);

		var placa  	  = $("#placa").val();
		var modelo 	  = $("#modelo").val();
		var marca 	  = $("#marca").val();
		var cor    	  = $("#cor").val();
		var documento = $("#documento").val();
		
		var campos_validos = validar(placa, modelo, marca, cor);

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
			alert("Algum campos não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez.");
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

	$("#placa").on("keyup keydown", function(){
		var placa = $(this).val();
		
		if(placa.length <= 8) {
			placa = placa.replace(/(^\d{1,3})/g, "");
			placa = placa.replace(/([a-zA-Z]{3})(\d{4})/g, "$1-$2");

			$(this).val(placa);	
		}else{
			$(this).val(placa.substring(0,8));
		}
		
	});
});

function validar(placa, modelo, marca, cor){
	var campos_validos = ePlaca(placa) && eTexto(modelo) && eTexto(cor) && eTexto(marca);

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