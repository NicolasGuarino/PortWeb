$(function(){
	lista_empresa_completo = [];
	lista_empresa_filtrados = [];
	ultima_empresa = 0;
	index_atual = 1;
	pesquisando = false;

	carregar_empresas();

	setInterval(function() {
		carregar_empresas();
	}, 5000);

	$("#proximo").on("click", proximo);

	$("#anterior").on("click", anterior);

	var ultimo_toque = -1;
	var reproduzir = true;

	$("#empresas").on("touchstart", function(e){
		ultimo_toque = e.originalEvent.touches[0].pageX;
		reproduzir = true;
	});

	$("#empresas").on("touchmove", function(e){
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
			listar_empresa(lista_empresa_completo);
		} 
	});
	
	$("#botao_pesquisa").click(function(){
		var valor_pesquisa = $("#campo_pesquisa").val();
		if(valor_pesquisa != "") {
			pesquisar(valor_pesquisa);	
		}else {
			pesquisando = false;
			listar_empresa(lista_empresa_completo);
		}
	});
});

function pesquisar(valor_pesquisa){
	var nova_lista = [];
	pesquisando = true;
	for(var index in lista_empresa_completo) {
		var empresa = lista_empresa_completo[index];
		
		var pesquisa_nome = empresa.nome.toLocaleLowerCase().indexOf(valor_pesquisa.toLocaleLowerCase());
		var pesquisa_tel = empresa.telefone.toLocaleLowerCase().indexOf(valor_pesquisa.toLocaleLowerCase());
		var pesquisa_email = empresa.email.toLocaleLowerCase().indexOf(valor_pesquisa.toLocaleLowerCase());

		if(pesquisa_nome != -1 || pesquisa_tel != -1 || pesquisa_email != -1) nova_lista.push(empresa);
	}

	$($(".card_empresa")[0]).css("marginLeft", "0");
	listar_empresa(nova_lista);
}

function proximo() {
	if(index_atual+3 <= lista_empresa_filtrados.length) {
		var card = $(".card_empresa")[0];

		$(card).animate({
			marginLeft: "-=400px"
		}, 100);

		index_atual+=1;
	}
}

function anterior(){
	if(index_atual > 1) {
		var card = $(".card_empresa")[0];

		$(card).animate({
			marginLeft: "+=400px"
		}, 100);

		index_atual-=1;
	}
}

function carregar_empresas() {
	$.ajax({
		url : 'api/listar_empresas.php',
        type : 'POST',
        data: {empresa_id:ultima_empresa}
	}).done(function(retorno) {
		var dados = $.parseJSON(retorno);
		
		if(dados[0].empresa_id == ultima_empresa) {
			lista_empresa_completo = lista_empresa_completo.concat(dados);
		}else{
			lista_empresa_completo = dados;
		}
		
		if(!pesquisando) listar_empresa(lista_empresa_completo);
	});
}

function listar_empresa(lista) {
	if($(".card_empresa")[0] != undefined) var marginLeft = $(".card_empresa")[0].style.marginLeft;

	$(".card_empresa").remove();

	for(var index in lista) {
		var empresa = lista[index];
		$("#empresas").append(criar_cardEmpresa(empresa.foto, empresa.nome, empresa.email, empresa.telefone, empresa.empresa_id));
	}


	if($(".card_empresa")[0] != undefined) $(".card_empresa")[0].style.marginLeft = marginLeft;

	lista_empresa_filtrados = lista;
	$(".qtde_empresas").children("label").text(lista.length);
}

function criar_cardEmpresa(caminho_img, nome, email, telefone, id) {
	var card_empresa = $(document.createElement("div")).addClass("card_empresa");
	
	if(caminho_img == null) caminho_img = "img/icones/ic_noImage.png";

	var ic_nome = $(document.createElement("label")).addClass("nome_empresa"); 
	var ic_info = $(document.createElement("div")).addClass("info"); 
	var ic_foto = $(document.createElement("div")).addClass("foto"); 
	var ic_email = $(document.createElement("label")).addClass("info_empresa"); 
	var ic_telefone = $(document.createElement("label")).addClass("info_empresa"); 
	var ic_link = $(document.createElement("a")).addClass("link_visualizar"); 
	var ic_hr = $(document.createElement("hr")); 
	var ic_opcao = $(document.createElement("div")).addClass("opcoes"); 
	var ic_editar = $(document.createElement("div")).addClass("edit_empresa"); 
	var ic_deletar = $(document.createElement("div")).addClass("delete_empresa"); 


	ic_nome.text(nome);
	ic_foto.css("background", "url("+caminho_img+") center / 100% auto no-repeat");
	ic_email.text(email);
	ic_telefone.text(telefone);
	ic_editar.text("Editar");
	ic_deletar.text("Deletar");
	ic_link.attr("target", "_blank");
	ic_link.attr("href", "usuarios_cadastrados_lista.php?empresa=" + id);
	ic_link.text("Visualizar funcionários");

	ic_deletar.click(deletar_empresa);
	ic_editar.click(function(){
		var empresa = {id:id, nome: nome, email:email, telefone:telefone, caminho_img:caminho_img};
		localStorage.setItem("empresa" + id, JSON.stringify(empresa));

		window.location = "cadastro_empresa.php?modo=editar&id=" + id;
	});

	ic_opcao.append(ic_editar);
	ic_opcao.append(ic_deletar);

	ic_info.append(ic_foto);
	ic_info.append(ic_email);
	ic_info.append(ic_telefone);

	card_empresa.append(ic_nome);
	card_empresa.append(ic_info);
	card_empresa.append(ic_link);
	card_empresa.append(ic_hr);
	card_empresa.append(ic_opcao);
	card_empresa.attr("id", id);

	return card_empresa;
}

function deletar_empresa() {
	var id = $(this).parent().parent().attr("id");
	$(this).parent().parent().remove();
	$.ajax({
		url: "api/deletar_empresa.php",
		data: {empresa_id: id}
	}).done(function(resultado){
		console.log(resultado);
	});
}