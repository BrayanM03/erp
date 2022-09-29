<?php
if ($_POST) {
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');


    $key = $_POST['id_orden'];
    $tabla = $_POST['tabla'];
    $indicador = $_POST['indicador'];

    $tabla_detalle = $_POST['tabla_detalle'];
    $indicador_detalle = $_POST['indicador_detalle'];
    
    $consultar = $con->prepare("SELECT COUNT(*) FROM $tabla WHERE $indicador  = ?");
    $consultar->execute([$key]);
    $total = $consultar->fetchColumn(); 

    if($total > 0){

        $consultar = $con->prepare("SELECT * FROM $tabla WHERE $indicador  = ? ORDER BY id DESC");
        $consultar->execute([$key]);
        while ($row = $consultar->fetch()) {

            
        
            $fecha = $row['fecha'];
            $hora = $row['hora'];
            $usuario_nombre = $row['usuario_nombre'];
            $sucursal_id = $row['sucursal_id'];

           

            /* $data['data'] = array(""); */
        }

        $datos_sucursal = obtenerDatosSucursal($con, $sucursal_id); //

        $response["folio"] = $key;
        $response["fecha"] =     $fecha;
        $response["hora"] =     $hora;
        $response["usuario"] =   $usuario_nombre;
        $response["datos_sucursal"] = $datos_sucursal;
        $response["id_sucursal"] = $sucursal_id;
        $response['status'] =    true;
        $response['mensj'] =     "Se encontraron datos";


        //BUSCANDO LOS DETALLES DE LA ORDENES

        $consulta_orden = "SELECT COUNT(*) FROM $tabla_detalle WHERE $indicador_detalle = ?";
        $resp = $con->prepare($consulta_orden);
        $resp->execute([$key]);
        $total_ordenes = $resp->fetchColumn();

    
        if($total_ordenes > 0) {
            $consulta_orden = "SELECT * FROM $tabla_detalle WHERE $indicador_detalle = ?";
            $resp = $con->prepare($consulta_orden);
            $resp->execute([$key]);

            while ($fila_orden = $resp->fetch()) {

                $codigo = $fila_orden['codigo'];
                $item_descripcion = $fila_orden["concepto"];
                $item_cant = $fila_orden["cantidad"];
                $producto_id = $fila_orden["producto_id"];
                $usuario_id = $fila_orden["usuario_id"];

                $detalle_orden[] = array("codigo" => $codigo, 
                                        "descripcion" => $item_descripcion, 
                                         "cantidad" => $item_cant);
                
            }
            $response["detalle_orden"] = $detalle_orden;
        }


        
    }else{
        $response['status'] = false;
        $response['mensj'] = "No se encontro un elemento coincidente";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);


}

function obtenerDatosSucursal($con, $sucursal_id){

    $queryCount = "SELECT count(*) FROM sucursal WHERE id = ?";
    $resp = $con->prepare($queryCount);
    $resp->execute([$sucursal_id]);
    $total = $resp->fetchColumn();

    if($total > 0){
        $selectStore = "SELECT * FROM sucursal WHERE id = ?";
        $resp = $con->prepare($selectStore);
        $resp->execute([$sucursal_id]);
        while ($row = $resp->fetch()) {
            $data = $row;
        }
        return $data;
    }else{
        return "No se encontro una sucursal coincidente";
    }

}

?>