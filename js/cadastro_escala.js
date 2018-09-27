$(function(){
	imagem = null;
	loader = new Loader();
	notificacao = new Notificacao();
	usuario_id = retorna_parametro_url("id");
	cpf = retorna_parametro_url("cpf");

	$("#voltar").click(function() { window.location = "cadastro_usuario.php?cpf=" + cpf });

	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var texto_ok = validar_campos_texto(".form_txt");
		var radio_ok = validar_campo($("input[type='checkbox']:checked").length > 0, $(".radio"), "#ff2233", "#aaa");

		var horario_entrada = $("#horario_entrada").val();
		var horario_saida   = $("#horario_saida").val();
		var empresa   = $("#principal").attr("name");
		
		var hora_entrada_ok = validar_campo(eHora(horario_entrada) , $("#horario_entrada"), "#ff2233", "#aaa");
		var hora_saida_ok = validar_campo(eHora(horario_saida), $("#horario_saida"), "#ff2233", "#aaa");
		var horas_validas = validar_campo((horario_entrada < horario_saida), $(".form_txt"), "#ff2233", "#aaa");

		var campos_validos = hora_entrada_ok && hora_saida_ok && horas_validas;

		var campos_preenchidos = texto_ok && radio_ok;
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
				formData.append("empresa_id", empresa);

				$.ajax({
					url: "api/inserir_escala.php",
	                data: formData,
	                type: 'post',
	                processData: false,
	                contentType: false,
	                success: function(res) {
	                	resultado += parseInt(res);

	                	if(index == $(".radio_checked").length) tratar_resultado_envio(resultado);
	                	index++;
	                }
				});
			});

		}else {
			notificacao.mostrar("Erro! ", "Algum campo não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente novamente.", "erro", $("#conteudo"), 1500);
		}
			
	});

	$(".radio").click(function(){
		$(this).toggleClass("radio_checked");

		if($(this).hasClass("radio_checked")) {
			$(this).prev().prop("checked", true);	
		}else{
			$(this).prev().prop("checked", false);	
		}
		
	});
});

function tratar_resultado_envio(resultado){
	if(resultado == $(".radio_checked").length) {
		loader.encerrar("img/icones/ic_okay.png", "Escala cadastrada com sucesso");
		setTimeout(function(){ window.location = "cadastro_usuario.php?cpf=" + retorna_parametro_url("cpf"); }, 2200);
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