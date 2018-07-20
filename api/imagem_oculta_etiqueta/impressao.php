<?php
	include "../conexao.php";

	// $conexao = mysqli_connect('portaria_db.mysql.dbaas.com.br', 'portaria_db', 'P0rt@ri@','portaria_db');
	$conexao = conectar();

	$documento_id 	= $_GET['documento_id'];

	/*$query  = "select d.documento_id, d.numero_documento, d.imagem_oculta, u.usuario_id, u.nome, u.email, u.foto from documento as d ";
	$query .= "inner join usuario as u on(d.documento_id = u.documento_id) ";
	$query .= "where d.documento_id = ". $documento_id .";";*/

	$query = "select d.documento_id, d.numero_documento, d.imagem_oculta, u.usuario_id, u.nome, u.email, u.foto , u.rg, e.nome as empresa from rel_empresa_funcionario as rel inner join empresa as e on e.empresa_id = rel.empresa_id
inner join usuario as u on u.usuario_id = rel.usuario_id inner join documento as d on d.documento_id = u.documento_id
 where d.documento_id = ". $documento_id .";";

	$exec = mysqli_query($conexao, $query);
	$res  = mysqli_fetch_array($exec);

	$imagem_oculta = "../" . $res['imagem_oculta'];
	$foto = "../../" . $res['foto'];
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Imagem oculta</title>
		<link rel="stylesheet" type="text/css" href="css/impressao.css?19" />

	</head>
	<body>
		<div class="folha">
			<div class="etiqueta_esq">

				<div class="foto_usuario">
					<!--img src="<?php echo $foto; ?>" class="img_usuario" />-->
				</div>

				<div class="lst_campo">
					<div class="campo">
						<span class="campo_item">Nº do documento</span>
						<span class="campo_cont"><?php echo $res['numero_documento'] ?></span>
					</div>

					<div class="campo">
						<span class="campo_item">Nome</span>
						<span class="campo_cont"><?php echo $res['nome'] ?></span>
					</div>

					<div class="campo">
						<span class="campo_item">Rg</span>
						<span class="campo_cont"><?php echo $res['rg'] ?></span>
					</div>
					<div class="campo">
						<span class="campo_item">Empresa</span>
						<span class="campo_cont"><?php echo $res['empresa'] ?></span>
					</div>
				</div>
			</div>
			<div class="etiqueta_dir">
				<img src="<?php echo $imagem_oculta; ?>" id="img_oculta" alt="Imagem Oculta" title="Imagem Oculta" />
			</div>
		</div>
	</body>
</html>