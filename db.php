<?php

//Definicion de los datos para conectarse al servidor de base de datos

$servername="";   //Direccion del servidor
$username="";                //Nombre del usuario de la base de datos
$password="";              //Contraseña del usuario
$dbname="";             //Nombre de la base de datos

//Crear la conexion con la base de datos usando la clase mysqli

$conn = new mysqli($servername, $username, $password,$dbname);

//Verificar si ocurrio un error al conectarse
    if($conn->connect_error){
        die("conexion fallida:". $conn->connect_error)
    }

    //Si la conexion fue exitosa se muestra este mensaje
    
        echo "Conexion exitosa a la base de datos"; 

        //Cerrar la conexion para liberar recursos

        $conn->close();
        ?>