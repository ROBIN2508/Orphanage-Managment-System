<?php
    // 1 hours in seconds
    $inactive = 60*60; 
    ini_set('session.gc_maxlifetime', $inactive); // set the session max lifetime to 1 hours
        
    session_start();
    if (isset($_SESSION['admin_id'])){
        require_once "../db_connection.php";

        $admin_id = $_SESSION['admin_id'];

        if (isset($_SESSION['testing']) && (time() - $_SESSION['testing'] > $inactive)) {
            // last request was more than 1 hours ago
            session_unset();     // unset $_SESSION variable for this page
            session_destroy();   // destroy session data
        }

        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['testing'] = time(); // Update session

        $sql = "SELECT admin_id, name, father_name, address, mobile_no, email, password,acc_type FROM orp_admin WHERE admin_id = '$admin_id'";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $user_id = $row["admin_id"];
            $name = $row["name"];
            $father_name = $row["father_name"];
            $email = $row["email"];
            $mobile_no = $row["mobile_no"];
            $address = $row["address"];
            $password = $row["password"];
            $acc_type = $row["acc_type"];

            if ($acc_type==1){
                header("Location: ./index_user.php");
            }
        }
    }

    else{
        header("Location: ../signin");
    }

    if (isset($_POST["logout"])){
        session_unset();     // unset $_SESSION variable for this page
        session_destroy();   // destroy session data
        header("Location: ../signin");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wellcome || Orphanage management system </title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.svg" type="image/x-icon">

    <!-- font css -->
    <link rel="stylesheet" href="assets/fonts/feather.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="assets/fonts/material.css">

    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link">

</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Mobile header ] start -->
    <div class="pc-mob-header pc-header d-sm-flex d-lg-none">
        <div class="pcm-toolbar  d-md-flex flex-sm-row">
            <a class="pc-head-link" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <!-- <a href="#!" class="pc-head-link" id="headerdrp-collapse">
                <i data-feather="align-right"></i>
            </a> -->
        </div>
        <div class="pcm-toolbar d-sm-flex justify-content-sm-end">
            <a class="pc-head-link " id="header-collapse">
                <i data-feather="more-vertical"></i>
            </a>
        </div>
    </div>
    <!-- [ Mobile header ] End -->

    <!-- [ navigation menu ] start -->
    <nav class="pc-sidebar ">
        <div class="navbar-wrapper">
            <div class="m-header h6 text-center">
                <a href="index.html" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <img src="" alt="Orphanage management system" class="logo logo-lg">
                    <img src="" alt="Orphanage management system" class="logo logo-sm">
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar mt-2">
                    <!-- <li class="pc-item pc-caption">
                                        <label>Admin</label>
                                    </li> -->
                    <li class="pc-item active">
                        <a href="./" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">home</i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Orphanage</label>
                        <!-- <span>Tones of readymade charts</span> -->
                    </li>

                    <!-- Add new Orphanage -->
                    <li class="pc-item">
                        <a href="./add_orphanage.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Add Orphanage</span>
                        </a>
                    </li>

                    <!-- All Orphanage -->
                    <li class="pc-item">
                        <a href="./all_orphanage.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">All Orphanage</span>
                        </a>
                    </li>
                    <!-- Only Available Orphanage -->
                    <li class="pc-item">
                        <a href="./avail_orphanage.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Available Orphanage</span>
                        </a>
                    </li>

                    <!-- Only Windrow Orphanage -->
                    <!-- <li class="pc-item">
                        <a href="./widrow_orphanage.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Widrowed Orphanage</span>
                        </a>
                    </li> -->
                    <!-- Admin & User -->
                    <li class="pc-item pc-caption">
                        <label>User &amp; Admin</label>
                        <!-- <span>Tones of readymade charts</span> -->
                    </li>
                    <!-- All User -->
                    <li class="pc-item">
                        <a href="./users.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Users</span>
                        </a>
                    </li>
                    <!-- All Admin -->
                    <li class="pc-item">
                        <a href="./admin.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Admins</span>
                        </a>
                    </li>

                    <!-- Donation & Windrow -->
                    <li class="pc-item pc-caption">
                        <label>Donation &AMP; Widrow</label>
                    </li>

                    <!-- Donation -->
                    <li class="pc-item">
                        <a href="./donation.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Donation</span>
                        </a>
                    </li>
                    <!-- Windrow -->
                    <li class="pc-item">
                        <a href="./widrow_request.php" class="pc-link">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Widrow Requests</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <header class="pc-header ">
        <div class="header-wrapper">
            <div class="ml-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <img src="../source/img/profile.png" alt="user-image" class="user-avtar">
                            <span>
                                <span class="user-name"><?php echo $name; ?></span>
                                <span class="user-desc">
                                    <?php 
                                        if ($acc_type == 1){
                                            echo "User";
                                        }
                                        if ($acc_type == 0){
                                            echo "Administrator";
                                        }
                                    ?>    
                                </span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
                            <form action="" method="POST">
                                <button class="dropdown-item" type="submit" name="logout">
                                    <i class="material-icons-two-tone">chrome_reader_mode</i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="./">Home</a>
                                </li>
                                <li class="breadcrumb-item">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- support-section start -->
                <div class="col-xl-6 col-md-12">
                    <div class="card flat-card">
                        <div class="row-table">
                            <div class="col-sm-12 card-body br text-center">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="material-icons-two-tone text-primary mb-1">group</i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5>
                                            <?php
                                                $sql="SELECT COUNT(orp_id) as total_orp FROM orp_details;";
                                                $result = mysqli_query($conn,$sql);
                                                $row = mysqli_fetch_row($result);
                                                echo $row[0];
                                            ?>
                                        </h5>
                                        <span>Orphanage</span>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6 card-body br text-center">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="material-icons-two-tone text-primary mb-1">group</i>
                                        <!- - <i class="material-icons-two-tone text-primary mb-1">language</i> - ->
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5>2</h5>
                                        <span>Moderator</span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row-table">
                            <div class="col-sm-6 card-body br text-center">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="material-icons-two-tone text-primary mb-1">group</i>
                                        <!-- <i class="material-icons-two-tone text-primary mb-1">unarchive</i> -->
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5>
                                            <?php
                                                $sql="SELECT COUNT(admin_id) as total_admin FROM orp_admin WHERE acc_type=1;";
                                                $result = mysqli_query($conn,$sql);
                                                $row = mysqli_fetch_row($result);
                                                echo $row[0];
                                            ?>
                                        </h5>
                                        <span>USER</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 card-body br text-center">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="material-icons-two-tone text-primary mb-1">group</i>
                                        <!-- <i class="material-icons-two-tone text-primary mb-1">shopping_cart</i> -->
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5>
                                            <?php
                                                $sql="SELECT COUNT(admin_id) as total_admin FROM orp_admin WHERE acc_type=0;";
                                                $result = mysqli_query($conn,$sql);
                                                $row = mysqli_fetch_row($result);
                                                echo $row[0];
                                            ?>
                                        </h5>
                                        <span>Admin</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- support-section end -->
                <div class="col-xl-6 col-md-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card prod-p-card background-pattern">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-0">
                                        <div class="col">
                                            <h6 class="m-b-5">Total Donation (tk.)</h6>
                                            <h3 class="m-b-0">
                                                <?php
                                                    $sql="SELECT SUM(total_amount)FROM orp_donation WHERE status=1;";
                                                    $result = mysqli_query($conn,$sql);
                                                    $row = mysqli_fetch_row($result);
                                                    echo $row[0];
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="material-icons-two-tone text-primary">card_giftcard</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card prod-p-card bg-primary background-pattern-white">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-0">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Total Donation (No.)</h6>
                                            <h3 class="m-b-0 text-white">
                                                <?php
                                                $sql="SELECT COUNT(total_amount)FROM orp_donation WHERE status=1";
                                                $result = mysqli_query($conn,$sql);
                                                $row = mysqli_fetch_row($result);
                                                echo $row[0];
                                            ?>
                                            </h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="material-icons-two-tone text-white">local_mall</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- customer-section end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Warning Section start -->
    <!-- Older IE warning message -->
    <!--[if lt IE 11]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade
               <br/>to any of the following web browsers to access this website.
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="assets/images/browser/chrome.png" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="assets/images/browser/firefox.png" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script> -->
    <!-- <script src="assets/js/plugins/clipboard.min.js"></script> -->
    <!-- <script src="assets/js/uikit.min.js"></script> -->

    <!-- Apex Chart -->
    <script src="assets/js/plugins/apexcharts.min.js"></script>

    <!-- custom-chart js -->
    <script src="assets/js/pages/dashboard-sale.js"></script>
</body>

</html>