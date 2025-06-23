<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jerlaw";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เริ่มต้น session
session_start();

// รับข้อมูลจากฟอร์ม
$user = $_POST['username'];
$password = $_POST['password'];

// SQL สำหรับดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user); // ป้องกัน SQL Injection
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่าพบผู้ใช้หรือไม่
if ($result->num_rows > 0) {
    // ดึงข้อมูลผู้ใช้
    $row = $result->fetch_assoc();
    
    // ตรวจสอบรหัสผ่าน
    if (password_verify($password, $row['password'])) {
        // รหัสผ่านถูกต้อง
        $_SESSION['user_id'] = $row['id']; // เก็บ ID ของผู้ใช้ในเซสชัน
        $_SESSION['username'] = $row['username']; // เก็บชื่อผู้ใช้ในเซสชัน
        header("Location: index.php");
        exit();
    } else {
        // หากรหัสผ่านไม่ถูกต้อง ส่งข้อความข้อผิดพลาดผ่าน query string
        header("Location: login.html?error=รหัสผ่านไม่ถูกต้อง!");
        exit();
    }
} else {
    // หากไม่พบผู้ใช้ ส่งข้อความข้อผิดพลาดผ่าน query string
    header("Location: login.html?error=ไม่พบบัญชีผู้ใช้!");
    exit();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
