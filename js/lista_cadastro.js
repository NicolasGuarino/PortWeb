$(function(){
	var time;

	time = setInterval(consultar, 1000);
});

function consultar(){
	$.ajax({
		url: "consultar_lista_cadastro.php",

		success: function(data){
			var lista = JSON.parse(data);
			var str = "";

			for(i=0; i<lista.length; i++){
				str += "<div><a href='imagem_oculta_etiqueta/impressao.php?documento_id="+ lista[i].documento_id +"'>" + lista[i].nome + "</a></div>";
			}

			console.log("Consulta");
			$("#main").html(str);
		}
	});
}