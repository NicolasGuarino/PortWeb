function carregar_info_excecao(lista_excecao) {
	for(var i in lista_excecao) {
		var excecao = lista_excecao[i];

		var el_excecao_container = $(document.createElement("div")).addClass("excecao_container");

		var el_data_excecao  = $(document.createElement("div")).addClass("info_excecao");
		var el_valor_data	 = $(document.createElement("span")).addClass("valor_info_excecao");

		var el_horario_excecao = $(document.createElement("div")).addClass("horario_excecao");

		var el_entrada_excecao   = $(document.createElement("div")).addClass("info_excecao");
		var el_valor_entrada	 = $(document.createElement("span")).addClass("valor_info_excecao");

		var el_saida_excecao  = $(document.createElement("div")).addClass("info_excecao");
		var el_valor_saida	  = $(document.createElement("span")).addClass("valor_info_excecao");

		el_data_excecao.html("<b> Data: </b>");
		el_valor_data.text(excecao.data_formatada);
		el_data_excecao.append(el_valor_data);

		el_entrada_excecao.html("<b> Entrada: </b>");
		el_valor_entrada.text(excecao.hora_entrada);
		el_entrada_excecao.append(el_valor_entrada);

		el_saida_excecao.html("<b> Saída: </b>");
		el_valor_saida.text(excecao.hora_saida);
		el_saida_excecao.append(el_valor_saida);

		el_horario_excecao.append(el_entrada_excecao);
		el_horario_excecao.append(el_saida_excecao);

		el_excecao_container.append(el_data_excecao);
		el_excecao_container.append(el_horario_excecao);

		var data = new Date(excecao.data);
		data.setDate(data.getDate() + 1)
		
		if(new Date().getTime() > data.getTime()) el_excecao_container.addClass("excecao_inativa");
		else el_excecao_container.addClass("excecao_ativa");

		$(".lista_excecao").append(el_excecao_container);
		$("#mostrar_excecao").show();
	}
}