<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <img src="./img/logo.jpg" alt="" style="width:80px; border-radius:7px; margin-right:1rem;">
            <span class="align-middle">Systechh</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Inicio
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Panel</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="nueva-orden.php">
                    <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Nueva venta</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Nueva cotización</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Historial</span>
                </a>
            </li>

            <!-- <li class="sidebar-item">
                <a class="sidebar-link" href="pages-blank.html">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Blank</span>
                </a>
            </li> -->

            <li class="sidebar-header">
                Inventario
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="agregar-producto.php">
                    <i class="align-middle" data-feather="plus-circle"></i> <span class="align-middle">Ingresar mercancia</span>
                </a>
            </li>


            <?php

            include './../servidor/database/conexion.php';

            $consultar_sucu = "SELECT COUNT(*) FROM sucursal";
            $res = $con->prepare($consultar_sucu);
            $res->execute();
            $total_sucu = $res->fetchColumn();
            $res->closeCursor();

            if ($total_sucu > 0) {

                $consultar = $con->prepare("SELECT * FROM sucursal");
                $consultar->execute();
                while ($row = $consultar->fetch()) {

            ?>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <li class="sidebar-item accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row["id"] ?>" aria-expanded="true" aria-controls="collapse<?php echo $row["id"] ?>">
                                <a class="sidebar-link" href="#">
                                    <i class="align-middle" data-feather="map-pin"></i> <span class="align-middle"><?php echo $row["name"] ?></span>
                                </a>
                            </li>




                            <div id="collapse<?php echo $row["id"] ?>" class="accordion-collapse collapse" style="margin-left:13px;" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    <div class="accordion" id="accordionComputers">
                                        <div class="accordion-item">

                                            <li class="sidebar-item accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseC<?php echo $row["id"] ?>" aria-expanded="true" aria-controls="collapseC<?php echo $row["id"] ?>">
                                                <a class="sidebar-link" href="#">
                                                    <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Computación</span>
                                                </a>
                                            </li>

                                            <div id="collapseC<?php echo $row["id"] ?>" class="accordion-collapse collapse" style="margin-left:13px;" aria-labelledby="headingComputers" data-bs-parent="#accordionComputers">
                                                <div class="accordion-body">
                                                    <div class="accordion-item">
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=computacion&subcategoria=almacenamiento">
                                                                <i class="align-middle" data-feather="hard-drive"></i> <span class="align-middle">Almacenamiento</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=computacion&subcategoria=accesorios">
                                                                <i class="align-middle" data-feather="mic"></i> <span class="align-middle">Accesorios</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=computacion&subcategoria=energia">
                                                                <i class="align-middle" data-feather="battery-charging"></i> <span class="align-middle">Energia</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=computacion&subcategoria=equipos">
                                                                <i class="align-middle" data-feather="monitor"></i> <span class="align-middle">Equipos</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=computacion&subcategoria=gaming">
                                                                <i class="align-middle" data-feather="headphones"></i> <span class="align-middle">Gaming</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=computacion&subcategoria=mantenimiento">
                                                                <i class="align-middle" data-feather="feather"></i> <span class="align-middle">Mantenimiento</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=computacion&subcategoria=software">
                                                                <i class="align-middle" data-feather="chrome"></i> <span class="align-middle">Software</span>
                                                            </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="accordion" id="accordionSeguridad">
                                        <div class="accordion-item">

                                            <li class="sidebar-item accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseS<?php echo $row["id"] ?>" aria-expanded="true" aria-controls="collapseS<?php echo $row["id"] ?>">
                                                <a class="sidebar-link" href="#">
                                                    <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Seguridad</span>
                                                </a>
                                            </li>

                                            <div id="collapseS<?php echo $row["id"] ?>" class="accordion-collapse collapse" style="margin-left:13px;" aria-labelledby="headingSecurity" data-bs-parent="#accordionSeguridad">
                                                <div class="accordion-body">
                                                    <div class="accordion-item">
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=seguridad&subcategoria=cctv">
                                                                <i class="align-middle" data-feather="video"></i> <span class="align-middle">CCTV</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=seguridad&subcategoria=accesorios">
                                                                <i class="align-middle" data-feather="lock"></i> <span class="align-middle">Accesorios</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=seguridad&subcategoria=control_acceso">
                                                                <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Control de acceso</span>
                                                            </a>
                                                        </li>
                                                       
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="accordion" id="accordionImpresion">
                                        <div class="accordion-item">

                                            <li class="sidebar-item accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseI<?php echo $row["id"] ?>" aria-expanded="true" aria-controls="collapseI<?php echo $row["id"] ?>">
                                                <a class="sidebar-link" href="#">
                                                    <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Impresión</span>
                                                </a>
                                            </li>

                                            <div id="collapseI<?php echo $row["id"] ?>" class="accordion-collapse collapse" style="margin-left:13px;" aria-labelledby="headingPrinters" data-bs-parent="#accordionImpresion">
                                                <div class="accordion-body">
                                                    <div class="accordion-item">
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=impresion&subcategoria=consumibles">
                                                                <i class="align-middle" data-feather="droplet"></i> <span class="align-middle">Consumibles</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=impresion&subcategoria=impresoras">
                                                                <i class="align-middle" data-feather="printer"></i> <span class="align-middle">Impresoras</span>
                                                            </a>
                                                        </li>
                                                       
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="accordion" id="accordionRedes">
                                        <div class="accordion-item">

                                            <li class="sidebar-item accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseR<?php echo $row["id"] ?>" aria-expanded="true" aria-controls="collapseR<?php echo $row["id"] ?>">
                                                <a class="sidebar-link" href="#">
                                                    <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Redes</span>
                                                </a>
                                            </li>

                                            <div id="collapseR<?php echo $row["id"] ?>" class="accordion-collapse collapse" style="margin-left:13px;" aria-labelledby="headingNetwork" data-bs-parent="#accordionRedes">
                                                <div class="accordion-body">
                                                    <div class="accordion-item">
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=redes&subcategoria=cableado_estructurado">
                                                                <i class="align-middle" data-feather="git-merge"></i> <span class="align-middle">Cableado estructurado</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=redes&subcategoria=conectividad">
                                                                <i class="align-middle" data-feather="wifi"></i> <span class="align-middle">Conectividad</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=redes&subcategoria=herramientas">
                                                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Herramientas</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=redes&subcategoria=telefonia">
                                                                <i class="align-middle" data-feather="phone"></i> <span class="align-middle">Telefonia</span>
                                                            </a>
                                                        </li>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="accordion" id="accordionPV">
                                        <div class="accordion-item">

                                            <li class="sidebar-item accordion-button" data-bs-toggle="collapse" data-bs-target="#collapsePV<?php echo $row["id"] ?>" aria-expanded="true" aria-controls="collapsePV<?php echo $row["id"] ?>">
                                                <a class="sidebar-link" href="#">
                                                    <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Punto de venta</span>
                                                </a>
                                            </li>

                                            <div id="collapsePV<?php echo $row["id"] ?>" class="accordion-collapse collapse" style="margin-left:13px;" aria-labelledby="headingPV" data-bs-parent="#accordionPV">
                                                <div class="accordion-body">
                                                    <div class="accordion-item">
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=punto_de_venta&subcategoria=cajones">
                                                                <i class="align-middle" data-feather="hard-drive"></i> <span class="align-middle">Cajones</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="inventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=punto_de_venta&subcategoria=impresoras_termicas">
                                                                <i class="align-middle" data-feather="printer"></i> <span class="align-middle">Impresoras termicas</span>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="iinventario.php?store_id=<?php echo $row["id"] ?>&name=<?php echo $row["name"] ?>&categoria=punto_de_venta&subcategoria=escaners">
                                                                <i class="align-middle" data-feather="list"></i> <span class="align-middle">Escaner</span>
                                                            </a>
                                                        </li>
                                                       
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>






                                    <!-- <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">
                                            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Seguridad</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">
                                            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Impresión</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">
                                            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Redes</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">
                                            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Punto de venta</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">
                                            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Otros</span>
                                        </a>
                                    </li> -->
                                </div>
                            </div>

                        </div>
                    </div>



            <?php
                }
            }
            ?>







            <li class="sidebar-header">
                Personas
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="clientes.php">
                    <i class="align-middle" data-feather="heart"></i> <span class="align-middle">Clientes</span>
                </a>
            </li>
<!-- 
            <li class="sidebar-item">
                <a class="sidebar-link" href="maps-google.html">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Usuarios</span>
                </a>
            </li> -->
        </ul>

        <div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2">Sistema en proceso</strong>
                <div class="mb-3 text-sm">
                    Algunas funciones estan en proceso de desarollo.
                </div>
                <!-- <div class="d-grid">
                    <a href="upgrade-to-pro.html" class="btn btn-primary">Upgrade to Pro</a>
                </div> -->
            </div>
        </div>
    </div>
</nav>