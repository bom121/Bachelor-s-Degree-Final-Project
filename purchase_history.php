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

// แทนที่ด้วย ID ของผู้ใช้ที่เข้าสู่ระบบ
$user_id = 1; // เปลี่ยนเป็นโค้ดที่ดึง ID ของผู้ใช้ที่ล็อกอิน

// ดึงข้อมูลจากตาราง bookings
$sql = "SELECT * FROM bookings WHERE user_id = $user_id"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BomAuto - ประวัติการซื้อ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">ประวัติการซื้อ</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>วันที่</th>
                    <th>จำนวน</th>
                    <th>รูปภาพ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // แสดงข้อมูลการซื้อ
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["booking_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($row["image"]) . "' alt='Product Image' style='width: 100px; height: auto;'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>ไม่มีประวัติการซื้อ</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="text-center mb-4">
            <a href="cart.php" class="btn btn-lg btn-secondary">กลับไปที่ตะกร้า</a>
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
