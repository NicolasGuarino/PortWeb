
// *** Registro de acesso ***

var id_do_usuario = "";

// Carregando lista inicialmente
$(document).ready(function(){

	    $.ajax({
            url : 'api/consultar_lista_cadastro.php', /* URL que será chamada */ 
            type : 'POST', /* Tipo da requisição */ 
            dataType : "json",
            crossDomain: true,
            beforeSend: function(){
            	
            },
            success: function(data){   
                var itens = new Array(0);
                var HTMLitens = "";
                var HTMLitensultimo = "";

				//INSERINDO LISTA DA ESQUERDA ...              

				

                if(data.length>0){
                	for (i=0; i<data.length; i++){
                		itens.push([
                			data[i].numero_etiqueta,
							data[i].usuario_id,
							data[i].nome_usuario,
							data[i].email,
							data[i].documento_pessoa,
							data[i].documento_veiculo,
							data[i].empresa,
							data[i].status_documento,
							data[i].foto,
							data[i].status_documento_id
                		]);
                	}

                	for (i=1; i<itens.length; i++){
                		if(data[i].foto!='' && data[i].foto!=null){

                			extensao = data[i].foto.substring(data[i].foto.lastIndexOf(".")+1,data[i].foto.length);
                			
                			console.log(data[i].foto);

                			if(extensao == 'jpg' || extensao == "JPEG" || extensao == "jpeg"){
                				imagem = "<div class='box_foto_item_lista_jpg' style='background-image:url("+data[i].foto+")'></div>";
                				box_dados = 'box_dados_item_lista_jpg';
                			}else{
                				imagem = "<div class='box_foto_item_lista' style='background-image:url("+data[i].foto+")'></div>";
                				box_dados = 'box_dados_item_lista';
                			}
                		}else{
                			imagem = "<div class='box_foto_item_lista' style='background-image:url(img/person.png)'></div>";
                			box_dados = 'box_dados_item_lista';
                		}

                		if(data[i].status_documento_id=='1'){
                			status_documento_id = 'permitido';
                			cor = 'liberado '+data[i].documento_pessoa+'-'+data[i].documento_veiculo;
                			doc = 'doc '+data[i].documento_pessoa+'-'+data[i].documento_veiculo;
                		}else{
                			status_documento_id = 'bloqueado';
                			cor = 'bloqueado '+data[i].documento_pessoa+'-'+data[i].documento_veiculo;
                			doc = 'doc '+data[i].documento_pessoa+'-'+data[i].documento_veiculo;
                		}

                		if(i == 1){
                			id_do_usuario = data[i].usuario_id;
                		}
                		 

                		HTMLitens = HTMLitens + "<div class='box_item_lista'>"+ imagem +
									"<div class='"+box_dados+"'>"+
										"<div class='box_nome_item_lista'>"+
											data[i].nome_usuario +
										"</div>"+
										"<div class='linha_lista'>"+
											"<div class='topico_item_lista'>"+
												"EMAIL:"+
											"</div>"+
											"<div class='valor_item_lista'>"+
												data[i].email +
											"</div><br>"+
										"</div>"+
										"<div class='linha_lista'>"+
											"<div class='topico_item_lista'>"+
												"Nº DOC.:"+
											"</div>"+
											"<div class='valor_item_lista'>"+
												data[i].numero_etiqueta +
											"</div><br>"+
										"</div>"+
										"<div class='linha_lista'>"+
											"<div class='topico_item_lista'>"+
												"EMPRESA:"+
											"</div>"+
											"<div class='valor_item_lista'>"+
												data[i].empresa.toString().toUpperCase()+
											"</div><br>"+
										"</div>"+
										"<div class='linha_lista linha_botao' >"+
											"<div class='topico_item_lista linha_botao'>"+
												"ACESSO:"+ 
											"</div>"+
											"<div class='valor_item_lista "+cor+"'>"+
												status_documento_id.toString().toUpperCase()+
											"</div><br>"+
											"<div class='valor_item_lista "+doc+"'>DOCUMENTO"+
											"</div><br>"+
										"</div>"+
										"<div style='clear:both'></div>"+
									"</div>"+
									"<div style='clear:both'></div>"+
								"</div>";
                	}
                }

                $(".box_lista").html(HTMLitens);


                //INSERINDO ULTIMO USUÁRIO
                if(data[0].foto!='' && data[0].foto!=null){

					extensao_ultimo_usuario = data[0].foto.substring(data[0].foto.lastIndexOf(".")+1,data[0].foto.length);
					
					if(extensao_ultimo_usuario == 'jpg' || extensao_ultimo_usuario == "JPEG" || extensao_ultimo_usuario == "jpeg"){

						imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario_jpg' style='background-image:url("+data[0].foto+")'></div>";
						box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
					}else{
						imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url("+data[0].foto+")'></div>";
						box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
					}
				}else{
					imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url(img/person.png)'></div>";
					box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
				}

				if(data[0].status_documento_id=='1'){
					status_documento_id_ultimo_usuario = 'permitido';
					cor_ultimo_usuario = 'liberado '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
					doc = 'doc '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
				}else{
					status_documento_id_ultimo_usuario = 'bloqueado';
					cor_ultimo_usuario = 'bloqueado '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
					doc = 'doc '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
				}

				HTMLitensultimo = HTMLitensultimo + "<div class='box_ultimo_usuario'>"+imagem_ultimo_usuario+
									"<div class='"+box_dados_ultimo_usuario+"'>"+
										"<div class='box_nome_ultimo_usuario'>"+
											"<div class='linha_topo'>"+
												data[0].nome_usuario +
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"EMAIL:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].email +
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"Nº DOC.:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].numero_etiqueta +
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario' >"+
												"EMPRESA:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].empresa.toString().toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='topico_ultimo_usuario linha_botao_ultimo_usuario'>"+
											"ACESSO:"+ 
										"</div>"+
										"<div class='valor_item_lista "+cor_ultimo_usuario+"'>"+
											status_documento_id_ultimo_usuario.toString().toUpperCase()+
										"</div>"+
										"<div class='valor_item_lista "+doc+"'>DOCUMENTO"+
										"</div><br>"+
										"<div style='clear:both'></div>"+
									"</div>"+
									"<div style='clear:both'></div>"+
								"</div>";

					$(".esp_ultimo_usuario").html(HTMLitensultimo)

            },
            error:function(){

            }
        });

		setInterval(function(){
			verificarSeHaNovoUsuario()
		},5000);
		
});	

