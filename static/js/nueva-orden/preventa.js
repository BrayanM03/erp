
const buscador = document.querySelector('#buscar-producto');
var result_area = document.querySelector('#area-products');
const loader = `<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_b88nh30c.json" background="transparent"  speed="1"  style="width: 250px; height: 250px;" loop autoplay></lottie-player>`
const not_found = `<lottie-player src="https://assets6.lottiefiles.com/private_files/lf30_cgfdhxgx.json" background="transparent"  speed="1"  style="width: 250px; height: 250px;" loop autoplay></lottie-player>`


buscador.addEventListener("keyup", ()=>{
  let param = buscador.value

  $.ajax({
    type: "POST",
    url: "../servidor/busquedas/busqueda-pos.php",
    data: {"param": param},
    dataType: "JSON",
    success: function (response) {


      result_area.innerHTML = ``
      result_area.innerHTML = `${loader}`

      let estatus = response.status;

      if(estatus == true){
      
        arreglo_productos = response["data"]
        setPage(0, arreglo_productos, 1)

    }else{
      result_area.innerHTML = `
          <div class="message_empty">
              ${not_found}</br>
              <p>${response.message}</p>
          </div>
      `
    }
  }
  });

  
})

$.ajax({
  type: "POST",
  url: "../servidor/busquedas/busqueda-pos.php",
  data: {"param": ''},
  dataType: "JSON",
  success: function (response) {

    result_area.innerHTML = ``
    result_area.innerHTML = `${loader}`

    let estatus = response.status;

    if(estatus == true){
      var arreglo_productos = shuffle(response.data)

  setPage(0, arreglo_productos, 1)

  }else{
    result_area.innerHTML = `
        <div class="message_empty">
            ${not_found}</br>
            <p>${response.message}</p>
        </div>
    `
  }

  }})

  function shuffle(array) {
    var tmp, current, top = array.length;

    if(top) while(--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
    }

    return array;
}


function setPage(indicador_pag, array_products, pagina_actual){

  let limite = 3;
  let timestamp = new Date().getTime();
  let lim_por_pag = indicador_pag + 12;
  let elementos_pagina = array_products.slice(indicador_pag, lim_por_pag);
  var total_productos = array_products.length

    result_area.innerHTML = `
    <div class="row" code="${timestamp}">
    </div>`

     elementos_pagina.forEach((element,index) => {
        let descrip = element.descripcion.length >= 49 ? element.descripcion.substring(49,0) + "..." : element.descripcion
        
        if(index <= limite){

          let row = document.querySelector(`div[code="${timestamp}"]`)
          let precio_formateado = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(element.precio_total)

          row.innerHTML += `
          <div class="col-12 col-md-3">
            <div class="product-item" onclick="elegirCant(${element.id}, ${element.stock})">
                <div class="product-head">
                    <span class="precio" id="precio">${precio_formateado}</span>
                    <img src="img/Productos/P${element.id}/P1.jpg" class="product-img" alt="imagen de producto">
                </div>
                
                <div class="product-body">
                  <div class="row">
                      <div class="col-12 col-md-9 desc-area">
                        ${descrip}
                      </div>
                      <div class="col-12 col-md-3 stock-area">
                        <b>${element.stock}</b>
                        <i class="fa-solid fa-box icon-product fa-2xl"></i>
                      </div>
                   </div>
                </div>
                
            </div>
          </div>`


        }else if(index > limite){
          let timestamp = new Date().getTime();

          result_area.innerHTML += `<div class="row" code="${timestamp}">
            </div>
          `
          let row = document.querySelector(`div[code="${timestamp}"]`)
 

          row.innerHTML += `
          <div class="col-12 col-md-3">
            <div class="product-item" onclick="elegirCant(${element.id}, ${element.stock})">
                <div class="product-head">
                    <span class="precio" id="precio">$68.00</span>
                    <img src="img/Productos/P${element.id}/p1.jpg" class="product-img" alt="imagen de producto">
                </div>
                
                <div class="product-body">
                  <div class="row">
                      <div class="col-12 col-md-9 desc-area">
                        ${descrip}
                      </div>
                      <div class="col-12 col-md-3 stock-area">
                        <b>${element.stock}</b>
                        <i class="fa-solid fa-box icon-product fa-2xl"></i>
                      </div>
                   </div>
                </div>
                
            </div>
          </div>`
        }
        
        limite += 4
      });

      setPaginador(total_productos, 12, "area-products", indicador_pag, array_products, pagina_actual)


}
 

function elegirCant(product_id, stock) { 
    Swal.fire({
      icon: 'question',
      html: `
        <p>¿Cuantos productos agregar?<p><br>
        <span>Stock disponible: <b id="stock_disponible">${stock}</b> - Stock en carrito: <b id="stock_carrito"></b></span><br>
        <input class="form-control" type="number" placeholder="0" id="cantidad_ingresada"><br>

        <span class="mt-3;">Elija precio a aplicar</span>
        <select class="form-control" id="lista-precios">

        <select><br>
        <div id="area-control-descuentos"></div>
      `,
      didOpen: ()=>{
        $.ajax({
          type: "POST",
          url: "../servidor/nueva-orden/traer-precios.php",
          data: {"product_id": product_id},
          dataType: "JSON",
          success: function (response) {
            let lista_precios = $("#lista-precios")
            $("#stock_carrito").text(response.total_carrito)
            let stock_disp = $("#stock_disponible")
            stock_disp.text(parseInt(stock_disp.text())-parseInt(response.total_carrito))
          lista_precios.empty().append(`
            <option value="base">${response.precio_principal.precio_base} - ${response.precio_principal.etiqueta}</option>
          `)

          if(response.data_precios !== "No se encontro información"){
            response.data_precios.forEach(element => {
              lista_precios.append(`
              <option value="${element.id}">${element.precio_base} - ${element.etiqueta}</option>
            `)
            });
          }
          } 
        });
        

        
         
      },
      confirmButtonText: "Agregar",
      preConfirm: ()=>{
        let cantidad = document.getElementById("cantidad_ingresada").value;

        if(parseInt($("#stock_disponible").text()) < cantidad){
          Swal.showValidationMessage(
            `La cantidad supera el stock`
          )
        }
      }
    }).then((respo)=>{ 
      let cantidad = document.getElementById("cantidad_ingresada").value;
      let dato_precios = document.getElementById("lista-precios").value;

      
       if(respo.isConfirmed){
          $.ajax({
            type: "POST",
            url: "../servidor/nueva-orden/agregar-preventa.php",
            data: {"id_product": product_id, "cantidad": cantidad, "dato_precios": dato_precios},
            dataType: "JSON",
            success: function (response) {
             console.log(response);
             if (response.status == true){
              Toast.fire({
                icon: "success",
                title: response.mensj
              }) 
              traerCarrito();
             }
                
            }
          });

       }

    })

 }

