<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bomauto";

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$product_id = $_POST['product_id'];
$user_id = 1; // แทนที่ด้วย ID ของผู้ใช้ที่เข้าสู่ระบบ
$quantity = 1; // จำนวนเริ่มต้น
$price = $_POST['price'];
$name = $_POST['name']; // เพิ่มการรับชื่อสินค้า
$image = $_POST['image']; // รับค่ารูปภาพ

// เพิ่มสินค้าเข้าตะกร้า
$sql = "INSERT INTO cart (product_id, user_id, quantity, price, name, image) VALUES ('$product_id', '$user_id', '$quantity', '$price', '$name', '$image')"; // เพิ่ม image ในคำสั่ง SQL

if ($conn->query($sql) === TRUE) {
    // แสดงข้อความแจ้งเตือนและเปลี่ยนหน้าไปที่ product.php
    echo "<script>
            alert('เพิ่มสินค้าลงตะกร้าสำเร็จ');
            window.location.href = 'product.php';
          </script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$conn->close();
?>
