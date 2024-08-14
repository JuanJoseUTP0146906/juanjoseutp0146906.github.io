<?php

require_once 'controlador/controlador.php'; // Usa require_once para evitar la inclusión múltiple

// Obtiene el número de artículos en el carrito
function obtenerNumeroArticulosEnCarrito() {
    if (isset($_SESSION['carrito'])) {
        return array_sum($_SESSION['carrito']);
    }
    return 0;
}

$vehiculos = obtenerVehiculos();
?>

<?php include 'templates/header2.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #f5f5f5; */
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .vehiculos {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .vehiculo {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 250px;
            text-align: center;
            padding: 15px;
            transition: transform 0.3s ease-in-out;
        }

        .vehiculo:hover {
            transform: translateY(-5px);
        }

        .vehiculo img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .vehiculo h2 {
            font-size: 1.5em;
            color: #333;
            margin: 10px 0;
        }

        .vehiculo p {
            font-size: 1.2em;
            color: #555;
        }

        .btn-add-cart {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-add-cart:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            .vehiculo {
                width: 100%;
                max-width: 100%;
            }
        }

        .carrito {
            margin-top: 40px;
        }

        .carrito ul {
            list-style: none;
            padding: 0;
        }

        .carrito li {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .carrito button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .carrito button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h1>Vehículos Disponibles</h1>
<div class="carrito-icono">
    <a href="carrito.php">
        <i class="fas fa-shopping-cart"></i> <!-- Icono de carrito de compras -->
        <span class="numero-articulos"><?php echo obtenerNumeroArticulosEnCarrito(); ?></span> <!-- Número de artículos -->
    </a>
</div>

<div class="vehiculos">
    <?php foreach ($vehiculos as $vehiculo): ?>
        <div class="vehiculo">
            <img src="assets/img/<?php echo $vehiculo['imagen']; ?>" alt="<?php echo $vehiculo['nombre']; ?>">
            <h2><?php echo $vehiculo['nombre']; ?></h2>
            <p>Precio: $<?php echo number_format($vehiculo['precio'], 2); ?></p>
            <a href="controlador/controlador.php?accion=agregar&id=<?php echo $vehiculo['id']; ?>" class="btn-add-cart">Agregar al carrito <i class="fas fa-shopping-cart"></i></a>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'templates/footer.php'; ?>
</body>
</html>
