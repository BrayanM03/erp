<div class="row mb-2">
    <div class="col-12 col-md-12">
        <h1 class="h3 mb-3 text-center">Agregar nueva mercancia</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-12 col-md-1" id="backbtn_area">
                        <div class="btn" onclick="RegresarAtras(1)">
                            <i class="fa-solid fa-circle-left fa-2xl icono" style="color:#E5BE01"></i>
                        </div>

                    </div>
                    <div class="col-12 col-md-11">
                        <h5 class="card-title mb-0" id="title-card">Desde este panel puedes agregar mercancia previamente registrada</h5>
                    </div>
                </div>


            </div>
            <div class="card-body" id="card-body">

                <div class="row mb-3">

                    <div class="col-12 col-md-6">
                        <span class="mb-2">Sucursal a agregar</span>
                        <select class="form-field mb-1" id="sucursal" name="sucursal">
                            <option value="">Selecciona una sucursal</option>
                            <option value="1">Buena vista</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="cantidad">Producto</label>
                        <select class="form-field" name="producto" id="producto" disabled>
                        </select>
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-12 col-md-8">
                        <div class="producto-data" style="margin-top:22px;border: 1px dashed #c3c3c3; padding:15px; border-radius: 8px">
                            <div class="row mb-2">
                                <div class="col-12 col-sm-4"><b>Codigo:</b></br>
                                    <span id="codigo-data"></span>
                                </div>

                                <div class="col-12 col-sm-4"><b>Estatus:</b></br>
                                    <span id="estatus-data"></span>
                                </div>

                                <div class="col-12 col-sm-4"><b>Stock:</b></br>
                                    <span id="stock-data" class="text-center"></span>
                                </div>


                                <input id="producto_id" style="display:none">


                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4"><b>Categoria:</b></br>
                                    <span id="categoria-data"></span>
                                </div>

                                <div class="col-12 col-sm-4"><b>Subcategoria:</b></br>
                                    <span id="subcategoria-data"></span>
                                </div>

                                <div class="col-12 col-sm-4"><b>Descripción:</b></br>
                                    <span id="descripcion-data" class="text-center"></span>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <label for=""><b>Imagen</b></label>
                        <div class="img-container">
                            <img src="img/productos/NA.jpg" id="img-prod" class="img-fluid" width="120" height="120" alt="Responsive image" style="border:1px solid #c3c3c3; border-radius: 8px;">
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <label for=""><b>Cantidad</b></label>
                        <input type="number" class="form-field" id="cantidad" name="cantidad" placeholder="0">
                    </div>
                </div>


                <div class="row mb-3 justify-content-center" id="area-botones">
                    <div class="col-12 col-md-6 text-center">
                        <div class="btn btn-success disabled" id="btn-add-serie" onclick="agregarSerie()">Agregar</div>
                    </div>
                </div>



                <div class="row mt-5">
                    <div class="col-12 col-md-12">
                        <table id="example" class="table table-hover nowrap" style="width:100%">

                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>