<?php
// product.php
$servername = "localhost"; // เปลี่ยนตามเซิร์ฟเวอร์ฐานข้อมูลของคุณ
$username = "root"; // เปลี่ยนตามชื่อผู้ใช้ฐานข้อมูลของคุณ
$password = ""; // เปลี่ยนตามรหัสผ่านฐานข้อมูลของคุณ
$dbname = "jerlaw"; // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM lost_items"; // เปลี่ยนชื่อตารางตามที่คุณต้องการดึงข้อมูล
$result = $conn->query($sql);

// สร้างอาร์เรย์เก็บข้อมูลสินค้า
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>
