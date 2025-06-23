<?php
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์
$username = "root"; // ชื่อผู้ใช้
$password = ""; // รหัสผ่าน
$dbname = "bomauto"; // ชื่อฐานข้อมูล

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// เพิ่มสินค้าใหม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $image = $_POST['image']; // ควรจัดการการอัปโหลดไฟล์แยกต่างหาก

    $sql = "INSERT INTO products (name, description, stock, price, image, created_at) VALUES ('$name', '$description', $stock, $price, '$image', NOW())";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                document.getElementById('toastBody').innerText = 'เพิ่มสินค้าสำเร็จ!';
                $('#notificationToast').toast('show');
              </script>";
    } else {
        echo "<script>
                document.getElementById('toastBody').innerText = 'เกิดข้อผิดพลาด: " . $conn->error . "';
                $('#notificationToast').toast('show');
              </script>";
    }
}

// เพิ่มจำนวนสินค้าที่มีอยู่แล้ว
if (isset($_GET['increase_id'])) {
    $increase_id = $_GET['increase_id'];
    
    // เพิ่มจำนวนสินค้าขึ้น 1 ชิ้น และอัปเดตวันที่เพิ่ม
    $sql_update_stock = "UPDATE products SET stock = stock + 1, created_at = NOW() WHERE id = $increase_id";
    if ($conn->query($sql_update_stock) === TRUE) {
        echo "<script>
                document.getElementById('toastBody').innerText = 'เพิ่มสินค้าขึ้น 1 ชิ้นเรียบร้อยแล้ว!';
                $('#notificationToast').toast('show');
              </script>";
    } else {
        echo "<script>
                document.getElementById('toastBody').innerText = 'เกิดข้อผิดพลาด: " . $conn->error . "';
                $('#notificationToast').toast('show');
              </script>";
    }
}

// ลบสินค้า
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // ตรวจสอบว่าสินค้ามีอยู่ในสต็อกหรือไม่
    $sql_check = "SELECT stock FROM products WHERE id = $delete_id";
    $result_check = $conn->query($sql_check);
    $row_check = $result_check->fetch_assoc();

    if ($row_check && $row_check['stock'] > 0) {
        // ลดจำนวนสินค้าในสต็อกลง 1 ชิ้น และเพิ่ม 1 ในจำนวนที่ขาย
        $sql_update_stock = "UPDATE products SET stock = stock - 1, sold = sold + 1, deleted_at = NOW() WHERE id = $delete_id";
        if ($conn->query($sql_update_stock) === TRUE) {
            echo "<script>
                    document.getElementById('toastBody').innerText = 'ลบสินค้าลงในสต็อก 1 ชิ้นเรียบร้อยแล้ว!';
                    $('#notificationToast').toast('show');
                  </script>";
        } else {
            echo "<script>
                    document.getElementById('toastBody').innerText = 'เกิดข้อผิดพลาด: " . $conn->error . "';
                    $('#notificationToast').toast('show');
                  </script>";
        }
    } else {
        echo "<script>
                document.getElementById('toastBody').innerText = 'ไม่สามารถลบได้ เนื่องจากสินค้าหมดสต็อก.';
                $('#notificationToast').toast('show');
              </script>";
    }
}

