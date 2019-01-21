$(function(){
	imagem = null;
	loader = new Loader();
	cpf_usuario = "";
	img_edit = "";
	id_usuario = 0;
	notificacao = new Notificacao();

	var modo = retorna_parametro_url("modo");

	if(modo == "edit") {
		editar_usuario(retorna_parametro_url("id"));
	}

	$("#voltar").click(function() { window.location = "usuarios_cadastrados_lista.php" });


	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var texto_ok = validar_campos_texto(".form_txt");
		var combobox_ok =  validar_comboBox(".form_cbo");
		var img_ok = validar_campo(imagem != null, $("#nome_arquivo").parent(), "#ff2233", "#aaa");
		
		var nome = $("#nome").val();
		var cpf = $("#cpf").val();
		var rg = $("#rg").val();
		var dt_nascimento = $("#dt_nascimento").val();
		var empresa = $("#empresa").val();
		var tipo_usuario = $("#tipo").val();
		var email = $("#email").val();
		var tel = $("#tel").val();
		
		if(empresa == undefined) {
			empresa = $("#principal").attr("name");
		}

		if(tipo_usuario == undefined) {
			tipo_usuario = 1;
		}

		var campos_validos = validar(nome, cpf, dt_nascimento, email, tel, rg);

		cpf_usuario = cpf;

		var campos_preenchidos = texto_ok && combobox_ok;

		if(campos_preenchidos && campos_validos) {
			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("nome", nome);
			formData.append("cpf", cpf);
			formData.append("rg", rg);
			formData.append("dt_nascimento", dt_nascimento);
			formData.append("empresa", empresa);
			formData.append("tipo_usuario", tipo_usuario);
			formData.append("imagem", imagem);
			formData.append("email", email);
			formData.append("tel", tel);

			$.ajax({
				url: "api/inserir_usuario.php",
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,                    
                beforeSend: loader.iniciar(),
                success: tratar_resultado_envio
			});
		}else {
			notificacao.mostrar("Erro! ", "Algum campos não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez", "erro", $("#conteudo"), 1500);
		}
			
	});


	$("#botao_upload").click(function(e){
		e.preventDefault();
		$("#arquivo_foto").trigger("click"); 
	});

	$("#arquivo_foto").change(function(){
		var arquivo, ext, lst_ext_permitidas;
		
		if(this.files[0]) {
			arquivo = this.files[0].name;
			ext = retorna_extensao(this.files[0]);
			lst_ext_permitidas = ['png', 'jpg', 'jpeg'];

			if($.inArray(ext.toLowerCase(), lst_ext_permitidas) == -1) {
				notificacao.mostrar("Erro! ", "Extensão inválida", "erro", $("#conteudo"), 1500);
			}else{
				imagem = this.files[0];

				$("#nome_arquivo").text(arquivo);
			}
		}else{
			$("#nome_arquivo").text("");
			imagem = null;
		}
	});

	$("#cpf").on("keyup keydown", mascara_cpf);
	$("#rg").on("keyup keydown", mascara_rg);
	$("#tel").on("keyup keydown", mascara_tel);
});

function validar(nome, cpf, dt_nascimento, email, tel, rg){
	var existencia = true;
	if(!retorna_parametro_url("modo")) existencia = !verificaExistencia("cpf", cpf) && !verificaExistencia("rg", rg);

	var nome_ok = validar_campo(eTexto(nome), $("#nome"), "#ff2233", "#aaa");
	var cpf_ok = validar_campo(eCpf(cpf), $("#cpf"), "#ff2233", "#aaa");
	var data_ok = validar_campo(eData(dt_nascimento), $("#dt_nascimento"), "#ff2233", "#aaa");
	var email_ok = validar_campo(eEmail(email), $("#email"), "#ff2233", "#aaa");
	var tel_ok = validar_campo(eTel(tel), $("#tel"), "#ff2233", "#aaa");
	// var rg_ok = validar_campo(eRG(rg), $("#rg"), "#ff2233", "#aaa");
	var rg_ok = true;

	var campos_validos = nome_ok && cpf_ok && data_ok && email_ok && tel_ok && rg_ok && existencia;

	return campos_validos;
}

function retorna_extensao(arquivo) {
	var ext = arquivo.type.toString();
	ext = ext.substring(ext.indexOf("/") + 1);

	return ext;
}

function tratar_resultado_envio(resultado){
	if(resultado == 1) {
		loader.encerrar("img/icones/ic_okay.png", "Usuario cadastrado com sucesso");
		limpar_caixas();

		window.location = "cadastro_usuario.php?cpf=" + cpf_usuario; 
    }else{
    	loader.encerrar("img/icones/ic_erro.png", "Ocorreu algum erro");
    	console.log(resultado);
    }
}

function limpar_caixas() {
	$("#nome_arquivo").text("");
	imagem = null;

	$(".form_txt").each(function(){ $(this).val(""); });
	$(".form_cbo").each(function(){ $(this).children("option:first")[0].selected = true; });
}