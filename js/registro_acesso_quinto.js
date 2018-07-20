$(function(){
	lista_registro = [];

	carregar_usuarios();

	setInterval(function() {
		carregar_usuarios();
	}, 2500);

	setInterval(function() {
		var elemento = $(".card_usuario").first();
		elemento.insertAfter($(".card_usuario").last());
	}, 3500)
});

function carregar_usuarios() {
	$.ajax({
		url : 'api/listar_pessoas_quinto.php', /* URL que será chamada */ 
        type : 'POST', /* Tipo da requisição */
        async: false
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);

		for(var index in dados) {
			var usuario = dados[index];
			
			// if(lista_registro.indexOf(usuario.registro_acesso_id) == -1) {
				if($("#" + usuario.usuario_id).attr("id") != undefined) {
					if(usuario.ativo == "1") {
						$("#" + usuario.usuario_id).children(".img").css("filter", "none");
					}else{
						$("#" + usuario.usuario_id).children(".img").css("filter", "grayscale(100%)");
					}
				}else{
					$("#usuarios_inativos").children("#cardsInativos").append(criar_card(usuario.foto, usuario.nome, usuario.ativo, usuario.usuario_id));				
				}
			
				// lista_registro.push(usuario.registro_acesso_id);
			// }
		}

		$(".qtde_usuarios").children("label").text($(".card_usuario").length);
	});
}

function criar_card(caminho_img, nome, ativo, usuario_id) {
	var card_usuario = $(document.createElement("div")).addClass("card_usuario");
		card_usuario.attr("id", usuario_id)
	var img = $(document.createElement("div")).addClass("img"); 
		img.css("background", "url("+caminho_img+") center / cover no-repeat");

	var nome_usuario = $(document.createElement("label")).addClass("nome_usuario"); 
		nome_usuario.text(nome);

	if(ativo == "1") {
		img.css("filter", "none");
	}else{
		img.css("filter", "grayscale(100%)");
	}

	card_usuario.append(img);
	card_usuario.append(nome_usuario);

	return card_usuario;
}