<?php 
    //echo "<tr>";
    echo '<div class="card" style="width: 21%; margin-right: 1%; margin-left: 2.5%;">';
    echo '<img src="../' . $row["hinh"] . '" alt= "' . $row["ten"] . '" style="width: 100%; height: 250px; mix-blend-mode: multiply;">';
    echo '<p class="tensp">' . $row["ten"] . '</p>';
    echo '<p class="price">' .'Giá: '. number_format($row['giaban'], 0, ',', ',') . ' VNĐ/kg</p>';
    echo "<p class='price'>".'Hiện đang còn: '. $row["soluongkg"].   " kg</p>";
    echo '<p class="buttons">';
    echo '<button class="mua-btn" style=" margin-left: 23px; width: 23%;" data-name="' . $row["ten"] . '" data-price="' . $row["giaban"] . '" data-stock="' . $row["soluongkg"] . '">Mua</button>';
    echo '<button class="add-to-cart-btn" id="themgiohang" data-name="' . $row["ten"] . '" data-price="' . $row["giaban"] . '" data-stock="' . $row["soluongkg"] . '">';
    echo '<img src="../hinh/giohang.png" alt="giohang"> Thêm vào giỏ hàng';
    echo '</button>';
    echo '</p>';
    echo '</div>';
    //echo "</tr>";
?>