<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remove doctor</title><link href="../style/index.css" rel="stylesheet">
</head>
<body>
<header>
    HospMan
</header>
<form action="remove.php" method="get" onsubmit="del(event)">
    <label for="selection">Select Emp Id to remove</label>
    <select name="empid" id="selection">
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            $host = "localhost";
            $user = "root";
            $pass = "password 3";
            $db = "project";
            $con = mysqli_connect($host, $user, $pass, $db);

            if ( !$con or mysqli_connect_errno() ) {
                echo "Some error! < /br> </br>";
                header("Location: http://localhost/dbw/project/index.php?connected=false");
            }

            $ids = mysqli_query($con, "select h.staffId, e.firstName, e.lastName from helpingStaff as h, employee as e where h.staffId=e.employeeId");

            while ($row = mysqli_fetch_array($ids))
            {
                echo "<option value='$row[staffId]'>$row[staffId] - $row[firstName] $row[lastName]</option>";
            }
        ?>
    </select>
    <input type="submit" value="delete" name="delete">
</form>

<?php
if (isset($_GET['delete'])){
    $ques = "call deleteHs($_GET[empid])";
    echo $ques;
    $res = mysqli_query($con, $ques);
    header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully deleted helping Staff!");
}
?>
</body>
</html>