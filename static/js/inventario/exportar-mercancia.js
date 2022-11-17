

let producto_buscador = $("#producto");
seleccionarProducto()
function seleccionarProducto(){
//Select2 clientes
let id_sucursal = $("#sucursal").val();
let indicador = "sucursal";
let tabla_ref = "inventario";

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
          <span id="${repo.id}">${repo.text}</span>
        </div>
      </div>`
    
  );
  }else{
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
                <span style="font-size:12px;">${repo.categoria} - ${repo.subcategoria} |  Stock ${repo.stock} | <i class="fa-solid fa-magnifying-glass"></i> ${repo.codigo}</span>
              </div> 
          </div>
        </div>
      </div>`
    
  );
  }
 
return $container
}

function formatSelection(repo){
     
  if(repo.id !== "null"){
    let select_cont =  $("#select2-producto-container")
    select_cont.attr("categoria-data",repo.categoria)
    select_cont.attr("subcategoria-data",repo.subcategoria)
    select_cont.attr("codigo-data",repo.codigo)
    select_cont.attr("estatus-data",repo.estatus)
    select_cont.attr("stock-data",repo.stock)
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


  $.ajax({
    type: "POST",
    url: "../servidor/inventario/registar-presalida.php",
    data: {
      categoria,
      subcategoria,
      codigo,
      estatus,
      stock,
      descripcion,
      id_producto,
      cantidad
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
    }
  });

}


function eliminarProducto(id_prod){
  let id_usuario = $("#user-data").attr("id_user");

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
        url: "../servidor/inventario/tabla-presalida.php",
        data: dato,
        dataType: "JSON",
        success: function (response) {
        
        tabla.ajax.reload(null, false)

        Toast.fire({
          icon: 'success',
          title: response.mensj
        })
          
        }
    });

    }
  }) 
    
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


 