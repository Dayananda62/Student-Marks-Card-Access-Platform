<!DOCTYPE html>
<?php
session_start();
if (empty($_SESSION["student_login"]) || $_SESSION["student_login"] !== true) {
    header("Location: student_login.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks Card</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    include("../config.php");

    $usn = $_SESSION['usn'];
    $sql = "select * from tbl_student_marks where usn='" . $usn . "'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    $sql1 = "select * from tbl_student where usn='" . $usn . "'";
    $result1 = mysqli_query($con, $sql1);
    $num1 = mysqli_num_rows($result1);
    $row1 = mysqli_fetch_array($result1);
    ?>

    <header>
        <h1>Student Marks Card</h1>
        <svg style="cursor: pointer;" onclick="window.location.href='../logout.php'" xmlns="http://www.w3.org/2000/svg"
            height="26" width="26" viewBox="0 0 512 512">
            <!-- LOGOUT ICON -->
            <path fill="white"
                d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
        </svg>
    </header>

    <?php
    if ($num > 0) {
        ?>
        <div class="container">
            <h2>Student Information</h2>
            <p><strong>Name:</strong>
                <?php echo $row1['name']; ?>
            </p>
            <p><strong>Roll Number:</strong>
                <?php echo $usn; ?>
            </p>

            <h2>Marks</h2>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks Obtained</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>DSA</td>
                        <td>
                            <?php echo $row['DSA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>ADBS</td>
                        <td>
                            <?php echo $row['ADBS']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>COA</td>
                        <td>
                            <?php echo $row['COA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>MFCA</td>
                        <td>
                            <?php echo $row['MFCA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>SET</td>
                        <td>
                            <?php echo $row['SETT']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>RMPE</td>
                        <td>
                            <?php echo $row['RMPE']; ?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="total">Total</td>
                        <td class="total">
                            <?php echo $row['total']; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
    } else {
        ?>
        <div class="container">
            <h2>Marks not updated yet!</h2>
        </div>
        <?php
    }
    ?>
</body>

</html>