function verificarSeHaNovoUsuario(){
	
	$.ajax({
        url : 'api/consultar_lista_cadastro.php', /* URL que será chamada */ 
        type : 'POST', /* Tipo da requisição */ 
        dataType : "json",
        crossDomain: true,
        beforeSend: function(){
        	// TODO: COLOCAR LOADER AQUI
        },
        success: function(data){   
           	var itens = new Array(0);
            var HTMLitens = "";

            // TODO: RETIRAR LOADERS AQUI

            if(data.length>0){
            	for (i=0; i<data.length; i++){
            		itens.push([
            			data[i].numero_etiqueta,
						data[i].usuario_id,
						data[i].nome_usuario,
						data[i].email,
						data[i].documento_pessoa,
						data[i].documento_veiculo,
						data[i].empresa,
						data[i].status_documento,
						data[i].foto,
						data[i].status_documento_id
            		]);
            	}

            	if(data[1].usuario_id == id_do_usuario){
            		
            		

            	}else{
            		
            		adicionarNovoLista(data);
            		adicionarNovoUltimo(data);

            		id_do_usuario = data[1].usuario_id;
            	}
            }
            
        },
        error:function(){

        }
    });
}

//Função para adicionar nova pessoa na lista
function adicionarNovoLista(data){

	var itens = new Array(0);
	var HTMLitens = "";

	// TODO: RETIRAR LOADERS AQUI
	if(data[1].foto!='' && data[1].foto!=null){

		extensao = data[1].foto.substring(data[1].foto.lastIndexOf(".")+1,data[1].foto.length);
		
		if(extensao == 'jpg' || extensao == "JPEG" || extensao == "jpeg"){
			imagem = "<div class='box_foto_item_lista_jpg' style='background-image:url("+data[1].foto+")'></div>";
			box_dados = 'box_dados_item_lista_jpg';
		}else{
			imagem = "<div class='box_foto_item_lista' style='background-image:url("+data[1].foto+")'></div>";
			box_dados = 'box_dados_item_lista';
		}
	}else{
		imagem = "<div class='box_foto_item_lista' style='background-image:url(img/person.png)'></div>";
		box_dados = 'box_dados_item_lista';
	}

	if(data[1].status_documento_id=='1'){
		status_documento_id = 'permitido';
		cor = 'liberado '+data[1].documento_pessoa+'-'+data[1].documento_veiculo;
		doc = 'doc '+data[1].documento_pessoa+'-'+data[1].documento_veiculo;
	}else{
		status_documento_id = 'bloqueado';
		cor = 'bloqueado '+data[1].documento_pessoa+'-'+data[1].documento_veiculo;
		doc = 'doc '+data[1].documento_pessoa+'-'+data[1].documento_veiculo;
	}
	 
	HTMLitens = HTMLitens + "<div class='box_item_lista'>"+ imagem +
					"<div class='"+box_dados+"'>"+
						"<div class='box_nome_item_lista'>"+
							data[1].nome_usuario +
						"</div>"+
						"<div class='linha_lista'>"+
							"<div class='topico_item_lista'>"+
								"EMAIL:"+
							"</div>"+
							"<div class='valor_item_lista'>"+
								data[1].email +
							"</div><br>"+
						"</div>"+
						"<div class='linha_lista'>"+
							"<div class='topico_item_lista'>"+
								"Nº DOC.:"+
							"</div>"+
							"<div class='valor_item_lista'>"+
								data[1].numero_etiqueta +
							"</div><br>"+
						"</div>"+
						"<div class='linha_lista'>"+
							"<div class='topico_item_lista'>"+
								"EMPRESA:"+
							"</div>"+
							"<div class='valor_item_lista'>"+
								data[1].empresa.toString().toUpperCase()+
							"</div><br>"+
						"</div>"+
						"<div class='linha_lista linha_botao'>"+
							"<div class='topico_item_lista linha_botao'>"+
								"ACESSO:"+ 
							"</div>"+
							"<div class='valor_item_lista "+cor+"'>"+
								status_documento_id.toString().toUpperCase()+
							"</div><br>"+
							"<div class='valor_item_lista "+doc+"'>DOCUMENTO"+
							"</div><br>"+
						"</div>"+
						"<div style='clear:both'></div>"+
					"</div>"+
					"<div style='clear:both'></div>"+
				"</div>";

	$(HTMLitens).insertBefore($(".box_item_lista:first"));

	$(".box_item_lista:first").animate({
		"margin-top":"0"
	},function(){

	});
}

