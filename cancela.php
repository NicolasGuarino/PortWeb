<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Portaria - Status Cancela </title>

		<link rel="stylesheet" type="text/css" href="css/login.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="js/login.js?0"></script>
		<script type="text/javascript" src="js/script.js"></script>

        <style>
            .bolinha_verde{
                margin-top:12px;float:right;width:20px;height:20px;background-color:green;border-radius:25px;
            }

            .bolinha_vermelha{
                margin-top:12px;float:right;width:20px;height:20px;background-color:red;border-radius:25px;
            }
        </style>
	</head>

	<body>
		<div id="principal">
			<div class="container" id="login_container">
				<div class="container_logo"></div>
				<span class="container_tit"> Status Cancela </span>

                <div class="servidor">
                    <h4 style="float:left;margin-top:15px;">Servidor </h4>
                    <div class="bolinha"> </div>
                </div>

                <div class="arduino">
                    <h4  style="clear:both;float:left;margin-top:15px;">Arduíno</h4>
                    <div class="bolinha"> </div>
                </div>

                <div class="rfid">
                    <h4  style="clear:both;float:left;margin-top:15px;">Leitor RFID</h4>
                    <div class="bolinha"> </div>
                </div>
                
			</div>			
		</div>
	</body>

    <script>
        start();

        setInterval(function(){
            start();
        }, 5000);
        function start(){
            $.getJSON("api/buscar_log_conexao.php", {}, function(retorno){
            
            if(retorno[0].status_servidor == "ONLINE"){
                $(".servidor").children(".bolinha").removeClass("bolinha_vermelha");
                $(".servidor").children(".bolinha").addClass("bolinha_verde");
            }else{
                $(".servidor").children(".bolinha").removeClass("bolinha_verde");
                $(".servidor").children(".bolinha").addClass("bolinha_vermelha");
            }


            if(retorno[0].status_arduino == "ONLINE"){
                $(".arduino").children(".bolinha").removeClass("bolinha_vermelha");
                $(".arduino").children(".bolinha").addClass("bolinha_verde");
            }else{
                $(".arduino").children(".bolinha").removeClass("bolinha_verde");
                $(".arduino").children(".bolinha").addClass("bolinha_vermelha");
            }


            if(retorno[0].status_rfid == "ONLINE"){
                $(".rfid").children(".bolinha").removeClass("bolinha_vermelha");
                $(".rfid").children(".bolinha").addClass("bolinha_verde");
            }else{
                $(".servidor").children(".bolinha").removeClass("bolinha_verde");
                $(".rfid").children(".bolinha").addClass("bolinha_vermelha");
            }
        });
        }
    </script>
</html>