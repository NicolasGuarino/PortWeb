
// Ajax utilizado para obter a lista de acesso
var ajax = null;
var timer = null;

// Obtendo o ID da empresa do usuário
var empresa_id = $("#principal").attr("name");

// VueJs
var app = new Vue({
	el: '#principal',
	data: {
		lista_acesso: [],
		lista_data: [],
		loader: false,

		controle: {
			ult_data: null
		},

		busca: {
			pagina: 		1,
			limite: 		10,
			filtro: 		null,
			tipo_usuario: 	"1,3,4",
			empresa_id: 	empresa_id,
			qtd_pagina: 	null
		},

		qtd_pagina: null
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
			this.tipo_usuario 		= "1,3,4",
			this.busca.empresa_id 	= empresa_id,
			this.busca.qtd_pagina 	= null
		},

		atualizarLista: function(e){
			$("#campo_pesquisa").val("");
			$("#campo_pesquisa").focus();

			this.limparFiltro();
			btnAtualizar();
			atualizarListaAcesso();
		},

		proximaPagina: function(){

			if(this.busca.pagina <= this.qtd_pagina){
				this.busca.pagina ++;
				atualizarListaAcesso();
			}
		},

		paginaAnterior: function(){
			if(this.busca.pagina > 0){
				this.busca.pagina --;
				atualizarListaAcesso();
			}
		}
	}
});

// Listando os acessos
atualizarListaAcesso();

// Deixando a linha do tempo fixa ao rolar a página
$(window).scroll(function(){
	var left = $("#linha_tempo").offset().left;
	var scroll_top = $(this).scrollTop();

	// Configurando a posição da linha do tempo
	if(scroll_top >= 402){
		$("#linha_tempo").css("margin", "0");
		$("#linha_tempo").css("position", "fixed");
		$("#linha_tempo").css("top", "0px");
		$("#linha_tempo").css("left", left + "px");

	}else {
		$("#linha_tempo").css("margin", "");
		$("#linha_tempo").css("position", "");
		$("#linha_tempo").css("top", "");
		$("#linha_tempo").css("left", "");
	}
});

// Realizando a pesquisa quando digitado
$("#campo_pesquisa").keyup(function(){
	var valor = $(this).val();

	// Cancelando timer anterior (se houver)
	clearInterval(timer);

	// Tempo de espera antes de realizar a pesquisa
	timer = setTimeout(function(){

		if(valor != "") atualizarListaAcesso();
		else atualizarListaAcesso();

	}, 500);
});

$("#lista_tipo_usuario").change(function(){
	atualizarListaAcesso();
});

$("#data").change(function(){
	var data = $(this).val();
	var dataSeparada = data.split("-");

	app.busca.filtro = dataSeparada[2] + "/" + dataSeparada[1] + "/" + dataSeparada[0][2] + dataSeparada[0][3];
	atualizarListaAcesso();
});

// Preenche a lista de acessos
function atualizarListaAcesso(){

	// 'Zerando' a ultima data
	app.controle.ult_data = null;

	// Mostrando o loader
	btnCarregando();

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
		app.lista_acesso = lista_acesso;

		// Mostrando aviso de nada encontrado
		if(app.lista_acesso.length == 0) $(".nada_encontrado").fadeIn(0);
		else $(".nada_encontrado").fadeOut(0);

		// Escondendo o loader
		btnAtualizar();

		$(".load_lista").fadeOut(100);
	});
}

// Mostra o botão de carregando
function btnCarregando(){
	$(".loader").children(".loader_circulo").addClass("loader_circulo_animacao");
}

// Mostra o botão de atualizar
function btnAtualizar(){
	$(".loader").children(".loader_circulo").removeClass("loader_circulo_animacao");
}