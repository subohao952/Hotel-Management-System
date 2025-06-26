<?php
include 'config.php';
session_start();

function prepareAndExecute($conn, $sql, $params) {
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('mysqli error: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    return $stmt;
}

$error_message = '';

// user login
if (isset($_POST['user_login_submit'])) {
    $email = $_POST['Email'];
    $password = md5($_POST['Password']);
    $sql = "SELECT * FROM signup WHERE Email = ?";
    $stmt = prepareAndExecute($conn, $sql, [$email]);
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $sql = "SELECT * FROM signup WHERE Email = ? AND Password = ?";
        $stmt = prepareAndExecute($conn, $sql, [$email, $password]);
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $_SESSION['usermail'] = $email;
            header("Location: home.php");
            exit();
        } else {
            $error_message = 'Password is incorrect';
        }
    } else {
        $error_message = 'Invalid account';
    }
}

// staff login
if (isset($_POST['Emp_login_submit'])) {
    $email = $_POST['Emp_Email'];
    $password = md5($_POST['Emp_Password']);
    $sql = "SELECT * FROM emp_login WHERE Emp_Email = ?";
    $stmt = prepareAndExecute($conn, $sql, [$email]);
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $sql = "SELECT * FROM emp_login WHERE Emp_Email = ? AND Emp_Password = ?";
        $stmt = prepareAndExecute($conn, $sql, [$email, $password]);
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $_SESSION['usermail'] = $email;
            header("Location: admin/admin.php");
            exit();
        } else {
            $error_message = 'Password is incorrect';
        }
    } else {
        $error_message = 'Invalid account';
    }
}

// register
if (isset($_POST['user_signup_submit'])) {
    $username = $_POST['Username'];
    $email = $_POST['Email'];
    $password = md5($_POST['Password']);
    $cpassword = md5($_POST['CPassword']);

    if ($username == "" || $email == "" || $password == "") {
        $error_message = 'Please fill all fields';
    } else {
        if ($password == $cpassword) {
            $sql_check = "SELECT * FROM signup WHERE Email = ?";
            $stmt_check = prepareAndExecute($conn, $sql_check, [$email]);
            $result = $stmt_check->get_result();
            if ($result->num_rows > 0) {
                $error_message = 'Account already exist';
            } else {
                $sql_insert = "INSERT INTO signup (Username, Email, Password) VALUES (?, ?, ?)";
                $stmt_insert = prepareAndExecute($conn, $sql_insert, [$username, $email, $password]);
                if ($stmt_insert->affected_rows > 0) {
                    $_SESSION['usermail'] = $email;
                    header("Location: home.php");
                    exit();
                } else {
                    $error_message = 'Something went wrong';
                }
            }
        } else {
            $error_message = 'Password does not match';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Blue Bird</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <section id="carouselExampleControls" class="carousel slide carousel_section" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active"><img class="carousel-image" src="./image/hotel1.jpg"></div>
            <div class="carousel-item"><img class="carousel-image" src="./image/hotel2.jpg"></div>
            <div class="carousel-item"><img class="carousel-image" src="./image/hotel3.jpg"></div>
            <div class="carousel-item"><img class="carousel-image" src="./image/hotel4.jpg"></div>
        </div>
    </section>

    <div class="login-container">
        <div class="logo">
            <img src="./image/bluebirdlogo.png" alt="Bluebird Logo">
            <h4 class="mt-2">Bluebird Hotel</h4>
        </div>

        <div class="role-tabs">
            <button class="btn btn-outline-primary" onclick="showUser()">User</button>
            <button class="btn btn-outline-secondary" onclick="showStaff()">Staff</button>
        </div>

        <div id="user_section">
            <h2>User Login</h2>
            <form method="POST" action="">
                <input type="email" name="Email" class="form-control mb-3" placeholder="Email" required>
                <input type="password" name="Password" class="form-control mb-3" placeholder="Password" required>
                <button type="submit" name="user_login_submit" class="auth_btn">Sign In</button>
            </form>
            <div class="switch-link">No account? <span onclick="showSignup()">Create one</span></div>
        </div>

        <div id="staff_section" style="display: none;">
            <h2>Staff Login</h2>
            <form method="POST" action="">
                <input type="email" name="Emp_Email" class="form-control mb-3" placeholder="Staff Email" required>
                <input type="password" name="Emp_Password" class="form-control mb-3" placeholder="Password" required>
                <button type="submit" name="Emp_login_submit" class="auth_btn">Sign In</button>
            </form>
        </div>

        <div id="signup_section" style="display: none;">
            <h2>Register</h2>
            <form method="POST" action="">
                <input type="text" name="Username" class="form-control mb-3" placeholder="Full Name" required>
                <input type="email" name="Email" class="form-control mb-3" placeholder="Email Address" required>
                <input type="password" name="Password" class="form-control mb-3" placeholder="Password" required>
                <input type="password" name="CPassword" class="form-control mb-3" placeholder="Confirm Password" required>
                <button type="submit" name="user_signup_submit" class="auth_btn">Register</button>
                <div class="switch-link">Already have an account? <span onclick="showUser()">Log in</span></div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showUser() {
            document.getElementById("user_section").style.display = "block";
            document.getElementById("staff_section").style.display = "none";
            document.getElementById("signup_section").style.display = "none";
        }

        function showStaff() {
            document.getElementById("user_section").style.display = "none";
            document.getElementById("staff_section").style.display = "block";
            document.getElementById("signup_section").style.display = "none";
        }

        function showSignup() {
            document.getElementById("user_section").style.display = "none";
            document.getElementById("staff_section").style.display = "none";
            document.getElementById("signup_section").style.display = "block";
        }

        <?php if (!empty($error_message)): ?>
        swal({
            title: '<?php echo $error_message; ?>',
            icon: 'error',
        });
        <?php endif; ?>
    </script>
</body>
</html>