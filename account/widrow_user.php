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

            if ($acc_type==0){
                header("Location: ./index.php");
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

    if (isset($_POST["make_wideow_data_submit"])){
        $gender=$_POST["input_gender"];
        $user=$_POST["input_user_id"];
        $id=substr(md5(uniqid(time(), true)), 0, 8);

        $sql="INSERT INTO orp_widrow(widrow_req_id,user_id, orp_gender) VALUES ('$id','$user','$gender')";
        mysqli_query($conn,$sql);
        header("Location: ./widrow_user.php");
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

    <!-- Data table css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

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
                    <li class="pc-item">
                        <a href="./" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">home</i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <!-- Donation & Windrow -->
                    <li class="pc-item pc-caption">
                        <label>Donation &AMP; Widrow</label>
                    </li>

                    <!-- Donation -->
                    <li class="pc-item">
                        <a href="donation_user.php" class="pc-link ">
                            <span class="pc-micon">
                                <i class="material-icons-two-tone">table_rows</i>
                            </span>
                            <span class="pc-mtext">Donation</span>
                        </a>
                    </li>
                    <!-- Windrow -->
                    <li class="pc-item">
                        <a class="pc-link active">
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
    <!-- ------------------------------------- make widrow Modal ------------------------------------- -->
    <div class="modal" id="make_donation_data_modal" tabindex="-1" aria-labelledby="make_don_data" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="make_don_data">Widrow Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row">
                                <div class="row mb-3">
                                    <label for="input_method" class="col-sm-4 col-form-label">Expected Gender</label>
                                    <div class="col-sm-8">
                                        <input list="gender_detail" class="form-control" id="input_method" name="input_gender">
                                        <datalist id="gender_detail">
                                            <option value="Male">
                                            <option value="Female">
                                            <option value="Other">
                                        </datalist>
                                    </div>
                                </div>
                                
                                <input type="hidden" class="form-control" id="input_user_id" name="input_user_id"
                                    value="<?php echo $user_id; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" name="make_wideow_data_submit">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Widrow</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="./">Home</a>
                                </li>
                                <li class="breadcrumb-item">Widrow Request</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <button type="submit" class="btn btn-primary make_donation_btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            <path fill-rule="evenodd"
                                d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                        </svg>
                        <span>&nbsp; Make Request </span>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table id="main_table" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Widrow ID</th>
                                <th scope="col">Date and Time</th>
                                <th scope="col">Expected Gender</th>
                                <th scope="col">status</th>
                                <th scope="col">Orphanage ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $rc=0;
                                $sql = "SELECT widrow_req_id, date, orp_gender, status, orp_id FROM orp_widrow WHERE user_id='$admin_id'";
                                $result = mysqli_query($conn,$sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    $rc+=1;
                                    echo "<tr>";
                                    echo "<th scope=\"row\">".$rc."</th>";
                                    echo "<td>".$row["date"]."</td>";
                                    echo "<td>".$row["widrow_req_id"]."</td>";
                                    echo "<td>".$row["orp_gender"]."</td>";
                                    echo "<td>";
                                    if ($row["status"]==0){
                                        echo "<span class=\"text-info\"> Not Approve </span> ";
                                    }
                                    elseif ($row["status"]==1){
                                        echo "<span class=\"text-success\"> Approved </span> ";
                                    }
                                    echo "</td>";
                                    echo "<td>".$row["orp_id"]."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
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


    <!-- data table js -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#main_table').DataTable({
            pagingType: 'full_numbers',
            lengthMenu: [
                [10, 25, 50],
                [10, 25, 50]
            ]
        });

        $('.make_donation_btn').on('click', function() {
            $("#make_donation_data_modal").modal('show');
        });
    });
    </script>
</body>

</html>