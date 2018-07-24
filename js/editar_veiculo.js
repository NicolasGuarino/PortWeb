$(function() {
	var modo = url_param("modo");

	if(modo) {
		carregar_info_veiculo(url_param("id"));
	}

	$("#btn_editar").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt") && validar_comboBox(".form_cbo");

		var placa  	  = $("#placa").val();
		var modelo 	  = $("#modelo").val();
		var marca 	  = $("#marca").val();
		var cor    	  = $("#cor").val();
		var documento = $("#documento").val();
		
		var campos_validos = validar(placa, modelo, marca, cor);

		if(campos_preenchidos && campos_validos) {
			if(imagem != null) var atualizarImg = "true"; 
			else var atualizarImg = $("#nome_arquivo").text();

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("veiculo_id", url_param("id"));
			formData.append("placa", placa);
			formData.append("modelo", modelo);
			formData.append("marca", marca);
			formData.append("cor", cor);
			formData.append("documento", documento);
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

		}else{
			alert("Algum campos não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez.");
		}
			
	});


});


function carregar_info_veiculo(id) {
	var veiculo = JSON.parse(localStorage.getItem("veiculo" + id));

	$("#placa").val(veiculo.placa);
	$("#marca").val(veiculo.marca);
	$("#modelo").val(veiculo.modelo);
	$("#cor").val(veiculo.cor);
	$("#documento").val(veiculo.documento_id);
	$("#nome_arquivo").text(veiculo.foto);

	$("#btn_cadastro").val("Editar");
	$("#btn_cadastro").unbind("click");
	$("#btn_cadastro").attr("id", "btn_editar");
	$(".tit").text("Editar veiculo");
}