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

    if (isset($_POST["edit_data_submit"])){
        $edit_orp_id=$_POST["edit_orp_id"];
        $edit_orp_name=$_POST["edit_orp_name"];
        $edit_orp_dob=$_POST["edit_orp_dob"];

        $sql="UPDATE orp_details SET name='$edit_orp_name',dob='$edit_orp_dob' WHERE orp_id='$edit_orp_id'";
        mysqli_query($conn,$sql);
        header("Location: ./all_orphanage.php");
    }
    if (isset($_POST["del_data_submit"])){
        $del_orp_id=$_POST["orp_id"];
        $sql="DELETE FROM orp_details WHERE orp_id='$del_orp_id'";
        mysqli_query($conn,$sql);
        header("Location: ./all_orphanage.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>View All Orphanage || Orphanage management system </title>
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
    <!-- <link rel="icon" href="assets/images/favicon.svg" type="image/x-icon"> -->

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
                    <!-- <li class="pc-item pc-caption">
                                        <label>Admin</label>
                                    </li> -->
                    <li class="pc-item">
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
                    <li class="pc-item active">
                        <a class="pc-link">
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
                        </a> -->
                    </li>
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

    <!-- ------------------------------------- Edit Modal ------------------------------------- -->
    <div class="modal" id="edit_orp_data_modal" tabindex="-1" aria-labelledby="edit_orp_data" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit_orp_data">Edit Orphanage Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row mb-3">
                                <label for="edit_orp_id" class="col-sm-2 col-form-label">Orp. ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="edit_orp_id" name="edit_orp_id" readonly
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit_orp_name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="edit_orp_name" name="edit_orp_name"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit_orp_dob" class="col-sm-2 col-form-label">DoB</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="edit_orp_dob" name="edit_orp_dob"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit_orp_gender" class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="edit_orp_gender" name="edit_orp_gender"
                                        readonly required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit_data_submit">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- ------------------------------------- Delete Modal ------------------------------------- -->
    <div class="modal" id="del_orp_data_modal" tabindex="-1" aria-labelledby="del_orp_data" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    <input type="hidden" name="orp_id" id="orp_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="del_orp_data">Delete Orphanage Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <p class="text-center fs-5 text-danger"> Are you sure to delete Data.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger" name="del_data_submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ------------------------------------- Finish Modal ------------------------------------- -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="page-header-title">
                                <h5 class="m-b-10">All Orphanage</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="./">Home</a>
                                </li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">View All Orphanage</li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- support-section start -->
                <div class="table-responsive">
                    <table id="main_table" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">DoB [ YYYY-MM-DD ]</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $rc=0;
                                $sql = "SELECT orp_id, name, dob, gender FROM orp_details";
                                $result = mysqli_query($conn,$sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    $rc+=1;
                                    echo "<tr>";
                                    echo "<th scope=\"row\">".$rc."</th>";
                                    echo "<td>".$row["orp_id"]."</td>";
                                    echo "<td>".$row["name"]."</td>";
                                    echo "<td>".$row["dob"]."</td>";
                                    echo "<td>".$row["gender"]."</td>";
                                    echo "<td>";
                                    echo "<a type=\"button\" class=\"btn btn-warning orp_edit_button\">";
                                    echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\"
                                            fill=\"currentColor\" class=\"bi bi-pencil-fill\" viewBox=\"0 0 16 16\">
                                            <path d=\"M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z\" />
                                        </svg>";
                                    echo "</a> ";
                                    echo "<a type=\"button\" class=\"btn btn-danger orp_del_button\">";
                                    echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\"
                                            fill=\"currentColor\" class=\"bi bi-trash-fill\" viewBox=\"0 0 16 16\">
                                            <path d=\"M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z\" />
                                        </svg> </a>";
                                    echo "</td> </tr>";
                                }
                            ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">DoB [ YYYY-MM-DD ]</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- support-section end -->
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

        $('.orp_edit_button').on('click', function() {
            $("#edit_orp_data_modal").modal('show');
            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function() {
                return $(this).text();
            }).get();
            $('#edit_orp_id').val(data[0]);
            $('#edit_orp_name').val(data[1]);
            $('#edit_orp_dob').val(data[2]);
            $('#edit_orp_gender').val(data[3]);
        })
        $('.orp_del_button').on('click', function() {
            $("#del_orp_data_modal").modal('show');
            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function() {
                return $(this).text();
            }).get();
            $('#orp_id').val(data[0]);
        });
    });
    </script>
</body>

</html>