$(function(){
	$(".card_opcao").click(function(){
		var id = $(this).attr("id");

		switch(id) {
			case 'usuario':
				window.location = "usuarios_cadastrados_lista.php";
				break;
			case 'documentos':
				window.location = "cadastro_documento.php";
				break;
			case 'empresa':
				window.location = "empresas_lista.php";
				break;

			case 'lista_acesso':
				window.location = "acesso_usuario.php";
				break;
		}
	});
});