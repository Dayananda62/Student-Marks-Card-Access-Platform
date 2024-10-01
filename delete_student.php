<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include("config.php");
    if (isset($_GET['usn'])) {
        $usn = $_GET['usn'];
        $sql = "DELETE FROM tbl_student WHERE usn='$usn'";
        $result = mysqli_query($con, $sql);
        header("Location: admin/marks_detail_admin.php");
    } else {
        echo "Something occured";
    }
    ?>
</body>

</html>