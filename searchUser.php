<?php 
    session_start();
    require_once("./db/controlUsuari.php");
    require_once("./db/controlProfile.php");

    if (!isset($_SESSION['usuari'])) {
        header("Location: ./home.php?redirected");
        exit;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $usuarioPOST = filter_input(INPUT_POST, 'usuarioBuscado');

        $userBuscado=getNameUserWithNameOrMail($usuarioPOST);

        if($userBuscado==false) header("location: home.php?error=true"); // PASAR ERROR Y MOSTRAR ALERT/EMERGENTE  
    }else{
        header("Location: ./home.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>IMAGINEST - TU RED SOCIAL</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-tap-highlight" content="no">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="img/logoImaginest.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,500,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link rel="stylesheet" href="css/material-cards.css">
<!--===============================================================================================-->
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>
    
    <?php 
        include("./includes/menuOrdenador.php"); //MENU DE ORDENADOR (sidebar)
        include("./includes/menuTabletMovil.php"); //MENU PARA MÓVIL (dropdown)
        include("./includes/modals.php"); //MODALS (buscador/cambiarFotoUsuarioPerfil/mostrarTodosLosUsuarios/mostrarVideoPublicitario/SubirFotografia)
    ?>

    <?php             
        echo "<h1 class='tituloapp' style='text-align: center;font-family: 'Titillium Web', sans-serif; padding: 0;font-weight: bold;'>IMAGINEST - Perfil de @$usuarioPOST</h1>";

        $fotosDelUSerBuscado=nombreFotosPublicadasByUser($userBuscado);
        $qttFotografias = count($fotosDelUSerBuscado);
        $contador=1;$esFinal=false;

        foreach($fotosDelUSerBuscado as $fotoUsu){
            if($contador==$qttFotografias)$esFinal=true;
            muestraFotografia($userBuscado,$fotoUsu[0],$contador,$esFinal);
            $contador++;
        }
    ?>



<script src="/imaginest/js/home.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script> 
<script>
    $(function () {
        $('.material-card > .mc-btn-action').click(function () {
            var card = $(this).parent('.material-card');
            var icon = $(this).children('i');
            icon.addClass('fa-spin-fast');

            if (card.hasClass('mc-active')) {
                card.removeClass('mc-active');

                window.setTimeout(function() {
                    icon
                        .removeClass('fa-arrow-left')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-bars');

                }, 800);
            } else {
                card.addClass('mc-active');

                window.setTimeout(function() {
                    icon
                        .removeClass('fa-bars')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-arrow-left');

                }, 800);
            }
        });
    });
</script>

</body>
</html>