<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập hàng cho Tiệm</title>
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
    <h1 style="text-align: center; color: #4CAF50; margin-top: 100px;">Hãy chọn hình thức cập nhật bạn muốn cho Cái Tiệm Trái Cây</h1>
    <script>
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
</body>
</html>