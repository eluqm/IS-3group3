<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Mi Perfil</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <style>
            <?php include __DIR__.'/css/general_style.css';?>
            <?php include __DIR__.'/components/nav_bar.css';?>

            <?php include __DIR__.'/css/pregunta.css';?>
            <?php include __DIR__.'/css/main_pregunta.css';?>
            <?php include __DIR__.'/components/pregunta.css';?>
            
        </style>
        <header>
            <?php
            include __DIR__.'../components/nav_bar.php';
            ?>
        </header>


    
    <main class="main-usando-navbar ">
        
        <section class="main__contenido"> 
            <div class="main__contenido__q-list">
            <div class="main_pregunta">
            <div class="pregunta__contenido">
                <p class="fecha">22/22/22</p>
                <h2><?php echo $data->titulo;?></h2>
                <br/><hr><br/>
                <p class="parrafo"><?php echo $data->descripcion;?></p>
            </div>
            </div>
            </div>
        </section>

        <aside>
            <br/>
            <div class="pregunta__contenido_info">
                <p><?php echo $data->curso;?></p>
                <a href="#"><span class="main_pregunta-icon edit-icon"></span></a>
                <a href="#"><span class="main_pregunta-icon delete-icon"></span></a>
            </div>

            <div class="main_pregunta">
            <div class="pregunta__contenido">
                <p class="info">Curso:</p>
                <p class="info"><?php echo $data->nombre_curso;?></p>
                <br/>
                <p class="info">Tema:</p>
                <p class="info"><?php echo $data->tema;?></p>
                <br/>
                <p class="info">Usuario:</p>
                <p class="info"><?php echo $data->cui_usuario;?></p>
                <br/>
                <p class="info">Disponibilidad:</p>
                <p class="info"><?php echo $data->disponibilidad;?></p>
                <br/>
                
            </div>
            </div>
            <button class="aside__button-log-out">
                ENSE&Ntilde;AR
            </button>
            
        </aside>

    </main>


        <script src="" async defer></script>
    </body>

</html>