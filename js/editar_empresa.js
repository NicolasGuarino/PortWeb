$(function() {
	var id = retorna_parametro_url("id");
	img_edit = "";

	if(id) {
		carregar_info_empresa(id);
	}

	$("#btn_editar").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt");
			
		var nome = $("#nome").val();
		var telefone = $("#telefone").val();
		var email = $("#email").val();

		var img_ok = validar_campo($("#nome_arquivo") != "", $("#nome_arquivo").parent(), "#ff2233", "#aaa");
		var tel_ok = validar_campo(eTel(telefone), $("#telefone"), "#ff2233", "#aaa");
		var email_ok = validar_campo(eEmail(email), $("#email"), "#ff2233", "#aaa");


		if(campos_preenchidos && tel_ok && email_ok) {
			if(imagem != null) var atualizarImg = "true";
			else var atualizarImg = img_edit;

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("nome", nome);
			formData.append("telefone", telefone);
			formData.append("email", email);
			formData.append("imagem", imagem);
			formData.append("atualizarImg", atualizarImg);
			formData.append("empresa_id", id);

			$.ajax({
				url: "api/editar_empresa.php",
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,                    
                beforeSend: loader.iniciar(),
                success: tratar_resultado_envio
			});
		}else{
			notificacao.mostrar("Erro! ", "Preencha todos os campos corretamente", "erro", $("#principal"), 1500);
		}
			
	});
});

function carregar_info_empresa(id) {
	var empresa = JSON.parse(localStorage.getItem("empresa"+id));

	$("#nome").val(empresa.nome);
	$("#telefone").val(empresa.telefone);
	$("#email").val(empresa.email);
	$("#nome_arquivo").text(empresa.caminho_img);
	$("#btn_cadastro").attr("id", "btn_editar");

	img_edit = empresa.caminho_img;
}