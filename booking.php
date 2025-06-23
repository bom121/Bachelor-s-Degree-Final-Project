<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การจอง</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin-top: 20px;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
        }
        p {
            text-align: center;
            font-size: 16px;
        }
        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }
        .button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-bookings {
            text-align: center;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // การเชื่อมต่อกับฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "car_repair";

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['phone'], $_POST['service'], $_POST['date'], $_POST['time'])) {
        // รับข้อมูลจากฟอร์ม
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $service = $_POST['service'];
        $booking_date = $_POST['date'];
        $booking_time = $_POST['time'];

        // SQL สำหรับการเพิ่มข้อมูลการจอง
        $sql = "INSERT INTO bookings (customer_name, phone_number, service_type, booking_date, booking_time) 
                VALUES ('$name', '$phone', '$service', '$booking_date', '$booking_time')";

        if ($conn->query($sql) === TRUE) {
            echo "<h2>การจองของคุณเสร็จสมบูรณ์แล้ว!</h2>";
            echo "<p>ขอบคุณสำหรับการจอง คุณสามารถกลับไปที่หน้าแรกได้โดยคลิกปุ่มด้านล่าง</p>";
            echo "<a href='index.php'><button class='button'>กลับไปหน้าแรก</button></a>";
        } else {
            echo "<p>เกิดข้อผิดพลาด: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "<p class='no-bookings'>กรุณากรอกข้อมูลการจอง</p>";
    }

    // ปิดการเชื่อมต่อ
    $conn->close();
    ?>
</div>

<div class="container">
    <h2>รายการการจองทั้งหมด</h2>
    <?php
    // สร้างการเชื่อมต่อใหม่
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ดึงข้อมูลจากตาราง bookings
    $sql = "SELECT * FROM bookings ORDER BY booking_date, booking_time";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>ชื่อ</th><th>เบอร์โทร</th><th>บริการ</th><th>วันที่จอง</th><th>เวลาจอง</th></tr>";

        // แสดงผลข้อมูล
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["customer_name"]. "</td><td>" . $row["phone_number"]. "</td><td>" . $row["service_type"]. "</td><td>" . $row["booking_date"]. "</td><td>" . $row["booking_time"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-bookings'>ไม่มีการจองในขณะนี้</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
