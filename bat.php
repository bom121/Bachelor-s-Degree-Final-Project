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

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM bat";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BomAuto - แสดงสินค้าทั้งหมด</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 15px;
            text-align: center;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
        .btn-yellow {
            background-color: yellow;
            color: black;
        }
        .stock-sold {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .back-button {
            position: absolute;
            top: 15px;
            left: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="product.php" class="btn btn-lg btn-success back-button">ย้อนกลับ</a>
        <h1 class="text-center">สินค้าแบตเตอรี่ทั้งหมด</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // แสดงข้อมูลสินค้า
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='product'>";
                    echo "<h5>" . $row["name"] . "</h5>";                   
                    echo "<img src='" . $row["image"] . "' alt='Product Image'>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "<div class='stock-sold'>";
                    echo "<p>Stock: " . $row["stock"] . "</p>";
                    echo "<p>ขายไปแล้ว: " . $row["sold"] . "</p>";
                    echo "</div>";
                    echo "<form action='add_to_cart.php' method='POST'>";
                    echo "<input type='hidden' name='product_id' value='" . $row["id"] . "'>";
                    echo "<input type='hidden' name='name' value='" . $row["name"] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='hidden' name='image' value='" . $row["image"] . "'>";
                    echo "<button type='submit' class='btn btn-sm btn-yellow'>จองเลย</button>";
                    echo "</form>";
                    echo "</div></div>";
                }
            } else {
                echo "<p class='text-center'>ไม่มีสินค้าที่แสดง</p>";
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
