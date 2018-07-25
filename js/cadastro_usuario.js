$(function(){
	imagem = null;
	loader = new Loader();
	cpf_usuario = "";
	img_edit = "";
	id_usuario = 0;

	var modo = url_param("modo");

	if(modo == "edit") {
		editar_usuario(url_param("id"));
	}


	$("#btn_cadastro").click(function(e){
		e.preventDefault();
		var campos_preenchidos = validar_campos_texto(".form_txt") && validar_comboBox(".form_cbo") && (imagem != null);
		
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

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("nome", nome);
			formData.append("cpf", cpf);
			formData.append("rg", rg);
			formData.append("dt_nascimento", dt_nascimento);
			formData.append("documento", documento);
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
			alert("Algum campos não foi preenchido ou foi preenchido incorretamente, por favor verifique e tente outra vez.");
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
				alert("Extensão inválida");
			}else{
				imagem = this.files[0];

				$("#nome_arquivo").text(arquivo);
			}
		}else{
			$("#nome_arquivo").text("");
			imagem = null;
		}
	});

	$("#cpf").on("keyup keydown", function(){
		var cpf = $(this).val();
		
		if(cpf.length <= 14) {
			cpf = cpf.replace(/\D*/g, "");
			cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "$1.$2.$3-$4");

			$(this).val(cpf);	
		}else{
			$(this).val(cpf.substring(0,12));
		}
		
	});

	$("#rg").on("keyup keydown", function(){
		var rg = $(this).val();
		
		if(rg.length <= 12) {
			rg = rg.replace(/\D*/g, "");
			rg = rg.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/g, "$1.$2.$3-$4");

			$(this).val(rg);	
		}else{
			$(this).val(rg.substring(0,12));
		}
		
	});

	$("#tel").on("keyup keydown", function(){
		var tel = $(this).val();
		
		if(tel.length <= 14) {
			tel = tel.replace(/\D*/g, "");
			tel = tel.replace(/(\d{2})(\d{4,5})(\d{4})/g, "($1)$2-$3");

			$(this).val(tel);	
		}else{
			$(this).val(tel.substring(0,12));
		}
		
	});
});

function validar(nome, cpf, dt_nascimento, email, tel){
	var campos_validos = eTexto(nome) && eCpf(cpf) && eData(dt_nascimento) && eEmail(email) && eTel(tel);

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

		carregar_info_usuario(cpf_usuario);
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