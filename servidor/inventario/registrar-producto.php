<?php
if ($_POST) {
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

    $modelo = $_POST["modelo"] ?? null;
    $marca = $_POST["marca"] ?? null;
    $upc = $_POST["upc"] ?? null;
    $sat = $_POST["sat"] ?? null;
    $estatus = "Activo";
    $fecha_ingreso = date("Y-m-d");
    $path ="NA";

    $insercion = "INSERT INTO inventario(id, 
                                         codigo, 
                                         descripcion, 
                                         marca, 
                                         modelo, 
                                         costo,
                                         precio,
                                         stock,
                                         estatus,
                                         sucursal,
                                         categoria,
                                         subcategoria,
                                         imagen,
                                         upc,
                                         fecha_ingreso,
                                         sat_key) VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insercion);
   
    $resp->execute([$codigo, $descripcion, $marca, $modelo, $costo, $precio, $cantidad, $estatus,
     $sucursal, $categoria, $subcategoria, $path, $upc, $fecha_ingreso, $sat]);

    $resp->closeCursor();

    $last_id = $con->lastInsertId();
   
    $response = array("status"=>true, "message"=> "Producto agregado correctamente", "id"=>$last_id);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}



?>