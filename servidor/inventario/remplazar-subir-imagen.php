<?php


    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');
    
    $producto_id = $_POST['id_producto'];
    $indicador = $_POST['indicador'];
    $folder = "../../static/img/Productos/P$producto_id";
    $_FILES["image"]['name'] = "P$indicador.jpg";
    $image_path = "P$producto_id/P1.jpg";
    $path = "P$producto_id/P1";
    $countfiles = count($_FILES);

    $folder = "../../static/img/Productos/P$producto_id";

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "$folder/".$_FILES['image']['name'])) {
        $updt = "UPDATE inventario SET imagen = ? WHERE id = ?";
        $ree = $con->prepare($updt);
        $ree->execute([$path, $producto_id]);
        $mensaje = "Imagen subida/cambiada correctamente";
        $estatus = true;
    }else{
        $mensaje = "Imagen no pudo ser subida";
        $estatus = false;
    }

    $response = array("status"=>$estatus, "mensaje"=>$mensaje, "files"=>$_FILES, "post"=>$_POST);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);



?>