<?php
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์
$username = "root"; // ชื่อผู้ใช้
$password = ""; // รหัสผ่าน
$dbname = "bomauto"; // ชื่อฐานข้อมูล

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลจากตาราง cart
$sql = "SELECT * FROM cart WHERE user_id = 1"; // แทนที่ด้วย ID ของผู้ใช้ที่เข้าสู่ระบบ
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BomAuto - ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .cart-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 15px;
            text-align: center;
        }
        .cart-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">สินค้าที่อยู่ในตะกร้า</h1>
        
        <!-- กลุ่มปุ่มที่จัดเรียงในแนวนอน -->
<div class="text-center mb-4">
    <div class="btn-group">
        <!-- ปุ่มกลับหน้าแรก -->
        <a href="product.php" class="btn btn-lg btn-success">กลับหน้าแรก</a>

        <!-- ปุ่มยืนยันการจอง -->
        <form action="confirm_booking.php" method="POST" style="display:inline;">
            <button type="submit" class="btn btn-lg btn-primary">ยืนยันการจอง</button>
        </form>

        <!-- ปุ่มดูประวัติการซื้อ -->
        <a href="purchase_history.php" class="btn btn-lg btn-info">ดูประวัติการซื้อ</a>
    </div>
</div>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // แสดงข้อมูลในตะกร้า
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='cart-item'>";
                    echo "<h5>" . htmlspecialchars($row["name"]) . "</h5>";
                    echo "<img src='" . htmlspecialchars($row["image"]) . "' alt='Product Image' class='img-fluid'>";
                    echo "<p>จำนวน: " . htmlspecialchars($row["quantity"]) . "</p>";
                    // ปุ่มลบสินค้า
                    echo "<form action='remove_from_cart.php' method='POST' style='display:inline;'>";
                    echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row["product_id"]) . "'>";
                    echo "<button type='submit' class='btn btn-danger'>ลบ</button>";
                    echo "</form>";
                    echo "</div></div>";
                }
            } else {
                echo "<p class='text-center'>ไม่มีสินค้าในตะกร้า</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
