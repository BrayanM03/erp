

let producto_buscador = $("#producto");
seleccionarProducto()
function seleccionarProducto(){
//Select2 clientes
let id_sucursal = $("#sucursal").val();
let indicador = "sucursal";
let tabla_ref = "inventario";

$("#cantidad").on("keyup change", ()=>{
  colocarDatosDePreciosEnLabel()
})

traerTotales()

producto_buscador.select2({
    placeholder: "Productos",
    theme: "bootstrap-5",
    height:"20px",
    ajax: {
        url: "../servidor/busquedas/buscar-productos.php",
        type: "post",
        dataType: 'json',
        delay: 250,

        data: function (params) {
           
           
          return {
            tabla: tabla_ref,
            indicador: indicador,
            id: id_sucursal,
            input: params // search term
            
          };
         },
        processResults: function (data) {
            return {
               results: data
            }; 
          },
       
        cache: true

    },
    language:  {

        inputTooShort: function () {
            return "Busca un cliente...";
          },
          
        noResults: function() {
    
          return "Sin resultados";        
        },
        searching: function() {
    
          return "Buscando..";
        }
      },

      templateResult: formatResultProducts,
        templateSelection: formatSelection

});
}

function formatResultProducts(repo){
  
  
    if(repo.loading == true){
      var $container = $(
        `
        <div class="row">
          <div class="col-12 col-md-12">
            <span>${repo.text}</span>
          </div>
        </div>`
      
    );
    }else{
      if(repo.status !== false){
        var $container = $(
          `
          <div class="row">
            <div class="col-12 col-md-2">
               <img src="img/productos/P${repo.id}/P1.jpg" style="width:60px;border-radius:8px;">
            </div>
            <div class="col-12 col-md-10 text-start">
              <div class="row">
                <span id="${repo.id}">${repo.descripcion}</span>
              </div>
              <div class="row">
                  <div class="col-12 col-md-12 text-start">
                    <span style="font-size:12px;"><b>$${repo.precio_base}</b> | ${repo.categoria} - ${repo.subcategoria} |  Stock ${repo.stock} | <i class="fa-solid fa-magnifying-glass"></i> ${repo.codigo}</span>
                  </div> 
              </div>
            </div>
          </div>`
        
      );
      }else{
        var $container = $(`<a href="./agregar-producto.php">${repo[0]}</a>`)
      }
        
      
    }
      
    
  
 
return $container
}

function formatSelection(repo){
  if(repo.id !== ''){
    let select_cont =  $("#select2-producto-container")
    select_cont.attr("categoria-data",repo.categoria)
    select_cont.attr("subcategoria-data",repo.subcategoria)
    select_cont.attr("codigo-data",repo.codigo)
    select_cont.attr("estatus-data",repo.estatus)
    select_cont.attr("stock-data",repo.stock)
    select_cont.attr("precio",repo.precio_base)
    let utilidad = (parseFloat(repo.precio_base) - parseFloat(repo.costo)).toFixed(2);
    let tasa = ((utilidad / parseFloat(repo.costo))*100).toFixed(2)
    $("#porcentaje").val(tasa)
    $("#precio").val(repo.precio_base);
    $("#costo").val(repo.costo);
    $("#utilidad").val(utilidad);
    select_cont.attr("descripcion-data",repo.descripcion)
    select_cont.attr("id_producto", repo.id)

    var response = repo.descripcion

  }else{
    var response = repo.text
  }

  return response
}

function agregarATabla(){
  let select_cont =  $("#select2-producto-container")
  let categoria = select_cont.attr("categoria",)
  let subcategoria = select_cont.attr("subcategoria-data")
  let codigo = select_cont.attr("codigo-data")
  let estatus = select_cont.attr("estatus-data")
  let stock = select_cont.attr("stock-data")
  let descripcion = select_cont.attr("descripcion-data")
  let id_producto = select_cont.attr("id_producto")
  let cantidad = $("#cantidad").val()
  let precio = $("#precio").val()
  let descuento = $("#descuento").val() ? $("#descuento").val() : 0;


  $.ajax({
    type: "POST",
    url: "../servidor/cotizaciones/registrar-precotizacion.php",
    data: {
      categoria,
      subcategoria,
      codigo,
      estatus,
      stock,
      descripcion,
      id_producto,
      cantidad,
      precio,
      descuento
    },
    dataType: "JSON",
    success: function (response) {
      if(response.status == true){
        Toast.fire({
          icon: 'success',
          title: response.message
        })
      }else{
        Toast.fire({
          icon: 'error',
          title:  response.message
        })
      }
      tabla.ajax.reload(null, false)
      traerTotales()
    }
  });

}


