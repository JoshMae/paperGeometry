<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Carrito de Compras</h1>

        <!-- Selección de Producto -->
        <div class="mb-4">
            <h3>Seleccionar Producto</h3>
            <form id="selectProductForm">
                <div class="form-group">
                    <label for="productId">ID del Producto:</label>
                    <input type="number" class="form-control" id="productId" name="productId" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Cantidad:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
            </form>
        </div>

        <!-- Mostrar Productos en el Carrito -->
        <div id="cartProducts" class="mb-4">
            <h3>Productos en el Carrito</h3>
            <ul id="cartList" class="list-group"></ul>
        </div>

        <!-- Total del Carrito -->
        <div class="mt-4">
            <h3>Total: $<span id="cartTotal">0.00</span></h3>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        let cont=0;
        let itTotal=0;
        // Obtener el token al cargar la página
        $(document).ready(function() {
            $.ajax({
                url: '/api/carrito/token',
                method: 'POST',
                success: function(response) {
                    if (response.cart_token) {
                        console.log('Token generado:', response.cart_token);
                        localStorage.setItem('cart_token', response.cart_token); // Almacena el token en localStorage
                    } else {
                        alert('Error al generar el token');
                    }
                },
                error: function(response) {
                    alert('Error al generar el token');
                }
            });

            loadCart();
        });

        // Manejar agregar al carrito
        $('#selectProductForm').on('submit', function(e) {
            
            e.preventDefault();

            let productId = $('#productId').val();
            let quantity = $('#quantity').val();
            let cartToken = localStorage.getItem('cart_token'); // Obtén el token de localStorage

            console.log('Token en la solicitud:', cartToken); // Imprime el token en la consola

            $.ajax({
                url: '/api/carrito/agregar',
                method: 'POST',
                data: {
                    idProducto: productId,
                    cantidad: quantity,
                    _token: '{{ csrf_token() }}'
                },
                headers: {
                    'Cart-Token': cartToken
                },
                success: function(response) {
                    if (response.success) {
                        loadCart();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(response) {
                    alert('Error al agregar producto al carrito');
                }
            });
            cont=1;
        });

        // Cargar productos del carrito
        function loadCart() {
            if(cont>0){
            let cartToken = localStorage.getItem('cart_token'); // Obtén el token de localStorage

            console.log('Token Asignado a Carrito:', cartToken);

            $.ajax({
                url: '/api/carrito',
                method: 'GET',
                headers: {
                    'Cart-Token': cartToken
                },
                success: function(response) {
                    console.log('Respuesta de la API:', response);
                    let totalItems=0;
                    if (response.success) {
                        let cartList = $('#cartList');
                        let cartTotal = 0;
                        cartList.empty();

                        response.carrito.forEach(item => {
                            
                            if (item.producto && item.producto.idProducto) {
                                let subtotal = item.producto.precio * item.cantidad;
                                cartTotal += subtotal;
                                totalItems += item.cantidad;
                                itTotal=totalItems;

                                cartList.append(`
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="${item.producto.foto}" class="img-fluid" alt="${item.producto.nombre}">
                                            </div>
                                            <div class="col-md-4">
                                                <h5>${item.producto.nombreP}</h5>
                                                <p>Precio: $${item.producto.precio}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Cantidad: 
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.idCarrito}, ${item.cantidad - 1})">-</button>
                                                    <span>${item.cantidad}</span>
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.idCarrito}, ${item.cantidad + 1})">+</button>
                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <p>Subtotal: $${subtotal.toFixed(2)}</p>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.idCarrito})">Eliminar</button>
                                            </div>
                                        </div>
                                    </li>
                                `);
                            } else {
                                console.warn('Producto no encontrado para el item en el carrito:', item);
                            }
                        });

                        $('#cartTotal').text(cartTotal.toFixed(2));
                    } else {
                        $('#cartList').html('<li class="list-group-item">El carrito está vacío</li>');
                    }
                },
                error: function(response) {
                    alert('Error al cargar el carrito');
                }
            });
            }
        }

        // Manejar la actualización de la cantidad
        function updateQuantity(idCarrito, newQuantity) {
            if (newQuantity < 1) {
                removeFromCart(idCarrito);
                return;
            }

            let cartToken = localStorage.getItem('cart_token'); // Obtén el token de localStorage

            $.ajax({
                url: `/api/carrito/${idCarrito}`,
                method: 'PUT',
                headers: {
                    'Cart-Token': cartToken,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({ cantidad: newQuantity }),
                success: function(response) {
                    if (response.success) {
                        loadCart();
                        } else {
                        alert('No se pudo actualizar la cantidad');
                    }
                },
                error: function(response) {
                    alert('Error al actualizar la cantidad');
                }
            });
        }

        

        // Manejar eliminar del carrito 
function removeFromCart(idCarrito) {
    let cartToken = localStorage.getItem('cart_token'); // Obtén el token de localStorage

    console.log('Token a eliminar: ', cartToken);

    // Solicita la información del carrito para obtener la cantidad actual del producto
    $.ajax({
        url: '/api/carrito', 
        method: 'GET',
        headers: {
            'Cart-Token': cartToken
        },
        success: function(response) {
            if (response.success) {
                // Encuentra el producto que se va a eliminar
                let item = response.carrito.find(item => item.idCarrito === idCarrito);
                
                if (item) {
                    let cantidadAEliminar = item.cantidad;
                    console.log(`Cantidad a eliminar: ${cantidadAEliminar}`);
                    itTotal-=cantidadAEliminar;

                    if(itTotal<1){
                        cont=0;
                    }
                    // Realiza la solicitud para eliminar el producto
                    $.ajax({
                        url: `/api/carrito/eliminar/${idCarrito}`,
                        method: 'DELETE',
                        headers: {
                            'Cart-Token': cartToken
                        },
                        success: function(response) {
                            if (response.success) {
                                loadCart();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(response) {
                            alert('Error al eliminar producto del carrito');
                        }
                    });
                } else {
                    alert('El producto no se encontró en el carrito');
                }
            } else {
                alert('Error al cargar el carrito');
            }
        },
        error: function() {
            alert('Error al cargar el carrito');
        }
    });
}

    </script>
</body>
</html>
