function setPaginador(numProductos, cantPorPagina, id, indicador_pag, arreglo_prod, pag_actual){

    let base = document.querySelector(`#${id}`)
    let numPaginas = Math.ceil(numProductos / cantPorPagina);
    let json_arreglo = JSON.stringify(arreglo_prod)
    console.log(json_arreglo);
    base.innerHTML +=`
    <div class="row">
    <div class="col-12 col-md-12">
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item disabled" onclick='goPage(${pag_actual-1}, ${json_arreglo})'>
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
      </li>
      <div id="paginator-body" class="pagination-body">
        
      </div>
      <li class="page-item" onclick='goPage(${pag_actual+1}, ${json_arreglo})'>
            <a class="page-link" href="#">Siguiente</a>
        </li>
    </ul>
  </nav>
  </div>
  </div>
    `
  let paginator_body = document.querySelector("#paginator-body");  

  for (let index = 0; index < numPaginas; index++) {
    pagIndex = index + 1
    let clas_pag_activa = pag_actual === pagIndex ? "pag_activa" : ''
    paginator_body.innerHTML += `<li class="page-item"><a class="page-link ${clas_pag_activa}" onclick='goPage(${pagIndex}, ${json_arreglo})' href="#">${pagIndex}</a></li>`
    
  }



}

function goPage(pageNumber,arr) {
  pN = pageNumber - 1
  num = pN * 12
  setPage(num, arr, pageNumber)


}