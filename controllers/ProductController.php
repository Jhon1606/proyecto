<?php
class ProductController
{
    private $apiUrl = 'http://localhost/proyecto/api/productos.php';

    public function getProducts()
    {
        $response = file_get_contents($this->apiUrl);
        return json_decode($response, true);
    }

    public function addProduct($codigo, $nombre, $categoria)
    {
        $data = json_encode(['codigo' => $codigo, 'nombre' => $nombre, 'categoria' => $categoria]);
        $this->sendRequest('POST', $data);
    }

    public function updateProduct($id, $codigo, $nombre, $categoria)
    {
        $data = json_encode(['id' => $id, 'codigo' => $codigo, 'nombre' => $nombre, 'categoria' => $categoria]);
        $this->sendRequest('PUT', $data);
    }

    public function deleteProduct($id)
    {
        $data = json_encode(['id' => $id]);
        $this->sendRequest('DELETE', $data);
    }

    private function sendRequest($method, $data)
    {
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
