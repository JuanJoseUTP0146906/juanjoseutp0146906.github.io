<?php
session_start();
require 'modelo/modelo.php';
include 'templates/header2.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .carrito {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 auto;
            width: 90%;
            max-width: 700px;
        }

        .ticket {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            padding: 20px;
            margin-bottom: 10px;
            position: relative;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .ticket img {
            width: 80px;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }

        .ticket-content {
            flex: 1;
        }

        .ticket-content h2 {
            font-size: 1.2em;
            color: #333;
            margin: 0;
        }

        .ticket-content p {
            font-size: 1em;
            color: #555;
        }

        .ticket-content .eliminar {
            color: #dc3545;
            font-size: 1.2em;
            cursor: pointer;
            border: none;
            background: none;
            float: right;
            margin-left: 10px;
        }

        .ticket-content .precio {
            font-weight: bold;
        }

        .paypal-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .carrito-vacio {
            text-align: center;
            color: #888;
        }
    </style>
    <!-- Solo un script de PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AXmFuqJYbPQ0DRZKaTdVsxQtj5j2bC2DMWpt_wJywqWjPWfa8u4OsZ61Ia_dSZqDKChzg2dJLrrU68Er&currency=MXN"></script>
</head>
<body>
    <h1>Tu Carrito de Compras</h1>

    <div class="carrito">
        <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
            <?php foreach ($_SESSION['carrito'] as $id => $cantidad): ?>
                <?php $vehiculo = obtenerVehiculoPorId($id); ?>
                <div class="ticket">
                    <img src="assets/img/<?php echo $vehiculo['imagen']; ?>" alt="<?php echo $vehiculo['nombre']; ?>">
                    <div class="ticket-content">
                        <h2><?php echo $vehiculo['nombre']; ?></h2>
                        <p class="precio">Precio: $<?php echo number_format($vehiculo['precio'], 2); ?> x <?php echo $cantidad; ?></p>
                        <p class="precio">Total: $<?php echo number_format($vehiculo['precio'] * $cantidad, 2); ?></p>
                        <button class="eliminar" onclick="window.location.href='controlador/controlador.php?accion=eliminar&id=<?php echo $id; ?>'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="ticket">
                <div class="ticket-content">
                    <h2><strong>Total: $<span id="total-carrito"><?php echo number_format(obtenerTotalCarrito(), 2); ?></span></strong></h2>
                </div>
            </div>
            <div class="paypal-buttons">
                <!-- Contenedor para el botón de PayPal -->
                <div id="paypal-button-container"></div>
                <script>
                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            const total = document.getElementById('total-carrito').textContent.replace(/,/g, '');
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: total
                                    }
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                alert('Gracias por su compra, ' + details.payer.name.given_name);
                                window.location.href = 'http://localhost/Producto3DWI/Producto3DWI/index.php?paypal_payment_complete=1';
                            });
                        },
                        onError: function(err) {
                            console.error('Error en la transacción: ', err);
                            alert('Hubo un error al procesar tu pago. Por favor, inténtalo de nuevo.');
                        }
                    }).render('#paypal-button-container');
                </script>
            </div>
        <?php else: ?>
            <div class="carrito-vacio">
                <p>Tu carrito está vacío.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
include 'templates/footer.php';
?>
