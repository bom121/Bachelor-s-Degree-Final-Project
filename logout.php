<?php
session_start();
session_destroy(); // ลบเซสชัน
header("Location: index.html"); // เปลี่ยนเส้นทางกลับไปที่หน้า index
exit();
?>
