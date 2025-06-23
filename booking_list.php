<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>รายการการจองทั้งหมด</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* สไตล์ต่างๆ */
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
        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .back-button a {
            display: inline-block;
            width: 200px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .back-button a:hover {
            background-color: #45a049;
        }
        .cancel-button {
            color: white;
            background-color: #d9534f;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">รายการการจองทั้งหมด</h2>

        <?php
            // การเชื่อมต่อกับฐานข้อมูล
            $conn = new mysqli("localhost", "root", "", "car_repair");

            if ($conn->connect_error) {
                die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
            }

            // ตรวจสอบว่ามีการกดปุ่มยกเลิกและได้รับ ID การจอง
            if (isset($_POST['cancel_booking'])) {
                $booking_id = $_POST['booking_id'];
                $delete_sql = "DELETE FROM bookings WHERE id = $booking_id";

                if ($conn->query($delete_sql) === TRUE) {
                    echo "<p style='color: green; text-align: center;'>การจองถูกยกเลิกเรียบร้อยแล้ว</p>";
                } else {
                    echo "<p style='color: red; text-align: center;'>เกิดข้อผิดพลาด: " . $conn->error . "</p>";
                }
            }

            // SQL เพื่อดึงข้อมูลการจอง
            $sql = "SELECT * FROM bookings ORDER BY booking_date, booking_time";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-hover'><thead><tr><th>ชื่อ</th><th>เบอร์โทร</th><th>บริการ</th><th>วันที่</th><th>เวลา</th><th>การจัดการ</th></tr></thead><tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["customer_name"] . "</td>
                        <td>" . $row["phone_number"] . "</td>
                        <td>" . $row["service_type"] . "</td>
                        <td>" . $row["booking_date"] . "</td>
                        <td>" . $row["booking_time"] . "</td>
                        <td>
                            <form method='post' style='display: inline;'>
                                <input type='hidden' name='booking_id' value='" . $row["id"] . "'>
                                <button type='submit' name='cancel_booking' class='cancel-button'>ยกเลิก</button>
                            </form>
                        </td>
                    </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='text-center no-bookings'>ไม่มีข้อมูลการจอง</p>";
            }

            $conn->close();
        ?>

        <!-- ปุ่มกลับไปที่หน้าแรก -->
        <div class="back-button">
            <a href="index.php">กลับหน้าแรก</a>
        </div>
    </div>
</body>
</html>
