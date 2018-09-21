$(function(){
	estaMostrando = false;
	id_atual = 0;
	timeout = null;

	verificarAcesso();
});

function verificarAcesso() {
	var requisicao = $.ajax({
		url : 'api/lista_acesso_maquete.php', /* URL que será chamada */ 
        type : 'POST', /* Tipo da requisição */
        async: false
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);
		
		if(dados != undefined) {
			if(!estaMostrando) {
				estaMostrando = true;

				id_atual = dados.usuario_id;
				exibir_acesso(dados);
			}else if(dados.usuario_id != id_atual){
				remover_acesso(dados, exibir_acesso);	
			}
		}

		setTimeout(verificarAcesso, 500);
	});
}

function exibir_acesso(dados) {
	clearTimeout(timeout);
	
	$("#vazio").fadeOut(100, function () {
		$("#aviso_acesso").animate({ width: "90%", height: "25px", padding: "10px" }, 200, "linear", function () {
			$(".card").remove();
			$("#cards").append(criar_card(1, { caminho_img: dados.foto_veiculo, lbl_principal: dados.carro, lbl_secundaria: dados.placa }));
			$("#cards").append(criar_card(0, { caminho_img: dados.foto_usuario, lbl_principal: dados.nome, lbl_secundaria: dados.documento_id }));
		});
	});
	
	timeout = setTimeout(function () {
		remover_acesso(dados);
	}, 5000);
}

function remover_acesso(dados, callback = function(x){}) {
	$("#aviso_acesso").animate({ width: "0", height: "0", padding: "0" }, 200, "linear", function () {
		$(".card").remove();
		$("#vazio").fadeIn(100, function () { 
			estaMostrando = false; 
			setTimeout(function() { callback(dados); }, 50);
		});
	});
}

function criar_card(eCarro, info) {
	var classe = (eCarro) ? "card_veiculo" : "card_usuario";

	var card_usuario = $(document.createElement("div")).addClass("card " + classe);
	
	var img = $(document.createElement("div")).addClass("img"); 
		img.css("background", "url("+info.caminho_img+") center / 100% auto no-repeat");

	var lbl_principal = $(document.createElement("label")).addClass("lbl_principal"); 
		lbl_principal.text(info.lbl_principal);

	var lbl_secundaria = $(document.createElement("label")).addClass("lbl_secundaria"); 
		lbl_secundaria.text(info.lbl_secundaria);

	card_usuario.append(img);
	card_usuario.append(lbl_principal);
	card_usuario.append(lbl_secundaria);

	return card_usuario;
}