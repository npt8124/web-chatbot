<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update hàng hóa</title>
    <link rel="icon" href="../hinh/logo.png" type="image/png">
</head>
<body style="background-color: honeydew;">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/card.css">
    <link rel="stylesheet" href="../css/menu.css">
    <div class="topnav">
    <a href="index.php">Trang chủ</a>
    <a class="active" href="update.php">Cập nhật hàng hóa</a>
    <a href="list.php">Giỏ hàng</a>
    <a href="gioithieu.php">Giới thiệu</a>
    <form class="searching" action="search.php" method="get" onsubmit="return validateSearchForm();" style="display: flex; align-items: center;">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." style="font-size: 17px; padding: 5px; border-radius: 5px; border: 1px solid #ddd; margin-left: 70px; width: 300px;">
            <button type="submit" style="font-size: 17px; padding: 5px 10px; border-radius: 5px; color: white; cursor: pointer; margin-left: 5px;">Tìm kiếm</button>
    </form>
    <a style="background-color: #333; :hover{color: #4CAF50;}" class="home" href="index.php">Cái Tiệm Trái Cây <img src="../hinh/logo.png" alt="logo"></a>
    </div>
    <div class="action-container">
        <button class="add-button" onclick="handleAction('add')">Thêm sản phẩm</button>
        <button class="delete-button" onclick="handleAction('delete')">Xóa sản phẩm</button>
        <button class="update-button" onclick="handleAction('update')">Sửa sản phẩm</button>
    </div>
    
    <form method="post" id="form" class="xoasp">
    <h1 style="text-align: center; color: #ffc107;">Cập nhật sản phẩm trong kho của Cái Tiệm Trái Cây</h1> 
    <p style="margin-top: 20px;">
        <label for="id">Nhập ID của sản phẩm bạn muốn sửa</label>
        <input type="text" id="id" name="id" placeholder="ID sản phẩm">
        <a href="#" onclick="handleUpdate();" class="button-sua">Sửa</a>
        <a class="button-xoacancel" href="index.php">Cancel</a>
    </p>   
    </form>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 30px; text-align: center;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng (kg)</th>
                <th>Vốn nhập</th>
                <th>Giá bán</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("config.php");
            $query = "SELECT * FROM food ORDER BY id ASC";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['ten'] . "</td>";
                    echo "<td><img src='../" . $row['hinh'] . "' alt='" . $row['ten'] . "' width='60' style='mix-blend-mode: multiply;'></td>";
                    echo "<td>" . $row['soluongkg'] . "</td>";
                    echo "<td>" . number_format($row['gianhap'], 0, ',', ',') . " VNĐ</td>";
                    echo "<td>" . number_format($row['giaban'], 0, ',', ',') . " VNĐ/kg</td>";
                    echo "<td>
                        <button onclick='updateProduct(" . $row['id'] . ")' class='button-sua'>Sửa</button>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Không có sản phẩm nào.</td></tr>";
            }        
            ?>
        </tbody>
    </table>   
    <button id="btnTop" title="Lên đầu trang">↑</button> 
    <script>
        function updateProduct(productId) {
            Swal.fire({
                title: 'Xác nhận sửa',
                text: 'Bạn có chắc chắn muốn sửa sản phẩm này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sửa',
                cancelButtonText: 'Hủy',
                customClass: {
                    confirmButton: 'custom-update-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Chuyển hướng đến URL xử lý sửa sản phẩm với ID cụ thể
                    window.location.href = `updateProductID.php?id=${productId}`;
                }
            });
        }
        function handleUpdate() {
            const productId = document.getElementById('id').value;
            if (!productId.trim()) {
                Swal.fire({
                    title: 'Cảnh báo!',
                    text: 'Vui lòng nhập ID sản phẩm cần sửa.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    customClass: {
                    confirmButton: 'custom-update-button'
                }
                });
                return;
            }
            Swal.fire({
                title: 'Xác nhận',
                text: 'Bạn có chắc chắn muốn sửa sản phẩm này?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Tiếp tục',
                cancelButtonText: 'Hủy',
                customClass: {
                    confirmButton: 'custom-update-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `updateProductID.php?id=${productId}`;
                }
            });
        }

        document.getElementById('form').addEventListener('submit', function(event) {
        event.preventDefault(); 
        const productId = document.getElementById('id').value;
        if (!productId.trim()) {
            Swal.fire({
                title: 'Cảnh báo!',
                text: 'Vui lòng nhập ID sản phẩm cần sửa.',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'custom-update-button'
                }
            });
            return; // Dừng lại nếu ID không hợp lệ
        }        
            Swal.fire({
                title: 'Xác nhận',
                text: 'Bạn có chắc chắn muốn sửa sản phẩm này?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Tiếp tục',
                cancelButtonText: 'Hủy',
                customClass: {
                        confirmButton: 'custom-update-button'
                    }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    }
                });
            });
            
            document.addEventListener('DOMContentLoaded', () => {
                const urlParams = new URLSearchParams(window.location.search);
                const status = urlParams.get('status');    
                if (status === 'success') {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Sản phẩm đã được sửa!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'custom-update-button'
                        }
                    });
                } else if (status === 'error') {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'ID sản phẩm không tồn tại.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'custom-update-button'
                        }
                    });
                } else if (status === 'invalid_id') {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'ID không hợp lệ.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'custom-update-button'
                        }
                    });
                }
            });
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

            function handleAction(action) {
            const messages = {
                'add': 'Bạn muốn thêm sản phẩm mới?',
                'delete': 'Bạn muốn sửa sản phẩm?',
                'update': 'Bạn muốn sửa thông tin sản phẩm?'
            };
            console.log(action);
            Swal.fire({
                title: 'Xác nhận',
                text: messages[action],
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Tiếp tục',            
                cancelButtonText: 'Hủy',
                customClass: {
                        confirmButton: `custom-${action}-button`
                    },
            }).then((result) => {
                if (result.isConfirmed) {
                    if (action === 'add') {
                        window.location.href = 'add_product.php';
                    } else if (action === 'delete') {
                        window.location.href = 'delete_product.php';
                    } else if (action === 'update') {
                        window.location.href = 'update_product.php';
                    }
                }
            });
        } 
    </script>        

    <!-- gửi form của tìm kiếm -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
            return false; // Ngăn gửi form nếu trống
        }
        return true; // Tiếp tục gửi form
    }
    </script>
</body>
</html>