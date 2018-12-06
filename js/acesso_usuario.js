
// Ajax utilizado para obter a lista de acesso
var ajax = null;
var timer = null;

// VueJs
var app = new Vue({
	el: '#principal',
	data: {
		lista_acesso: [],
		loader: false,

		controle: {
			ult_data: null,
			ult_data_linha_tempo: null,
			pagina_atual: 1,
			limite: 50
		}
	},

	methods: {
		liberacaoClass: function(liberacao) {
			return (liberacao == 1)? "liberado" : "bloqueado";
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

		atualizarLista: function(e){
			$("#campo_pesquisa").val("");
			$("#campo_pesquisa").focus();

			btnAtualizar();
			listarAcesso(null, "todos");
		}
	}
});

// Obtendo o ID da empresa do usuário
var empresa_id = $("#principal").attr("name");

// Listando os acessos
listarAcesso(null, "todos");

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

	// Verificando se o scroll está no fim
	if($(this).scrollTop() + $(this).height() == $(document).height()){
		listarAcesso(null, "continuar");
	}
});

// Realizando a pesquisa quando digitado
$("#campo_pesquisa").keyup(function(){
	var valor = $(this).val();

	// Cancelando timer anterior (se houver)
	clearInterval(timer);

	// Tempo de espera antes de realizar a pesquisa
	timer = setTimeout(function(){

		if(valor != "") listarAcesso(valor, "pesquisa");
		else listarAcesso(null, "todos");

	}, 500);
});

// Preenche a lista de acessos
function listarAcesso(valor, modo){

	// Parâmetros para a API
	var dados = {
		pagina: 	null,
		filtro: 	null,
		limite: 	app.limite,
		empresa_id: empresa_idl
		tipo_usuario: ""
	};

	// Valor do campo de pesquisa
	var valor_pesquisa = $("#campo_pesquisa").val();

	app.ult_data 			 =  null;
	app.ult_data_linha_tempo =  null;

	if(modo == "todos"){

		// Atualizando a página atual
		app.pagina_atual = 1;

		dados = {
			pagina: app.pagina_atual,
			filtro: ""
		}
	}

	if(modo == "pesquisa"){

		// Atualizando a página atual
		app.pagina_atual = 1;

		dados = {
			pagina: app.pagina_atual,
			filtro: valor
		}

	}

	if(modo == "continuar"){

		// Atualizando a página atual
		app.pagina_atual ++;

		dados = {
			pagina: app.pagina_atual,
			filtro: valor_pesquisa
		}

		$(".load_lista").fadeIn(200);
	}

	// Mostrando o loader
	btnCarregando();

	// Preenchendo a lista de registro de acesso
	ajax = $.ajax({

		url:  "api/listar_pessoas.php",
		data: dados

	}).done(function(resultado){

		// Convertendo para JSON a lista de pessoas
		var lista_acesso = $.parseJSON(resultado);

		// Preenchendo a lista de acesso
		if(modo == "continuar"){

			if(lista_acesso != 0)
				app.lista_acesso = app.lista_acesso.concat(lista_acesso);

		} else app.lista_acesso = lista_acesso;

		// Mostrando aviso de nada encontrado
		if(app.lista_acesso.length == 0){
			$(".nada_encontrado").fadeIn(0);
			$("#linha_tempo").fadeOut(0);
			
		}else {
			$(".nada_encontrado").fadeOut(0);
			$("#linha_tempo").fadeIn(0);
		}

		// Escondendo o loader
		btnAtualizar();

		$(".load_lista").fadeOut(100);
	});
}

// Mostra o botão de carregando
function btnCarregando(){
	$(".loader").css("width", "280px");
	$(".loader").children("span").text("carregando");
	$(".loader").children(".loader_circulo").addClass("loader_circulo_animacao");
}

// Mostra o botão de atualizar
function btnAtualizar(){
	$(".loader").css("width", "");
	$(".loader").children("span").text("atualizar");
	$(".loader").children(".loader_circulo").removeClass("loader_circulo_animacao");
}