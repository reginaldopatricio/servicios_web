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
        <img class="imagen" src="./imagenes/2764922.png" alt="">
        <h1 class="titulo">CONSULTA PREMIOS</h1>

        <section class="php">
            <h3>Boletos comprados</h3>
            <hr class="linea">
            <?php

            // Incluimos el archivo de conexión mediante PDO
            use LDAP\Result;

            include 'conexion.php';
            $pdo = new Conexion();


            $sql = $pdo->prepare("SELECT * FROM caja ");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 hay datos");

            // Sacamos todos los resultados de la base de datos
            $resultado = $sql->fetchAll();

            // Mostrar resultados
            foreach ($resultado as $row) {
                $acumulado = $pdo->prepare("INSERT INTO acumulado (fecha_sorteo, numero_boleto)
Values (:fecha_sorteo, :numero_boleto)");
                $acumulado->bindParam(':fecha_sorteo', $row['fecha_sorteo']);
                $acumulado->bindParam(':numero_boleto', $row['numero_boleto']);
                $acumulado->execute();
            }


            try {

                //LA TRANSACCION
                $pdo->beginTransaction();
                //SI EL BOLETO COMPRADO ES IGUAL AL GANADOR
                $pdo->exec("UPDATE acumulado SET premio = 600000 WHERE EXISTS (SELECT * FROM sorteo WHERE sorteo.numero_boleto = acumulado.numero_boleto AND sorteo.fecha_sorteo=acumulado.fecha_sorteo)");

                //SI EL BOLETO COMPRADO SEGUN LA FECHA TIENE EL ÚTIMO DIGITO QUE APARECE EN EL BOLETO GANADOR
                $pdo->exec("UPDATE acumulado SET premio = 60000 WHERE RIGHT(numero_boleto, 1) = (SELECT RIGHT(numero_boleto, 1) FROM sorteo WHERE premio != 600000 AND fecha_sorteo = acumulado.fecha_sorteo LIMIT 1)");

                //SI EL BOLETO COMPRADO SEGUN LA FECHA TIENE LOS DOS ULTIMOS DIGITO QUE APARECEN EN EL BOLETO GANADOR
                $pdo->exec("UPDATE acumulado SET premio = 6000 WHERE RIGHT(numero_boleto, 2) = (SELECT RIGHT(numero_boleto, 2) FROM sorteo WHERE premio != 600000 AND fecha_sorteo = acumulado.fecha_sorteo LIMIT 1)");

                //SI EL BOLETO COMPRADO SEGUN LA FECHA TIENE LOS TRES ULTIMOS DIGITOS QUE APARECEN EEN EL BOLETO GANADOR
                $pdo->exec("UPDATE acumulado SET premio = 600 WHERE RIGHT(numero_boleto, 3) = (SELECT RIGHT(numero_boleto, 3) FROM sorteo WHERE premio != 600000 AND fecha_sorteo = acumulado.fecha_sorteo LIMIT 1)");

                //SI EN EL BOLETO COMPRADO APARECE UN CERO NOS AÑADIRA EL PREMIO
                $pdo->exec("UPDATE acumulado SET premio = 60 where numero_boleto LIKE '%0%'");

                $pdo->commit();
            } catch (Exception $e) {
                $pdo->rollback();
                echo 'fallo' . $e->getMessage();
            }


            //MOSTRAR POR PANTALLA
            $sql = $pdo->prepare("SELECT * FROM acumulado");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 hay datos");

            // Sacamos todos los resultados de la base de datos
            $resultado = $sql->fetchAll();

            // Mostrar resultados
            foreach ($resultado as $row) {
                echo "<b>" . '<span style="margin-right: 55px;">' . $row["fecha_sorteo"] . '</span>' . '<span style="margin-right: 55px;">' .  $row["numero_boleto"] . '</span>' . '<span style="margin-right: 55px;">' . $row["premio"] . "€" . '</span>' . "</b><br>";
            }


            //SUMAR TODOS LOS VALORES DE LA TABLA
            $sql = "SELECT SUM(premio) as total FROM acumulado";

            // Ejecutar la consulta
            $stmt = $pdo->query($sql);

            // Obtener el resultado de la consulta
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Imprimir el resultado
            echo "<br>";
            echo "<hr class='linea'>";
            echo "La sumatoria total es: " . '<span style="margin-left: 80px;">' . $resultado['total'] . "€" . '</span>';

            ?>
        </section>
        <a href="inicio.html"><button class="enlace1">VOLVER AL MENU</button></a>
    </section>

</body>

</html>