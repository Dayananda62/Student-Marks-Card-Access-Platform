<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #ecf0f1;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #fff; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
        }

        h1 {
            color: #333;
        }

        .buttons-container {
            margin-top: 20px;
        }

        .login-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 20px;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Student Portal</h1>
        <div class="buttons-container">
            <a href="admin/admin_login.php" class="login-button">Admin Login</a>
            <a href="student/student_login.php" class="login-button">Student Login</a>
        </div>
    </div>
</body>
</html>
