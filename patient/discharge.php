<html lang="en">
<head>
    <title>
        Add Patient
    </title>
    <link rel="stylesheet" href="../style/index.css">

</head>
<body>

<header>
    <a href="http://localhost/dbw/project">HospMan</a>
</header>
<form action="#" method="get" onsubmit="validate(event);">

    <label for="selection">Select patient to discharge</label>
    <select name="patid" id="selection">
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

        $ids = mysqli_query($con, "select * from patient where dateDischarged is null");

        while ($row = mysqli_fetch_array($ids))
        {
            echo "<option value='$row[patientId]'>$row[patientId] - $row[firstName] $row[lastName]</option>";
        }
        ?>
    </select>
    
    <input type="submit" value="Discharge" name="discharge">

</form>

<div class="error"></div>

<script>
    function setError(er) {
        let error = document.querySelector(".error");
        error.innerHTML = er;
    }
</script>

<?php
    if (isset($_GET['discharge']))
    {
        $exists = 0;
        if ($exists == 0)
        {
            $date = date("Y-m-d");
            $quer = "update patient set dateDischarged='$date' where patientId=$_GET[patid]";

            if (mysqli_query($con, $quer)){
                header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully discharged!");
            }
        }
        else {
            echo "<script>setError('ID already exists!')</script>";
        }
    }
?>
</body>
</html>
