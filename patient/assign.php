<html lang="en">
<head>
    <title>
        Add Patient
    </title>
    <link rel="stylesheet" href="../style/index.css">

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
<form action="#" method="get" onsubmit="validate(event);">
    <div class="patG inGroup">
        <label for="selection">Select patient to assign</label>
        <select name="patid" id="selection">
            <?php
                $ids = mysqli_query($con, "select * from patient where dateDischarged is null and roomId is null");
                while ($row = mysqli_fetch_array($ids))
                {
                    echo "<option value='$row[patientId]'>$row[patientId] - $row[firstName] $row[lastName]</option>";
                }
            ?>
        </select>
    </div>

    <div class="doctorsG inGroup">
        <label for="doctor">Doctors: </label>
        <?php
            $ids = mysqli_query($con, "select * from doctor, employee where docId=employee.employeeId");
            while ($row = mysqli_fetch_array($ids))
            {
                echo "<label for='$row[docId]'>$row[docId] - $row[firstName] $row[lastName]</label>";
                echo "<input type='checkbox' name='doc[]' value='$row[docId]' id='$row[docId]'>";
            }
        ?>
    </div>

    <div class="treatmentG inGroup">
        <label for="treatment">Treatments: </label>
        <?php
            $ids = mysqli_query($con, "select * from treatment");
            while ($row = mysqli_fetch_array($ids))
            {
                echo "<label for='$row[treatmentId]'>$row[treatmentId] - $row[name]</label>";
                echo "<input type='checkbox' name='treatment[]' value='$row[treatmentId]' id='$row[treatmentId]'>";
            }
        ?>
    </div>

    <div class="roomG inGroup">
        <label for="room">Room: </label>
        <?php
            $ids = mysqli_query($con, "select * from room");
            while ($row = mysqli_fetch_array($ids))
            {
                echo "<label for='$row[roomId]'>$row[roomId] - $row[roomType]</label>";
                echo "<input type='radio' name='room' value='$row[roomId]' id='$row[roomId]'>";
            }
        ?>
    </div>

    <input type="submit" value="Assign" name="assign">

</form>

<div class="error"></div>

<script>
    function validate(e) {
        let doclis = document.getElementsByName("doc[]");
        let flag = false;
        for (let i = 0; i < doclis.length; i++) {
            if (doclis[i].checked) {
                flag = true;
                break;
            }
        }

        if (!flag) {
            setError("Select At least one doctor");
            e.preventDefault();
        }


        let treatmentlis = document.getElementsByName("treatment[]");
        flag = false;
        for (let i = 0; i < treatmentlis.length; i++) {
            if (treatmentlis[i].checked) {
                flag = true;
                break;
            }
        }

        if (!flag) {
            setError("Select At least one Treatment");
            e.preventDefault();
        }

        let $room = document.querySelector('input[name="room"]:checked');
        // console.log($room);

        if (!$room){
            setError("Please select a room!");
            e.preventDefault();
        }
    }

    function setError(er) {
        let error = document.querySelector(".error");
        error.innerHTML = er;
    }
</script>

<?php
    if (isset($_GET['assign']))
    {
        $exists = 0;
        if ($exists == 0)
        {
            foreach ($_GET['doc'] as $doc) {
                $quer = "call assignPatDoc($_GET[patid], $doc)";
                mysqli_query($con, $quer);
            }

            foreach ($_GET['treatment'] as $treatmentid) {
                $quer = "call assignPatTreatment($_GET[patid], $treatmentid)";
                mysqli_query($con, $quer);
            }

            $quer = "call assignPatRoom($_GET[patid], $_GET[room])";
//            echo $quer;
            mysqli_query($con,$quer);

            header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Assigning successful!");

        }
    }
?>
</body>
</html>
