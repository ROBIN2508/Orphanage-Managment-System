<?php
    require_once "../db_connection.php";
    $not = '';
    $mail = '';
    $password = '';
    
    if(isset($_POST["submit"])){
        $mail = $_POST["log_mail_or_id"];
        $password = $_POST["log_password"];

        if ($mail == null || $password == null) {
			$not = "Invalid Email / ID or Password";
		}

		else {
            $not = "Invalid Email / ID or Password";
            $sql = "SELECT admin_id, email, password FROM orp_admin WHERE (admin_id = '$mail' OR email = '$mail') AND password = '$password'";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                if (($row["admin_id"] == $mail || $row["email"] == $mail) && $row["password"] == $password) {
                    $not = "Sucess";
                    session_start();
					$_SESSION["admin_id"] = $row["admin_id"];
                    $_SESSION['testing'] = time();
                    header("Location: ../account/");
		        }

                else{
                    $not = "Invalid Email / ID or Password";
                }
            }
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

    <!-- fontawesome css -->
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css'>

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="../source/custom/css/style.css">

    <!-- favicon logo  -->
    <link rel="icon" href="../source/img/logo.ico">

    <title>Sign In || Orphanage management system</title>
</head>

<body
    style="background: url('../source/img/background.jpg')no-repeat center center fixed; background-color: #7FABB7;
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
            <div class="row my-3 mx-auto">
                <div class="wrapper">
                    <form method="POST" action="">
                        <div class="h5 font-weight-bold text-center mb-3">
                            Login
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div class="icon">
                                <span class="far fa-envelope"></span>
                            </div>
                            <input autocomplete="off" type="text" class="form-control" placeholder="Email or ID"
                                name="log_mail_or_id" value="<?php echo $mail; ?>">
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div class="icon">
                                <span class="fas fa-key"></span>
                            </div>
                            <input autocomplete="off" type="password" id="pwd" class="form-control" name="log_password"
                                placeholder="Password" value="<?php echo $password; ?>">
                            <div class="icon btn">
                                <span class="fas fa-eye" id="pwdic" onclick="showPassword()"></span>
                            </div>
                        </div>
                        <input type="submit" role="button" class="btn btn-primary mb-2 mx-auto d-block" value="Login"
                            name="submit">
                        <!-- <div class="btn btn-primary mb-2 mx-auto">
                                    Signup
                                </div> -->

                        <!-- <div class="terms mb-2">
                                    By clicking "Signup", you acknowledge that you have read the
                                    <a href="#">Privacy Policy</a> and agree to the <a href="#">Terms of Service</a>.
                                </div> -->

                        <p id="not" class="text-danger text-center fs-6">
                            <b>
                                <?php echo $not; ?>
                            </b>
                        </p>
                    </form>
                    <div class="mb-3 sign_up_button">
                        <span class="text-light-white">Don't have an account? &nbsp;</span>
                        <a href="./signup.php">Sign Up</a>
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
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>