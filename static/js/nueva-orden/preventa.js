
const buscador = document.querySelector('#buscar-producto');
var result_area = document.querySelector('#area-products');
const loader = `<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_b88nh30c.json" background="transparent"  speed="1"  style="width: 250px; height: 250px;" loop autoplay></lottie-player>`
const not_found = `<lottie-player src="https://assets6.lottiefiles.com/private_files/lf30_cgfdhxgx.json" background="transparent"  speed="1"  style="width: 250px; height: 250px;" loop autoplay></lottie-player>`

let = resp = [{
  codigo: "P00001",
  descripcion: "SSD 120GB Adata",
  marca: "Adata",
  modelo: "PC-320500",
  precio_base: 700.00,
  impuesto: 56.00,
  precio_total: 756.00,
  stock: 31,
  },
  {
    codigo: "P00002",
    descripcion: "Regulador de voltaje UPS 90V",
    marca: "Volti",
    modelo: "UPS872",
    precio_base: 700.00,
    impuesto: 56.00,
    precio_total: 756.00,
    stock: 11,
    },
    {
      codigo: "P00003",
      descripcion: "Espuma limpiadora Perfect choice 432mL",
      marca: "Perfect Choice",
      modelo: "PC-030089",
      precio_base: 68.97,
      impuesto: 11.03,
      precio_total: 80.00,
      stock: 41,
      }]

buscador.addEventListener("keyup", ()=>{
  let param = buscador.value
  console.log(param);
 
/* 
  if(param === "" || param === undefined || param === null){
    result_area.innerHTML = "";
    result_area.classList.add("d-none");
  }else{
    result_area.classList.remove("d-none");
    result_area.innerHTML = `<ul class="item-result-list">
                            <li class="item-result">Codigo: ${resp[0]["codigo"]}</li>
                            <li class="item-result">Codigo: ${resp[0]["codigo"]}</li>
                            </ul>` 
  } */

  $.ajax({
    type: "POST",
    url: "../servidor/busquedas/busqueda-pos.php",
    data: {"param": param},
    dataType: "JSON",
    success: function (response) {

      let limite = 3;
      let timestamp = new Date().getTime();

      result_area.innerHTML = ``
      result_area.innerHTML = `${loader}`

      let estatus = response.status;

      if(estatus == true){
      result_area.innerHTML = `
      <div class="row" code="${timestamp}">
      </div>`
  
       response["data"].forEach((element,index) => {
          console.log(element);
          if(index <= limite){

            let row = document.querySelector(`div[code="${timestamp}"]`)
            row.innerHTML += `
            <div class="col-12 col-md-3">
              <div class="product-item">
                  <div class="product-head">
                      <span class="precio" id="precio">$${element.precio_total}</span>
                      <img src="img/Productos/P${element.id}/p1.jpg" class="product-img" alt="imagen de producto">
                  </div>
                  
                  <div class="product-body">${element.descripcion}
                    <div class="col-12 col-md-2 text-center d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-circle-plus icon-product fa-2xl"></i>
                    </div>
                  </div>
                  
              </div>
            </div>`

          }else if(index > limite){
            let timestamp = new Date().getTime();
            let row = document.querySelector(`div[code="${timestamp}"]`)

            result_area.innerHTML += `<div class="row" code="${timestamp}">
              </div>
            `

            row.innerHTML += `
            <div class="col-12 col-md-3">
              <div class="product-item">
                  <div class="product-head">
                      <span class="precio" id="precio">$68.00</span>
                      <img src="img/Productos/P51/p1.jpg" class="product-img" alt="imagen de producto">
                  </div>
                  
                  <div class="product-body">Aire comprimido Perfect Choice 445mL</div>
                  <div class="col-12 col-md-2 text-center d-flex justify-content-center align-items-center">
                       <i class="fa-solid fa-circle-plus icon-product fa-2xl"></i>
                  </div>
              </div>
            </div>`
          }
          
          index == limite ? limite + 4 : limite = 3;
        });


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

function esPar(x){
  return !( x & 1 );
}
