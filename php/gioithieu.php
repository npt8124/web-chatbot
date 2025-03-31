<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu về Cái Tiệm Trái Cây</title>
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/card.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="icon" href="../hinh/logo.png" type="image/png">
</head>
<body style="background-color: honeydew">
    <div class="topnav">
        <a href="index.php">Trang chủ</a>
        <a href="update.php">Cập nhật hàng hóa</a>
        <a href="list.php">Giỏ hàng</a>
        <a class="active" href="gioithieu.php">Giới thiệu</a>
        <form class="searching" action="search.php" method="get" onsubmit="return validateSearchForm();" style="display: flex; align-items: center;">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." style="font-size: 17px; padding: 5px; border-radius: 5px; border: 1px solid #ddd; margin-left: 70px; width: 300px;">
            <button type="submit" style="font-size: 17px; padding: 5px 10px; border-radius: 5px; color: white; cursor: pointer; margin-left: 5px;">Tìm kiếm</button>
    </form>
        <a class="home" href="index.php">Cái Tiệm Trái Cây <img src="../hinh/logo.png" alt="logo"></a>
    </div>
    <div class="content">
        <div style="text-align: center; margin-top: 10px;">
            <img src="../hinh/gioithieu.jpg" alt="Gioithieu" style="width: 80%; height: auto;">
        </div>   
        <h2>
            Chào mừng bạn đến với cửa hàng trái cây tươi ngon của Cái Tiệm Trái Cây! 
            Tại đây, chúng tôi cung cấp đa dạng các loại trái cây nhập khẩu và nội địa, 
            được chọn lọc kỹ càng từ những nguồn cung uy tín. Mỗi trái cây đều đảm bảo chất lượng tươi mới, 
            an toàn và giàu dinh dưỡng, phù hợp với mọi nhu cầu của khách hàng.
        </h2>
        <h2>
            Tại Cái Tiệm Trái Cây, bạn sẽ được thưởng thức những loại trái cây ngon nhất, 
            được nhập khẩu trực tiếp từ các quốc gia nổi tiếng về chất lượng trái cây như Mỹ, Úc, Thái Lan, và New Zealand. 
            Chúng tôi luôn ưu tiên chọn lựa những sản phẩm tươi ngon, đảm bảo không sử dụng hóa chất hay phụ gia, 
            mang lại sự an toàn tuyệt đối cho khách hàng thân yêu của chúng tôi.
        </h2>
        <img src="../hinh/gioithieu_tiem.jpg" alt="Giới thiệu tiệm" class="center-image">
        <h2>
            Cái Tiệm Trái Cây luôn đặt chất lượng và sức khỏe của khách hàng lên hàng đầu. 
            Vì vậy tất cả sản phẩm tại cửa hàng đều được kiểm tra nghiêm ngặt về nguồn gốc và chất lượng. 
            Chúng tôi cam kết mang đến cho bạn những sản phẩm trái cây tươi ngon nhất, giúp bạn duy trì một chế độ ăn uống lành mạnh và bổ dưỡng.
        </h2>
        <h2>
            Hãy đến và cảm nhận sự khác biệt trong từng miếng trái cây, với chất lượng vượt trội và dịch vụ tận tâm của chúng tôi.
        </h2>
    </div>
    <div class="footer">
        <h3>Cảm ơn vì khách hàng đã luôn tin tưởng và ủng hộ cho Cái Tiệm Trái Cây.</h3>
        <img src="../hinh/logo.png" alt="Logo Cái Tiệm Trái Cây">
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
