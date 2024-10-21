<?php
require_once '../config/database.php';

header("Content-Type: application/json");

$database = new Database();
$conn = $database->getConnection();

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'GET':
        getAllProducts($conn);
        break;
    case 'POST':
        addProduct($conn);
        break;
    case 'PUT':
        updateProduct($conn);
        break;
    case 'DELETE':
        deleteProduct($conn);
        break;
    default:
        echo json_encode(['message' => 'Método no permitido']);
        break;
}

function getAllProducts($conn)
{
    $query = "SELECT * FROM productos";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
}

function addProduct($conn)
{
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "INSERT INTO productos (codigo, nombre, categoria) VALUES (:codigo, :nombre, :categoria)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo', $data['codigo']);
    $stmt->bindParam(':nombre', $data['nombre']);
    $stmt->bindParam(':categoria', $data['categoria']);
    $stmt->execute();
    echo json_encode(['message' => 'Producto añadido exitosamente']);
}

function updateProduct($conn)
{
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "UPDATE productos SET codigo = :codigo, nombre = :nombre, categoria = :categoria WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $data['id']);
    $stmt->bindParam(':codigo', $data['codigo']);
    $stmt->bindParam(':nombre', $data['nombre']);
    $stmt->bindParam(':categoria', $data['categoria']);
    $stmt->execute();
    echo json_encode(['message' => 'Producto actualizado exitosamente']);
}

function deleteProduct($conn)
{
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "DELETE FROM productos WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $data['id']);
    $stmt->execute();
    echo json_encode(['message' => 'Producto eliminado exitosamente']);
}
