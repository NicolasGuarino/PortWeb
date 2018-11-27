// Lista de acessos
var lista_acesso = [];

// Ajax utilizado para obter a lista de acesso
var ajax = null;

var timer = null;

// VueJs
var app = new Vue({
	el: '#principal',
	data: {
		lista_acesso: lista_acesso,
		loader: false
	},

	methods: {
		liberacaoClass: liberacao => {return (liberacao == 1)? "liberado" : "bloqueado"},
		liberacaoStyle: liberacao => {return (liberacao == 1)? "linha_verde" : "linha_vermelha"},
		backgroundImageUrl: texto => {return 'url("' + texto + '")'}
	}
});

// Obtendo o ID da empresa do usuário
var empresa_id = $("#principal").attr("name");

// Listando os acessos
listarAcesso();

// Realizando a pesquisa quando digitado
$("#campo_pesquisa").keyup(function(){
	var valor = $(this).val();

	// Cancelando timer anterior (se houver)
	clearInterval(timer);

	// Tempo de espera antes de realizar a pesquisa
	timer = setTimeout(function(){

		if(valor != "") listarAcesso(valor);
		else listarAcesso();

		// Mostrando o loader
		$(".loader").fadeIn(250);

	}, 500);
});

// Preenche a lista de acessos
function listarAcesso(nome){
	var dados = {
		limite: 50,
		pagina: 1,
		empresa_id: empresa_id
	};

	if(nome != null){
		dados = {
			empresa_id: empresa_id,
			filtro: 	nome
		};
	}

	// Mostrando o loader
	$(".loader").fadeIn(250);

	// Preenchendo a lista de registro de acesso
	ajax = $.ajax({

		url:  "api/listar_pessoas.php",
		data: dados

	}).done(function(resultado){

		// Preenchendo a lista de acessos
		app.lista_acesso = $.parseJSON(resultado)

		// Escondendo o loader
		$(".loader").fadeOut(250);
	});
}