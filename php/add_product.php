<?php 
    if (isset($_POST["add"])) {
        include_once("config.php");
        $cn = new mysqli($servername, $username, $password, $dbname);
        if ($cn->connect_error) {
            die("". $cn->connect_error);
        }
        $result = $cn->query("SELECT MAX(id) AS max_id FROM food");
        $row = $result->fetch_assoc();
        $last_id = $row['max_id']; //id cuối cùng trong database
        if ($last_id === NULL) {
            $id = 1; 
        } else {
            $id = $last_id + 1; 
        }
        $ten = $_POST["ten"];
        $hinh = $_POST["hinh"];
        $soluongkg = $_POST["soluongkg"];
        $gianhap= $_POST["gianhap"];
        $giaban = $_POST["giaban"];
        $cmd = $cn->prepare("insert into food(id, ten, hinh, soluongkg, gianhap, giaban) values (?,?,?,?,?,?)");
        $cmd->bind_param("ssssss", $id, $ten, $hinh, $soluongkg, $gianhap, $giaban);
        //$cmd->execute();        
        if ($cmd->execute() === TRUE) {
            $cn->close();
            header("location:add_product.php?status=success");            
            exit();
        } else {
            $cn->close();
            header("location:add_product.php?status=error");
            exit();
        }   
    }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
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

    <form method="post" id="form" class="themsp">
    <h1 style="text-align: center; color: #4CAF50;">Thêm sản phẩm mới cho Cái Tiệm Trái Cây</h1> 
    <p style="margin-top: 40px;">
        <label for="ten">Tên trái cây</label>
        <input type="text" id="ten" name="ten" required placeholder="">
    </p>
    <p>
        <label for="hinh">Hình ảnh</label>
        <input type="text" id="hinh" name="hinh" required placeholder=" Ví dụ: hinh/h01.jpg">
    </p>
    <p>
        <label for="soluongkg">Số kg nhập về</label>
        <input type="text" id="soluongkg" name="soluongkg" required placeholder=" ... kg">
    </p>
    <p>
        <label for="gianhap">Vốn nhập hàng</label>
        <input type="text" id="gianhap" name="gianhap" required placeholder=" ... VNĐ">
    </p>
    <p>
        <label for="giaban">Giá bán</label>
        <input type="text" id="giaban" name="giaban" required placeholder=" ... VNĐ/kg">
    </p>
    <p class="button">
        <input type="submit" name="add" value="Thêm">
        <a href="index.php"> <input type="button" value="Cancel"></a>
    </p>
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Hàm kiểm tra các giá trị nhập vào
        function validateForm() {
            const ten = document.getElementById("ten").value.trim();
            const hinh = document.getElementById("hinh").value.trim();
            const soluongkg = document.getElementById("soluongkg").value.trim();
            const gianhap = document.getElementById("gianhap").value.trim();
            const giaban = document.getElementById("giaban").value.trim();          
            if (ten === "") {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Tên sản phẩm không được để trống!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return false; 
            }
            if (!hinh.startsWith("hinh/")) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Hình ảnh phải bắt đầu bằng "hinh/tên ảnh"!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return false;
            }            
            if (!Number.isInteger(Number(soluongkg)) || soluongkg <= 0) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Số lượng kg phải là một số nguyên và lớn hơn 0!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return false;
            }
            if (!Number.isInteger(Number(gianhap)) || gianhap <= 0) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Vốn nhập hàng phải là một số nguyên và lớn hơn 0!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return false;
            }
            if (!Number.isInteger(Number(giaban)) || giaban <= 0) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Giá bán phải là một số nguyên và lớn hơn 0!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return false;
            }
            return true; // Nếu không có lỗi, cho phép gửi form
        }
        // Thêm sự kiện submit vào form để gọi hàm validateForm
        document.getElementById("form").addEventListener("submit", function(event) {
            if (!validateForm()) {
                event.preventDefault(); // Ngừng gửi form nếu có lỗi
            }            
        });
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');    
        if (status === 'success') {
            Swal.fire({
                title: 'Thành công!',
                text: 'Sản phẩm đã được thêm thành công!',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'custom-ok-button'
                }
            });
        }     
    </script>

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
        function handleAction(action) {
        const messages = {
            'add': 'Bạn muốn thêm sản phẩm mới?',
            'delete': 'Bạn muốn xóa sản phẩm?',
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