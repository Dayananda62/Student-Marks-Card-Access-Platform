<?php
session_start();
?>
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
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition-duration: 0.3s;
        }

        button:hover {
            background-color: #3d8b3d;
        }

        .switch-form {
            margin-top: 16px;
            font-size: 14px;
            color: #555;
        }

        .switch-form a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <script>
        function validateFullname(formType) {
            const fullnameInput = document.getElementById('fullname');
            const err = document.getElementById(formType);

            if (fullnameInput.value === '') {
                err.textContent = 'Please enter your fullname.';
            } else if (!/^[A-Za-z\s]+$/.test(fullnameInput.value)) {
                err.textContent = 'Only alphabets & spaces are allowed!';
            } else {
                err.textContent = '';
            }
        }

        function validateUsername(formType) {
            const usernameInput = document.getElementById('usn');
            const err = document.getElementById(formType);

            if (usernameInput.value === '') {
                err.textContent = 'Please enter a username.';
            } else if (!/^[a-zA-Z0-9]+$/.test(usernameInput.value)) {
                err.textContent = 'Username can only contain letters and numbers.';
            } else {
                err.textContent = '';
            }
        }

        function validateEmail(formType) {
            const err = document.getElementById(formType);
            err.textContent = 'Please enter a valid email!';
        }

        function validatePassword(formType) {
            const err = document.getElementById(formType);
            err.textContent = 'Minimum 8 characters required. Number and alphabet required.';
        }

    </script>
</head>

<body>
    <?php
    if (isset($_POST['register'])) {
        include("../config.php");

        $email = $_POST['email'];
        $sql = "select * from tbl_student where email='$email'";
        $result = mysqli_query($con, $sql);
        $count = mysqlI_num_rows($result);

        if ($count > 0) {
            echo "<script>
				alert('There is an existing account associated with this email.');
			</script>";
            echo "<script> location.href='student_login.php'; </script>";
        } else {
            $name = $_POST['name'];
            $usn = $_POST['usn'];
            $class = $_POST['class'];
            $password = $_POST['password'];
            $conPassword = $_POST['conPassword'];

            if (!preg_match('/^[A-Za-z\s]+$/', $name)) {
                echo "<script>alert('Only alphabets & spaces are allowed!')";
                echo "<script>window.location.href='student_login.php';</script>";
            }
            if (!preg_match('/^[a-zA-Z0-9]+$/', $usn)) {
                echo "<script>alert('USN can only contain letters and numbers.')";
                echo "<script>window.location.href='student_login.php';</script>";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Invalid email format');</script>";
                echo "<script>location.href='student_login.php';</script>";
            }
            if ($password !== $conPassword) {
                echo "<script>alert('Password Does not match!');</script>";
                echo "<script> location.href='student_login.php'; </script>";
            }
            $query = "INSERT INTO tbl_student(name,usn,class,email,password) VALUES('" . $name . "','" . $usn . "','" . $class . "','" . $email . "','" . $password . "')";
            mysqli_query($con, $query);
            echo "<script>alert('Registeration Completed, Please Login.');</script>";
            echo "<script> location.href='student_login.php'; </script>";
        }
    }
    ?>

    <?php
    if (isset($_POST['login'])) {
        include("../config.php");

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "select * from tbl_student where email='" . $email . "' and password='" . $password . "'";
        $result = mysqli_query($con, $sql);
        $count = mysqlI_num_rows($result);

        if ($count > 0) {
            $row = mysqli_fetch_assoc($result);
            $usn = $row['usn'];
            $_SESSION["student_login"] = true;
            $_SESSION['usn'] = $usn;
            $a = $_SESSION['student'];
            echo "<script>alert('Login Success');</script>";
            echo "<script> location.href='marks_detail.php'; </script>";
        } else {
            echo "<script>
				alert('Invalid Email or Password');
			</script>";
        }
    }
    ?>
    <div class="container" id="loginForm">
        <h2>Student Login</h2>
        <form action="#" method="post">
            <input type="email" id="email" name="email" placeholder="Email" required
                oninput="validateEmail('loginFormType')">
            <input type="password" id="password" name="password" placeholder="Password" required
                oninput="validatePassword('loginFormType')">
            <button type="submit" name="login">Login</button>
            <p id="loginFormType" style="color:red;"></p>
        </form>

        <p class="switch-form">Don't have an account? <a href="#" id="switchToReg">Register here</a></p>
    </div>

    <div class="container" style="display: none;" id="registrationForm">
        <h2>Registration</h2>
        <form action="#" method="post">
            <input type="text" id="fullname" name="name" placeholder="Name" required
                oninput="validateFullname('regFormType')">
            <input type="text" id="usn" name="usn" placeholder="USN" required oninput="validateUsername('regFormType')">
            <input type="text" id="class" name="class" placeholder="Class" required>
            <input type="email" id="email" name="email" placeholder="Email" required
                oninput="validateEmail('regFormType')">
            <input type="password" id="password" name="password" placeholder="Password" required
                oninput="validatePassword('regFormType')">
            <input type="password" id="confirm" name="conPassword" placeholder="Confirm Password" required>
            <button type="submit" name="register">Register</button>
            <p id="regFormType" style="color:red;"></p>
        </form>

        <p class="switch-form">Already have an account? <a href="#" id="switchToLogin">Login here</a></p>
    </div>
    <script>
        document.getElementById('switchToReg').addEventListener('click', function () {
            document.getElementById('registrationForm').style.display = 'block';
            document.getElementById('loginForm').style.display = 'none';
        });

        document.getElementById('switchToLogin').addEventListener('click', function () {
            document.getElementById('registrationForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        });
    </script>
</body>

</html>