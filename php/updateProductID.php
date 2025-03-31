<?php
    include("config.php");
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $query = "SELECT * FROM food";
    if ($id) {
        $query .= " WHERE id = " . intval($id);
        $result123 = $conn->query($query);
        $row = $result123->fetch_assoc();
        $productName = $row['ten'];
    }
    $query .= " ORDER BY id ASC";
    $result = $conn->query($query);    
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST["update"])) { 
            $id = $_POST["id"];            
            $ten = $_POST["ten"];
            $hinh = $_POST["hinh"];
            $soluongkg = $_POST["soluongkg"];
            $gianhap= $_POST["gianhap"];
            $giaban = $_POST["giaban"];

            $update_query = "UPDATE food SET ten=?, hinh=?, soluongkg=?, gianhap=?, giaban=? WHERE id=?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssssi", $ten, $hinh, $soluongkg, $gianhap, $giaban, $id);    
            if ($stmt->execute()) {
                header("Location: update_product.php?id=" . $id . "&status=success");
                exit();
            } else {
                header("Location: update_product.php?id=" . $id . "&status=error");
                exit();
            }   
        } 
    }
?>
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
    <h1 style="text-align: center; color: #ffc107; font-size: 42px;">
        <?php echo $productName ? "Cập nhật thông tin cho " . htmlspecialchars($productName) : "Cập nhật hàng hóa"; ?>
    </h1>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 30px; text-align: center;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng (kg)</th>
                <th>Vốn nhập</th>
                <th>Giá bán</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    if ($row) {
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    }
                    echo "<td>" . $row['ten'] . "</td>";
                    echo "<td><img src='../" . $row['hinh'] . "' alt='" . $row['ten'] . "' width='60' style='mix-blend-mode: multiply;'></td>";
                    echo "<td>" . $row['soluongkg'] . "</td>";
                    echo "<td>" . number_format($row['gianhap'], 0, ',', ',') . " VNĐ</td>";
                    echo "<td>" . number_format($row['giaban'], 0, ',', ',') . " VNĐ/kg</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Không có sản phẩm nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <h1 style="text-align: center; color: #ffc107; font-size: 42px;">
        Nhập thông tin mới
    </h1>
    <form method="post" id="form" action="updateProductID.php" style="text-align: center;">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 30px; margin-bottom: 20px; text-align: center;">
        <colgroup>
            <col style="width: 6%;">
            <col style="width: 20%;">
            <col style="width: 14%;">
            <col style="width: 19.8%;">
            <col style="width: 20.2%;">
            <col style="width: 20%;">
        </colgroup>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng (kg)</th>
                    <th>Vốn nhập</th>
                    <th>Giá bán</th>
                </tr>
            </thead>
            <tbody>
                <tr> 
                <td><span id="productID"></span></td>
                <td><input type="text" id="ten" name="ten" required style="width: 85%; padding: 10px; font-size: 16px; height: 10px;"></td>
                <td><input type="text" id="hinh" name="hinh" required style="width: 85%; padding: 10px; font-size: 16px; height: 10px;" placeholder="Ví dụ: hinh/h01.jpg"></td>
                <td><input type="text" id="soluongkg" name="soluongkg" required style="width: 85%; padding: 10px; font-size: 16px; height: 10px;" placeholder="... kg"></td>
                <td><input type="text" id="gianhap" name="gianhap" required style="width: 85%; padding: 10px; font-size: 16px; height: 10px;" placeholder="... VNĐ"></td>
                <td><input type="text" id="giaban" name="giaban" required style="width: 85%; padding: 10px; font-size: 16px; height: 10px;" placeholder="... VNĐ/kg"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="submit" name="update" style="padding: 10px 20px; background-color: #ffc107; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 20px;">Update sản phẩm</button>
    </form>
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
                    text: 'Sản phẩm đã được sửa thành công!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'custom-ok-button'
                    }
                });
            }    
        </script>
    <script>
         function getParameterByName(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }
        const productID = getParameterByName('id');
        document.getElementById('productID').innerText = productID ? productID : 'Chưa có ID';
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