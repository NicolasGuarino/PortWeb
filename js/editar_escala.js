$(function() {
	$(".dia").hover(function(){
		var fundo = $(document.createElement("div")).addClass("edit_fundo");
		fundo.click(abrir_popup);

		$(".edit_fundo").remove();
		$(this).append(fundo);
	});

	$(".dia").mouseleave(function(){
		$(".edit_fundo").remove();
	});

	$("#fechar").click(function() {
		$("#background").fadeOut();

		$("#entrada").val("");
		$("#saida").val("");
	});

	$("#btn_salvar").click(function(e){
		e.preventDefault();

		var entrada = $("#entrada").val();
		var saida = $("#saida").val();
		var dia = $("#container").attr("name");

		var campos_preenchidos = validar_campos_texto(".time_txt");
		var campos_validos = validar_hora(entrada, saida);

		if(campos_validos && campos_preenchidos) {
			loader.iniciar();

			$.ajax({
				url: "api/editar_escala.php",
				data: {dia:dia, entrada:entrada, saida:saida, empresa_id:1, usuario_id:$("#foto_usuario").attr("name")}
			}).done(tratar_resultado_edicao);
		}else{
			alert("Algum campos não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez.");
		}
	});
});

function tratar_resultado_edicao(resultado){
	if(resultado == 1) {
		loader.encerrar("img/ic_okay.png", "Escala alterada com sucesso");
		limpar_caixas();

		setTimeout(function() { window.location.reload(); }, 2200);
    }else{
    	loader.encerrar("img/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}

function validar_hora(entrada, saida) {
	return eHora(entrada) && eHora(saida);
}

function abrir_popup() {
	var horario = $(this).prev().text();
	var dia = $(this).parent().attr("id");
	var dia_texto = $(this).parent().children(".nome_dia").attr("id");
	
	var entrada = horario.substr(0, horario.indexOf(" "));
	var saida 	= horario.substr(horario.indexOf("- ") + 2);
	var ic_deletar = $(document.createElement("i")).addClass("fa fa-trash-o");

	ic_deletar.attr("id", "deletar_escala");
	ic_deletar.click(function() {
		$.ajax({
			url: "api/deletar_escala.php",
			data: {escala_id: dia}
		}).done(function(resultado) {
			if(resultado) window.location.reload();
			else console.log(resultado);
		});
	});

	$("#background").fadeIn();

	$(".tit_edicao").text(dia_texto);
	$(".tit_edicao").append(ic_deletar);
	$("#entrada").val(entrada);
	$("#saida").val(saida);
	$("#container").attr("name", dia);
}