<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Tasti| Administrador > Formulario</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <h2>Eliminar Pregunta</h2>
        <form method="POST" action="../controllers/adminController.php">
            <input type="hidden" name="action" value="eliminar_pregunta">
            <input type="hidden" name="id_pregunta" value="<?php echo $datos_pregunta->id?>">
            <p><?php echo $datos_pregunta->nombre_curso;?> > <?php echo $datos_pregunta->tema;?> | <?php echo $datos_pregunta->fecha_publicacion;?></p>
            <p> Estado: 
                <?php if ($datos_pregunta->estado == 0): ?> 
                    Abierto
                <?php else: ?>
                    Cerrado
                <?php endif; ?>
            </p>
            </div>
            <p>Titulo: <?php echo $datos_pregunta->titulo;?></p>
            <p>Descripcion: <?php echo $datos_pregunta->descripcion;?></p>
            <label id="razon" name="razon">Razon:</label>
            <textarea id="razon" name="razon" placeholder="Motivo de su denuncia"></textarea>
            <button type="submit">Eliminar</button>
            <a href="../controllers/inicioController.php">Cancelar</a>
        </form>
        
        <script src="" async defer></script>
    </body>
</html>