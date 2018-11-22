$(function() {
	var modo = retorna_parametro_url("modo");
	notificacao = new Notificacao();

	if(modo) {
		carregar_info_veiculo(retorna_parametro_url("id"));
	}

	$("#btn_editar").click(function(e){
		e.preventDefault();
		var texto_ok = validar_campos_texto(".form_txt");
		var combobox_ok = validar_comboBox(".form_cbo");
		var img_ok = validar_campo($("#nome_arquivo").text() != null, $("#nome_arquivo").parent(), "#ff2233", "#aaa");

		var placa  	  = $("#placa").val();
		var modelo 	  = $("#modelo").val();
		var marca 	  = $("#marca").val();
		var cor    	  = $("#cor").val();
		var documento = $("#documento").val();
		
		var campos_validos = validar(placa, marca, cor);
		var campos_preenchidos = texto_ok && combobox_ok;
		
		if(campos_preenchidos && campos_validos) {
			if(imagem != null) var atualizarImg = "true"; 
			else var atualizarImg = $("#nome_arquivo").text();

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("veiculo_id", retorna_parametro_url("id"));
			formData.append("placa", placa);
			formData.append("modelo", modelo);
			formData.append("marca", marca);
			formData.append("cor", cor);
			formData.append("foto", imagem);
			formData.append("atualizarImg", atualizarImg);
			
			$.ajax({
				url: "api/editar_veiculo.php",
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,                    
                beforeSend: loader.iniciar(),
                success: tratar_resultado_envio
			});

			window.location = "cadastro_usuario.php?cpf=" + retorna_parametro_url("cpf");

		}else{
			notificacao.mostrar("Erro! ", "Algum campo não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez", "erro", $("#conteudo"), 1500);
		}
			
	});


});


function carregar_info_veiculo(id) {
	var veiculo = JSON.parse(localStorage.getItem("veiculo" + id));

	$("#placa").val(veiculo.placa);
	$("#marca").val(veiculo.marca);
	$("#modelo").val(veiculo.modelo);
	$("#cor").val(veiculo.cor);
	$("#nome_arquivo").text(veiculo.foto);

	$("#btn_cadastro").val("Editar");
	$("#btn_cadastro").unbind("click");
	$("#btn_cadastro").attr("id", "btn_editar");
	$(".tit").text("Editar veiculo");
}