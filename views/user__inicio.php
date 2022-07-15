<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Inicio</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    </head>
    <body>
        <style>
            <?php include __DIR__.'/css/general_style.css';?>
            <?php include __DIR__.'/css/inicio.css';?>
            <?php include __DIR__.'/components/pregunta.css';?>
            <?php include __DIR__.'/components/nav_bar.css';?>
            <?php include __DIR__.'/components/lista_cursos.css';?>
            .logo-icon {background-image: url('./../views/icons/logo.png');}
            .eye-icon {background-image: url('./../views/icons/eye.png');}
            .edit-icon {background-image: url('./../views/icons/edit.png');}
            .flag-icon {background-image: url('./../views/icons/flag.png');}
            .checkmark-icon {background-image: url('./../views/icons/checkmark.png');}
            .trash-icon {background-image: url('./../views/icons/delete.png');}
            .x-mark-icon {background-image: url('./../views/icons/x-mark.png');}
            .search-icon {background-image: url('./../views/icons/search.png');}
            .admin-icon {background-image: url('./../views/icons/admin.png');}
        </style>
        <header>
            <?php
            include __DIR__.'../components/nav_bar.php';
            ?>
        </header>

        <main class="main-usando-navbar">
           
            <?php
            include __DIR__.'../components/lista_cursos.php';
            ?>

            <section class="main__contenido">
                <div class="main__contenido__header">
                    <a id="estado_todo" href="../controllers/inicioController.php?action=get_preguntas&estado=all&curso=<?php echo $curso_actual;?>&anio=<?php echo $q_anio;?>">TODO</a>
                    <a id="estado_open" href="../controllers/inicioController.php?action=get_preguntas&estado=open&curso=<?php echo $curso_actual;?>&anio=<?php echo $q_anio;?>">ABIERTAS</a>
                    <a id="estado_close" href="../controllers/inicioController.php?action=get_preguntas&estado=close&curso=<?php echo $curso_actual;?>&anio=<?php echo $q_anio;?>">CERRADAS</a>
                </div>

                <div class="main__contenido__q-list">

                <!-- Traer de la base de datos -->
                <?php if (isset($datos) && $datos!=0): ?>
                <?php foreach ($datos as $dato) { ?>
                        <div class="pregunta">
                            <div class="pregunta__contenido">
                                <div class="pregunta__contenido__info">
                                    <p><?php echo $dato->nombre_curso;?> > <?php echo $dato->tema;?> | <?php echo $dato->fecha_publicacion;?></p>
                                    <p class="pregunta__contenido__status"> Estado: 
                                        <?php if ($dato->estado == 0): ?> 
                                            Abierto
                                        <?php else: ?>
                                            Cerrado
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <h2><?php echo $dato->titulo;?></h2>
                                <p><?php echo $dato->descripcion;?></p>
                            </div>
                            <div class="pregunta__actions">
                                <a href="#"><span class="pregunta-icon eye-icon"></span></a>

                                <?php if ($dato->estado == 0 && $dato->cui_usuario != $_SESSION['usersCUI']): ?> 
                                <a href="#"><span class="pregunta-icon checkmark-icon"></span></a>
                                <?php else: ?>
                                <div><span class="pregunta-icon"></span></div>
                                <?php endif;?>

                                <?php if ($dato->cui_usuario == $_SESSION['usersCUI']&& $dato->estado == 0): ?> 
                                <a href="#"><span class="pregunta-icon edit-icon"></span></a>
                                <?php elseif($_SESSION['admin']==1): ?>
                                <a href="../controllers/adminController.php?action=goTo_formulario_eliminar&id_pregunta=<?php echo $dato->id;?>"><span class="pregunta-icon x-mark-icon"></span></a>
                                <?php else: ?>
                                <div><span class="pregunta-icon"></span></div>
                                <?php endif;?>

                                <?php if ($dato->cui_usuario == $_SESSION['usersCUI']): ?> 
                                <a href="#"><span class="pregunta-icon trash-icon"></span></a>
                                <?php else: ?>
                                <a href="#"><span class="pregunta-icon flag-icon"></span></a>
                                <?php endif;?>
                            </div>
                        </div>                    
                <?php } ?>
                <?php else: ?>
                    <p>No hay preguntas :)</p>
                <?php endif; ?>
                </div>
            </section>
        </main>
        <script>
            function estilo_check_estado(){
                switch('<?php echo $estado_actual?>'){
                    case 'all':
                        document.getElementById("estado_todo").style.backgroundColor = 'var(--color_principal)';
                        break;
                    case 'open':
                        document.getElementById("estado_open").style.backgroundColor = 'var(--color_principal)';
                        break;
                    case 'close':
                        document.getElementById("estado_close").style.backgroundColor = 'var(--color_principal)';
                        break;
                }
            }
            window.addEventListener("load",function() { estilo_check_estado() });
        </script>
    </body>
</html>