<div id="main-menu-mobile">
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="myprofile.php"><?php echo "@$userName"; ?></a>
        <a href="home.php">Inicio</a>
        <a onclick="closeNav()" href="#" data-toggle="modal" data-target="#cambiarFotoPerfil">Cambiar mis datos</a>
        <a onclick="closeNav()" href="#" data-toggle="modal" data-target="#exampleModal">Subir fotografia</a>
        <a onclick="closeNav()" href="#" data-toggle="modal" data-target="#buscador">Buscador</a>
        <?php
            if (strpos($usuari, '@') !== false) {
                echo "<a href='resetPasswordDentro.php?mail=$usuari'>
                <span class='nav-text'>
                    Cambiar contraseña
                </span>
                </a>";
            }
        ?>
        <a href="politicas.php">Política de privacidad</a>
        <a href="faq.php">Preguntas frecuentes</a>
        <a href="logout.php">Cerrar sesión</a>
    </div>

    <div id="main">
        <button class="openbtn" onclick="openNav()">IMAGINEST▾</button>
    </div>
</div>