// แก้ไขสินค้า
if (isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $sql_update = "UPDATE products SET name='$name', description='$description', stock=$stock, price=$price, image='$image' WHERE id=$id";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
                document.getElementById('toastBody').innerText = 'แก้ไขสินค้าสำเร็จ!';
                $('#notificationToast').toast('show');
              </script>";
    } else {
        echo "<script>
                document.getElementById('toastBody').innerText = 'เกิดข้อผิดพลาด: " . $conn->error . "';
                $('#notificationToast').toast('show');
              </script>";
    }
}

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้า Admin - จัดการสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">จัดการสินค้า</h1>
        <div class="text-center mb-4">
            <a href="admin1.php" class="btn btn-lg btn-primary">ชื่อผู้ใช้</a>
            <a href="admin2.php" class="btn btn-lg btn-success">ประวัติการจองคิว</a>
            <a href="admin3.php" class="btn btn-lg btn-info">ประวัติการจองสินค้า</a>
            <a href="admin4.php" class="btn btn-lg btn-info">สินค้า</a>
        </div>
        <!-- ฟอร์มเพิ่มสินค้า -->
        <h3>เพิ่มสินค้าใหม่</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">ชื่อสินค้า</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">รายละเอียดสินค้า</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="stock">จำนวนในสต็อก</label>
                <input type="number" class="form-control" name="stock" required>
            </div>
            <div class="form-group">
                <label for="price">ราคา</label>
                <input type="number" class="form-control" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="image">ลิงก์ภาพสินค้า</label>
                <input type="text" class="form-control" name="image" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-success">เพิ่มสินค้า</button>
        </form>

        <!-- ตารางแสดงสินค้า -->
        <h3 class="mt-5">รายการสินค้า</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อสินค้า</th>
                    <th>รายละเอียด</th>
                    <th>จำนวนในสต็อก</th>
                    <th>ราคา</th>
                    <th>รูปภาพ</th>
                    <th>วันที่เพิ่มสินค้า</th>
                    <th>วันที่ลบสินค้า</th>
                    <th>จำนวนที่ขาย</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["stock"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($row["image"]) . "' alt='Product Image' style='width: 50px;'></td>";
                        echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["deleted_at"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["sold"]) . "</td>";
                        echo "<td>
                            <a href='?increase_id=" . $row["id"] . "' class='btn btn-primary'>เพิ่ม</a>
                            <a href='?delete_id=" . $row["id"] . "' class='btn btn-danger'>ลบ</a>
                            <button type='button' class='btn btn-warning' data-toggle='modal' data-target='#editModal' data-id='" . $row["id"] . "' data-name='" . htmlspecialchars($row["name"]) . "' data-description='" . htmlspecialchars($row["description"]) . "' data-stock='" . $row["stock"] . "' data-price='" . $row["price"] . "' data-image='" . htmlspecialchars($row["image"]) . "'>แก้ไข</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>ไม่มีสินค้าที่จะแสดง</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- ฟอร์มแก้ไขสินค้า (Modal) -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">แก้ไขสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" method="POST">
                        <input type="hidden" name="id" id="editProductId">
                        <div class="form-group">
                            <label for="edit_name">ชื่อสินค้า</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">รายละเอียดสินค้า</label>
                            <textarea class="form-control" name="description" id="edit_description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_stock">จำนวนในสต็อก</label>
                            <input type="number" class="form-control" name="stock" id="edit_stock" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_price">ราคา</label>
                            <input type="number" class="form-control" name="price" id="edit_price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">ลิงก์ภาพสินค้า</label>
                            <input type="text" class="form-control" name="image" id="edit_image" required>
                        </div>
                        <button type="submit" name="edit_product" class="btn btn-warning">บันทึกการแก้ไข</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="notificationToast" style="position: fixed; bottom: 20px; right: 20px;" data-delay="3000">
        <div class="toast-header">
            <strong class="mr-auto">การแจ้งเตือน</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="toastBody">
            <!-- ข้อความแจ้งเตือนจะปรากฏที่นี่ -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#notificationToast').toast();

            // ตั้งค่าข้อมูลใน Modal สำหรับการแก้ไข
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var description = button.data('description');
                var stock = button.data('stock');
                var price = button.data('price');
                var image = button.data('image');

                var modal = $(this);
                modal.find('#editProductId').val(id);
                modal.find('#edit_name').val(name);
                modal.find('#edit_description').val(description);
                modal.find('#edit_stock').val(stock);
                modal.find('#edit_price').val(price);
                modal.find('#edit_image').val(image);
            });
        });
    </script>
</body>
</html>
