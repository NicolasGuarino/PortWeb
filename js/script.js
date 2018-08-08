$(function() {
	tipo_usuario_id = localStorage.getItem("tipo_usuario_id");
});


function validar_campos_texto(classe){
	var campos_preenchidos = true;

	$(classe).each(function(){
		if($(this).val() == '') {
			$(this).css("border", "solid 1px #ff2233");
			campos_preenchidos = false;
		}else{
			$(this).css("border", "solid 1px #aaa");
		}
	});

	return campos_preenchidos;
}

function validar_radio(classe){
	var campos_preenchidos = true;

	$(classe).each(function(){
		if(!$(this).prop("checked") && $(classe + ":checked").size() == 0){
			$(this).next().css("border","solid 1px #ff2233");
			campos_preenchidos = false;
		}else{
			$(this).next().css("border","solid 1px #000");
		}
	});

	return campos_preenchidos;
}

function validar_comboBox(classe){
	var campos_preenchidos = true;

	$(classe).each(function(){
		
		if($(this).children("option:selected")[0].value != "0"){
			$(this).css("border","none");
		}else{
			$(this).css("border","solid 1px #ff2233");
			campos_preenchidos = false;
		}
	});

	return campos_preenchidos;
}

function validar_campo(valor, elemento, cor_borda_erro, cor_borda_ok) {
	var resultado = false;

	if(!valor) {
		elemento.css("border", "solid 1px " + cor_borda_erro);
		resultado = false;
	}else{
		elemento.css("border", "solid 1px " + cor_borda_ok);
		resultado = true;
	}

	return resultado;
}

function mascara_cpf() {
	var cpf = $(this).val();

	if(cpf.length <= 14) {
		cpf = cpf.replace(/\D*/g, "");
		cpf = cpf.replace(/([0-9]{3})([0-9]{1})/y, "$1.$2");
		cpf = cpf.replace(/([0-9]{3})\.([0-9]{3})([0-9]{1})/y, "$1.$2.$3");
		cpf = cpf.replace(/([0-9]{3})\.([0-9]{3})\.([0-9]{3})([0-9]{1})/y, "$1.$2.$3-$4");
	}else{
		cpf = cpf.substr(0, 14);
	}

	$(this).val(cpf);
}

function mascara_rg() {
	var rg = $(this).val();

	if(rg.length <= 12) {
		rg = rg.replace(/\D*/g, "");
		rg = rg.replace(/([0-9]{2})([0-9]{1})/y, "$1.$2");
		rg = rg.replace(/([0-9]{2})\.([0-9]{3})([0-9]{1})/y, "$1.$2.$3");
		rg = rg.replace(/([0-9]{2})\.([0-9]{3})\.([0-9]{3})([0-9]{1})/y, "$1.$2.$3-$4");
	}else{
		rg = rg.substr(0, 12);
	}

	$(this).val(rg);
}

function mascara_tel() {
	var tel = $(this).val();

	if(tel.length <= 14) {
		tel = tel.replace(/\D*/g, "");
		tel = tel.replace(/([0-9]{2})([0-9]{1})/y, "($1)$2");
		tel = tel.replace(/\(([0-9]{2})\)([0-9]{4,5})([0-9]{1})/y, "($1)$2-$3");
	}else{
		tel = tel.substr(0, 14);
	}

	$(this).val(tel);
}

function mascara_placa() {
	var placa = $(this).val();

	if(placa.length <= 10) {
		placa = placa.toUpperCase();
		placa = placa.replace(/([a-zA-Z]{3})([0-9]{1})/g, "$1 - $2");
		placa = placa.replace(/([a-zA-Z]{3})-([0-9]{1})/g, "$1 - $2");
		placa = placa.replace(/([a-zA-Z]{3}) -([0-9]{1})/g, "$1 - $2");
		placa = placa.replace(/([a-zA-Z]{3})- ([0-9]{1})/g, "$1 - $2");
	}else{
		placa = placa.substr(0, 10);
	}

	$(this).val(placa);
}

