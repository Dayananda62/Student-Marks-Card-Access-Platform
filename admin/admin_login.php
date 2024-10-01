<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            display: flex;
            gap: 2rem;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        label {
            margin-bottom: 8px;
            color: #555;
        }

        input {
            padding: 10px;
            margin-bottom: 16px;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }

        input::placeholder {
            transition-duration: 0.3s;
        }

        input:focus::placeholder {
            transform: translateY(-5rem);
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition-duration: 0.3s;

        }

        button:hover {
            background-color: #3d8b3d;
        }

        /* .switch-form {
            margin-top: 16px;
            font-size: 14px;
            color: #555;
        }

        .switch-form a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        } */
    </style>
</head>

<body>

    <?php
    session_start();
    ?>
    <script>
        function validateEmail() {
            const email = document.getElementById('email');
            const login = document.getElementById('loginButton');
            const errorElement = document.getElementById('err');
            const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
            login.disabled = !isValidEmail;
            login.style.cursor = isValidEmail ? 'pointer' : 'not-allowed';
            errorElement.textContent = isValidEmail ? '' : 'Invalid email format';
        }
    </script>

    <?php
    // if (isset($_POST['register'])) {
//     include("../config.php");
    
    //     $email = $_POST['email'];
    
    //     $sql = "select * from tbl_admin where email='$email'";
//     $result = mysqli_query($con, $sql);
//     $count = mysqlI_num_rows($result);
    
    //     if ($count > 0) {
//         echo "<script>
// 				alert('There is an existing account associated with this email.');
// 			</script>";
//         echo "<script> location.href='index.php'; </script>";
//     } else {
//         $name = $_POST['name'];
//         $email = $_POST['email'];
//         $password = $_POST['password'];
//         $query = "INSERT INTO tbl_admin(name,email,password) VALUES('" . $name . "','" . $email . "','" . $password . "')";
//         mysqli_query($con, $query) or die(mysqli_error($con));
//         echo "<script>
// 				alert('Registeration Completed, Please Login.');
// 			</script>";
//         echo "<script> location.href='admin_login.php'; </script>";
    
    //     }
// }
    

    if (isset($_POST['login'])) {
        include("../config.php");

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "select * from tbl_admin where email='" . $email . "' and password='" . $password . "'";
            $result = mysqli_query($con, $sql);
            $count = mysqlI_num_rows($result);
            if ($count > 0) {
                $_SESSION["admin_login"] = true;
                $_SESSION['admin'] = $email;
                $a = $_SESSION['admin'];
                echo "<script>alert('Login Success');</script>";
                echo "<script> location.href='marks_detail_admin.php'; </script>";
            } else {
                echo "<script>
				alert('Invalid Email or Password');
			</script>";
            }
        } else {
            echo "<script>alert('Invalid Email');</script>";
            echo "<script> location.href='admin_login.php'; </script>";
        }
    }
    ?>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="#" method="post">
            <input type="email" id="email" name="email" placeholder="Email" required oninput="validateEmail()">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" id="loginButton" disabled style="cursor: not-allowed;">Login</button>
            <p id="err" style="color:red;"></p>
        </form>

        <!-- <p class="switch-form">Don't have an account? <a href="#" id="switchToReg">Register here</a></p> -->
    </div>

    <!-- <div class="container" style="display: none;" id="registrationForm">
        <h2>Admin Registration</h2>
        <form action="admin_login.php" method="post">
            <label for="regName">Name:</label>
            <input type="text" id="regName" name="name" required>

            <label for="regEmail">Email:</label>
            <input type="email" id="regEmail" name="email" required>

            <label for="regPassword">Password:</label>
            <input type="password" id="regPassword" name="password" required>

            <label for="regPassword">Confirm Password:</label>
            <input type="password" id="regPassword" name="conPassword" required>

            <button type="submit" name="register">Register</button>
        </form>

        <p class="switch-form">Already have an account? <a href="#" id="switchToLogin">Login here</a></p>
    </div>

    <script>
        document.getElementById('switchToReg').addEventListener('click', function () {
            document.getElementById('registrationForm').style.display = 'block';
            document.querySelector('.container').style.display = 'none';
        });

        document.getElementById('switchToLogin').addEventListener('click', function () {
            document.getElementById('registrationForm').style.display = 'none';
            document.querySelector('.container').style.display = 'block';
        });
    </script> -->

</body>

</html>