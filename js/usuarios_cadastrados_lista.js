$(function(){
	lista_usuarios_completo = [];
	lista_usuario_filtrados = [];
	ultimo_usuario = 0;
	index_atual = 1;
	pesquisando = false;

	carregar_usuarios();

	setInterval(function() {
		carregar_usuarios();
	}, 5000);

	$("#proximo").on("click", proximoUsuario);

	$("#anterior").on("click", usuarioAnterior);

	var ultimo_toque = -1;
	var reproduzir = true;

	$("#lista_usuarios").on("touchstart", function(e){
		ultimo_toque = e.originalEvent.touches[0].pageX;
		reproduzir = true;
	});

	$("#lista_usuarios").on("touchmove", function(e){
		var toque_atual = e.originalEvent.touches[0].pageX;

		if(toque_atual > (ultimo_toque + 100) && reproduzir){
			usuarioAnterior();
			reproduzir = false;
		}

		if(toque_atual < (ultimo_toque - 100) && reproduzir){
			proximoUsuario();
			reproduzir = false;
		}
	});

	$("#campo_pesquisa").keyup(function(e){
		var valor_pesquisa = $(this).val();
		if(valor_pesquisa != "") {
			pesquisar(valor_pesquisa);
		}else{
			pesquisando = false;	
			listar_usuario(lista_usuarios_completo);
		} 
	});
	
	$("#botao_pesquisa").click(function(){
		var valor_pesquisa = $("#campo_pesquisa").val();
		if(valor_pesquisa != "") {
			pesquisar(valor_pesquisa);	
		}else {
			pesquisando = false;
			listar_usuario(lista_usuarios_completo);
		}
	});
});

function pesquisar(valor_pesquisa){
	var nova_lista = [];

	pesquisando = true;
	for(var index in lista_usuarios_completo) {
		var usuario = lista_usuarios_completo[index];
		
		var pesquisa_nome = usuario.nome.toLocaleLowerCase().indexOf(valor_pesquisa.toLocaleLowerCase());
		var pesquisa_rg = usuario.rg.toLocaleLowerCase().indexOf(valor_pesquisa.toLocaleLowerCase());
		var pesquisa_documento = usuario.documento_id.toLocaleLowerCase().indexOf(valor_pesquisa.toLocaleLowerCase());

		if(pesquisa_nome != -1 || pesquisa_rg != -1 || pesquisa_documento != -1) nova_lista.push(usuario);
	}

	$("#usuarios_ativos").css("marginLeft", "0");
	listar_usuario(nova_lista);
}

function proximoUsuario() {
	if(index_atual+5 <= lista_usuario_filtrados.length) {
		$("#usuarios_ativos").animate({
			marginLeft: "-=300px"
		}, 100);
		index_atual+=1;
	}
}

function usuarioAnterior(){
	if(index_atual > 1) {
		$("#usuarios_ativos").animate({
			marginLeft: "+=300px"
		}, 100);

		index_atual-=1;
	}
}

function carregar_usuarios() {
	$.ajax({
		url : 'api/listar_usuario_senai.php',
        type : 'POST',
        data: {usuario_id:ultimo_usuario}
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);
		
		if(dados[0].usuario_id == ultimo_usuario) {
			lista_usuarios_completo = lista_usuarios_completo.concat(dados);
		}else{
			lista_usuarios_completo = dados;
		}
		
		if(!pesquisando) listar_usuario(lista_usuarios_completo);
	});
}

function listar_usuario(lista) {
	$(".card_usuario").remove();

	for(var index in lista) {
		var usuario = lista[index];
		$("#usuarios_ativos").append(criar_cardUsuario(usuario.foto, usuario.nome, usuario.documento_id, usuario.cpf));
	}

	lista_usuario_filtrados = lista;
	$(".qtde_usuarios").children("label").text(lista.length);
}

function criar_cardUsuario(caminho_img, nome, numDoc, cpf) {
	var card_usuario = $(document.createElement("div")).addClass("card_usuario");
	
	if(caminho_img == "") caminho_img = "img/icones/ic_noImage.png";

	var img = $(document.createElement("div")).addClass("img"); 
		img.css("background", "url("+caminho_img+") center / 100% auto no-repeat");

	var nome_usuario = $(document.createElement("label")).addClass("nome_usuario"); 
		nome_usuario.text(nome);

	var num_documento = $(document.createElement("label")).addClass("num_documento"); 
		num_documento.text(numDoc);

	var botao_imprimir = $(document.createElement("a")).addClass("btn_imprimir");
		botao_imprimir.text("Imprimir");
		botao_imprimir.attr("target", "_blank");
		botao_imprimir.attr("href", "api/imagem_oculta_etiqueta/impressao.php?documento_id=" + numDoc);

	var botao_detalhe = $(document.createElement("a")).addClass("fa fa-info-circle btn_detalhes");
		botao_detalhe.attr("target", "_blank");
		botao_detalhe.attr("href", "cadastro_usuario.php?cpf=" + cpf);

	card_usuario.append(img);
	card_usuario.append(nome_usuario);
	card_usuario.append(num_documento);
	card_usuario.append(botao_imprimir);
	card_usuario.append(botao_detalhe);

	return card_usuario;
}