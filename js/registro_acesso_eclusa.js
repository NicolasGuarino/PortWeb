$(function(){
	lista_usuarioAtivos = [];
	lista_usuarioInativos = [];
	indexInativo = 0;

	carregar_usuariosAtivos();
	carregar_usuariosInativos();

	// setInterval(function() {
		carregar_usuariosAtivos();
		carregar_usuariosInativos();

		var elemento = $(".card_usuario_inativo").first();
		elemento.insertAfter($(".card_usuario_inativo").last());
	// }, 500);
});

function carregar_usuariosAtivos() {
	$.ajax({
		url : 'api/listar_pessoas.php', /* URL que será chamada */ 
        type : 'POST', /* Tipo da requisição */
        async: false
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);
		var limite = 5;

		$(".card_usuario").remove();
		lista_usuarioAtivos = [];
		
		for(var index in dados) {
			if(index < 5) {
				var usuario = dados[index];
							
				$("#usuarios_ativos").append(criar_cardAtivo(usuario.foto_usuario, usuario.usuario, usuario.documento_pessoa));
				lista_usuarioAtivos.push(usuario.usuario_id);
			}else{
				return 0;
			}
		}
	});
}

function carregar_usuariosInativos() {
	$.ajax({
		url : 'api/listar_pessoas.php', /* URL que será chamada */ 
        type : 'POST', /* Tipo da requisição */
        async: false
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);
		var limite = 9;

		for(var index in dados) {
			var usuario = dados[index];
			
			if(lista_usuarioAtivos.indexOf(usuario.usuario_id) == -1 && lista_usuarioInativos.indexOf(usuario.usuario_id) == -1) {	
				$("#usuarios_inativos").children("#cardsInativos").append(criar_cardInativo(usuario.foto_usuario, usuario.usuario, usuario.usuario_id));
				lista_usuarioInativos.push(usuario.usuario_id);
			}else{
				if(lista_usuarioAtivos.indexOf(usuario.usuario_id) != -1) $("#" + usuario.usuario_id).remove();
			}
		}
	});
}

function criar_cardAtivo(caminho_img, nome, numDoc) {
	var card_usuario = $(document.createElement("div")).addClass("card_usuario");
	
	var img = $(document.createElement("div")).addClass("img"); 
		img.css("background", "url("+caminho_img+") center / 100% auto no-repeat");

	var nome_usuario = $(document.createElement("label")).addClass("nome_usuario"); 
		nome_usuario.text(nome);

	var num_documento = $(document.createElement("label")).addClass("num_documento"); 
		num_documento.text(numDoc);

	card_usuario.append(img);
	card_usuario.append(nome_usuario);
	card_usuario.append(num_documento);

	var qtd_usuarios = $("#usuarios_ativos").children(".card_usuario").length + 1;
	$(".qtde_usuarios").children("label").text(qtd_usuarios);

	return card_usuario;
}

function criar_cardInativo(caminho_img, nome, usuario_id) {
	var card_usuario = $(document.createElement("div")).addClass("card_usuario_inativo");
		card_usuario.attr("id", usuario_id);
	
	var img = $(document.createElement("div")).addClass("img"); 
		img.css("background", "url("+caminho_img+") center / cover no-repeat");

	var nome_usuario = $(document.createElement("label")).addClass("nome_usuario"); 
		nome_usuario.text(nome);

	card_usuario.append(img);
	card_usuario.append(nome_usuario);

	return card_usuario;
}