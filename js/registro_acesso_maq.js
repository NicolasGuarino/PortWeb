$(function(){
	lst_verificado = [];
	
	/*$("#vazio").fadeOut(100);
	$("#aviso_acesso").animate({ width: "90%",height: "25px",padding: "10px" }, 200, "linear");
	$("#cards").append(criar_card(1, {caminho_img:'img/Carro_azul.jpg', lbl_principal:'Gol - Volkswagem', lbl_secundaria:'ABC-1234'}));
	$("#cards").append(criar_card(0, {caminho_img:'img/1525799849443.JPG', lbl_principal:'Daniela Lira', lbl_secundaria:'59'}));*/

	setInterval(function() {
		verificarAcesso();
	}, 500);
});

function verificarAcesso() {
	$.ajax({
		url : 'api/lista_acesso_maquete.php', /* URL que será chamada */ 
        type : 'POST', /* Tipo da requisição */
        async: false
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);
		
		if(dados != undefined) {
			if(lst_verificado.indexOf(dados.veiculo_id) == -1) {
				lst_verificado.push(dados.veiculo_id);
				$("#vazio").fadeOut(100);
				$("#aviso_acesso").animate({ width: "90%",height: "25px",padding: "10px" }, 200, "linear");
				
				setTimeout(function() {
					$("#cards").append(criar_card(1, {caminho_img:dados.foto_veiculo, lbl_principal:dados.carro, lbl_secundaria:dados.placa}));
					$("#cards").append(criar_card(0, {caminho_img:dados.foto_usuario, lbl_principal:dados.nome, lbl_secundaria:dados.documento_id}));

					setTimeout(function() {
						$(".card").remove();
						$("#aviso_acesso").animate({ width: "0px",height: "0px",padding: "0px" }, 300, "linear");
						$("#vazio").fadeIn(300);
						lst_verificado = [];
					}, 20000);
				}, 100);
			}else{
				$(".card").remove();
				lst_verificado = [];
				lst_verificado.push(dados.veiculo_id);

				$("#cards").append(criar_card(1, {caminho_img:dados.foto_veiculo, lbl_principal:dados.carro, lbl_secundaria:dados.placa}));
				$("#cards").append(criar_card(0, {caminho_img:dados.foto_usuario, lbl_principal:dados.nome, lbl_secundaria:dados.documento_id}));
			}
		}
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