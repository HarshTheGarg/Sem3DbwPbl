<html lang="en">
<head>
    <title>
        Add Patient
    </title>
    <link rel="stylesheet" href="../index.css">

</head>
<body>
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
?>

<header>
    <a href="http://localhost/dbw/project">HospMan</a>
</header>
<main>
<table>
    <tr>
        <th>Patient Id</th>
        <th>Patient Name</th>
        <th>Room No</th>
        <th>Doctors</th>
        <th>Treatment(s)</th>
    </tr>
    <?php
        $ids = mysqli_query($con, "select * from patient where dateDischarged is null and roomId is not null order by patientId");
        while ($row = mysqli_fetch_array($ids))
        {
            echo "<tr>";
            echo "<td>$row[patientId]</td>";
            echo "<td>$row[firstName] $row[lastName]</td>";
            echo "<td>$row[roomId]</td>";
            echo "<td><ul>";
            $res = mysqli_query($con, "select firstName, lastName from attends, employee where attends.patientId=$row[patientId] and attends.docId=employee.employeeId");
            while ($doc = mysqli_fetch_array($res))
            {
                echo "<li>$doc[firstName] $doc[lastName]</li>";
            }
            echo "</td>";

            echo "<td><ul>";
            $res = mysqli_query($con, "select treatment.name from billed, treatment where billed.patientId=$row[patientId] and billed.treatmentId=treatment.treatmentId");
            while ($doc = mysqli_fetch_array($res))
            {
                echo "<li>$doc[name]</li>";
            }
            echo "</td>";


            echo "</tr>";
        }
    ?>
</table>
</main>
</body>
</html>