function eTexto(texto){
	var regex = /[0-9_*-+.!@#$%¨¨&*\(\)_+=<>:;?\\\/\]\}\{\[\§£¢¬]/g;
	var campos_validos = (regex.exec(texto) == null) ? true: false;
	return campos_validos && texto != "";
}

function eCpf(cpf){
	var regex  = /(\d{3}).(\d{3}).(\d{3})-(\d{2})/g;
	var valido = false;

	if(regex.test(cpf)) {
		valido = validaCPF(cpf);
	}

	return valido;	
}

function eRG(rg){
	var regex  = /(\d{2}).(\d{3}).(\d{3})-(\d{1})/g;
	var valido = false;

	if(regex.test(rg)) {
		valido = validaRG(rg);
	}

	return valido;	
}

function eData(data){
	var regex = /(\d{4})-(\d{2})-(\d{2})/g;
	var data_invalida = isNaN(Date.parse(data));
	
	return regex.test(data) && !data_invalida;	
}

function eEmail(email){
	var regex = /[a-zA-Z]@[a-zA-Z]/g;

	return regex.test(email);
}

function eTel(tel){
	var regex = /\((\d{2})\)(\d{4,5})-(\d{3,4})/g;
	
	return regex.test(tel);	
}

function ePlaca(placa){
	var regex = /([a-zA-Z]{3}) \- (\d{4})/g;
	
	return regex.test(placa);	
}

function eHora(hora){
	var regex = /(\d{2})\:(\d{2})/g;
	var hora_valida = (hora.substr(0,2) < 24 && hora.substr(0,2) >= 0) && (hora.substr(3) <= 59 && hora.substr(3) >= 0);

	return regex.test(hora) && hora_valida;	
}

function validaCPF(cpf) {
	var valido = true;
	var soma = 0, resto;

	// Removendo a formatação
	cpf = cpf.replace(/\./g, "");
	cpf = cpf.replace(/\-/g, "");

	// Calculando o primeiro numero do digito verificador
    for (i=1; i<=9; i++)  soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
    resto = ((soma * 10) % 11 >= 10? 0: (soma * 10) % 11); // O primeiro número não pode passar de 10

	// Verificando se o primeiro numero do digito verificador é igual ao numero calculado
	if (resto != parseInt(cpf.substring(9, 10))) valido = false; 
		
	// Calculando o segundo numero do digito verificador
	soma = 0;
    for(i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
    resto = ((soma * 10) % 11 >= 10? 0: (soma * 10) % 11); // O primeiro número não pode passar de 10

    // Verificando se o primeiro numero do digito verificador é igual ao numero calculado
    if (resto != parseInt(cpf.substring(10, 11))) valido = false;

    return valido;
}

function validaRG(rg) {
	var valido = true;
	var soma = 0, resto;

	// Removendo a formatação
	rg = rg.replace(/\./g, "");
	rg = rg.replace(/\-/g, "");

	// Verificando se o último digito é valido
    for (i=1; i<=9; i++) {
    	if(i == 9) soma += parseInt(rg.substring(i-1, i)) * 100;
    	else soma += parseInt(rg.substring(i-1, i)) * (i+1);
    }

    if(soma % 11 != 0) valido = false;

    return valido;
}

function verificaExistencia(campo, valor) {
	var existe = false;

	$.ajax({
		url:"api/verificar_existencia.php", 
		data: { campo: campo, valor:valor },
		async: false
	}).done(function(retorno) { 
		retorno = $.parseJSON(retorno);
		existe = retorno.resultado;
	});

	return existe;
}

function retorna_parametro_url(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	if(results != null) return results[1] || 0;
	else return 0;
}

function temItem(lista, campo_procurado, item_procurado) {
	var temItem = false;

	$.each(lista, function(index, item){
		if(item[campo_procurado] == item_procurado) {
			temItem = true;
			return false;
		}
	});

	return temItem;
}

function retornaItem(lista, campo_procurado, item_procurado) {
	var item_retorno = {};

	$.each(lista, function(index, item){
		if(item[campo_procurado] == item_procurado) {
			item_retorno = item;
			return false;
		}
	});
	
	return item_retorno;
}

function tratar_retorno(retorno, texto_positivo, texto_negativo, funcao_positivo = null, funcao_negativo = null) {
	if(retorno.valor) {
		loader.encerrar("img/icones/ic_okay.png", texto_positivo);
		if(funcao_positivo != null) funcao_positivo();
    }else{
    	loader.encerrar("img/icones/ic_erro.png", texto_negativo);
    	if(funcao_negativo != null) funcao_negativo();
	}

	return retorno.valor;
}

function Notificacao() {
	this.mostrar = function(titulo, conteudo, tipo, alvo, time = 0) {
		var el_notificacao  = $(document.createElement("div")).addClass("notificacao");
		var el_titulo	 	= $(document.createElement("span")).addClass("titulo");
		var el_conteudo 	= $(document.createElement("span")).addClass("conteudo");
		var ic_fechar 		= $(document.createElement("i")).addClass("fa fa-times fechar");

		el_titulo.text(titulo);
		el_conteudo.text(conteudo);

		ic_fechar.click(function() { $(this).parent().remove(); });
		
		switch(tipo.toUpperCase()) {
			case "SUCESSO":
				el_notificacao.addClass("sucesso");
				break;
			case "ERRO":
				el_notificacao.addClass("erro");
				break;
			case "AVISO":
				el_notificacao.addClass("aviso");
				break;
			case "INFO":
				el_notificacao.addClass("info");
				break;
		}

		el_notificacao.append(el_titulo);
		el_notificacao.append(el_conteudo);
		el_notificacao.append(ic_fechar);
		
		$(alvo).prepend(el_notificacao);
		$(el_notificacao).css("display", "table");

		if(time != 0) {
			setTimeout(function() {
				$(el_notificacao).fadeOut(500);
			}, time);

			setTimeout(function() { $(el_notificacao).remove(); }, time + 600);
		}
	}
}

function Loader() {
	this.fundo = $(document.createElement("div")).attr("id", "background"),
	this.container = $(document.createElement("div")).attr("id", "loader_container"),
	this.loader = $(document.createElement("div")).attr("id", "bola"),
	this.titulo = $(document.createElement("span")),
	this.iniciar = function(){
		$(this.titulo).text("Carregando...");

		$("body").prepend(this.fundo);
		$(this.fundo).append(this.container)
		$(this.container).append(this.loader);
		$(this.container).append(this.titulo);

		$(this.fundo).fadeIn();
		
		$("#bola").css("background", "#ffc55a");
		$("#bola").css("animation", "pular 400ms ease infinite alternate");
	},
	this.encerrar = function(imagem, texto) {
		$("#loader_container span").text(texto);
		$("#bola").css("background", "transparent url("+ imagem +") 0 0 / 100% 100%");
		$("#bola").css("top", "-5px");
		$("#bola").css("animation", "parar 400ms ease alternate");
		
		var fundo = this.fundo;

		setTimeout(function(){ 
			$("#background").fadeOut();
			$(fundo).remove();

		}, 2000);
	}
}