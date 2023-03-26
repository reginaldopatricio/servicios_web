<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos.css/inicio.css">
    <title>Document</title>
</head>

<body>
    <section class="container1">
        <img class="imagen1" src="./imagenes/2764922.png" alt="">
        <a href="inicio.html"><button class="enlace">VOLVER AL MENU</button></a>
        <section><?php
                    include 'conexion.php';

                    $pdo = new Conexion();

                    //Insertar registro
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $sql = "INSERT INTO sorteo (fecha_sorteo, numero_boleto) VALUES(:fecha_sorteo, :numero_boleto)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindValue(':fecha_sorteo', $_POST['fecha_sorteo']);
                        $stmt->bindValue(':numero_boleto', $_POST['numero_boleto']);
                        $stmt->execute();
                        $idPost = $pdo->lastInsertId();
                        if ($idPost) {
                            header("HTTP/1.1 200 Ok");
                            echo "<h1>se han guardado los datos correctamete</h1>";
                            exit;
                        }
                    }
                    ?></section>
    </section>
</body>

</html>