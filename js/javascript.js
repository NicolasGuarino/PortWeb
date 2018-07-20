
// *** Registro de acesso ***

var ultimo_horario = "";

// Carregando lista inicialmente
$(document).ready(function(){

	    $.ajax({
            url : 'api/listar_pessoas.php', /* URL que será chamada */ 
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
                			data[i].registro_acesso_id,
                			data[i].foto_usuario,
                			data[i].usuario,
                			data[i].empresa,
                			data[i].liberacao,
                			data[i].data,
                			data[i].hora,
                			data[i].tipo_acao,
                			data[i].tipo_locomocao
                		]);
                	}

                	for (i=1; i<itens.length; i++){
                		if(data[i].foto_usuario!='' && data[i].foto_usuario!=null){

                			extensao = data[i].foto_usuario.substring(data[i].foto_usuario.lastIndexOf(".")+1,data[i].foto_usuario.length);
                			
                			if(extensao == 'jpg' || extensao == "JPEG" || extensao == "jpeg"){
                				imagem = "<div class='box_foto_item_lista_jpg' style='background-image:url("+data[i].foto_usuario+")'></div>";
                				box_dados = 'box_dados_item_lista_jpg';
                			}else{
                				imagem = "<div class='box_foto_item_lista' style='background-image:url("+data[i].foto_usuario+")'></div>";
                				box_dados = 'box_dados_item_lista';
                			}
                		}else{
                			imagem = "<div class='box_foto_item_lista' style='background-image:url(img/person.png)'></div>";
                			box_dados = 'box_dados_item_lista';
                		}

                		if(data[i].liberacao=='1'){
                			liberacao = 'permitido';
                			cor = 'liberado';
                		}else{
                			liberacao = 'bloqueado';
                			cor = 'bloqueado';
                		}

                		if(i == 1){
                			ultimo_horario = data[i].hora;
                		}
                		 

                		HTMLitens = HTMLitens + "<div class='box_item_lista'>"+ imagem +
									"<div class='"+box_dados+"'>"+

										"<div class='box_nome_item_lista'>"+
											data[i].usuario.toUpperCase()+
										"</div>"+
										"<div class='topico_item_lista'>"+
											"PARA:"+
										"</div>"+
										"<div class='valor_item_lista'>"+
											data[i].empresa.toString().toUpperCase()+
										"</div><br>"+
										"<div class='topico_item_lista'>"+
											"TIPO:"+
										"</div>"+
										"<div class='valor_item_lista'>"+
											data[i].tipo_locomocao.toString().toUpperCase()+
										"</div><br>"+
										"<div class='topico_item_lista'>"+
											"AÇÃO:"+
										"</div>"+
										"<div class='valor_item_lista'>"+
											data[i].tipo_acao.toString().toUpperCase()+
										"</div><br>"+
										"<div class='topico_item_lista'>"+
											"DATA:"+
										"</div>"+
										"<div class='valor_item_lista'>"+
											data[i].data.toString().toUpperCase()+
										"</div><br>"+
										"<div class='topico_item_lista'>"+
											"HORÁRIO: "+
										"</div>"+
										"<div class='valor_item_lista'>"+
											data[i].hora.toString().toUpperCase()+
										"</div><br>"+
										"<div class='topico_item_lista'>"+
											"ACESSO:"+ 
										"</div>"+
										"<div class='valor_item_lista "+cor+"'>"+
											liberacao.toString().toUpperCase()+
										"</div><br>"+
										"<div style='clear:both'></div>"+
									"</div>"+
									"<div style='clear:both'></div>"+
								"</div>";
                	}
                }

                $(".box_lista").html(HTMLitens);


                //INSERINDO ULTIMO USUÁRIO
                if(data[0].foto_usuario!='' && data[0].foto_usuario!=null){

					extensao_ultimo_usuario = data[0].foto_usuario.substring(data[0].foto_usuario.lastIndexOf(".")+1,data[0].foto_usuario.length);
					
					if(extensao_ultimo_usuario == 'jpg' || extensao_ultimo_usuario == "JPEG" || extensao_ultimo_usuario == "jpeg"){

						imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario_jpg' style='background-image:url("+data[0].foto_usuario+")'></div>";
						box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
					}else{
						imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url("+data[0].foto_usuario+")'></div>";
						box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
					}
				}else{
					imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url(img/person.png)'></div>";
					box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
				}

				if(data[0].liberacao=='1'){
					liberacao_ultimo_usuario = 'permitido';
					cor_ultimo_usuario = 'liberado';
				}else{
					liberacao_ultimo_usuario = 'bloqueado';
					cor_ultimo_usuario = 'bloqueado';
				}

				HTMLitensultimo = HTMLitensultimo + "<div class='box_ultimo_usuario'>"+imagem_ultimo_usuario+
									"<div class='"+box_dados_ultimo_usuario+"'>"+
										"<div class='box_nome_ultimo_usuario'>"+
											"<div class='linha_topo'>"+
												data[0].usuario.toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"PARA:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].empresa.toString().toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"TIPO:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].tipo_locomocao.toString().toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"AÇÃO:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].tipo_acao.toString().toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"DATA:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].data.toString().toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='linha'>"+
											"<div class='topico_ultimo_usuario'>"+
												"HORÁRIO:"+
											"</div>"+
											"<div class='valor_ultimo_usuario'>"+
												data[0].hora.toString().toUpperCase()+
											"</div>"+
										"</div>"+
										"<div class='topico_ultimo_usuario'>"+
											"ACESSO:"+ 
										"</div>"+
										"<div class='valor_ultimo_usuario "+cor_ultimo_usuario+"'>"+
											liberacao_ultimo_usuario.toString().toUpperCase()+
										"</div>"+
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
		},1000);
		
});	

