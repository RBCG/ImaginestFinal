<!-- SUBIR FOTOGRAFIA NUEVA -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content fondoModalFoto">
            <div class="modal-header">
                <div class="centerText">
                    <h4 class="modal-title ModalLabelTamaño" id="exampleModalLabel">Crear publicación</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body infoPublicPhoto">
                <div class="PublicPhotoDiv1">
                    <?php echo "<img src='./fotosProfiles/$fotoNueva.png' id='fotoAddPhoto' class='m-t-2'></img>" ?>
                </div>
                <div class="PublicPhotoDiv2 ">
                    <span>
                    <?php
                        echo "@$userName";
                    ?>
                    </span>
                    <br>
                    <span id="hashtag" style="color: purple">#</span>
                    <span id="letraL" style="color: red">L</span>
                    <span id="letraE" style="color: yellow">e</span>
                    <span id="letraG" style="color: green">G</span>
                    <span id="letraO" style="color: blue">o</span>
                    <span id="letraN" style="color: purple">n</span>
                </div>
            </div>
            <div class="modal-body">
                <form action="./db/controlArchivos.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <textarea maxlength="200" class="form-control" name="descripcionFoto" id="exampleFormControlTextarea1" placeholder="¿En que está pensando, <?php echo $userName ?>?" rows="3" style="background-color: #242526; color: #C4C6CA; border: gray 1px solid"></textarea>
                    </div>
                    <div class="file-upload">

                        <div class="image-upload-wrap">
                            <input class="file-upload-input" type='file' name="fotoSubida" onchange="readURL(this);" accept="image/*" required />
                            <div class="drag-text">
                                <h3>Arrastra y suelta una imagen o haz clic</h3>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#"/>
                            <div class="image-title-wrap">
                                <button type="button" onclick="removeUpload()" class="remove-image">Eliminar <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                    </div>

                    <input class="btn-enviar" name="resetpassword" type="submit" value="Enviar"/>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- VIDEO PUBLICITARIO -->
<div class="modal fade" id="video" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="col">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/hZ4eByRDqJo" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<!-- BUSCADOR -->
<div class="modal fade" id="buscador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content fondoModalFoto" >
            <div class="modal-header">
                <div class="centerText">
                    <h4 class="modal-title ModalLabelTamaño" id="exampleModalLabel">Buscador de usuarios</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="buscarTodosLosUsuarios" data-toggle="modal" data-target="#todosLosUsuarios">Consultar todos los usuarios</p>
                <?php if(isset($error) && $error == TRUE){
                    echo '<div class="alert alert-danger alert-dismissible fade show m-t-5" role="alert">
                    ¡Vaya! Este usuario no existe. Si tiene dudas sobre el nombre de alguno, consulta la lista.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                }?>
                <form action="./searchUser.php" method="POST" enctype="multipart/form-data"> 
                    <div class="wrap-input100 validate-input">
                        <input class="input100" style="width: 100%" type="text" name="usuarioBuscado" placeholder="🔎 Introduce el nombre de un usuario..." required>
                        <span class="focus-input100"></span>
                        <input class="btn-enviar-buscador" type="submit" value="Buscar usuario"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MOSTRAR TODOS LOS USUARIOS -->
<div class="modal fade" id="todosLosUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content fondoModalFoto" >
            <div class="modal-header">
                <div class="centerText">
                    <h4 class="modal-title ModalLabelTamaño" id="exampleModalLabel">Consultar todos los usuarios</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php 
                    $todosLosUsuariosDB = buscarTodosLosUsuariosDB();
                    foreach($todosLosUsuariosDB as $usuarioDB) echo "<p>⮕ $usuarioDB[0]</p>";
                ?>
            </div>
        </div>
    </div>
</div>

<!-- CAMBIAR FOTO PERFIL USU /  -->
<div class="modal fade" id="cambiarFotoPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content fondoModalFoto">
            <div class="modal-header">
                <div class="centerText">
                    <h4 class="modal-title ModalLabelTamaño" id="exampleModalLabel">Cambiar datos perfil</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="./db/controlArchivosProfile.php" method="POST" enctype="multipart/form-data"> 
                    <p id="infoActualizarDatos">Aquí podras actualizar tanto tu nombre, apellido/s y foto de perfil</p>
                    <input class="input100" style="width: 100%" type="text" name="nuevoNombre" placeholder="Introduce tu nuevo nombre...">
                    <input class="input100" style="width: 100%" type="text" name="nuevoApellido" placeholder="Introduce tu/s nuevos apellidos...">
                    <div class="file-upload">
                        <div class="image-upload-wrap">
                            <input class="file-upload-input" type='file' name="fotoPerfil" onchange="readURL(this);" accept="image/*"/>
                            <div class="drag-text">
                                <h3>Arrastra y suelta una imagen o haz clic</h3>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#"/>
                            <div class="image-title-wrap">
                                <button type="button" onclick="removeUpload()" class="remove-image">Eliminar <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                    </div>

                    <input class="btn-enviar" name="resetpassword" type="submit" value="Enviar"/>
                </form>
            </div>
        </div>
    </div>
</div>