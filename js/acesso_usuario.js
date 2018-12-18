
// Ajax utilizado para obter a lista de acesso
var ajax = null;
var timer = null;

// Obtendo o ID da empresa do usuário
var empresa_id = $("#principal").attr("name");

// VueJs
var app = new Vue({
	el: '#principal',

	data: {

		// Lista de acesso
		lista_acesso: [],

		add_lista_acesso: false,
		lista_data: 	  [],
		loader: 		  false,
		qtd_pagina: 	  null,

		// Variáveis de controle
		controle: {
			ult_data: 	null,
			btn_filtro: true
		},

		// Parâmetros da busca dos registros
		busca: {
			pagina: 		1,
			limite: 		10,
			filtro: 		null,
			data_inicio: 	null,
			data_termino: 	null,
			ordem: 			null,
			tipo_usuario: 	"1,3,4",
			empresa_id: 	empresa_id,
			qtd_pagina: 	null
		}
	},

	methods: {
		acaoClass: function(acao) {
			return (acao == "ENTRADA")? "seta_esquerda" : "seta_direita";
		},

		liberacaoStyle: function(liberacao) {
			return (liberacao == 1)? "linha_verde" : "linha_vermelha";
		},

		backgroundImageUrl: function(texto) {
			return 'url("' + texto + '")';
		},

		expandirLinha: function(e){
			var linha = $(e.currentTarget);

			if(linha.hasClass("expandido")){
				linha.removeClass("expandido");

			}else {
				$(".linha").removeClass("expandido");
				linha.addClass("expandido");
			}
		},

		mostrarData: function(data){

			if(data != this.ult_data){
				this.ult_data = data;
				return true;

			}else return false;
		},

		mostrarDataLinha: function(data){

			if(data != this.ult_data_linha_tempo){
				this.ult_data_linha_tempo = data;
				return true;

			}else return false;
		},

		scrollData: function(evento){
			var el = $(evento.target);
			var el_origem = $("#" + el.attr("id") + "_data");
			var el_origem_top = el_origem.offset().top;

			$(".linha_data").removeClass("data_selecionado");
			el.addClass("data_selecionado");

			$("html").animate({scrollTop: el_origem_top}, 200);
		},

		limparFiltro: function(){
			this.busca.pagina 		= 1,
			this.busca.limite 		= 10,
			this.busca.filtro 		= null,
			this.busca.data_inicio 	= null,
			this.busca.data_termino	= null,
			this.busca.ordem 		= null,
			this.tipo_usuario 		= "1,3,4",
			this.busca.empresa_id 	= empresa_id,
			this.busca.qtd_pagina 	= null
		},

		atualizarLista: function(e){
			$("#campo_pesquisa").val("");
			$("#campo_pesquisa").focus();

			btnAtualizar();
			atualizarListaAcesso();
		},

		carregarMais: function(){

			if(this.busca.pagina <= this.qtd_pagina){
				this.busca.pagina ++;
				this.add_lista_acesso = true;
				atualizarListaAcesso();
			}
		},

		adicionarRemoverFiltro: function(){

			if(this.controle.btn_filtro){

				// Mostrando os filtros
				this.controle.btn_filtro = false;
				$("#btn_filtro").text("remover filtro");
				$("#caixa_filtro").css("height", "57px");
				$("#caixa_filtro").css("margin", "20px auto 0 auto");

			}else {
				
				// Escondendo os filtros
				this.controle.btn_filtro = true;
				$("#btn_filtro").text("adicionar filtro");
				$("#caixa_filtro").css("height", "0");
				$("#caixa_filtro").css("margin", "");

				// Limpando os filtros
				this.limparFiltro();
			}
		}
	}
});

// Listando os acessos
atualizarListaAcesso();

// Botão de 'ok'
$("#btn_ok").click(atualizarListaAcesso);

// Pesquisa de texto
$("#campo_pesquisa").keyup(function(e){
	if(e.keyCode == 13) atualizarListaAcesso();
});

// Filtro de período de data
$("#data_inicio").change(function(){

	if(app.busca.data_termino == null){
		app.busca.data_termino = app.busca.data_inicio;

	}else if(app.busca.data_inicio > app.busca.data_termino)
		app.busca.data_inicio = app.busca.data_termino;
});

$("#data_termino").change(function(){

	if(app.busca.data_termino < app.busca.data_inicio)
		app.busca.data_termino = app.busca.data_inicio;
});

// Fixando a caixa de filtro ao rolar a página
$(window).scroll(function(){
	var scroll_top = $(window).scrollTop();

	if(scroll_top >= 255){
		$("#caixa_pesquisa").addClass("caixa_pesquisa_fixa");
		$("#lista").css("marginTop", "163px");

	}else {
		$("#caixa_pesquisa").removeClass("caixa_pesquisa_fixa");
		$("#lista").css("marginTop", "");
	} 
});

// Botão de voltar ao topo da página
$("#voltar_topo").click(function(){
	$("html, body").animate({
		scrollTop: 0
	}, 100);
});

// Preenche a lista de acessos
function atualizarListaAcesso(){

	// 'Zerando' a ultima data
	app.controle.ult_data = null;

	// Mostrando o loader
	btnCarregando();

	// Zerando a página
	if(!app.add_lista_acesso) app.busca.pagina = 1;

	// Preenchendo a lista de registro de acesso
	ajax = $.ajax({

		url:  "api/listar_pessoas.php",
		data: app.busca

	}).done(function(r){

		var res = $.parseJSON(r);

		// Convertendo para JSON a lista de pessoas
		var lista_acesso = res.lista;

		// Preenchendo a quantidade de páginas
		app.qtd_pagina = res.qtd_pagina;

		// Preenchendo a lista de acesso
		if(app.add_lista_acesso){
			app.lista_acesso = app.lista_acesso.concat(lista_acesso);
			app.add_lista_acesso = false;

		}else app.lista_acesso = lista_acesso;

		// Mostrando aviso de nada encontrado
		if(app.lista_acesso.length == 0) $(".nada_encontrado").fadeIn(0);
		else $(".nada_encontrado").fadeOut(0);

		// Escondendo o loader
		btnAtualizar();
	});
}

// Mostra o botão de carregando
function btnCarregando(){
	// $(".loader").css("width", "300px");
	$(".loader").css("height", "45px");
	$(".loader").children("span").text("Carregando");
	$(".loader").children(".loader_circulo").addClass("loader_circulo_animacao");
	$(".loader").children(".loader_circulo").css("margin", "0");
}

// Mostra o botão de atualizar
function btnAtualizar(){
	// $(".loader").css("width", "");
	$(".loader").css("height", "");
	$(".loader").children("span").text("");
	$(".loader").children(".loader_circulo").removeClass("loader_circulo_animacao");
	$(".loader").children(".loader_circulo").css("margin", "");
}