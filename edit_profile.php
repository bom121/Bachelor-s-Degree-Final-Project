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
$sql = "SELECT * FROM users WHERE username='$current_user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "ไม่พบข้อมูลผู้ใช้";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 600px; /* ปรับขนาดฟอร์มให้กว้างขึ้น */
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px); /* ให้มีขนาดพอดีกับฟอร์ม */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px; /* เพิ่มขนาดตัวอักษร */
        }

        input[type="submit"],
        .back-button {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px; /* เพิ่มขนาดตัวอักษร */
            margin-top: 10px; /* เพิ่มช่องว่างระหว่างปุ่ม */
        }

        input[type="submit"]:hover,
        .back-button:hover {
            background-color: #4cae4c;
        }

        .back-button {
            background-color: #d9534f; /* สีของปุ่มย้อนกลับ */
        }
    </style>
</head>
<body>
    <h1>แก้ไขข้อมูลส่วนตัว</h1>
    <form action="update_profile.php" method="POST">
        <label for="email">อีเมล:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <label for="phone">เบอร์โทร:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        
        <label for="password">รหัสผ่านใหม่:</label>
        <input type="password" id="password" name="password" placeholder="รหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)">
        
        <input type="submit" value="อัปเดตข้อมูล">
        <button type="button" class="back-button" onclick="window.location.href='index.php'">ย้อนกลับ</button> <!-- ปุ่มย้อนกลับ -->
    </form>
</body>
</html>
