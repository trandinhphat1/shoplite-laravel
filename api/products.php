<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Lấy danh sách sản phẩm hoặc một sản phẩm cụ thể
        try {
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = "SELECT * FROM products WHERE id = :id";
                $stmt = $conn->prepare($query);
                $stmt->execute(['id' => $id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                echo json_encode([
                    "status" => "success",
                    "data" => $product
                ]);
            } else {
                $query = "SELECT * FROM products";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo json_encode([
                    "status" => "success",
                    "data" => $products
                ]);
            }
        } catch(PDOException $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
        break;

    case 'POST':
        // Thêm sản phẩm mới
        try {
            $data = json_decode(file_get_contents("php://input"));
            
            $query = "INSERT INTO products (name, price, description) VALUES (:name, :price, :description)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                'name' => $data->name,
                'price' => $data->price,
                'description' => $data->description
            ]);
            
            echo json_encode([
                "status" => "success",
                "message" => "Sản phẩm đã được thêm thành công"
            ]);
        } catch(PDOException $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
        break;

    case 'PUT':
        // Cập nhật sản phẩm
        try {
            $data = json_decode(file_get_contents("php://input"));
            
            $query = "UPDATE products SET name = :name, price = :price, description = :description WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                'id' => $data->id,
                'name' => $data->name,
                'price' => $data->price,
                'description' => $data->description
            ]);
            
            echo json_encode([
                "status" => "success",
                "message" => "Sản phẩm đã được cập nhật thành công"
            ]);
        } catch(PDOException $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
        break;

    case 'DELETE':
        // Xóa sản phẩm
        try {
            $data = json_decode(file_get_contents("php://input"));
            
            $query = "DELETE FROM products WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $data->id]);
            
            echo json_encode([
                "status" => "success",
                "message" => "Sản phẩm đã được xóa thành công"
            ]);
        } catch(PDOException $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
        break;
}

$conn = null;
?> 