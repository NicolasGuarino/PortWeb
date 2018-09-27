$(function() {
	notificacao = new Notificacao();

	$(".dia").hover(function(){
		var fundo = $(document.createElement("div")).addClass("edit_fundo");
		fundo.click(abrir_popup);

		$(".edit_fundo").remove();
		$(this).append(fundo);
	});

	$(".dia").mouseleave(function(){
		$(".edit_fundo").remove();
	});

	$(".fechar").click(function() {
		$("#background_escala").fadeOut();

		$("#entrada").val("");
		$("#saida").val("");
	});

	$("#btn_salvar").click(function(e){
		e.preventDefault();

		var entrada = $("#entrada").val();
		var saida = $("#saida").val();
		var dia = $("#container").attr("name");
		var empresa = $("#principal").attr("name");

		var campos_preenchidos = validar_campos_texto(".escala");
		var campos_validos = validar_hora(entrada, saida);

		if(campos_validos && campos_preenchidos) {
			loader.iniciar();

			$.ajax({
				url: "api/editar_escala.php",
				data: {dia:dia, entrada:entrada, saida:saida, empresa_id:empresa, usuario_id:$("#foto_usuario").attr("name")}
			}).done(tratar_resultado_edicao);
		}else{
			notificacao.mostrar("Erro! ", "Algum campo não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez", "erro", $("#background_escala"), 1500);
		}
	});

	$("#cadastrar_excecao").click(function(){
		$("#background_escala").fadeIn(600);
		$("#frm_escala").fadeOut(100);
		$("#frm_excecao").fadeIn(100);
	});

	$("#btn_adicionarExcecao").click(function(e){
		e.preventDefault();

		var entrada = $("#entradaExcecao").val();
		var saida = $("#saidaExcecao").val();
		var dia = $("#diaExcecao").val();
		var usuario_id = $("#foto_usuario").attr("name");

		var campos_preenchidos = validar_campos_texto(".excecao");
		var campos_validos = validar_hora(entrada, saida, dia);

		if(campos_validos && campos_preenchidos) {
			loader.iniciar();

			$.ajax({
				url: "api/inserir_excecao_site.php",
				data: {data:dia, hora_entrada:entrada, hora_saida:saida, usuario_id:usuario_id}
			}).done(tratar_resultado_edicao);
		}else{
			notificacao.mostrar("Erro! ", "Algum campo não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez", "erro", $("#background_escala"), 1500);
		}
	});
});

function tratar_resultado_edicao(resultado){
	if(resultado == 1) {
		loader.encerrar("img/icones/ic_okay.png", "Ação realizada com sucesso");
		limpar_caixas();

		setTimeout(function() { window.location.reload(); }, 2200);
    }else{
    	loader.encerrar("img/icones/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}

function validar_hora(entrada, saida, dia = '2018-07-07') {
	var hora_entrada_ok = validar_campo(eHora(entrada) , $("#horario_entrada"), "#ff2233", "#aaa");
	var hora_saida_ok = validar_campo(eHora(saida), $("#horario_saida"), "#ff2233", "#aaa");
	var horas_validas = validar_campo((entrada < saida), $(".time_txt"), "#ff2233", "#aaa");
	var e_data = validar_campo(eData(dia), $("#diaExcecao"), "#ff2233", "#aaa");

	return hora_entrada_ok && hora_saida_ok && horas_validas && e_data;
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

	$("#background_escala").fadeIn(600);
	$("#frm_excecao").fadeOut(100);
	$("#frm_escala").fadeIn(100);

	$("#frm_escala").children(".tit_edicao").text(dia_texto);
	$("#frm_escala").children(".tit_edicao").append(ic_deletar);
	$("#entrada").val(entrada);
	$("#saida").val(saida);
	$("#container").attr("name", dia);
}