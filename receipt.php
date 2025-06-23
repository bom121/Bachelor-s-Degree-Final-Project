<?php
session_start(); // เริ่มต้น session

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
$username = $_SESSION['username']; // ดึงชื่อผู้ใช้จาก session

// ตรวจสอบว่ามีข้อมูลการจองใน session หรือไม่
if (!isset($_SESSION['bookings'])) {
    header("Location: cart.php"); // ถ้าไม่มีข้อมูลให้กลับไปที่ตะกร้า
    exit();
}

// ข้อมูลการจองจาก session
$bookings = $_SESSION['bookings'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จการจอง</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">ใบเสร็จการจอง</h1>
        
        <h3>ผู้ใช้: <?php echo htmlspecialchars($username); ?></h3>
        <div class="mt-4">
            <h5>รายการที่จอง:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>ภาพสินค้า</th>
                        <th>จำนวน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bookings as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($row["image"]) . "' alt='Product Image' style='width: 100px;'></td>";
                        echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <form action="finalize_booking.php" method="POST">
                <button type="submit" class="btn btn-lg btn-primary">ยืนยันการจอง</button>
            </form>
            <a href="cart.php" class="btn btn-lg btn-danger">ยกเลิกและกลับไปที่ตะกร้า</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
