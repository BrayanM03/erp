  <?php
  session_start();
  include '../database/conexion.php';
  
  date_default_timezone_set("America/Matamoros");
  $detalle_id = $_POST["id_detalle"];
  $sesion_id = $_SESSION["id"];
  $response = array();

  $select = "SELECT * FROM carrito_compra WHERE id = ?";
  $resp = $con->prepare($select);
  $resp->execute([$detalle_id]);
  $importe =0;
  $iva =0;
  while ($row = $resp->fetch(PDO::FETCH_OBJ)) {
      //print_r($row['importe']);
      $importe = floatval($row->importe);
      $iva = floatval($row->impuesto);
  }

  $selects = "SELECT SUM(impuesto) as suma_impuesto, SUM(importe) as suma_importe FROM carrito_compra WHERE usuario_id = ?";
  $res = $con->prepare($selects);
  $res->execute([$sesion_id]);
  
  while ($rows = $res->fetch(PDO::FETCH_OBJ)) {
      //print_r($row['importe']);
      $importe_actual = floatval($rows->suma_importe);
      $iva_actual = floatval($rows->suma_impuesto);
  }

  $importe_restante = $importe_actual - $importe;
  $iva_restante = $iva_actual - $iva;


  $delete = "DELETE FROM carrito_compra WHERE id = ?";
  $re = $con->prepare($delete);
  $re->execute([$detalle_id]);
  $re->closeCursor();


  $response["status"] = true;
  $response["iva"] = $iva_restante;
  $response["importe"] = $importe_restante;

  echo json_encode($response, JSON_UNESCAPED_UNICODE);


  ?>