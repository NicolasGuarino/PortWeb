<?php 
   	require_once 'api/conexao.php';
    $documento_id = $_GET['documento_id'];
    $con = conectar();


    $sql = "select * from usuario where documento_id =".$documento_id.";";
    $exec = mysqli_query($con, $sql);


    while($item = mysqli_fetch_assoc($exec)){ 
    	$nome = $item['nome'];
    	$data_nascimento = date('d/m/Y', strtotime($item['data_nascimento']));
    	$email = $item['email'];
    	$foto = $item['foto'];
    	$telefone = $item['telefone'];

    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Meu perfil</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

 
    <link href="assets/css/bootstrap.css?1" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style_perfil.css?1"/>

</head>
<body>
	<div class="container">
       
        <div class="twPc-div">
            <a class="twPc-bg twPc-block"></a>

            <div style="margin-top:50px;">
                <!-- <div class="twPc-button"> -->
		            <!-- Twitter Button | you can get from: https://about.twitter.com/tr/resources/buttons#follow -->
		            <!-- <a href="#" class="alert alert-info" data-show-count="false" data-size="large" data-show-screen-name="false" data-dnt="true">TELA DOIS</a> -->
		               
				<!-- </div> -->

                <a title="#" href="#" class="twPc-avatarLink">
                    <div  style="background:url('<?php echo ($foto); ?>') center / cover no-repeat; width:72px; height:72px;"  class="twPc-avatarImg" ></div>
                </a>

                <div class="twPc-divUser">
                    <div class="twPc-divName">
                        <a href="#"><?php echo($nome); ?></a>
                    </div>
                    <span>
                        <a href="#"><?php echo($email); ?></a>
                    </span>
                </div>

                <div class="twPc-divStats" >
                    <li class="twPc-ArrangeSizeFit" style="float:left; margin-left:30px;">
                        <a href="#" title="#">
                            <span class="twPc-StatLabel twPc-block">Data de nascimento</span>
                            <span class="twPc-StatValue"><?php echo($data_nascimento); ?></span>
                        </a>
                    </li>
                    <li class="twPc-ArrangeSizeFit" style="float:right; margin-right:30px;">
                        <a href="#" title="#">
                            <span class="twPc-StatLabel twPc-block">Número de telefone</span>
                            <span class="twPc-StatValue"><?php echo($telefone); ?></span>
                        </a>
                    </li>
            </ul>
                </div>
            </div>
        </div>
        <!-- code end -->
        </div>
    </div>
</body>
</html>