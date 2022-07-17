<!DOCTYPE html>
<html lang="es">

<head>

</head>

<body>
    <h1> Editar pregunta </h1>
    <br><br>

        <form name="form_editar_pregunta" action="../controllers/pregunta.php" method="post">
        <input type="hidden" name="type" value="edit">
        Id: <input name="id" type="text"/>  <br/><br/>
        Titulo: <input name="titulo" type="text"/>  <br/><br/>
        Descripcion:  <textarea name="descripcion"> </textarea> <br/><br/>
        <input type="submit" value="Enviar ahora"/>
        </form>
</body>
</html>