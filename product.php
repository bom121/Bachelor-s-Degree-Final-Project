<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bomauto.com</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<?php
// เริ่มเซสชัน
session_start();

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost"; // เปลี่ยนเป็นเซิร์ฟเวอร์ฐานข้อมูลของคุณ
$username_db = "root"; // ชื่อผู้ใช้ที่ถูกต้อง
$password_db = ""; // รหัสผ่านที่ถูกต้อง
$dbname = "jerlaw"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าได้มีการล็อกอินหรือไม่
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT username FROM users WHERE id = '$userId'"; // ตรวจสอบว่าชื่อฟิลด์และตารางถูกต้อง
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        $username = "Guest"; // ถ้าไม่พบผู้ใช้
    }
} else {
    $username = "Guest"; // ถ้ายังไม่ได้ล็อกอิน
}

$conn->close();

?>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="index.php" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary text-uppercase">BOMAUTO</h1>
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="row gx-0 bg-white d-none d-lg-flex">
                        <div class="col-lg-7 px-5 text-start">
                            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                             
                            </div>
                            <div class="h-100 d-inline-flex align-items-center py-2">
                                
                            </div>
                        </div>
                        <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                              
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                        <a href="index.html" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary text-uppercase">BOMAUTO</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="index.php" class="nav-item nav-link">หน้าแรก</a>                        
                                <a href="product.php" class="nav-item nav-link active">สินค้า</a>                                 
                                <a href="booking1.php" class="nav-item nav-link">การจอง</a>                   
                                <a href="contact.php" class="nav-item nav-link">ติดต่อเรา</a>
                            </div>

                            <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                                <div class="d-inline-flex align-items-center py-2">
                                <span class="text-warning">
                                <div class="d-inline-flex align-items-center py-2">
                                <a href="cart.php" class="fas fa-shopping-cart 2x mb-2 me-2"></a>
                                    Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest"; ?>
                                </span>
                                <a href="logout.php" class="btn btn-primary ms-3">Logout</a> <!-- ปุ่มออกจากระบบ -->
                            </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/background2.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">สินค้า</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">หน้าแรก</a></li>
                            <li class="breadcrumb-item"><a href="#">หน้า</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">สินค้า</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


    


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">สินค้าของเรา</h6>
                    <h1 class="mb-5">รายการ <span class="text-primary text-uppercase">สินค้า</span></h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a class="service-item rounded" href="car tires.php">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fas fa-ring fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">ยางรถยนต์</h5>
                            <p class="text-body mb-0">ยางรถยนต์ที่เราจำหน่ายผ่านการคัดสรรอย่างพิถีพิถันจากแบรนด์ชั้นนำที่ได้รับการยอมรับในระดับสากลช่วยให้การขับขี่ของคุณปลอดภัยยิ่งขึ้น</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <a class="service-item rounded" href="oil.php">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fas fa-oil-can fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">น้ำมันเครื่อง</h5>
                            <p class="text-body mb-0">น้ำมันเครื่องที่เราจำหน่ายมีคุณภาพสูงและผ่านการรับรองมาตรฐานสากลทำให้เครื่องยนต์ทำงานได้อย่างมีประสิทธิภาพมากขึ้น
                            </p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <a class="service-item rounded" href="Brake.php">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fas fa-tachometer-alt fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">เบรค</h5>
                            <p class="text-body mb-0">เบรคที่เราจำหน่ายได้รับการผลิตจากวัสดุคุณภาพสูงและผ่านการทดสอบมาตรฐานความปลอดภัยระดับสากลเพื่อให้คุณมั่นใจในความปลอดภัยสูงสุดขณะขับขี่</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <a class="service-item rounded" href="bat.php">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fas fa-car-battery fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">แบตเตอรี่</h5>
                            <p class="text-body mb-0">แบตเตอรี่ที่เราจำหน่ายถูกคัดสรรมาเพื่อให้ประสิทธิภาพในการจ่ายพลังงานที่สม่ำเสมอและเชื่อถือได้ ช่วยให้รถยนต์ของคุณพร้อมเดินทางในทุกสถานการณ์</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <a class="service-item rounded" href="air.php">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fas fa-snowflake fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">ระบบปรับอากาศในรถ</h5>
                            <p class="text-body mb-0">ระบบปรับอากาศในรถยนต์ที่เราจำหน่ายถูกออกแบบมาเพื่อให้ความเย็นที่รวดเร็วและมีประสิทธิภาพในทุกสภาพอากาศ  </p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <a class="service-item rounded" href="wheel.php">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="	fas fa-car fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">ล้อแม็ก</h5>
                            <p class="text-body mb-0">ล้อแม็กที่เราจำหน่ายเป็นสินค้าคุณภาพสูง ผลิตจากวัสดุเกรดพรีเมี่ยม มีความแข็งแรง ทนทาน รองรับการใช้งานได้ดีในระยะยาว </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
     <!-- ล่างสุด -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/background2.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown"></p1>
                    <nav aria-label="breadcrumb">
                    </nav>
                </div>
            </div>
        </div>
 <!-- ล่างสุด -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>