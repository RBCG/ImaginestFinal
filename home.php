<?php
    session_start();

    require_once('./db/controlLikeDislike.php');
    require_once('./db/controlUsuari.php');

    if (!isset($_SESSION['usuari'])) {
        header("Location: ./index.php?redirected");
        $username = getNameUserWithNameOrMail($_SESSION['usuari']);
        exit;
    }

    $fotoRandom=false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $namePhotoOculto = filter_input(INPUT_POST, 'namePhotoOculto');
        $post = getImageSQLRandom($namePhotoOculto);

        $nameUserPost = getUserNamePost($post[0])[0];
        $nameUser = getNameUserWithNameOrMail($_SESSION['usuari']);
        
        if(isset($_POST["like"])){
            $likePOST=haDadoLike($namePhotoOculto,$nameUser);
            if($likePOST[0]==0) darLike($namePhotoOculto,$nameUser);
        } else if(isset($_POST["dislike"])){
            $dislikePOST=haDadoDislike($namePhotoOculto,$nameUser);
            if($dislikePOST[0]==0) darDislike($namePhotoOculto,$nameUser);
        }

        $fotoRandom=true;
    }

    if (!empty($_GET['error'])) {
        $error = filter_input(INPUT_GET, 'error');
	}

    if (getImageSQL()!=null)
    {
        if(!$fotoRandom){
            $post = getImageSQL();
            $nameUserPost = getUserNamePost($post[0])[0];
        }
    } else {
        $post=null;
        $noHay=true;
        $nameUserPost=null;
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
	<link rel="icon" type="image/png" href="img/logoImaginest.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,500,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link rel="stylesheet" href="css/material-cards.css">
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>

<body>
    
    <?php 
        include("./includes/menuOrdenador.php"); //MENU DE ORDENADOR (sidebar)
        include("./includes/menuTabletMovil.php"); //MENU PARA MÓVIL (dropdown)
        include("./includes/modals.php"); //MODALS (buscador/cambiarFotoUsuarioPerfil/mostrarTodosLosUsuarios/mostrarVideoPublicitario/SubirFotografia)
    ?>
    
    <!-- CARD CON LA FOTO, VALORACIÓN, LIKES... -->
    <section class="container">
        <h1 class="tituloapp" style="text-align: center;font-family: 'Titillium Web', sans-serif; padding: 0;font-weight: bold;">IMAGINEST</h1>
        <div class="row active-with-click" style="padding: 0px !important; justify-content: center">
            <div class="col-lg-7 col-md-11 col-sm-12 col-xs-12">
                <article class="material-card Green">
                    <h2 style="display: inline-flex;">
                        <span>
                            <?php
                                if($post){
                                    $rating = calcularCuantosVotosEnTotal($post[0]);
                                    
                                    if ($rating >=0 && $rating<2) $ratingPhoto="baja";
                                    else if ($rating >=2 && $rating <4) $ratingPhoto="media";
                                    else if ($rating >=4 && $rating <=5) $ratingPhoto="alta"; 
                                    else $ratingPhoto="noRating";

                                    echo "<div>Publicado por @$nameUserPost<img style='position: absolute; left: 80%; width: 40px' src='./img/$ratingPhoto.png'></img></div>";  
                                }             
                            ?>
                        </span>
                    </h2>
                    <div class="mc-content">
                        <div class="img-container" style="background-color: white; border-top-left-radius:30px; border-top-right-radius:30px">                            
                            <?php
                                require_once './db/controlUsuari.php';
                                if (!$post)
                                {
                                    $nombreFoto=null;
                                    $descripcionFoto=null;
                                } else {
                                    $nombreFoto = $post[0]; 
                                    $descripcionFoto = $post[1];
                                }
                                if ($nombreFoto == null) echo "<img class='img-responsive' src='./img/nohayfoto2.png' style='border-top-left-radius: 10px; border-top-right-radius: 10px; height: 100%; width: 100%; object-fit: contain'>";

                                else {
                                    echo "<img class='img-responsive' src='./fotosPublicadas/$nombreFoto.png' style='border-top-left-radius: 10px; border-top-right-radius: 10px; height: 100%; width: 100%; object-fit: cover'>";
                                }
                                ?>
                        </div>
                        <div class="mc-description">
                            <p><?php echo $descripcionFoto ?></p>
                        </div>
                    </div>
                    <?php if ($nombreFoto != null) echo "<a class='mc-btn-action'><i class='fa fa-bars' style='padding-top: 10px'></i></a>"; ?>
                    <div class="mc-footer">
                        <?php
                            $likes = contarLikes($nombreFoto)[0];
                            $dislikes = contarDislikes($nombreFoto)[0];
                            $hayLike = haDadoLike($nombreFoto,$userName);
                            $hayDislike = haDadoDislike($nombreFoto,$userName);
                        ?>

                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        
                            <button class="fa fa-fw fa-chevron-left" name="pasarFotoLeft" id="pasarFotoLeft" type="submit"></button>

                            <?php
                                if($hayLike[0] == 0) echo "<button class=\"fa fa-thumbs-o-up\" name=\"like\" id=\"likes\" type=\"submit\">&nbsp $likes </button>";
                                else echo "<button class=\"fa fa-thumbs-up\" name=\"like\" id=\"conLike\" type=\"submit\">&nbsp $likes </button>";
                                
                                if($hayDislike[0] == 0) echo "<button class=\"fa fa-thumbs-o-down\" name=\"dislike\" id=\"dislikes\" type=\"submit\">&nbsp $dislikes </button>";
                                else echo "<button class=\"fa fa-thumbs-down\" name=\"dislike\" id=\"conDislike\" type=\"submit\">&nbsp $dislikes </button>";
                            ?>

                            <button class="fa fa-fw fa-chevron-right" name="pasarFotoRight" id="pasarFotoRight" type="submit"></button>

                            <input type="hidden" name="namePhotoOculto" value="<?php echo $nombreFoto?>">
                        </form>
                    </div>  
                </article>
            </div>   
        </div>
    </section>

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