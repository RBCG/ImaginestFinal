<nav class="main-menu" style="z-index: 30">
    <span>
        <?php 
            $usuari = $_SESSION['usuari'];
            $userName=getNameUserWithNameOrMail($usuari);

            $fotoNueva = obtenerFotoPerfil($userName)[0];

            echo "<img src=\"./fotosProfiles/$fotoNueva.png\" href=\"./home.php\" id=\"fotoSidebar\" class=\"m-t-15\"></img>";
        ?>
        
        <hr style="color:white 5px solid;">
    </span>

    <li class="has-subnav nombre">
        <a href="myprofile.php">
            <i class="fa fa-user fa-2x"></i>
            <span class="nav-text">
            <?php
                echo "@$userName";
            ?>
            </span>
        </a>
    </li>

    <ul>
        <li class="inicio">
            <a href="home.php">
                <i class="fa fa-home fa-2x"></i>
                <span class="nav-text">
                    Inicio
                </span>
            </a>
        </li>
        <li class="inicio">
            <a href="#" data-toggle="modal" data-target="#cambiarFotoPerfil">
                <i class="fa fa-bookmark"></i>
                <span class="nav-text">
                    Cambiar mis datos
                </span>
            </a>
        </li>
        <li class="has-subnav subirFotografia">
            <a href="#" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-upload fa-2x subirFotografia"></i>
                <span class="nav-text">
                    Subir fotografia
                </span>
            </a>
        </li>
        <li class="has-subnav buscador">
            <a href="#" data-toggle="modal" data-target="#buscador">
                <i class="fa fa-search fa-2x subirFotografia"></i>
                <span class="nav-text">
                    Buscador
                </span>
            </a>
        </li>
        <li class="has-subnav videoPublicitario">
            <a href="#" data-toggle="modal" data-target="#video">
                <i class="fa fa-play fa-2x"></i>
                <span class="nav-text">
                    Ver video publicatario
                </span>
            </a>
        </li>
        <li class="cambiarContraseña">
            <?php
                if (strpos($usuari, '@') !== false) {
                    echo "<a href='resetPasswordDentro.php?mail=$usuari'>
                    <i class='fa fa-unlock-alt fa-2x'></i>
                    <span class='nav-text'>
                        Cambiar contraseña
                    </span>
                    </a>";
                }
                ?>
        </li>
        <li class="politicas">
            <a href="politicas.php">
                <i class="fa fa-info fa-2x"></i>
                <span class="nav-text">
                    Politica de privacidad
                </span>
            </a>
        </li>
        <li class="faq">
            <a href="faq.php">
                <i class="fa fa-question-circle fa-2x"></i>
                <span class="nav-text">
                    Preguntas frecuentes
                </span>
            </a>
        </li>
        <li Class="logout">
            <a href="logout.php">
                <i class="fa fa-power-off fa-2x"></i>
                <span class="nav-text">
                    Cerrar sesión
                </span>
            </a>
        </li>
    </ul>
</nav> 