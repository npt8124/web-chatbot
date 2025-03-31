<?php
include("config.php");
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $_GET['search']; 
    $sql = "SELECT ten, giaban, hinh, soluongkg FROM food WHERE ten LIKE '%$searchTerm%'";
    $result = $conn->query($sql);
}else {
    $searchTerm = '';
    $result = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="icon" href="../hinh/logo.png" type="image/png">
</head>
<body style="background-color: honeydew;">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/card.css">
    <link rel="stylesheet" href="../css/menu.css">
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

    <div><h1 style="text-align: center;">Kết quả tìm kiếm cho: <?php echo htmlspecialchars($searchTerm); ?></h1></div>    
    <div class="flex-container">
        <?php
        if ($result && $result->num_rows > 0) {
            // while ($row = $result->fetch_assoc()) {
            //     // echo '<div class="card" style="width: 21%; margin-right: 1%; margin-left: 2.5%;">';
            //     // echo '<img src="../' . $row["hinh"] . '" alt="' . $row["ten"] . '" style="width: 100%; height: 250px;">';
            //     // echo '<p class="tensp">' . $row["ten"] . '</p>';
            //     // echo '<p class="price">' .'Giá: '. number_format($row['giaban'], 0, ',', ',') . ' VNĐ/kg</p>';
            //     // echo "<p class='price'>".'Hiện đang còn: '. $row["soluongkg"]. " kg</p>";
            //     // echo "<p><button>Mua</button></p><p><button>Thêm vào giỏ hàng</button></p>";
            //     // echo '</div>';
            //     include('display.php');
            // }
            $i=1;
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
            echo "<h2 style='text-align: center;'>Không tìm thấy sản phẩm nào!</h2>";
        }
        $conn->close();
        ?>
    </div>
    <button id="btnTop" title="Lên đầu trang">↑</button>
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
