$(function(){
	loader = new Loader();
	timer = null;

	$.ajax({
		url: "api/listar_usuarios_cadastrados.php",
        type: 'post',
        processData: false,
        contentType: false,                    
        beforeSend: loader.iniciar(),
        success: preencher_tabela
	});

	$("#fechar").click(function(){
		$("#background").fadeOut();

		$(".adicionar").each(function() {
			var link_adicionar = $(this).attr("href");

			$(this).attr("href", link_adicionar.substr(0, link_adicionar.indexOf("?")));			
		});
		
	});

	$(".item_filtro").on("keyup", function(){
		var texto_pesquisa = $(this).val();

		if(texto_pesquisa != "") $(".img_pesq").css("background", "url(img/fechar.png) no-repeat center / 20px 20px");
		else $(".img_pesq").css("background", "url(img/pesq.png) no-repeat center / 20px 20px");

		pesquisar(texto_pesquisa);
	});

	$(".img_pesq").click(function(){
		$(".img_pesq").css("background", "url(img/pesq.png) no-repeat center / 20px 20px");
		$(".item_filtro").val("");

		var texto_pesquisa = $(".item_filtro").val();
	
		var formData = new FormData();
		formData.append("valor_pesquisa", texto_pesquisa);

		$.ajax({
			url: "api/pesquisar_usuario.php",
	        type: 'post',
	        data: formData,
	        processData: false,
	        contentType: false,                    
	        beforeSend: loader.iniciar(),
	        success: preencher_tabela
		});
	});

	$(".excluir").click(function(){
		var id = $(this).attr("id");

		var formData = new FormData();
		formData.append("id", id);

		$("#background").fadeOut();

		$.ajax({
			url: "api/excluir_usuario.php",
	        type: 'post',
	        data: formData,
	        processData: false,
	        contentType: false,                    
	        beforeSend: loader.iniciar(),
	        success: tratar_resultado
		});

	});

	$(".editar").click(function(){

	});
});

function preencher_tabela(retorno){
	var dados = $.parseJSON(retorno);
	var qtd_colunas = 3;

	$(".ln").remove();
	$(".ln_tit").remove();

	criar_linha_titulo(qtd_colunas);

	$.each(dados, function(index, item){
		var ln = $(document.createElement("div")).addClass("ln");
			ln.attr("id", item.usuario_id)
		var cl_tam = 100 / qtd_colunas;
		var titulos = [item.nome, item.cpf, item.email];

		for(var i = 0; i < 3; i++) {
			var cl = criar_coluna(titulos[i]);
			cl.css("width", cl_tam + "%");
			ln.append(cl);
		}
		
		ln.click(mostrar_mais_detalhes);

		$("#tbl_usuarios").append(ln);
		loader.encerrar("img/ic_okay.png", "Dados carregados com sucesso!");
	})
}

function criar_linha_titulo(qtd_colunas) {
	var ln = $(document.createElement("div")).addClass("ln_tit");

	var cl_tam = 100 / qtd_colunas;
	var titulos = ["Nome", "CPF", "Email"];

	for(var i = 0; i < 3; i++) {
		var cl = criar_coluna(titulos[i]);
		cl.css("width", cl_tam + "%");
		ln.append(cl);
	}

	$("#tbl_usuarios").append(ln);
}

function criar_coluna(texto) {
	var cl = $(document.createElement("div")).addClass("cl");

	if(texto == "" || texto == null){
		texto = "não definido";
		cl.css("font-style", "italic");	
	} 
	cl.text(texto);
	return cl;
}

function mostrar_mais_detalhes(){
	var formData = new FormData();
	formData.append("usuario_id", $(this).attr("id"));

	$.ajax({
		url: "api/retornar_detalhes_usuario.php",
        data: formData,
        type: 'post',
        processData: false,
        contentType: false,                    
        beforeSend: loader.iniciar(),
        success: preencher_detalhes
	});
}

function preencher_detalhes(retorno){
	limpar_tela_detalhes();
	try {
		var item = $.parseJSON(retorno);
		var lista_dados = [item.nome, item.cpf, item.email, item.veiculo];

		if(item.img == null) {
			$("#foto").css("background", "transparent url(img/person.png) no-repeat  0 0 / auto 100%");
		}else{
			$("#foto").css("background", "transparent url('"+ item.img +"') no-repeat  0 0 / auto 100%");
		}

		$(".texto").each(function(index, item){
			var texto = lista_dados[index];

			if(texto == null || texto == ""){
				texto = "não definido";
				$(this).css("font-style", "italic");
				$("#add_veiculo").css("display", "block");
					
			}else{
				texto = lista_dados[index];
			}

			$(this).text(texto);
		});

		var lst_escala = $.parseJSON(item.escala);
		
		if(lst_escala.length > 0) {
			$("#escala").fadeIn();
			$("#add_escala").css("display", "none");
			preencher_escala(lst_escala);
		}else{
			$("#escala").fadeOut();
			$("#add_escala").css("display", "block");
		}

		loader.encerrar("img/ic_okay.png", "Os dados foram carregados com sucesso");
		
		$(".editar").attr("id", item.usuario_id);
		$(".excluir").attr("id", item.usuario_id);

		$(".adicionar").each(function(){
			$(this).attr("href", $(this).attr("href") + "?id=" + item.usuario_id);
		});

		setTimeout(function(){
			$("#background").fadeIn();
		}, 2100);
		

	}catch(e) {
		console.error("Retorno: " + retorno+"\nErro:" + e);
		loader.encerrar("img/ic_erro.png", "Ocorreu um erro, entre em contato com o administrador.");
	}
	
}

function preencher_escala(lst_escala) {
	$(".dia").each(function(index){
		var dia = $(this).attr("id").substr(4);

		try {
			if(temItem(lst_escala, "dia", dia)) {
				$(this).css("background", "#af2");
				
				
				var seta_cima = $(document.createElement("div")).addClass("seta_cima");
				var hora_entrada = $(document.createElement("div")).addClass("hora_entrada");
					hora_entrada.text(retornaItem(lst_escala, "dia", dia).horario);

				$(this).append(seta_cima);
				$(this).append(hora_entrada);
			}
		}catch(e) {
			
		}

	});
}

function limpar_tela_detalhes() {
	$("#foto").css("background", "transparent");
	$(".texto").each(function(index, item){ $(this).text(""); });
	$(".dia").each(function(index){ $(this).css("background", "#eee"); });
}

function pesquisar(valor_pesquisa) {
	clearTimeout(timer);

	timer = setTimeout(function(){
		var formData = new FormData();
		formData.append("valor_pesquisa", valor_pesquisa);

		$.ajax({
			url: "api/pesquisar_usuario.php",
	        type: 'post',
	        data: formData,
	        processData: false,
	        contentType: false,                    
	        beforeSend: loader.iniciar(),
	        success: preencher_tabela
		});
	}, 800);
}

function tratar_resultado(resultado) {
	if(resultado == 1) {
		loader.encerrar("img/ic_okay.png", "Usuario deletado com sucesso");
		
		pesquisar($(".item_filtro").val());
	}else{
		loader.encerrar("img/ic_erro.png", "Ocorreu um erro, entre em contato com o administrador");
		console.log("Erro: " + resultado);
	}
}