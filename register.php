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

// รับข้อมูลจากฟอร์ม
$user = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];

// ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
if ($password !== $confirmPassword) {
    die("Passwords do not match.");
}

// เข้ารหัสรหัสผ่านก่อนบันทึก
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// แสดงรหัสผ่านที่เข้ารหัส
echo "รหัสผ่านที่เข้ารหัส: " . $hashed_password; // เพิ่มบรรทัดนี้เพื่อแสดงรหัสผ่านที่เข้ารหัส

// SQL สำหรับเพิ่มข้อมูลผู้ใช้ใหม่
$sql = "INSERT INTO users (username, email, phone, password) VALUES ('$user', '$email', '$phone', '$hashed_password')";

// บันทึกข้อมูลลงฐานข้อมูล
if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
    // เปลี่ยนเส้นทางไปที่หน้า login.html
    header("Location: login.html");
    exit(); 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
