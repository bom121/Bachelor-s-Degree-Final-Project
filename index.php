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
                                <a href="index.php" class="nav-item nav-link active">หน้าแรก</a>                     
                                <a href="product.php" class="nav-item nav-link">สินค้า</a>                      
                                <a href="booking1.php" class="nav-item nav-link">การจอง</a>                                                                                         
                                <a href="contact.php" class="nav-item nav-link">ติดต่อเรา</a>
                            </div>
                            
                            <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                                <div class="d-inline-flex align-items-center py-2">
                                <span class="text-warning">
                                <div class="d-inline-flex align-items-center py-2">
                                <a href="cart.php" class="fas fa-shopping-cart 2x mb-2 me-2"></a>
                                <a href="edit_profile.php">Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest"; ?>
                                </span>
                                <a href="logout.php" class="btn btn-primary ms-3">Logout</a> <!-- ปุ่มออกจากระบบ -->
                            </div>
                        </div>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->




        
        <!-- Carousel Start -->
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="img/background.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style=" max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">โปรโมชั่นของทางร้าน</h6>                   
                                <h1 class="display-3 text-white mb-4 animated slideInDown"><img class="img-fluid" src="img/pomotion2.png" alt=""></h1>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">ติดต่อพูดคุยกับเรา</a>
                                <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">ดูเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="carousel-item">
                        <img class="w-100" src="img/background.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">โปรโมชั่นของทางร้าน</h6>
                                <h1 class="display-3 text-white mb-4 animated slideInDown"><img class="img-fluid" src="img/pomotion1.png" alt=""></h1>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">ติดต่อพูดคุยกับเรา</a>
                                <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">ดูเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->



        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase">About Us</h6>
                        <h1 class="mb-4">Welcome to <span class="text-primary text-uppercase">BOMAUTO</span></h1>
                        <p class="mb-4">เว็บไซต์ของเราคือจุดหมายปลายทางครบวงจรสำหรับการดูแลและซ่อมแซมรถยนต์ของคุณ คุณสามารถตรวจสอบสินค้าที่มีอยู่ เช่น ยาง น้ำมันเครื่อง เบรก แบตเตอรี่ และระบบปรับอากาศ พร้อมทั้งรับข้อมูลและคำแนะนำในการเลือกสินค้าที่เหมาะสมกับรถของคุณ

                        </p>
                        <div class="row g-3 pb-4">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                        <p class="mb-0">Product</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fas fa-comments-dollar fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                        <p class="mb-0">Products sold</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                        <p class="mb-0">Applicant</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a  href="about.html"class="btn btn-primary py-3 px-5 mt-2" href="">ดูเพิ่มเติม</a>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="img/test02.png" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="img/test01.jpg">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="img/test04.png">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="img/test03.jpg">
                            </div>
                        </div>
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
        


        <!-- Back to Top -->
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