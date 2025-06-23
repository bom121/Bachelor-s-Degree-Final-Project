<?php
session_start(); // เริ่มต้น session

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

// แทนที่ด้วย ID ของผู้ใช้ที่เข้าสู่ระบบ
$user_id = 1; // เปลี่ยนเป็นโค้ดที่ดึง ID ของผู้ใช้ที่ล็อกอิน
$username = $_SESSION['username']; // ดึงชื่อผู้ใช้จาก session

// ดึงข้อมูลจากตาราง cart
$sql = "SELECT * FROM cart WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // ตัวแปรสำหรับเก็บข้อมูลการจอง
    $bookings = [];
    $totalQuantity = 0;

    // สร้างการบันทึกการจองใหม่ในตาราง bookings
    while ($row = $result->fetch_assoc()) {
        $product_id = $row["product_id"];
        $quantity = $row["quantity"];
        $name = $row["name"];
        $image = $row["image"];

        // เพิ่มข้อมูลการจองในตาราง bookings
        $insertBookingSql = "INSERT INTO bookings (user_id, username, product_id, name, image, quantity) VALUES ($user_id, '$username', $product_id, '$name', '$image', $quantity)";
        if ($conn->query($insertBookingSql) === TRUE) {
            // อัปเดตข้อมูลสต็อกและจำนวนการขายในตาราง products
            $updateProductSql = "UPDATE products SET stock = stock - $quantity, sold = sold + $quantity WHERE id = $product_id";
            if ($conn->query($updateProductSql) !== TRUE) {
                echo "Error updating product stock and sold quantity: " . $conn->error;
            }

            // เพิ่มข้อมูลการจองในอาร์เรย์
            $bookings[] = [
                'name' => $name,
                'image' => $image,
                'quantity' => $quantity,
                'booking_date' => date('Y-m-d H:i:s') // บันทึกวันที่ปัจจุบัน
            ];
            $totalQuantity += $quantity;
        } else {
            echo "Error adding booking: " . $conn->error;
        }
    }

    // ลบรายการจากตะกร้า
    $deleteCartSql = "DELETE FROM cart WHERE user_id = $user_id";
    if ($conn->query($deleteCartSql) !== TRUE) {
        echo "Error clearing cart: " . $conn->error;
    }

    // แสดงใบเสร็จ
    ?>
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ใบเสร็จการจอง</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <h1 class="text-center">ใบเสร็จการจอง</h1>
            <p class="text-center">คุณได้ทำการจองทั้งหมด <strong><?php echo $totalQuantity; ?></strong> ชิ้น</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>รูปภาพ</th>
                        <th>จำนวน</th>
                        <th>วันที่จอง</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($booking['image']); ?>" alt="Product Image" style="width: 100px; height: auto;"></td>
                            <td><?php echo htmlspecialchars($booking['quantity']); ?></td>
                            <td><?php echo $booking['booking_date']; ?></td> <!-- แสดงวันที่จอง -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary">กลับไปหน้าแรก</a>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "ไม่มีสินค้าที่อยู่ในตะกร้า";
}

$conn->close();
?>
