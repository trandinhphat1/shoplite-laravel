<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'config.php';

try {
    // Lấy tất cả sản phẩm
    $query = "SELECT * FROM products";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Trả về kết quả dạng JSON
    echo json_encode([
        "status" => "success",
        "data" => $products
    ]);

} catch(PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Lỗi: " . $e->getMessage()
    ]);
}

$conn = null;
?> 