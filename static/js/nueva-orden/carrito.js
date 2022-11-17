var product_list = document.querySelector("#products-body");

var area_subtotal = document.querySelector("#subtotal")
var area_descuento = document.querySelector("#descuento")
var area_iva = document.querySelector("#iva")
var area_importe = document.querySelector("#neto")

//?Executando funciones
traerCarrito();

function traerCarrito() {
  $.ajax({
    type: "POST",
    url: "../servidor/carrito/traer-carrito.php",
    data: "data",
    dataType: "JSON",
    success: function (response) {

      if (response.status == false) {
        product_list.innerHTML = "";
        product_list.innerHTML = `

          <li>
            <div class="row text-center">
                <div class="col-12 col-md-12">
                <lottie-player src="https://assets6.lottiefiles.com/private_files/lf30_e3pteeho.json" background="transparent"  speed="1"  style="width: 250px; height: 250px;" loop autoplay></lottie-player></br>
                </div>
                <div class="col-12 col-md-12">
                <p>Sin productos</p>
                </div>
             </div>
          </li>
        `;
      }else{ 
        product_list.innerHTML = "";

        let subtotal = response.subtotal;
        let descuento = response.descuento;
        let iva = response.iva  
        let importe = response.importe  

    let subtotal_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(subtotal)
    let descuento_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(descuento)
    let iva_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(iva)
    let importe_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(importe)

    area_subtotal.textContent = subtotal_formateado
    area_descuento.textContent = descuento_formateado
    area_iva.textContent = iva_formateado
    area_importe.textContent = importe_formateado

     response.data.forEach(element => {
      
     product_list.innerHTML += `
     <li>
        <div class="row text-center">
            <div class="col-12 col-md-6">${element.descripcion}</div>
            <div class="col-12 col-md-3">
               <span class="quanty">${element.cantidad}</span>
            </div>
            <div class="col-12 col-md-3" class="import-cell">$${element.importe}</div>
        </div>
        <div class="row">
          <div class="col-12 d-flex justify-content-end">
            <a class="btn-eliminar" onclick="eliminarItem(${element.id})">Eliminar</a>
          </div>
        </div>
      </li>
     `
     });
      }
    },
  });
}


function setearCarrito(response) { }


function eliminarItem(id_detalle){
  $.ajax({
    type: "POST",
    url: "../servidor/carrito/eliminar-item.php",
    data: {"id_detalle": id_detalle},
    dataType: "JSON",
    success: function (response) {
  
      if(response.status == true){
        
        let subtotal = response.subtotal;
        //let descuento = response.descuento;
        let iva = response.iva  
        let importe = response.importe  

    let subtotal_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(subtotal)
    //let descuento_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(descuento)
    let iva_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(iva)
    let importe_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(importe)

    area_subtotal.textContent = subtotal_formateado
    //area_descuento.textContent = descuento_formateado
    area_iva.textContent = iva_formateado
    area_importe.textContent = importe_formateado
    
        traerCarrito();
      }else{
        Toast.fire({
          icon: "error",
          title: response.message
        }) 
      }
      
  
    }
  });
}

const Toast = Swal.mixin({
  toast: true,
  position: "bottom-start",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});
