<?php
    session_start();
    require_once 'config.php';  
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Kiểm tra nếu có yêu cầu xóa sản phẩm
    if (isset($_GET['remove_name']) && isset($_GET['quantity'])) {
        $productName = $_GET['remove_name'];  // Tên sản phẩm cần xóa
        $quantity = $_GET['quantity']; // Số lượng sản phẩm cần thêm lại vào kho

        // Cập nhật số lượng lại trong bảng sản phẩm
        $updateQuery = "UPDATE food SET soluongkg = soluongkg + ? WHERE ten = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("is", $quantity, $productName);
        $stmt->execute();

        // Xóa sản phẩm khỏi giỏ hàng
        $deleteQuery = "DELETE FROM giohang WHERE product_name = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("s", $productName);
        $stmt->execute();

        // Redirect lại trang giỏ hàng sau khi xóa
        header("Location: list.php");
        exit;
    }

    // Truy vấn dữ liệu giỏ hàng
    $query = "SELECT * FROM giohang";
    $result = $conn->query($query);

    // Kiểm tra nếu có dữ liệu trả về
    if ($result) {
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $cartItems = [];
    }

    $totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <link rel="icon" href="../hinh/logo.png" type="image/png">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/card.css">
    <link rel="stylesheet" href="../css/menu.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            font-size: 18px;
        }
        .show {
            display: block;
        }
        .remove-btn {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color: honeydew;">
    <div class="topnav">
        <a href="index.php">Trang chủ</a>
        <a href="update.php">Cập nhật hàng hóa</a>
        <a class="active" href="list.php">Giỏ hàng</a>
        <a href="gioithieu.php">Giới thiệu</a>
        <form class="searching" action="search.php" method="get" onsubmit="return validateSearchForm();" style="display: flex; align-items: center;">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." style="font-size: 17px; padding: 5px; border-radius: 5px; border: 1px solid #ddd; margin-left: 70px; width: 300px;">
            <button type="submit" style="font-size: 17px; padding: 5px 10px; border-radius: 5px; color: white; cursor: pointer; margin-left: 5px;">Tìm kiếm</button>
        </form>
        <a style="background-color: #333;" class="home" href="index.php">Cái Tiệm Trái Cây <img src="../hinh/logo.png" alt="logo"></a>
    </div>

    <h1 style="text-align: center; margin-top: 40px; margin-bottom: 30px; color: #4CAF50;">Những sản phẩm trong giỏ hàng của bạn</h1>
    <?php
    if ($cartItems && count($cartItems) > 0) {
        echo "<table>";
        echo "<tr>
        <th>Tên sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá (VNĐ/kg)</th>
        <th>Tổng tiền</th>
        <th>Hành động</th>
        </tr>";

        foreach ($cartItems as $item) {
           // $totalPrice += $item['price']; // Cộng dồn giá vào tổng
           // $itemTotalPrice = $item['quantity'] * $item['price']; // Tính tổng tiền cho mỗi sản phẩm
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['product_name']) . "</td>";
            echo "<td>" . $item['quantity'] . "</td>";
            echo "<td>" . number_format($item['price']/$item['quantity'], 0) . " VNĐ</td>";
            echo "<td>" . number_format($item['price'], 0) . " VNĐ</td>";

            // Thêm cột "Xóa"
           echo "<td><a class='button-xoa' style='text-decoration: none;' href='?remove_name=" . urlencode($item['product_name']) . "&quantity=" . $item['quantity'] . "' class='remove-btn'>Xóa</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Giỏ hàng của bạn chưa có sản phẩm nào</h1>" ;
    }    
    ?>
    <?php 
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'];}
    ?>
    <div id="totalPrice" class="total" style="margin-top:20px; margin-left: 50px;">
        Tổng tiền: <?= number_format($totalPrice, 0) ?> VNĐ
    </div>
            
    <button id="btnTop" title="Lên đầu trang">↑</button>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const btnTop = document.getElementById("btnTop");
        window.onscroll = function () {
            if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
                btnTop.classList.add("show");
            } else {
                btnTop.classList.remove("show");
            }
        };

        btnTop.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth" 
            });
        });

        function validateSearchForm() {
            const searchInput = document.querySelector('input[name="search"]');
            if (!searchInput.value.trim()) {
                Swal.fire({
                    title: 'Cái Tiệm Trái Cây cho biết',
                    text: 'Bạn cần nhập tên trái cây để tìm kiếm!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'custom-ok-button'
                    }
                });
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
