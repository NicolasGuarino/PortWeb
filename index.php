<?php 
    
    $pagina = $_SERVER['REQUEST_URI'];
    $host = $_SERVER['HTTP_HOST']; 

    if(strpos($pagina, 'homologacao') !== false || strpos($host, 'localhost') !== false  || strpos($host, '192.168.') !== false) {
        header("location:login.php");
    }else{
        header("location:https://nuflame1.websiteseguro.com/portaria/login.php");
    }
?>