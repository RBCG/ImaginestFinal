<?php
    require_once("controlUsuari.php");

    session_start();

    $mida = $_FILES["fotoSubida"]["size"];

    
        $hashedNameFoto = hash('sha256', $_FILES["fotoSubida"]["name"].rand());
        $descripcionFoto = $_POST["descripcionFoto"];
        $res = move_uploaded_file($_FILES["fotoSubida"]["tmp_name"], "../fotosPublicadas/" . $hashedNameFoto . ".png");

        preg_match_all('/(#[A-Za-z0-9-_]+)(?:#[A-Za-z0-9-_]+)*/', $descripcionFoto, $hashtags);

        $textoConHashtags = "";
        if(count($hashtags[0])>0){
            foreach($hashtags[0] as $nombreHashtag){
                $textoConHashtags .= $nombreHashtag . " ";
                if (!existeHashtag($nombreHashtag)) añadirHashtags($nombreHashtag);
            }
        }

        if($res){
            $usuari = getNameUserWithNameOrMail($_SESSION['usuari']);
            publicarFoto($hashedNameFoto,$descripcionFoto,$textoConHashtags,$usuari);
            
        }else{
            echo "<br>Error a la hora de publicar la fotografia!!";
        }

    header("Location: ../home.php");

    function publicarFoto($nameF,$descF,$hashtags,$nameUser)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "INSERT INTO photographies(hashedName,description,publicationDate,likes,dislikes,hashtagName,postedBy) values(?,?,CURRENT_TIMESTAMP,?,?,?,?)";
            $preparePublicarFoto = $db->prepare($sql);
            $preparePublicarFoto->execute(array($nameF,$descF,0,0,$hashtags,$nameUser)); 
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function existeHashtag($hashtag)
    {

        require('connecta_db_persistent.php');
        
        try{
            $sql = "SELECT count(name) FROM hashtags where name=?";
            $prepareExisteNameHashtag = $db->prepare($sql);
            $prepareExisteNameHashtag->execute(array($hashtag)); 
            $resultado = $prepareExisteNameHashtag->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }

        return ($resultado[0]==1 ? true : false); 
    }

    function añadirHashtags($hashtag)
    {

        require('connecta_db_persistent.php');

        try{
            $sql = "INSERT INTO hashtags(name) values (?)";
            $prepareAñadirHashtag = $db->prepare($sql);
            $prepareAñadirHashtag->execute(array($hashtag)); 
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }
?>