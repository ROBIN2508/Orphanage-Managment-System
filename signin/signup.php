<?php
    require_once "../db_connection.php";
    $flag = 0;

    $user_id ='';
    $name = '';
    $father_name = '';
    $email = '';
    $mobile_no = '';
    $address = '';
    $password = '';

    $border=' border-danger border-2';
    $border_user_id = '';
    $border_email = '';
    $border_mobile_no = '';

    if(isset($_POST["register"])){
        $user_id = $_POST["user_id"];
        $name = $_POST["name"];
        $father_name = $_POST["father_name"];
        $email = $_POST["email"];
        $mobile_no = $_POST["mobile_no"];
        $address = $_POST["address"];
        $password = $_POST["password"];
        
        $sql = "SELECT admin_id, email, mobile_no FROM orp_admin WHERE 1";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            if ($row["admin_id"] == $user_id){
                $border_user_id = $border;
                $flag = 1;
            }
            if ($row["email"] == $email){
                $border_email = $border;
                $flag = 1;
            }
            if ($row["mobile_no"] == $mobile_no){
                $border_mobile_no = $border;
                $flag = 1;
            }
        }
        
        if ($flag == 0){
            $sql = "INSERT INTO orp_admin(admin_id, name, father_name, address, mobile_no, email, password, acc_type) VALUES ('$user_id','$name','$father_name','$address','$mobile_no','$email','$password','1')";
            mysqli_query($conn,$sql);
            header("Location: ./");
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- fontawesome CSS -->
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css'>

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="../source/custom/css/style.css">

    <!-- favicon logo  -->
    <link rel="icon" href="../source/img/logo.ico">

    <title>Regestration || Orphanage management system</title>
</head>

<body
    style="background: url('../source/img/background.jpg')no-repeat center center fixed; 
                                background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">

    <!-- Nav start here -->
    <nav class="navbar navbar-expand-lg navbar-light pt-3">
        <div class="container">
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-pills text-center ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../vision/">Vision &amp; Mission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contact_us/">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../donation/">Donate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page">Sign in</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nav end here -->

    <!-- Body paragraph start here -->
    <div class="container mt-3">
        <div class="row"
            style="background: linear-gradient(to bottom, #004683, #000428); border-radius: 15px; text-align: justify !important;">
            <div class="row  mx-auto">
                <div class="wrapper">
                    <form action="" method='POST'>
                        <div class="h5 font-weight-bold text-center mb-3">
                            Registration
                        </div>
                        <div class="form-group d-flex align-items-center <?php echo $border_user_id; ?>">
                            <div class="icon">
                                <span class="far fa-user"></span>
                            </div>
                            <input autocomplete="off" type="text" class="form-control" placeholder="User ID"
                                name="user_id" value="<?php echo $user_id; ?>" required>
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div class="icon">
                                <span class="far fa-user"></span>
                            </div>
                            <input autocomplete="off" type="text" class="form-control" placeholder="Name" name="name"
                                value="<?php echo $name; ?>" required>
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div class="icon">
                                <span class="far fa-user"></span>
                            </div>
                            <input autocomplete="off" type="text" class="form-control" placeholder="Father Name"
                                name="father_name" value="<?php echo $father_name; ?>" required>
                        </div>
                        <div class="form-group d-flex align-items-center <?php echo $border_email; ?>">
                            <div class="icon">
                                <span class="far fa-envelope"></span>
                            </div>
                            <input autocomplete="off" type="email" class="form-control" placeholder="Email" name="email"
                                value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group d-flex align-items-center <?php echo $border_mobile_no; ?>">
                            <div class="icon">
                                <span class="fas fa-phone"></span>
                            </div>
                            <input autocomplete="off" type="tel" class="form-control" placeholder="Mobile No."
                                name="mobile_no" value="<?php echo $mobile_no; ?>" required>
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div class="icon">
                                <span class="fas fa-map-marker-alt"></span>
                            </div>
                            <input autocomplete="off" type="text" class="form-control" placeholder="Parmanent Address"
                                name="address" value="<?php echo $address; ?>" required>
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div class="icon">
                                <span class="fas fa-key"></span>
                            </div>
                            <input autocomplete="off" type="password" id="pwd" class="form-control"
                                placeholder="Password" name="password" value="<?php echo $password; ?>" required>
                            <div class="icon btn">
                                <span class="fas fa-eye" id="pwdic" onclick="showPassword()"></span>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mb-2 mx-auto d-block" value="Register"
                            name="register">
                        <!-- <div class="btn btn-primary mb-2 mx-auto">
                                    Signup
                                </div> -->

                        <!-- <div class="terms mb-2">
                                    By clicking "Signup", you acknowledge that you have read the
                                    <a href="#">Privacy Policy</a> and agree to the <a href="#">Terms of Service</a>.
                                </div> -->
                    </form>
                    <div class="mb-3 sign_up_button">
                        <span class="text-light-white">Already have an account?</span>
                        <a href="./">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Body paragraph end here -->

    <!-- custom JavaScript -->
    <script src="../source/custom/js/main.js"></script>

    <!-- fontawesome JavaScript -->
    <script src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>