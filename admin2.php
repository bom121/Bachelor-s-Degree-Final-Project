<?php
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์
$username = "root"; // ชื่อผู้ใช้
$password = ""; // รหัสผ่าน
$dbname = "car_repair"; // ชื่อฐานข้อมูล

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลจากตาราง car_repair (แทนที่ด้วยชื่อที่ถูกต้อง)
$sql = "SELECT * FROM bookings"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้า Admin - ประวัติการจองคิว</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">ประวัติการจองคิว</h1>
        
        <!-- ปุ่มด้านบน -->
        <div class="text-center mb-4">
            <a href="admin1.php" class="btn btn-lg btn-primary">ชื่อผู้ใช้</a>
            <a href="admin2.php" class="btn btn-lg btn-success">ประวัติการจองคิว</a>
            <a href="admin3.php" class="btn btn-lg btn-info">ประวัติการจองสินค้า</a>
            <a href="admin4.php" class="btn btn-lg btn-info">สินค้า</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>วันที่จอง</th>
                    <th>เวลา</th>
                    <th>รายละเอียด</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // แสดงข้อมูลการจองคิว
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["customer_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["booking_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["booking_time"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["service_type"]) . "</td>"; // แสดงรายละเอียดการจอง                      
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>ไม่มีประวัติการจองคิว</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="text-center mb-4">
            <a href="index.php" class="btn btn-lg btn-secondary">กลับไปหน้าแรก</a>
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
