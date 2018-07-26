function validar_campos_texto(classe){
	var campos_preenchidos = true;

	$(classe).each(function(){
		if($(this).val() == '') {
			$(this).css("outline", "solid 1px #ff2233");
			campos_preenchidos = false;
		}else{
			$(this).css("outline", "none");
		}
	});

	return campos_preenchidos;
}

function validar_radio(classe){
	var campos_preenchidos = true;

	$(classe).each(function(){
		if(!$(this).prop("checked") && $(classe + ":checked").size() == 0){
			$(this).css("outline","solid 1px #ff2233");
			campos_preenchidos = false;
		}else{
			$(this).css("outline","none");
		}
	});

	return campos_preenchidos;
}

function validar_comboBox(classe){
	var campos_preenchidos = true;

	$(classe).each(function(){
		
		if($(this).children("option:selected")[0].value != "0"){
			$(this).css("outline","none");
		}else{
			$(this).css("outline","solid 1px #ff2233");
			campos_preenchidos = false;
		}
	});

	return campos_preenchidos;
}

function url_param(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	if(results != null) return results[1] || 0;
	else return 0;
}

// function mascara_cpf() {
// 	var cpf = $(this).val();

// 	if(cpf.length <= 14) {
// 		cpf = cpf.replace(/\D*/g, "");
// 		cpf = cpf.replace(/([1-9]{3})([1-9]{1})/g, "$1.$2");
// 		cpf = cpf.replace(/([1-9]{3}).([1-9]{3})([1-9]{1})/g, "$1.$2.$3");
// 		// cpf = cpf.replace(/([1-9]{3}).([1-9]{3}).([1-9]{3})([1-9]{1})/g, "$1.$2.$3-$4");
// 	}else{
// 		cpf = cpf.substr(0, 14);
// 	}

// 	$(this).val(cpf);
// }

function mascara_rg() {

}

function mascara_tel() {

}

function eTexto(texto){
	var regex = /[0-9_*-+.!@#$%¨¨&*\(\)_+=<>:;?\\\/\]\}\{\[\§£¢¬]/g;
	var campos_validos = (regex.exec(texto) == null) ? true: false;
	return campos_validos;
}

function eCpf(cpf){
	var regex = /(\d{3}).(\d{3}).(\d{3})-(\d{2})/g;
	
	return regex.test(cpf);	
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
	var regex = /\((\d{2})\)(\d{4,5})-(\d{4})/g;
	
	return regex.test(tel);	
}

function ePlaca(placa){
	var regex = /([a-zA-Z]{3})\-(\d{4})/g;
	
	return regex.test(placa);	
}

function eHora(hora){
	var regex = /(\d{2})\:(\d{2})/g;
	var hora_valida = (hora.substr(0,2) < 24 && hora.substr(0,2) >= 0) && (hora.substr(3) < 59 && hora.substr(3) >= 0);

	return regex.test(hora) && hora_valida;	
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