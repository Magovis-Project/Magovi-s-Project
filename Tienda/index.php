<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyDrops</title>
    <!-- Bootstrap CSS para la versión 4.5.3 -->
    <link href="../Tienda/Estilos/css/bootstrap.css" rel="stylesheet">
    <link href="../Tienda/Estilos/css/" rel="stylesheet">
    
    <link href="../Tienda/Estilos/inicio.css" rel="stylesheet">
</head>
<body>
    <header class=" d-flex flex-column flex-md-row align-items-center justify-content-between">
        <section class="container">
            <div class="row">
                <article style="margin-right:10px;" class="d-flex align-items-center col-3">
                    <img src="../Tienda/assets/logo.png" id="logo" alt="MyDropsLogo" class="mr-1" style="height: 100px; width: 100px;">
                    <span class="font-weight-bold" id="MyDrops">MyDrops</span>
                </article>
    
                <div class="d-flex align-items-center col-4">
                    <input type="text" placeholder="Buscar productos, marcas" id="barraBusqueda" class="form-control mr-2" >
                    <button class="btnBuscar"><img src="../Tienda/assets/lupa.png" alt="lupa" style="width: 30px; height: 30px; filter:brightness(200);"></button>
                </div>
    
                <article id="accionesUsuario" class="d-flex align-items-center">
                    <a href="../Tienda/Vistas/registros/division.html" class="mr-2 btn btn-custom">
                        Crea tu cuenta
                    </a>
                    <a href="../Tienda/Vistas/inicios/divisionIni.html" id="btnInicio" class="btn btn-custom mr-2">Ingresa</a>
                    <button class="btn btn-custom mr-2">Mis compras</button>
                    <a href="../Tienda/Vistas/carrito.html">
                        <img src="../Tienda/assets/carrito.png" alt="Carrito" id="imagenCarrito" style="height: auto; max-width: 100%;">
                    </a>
                </article>
            </div>
        </section>
    </header>
    
        <nav id="bajoHeader" class="col-12">
            <div class="container" style="display: flex;">
                <div style="flex: 1;">
                <div class="dropdown">
                    <p class="nav-link-custom drop">Categorias</p>
                    <div class="dropdown-content">
                      <a href="#">Accesorios</a>
                      <a href="#">Calzado</a>
                      <a href="#">Moda</a>
                      <a href="#">Ver todas</a>
                    </div>
                  </div>
                <a class="nav-link-custom" href="#">Ofertas</a>
                <a class="nav-link-custom" href="../Tienda/Vistas/inicios/inicioUsu.html">Historial</a>
            </div>
            <div>
                <a class="nav-link-custom" href="../Tienda/Vistas/ayuda.html">Ayuda</a>
            </div>
        </div>
        </nav>


        <main class="py-4">
            <section class="seccion-principal mb-4">
                <p class="tituloGeneral" style="font-weight: bold;" >Las mejores Ofertas del invierno</p>
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="seccion-Ofertas d-flex align-items-center mt-4">
                                <div>
                                    <p class="titOferta" class="h5 font-weight-bold">Ahorros únicos en productos de Electrónica</p>
                                    <p class="textOferta" class="h5 font-weight-bold">Hasta 40% de descuento</p>
                                </div>
                                <img src="../Tienda/assets/oferta_electronica.png" alt="Ofertas en Electrónica" class="img-fluid imagenOferta"  >
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="seccion-Ofertas d-flex align-items-center mt-4">
                                <div>
                                    <p class="titOferta" class="h5 font-weight-bold">Sorprende a papá con un celular nuevo</p>
                                    <p class="textOferta" class="h5 font-weight-bold">Hasta 60% de descuento</p>
                                </div>
                                <img src="../Tienda/assets/celulares.png" alt="Ofertas en Celulares" class="img-fluid imagenOferta"  >
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="seccion-Ofertas d-flex align-items-center mt-4">
                                <div>
                                    <p class="titOferta" class="h5 font-weight-bold">Calienta el ambiente con estos descuentos</p>
                                    <p class="textOferta" class="h5 font-weight-bold">Hasta 35% de descuento y 12 cuotas</p>
                                </div>
                                <img src="../Tienda/assets/estufa.png" alt="Ofertas en Estufas" class="img-fluid imagenOferta"  >
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <p class="mt-4 text-custom-foreground" style="color: white;">Ofertas todos los días, hasta 70% de descuento en productos seleccionados</p>
            </section>
            
                <section class="seccion-Info" style="margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-3 mb-3" id="divDistinto">
                            <img src="../Tienda/assets/logo.png" alt="logo" class="imgInfo mr-2">
                            <p>Qué es MyDrops. Fácil de comprar y pedir</p>
                        </div>
                        <div class="col-3 mb-3 lineaVert">
                            <img src="../Tienda/assets/camioncito.png" alt="camion" class="imgInfo mr-2">
                            <p>Información de tus envíos. Déjanos todo a nosotros.</p>
                        </div>
                        <div class="col-3 mb-3 lineaVert">
                            <img src="../Tienda/assets/tarjetas.jpg" alt="tarjetas" class="imgInfo mr-2">
                            <p>Paga con crédito o débito. <br>Conoce los beneficios</p>
                        </div>
                        <div class="col-3 mb-3 lineaVert">
                            <img src="../Tienda/assets/usuarioPre.jpg" alt="UsuarioPremium" class="imgInfo mr-2">
                            <p>Sé un usuario premium de MyDrops</p>
                        </div>
                    </div>
                </section> 

                    <div class="seccion-Tendencias">
                        <div style="background-color: #5c6f8f; border-radius: 10px;">
                        <p id="tituloTendencias">Tendencias</p>
                        </div>
                        <div style="background-color: #5c6f8f; border-radius: 10px;height: 320px;width: 100%;padding: 20px;">
                        <div class="horizontal-scroll">
                            <div class="horizontal-scroll-item">
                                <img src="../Tienda/assets/cartera.jpg" alt="Carteras" class="imagenesTendencias">
                            <p>Bolsos de mano</p>
                            </div>
                            <div class="horizontal-scroll-item">
                                <img src="../Tienda/assets/juguete.jpg" alt="Juguetes" class="imagenesTendencias">
                                <p>Juguetes</p>
                            </div>
                            <div class="horizontal-scroll-item">
                                <img src="../Tienda/assets/perfume.jpeg" alt="Perfume" class="imagenesTendencias">
                                <p>Perfumes</p>
                            </div>
                            <div class="horizontal-scroll-item">
                                <img src="../Tienda/assets/zapatos.jpeg" alt="Zapatos" class="imagenesTendencias">
                                <p>Calzado</p>
                            </div>
                            <div class="horizontal-scroll-item">
                                <img src="../Tienda/assets/piezas.jpg" alt="Piezas" class="imagenesTendencias">
                            <p>Piezas y recambios</p>
                            </div>
                            <div class="horizontal-scroll-item">

                            </div>
                            <div class="horizontal-scroll-item">

                            </div>
                            <div class="horizontal-scroll-item">

                            </div>
                            <div class="horizontal-scroll-item">
                            </div>
                            </div>
                        </div>
                    </div>
                
                    
                <section class="seccion-Bloques col-12">
                    <div class="bloqBlanco col-6">
                        <div>
                            <h5>Explora las novedadas</h5>
                            <br>
                            <h4>Nuevos productos en MyDrops</h4>
                            <br>
                            <button class="btn-custom" style="justify-content: end;">Ver mas</button>
                        </div>
                        <div>
                            <img src="../Tienda/assets/producto2.jpg" alt="Maquillaje" style="height: 250px;width: 350px;">
                        </div>
                    </div>
                    <div class="bloqBlanco col-6">
                        <div>
                            <h5>Descubre precios inigualables al alcance de la mano</h5>
                            <br>
                            <h4>Conoce empresas a tu alrededor</h4>
                            <br>
                            <button class="btn-custom" style="justify-content: end;">Ver mas</button>
                        </div>
                        <div>
                            <img src="../Tienda/assets/imagen_producto.jpg" alt="Productos Ofertas" style="height: 250px;width: 300px;">
                        </div>
                    </div>

                </section>

                    <div class="seccion-Anuncios">
                        <div class="horizontal-scroll">
                            <div class="horizontal-scroll-anuncios">
                                <article class="anunciosCard">
                                    <p>Esenciales para las vacaciones</p>
                                    <img src="../Tienda/assets/equipamiento.jpg" alt="Veraniego" class="imagenesAnuncios">
                                </article>
                            </div>
                            <div class="horizontal-scroll-anuncios">
                                <article class="anunciosCard">
                                    <p>Hora de decorar ese living</p>
                                    <img src="../Tienda/assets/muebles.jpg" alt="Muebles" class="imagenesAnuncios">
                                </article>
                            </div>
                            <div class="horizontal-scroll-anuncios">
                                <article class="anunciosCard">
                                    <p>Ideas para tu cocina</p>
                                    <img src="../Tienda/assets/cocina.jpg" alt="Cocinas" class="imagenesAnuncios">
                                </article>
                            </div>
                            <div class="horizontal-scroll-anuncios">
                                <article class="anunciosCard">
                                    <p>Ponte en forma en casa</p>
                                    <img src="../Tienda/assets/yoga.jpeg" alt="Deportivos" class="imagenesAnuncios">
                                </article>
                            </div>
                        </div>
                    </div>

                <section id="seccion-Categorias" class="col-8">
                    <button class="btn col-2"><img src="../Tienda/assets/muebles.jpg" alt="Muebles" style="width: 50px; height: auto">Muebles</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 2</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 3</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 4</button>
                <br>
                    <button class="btn col-2"><img src="#" alt="vacio" >Categoria 5</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 6</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 7</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 8</button>
                <br>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 9</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 10</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 11</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 12</button>
                <br>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 13</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 14</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 15</button>
                    <button class="btn col-2"><img src="#" alt="vacio">Categoria 16</button>
                </section>
        </main>
    <footer class="col-12 text-center p-3 m-0">
        <div style="gap: 25px; margin-top: 15px;" class="row justify-content-center">
            <section class="col-md-3 col-sm-12 mb-3">
                <h3>Redes Sociales</h3>
                <br>
                <div class="d-flex align-items-center mb-2">
                    <img src="../Tienda/assets/x.png" style="height: 25px; width: 25px;" alt="X">
                    <p class="mb-0 ml-2">X.</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <img src="../Tienda/assets/ig.png" style="height: 25px; width: 25px;" alt="Instagram">
                    <p class="mb-0 ml-2">Instagram.</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <img src="../Tienda/assets/facebook.png" style="height: 25px; width: 25px;" alt="Facebook">
                    <p class="mb-0 ml-2">Facebook.</p>
                </div>
            </section>
    
            <section class="col-md-3 col-sm-12 mb-3">
                <h3>Todo en un solo lugar</h3>
                <br>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-2">
                        Envío Asegurado
                        <img src="https://openui.fly.dev/openui/24x24.svg?text=✔" alt="checkmark" class="ml-2" aria-hidden="true">
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        Garantía de Entrega
                        <img src="https://openui.fly.dev/openui/24x24.svg?text=✔" alt="checkmark" class="ml-2" aria-hidden="true">
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        Productos Originales
                        <img src="https://openui.fly.dev/openui/24x24.svg?text=✔" alt="checkmark" class="ml-2" aria-hidden="true">
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        El mejor Precio
                        <img src="https://openui.fly.dev/openui/24x24.svg?text=✔" alt="checkmark" class="ml-2" aria-hidden="true">
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        Compra fácil, rápido y seguro
                        <img src="https://openui.fly.dev/openui/24x24.svg?text=✔" alt="checkmark" class="ml-2" aria-hidden="true">
                    </li>
                </ul>
            </section>
    
            <section class="col-md-3 col-sm-12 mb-3">
                <h3>Contacto:</h3>
                <br>
                <div class="d-flex align-items-center mb-2">
                    <img src="https://openui.fly.dev/openui/24x24.svg?text=📞" alt="phone" class="mr-2" aria-hidden="true">
                    <span>Atención telefónica: (+598) 91 923 568</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <img src="https://openui.fly.dev/openui/24x24.svg?text=⏰" alt="clock" class="mr-2" aria-hidden="true">
                    <span>De Lunes a Sábados en el horario de 09:00hs a 18:00hs y Domingos de 10:00hs a 16:00hs</span>
                </div>
            </section>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../Tienda/js/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="../Tienda/js/jsboot/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="../Tienda/js/inicio.js"></script>
</body>
</html>