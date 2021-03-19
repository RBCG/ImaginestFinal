<?php
    require_once("controlUsuari.php");

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $fotoPerfil = $_FILES["fotoPerfil"]["name"];
        $firstName = $_POST['nuevoNombre'];
        $lastName = $_POST['nuevoApellido'];
    } else header("Location: ../home.php");
    
    $username = getNameUserWithNameOrMail($_SESSION['usuari']);

    if($fotoPerfil!=null){
        $hashedNameFoto = hash('sha256', $fotoPerfil.rand());
        move_uploaded_file($_FILES["fotoPerfil"]["tmp_name"], "../fotosProfiles/" . $hashedNameFoto . ".png");
    
        actualizarFotoPerfilUsu($hashedNameFoto,$username);
    }

    if($firstName!=null){
        actualizarFirstNameUsu($firstName,$username);
    }

    if($lastName!=null){
        actualizarLastNameUsu($lastName,$username);
    }
    

    header("Location: ../home.php");

    function actualizarFotoPerfilUsu($nameFoto,$username){
        require('connecta_db_persistent.php');
        try{
            $sql = "UPDATE users SET fotoPerfil = ? WHERE username=?";
            $preparadaActPhotoProfile = $db->prepare($sql);
            $preparadaActPhotoProfile->execute(array($nameFoto,$username));

        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function actualizarFirstNameUsu($firstName,$username){
        require('connecta_db_persistent.php');
        try{
            $sql = "UPDATE users SET userFirstName = ? WHERE username=?";
            $preparadaActFirstName = $db->prepare($sql);
            $preparadaActFirstName->execute(array($firstName,$username));

        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function actualizarLastNameUsu($lastName,$username){
        require('connecta_db_persistent.php');
        try{
            $sql = "UPDATE users SET userLastName = ? WHERE username=?";
            $preparadaActLastName = $db->prepare($sql);
            $preparadaActLastName->execute(array($lastName,$username));

        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }