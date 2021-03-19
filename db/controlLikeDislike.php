<?php 
    function darLike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');
        
        $existe = existeValoracionFoto($nombreFoto,$usuarioName);

        if($existe){
            $hayDislike = comprobarSiHayDislike($nombreFoto,$usuarioName);
            if($hayDislike){
                quitarVoto($nombreFoto,"dislikes");
                darVoto($nombreFoto,"likes");
                actualizarVotoLike($nombreFoto,$usuarioName);
            }else{
                darVoto($nombreFoto,"likes");
                añadirLike($nombreFoto,$usuarioName);
            }
        }else{
            darVoto($nombreFoto,"likes");
            añadirLike($nombreFoto,$usuarioName);
        }
    }

    function comprobarSiHayDislike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(dislikeP) FROM valorationphotographies WHERE namePhoto=? AND nameUser=?";
            $preparadaComprobarDislike = $db->prepare($sql);
            $preparadaComprobarDislike->execute(array($nombreFoto,$usuarioName));
            $resultado = $preparadaComprobarDislike->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }

        return ($resultado[0]==1 ? true : false);
    }

    function existeDislikesPhotograpies($nombreFoto)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(*) FROM photographies WHERE hashedName=? and dislikes>0";
            $preparadaComprobarDislike = $db->prepare($sql);
            $preparadaComprobarDislike->execute(array($nombreFoto));
            $resultado = $preparadaComprobarDislike->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }

        return ($resultado[0]==1 ? true : false);
    }
    
    function existeLikesPhotograpies($nombreFoto,$nombreUsu)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(*) FROM valorationphotographies WHERE namePhoto=? and nameUser=? and likes>0";
            $preparadaComprobarDislike = $db->prepare($sql);
            $preparadaComprobarDislike->execute(array($nombreFoto,$nombreUsu));
            $resultado = $preparadaComprobarDislike->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }

        return ($resultado[0]==1 ? true : false);
    }

    function comprobarSiHayLike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(likeP) FROM valorationphotographies WHERE namePhoto=? AND nameUser=?";
            $preparadaComprobarDislike = $db->prepare($sql);
            $preparadaComprobarDislike->execute(array($nombreFoto,$usuarioName));
            $resultado = $preparadaComprobarDislike->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }

        return ($resultado[0]==1 ? true : false);
    }

    function actualizarVotoLike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "UPDATE valorationphotographies SET likeP=1, dislikeP=0 WHERE namePhoto=? AND nameUser=?";
            $preparadaAñadirLike = $db->prepare($sql);
            $preparadaAñadirLike->execute(array($nombreFoto,$usuarioName));
            $añadirLike = $db->query($sql);
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }
    
    function actualizarVotoDislike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "UPDATE valorationphotographies SET likeP=0, dislikeP=1 WHERE namePhoto=? AND nameUser=?";
            $preparadaAñadirLike = $db->prepare($sql);
            $preparadaAñadirLike->execute(array($nombreFoto,$usuarioName));
            $añadirLike = $db->query($sql);
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }   

    function darDislike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');
        
        $existe = existeValoracionFoto($nombreFoto,$usuarioName);

        if($existe){
            $hayLike = comprobarSiHayLike($nombreFoto,$usuarioName);
            if($hayLike){
                quitarVoto($nombreFoto,"likes");
                darVoto($nombreFoto,"dislikes");
                actualizarVotoDislike($nombreFoto,$usuarioName);
            }
        }else{
            darVoto($nombreFoto,"dislikes");
            añadirDislike($nombreFoto,$usuarioName);
        }
    }

    function añadirLike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "INSERT INTO valorationphotographies(nameUser,namePhoto,likeP,dislikeP) values(?,?,1,0)";
            $preparadaAñadirLike = $db->prepare($sql);
            $preparadaAñadirLike->execute(array($usuarioName,$nombreFoto));
            $añadirLike = $db->query($sql);
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function añadirDislike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "INSERT INTO valorationphotographies(nameUser,namePhoto,likeP,dislikeP) values(?,?,0,1)";
            $preparadaAñadiDislike = $db->prepare($sql);
            $preparadaAñadiDislike->execute(array($usuarioName,$nombreFoto));
            $añadirDislike = $db->query($sql);
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function existeValoracionFoto($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(namePhoto) FROM valorationphotographies WHERE namePhoto=? AND nameUser=?";
            $preparadaExisteValoracionFoto = $db->prepare($sql);
            $preparadaExisteValoracionFoto->execute(array($nombreFoto,$usuarioName));
            $resultado = $preparadaExisteValoracionFoto->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado[0]==1 ? true : false);
    }    

    function contarLikes($nombreFoto)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(namePhoto) FROM valorationphotographies WHERE namePhoto=? and likeP=1";
            $preparadaContarLikes = $db->prepare($sql);
            $preparadaContarLikes->execute(array($nombreFoto));
            $resultado = $preparadaContarLikes->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado);
    }

    function contarDislikes($nombreFoto)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(namePhoto) FROM valorationphotographies WHERE namePhoto=? and dislikeP=1";
            $preparadaContarDislikes = $db->prepare($sql);
            $preparadaContarDislikes->execute(array($nombreFoto));
            $resultado = $preparadaContarDislikes->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado);
    }

    function haDadoLike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(*) FROM valorationphotographies WHERE namePhoto=? and nameUser=? and likeP=1";
            $preparadaHaDadoLike = $db->prepare($sql);
            $preparadaHaDadoLike->execute(array($nombreFoto,$usuarioName));
            $resultado = $preparadaHaDadoLike->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado);
    }

    function haDadoDislike($nombreFoto,$usuarioName)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(*) FROM valorationphotographies WHERE namePhoto=? and nameUser=? and dislikeP=1";
            $preparadaHaDadoDislike = $db->prepare($sql);
            $preparadaHaDadoDislike->execute(array($nombreFoto,$usuarioName));
            $resultado = $preparadaHaDadoDislike->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado);
    }

    function quitarVoto($nombreFoto,$tipo)
    {
        require('connecta_db_persistent.php');

        if(strcmp($tipo,"dislikes")==0){
            try{
                $sql = "UPDATE photographies SET dislikes=dislikes-1 WHERE hashedName=?";
                $preparadaQuitarVotoNegativo = $db->prepare($sql);
                $preparadaQuitarVotoNegativo->execute(array($nombreFoto));
                $quitarDislike = $db->query($sql);
            }catch(PDOException $e){
                echo 'Error amb la BDs: ' . $e->getMessage();
            }
        }else{
            try{
                $sql = "UPDATE photographies SET likes=likes-1 WHERE hashedName=?";
                $preparadaQuitarVotoNegativo = $db->prepare($sql);
                $preparadaQuitarVotoNegativo->execute(array($nombreFoto));
                $quitarDislike = $db->query($sql);
            }catch(PDOException $e){
                echo 'Error amb la BDs: ' . $e->getMessage();
            }
        }
        
    }

    function darVoto($nombreFoto,$tipo)
    {
        require('connecta_db_persistent.php');

        if(strcmp($tipo,"dislikes")==0){
            try{
                $sql = "UPDATE photographies SET dislikes=dislikes+1 WHERE hashedName=?";
                $preparadaDarVoto = $db->prepare($sql);
                $preparadaDarVoto->execute(array($nombreFoto));
                $quitarDislike = $db->query($sql);
            }catch(PDOException $e){
                echo 'Error amb la BDs: ' . $e->getMessage();
            }
        }else{
            try{
                $sql = "UPDATE photographies SET likes=likes+1 WHERE hashedName=?";
                $preparadaDarVoto = $db->prepare($sql);
                $preparadaDarVoto->execute(array($nombreFoto));
                $quitarDislike = $db->query($sql);
            }catch(PDOException $e){
                echo 'Error amb la BDs: ' . $e->getMessage();
            }
        }
    }

