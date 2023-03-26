<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos.css/estilos.css">
    <title>Document</title>
</head>

<body>
    <section class="contenedor">
        <img class="imagen" src="./imagenes/2764922.png" alt="">
        <h1 class="titulo">SERVICIO DE LOTERIA</h1>
        <p>Has accedido al servicio web de loteria</p>
        <a href="inicio.html"><button class="enlace">EMPEZAR</button></a>

        <section><?php
                    $host = "localhost";
                    $user = "edib";
                    $password = "edib";
                    $bbdd = "servicios_web";
                    $conector = mysqli_connect($host, $user, $password);

                    //comprobación de la connexion
                    if ($conector) {
                        // echo "Conexion establecida correctamente a Mysql con el usuario: <b>" . $user . "</b>";
                        echo "<br>";
                        $sentencia = "CREATE DATABASE servicios_web";
                        $resultado = mysqli_query($conector, $sentencia);
                        if ($resultado) {
                            //echo "la base de datos servicios se ha creado correctamente";
                            echo "<br>";
                            //Seleccion de la base de datos
                            $ElegirBD = mysqli_select_db($conector, "servicios_web");
                            if ($ElegirBD) {
                                //echo "Se ha seleccionado correctamente la base de datos";
                                echo "<br>";
                                $acumulado = "CREATE TABLE `servicios_web`.`acumulado` ( `id_acumulado` INT NOT NULL AUTO_INCREMENT , `fecha_sorteo` DATE NOT NULL , `numero_boleto` INT NOT NULL , `premio` INT NOT NULL , PRIMARY KEY (`id_acumulado`)) ENGINE = InnoDB;";
                                $res = mysqli_query($conector, $acumulado);
                                if ($res) {
                                    echo "<br>";
                                    //echo "La tabla ha sido creada correctamente";
                                } else {
                                    echo "no se ha creado correctamente";
                                }

                                $premios = "CREATE TABLE `servicios_web`.`sorteo` ( `id_sorteo` INT NOT NULL AUTO_INCREMENT , `fecha_sorteo` DATE NOT NULL , `numero_boleto` INT NOT NULL , PRIMARY KEY (`id_sorteo`)) ENGINE = InnoDB;";
                                $valores = mysqli_query($conector, $premios);
                                if ($valores) {
                                    echo "<br>";
                                    //echo "La tabla ha sido creada correctamente";
                                    echo "<br>";
                                } else {
                                    echo "no se ha creado correctamente";
                                }
                                $tabla = "CREATE TABLE `servicios_web`.`caja` ( `id_caja` INT NOT NULL AUTO_INCREMENT , `fecha_sorteo` DATE NOT NULL , `numero_boleto` INT(10) NOT NULL , PRIMARY KEY (`id_caja`)) ENGINE = InnoDB;";
                                $valor = mysqli_query($conector, $tabla);
                                if ($valor) {
                                    echo "<br>";
                                    //echo "La tabla ha sido creada correctamente";
                                    echo "<br>";
                                } else {

                                    echo "No se ha creado correctamente";
                                }
                            } else {
                                echo "No se ha seleccionado correctamente la base de datos";
                                echo "<br>";
                            }
                        } else {
                            echo "<br>No se ha podido crear correctamente la tabla <b>" . $bbdd . "</b><br>";
                        }
                    }
                    ?></section>
    </section>

</body>

</html>