//Função para adicionar nova pessoa na lista
function adicionarNovoUltimo(data){

		var itens = new Array(0);
		var HTMLitens = "";

		// TODO: RETIRAR LOADERS AQUI
		if(data[0].foto!='' && data[0].foto!=null){

			extensao_ultimo_usuario = data[0].foto.substring(data[0].foto.lastIndexOf(".")+1,data[0].foto.length);

			if(extensao_ultimo_usuario == 'jpg' || extensao_ultimo_usuario == "JPEG" || extensao_ultimo_usuario == "jpeg"){

				imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario_jpg' style='background-image:url("+data[0].foto+")'></div>";
				box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
			}else{
				imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url("+data[0].foto+")'></div>";
				box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
			}
		}else{
			imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url(img/person.png)'></div>";
			box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
		}

		if(data[0].status_documento_id=='1'){
			status_documento_id_ultimo_usuario = 'permitido';
			cor_ultimo_usuario = 'liberado '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
			doc = 'doc '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
		}else{
			status_documento_id_ultimo_usuario = 'bloqueado';
			cor_ultimo_usuario = 'bloqueado '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
			doc = 'doc '+data[0].documento_pessoa+'-'+data[0].documento_veiculo;
		}

		HTMLitens = HTMLitens + "<div class='box_ultimo_usuario'>"+imagem_ultimo_usuario+
									"<div class='"+box_dados_ultimo_usuario+"'>"+
										"<div class='box_nome_ultimo_usuario'>"+
											"<div class='linha_topo'>"+
												data[0].nome_usuario +
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"EMAIL:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].email +
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"Nº DOC.:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].numero_etiqueta +
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"EMPRESA:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].empresa.toString().toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='topico_ultimo_usuario linha_botao_ultimo_usuario'>"+
											"ACESSO:"+ 
										"</div>"+
										"<div class='valor_item_lista "+cor_ultimo_usuario+"'>"+
											status_documento_id_ultimo_usuario.toString().toUpperCase()+
										"</div>"+
										"<div class='valor_item_lista "+doc+"'>DOCUMENTO"+
										"</div>"+
										"<div style='clear:both'></div>"+
									"</div>"+
									"<div style='clear:both'></div>"+
								"</div>";

		$(HTMLitens).insertAfter($(".box_ultimo_usuario:first"));

		$(".box_ultimo_usuario:first").animate({
			"margin-left":"-753px"
		},function(){
			$(".box_ultimo_usuario:first").remove();
		});
	}

