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

// ตรวจสอบว่ามี product_id หรือไม่
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = 1; // แทนที่ด้วย ID ของผู้ใช้ที่เข้าสู่ระบบ

    // ลบรายการจากตะกร้า
    $deleteSql = "DELETE FROM cart WHERE product_id = $product_id AND user_id = $user_id";
    
    if ($conn->query($deleteSql) === TRUE) {
        // ถ้าลบสำเร็จ redirect กลับไปที่หน้า cart
        header("Location: cart.php");
        exit();
    } else {
        echo "Error removing item: " . $conn->error;
    }
} else {
    echo "Product ID not specified.";
}

$conn->close();
?>
