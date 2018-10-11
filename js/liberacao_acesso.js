$(function(){
	estaMostrando = false;
	id_atual = 0;
	timeout = null;

	verificarAcesso();
});

function verificarAcesso() {
	var requisicao = $.ajax({
		url : 'api/lista_acesso.php', /* URL que será chamada */ 
        type : 'POST', /* Tipo da requisição */
        async: false
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);
		
		if(dados.length != 0) {
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
        $(".card").remove();
        $("#cards").append(criar_card(0, dados.usuario));
        if(dados.veiculo.lbl_principal != undefined) $("#cards").append(criar_card(1, dados.veiculo));

        var classe_tipoLeitura = (dados.tipo_leitura == 1) ? "nfc" : "rfid";

        $("#cards").append($(document.createElement("span")).addClass("tipo_leitura rfid"));

        if(dados.liberado == 1) {
            $(".aviso_liberacao").addClass("permitido");
            $(".aviso_liberacao").text(" Acesso liberado");
            $(".aviso_liberacao").prepend("<i class='fa fa-check'></i>");
        }else{
            $(".aviso_liberacao").addClass("negado");
            $(".aviso_liberacao").text(" Acesso negado");
            $(".aviso_liberacao").prepend("<i class='fa fa-times'></i>");
        }
	});
	
	timeout = setTimeout(function () {
		remover_acesso(dados);
	}, 5000);
}

function remover_acesso(dados, callback = function(x){}) {
    $(".card").remove();
    $(".tipo_leitura").remove();
    $(".aviso_liberacao").text("");
    $(".aviso_liberacao").removeClass("negado permitido");
	id_atual = 0;
	
    $("#vazio").fadeIn(100, function () { 
        estaMostrando = false;
        setTimeout(function() { callback(dados); }, 50);
    });
}

function criar_card(eCarro, info) {
    var classe_card = (eCarro) ? "card_veiculo" : "card_usuario";

	var card_usuario = $(document.createElement("div")).addClass("card " + classe_card);
	
	var img = $(document.createElement("div")).addClass("img"); 
		img.css("background", "url("+ info.caminho_img +") center / 100% auto no-repeat");

	var lbl_principal = $(document.createElement("label")).addClass("lbl_principal"); 
		lbl_principal.text(info.lbl_principal);

	var lbl_secundaria = $(document.createElement("label")).addClass("lbl_secundaria"); 
		lbl_secundaria.text(info.lbl_secundaria);

	card_usuario.append(img);
	card_usuario.append(lbl_principal);
	card_usuario.append(lbl_secundaria);

	return card_usuario;
}