<?php
    function nombreFotosPublicadasByUser($usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT hashedName FROM photographies where postedBy=? ORDER BY publicationDate DESC";
            $prepareHashedNameFotoUsu = $db->prepare($sql);
            $prepareHashedNameFotoUsu->execute(array($usuarioName)); 
            $resultado = $prepareHashedNameFotoUsu->fetchAll();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }

        return $resultado;
    }

    function obtenerDescripcionFoto($nombreFoto)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT description FROM photographies where hashedName=?";
            $prepareDescripcionFoto = $db->prepare($sql);
            $prepareDescripcionFoto->execute(array($nombreFoto)); 
            $resultado = $prepareDescripcionFoto->fetchAll();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }

        return $resultado=$resultado[0][0];
    }

    function muestraFotografia($userName,$fotoUsu,$contador,$final)
    {
        require_once("controlLikeDislike.php");
        $descripcion = obtenerDescripcionFoto($fotoUsu);

        if($contador==1) echo "<section class='container'><div class='row active-with-click'>";?>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <article class="material-card Green" style=" border-radius: 30px">
                <h2>
                    <span><?php echo fechaPublicacion($userName,$fotoUsu)[0];?></span>
                </h2>
                <div class="mc-content">
                    <div class="img-container">
                        <img class="img-responsive" src="../../imaginest/fotosPublicadas/<?php echo $fotoUsu; ?>.png" style="height: 100%; width: 100%; object-fit: cover;">
                    </div>
                    <div class="mc-description">
                        <?php echo $descripcion;?>
                    </div>
                </div>
                <a class="mc-btn-action">
                    <i class="fa fa-bars" style="padding-top: 10px"></i>
                </a>
                <div class="mc-footer">
                    <?php 
                    $url= $_SERVER["REQUEST_URI"];
                    if($url=="/imaginest/myprofile.php"){ ?>
                        <button class="fa fa-fw fa-thumbs-up" id="botonLikeDislikeDeleteMyProfile">&nbsp<?php echo $likes = contarLikes($fotoUsu)[0];?></button>
                        <button class="fa fa-fw fa-thumbs-down" id="botonLikeDislikeDeleteMyProfile">&nbsp<?php echo $dislikes = contarDislikes($fotoUsu)[0];?></button>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                            <input type="hidden" name="photoOcultaBorrar" value="<?php echo $fotoUsu?>">
                            <button id="botonDeleteMyProfile" type="submit" name="delete" value="delete">
                                <span class="fa fa-trash-o" id="iconPapelera"></span>
                            </button>
                        </form>
                    <?php }else { ?>
                        <button class="fa fa-fw fa-thumbs-up" id="botonLikeDislikeMyProfile">&nbsp<?php echo $likes = contarLikes($fotoUsu)[0];?></button>
                        <button class="fa fa-fw fa-thumbs-down" id="botonLikeDislikeMyProfile">&nbsp<?php echo $dislikes = contarDislikes($fotoUsu)[0];?></button>
                    <?php } ?>
                </div>
            </article>
        </div>
        <?php if($final) echo "</div></div>"; ?>

        <?php   
        
    }

    function fechaPublicacion($userName,$fotoUsu)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT publicationDate FROM photographies WHERE postedBy=? and hashedName=?";
            $preparadaFechaPublicacion = $db->prepare($sql);
            $preparadaFechaPublicacion->execute(array($userName,$fotoUsu));
            $resultado = $preparadaFechaPublicacion->fetch();
            
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado); 
    }

    function eliminarPhoto($nombreFoto){

        eliminarDePhotographies($nombreFoto);
        eliminarDeValorationPhotographies($nombreFoto);
    }

    function eliminarDePhotographies($nombreFoto)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "DELETE from photographies where hashedName=?";
            $prepareDELPhotoBD = $db->prepare($sql);
            $prepareDELPhotoBD->execute(array($nombreFoto)); 
            $prepareDELPhotoBD->fetchAll();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function eliminarDeValorationPhotographies($nombreFoto)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "DELETE from valorationphotographies where namePhoto=?";
            $prepareDELValorationPhotographiesBD = $db->prepare($sql);
            $prepareDELValorationPhotographiesBD->execute(array($nombreFoto)); 
            $prepareDELValorationPhotographiesBD->fetchAll();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }