<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jerlaw";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_user = $_SESSION['username'];

// รับข้อมูลจากฟอร์ม
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

// เตรียมคำสั่ง SQL
$sql = "UPDATE users SET email='$email', phone='$phone'";

if (!empty($password)) {
    // ถ้ามีการกรอกรหัสผ่านใหม่ให้ปรับปรุงรหัสผ่านด้วย
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // แฮชรหัสผ่าน
    $sql .= ", password='$hashed_password'";
}

$sql .= " WHERE username='$current_user'";

// ประมวลผลคำสั่ง SQL
if ($conn->query($sql) === TRUE) {
    // ถ้าอัปเดตข้อมูลสำเร็จ ให้ล้างเซสชันและเปลี่ยนเส้นทางไปหน้าล็อกอิน
    session_destroy(); // ทำลายเซสชัน
    header("Location: login.html"); // เปลี่ยนเส้นทางไปหน้าล็อกอิน
    exit();
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
