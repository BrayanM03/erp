
 
 main_content = $('#main-content');
 let arrayImages = []


function clickNuevoProducto(){

    main_content.empty().load(`vistas/inventario/agregar-producto-nuevo.php`, {
        postdata: false,
        proveedor : "",
        tonelaje: "",
        modelo : "",
        marca : "",
        cantidad : "",
        costo : "",
        precio : ""}, function (param) {

          activarNavTab()
          eliminarPrecioTMP(0, 'total')

          //Agregando eventos
          $("#categoria").change(()=>{
            let categoria = $("#categoria").val();

            switch (categoria) {
                case "computacion":
                        $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                        <option value="almacenamiento">Almacenamiento</option>
                        <option value="almacenamiento">Accesorios</option>
                        <option value="almacenamiento">Energia</option>
                        <option value="almacenamiento">Equipos</option>
                        <option value="almacenamiento">Gaming</option>
                        <option value="almacenamiento">Mantenimiento</option>
                        <option value="almacenamiento">Software</option>
        
                        `)
                    break;
        
                    case "seguridad":
                        $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                        <option value="cctv">CCTV</option>
                        <option value="accesorios">Accesorios</option>
                        <option value="control_acceso">Control de acceso</option>
                        `)
                    break;
        
                    case "impresion":
                        $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                        <option value="consumibles">Consumibles</option>
                        <option value="impresoras">Impresoras</option>
                        `)
                    break; 
                    
                    case "redes":
                        $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                        <option value="cableado_estructurado">Cableado estructurado</option>
                        <option value="conectividad">Conectividad</option>
                        <option value="herramientas">Herramientas</option>
                        <option value="telefonia">Telefonia</option>
                        `)
                    break;
                    case "punto_de_venta":
                        $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                        <option value="cajones">Cajones</option>
                        <option value="impresoras_termicas">Impresoras termicas</option>
                        <option value="escaners">Escaners</option>
                        `)
                    break;
            
                default:
                $("#subcategoria").prop("disabled", true).empty().css("background", "#E7E3E3").css("color", "gray").append(`
                        <option value="null">Elige una categoria primero</option>
                        `)
                    break;
            }})

            $("#codigo").keyup(function(){
                let codigo = $("#codigo").val()
                validarCodigo(codigo)
            })

            $("#precio-base").keyup(function(){
              
              let precio = precioTotal("base")
              
              $("#precio-total").val(precio)
          })

          $("#impuesto").change(()=>{

            let precio = precioTotal("impuesto")
            $("#precio-total").val(precio)
          })

          $("#precio-total").keyup(()=>{

            let base = precioTotal("total")
            $("#precio-base").val(base)
          })

          



        ejecutarDropzoneJS();


        
          });

        
}

function clickEditarProducto(e) {

    let producto_id = getParameterByName("id_product");
    let sucursal_id = getParameterByName("sucursal");

    $.ajax({
        type: "POST",
        url: "../servidor/inventario/traer-datos-en-base-uno.php",
        data: {"id": producto_id, "tabla": "inventario", "indicador": "id"},
        dataType: "JSON",
        success: function (response) {

            response['data'].forEach(element => {
                data = {
                id_producto: producto_id,
                codigo: element.codigo,
                descripcion: element.descripcion,
                marca : element.marca,
                modelo : element.modelo,
                costo : element.costo,
                precio_base : element.precio_base,
                tasa : element.tasa,
                impuesto: element.impuesto,
                precio_total : element.precio_total,
                stock : element.stock,
                estatus : element.estatus,
                sucursal : element.sucursal,
                categoria: element.categoria,
                subcategoria: element.subcategoria,
                id_sucursal: sucursal_id,     
                upc: element.upc,
                fecha_ingreso: element.fecha_ingreso,
                sat_key : element.sat_key
              }
            });
           

            main_content.empty().load(`vistas/inventario/actualizar-datos-producto.php?store_id=${sucursal_id}`, data, ()=>{
              activarNavTab()

              $("#categoria").change(()=>{
                let categoria = $("#categoria").val();
    
                switch (categoria) {
                    case "computacion":
                            $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                            <option value="almacenamiento">Almacenamiento</option>
                            <option value="accesorios">Accesorios</option>
                            <option value="energia">Energia</option>
                            <option value="equipos">Equipos</option>
                            <option value="gaming">Gaming</option>
                            <option value="mantenimiento">Mantenimiento</option>
                            <option value="software">Software</option>
            
                            `)
                        break;
            
                        case "seguridad":
                            $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                            <option value="cctv">CCTV</option>
                            <option value="accesorios">Accesorios</option>
                            <option value="control_acceso">Control de acceso</option>
                            `)
                        break;
            
                        case "impresion":
                            $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                            <option value="consumibles">Consumibles</option>
                            <option value="impresoras">Impresoras</option>
                            `)
                        break; 
                        
                        case "redes":
                            $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                            <option value="cableado_estructurado">Cableado estructurado</option>
                            <option value="conectividad">Conectividad</option>
                            <option value="herramientas">Herramientas</option>
                            <option value="telefonia">Telefonia</option>
                            `)
                        break;
                        case "punto_de_venta":
                            $("#subcategoria").prop("disabled", false).empty().css("background", "#FFF").css("color", "#99A3BA").append(`
                            <option value="cajones">Cajones</option>
                            <option value="impresoras_termicas">Impresoras termicas</option>
                            <option value="escaners">Escaners</option>
                            `)
                        break;
                
                    default:
                    $("#subcategoria").prop("disabled", true).empty().css("background", "#E7E3E3").css("color", "gray").append(`
                            <option value="null">Elige una categoria primero</option>
                            `)
                        break;
                }})
    
                $("#codigo").keyup(function(){
                    let codigo = $("#codigo").val()
                    validarCodigo(codigo)
                })
    
                $("#precio-base").keyup(function(){
                  
                  let precio = precioTotal("base")
                  
                  $("#precio-total").val(precio)
              })
    
              $("#impuesto").change(()=>{
    
                let precio = precioTotal("impuesto")
                $("#precio-total").val(precio)
              })
    
              $("#precio-total").keyup(()=>{
    
                let base = precioTotal("total")
                $("#precio-base").val(base)
              })

              //Activando funcion principal de edicion de imagenes
              dibujarCanvas()
            }
            );
        }
    });
  
           
}

function clickagregarSeries(){
   
    main_content.empty().load(`vistas/inventario/ingresar-producto-existente.php`, function() {
        
        agregarEventos()
        $("#producto").select2({
          theme: "bootstrap",
        })
      });

}



function RegresarAtras(vista){
 
    let id_product = getParameterByName("id_product");
    let sucursal = getParameterByName("store_id");
    let name = getParameterByName("name");

    if(vista == 1){
        main_content.empty().load(`vistas/inventario/seleccionar-tipo-agregar.php?store_id=${sucursal}&name=${name}`,()=>{
          eliminarPrecioTMP(0, 'total')
        });
    }else if(vista == 2){

        main_content.empty().load(`vistas/inventario/nuevo-aire.php`, {
              postdata: true,
              proveedor : datosForm.get("proveedor"),
              tonelaje: datosForm.get("tonelaje"),
              modelo : datosForm.get("modelo"),
              marca : datosForm.get("marca"),
              cantidad : datosForm.get("cantidad"),
              costo : datosForm.get("costo"),
              precio : datosForm.get("precio")
        });

       
    }else if(3){ //vista desde el editor de productos
        main_content.empty().load(`vistas/inventario/seleccionar-opcion-edicion.php?store_id=${sucursal}&id_product=${id_product}&name=${name}`);
    }
    
}


function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }

function ejecutarDropzoneJS(){

  console.log("great");

  let myDropzone = new Dropzone("#my-great-dropzone",{ 
    url: "agregar-producto.php",
    paramName: "file",
    addRemoveLinks: true,
    dictRemoveFile: "Remover",
    maxFilesSize:2,
    maxFiles: 3,
    parallelUploads: 10,
    acceptedFiles: ".jpg, .jpeg",

   });

  /* Dropzone.options.myGreatDropzone = { // camelized version of the `id`
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 3, // MB
    maxFiles: 1,
    acceptedFiles: ".jpg, .jpeg",
    uploadMultiple: false, 
    parallelUploads: 10,
    addRemoveLinks: true,
    dictRemoveFile: "Remover",
    init: function () { 

      this.on("success", function(file, response) {  
       
      });  

    },
  }; */

  myDropzone.options.dictMaxFilesExceeded = "No puedes subir m??s 3 imagenes";


  myDropzone.on('addedfile', function(file) {
    arrayImages.push(file);
  })

  myDropzone.on('removedfile', function(file) {
    let i = arrayImages.indexOf(file);
    arrayImages.splice(i, 1);
  })


}  

function precioTotal(origen) {
  let precio_base = parseFloat(document.getElementById("precio-base").value)
  let tasa = parseInt(document.getElementById("impuesto").value)
  let precio_total = parseFloat(document.getElementById("precio-total").value)

  switch (origen) {
    case "base":
      var impuesto = ((precio_base * tasa)/100) 
      var impuesto_redondeado = Number.parseFloat(impuesto).toFixed(2); 
      $("#impuesto").attr("impuesto", impuesto_redondeado) 
      var response = precio_base + impuesto; 
     
      
      break;

      case "impuesto":
      var impuesto = ((precio_base * tasa)/100)
      var impuesto_redondeado = Number.parseFloat(impuesto).toFixed(2); 
      $("#impuesto").attr("impuesto", impuesto_redondeado) 
      var response = precio_base + impuesto; 
      
      break;

      case "total":
       if(tasa == 16){iva =1.16}else if(tasa == 8){ iva =1.08}else{ iva =0}   
      var base = (precio_total / iva)
      var impuesto = ((base * tasa)/100) 
      var impuesto_redondeado = Number.parseFloat(impuesto).toFixed(2); 
      $("#impuesto").attr("impuesto", impuesto_redondeado) 
      var response = base; 
 
      
      break;
  
    default:
      break;

    
  }
  var respuesta = Number.parseFloat(response).toFixed(2); 

  return respuesta;

}




