<?php
if ($_POST) {
    session_start();
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];
    $subcategoria = $_POST["subcategoria"];
    $cantidad = $_POST["cantidad"];
    $sucursal = $_POST["sucursal"];
    $costo = $_POST["costo"];
    $precio = $_POST["precio"];
    $tasa = $_POST["tasa"];
    $impuesto = $_POST["impuesto"];
    $precio_total = $_POST["precio_total"];
    $usuario_id = $_SESSION["id"];

    $modelo = $_POST["modelo"] ?? null;
    $marca = $_POST["marca"] ?? null;
    $upc = $_POST["upc"] ?? null;
    $sat = $_POST["sat"] ?? null;
    $estatus = "Pendiente";
    $fecha_ingreso = date("Y-m-d");
    $path ="NA";

    $insercion = "INSERT INTO inventario(id, 
                                         codigo, 
                                         descripcion, 
                                         marca, 
                                         modelo, 
                                         costo,
                                         precio_base,
                                         tasa,
                                         impuesto,
                                         precio_total,
                                         stock,
                                         estatus,
                                         sucursal,
                                         categoria,
                                         subcategoria,
                                         imagen,
                                         upc,
                                         fecha_ingreso,
                                         sat_key) VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insercion);
   
    $resp->execute([$codigo, $descripcion, $marca, $modelo, $costo, $precio, $tasa, $impuesto, $precio_total, $cantidad, $estatus,
     $sucursal, $categoria, $subcategoria, $path, $upc, $fecha_ingreso, $sat]);

    $resp->closeCursor();

    $last_id = $con->lastInsertId(); 

    $folder_product = "P" . $last_id;
    $folder = "../../static/img/Productos/$folder_product";

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }


    //Procesando la tabla de precios

    $compr = "SELECT COUNT(*) FROM precios_tmp WHERE usuario_id = ?";
    $r = $con->prepare($compr);
    $r->execute([$usuario_id]);
    $total_prec = $r->fetchColumn(); 
    $r->closeCursor();

    if($total_prec > 0){

        $select = "SELECT * FROM precios_tmp WHERE usuario_id = ?";
        $re = $con->prepare($select);
        $re->execute([$usuario_id]);

        while ($row = $re->fetch(PDO::FETCH_OBJ)) {

            $data[] = $row;
            $insert = "INSERT INTO precios (id, costo, precio_base, tasa, impuesto, precio_neto, etiqueta, producto_id, usuario_id)
            VALUES (null, ?,?,?,?,?,?,?,?)";
            $resp = $con->prepare($insert);
            $resp->execute([$row->costo, $row->precio_base, $row->tasa, $row->impuesto,
            $row->precio_neto, $row->etiqueta, $last_id, $usuario_id]);
            $resp->closeCursor(); 
        
        }
        $re->closeCursor();
  
    }else{
        $data = [];
    }
   
    $response = array("status"=>true, "message"=> "Producto agregado correctamente", "id"=>$last_id, "data"=>$data);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}



?>