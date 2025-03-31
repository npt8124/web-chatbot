<?php
    header('Content-Type: application/json');
    include("config.php");

    try {
        $productName = $_POST['product_name'];
        $quantity = intval($_POST['quantity']);
        $price = intval($_POST['price']); // Giá sản phẩm

        // Kiểm tra số lượng tồn kho
        $checkStockQuery = "SELECT soluongkg FROM food WHERE ten = ?";
        $stock_stmt = $conn->prepare($checkStockQuery);
        $stock_stmt->bind_param("s", $productName);
        $stock_stmt->execute();
        $stock_result = $stock_stmt->get_result();
        $stock = $stock_result->fetch_assoc();

        if (!$stock || $stock['soluongkg'] < $quantity) {
            // Không đủ số lượng trong kho
            echo json_encode(['success' => false, 'message' => 'Không đủ số lượng trong kho.']);
            exit;
        }

        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
        $checkQuery = "SELECT * FROM giohang WHERE product_name = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Sản phẩm đã tồn tại -> cập nhật số lượng và giá
            $updateQuery = "UPDATE giohang SET quantity = quantity + ?, price = price + ? WHERE product_name = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("iis", $quantity, $price, $productName);
            $stmt->execute();
        } else {
            // Sản phẩm chưa tồn tại -> thêm mới
            $insertQuery = "INSERT INTO giohang (product_name, quantity, price) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sii", $productName, $quantity, $price);
            $stmt->execute();
        }

        // Cập nhật số lượng sản phẩm trong kho
        $update_sql = "UPDATE food SET soluongkg = soluongkg - ? WHERE ten = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("is", $quantity, $productName);
        $update_stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
?>