function eliminarProducto(id_prod){

  Swal.fire({
    icon: "question",
    html: "<b>¿Seguro de eliminarlo de la lista?</b>",
    confirmButtonText: "Si",
    showCancelButton: true,
    cancelButtonText: "Mejor no"
  }).then((response) => {
    if(response.isConfirmed) {

      let dato = {
        type: "eliminacion",
        id_producto: id_prod
    };

      $.ajax({
        type: "POST",
        url: "../servidor/cotizaciones/eliminar-precotizacion.php",
        data: dato,
        dataType: "JSON",
        success: function (response) {
        
        tabla.ajax.reload(null, false)
        traerTotales()
        Toast.fire({
          icon: 'success',
          title: response.mensj
        })
          
        }
    });

    }
  }) 
    
}

function traerTotales(){
  let tasa = $("#tasa").val();

  $.ajax({
    type: "POST",
    url: "../servidor/cotizaciones/traer-totales.php",
    data: {"tasa": tasa},
    dataType: "JSON",
    success: function (response) {

     let impuesto = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(response.impuesto)
     let subtotal = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(response.subtotal)
     let neto = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(response.neto)
      let descuento = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(response.descuento)
     $("#subtotal_final").text(subtotal)
     $("#impuesto_final").text(impuesto)
     $("#descuento_final").text(descuento)
     $("#tasa_final").text(tasa.split("0.").pop()+"%")
     $("#total_final").text(neto)
    }
  });
}
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

activarEventosKeyUp()
function activarEventosKeyUp(){
    let porcentaje_utilidad = $("#porcentaje")
    let costo = $("#costo")
    let utilidad = $("#utilidad")
    let precio = $("#precio")
    let descuento = $("#descuento")

    costo.on('keyup change',()=>{
     
     let nueva_utilidad = (parseFloat(costo.val()) * (parseFloat(porcentaje_utilidad.val() ? porcentaje_utilidad.val() : 0)/ 100)).toFixed(2)
     let nuevo_precio_base = (parseFloat(costo.val()) + parseFloat(nueva_utilidad)).toFixed(2)
   
     utilidad.val(nueva_utilidad)
     precio.val(nuevo_precio_base)
     colocarDatosDePreciosEnLabel()
    })

    porcentaje_utilidad.on('keyup change',()=>{
      let nueva_utilidad = (parseFloat(costo.val()) * (parseFloat(porcentaje_utilidad.val() ? porcentaje_utilidad.val() : 0)/ 100)).toFixed(2)
      let nuevo_precio_base = (parseFloat(costo.val() ? costo.val() : 0) + parseFloat(nueva_utilidad)).toFixed(2)
      utilidad.val(nueva_utilidad)
      precio.val(nuevo_precio_base)
      colocarDatosDePreciosEnLabel()
    })

    utilidad.on('keyup change',()=>{
      let nuevo_porcentaje =  ((parseFloat(utilidad.val() ? utilidad.val() : 0) / parseFloat(costo.val() ? costo.val() : 0))*100).toFixed(2)
      let nuevo_precio_base = (parseFloat(costo.val() ? costo.val() : 0) + parseFloat(utilidad.val() ? utilidad.val() : 0)).toFixed(2)
      porcentaje_utilidad.val(nuevo_porcentaje)
      precio.val(nuevo_precio_base)
      colocarDatosDePreciosEnLabel()
    })

    precio.on('keyup change',()=>{
      let nueva_utilidad = (parseFloat(precio.val() ? precio.val() : 0) - parseFloat(precio.val() ? precio.val() : 0)).toFixed(2)
      let nuevo_porcentaje =  ((parseFloat(nueva_utilidad) / parseFloat(costo.val() ? costo.val() : 0))*100).toFixed(2)
      porcentaje_utilidad.val(nuevo_porcentaje)
      utilidad.val(nueva_utilidad)
      colocarDatosDePreciosEnLabel()
    })

    descuento.on('keyup change',()=>{
      colocarDatosDePreciosEnLabel()
    })
}

function colocarDatosDePreciosEnLabel(){
  let cant = $("#cantidad").val() ? $("#cantidad").val() : 0
  let precio_base = (parseFloat($("#precio").val() ? $("#precio").val() : 0)).toFixed(2)
  let precio_base_total = cant * precio_base
  let descuento = (parseFloat($("#descuento").val() ? $("#descuento").val() : 0)).toFixed(2)

  let descueno_f = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(descuento)
  let precio_base_f = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(precio_base)
  let precio_base_total_f = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(precio_base_total)
  $("#cantidad_label").text(cant)
  $("#precio_base_label").text(precio_base_f)
  $("#precio_base_total_label").text(precio_base_total_f)
  $("#descuento_label").text(descueno_f)

  let precio_final = precio_base_total - descuento;
  let precio_final_f = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(precio_final)
  $("#precio_final_label").text(precio_final_f)
}


 