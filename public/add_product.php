<?php
require_once '../controllers/ProductController.php';

// Verifica que el formulario se haya enviado con el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos del formulario
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];

    // Crea una instancia del controlador y agrega el producto
    $controller = new ProductController();
    $controller->addProduct($codigo, $nombre, $categoria);

    // Redirige de nuevo a la página principal después de agregar el producto
    header('Location: index.php');
    exit();
} else {
    // Si el método de solicitud no es POST, redirige a la página principal
    header('Location: index.php');
    exit();
}
