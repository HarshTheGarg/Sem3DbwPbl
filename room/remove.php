<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remove doctor</title>
    <link href="../index.css" rel="stylesheet">
</head>
<body>
<header>
    <a href="http://localhost/dbw/project">HospMan</a>
</header>
<main>
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

            $ids = mysqli_query($con, "select * from doctor");

            while ($row = mysqli_fetch_array($ids))
            {
                echo "<option value='$row[docId]'>$row[docId]</option>";
            }
        ?>
    </select>
    <input type="submit" value="delete" name="delete">
</form>
</main>
<?php
if (isset($_GET['delete'])){
    $ques = "call deleteDoc($_GET[empid])";
    echo $ques;
    $res = mysqli_query($con, $ques);
    header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully deleted a doctor!");

}
?>
</body>
</html>