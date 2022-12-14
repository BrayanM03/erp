<!-- TESTE DE DESARROLLO DE PAGINA -->

<div class="row mb-2">
    <div class="col-12 col-md-12">
        <h1 class="h3 mb-3 text-center">Agregar producto nuevo</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-7">

        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a class="nav-link active" id="datos-generales" data-toggle="tab" href="#generales-tab" role="tab" aria-controls="generales-tab" aria-selected="true">
                    <span style="font-size: 19px; color: Tomato;"><i class="fa-solid fa-tags"></i></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="datos-precios" data-toggle="tab" href="#precios-tab" role="tab" aria-controls="precios-tab" aria-selected="false">
                    <span style="font-size: 19px; color: Gray;"><i class="fa-solid fa-money-bill-wave"></i></span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="generales-tab" role="tabpanel" aria-labelledby="datos-generales">
                <div class="card">
                    <div class="card-header text-center">
                        <div class="row">
                            <div class="col-12 col-md-1" id="backbtn_area">
                                <div class="btn" onclick="RegresarAtras(1)">
                                    <i class="fa-solid fa-circle-left fa-2xl icono" style="color:#E5BE01"></i>
                                </div>

                            </div>
                            <div class="col-12 col-md-11">
                                <h5 class="card-title mb-0" id="title-card">Ingresa los datos del producto</h5>
                            </div>
                        </div>


                    </div>
                    <div class="card-body" id="card-body">

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">

                                <label for="codigo">Codigo</label>
                                <!-- <select name="proveedor" class="form-control" id="proveedor"></select> -->
                                <input name="codigo" value="P00005" class="form-field" id="codigo" placeholder="Escribe un codigo interno">
                                <div class="col-12 text-end"><small class="d-none" valid="false" id="small_response">Codigo en uso</small></div>
                            </div>
                            <!-- <div class="col-12 col-md-2 mt-4">
                                    <div class="btn btn-info" onclick="generarCodigo()">Generar</div>
                                </div> -->


                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="modelo">Categoria</label>
                                <select class="form-field" name="categoria" id="categoria">
                                    <option value="null">Selecciona una categoria</option>
                                    <option value="computacion">Computaci??n</option>
                                    <option value="seguridad">Seguridad</option>
                                    <option value="impresion">Impresi??n</option>
                                    <option value="redes">Redes</option>
                                    <option value="punto_de_venta">Punto de venta</option>


                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="marca">Subcategoria</label>
                                <select class="form-field" style="background: rgb(231, 227, 227); color: gray" name="subcategoria" id="subcategoria" disabled>
                                    <option value="null">Primero elige una categoria</option>
                                </select>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="cantidad">Cantidad</label>
                                <input class="form-field" type="number" placeholder="0" name="cantidad" id="cantidad">
                            </div>

                            <div class="col-12 col-md-6">
                                <span class="mb-2">Sucursal a agregar</span>
                                <select class="form-field mb-1" id="sucursal" name="sucursal">
                                    <option value="1">Buena vista</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mb-3 justify-content-between">
                            <div class="col-12 col-md-3">
                                <label for="costo">Costo</label>
                                <input class="form-field" placeholder="0.00" name="costo" id="costo" type="number">
                            </div>
                            <div class="col-4 col-md-3">
                                <label for="precio-base">Precio base</label>
                                <div class="row">
                                    <div class="col-9 col-md-9">
                                        <input class="form-field" placeholder="0.00" name="precio-base" id="precio-base" type="number">
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <i class="fa-solid fa-plus mt-3" style="color:#20c997;"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="col-4 col-md-3">
                                <label for="impuesto">Impuesto</label>

                                <div class="row">
                                    <div class="col-9 col-md-9">
                                        <select class="form-field" name="impuesto" id="impuesto" impuesto="">
                                            <option value="0">Sin desglosar</option>
                                            <option value="8" selected>IVA 8%</option>
                                            <option value="16">IVA 16%</option>
                                        </select>
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <i class="fa-solid fa-equals fa-beat mt-3" style="color:#20c997;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3">
                                <label for="precio-total">Precio total</label>
                                <input class="form-field" placeholder="0.00" name="precio-total" id="precio-total" type="number">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-12">
                                <label for="descripcion">Descripci??n</label>
                                <textarea autocapitalize="sentences" class="form-field" placeholder="Escribe una descripci??n del producto" id="descripcion"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-end">
                            <div class="col-12 col-md-3 text-end">
                                <a class="buttom-advanced-options" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Campos adicionales
                                </a>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-12 col-md-12">
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-6">
                                                <label for="modelo">Modelo</label>
                                                <input class="form-field" placeholder="Escribe un modelo" name="modelo" id="modelo">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="marca">Marca</label>
                                                <input class="form-field" placeholder="Escribe una marca" name="marca" id="marca">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-6">
                                                <label for="modelo">UPC</label>
                                                <input class="form-field" placeholder="Escribe un codigo de barras UPC" name="upc" id="upc">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="marca">Clave SAT</label>
                                                <input class="form-field" placeholder="Escribe una clave SAT" name="sat" id="sat">
                                            </div>
                                        </div>

                                        <div class="row justify-content-center mt-3">
                                            <div class="col-12 col-md-10">



                                                <form class="dropzone" id="my-great-dropzone" action="#" enctype="multipart/form-data">
                                                    <div class="dz-message">
                                                        <div class="icon">
                                                            <i id="cloud-icon" class="fas fa-cloud-upload-alt"></i>
                                                        </div>

                                                        <h4>Elige una foto para tu producto</h4>
                                                        <span class="note">No hay archivos seleccionados (Max. 3)</span>
                                                    </div>
                                                    <div class="fallback">
                                                        <input type="file" name="file">
                                                    </div>
                                                </form>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="btn btn-success" onclick="agregarProducto()">Agregar</div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-12 col-md-12">
                                <table id="example" class="table table-hover nowrap" style="width:100%">
                                    <!-- <thead>
                                                            <tr>
                                                                <th>Subscriber ID</th>
                                                                <th>Install Location</th>
                                                                <th>Subscriber Name</th>
                                                                <th>some data</th>
                                                            </tr>
                                                        </thead> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="precios-tab" role="tabpanel" aria-labelledby="datos-precios">
                <div class="card">
                    <div class="card-header text-center">
                        <div class="row">
                            <div class="col-12 col-md-1" id="backbtn_area">
                                <div class="btn" onclick="RegresarAtras(1)">
                                    <i class="fa-solid fa-circle-left fa-2xl icono" style="color:#E5BE01"></i>
                                </div>

                            </div>
                            <div class="col-12 col-md-11">
                                <h5 class="card-title mb-0" id="title-card">??Agrega mas precios a tu producto!</h5>
                            </div>
                        </div>
                    </div>

                    <div class="body-card" style="padding: 1rem;">

                    <div class="row mb-3 justify-content-between">
                            <div class="col-12 col-md-3">
                                <label for="costo-agregar">Costo</label>
                                <input class="form-field" placeholder="0.00" name="costo" id="costo-agregar" type="number">
                            </div>
                            <div class="col-4 col-md-3">
                                <label for="precio-base-agregar">Precio base</label>
                                <div class="row">
                                    <div class="col-9 col-md-9">
                                        <input class="form-field" placeholder="0.00" name="precio-base-agregar" id="precio-base-agregar" type="number">
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <i class="fa-solid fa-plus mt-3" style="color:#20c997;"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="col-4 col-md-3">
                                <label for="impuesto-agregar">Impuesto</label>

                                <div class="row">
                                    <div class="col-9 col-md-9">
                                        <select class="form-field" name="impuesto-agregar" id="impuesto-agregar" impuesto="">
                                            <option value="0">Sin desglosar</option>
                                            <option value="8" selected>IVA 8%</option>
                                            <option value="16">IVA 16%</option>
                                        </select>
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <i class="fa-solid fa-equals fa-beat mt-3" style="color:#20c997;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3">
                                <label for="precio-total-agregar">Precio total</label>
                                <input class="form-field" placeholder="0.00" name="precio-total-agregar" id="precio-total-agregar" type="number">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-12 col-md-8">
                                <label for="etiqueta-agregar"></label>
                                <input id="etiqueta-agregar" class="form-field" placeholder="Escribe una etiqueta">
                            </div>
                            <div class="col-12 col-md-2">
                                <div id="btn-agregar-precios" style="margin:32px;" class="btn btn-primary" onclick="agregarPrecioTmp()">Agregar</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table id="tabla-precios-tmp" class="table"></table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>



    </div>
</div>