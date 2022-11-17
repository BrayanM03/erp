<?php


    session_start();
    include '../database/conexion.php';
    
    date_default_timezone_set("America/Matamoros");

    $id_usuario = $_SESSION['id'];


    $consulta = "DELETE FROM carrito_compra WHERE usuario_id = ?";
    $res = $con->prepare($consulta);
    $res->execute([$id_usuario]); 



    $response = array("status"=> true, "mensaje"=> "Carrito vaciado");
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

