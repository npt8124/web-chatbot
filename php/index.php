<?php
    include("config.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productName = $_POST['product_name'];
        $quantity = $_POST['quantity'];
        $sql = "UPDATE food SET soluongkg = soluongkg - ? WHERE ten = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $quantity, $productName);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Cập nhật không thành công.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cái Tiệm Trái Cây xin chào</title>
    <link rel="icon" href="../hinh/logo.png" type="image/png" >
</head>
<body style="background-color: honeydew;">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/card.css">
    <div class="topnav">
    <a class="active" href="index.php">Trang chủ</a>
    <a href="update.php">Cập nhật hàng hóa</a>
    <a href="list.php">Giỏ hàng</a>
    <a href="gioithieu.php">Giới thiệu</a>
    <form class="searching" action="search.php" method="get" onsubmit="return validateSearchForm();" style="display: flex; align-items: center;">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." style="font-size: 17px; padding: 5px; border-radius: 5px; border: 1px solid #ddd; margin-left: 70px; width: 300px;">
            <button type="submit" style="font-size: 17px; padding: 5px 10px; border-radius: 5px; color: white; cursor: pointer; margin-left: 5px;">Tìm kiếm</button>
    </form>
    <a style="background-color: #333; :hover{color: #4CAF50;}" class="home" href="index.php">Cái Tiệm Trái Cây <img src="../hinh/logo.png" alt="logo"></a>
    </div>
    <div><h1 style="text-align: center; color: #4CAF50; font-size: 39px;">Những sản phẩm hiện có của Cái Tiệm Trái Cây</h1></div>
    <table id="customers">
    <div class="flex-container">
    <?php
        include("config.php");
        $sql = "SELECT ten, giaban, hinh, soluongkg FROM food";
        $result = $conn->query($sql);
        $i=1;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($i%4==1){
                    //echo "<tr>";
                    echo '<div class="row">';
                }
                include("display.php");
                if($i%4== 0){
                    //echo "</tr>";
                    echo "</div>";
                }
                $i++;
            }
            if (($i - 1) % 4 != 0) {
                echo "</div>"; 
            }
        } else {
            echo "<p>Không có sản phẩm nào.</p>";
        }
        $conn->close();
    ?>
    </div>
    </table>    
    <!-- Mua -->
    <div id="buyModal" class="modal" style="display: none; font-size: 20px;">
        <div class="modal-content" style="background-color: white; padding: 20px; border-radius: 10px; width: 300px; margin: auto;">
            <span id="closeModal" style="float: right; cursor: pointer; font-size: 20px;">&times;</span>
            <h3 id="modalProductName">Mua sản phẩm</h3>
            <p>Giá: <span id="modalProductPrice">0</span> VNĐ/kg</p>
            <p>Hiện có: <span id="modalProductStock">0</span> kg</p>
            <label for="quantity">Số lượng (kg):</label>
            <input type="number" id="modalQuantity" min="1" value="1" style="width: 22%; padding: 5px; margin: 0px 0; font-size: 20px;">
            <p>Tổng tiền: <span id="modalTotalPrice">0</span> VNĐ</p>
            <button id="confirmPurchase">Xác nhận</button>
            <button id="cancelPurchase">Hủy</button>
        </div>
    </div>
    <!-- Thêm giỏ hàng -->
    <div id="addToCartModal" class="modal" style="display: none; font-size: 20px;">
        <div class="modal-content" style="background-color: white; padding: 20px; border-radius: 10px; width: 300px; margin: auto;">
            <span id="closeCartModal" style="float: right; cursor: pointer; font-size: 20px;">&times;</span>
            <h3 id="cartProductName">Thêm sản phẩm vào giỏ hàng</h3>
            <p>Giá: <span id="cartProductPrice">0</span> VNĐ/kg</p>
            <p>Hiện có: <span id="cartProductStock">0</span> kg</p>
            <label for="cartQuantity">Số lượng (kg):</label>
            <input type="number" id="cartQuantity" min="1" value="1" style="width: 22%; padding: 5px; margin: 0px 0; font-size: 20px;">
            <p>Tổng tiền: <span id="totalPrice">0</span> VNĐ</p>
            <button id="confirmAddToCart">Xác nhận</button>
            <button id="cancelAddToCart">Hủy</button>
        </div>
    </div>

    <button id="btnTop" title="Lên đầu trang">↑</button>
    <!-- gửi form của tìm kiếm -->
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
                behavior: "smooth" // Cuộn mượt
            });
        });
        //của nút Mua
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("buyModal");
            const closeModal = document.getElementById("closeModal");
            const cancelPurchase = document.getElementById("cancelPurchase");
            const confirmPurchase = document.getElementById("confirmPurchase");
            const quantityInput = document.getElementById("modalQuantity");
            const totalPriceElement = document.getElementById("modalTotalPrice");
            const modalProductName = document.getElementById("modalProductName");
            const modalProductPrice = document.getElementById("modalProductPrice");
            const modalProductStock = document.getElementById("modalProductStock");        
            let currentPrice = 0;
            let currentStock = 0;
            
            document.querySelectorAll(".mua-btn").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const productName = btn.dataset.name;
                    currentPrice = parseInt(btn.dataset.price, 10);
                    currentStock = parseInt(btn.dataset.stock, 10);
                    if (currentStock <= 0) {
                        Swal.fire({
                            title: 'Hết hàng',
                            text: `Sản phẩm "${productName}" hiện không còn hàng để mua.`,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: {
                                    confirmButton: 'custom-ok-button' 
                                }
                        });
                        return;
                    }
                    modalProductName.textContent = `Mua ${productName}`;
                    modalProductPrice.textContent = currentPrice.toLocaleString();
                    modalProductStock.textContent = currentStock.toLocaleString();
                    totalPriceElement.textContent = currentPrice.toLocaleString();
                    quantityInput.value = 1;
                    modal.style.display = "flex";
                });
            });
            quantityInput.addEventListener("input", () => {
                const quantity = parseInt(quantityInput.value, 10) || 1;
                if (quantity > currentStock) {                
                    Swal.fire({
                        title: 'Có lỗi',
                        text: 'Số lượng bạn vừa nhập vượt quá hàng trong kho',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'custom-ok-button' 
                        }
                    });
                    quantityInput.value = currentStock;
                    return;
                }
                const totalPrice = currentPrice * quantity;
                totalPriceElement.textContent = totalPrice.toLocaleString();
            });
            closeModal.addEventListener("click", () => {
                modal.style.display = "none";
            });
            cancelPurchase.addEventListener("click", () => {
                modal.style.display = "none";
            });
            confirmPurchase.addEventListener("click", () => {
                const quantity = parseInt(quantityInput.value, 10) || 1;
                const totalPrice = currentPrice * quantity;
                const productName = modalProductName.textContent.replace('Mua ', '');
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "update_quantity.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            Swal.fire({
                                title: 'Mua hàng thành công!',
                                html: `Bạn đã mua <b>${quantity} kg</b> <b>${productName}</b> với tổng số tiền <b>${totalPrice.toLocaleString()} VNĐ</b>.`,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'custom-ok-button' 
                                }
                            }).then(() => {
                                    window.location.href = "index.php";
                                });
                                modal.style.display = "none";                                                      
                        } else {
                            Swal.fire({
                                title: 'Lỗi',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    }
                };
                xhr.send("product_name=" + encodeURIComponent(productName) + "&quantity=" + encodeURIComponent(quantity));
            });
        });
    //của nút Thêm giỏ hàng
    document.addEventListener("DOMContentLoaded", () => {
    // Modal cho giỏ hàng
    const cartModal = document.getElementById("addToCartModal");
    const closeCartModal = document.getElementById("closeCartModal");
    const cancelAddToCart = document.getElementById("cancelAddToCart");
    const confirmAddToCart = document.getElementById("confirmAddToCart");
    const cartQuantityInput = document.getElementById("cartQuantity");
    const cartProductName = document.getElementById("cartProductName");
    const cartProductPrice = document.getElementById("cartProductPrice");
    const cartProductStock = document.getElementById("cartProductStock");
    let currentCartPrice = 0;
    let currentCartStock = 0;
    
    document.querySelectorAll(".add-to-cart-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const productName = btn.dataset.name;
            currentCartPrice = parseInt(btn.dataset.price, 10);
            currentCartStock = parseInt(btn.dataset.stock, 10);
            if (currentCartStock <= 0) {
                Swal.fire({
                    title: 'Hết hàng',
                    text: `Sản phẩm "${productName}" hiện không còn hàng để thêm vào giỏ.`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'custom-ok-button' 
                    }
                });
                return;
            }
            cartProductName.textContent = `Thêm ${productName} vào giỏ hàng`;
            cartProductPrice.textContent = currentCartPrice.toLocaleString();
            cartProductStock.textContent = currentCartStock.toLocaleString();
            document.getElementById("totalPrice").textContent = currentCartPrice.toLocaleString();
            cartQuantityInput.value = 1;
            cartModal.style.display = "flex";
        });
    });    
    cartQuantityInput.addEventListener("input", () => {
        const quantity = parseInt(cartQuantityInput.value, 10) || 1;
        if (quantity > currentCartStock) {
            Swal.fire({
                title: 'Lỗi',
                text: 'Số lượng bạn nhập vượt quá hàng trong kho',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'custom-ok-button' 
                }
            });
            cartQuantityInput.value = currentCartStock;
            return;
        }
        const totalPrice = currentCartPrice * cartquantity;
        document.getElementById("totalPrice").textContent = totalPrice.toLocaleString();
    });
    
    closeCartModal.addEventListener("click", () => {
        cartModal.style.display = "none";
    });
    cancelAddToCart.addEventListener("click", () => {
        cartModal.style.display = "none";
    });
    
    confirmAddToCart.addEventListener("click", () => {
        const quantity = parseInt(cartQuantityInput.value, 10) || 1;
        const productName = cartProductName.textContent.replace('Thêm ', '').replace(' vào giỏ hàng', '');
        const totalPrice = currentCartPrice * quantity;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "add_to_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);                
                if (response.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                        confirmButton: 'custom-ok-button' 
                    }
                    }).then(() => {
                        window.location.href = "index.php";
                    });
                    modal.style.display = "none";   
            } else {
                Swal.fire({
                    title: 'Lỗi',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }
        }
    };
        xhr.send("product_name=" + encodeURIComponent(productName) + "&quantity=" + encodeURIComponent(quantity) + "&price=" + encodeURIComponent(totalPrice));
    });
});

    </script>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger
    intent="WELCOME"
    chat-title="Cái Tiệm Trái Cây"
    agent-id="ebc34907-e116-488e-8598-9b6aaaca511d"
    language-code="vi">
    </df-messenger>

