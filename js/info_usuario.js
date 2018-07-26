$(function(){
	cpf = url_param("cpf");
	usuario_id = 0;

	if(cpf) {
		carregar_info_usuario(cpf);
		
		$("#sl_status").change(function() {
			var status = $(this).val();

			if(status != 0) {
				$.ajax({
					url: "api/atualizar_status.php",
					data: {status:status, usuario_id: usuario_id}
				}).done(function(resultado){ console.log(resultado); });
			}
		});
	}

});

function carregar_info_usuario(cpf) {
	$.getJSON("api/carregar_detalhes_usuario.php", {cpf:cpf}, function(retorno) {
		$("#form_user").fadeOut(600);
		$("#perfil_usuario").fadeIn(700);
		$(".container_tit").children(".texto").text("Detalhes usuário");

		var usuario = retorno[0];
		var foto = usuario.foto;
		usuario_id = usuario.usuario_id;

		if(foto == null) foto = "img/icones/ic_noImage.png";

		$("#cadastrar_escala").click(function() { window.location = "cadastro_escala.php?id=" + usuario.usuario_id + "&cpf=" + usuario.cpf});
		$("#cadastrar_veiculo").click(function() { window.location = "cadastro_veiculo.php?id=" + usuario.usuario_id + "&cpf=" + usuario.cpf});
		
		$("#edit_user").click(function() { 
			var usuario_editar = {
				nome: usuario.nome,
				foto: usuario.foto,
				email: usuario.email,
				data_nascimento: usuario.data_nascimento,
				cpf: usuario.cpf,
				documento_id: usuario.documento_id,
				numero_documento: usuario.numero_etiqueta,
				telefone: usuario.telefone,
				rg: usuario.rg,
				tipo_usuario: usuario.tipo_usuario_id
			};

			localStorage.setItem("usuario" + usuario.usuario_id, JSON.stringify(usuario_editar));
			window.location = "cadastro_usuario.php?modo=edit&id=" + usuario.usuario_id
		});

		$("#delete_user").click(function(){
			$.ajax({
				url: "api/deletar_usuario.php",
				data: {usuario_id: usuario.usuario_id }
			}).done(function(){ window.location = "usuarios_cadastrados_lista.php" });
		});
		
		$("#nome_usuario").text(usuario.nome);
		$("#foto_usuario").css("background", "url('"+ foto +"') center / cover no-repeat");
		$("#foto_usuario").attr("name", usuario.usuario_id);
		$("#email_usuario").children(".valor").text(usuario.email);
		$("#data_nascimento_usuario").children(".valor").text(usuario.data_nascimento_f);
		$("#cpf_usuario").children(".valor").text(usuario.cpf);
		$("#documento_usuario").children(".valor").text(usuario.numero_etiqueta);
		$("#tel_usuario").children(".valor").text(usuario.telefone);
		$("#rg_usuario").children(".valor").text(usuario.rg);
		$("#status").children("#sl_status").val(usuario.status_id);

		if(usuario.escala.length > 1) {
			$("#cadastrar_escala").fadeOut();
			$("#escala").css("display", "table");
			preencher_escala(usuario.escala);
		}
			
		if(usuario.veiculos.length > 1) {
			$("#veiculos").fadeIn();

			for(var i in usuario.veiculos) {
				var veiculo = usuario.veiculos[i];
				
				if(veiculo.length != 0) {
					$("#veiculos").append(criar_cardVeiculo(veiculo));
				}
			}
		}
	});
}

function criar_cardVeiculo(veiculo_info) {
	var card_veiculo = $(document.createElement("div")).addClass("card_veiculo");
	var foto_veiculo = $(document.createElement("div")).addClass("foto_carro");
	var placa = $(document.createElement("div")).addClass("placa");

	var ic_editar = $(document.createElement("div")).addClass("ic_editar");
	var ic_deletar = $(document.createElement("div")).addClass("ic_deletar");

	foto_veiculo.css("background", "url('"+ veiculo_info.foto +"') center / contain no-repeat");
	placa.text(veiculo_info.placa);

	ic_editar.click(function() { 
		var veiculo = {
			veiculo_id: veiculo_info.veiculo_id,
			documento_id: veiculo_info.documento_id,
			num_documento: veiculo_info.numero_etiqueta,
			placa: veiculo_info.placa,
			modelo: veiculo_info.modelo,
			marca: veiculo_info.marca,
			cor: veiculo_info.cor,
			foto: veiculo_info.foto
		};

		localStorage.setItem("veiculo" + veiculo_info.veiculo_id, JSON.stringify(veiculo));
		window.location = "cadastro_veiculo.php?id=" + veiculo_info.veiculo_id + "&modo=editar&cpf=" + cpf;
	});

	ic_deletar.click(function() {
		var card = $(this).parent();

		$.ajax({
			url: "api/deletar_veiculo.php",
			data: {veiculo_id: veiculo_info.veiculo_id }
		}).done(function(){ card.addClass("sumir"); setTimeout(function() { card.remove(); }, 300); });
		
	});

	card_veiculo.append(foto_veiculo);
	card_veiculo.append(placa);
	card_veiculo.append(ic_editar);
	card_veiculo.append(ic_deletar);

	return card_veiculo;
}

function preencher_escala(lst_escala) {
	$(".dia").each(function(index){
		var dia = $(this).attr("id").substr(4);

		try {
			if(temItem(lst_escala, "dia_da_semana", dia)) {
				$(this).css("background", "#c4ea81");
				$(this).attr("id", retornaItem(lst_escala, "dia_da_semana", dia).escala_id);
				
				var seta_cima = $(document.createElement("div")).addClass("seta_cima");
				var hora_entrada = $(document.createElement("div")).addClass("hora_entrada");
					hora_entrada.text(retornaItem(lst_escala, "dia_da_semana", dia).horario);

				$(this).append(seta_cima);
				$(this).append(hora_entrada);
			}
		}catch(e) {}
	});
}