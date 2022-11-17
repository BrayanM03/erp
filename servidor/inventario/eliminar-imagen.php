<?php


    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');
    
    $producto_id = $_POST['id_producto'];
    $indicador = $_POST['id_img'];
    $folder = "../../static/img/Productos/P$producto_id/P$indicador.jpg";
    
    if (unlink($folder)) {
        $mensaje = "Imagen borrada correctamente";
        $estatus = true;
    }else{
        $mensaje = "Imagen no pudo ser borrada";
        $estatus = false;
    }

    $response = array("status"=>$estatus, "mensaje"=>$mensaje, "post"=>$_POST);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);



?>