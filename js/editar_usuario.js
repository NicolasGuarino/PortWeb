$(function() {
	$("#btn_editar").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt") && validar_comboBox(".form_cbo");

		var nome = $("#nome").val();
		var cpf = $("#cpf").val();
		var rg = $("#rg").val();
		var dt_nascimento = $("#dt_nascimento").val();
		var documento = $("#documento").val();
		var tipo_usuario = $("#tipo").val();
		var email = $("#email").val();
		var tel = $("#tel").val();
	
		var campos_validos = validar(nome, cpf, dt_nascimento, email, tel);

		cpf_usuario = cpf;

		if(campos_preenchidos && campos_validos) {
			if(imagem != null) var atualizarImg = "true"; 
			else var atualizarImg = img_edit;
			
			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("usuario_id", id_usuario);
			formData.append("nome", nome);
			formData.append("cpf", cpf);
			formData.append("rg", rg);
			formData.append("dt_nascimento", dt_nascimento);
			formData.append("documento", documento);
			formData.append("tipo_usuario", tipo_usuario);
			formData.append("imagem", imagem);
			formData.append("email", email);
			formData.append("tel", tel);
			formData.append("atualizarImg", atualizarImg);

			$.ajax({
				url: "api/editar_usuario.php",
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,                    
                beforeSend: loader.iniciar(),
                success: tratar_resultado_envio
			});
		}else {
			alert("Algum campos não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez.");
		}
			
	});
});

function editar_usuario(id) {
	var usuario = JSON.parse(localStorage.getItem("usuario" + id));
	
	img_edit = usuario.foto;
	id_usuario = id;

	$("#nome").val(usuario.nome);
	$("#cpf").val(usuario.cpf);
	$("#rg").val(usuario.rg);
	$("#email").val(usuario.email);
	$("#tel").val(usuario.telefone);
	$("#dt_nascimento").val(usuario.data_nascimento);
	$("#documento").val(usuario.numero_documento);
	$("#tipo").val(usuario.tipo_usuario);
	$("#nome_arquivo").text(usuario.foto);

	$("#btn_cadastro").val("Editar");
	$("#btn_cadastro").attr("id", "btn_editar");
	$(".tit").text("Editar usuário");
}