<!DOCTYPE html>
<?php
include("../config.php");
session_start();
if (empty($_SESSION["admin_login"]) || $_SESSION["admin_login"] !== true) {
  header("Location: admin_login.php");
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

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
      background-color: #f8f8f8;
    }


    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      width: 17%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition-duration: 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #3d8b3d;
    }

    button {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition-duration: 0.3s;

    }

    button:hover {
      background-color: #3d8b3d;
    }

    .student-list-container {
      width: 80%;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .student-list-item {
      margin-bottom: 10px;
      padding: 15px 20px;
      background-color: #f8f8f8;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin-bottom: 10px;
      padding: 10px;
      background-color: #f8f8f8;
      border-radius: 5px;
    }
  </style>
</head>

<body>

  <?php
  include("../config.php");
  if (isset($_POST['add_student'])) {
    $usn = $_POST['usn'];
    $dsa = $_POST['dsa'];
    $adbs = $_POST['adbs'];
    $coa = $_POST['coa'];
    $mfca = $_POST['mfca'];
    $set = $_POST['set'];
    $rmpe = $_POST['rmpe'];
    $total = $dsa + $adbs + $coa + $mfca + $set + $rmpe;


    $sql = "SELECT * FROM tbl_student_marks WHERE usn='$usn'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
      $updateSql = "UPDATE tbl_student_marks SET DSA = $dsa, ADBS = $adbs, COA = $coa, MFCA = $mfca, SETT = $set, RMPE = $rmpe, total = $total WHERE usn = '$usn'";

      if (mysqli_query($con, $updateSql)) {
        echo "<script>alert('Student marks updated successfully!');</script>";
      } else {
        echo "<script>alert('Error updating student marks: " . mysqli_error($con) . "');</script>";
      }
    } else {
      $query = "INSERT INTO tbl_student_marks(usn,DSA,ADBS,COA,MFCA,SETT,RMPE,total) VALUES('" . $usn . "','" . $dsa . "','" . $adbs . "','" . $coa . "','" . $mfca . "','" . $set . "','" . $rmpe . "','" . $total . "')";
      mysqli_query($con, $query) or die(mysqli_error($con));
      echo "<script>
              alert('Student marks submitted successfully!');
          </script>";
      echo "<script> location.href='marks_detail_admin.php'; </script>";
    }
  }
  ?>

  <header>
    <h1>Student Marks Card</h1>
    <svg style="cursor: pointer;" onclick="window.location.href='../logout.php'" xmlns="http://www.w3.org/2000/svg" height="26" width="26" viewBox="0 0 512 512">
      <!-- LOGOUT ICON -->
      <path fill="white" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
    </svg>
  </header>

  <div class="container">
    <?php
    if (isset($_POST["view_students_list"]) || isset($_POST['sortOption'])) {

      $sortOption = isset($_POST['sortOption']) ? $_POST['sortOption'] : 'name';
      $sql = "SELECT * FROM tbl_student ORDER BY $sortOption";
      $result = mysqli_query($con, $sql);
      $i = 0;
      $count = mysqli_num_rows($result);
    ?>
      <div style="display: flex; align-items:center; justify-content:start; gap:1rem;">
        <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" onclick="window.location.href='marks_detail_admin.php'" height="25" width="25" viewBox="0 0 512 512">
          <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288 480 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-370.7 0 73.4-73.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-128 128z" />
        </svg>
        <h2>Student List</h2>
        <form action="" method="post" id="sortForm">
          <input type="hidden" name="view_students_list" value=1>
          <select name="sortOption" id="sortOption" onchange="document.getElementById('sortForm').submit();" style="padding: 8px; margin-right: 10px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer;">
            <option value="name" <?php echo ($sortOption == 'name') ? 'selected' : ''; ?>>Name</option>
            <option value="usn" <?php echo ($sortOption == 'usn') ? 'selected' : ''; ?>>USN</option>
          </select>
        </form>
      </div>
      <div class="container student-list-container">
        <ul>
          <?php
          if ($count > 0) {
            while ($row = mysqli_fetch_assoc($result)) :
              $i = $i + 1; ?>
              <li class="student-list-item">
                <div>
                  <strong>
                    <?php echo $i; ?>.
                  </strong><br><strong>Name:</strong>
                  <?php echo $row['name']; ?><br>
                  <strong>Roll Number:</strong>
                  <?php echo $row['usn']; ?>
                </div>
                <div style="display:flex; align-items:center; gap: 2rem;">
                  <a href="marks_detail_admin.php?usn=<?php echo $row['usn']; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                      <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                    </svg>
                  </a>
                  <a href="../delete_student.php?usn=<?php echo $row['usn']; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                      <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                    </svg>
                  </a>
                </div>

              </li>
            <?php endwhile;
          } else {
            ?>
            <strong>
              No students have registered yet!
            </strong>
          <?php
          }
          ?>
        </ul>
      </div>
    <?php
    }
    if (!isset($_POST["view_students_list"]) || isset($_GET["usn"])) {
      $usn = "";
      $dsa = "";
      $adbs = "";
      $coa = "";
      $mfca = "";
      $set = "";
      $rmpe = "";

      if (isset($_GET["usn"])) {
        $usn = $_GET["usn"];
        $sql2 = "SELECT * FROM tbl_student_marks WHERE usn='$usn'";
        $result2 = mysqli_query($con, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $usn = $_GET["usn"];
        $dsa = $row2["DSA"] ?? '';
        $adbs = $row2["ADBS"] ?? '';
        $coa = $row2["COA"] ?? '';
        $mfca = $row2["MFCA"] ?? '';
        $set = $row2["SETT"] ?? '';
        $rmpe = $row2["RMPE"] ?? '';
      }
    ?>
      <div style="display: flex; align-items:center; justify-content:start; gap:1rem;">
        <h2>Student Information</h2>
      </div>
      <form action="marks_detail_admin.php" method="post">
        <button name="view_students_list">View Student List</button>
      </form>
      <form action="marks_detail_admin.php" method="post">
        <p><strong>Student USN : <input type="text" name="usn" value="<?php echo $usn ?>"></strong></p>
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
              <td><input type="number" name="dsa" value="<?php echo $dsa ?>"></td>
            </tr>
            <tr>
              <td>ADBS</td>
              <td><input type="number" name="adbs" value="<?php echo $adbs ?>"></td>
            </tr>
            <tr>
              <td>COA</td>
              <td><input type="number" name="coa" value="<?php echo $coa ?>"></td>
            </tr>
            <tr>
              <td>MFCA</td>
              <td><input type="number" name="mfca" value="<?php echo $mfca ?>"></td>
            </tr>
            <tr>
              <td>SET</td>
              <td><input type="number" name="set" value="<?php echo $set ?>"></td>
            </tr>
            <tr>
              <td>RMPE</td>
              <td><input type="number" name="rmpe" value="<?php echo $rmpe ?>"></td>
            </tr>
          </tbody>
        </table>
        <div style="display:flex;flex-direction:column;align-items: center;justify-content: center; padding: 1rem;">
          <input type="submit" name="add_student" value="Submit">
        </div>
      </form>
    <?php
    }
    ?>
  </div>

</body>

</html>