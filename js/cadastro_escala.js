$(function(){
	imagem = null;
	loader = new Loader();
	usuario_id = retorna_parametro_url("id");
	cpf = retorna_parametro_url("cpf");

	$("#voltar").click(function() { window.location = "cadastro_usuario.php?cpf=" + cpf });

	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt") && ($("input[type='checkbox']:checked").length > 0);

		var horario_entrada = $("#horario_entrada").val();
		var horario_saida   = $("#horario_saida").val();
		
		var campos_validos = eHora(horario_entrada) && eHora(horario_saida);

		if(campos_preenchidos && campos_validos) {

			loader.iniciar();
			var resultado = 0;

			var index = 1;
			$(".radio_checked").each(function(){
				var dia = $(this).prev().val();
				
				var formData = new FormData();
				formData.append("hora_entrada", horario_entrada);
				formData.append("hora_saida", horario_saida);
				formData.append("dia_da_semana", dia);
				formData.append("usuario_id", usuario_id);
				formData.append("empresa_id", "1"); // VERIFICAR COM A JULIA O PQ DESSE CAMPO

				$.ajax({
					url: "api/inserir_escala.php",
	                data: formData,
	                type: 'post',
	                processData: false,
	                contentType: false,
	                success: function(res) {
	                	resultado += parseInt(res);

	                	if(index == $(".radio_checked").length) tratar_resultado_envio(resultado);
	                	console.log(index);
	                	index++;
	                }
				});
			});

		}else {
			alert("Algum campos não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez.");
		}
			
	});

	$(".radio").click(function(){
		$(this).addClass("radio_checked");
		$(this).prev().attr("checked", "true");
	});
});

function validar(placa, modelo, marca, cor){
	var campos_validos = ePlaca(placa) && eTexto(modelo) && eTexto(cor) && eTexto(marca);

	return campos_validos;
}

function tratar_resultado_envio(resultado){
	if(resultado == $(".radio_checked").length) {
		loader.encerrar("img/icones/ic_okay.png", "Escala cadastrada com sucesso");
		setTimeout(function(){ window.location.reload(); }, 2200);
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