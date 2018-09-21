$(function(){
	lista_registro = [];
	dados = [];

	/* dados.push({ foto:"img/1504898218401.JPG", nome:"Gabriel Navevaiko", ativo:"1", usuario_id:"1" });
	dados.push({ foto:"img/1505154354740.JPG", nome:"Nicolas Guarino", ativo:"1", usuario_id:"2" });
	dados.push({ foto:"img/1505304552278.JPG", nome:"Samuel Rocha", ativo:"0", usuario_id:"3" });
	dados.push({ foto:"img/1505305558569.JPG", nome:"Mateus Morelli", ativo:"1", usuario_id:"4" });
	dados.push({ foto:"img/1505306659103.JPG", nome:"Lucas Roberto", ativo:"1", usuario_id:"5" });
	dados.push({ foto:"img/1505248511356.JPG", nome:"karen Scorci", ativo:"0", usuario_id:"6" });
	dados.push({ foto:"img/1525802376147.JPG", nome:"Mileni Paradela", ativo:"0", usuario_id:"7" });
	dados.push({ foto:"img/1525803071603.JPG", nome:"Nicolly de Souza", ativo:"1", usuario_id:"8" });
	dados.push({ foto:"img/1525802613129.JPG", nome:"Marcus Vinícius", ativo:"1", usuario_id:"9" });
	dados.push({ foto:"img/1525802519287.JPG", nome:"Neide Cardozo", ativo:"1", usuario_id:"10" });
	dados.push({ foto:"img/1525802512709.JPG", nome:"Bruna Menezes", ativo:"0", usuario_id:"11" });
	dados.push({ foto:"img/1528540455452.JPG", nome:"Isadora Barbosa", ativo:"1", usuario_id:"12" });
	dados.push({ foto:"img/1525789817114.JPG", nome:"Fernanda Guerra", ativo:"0", usuario_id:"13" });
	dados.push({ foto:"img/1525789628081.JPG", nome:"Rosangela Medeiros", ativo:"1", usuario_id:"14" });
	dados.push({ foto:"img/1525789464009.JPG", nome:"Guilherme Costa", ativo:"0", usuario_id:"15" });
	dados.push({ foto:"img/1525789337695.JPG", nome:"Caio de Costa", ativo:"1", usuario_id:"16" });
	dados.push({ foto:"img/1525788175483.JPG", nome:"Carlos Souza", ativo:"0", usuario_id:"17" });
	dados.push({ foto:"img/1525788933579.JPG", nome:"Jeferson Ferreira", ativo:"1", usuario_id:"18" });
	dados.push({ foto:"img/1525798350340.JPG", nome:"Letícia Campos", ativo:"1", usuario_id:"19" });
	dados.push({ foto:"img/1525799849443.JPG", nome:"Gizelli Correa", ativo:"0", usuario_id:"20" });
	dados.push({ foto:"img/1525799792066.JPG", nome:"Vinícius Tromel", ativo:"1", usuario_id:"21" });
	dados.push({ foto:"img/1525798168719.JPG", nome:"Giovanna Resende", ativo:"0", usuario_id:"22" });
	dados.push({ foto:"img/1505311296136.JPG", nome:"Matheus Silva", ativo:"1", usuario_id:"23" });
	dados.push({ foto:"img/1525799422228.JPG", nome:"Micael Arantes", ativo:"0", usuario_id:"24" });
	dados.push({ foto:"img/1525799409620.JPG", nome:"Guilherme Polito", ativo:"1", usuario_id:"25" });
	dados.push({ foto:"img/1525799326796.JPG", nome:"Ricardo Bezerra", ativo:"1", usuario_id:"26" });
	dados.push({ foto:"img/1525799323795.JPG", nome:"Victor Emanuel", ativo:"1", usuario_id:"27" });
	dados.push({ foto:"img/1525802756779.JPG", nome:"Sara Rodrigues", ativo:"0", usuario_id:"28" });
	dados.push({ foto:"img/1525804971966.JPG", nome:"Camila Almeida", ativo:"1", usuario_id:"29" });
	dados.push({ foto:"img/1525805791903.JPG", nome:"Roque Brito", ativo:"0", usuario_id:"30" });
	dados.push({ foto:"img/1525790204572.JPG", nome:"Raquel Arantes", ativo:"0", usuario_id:"31" });
	dados.push({ foto:"img/1528546143601.JPG", nome:"Wanderson Souza", ativo:"1", usuario_id:"32" });
	dados.push({ foto:"img/1528547164566.JPG", nome:"Alane Silva", ativo:"0", usuario_id:"33" }); */
	
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