function verificarSeHaNovoUsuario(){
	
	$.ajax({
        url : 'api/listar_pessoas.php', /* URL que será chamada */ 
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
            			data[i].registro_acesso_id,
            			data[i].foto_usuario,
            			data[i].usuario,
            			data[i].empresa,
            			data[i].liberacao,
            			data[i].data,
            			data[i].hora,
            			data[i].tipo_acao,
            			data[i].tipo_locomocao
            		]);
            	}

            	if(data[1].hora == ultimo_horario){
            		
            		

            	}else{
            		
            		adicionarNovoLista(data);
            		adicionarNovoUltimo(data);

            		ultimo_horario = data[1].hora;
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
	if(data[1].foto_usuario!='' && data[1].foto_usuario!=null){

		extensao = data[1].foto_usuario.substring(data[1].foto_usuario.lastIndexOf(".")+1,data[1].foto_usuario.length);
		
		if(extensao == 'jpg' || extensao == "JPEG" || extensao == "jpeg"){
			imagem = "<div class='box_foto_item_lista_jpg' style='background-image:url("+data[1].foto_usuario+")'></div>";
			box_dados = 'box_dados_item_lista_jpg';
		}else{
			imagem = "<div class='box_foto_item_lista' style='background-image:url("+data[1].foto_usuario+")'></div>";
			box_dados = 'box_dados_item_lista';
		}
	}else{
		imagem = "<div class='box_foto_item_lista' style='background-image:url(img/person.png)'></div>";
		box_dados = 'box_dados_item_lista';
	}

	if(data[1].liberacao=='1'){
		liberacao = 'permitido';
		cor = 'liberado';
	}else{
		liberacao = 'bloqueado';
		cor = 'bloqueado';
	}
	 
	HTMLitens = HTMLitens + "<div class='box_item_lista' style='margin-top:-170px;'>"+ imagem +
				"<div class='"+box_dados+"'>"+

					"<div class='box_nome_item_lista'>"+
						data[1].usuario.toUpperCase()+
					"</div>"+
					"<div class='topico_item_lista'>"+
						"PARA:"+
					"</div>"+
					"<div class='valor_item_lista'>"+
						data[1].empresa.toString().toUpperCase()+"</div><br>"+
					"<div class='topico_item_lista'>"+
						"TIPO:"+
					"</div>"+
					"<div class='valor_item_lista'>"+
						data[1].tipo_locomocao.toString().toUpperCase()+
					"</div><br>"+
					"<div class='topico_item_lista'>"+
						"AÇÃO:"+
					"</div>"+
					"<div class='valor_item_lista'>"+
						data[1].tipo_acao.toString().toUpperCase()+
					"</div><br>"+
					"<div class='topico_item_lista'>"+
						"DATA:"+
					"</div>"+
					"<div class='valor_item_lista'>"+
						data[1].data.toString().toUpperCase()+
					"</div><br>"+
					"<div class='topico_item_lista'>"+
						"HORÁRIO: "+
					"</div>"+
					"<div class='valor_item_lista'>"+
						data[1].hora.toString().toUpperCase()+
					"</div><br>"+
					"<div class='topico_item_lista'>"+
						"ACESSO:"+ 
					"</div>"+
					"<div class='valor_item_lista "+cor+"'>"+
						liberacao.toString().toUpperCase()+
					"</div><br>"+
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
		if(data[0].foto_usuario!='' && data[0].foto_usuario!=null){

						extensao_ultimo_usuario = data[0].foto_usuario.substring(data[0].foto_usuario.lastIndexOf(".")+1,data[0].foto_usuario.length);
						
						if(extensao_ultimo_usuario == 'jpg' || extensao_ultimo_usuario == "JPEG" || extensao_ultimo_usuario == "jpeg"){

							imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario_jpg' style='background-image:url("+data[0].foto_usuario+")'></div>";
							box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
						}else{
							imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url("+data[0].foto_usuario+")'></div>";
							box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
						}
					}else{
						imagem_ultimo_usuario = "<div class='box_foto_ultimo_usuario' style='background-image:url(img/person.png)'></div>";
						box_dados_ultimo_usuario = 'box_dados_ultimo_usuario_jpg';
					}

					if(data[0].liberacao=='1'){
						liberacao_ultimo_usuario = 'permitido';
						cor_ultimo_usuario = 'liberado';
					}else{
						liberacao_ultimo_usuario = 'bloqueado';
						cor_ultimo_usuario = 'bloqueado';
					}

					HTMLitens = HTMLitens + "<div class='box_ultimo_usuario'>"+imagem_ultimo_usuario+
										"<div class='"+box_dados_ultimo_usuario+"'>"+
											"<div class='box_nome_ultimo_usuario'>"+
												"<div class='linha_topo'>"+
													data[0].usuario.toUpperCase()+
												"</div>"+
											"</div>"+
											"<div class='linha'>"+
												"<div class='topico_ultimo_usuario'>"+
													"PARA:"+
												"</div>"+
												"<div class='valor_ultimo_usuario'>"+
													data[0].empresa.toString().toUpperCase()+
												"</div>"+
											"</div>"+
											"<div class='linha'>"+
												"<div class='topico_ultimo_usuario'>"+
													"TIPO:"+
												"</div>"+
												"<div class='valor_ultimo_usuario'>"+
													data[0].tipo_locomocao.toString().toUpperCase()+
												"</div>"+
											"</div>"+
											"<div class='linha'>"+
												"<div class='topico_ultimo_usuario'>"+
													"AÇÃO:"+
												"</div>"+
												"<div class='valor_ultimo_usuario'>"+
													data[0].tipo_acao.toString().toUpperCase()+
												"</div>"+
											"</div>"+
											"<div class='linha'>"+
												"<div class='topico_ultimo_usuario'>"+
													"DATA:"+
												"</div>"+
												"<div class='valor_ultimo_usuario'>"+
													data[0].data.toString().toUpperCase()+
												"</div>"+
											"</div>"+
											"<div class='linha'>"+
												"<div class='topico_ultimo_usuario'>"+
													"HORÁRIO:"+
												"</div>"+
												"<div class='valor_ultimo_usuario'>"+
													data[0].hora.toString().toUpperCase()+
												"</div>"+
											"</div>"+
											"<div class='topico_ultimo_usuario'>"+
												"ACESSO:"+ 
											"</div>"+
											"<div class='valor_ultimo_usuario "+cor_ultimo_usuario+"'>"+
												liberacao_ultimo_usuario.toString().toUpperCase()+
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

