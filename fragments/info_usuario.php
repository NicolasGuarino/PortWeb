<link rel="stylesheet" type="text/css" href="css/info_usuario.css">
<script type="text/javascript" src="js/info_usuario.js"></script>	

<div id="perfil_usuario"> 
	<div id="info_usuario">
		
		<div id="info_principal">
			<div id="foto_usuario"></div>
			<span id="nome_usuario"> </span>
		</div>

		<div id="outras_info">
			<span class="item_info" id="email_usuario"> <b> Email:</b>  <span class="valor"></span> </span>
			<span class="item_info" id="data_nascimento_usuario"> <b> Data de nascimento:</b>  <span class="valor"></span> </span>
			<span class="item_info" id="cpf_usuario"> <b> CPF:</b>  <span class="valor"></span> </span>
			<span class="item_info" id="documento_usuario"> <b> Documento:</b> <span class="valor"></span> </span>
			<span class="item_info" id="tel_usuario"> <b> Telefone:</b>  <span class="valor"></span> </span>
			<span class="item_info" id="rg_usuario"> <b> RG:</b> <span class="valor"></span> </span>
			
			<span class="item_info" id="status">
				<b> Status:</b> 
				<select class="form_cbo" id="sl_status">
					<?php 
						require_once "api/conexao.php";
						$conexao = conectar();

						$query  = "select * from status;";
						$select = mysqli_query($conexao, $query);

						while ($rs = mysqli_fetch_array($select)) {
					?>
						<option value="<?php echo $rs['status_id'] ?>"> <?php echo $rs['nome'] ?> </option>
					<?php } ?>
				</select>
			</span>

			<div id="botoes">
				<span id="edit_user"> Editar </span>
				<span id="delete_user"> Deletar </span>
			</div>
		</div>
	</div>


	<div id="opcoes">
		<div id="veiculos">
			<span id="tit_veiculos"> Veiculos </span>
		</div>

		<div id="cadastrar_veiculo" class="btn_opcoes"></div>
		<div id="cadastrar_escala" class="btn_opcoes"></div>
	</div>


	<div id="escala">
		<span id="tit_escala"> Escala </span>
		<div class="dia" id="dia_0"> <span class="nome_dia" id="Segunda"> Seg </span> </div>
		<div class="dia" id="dia_1"> <span class="nome_dia" id="Terça"> Ter </span> </div>
		<div class="dia" id="dia_2"> <span class="nome_dia" id="Quarta"> Qua </span> </div>
		<div class="dia" id="dia_3"> <span class="nome_dia" id="Quinta"> Qui </span> </div>
		<div class="dia" id="dia_4"> <span class="nome_dia" id="Sexta"> Sex </span> </div>
		<div class="dia" id="dia_5"> <span class="nome_dia" id="Sábado"> Sab </span> </div>
		<div class="dia" id="dia_6"> <span class="nome_dia" id="Domingo"> Dom </span> </div>
	</div>
</div>
</div>