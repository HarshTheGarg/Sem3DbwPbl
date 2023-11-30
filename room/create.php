<html lang="en">
<head>
    <title>
        Add Doctor
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
    HospMan
</header>
<form action="#" method="get" onsubmit="validate(event)">
    <div class="roomIdG inGroup">
        <label for="roomId">Room Id</label>
        <input type="number" min="0" id="roomId" name="roomId" value="444">
    </div>

    <div class="roomTypeG inGroup">
        <label for="roomType">Room Type</label>
        <select name="type" id="roomType">
            <option value="sr">Single Room</option>
            <option value="ts">Twin Sharing</option>
            <option value="ir">Isolation Room</option>
            <option value="mc">Maternity Care</option>
            <option value="icu">Intensive care unit</option>
            <option value="dc">Day Care</option>
        </select>
    </div>

    <div class="cleanG inGroup">
        <label for="clean">Cleaned by</label>

        <?php
            $ids = mysqli_query($con, "select * from janitor");

            while ($row = mysqli_fetch_array($ids))
            {
                echo "<label for='$row[janitorId]'>$row[janitorId]</label>";
                echo "<input type='checkbox' name='clean[]' id='$row[janitorId]' value='$row[janitorId]'>";
            }
        ?>
    </div>

    <div class="governG inGroup">
        <label for="govern">Governed By</label>
        <?php
            $ids = mysqli_query($con, "select * from nurse");

            while ($row = mysqli_fetch_array($ids))
            {
                echo "<label for='$row[nurseId]'>$row[nurseId]</label>";
                echo "<input type='checkbox' name='govern[]' id='$row[nurseId]' value='$row[nurseId]'>";
            }
        ?>
    </div>

    <input type="submit" value="Add" name="add">

</form>

<div class="error"></div>

<script>
    function validate(e) {
        let govlis = document.getElementsByName("govern[]");
        let flag = false;
        for (let i =0 ; i <govlis.length; i++)
        {
            if (govlis[i].checked)
            {
                flag = true;
                break;
            }
        }

        if (!flag)
        {
            setError("Select At least one nurse");
            e.preventDefault();
        }


        let cleanlis = document.getElementsByName("clean[]");
        flag = false;
        for (let i =0 ; i <cleanlis.length; i++)
        {
            if (cleanlis[i].checked)
            {
                flag = true;
                break;
            }
        }

        if (!flag)
        {
            setError("Select At least one Janitor");
            e.preventDefault();
        }
    }


    function setError(er) {
        let error = document.querySelector(".error");
        error.innerHTML = er;
    }
</script>

<?php
    if (isset($_GET['add']))
    {

//            $exists = mysqli_query($con, "select checkEmpExists($_GET[empId]) as res");
//            while ($row = mysqli_fetch_array($exists))
//            {
//                echo "$row{res}";
//            }
//            echo $exists;
        $exists = 0;
        if ($exists == 0)
        {
            $quer = "insert into room(roomId, roomType) values($_GET[roomId], '$_GET[type]')";
            mysqli_query($con, $quer);

            $govList = $_GET['govern'];
            foreach ($govList as $gov)
            {
                $quer = "call addRoomGov($_GET[roomId], $gov)";
                mysqli_query($con, $quer);
//                echo $gov;
            }

            $cleanList = $_GET['clean'];
            foreach ($cleanList as $jan)
            {
                mysqli_query($con, "call addRoomJan($_GET[roomId], $jan)");
            }

            header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully added a room!");
//            if (mysqli_query($con, $quer)){
//            }
        }
        else {
            echo "<script>setError('ID already exists!')</script>";
        }
    }
?>
</body>
</html>