$(document).ready(function(){

	$(document).on('click','.bloqueado',function(){
		
		classe = $(this).attr('class');
		ids = classe.substring(classe.lastIndexOf(" ")+1,classe.length);
		documento_id_pessoa = ids.substring(0,ids.lastIndexOf("-"));
		documento_id_veiculo = ids.substring(ids.lastIndexOf("-")+1,ids.length);
		situacao_atual = '0';
		$(this).attr("class", "valor_item_lista liberado "+documento_id_pessoa+"-"+documento_id_veiculo);
		$(this).text("PERMITIDO");

		$.ajax({
	        url : 'api/liberar_usuario.php', /* URL que será chamada */ 
	        type : 'GET', /* Tipo da requisição */ 
	        dataType : "json",
	        data: {'documento_id_pessoa':documento_id_pessoa, 'documento_id_veiculo':documento_id_veiculo, 'situacao_atual':situacao_atual},
	        crossDomain: true,
	        beforeSend: function(){
	        	// TODO: COLOCAR LOADER AQUI
	        },
	        success: function(data){   

	        },
	        error:function(){

	        }
	    });
		
	});

	$(document).on('click','.liberado',function(){
		
		classe = $(this).attr('class');
		ids = classe.substring(classe.lastIndexOf(" ")+1,classe.length);
		documento_id_pessoa = ids.substring(0,ids.lastIndexOf("-"));
		documento_id_veiculo = ids.substring(ids.lastIndexOf("-")+1,ids.length);
		situacao_atual = '1';
		$(this).attr("class", "valor_item_lista bloqueado "+documento_id_pessoa+"-"+documento_id_veiculo);
		$(this).text("BLOQUEADO");

		$.ajax({
	        url : 'api/liberar_usuario.php', /* URL que será chamada */ 
	        type : 'GET', /* Tipo da requisição */ 
	        dataType : "json",
	        data: {'documento_id_pessoa':documento_id_pessoa, 'documento_id_veiculo':documento_id_veiculo, 'situacao_atual':situacao_atual},
	        crossDomain: true,
	        beforeSend: function(){
	        	// TODO: COLOCAR LOADER AQUI
	        },
	        success: function(data){   
	           	
	        },
	        error:function(){

	        }
	    });
		
	});

	$(document).on('click','.doc',function(){
		
		classe = $(this).attr('class');
		ids = classe.substring(classe.lastIndexOf(" ")+1,classe.length);
		documento_id_pessoa = ids.substring(0,ids.lastIndexOf("-"));
		documento_id_veiculo = ids.substring(ids.lastIndexOf("-")+1,ids.length);
	
		window.open('http://192.168.0.2/portaria/api/imagem_oculta_etiqueta/impressao.php?documento_id='+documento_id_pessoa, '_blank');
		
	});

});	


