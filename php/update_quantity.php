<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    
    // Kiểm tra xem số lượng có hợp lệ không
    if ($quantity > 0) {
        // Cập nhật số lượng trong kho
        $sql = "UPDATE food SET soluongkg = soluongkg - ? WHERE ten = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $quantity, $productName);
        
        if ($stmt->execute()) {
            // Thành công, trả về phản hồi cho AJAX
            echo json_encode(["success" => true, "message" => "Cập nhật kho thành công."]);
        } else {
            // Lỗi khi cập nhật
            echo json_encode(["success" => false, "message" => "Không thể cập nhật số lượng trong kho."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Số lượng không hợp lệ."]);
    }
}
?>