</body>
</html>
<hr>
<div class="info" style="background-color: honeydew; width:100%; height: 300px; font-family: 'Times New Roman', Times, serif">
<div style="width: 53%; margin-left: 60px; margin-top: 10px; font-size: 23px;">
    <p style="color: rgba(17, 10, 112, 0.837); font-size: 25px;"><b>THÔNG TIN</b><br> </p>
    <p style="color: rgba(17, 10, 112, 0.837);">TRƯỜNG ĐẠI HỌC VĂN LANG <br></p>     
    <p style="color: rgba(17, 10, 112, 0.837);">69/68 Đ. Đặng Thuỳ Trâm, Phường 13, Bình Thạnh, Hồ Chí Minh 70000 <br></p>    
    <p style="color: rgba(17, 10, 112, 0.837);">(028)7105 9999</p>        <br>
    <p><img src="../hinh/facebook.png" alt=""> <img src="../hinh/g.png" alt=""> <img src="../hinh/telegram.jpg" alt=""></p>   
</div>
<div style="width: 40%; margin-left: 300px; margin-top: 10px; font-size: 23px;">
    <p style="color: rgba(17, 10, 112, 0.837); font-size: 25px;"><b>LIÊN HỆ</b><br> </p>
    <p style="color: rgba(17, 10, 112, 0.837);">Email: nguyenthanh081204@gmail.com <br> hoặc <br>caitiemtraicay@gmail.com
    <p><img src="../hinh/logo.png" alt="logo" style="width: 300px; height: 300px;"></p>
</div>