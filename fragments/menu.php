<?php include "api/verifica_permissao.php" ?>

<div id="menu">
	<a href="dashboard.php" class="item_menu"> <i class="fa fa-home"></i> Dashboard </a> 
	<a href="usuarios_cadastrados_lista.php" class="item_menu"> <i class="fa fa-users"></i> Gerenciamento de usuário </a>
	<a href="empresas_lista.php" class="item_menu"> <i class="fa fa-building-o"></i> Gerenciamento de empresa </a>  
	<?php 
		if($_SESSION['usuario']['tipo_usuario_id'] == 8) {
	?>
		<a href="cadastro_documento.php" class="item_menu"> <i class="fa fa-file-text-o"></i> Cadastro de documento </a> 
	<?php } ?>
	<a href="acesso_usuario.php" class="item_menu"> <i class="fa fa-bars"></i> Lista de acessos </a>
</div>