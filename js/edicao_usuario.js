$(function(){
	
	$("#editar").click(function(){
		var id = $(this).attr("id");

		$("#upload_container").css("background", $("#foto").css("background"));

		$(".texto").each(function(index, item){
			var nome = $(this).prev().text().trim().replace(":", "").toLowerCase();
			$("#"+nome).val($(this).text());
		});

		$("#modo_visualizacao").fadeOut(50, "linear");
		$("#form_edicao").fadeIn(250, "linear");
	});

	$(".form_btn").click(function(e){
		e.preventDefault();

		var campos_preenchidos = validar_campos_texto(".form_txt") && validar_comboBox(".form_cbo") && (imagem != null);

		var nome = $("#nome").val();
		var cpf = $("#cpf").val();
		var dt_nascimento = $("#dt_nascimento").val();
		var documento = $("#documento").val();
		var tipo_usuario = $("#tipo").val();
		var email = $("#email").val();
		var tel = $("#tel").val();

		cpf_usuario = cpf;

		var campos_validos = validar(nome, cpf, dt_nascimento, email, tel);

		if(campos_preenchidos && campos_validos) {

			// Dados a serem enviados
    		var formData = new FormData();
			formData.append("nome", nome);
			formData.append("cpf", cpf);
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