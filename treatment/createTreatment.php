<html lang="en">
<head>
    <title>
        Create Treatment
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
<form action="#" method="get" onsubmit="validate(event);">
    <div class="treatmentIdG inGroup">
        <label for="treatmentId">Treatment Id</label>
        <input type="number" min="0" id="treatmentId" name="treatmentId">
    </div>

    <div class="name inGroup">
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
    </div>

    <div class="descG inGroup">
        <label for="desc">Description</label>
        <input type="text" name="desc" id="desc">
    </div>

    <div class="medG inGroup">
        <label for="med">Medicines Required</label>
        <?php
            $ids = mysqli_query($con, "select * from medicine");

            while ($row = mysqli_fetch_array($ids))
            {
                echo "<label for='$row[medId]'>$row[medId] - $row[name]</label>";
                echo "<input type='checkbox' name='med[]' id='$row[medId]' value='$row[medId]'>";
            }
        ?>
    </div>

    <div class="equipG inGroup">
        <label for="equip">Equipments Required</label>
        <?php
        $ids = mysqli_query($con, "select * from equipment");

        while ($row = mysqli_fetch_array($ids))
        {
            echo "<label for='$row[equipId]'>$row[equipId] - $row[name]</label>";
            echo "<input type='checkbox' name='equip[]' id='$row[equipId]' value='$row[equipId]'>";
        }
        ?>
    </div>

    <input type="submit" value="Add" name="add">

</form>
<div class="error"></div>
</main>

<script>
    let error = document.querySelector(".error");
    function validate(e)
    {
        error.innerHTML = "";
        let treatmentid = document.querySelector("#treatmentID").value;
        let name = document.querySelector("#name").value;
        let desc = document.querySelector("#desc").value;


        const re = /^[a-z\s]+$/i

        // console.log({empid, fname, lname, sal, qual, sex, age, experience, type});
        // console.log({sal});

        if (!(treatmentid && name && desc))
        {
            e.preventDefault();
            setError("Please Fill all the values!");
        }else if (!re.test(name)) {
            e.preventDefault();
            setError(`Please enter correct name`);
        }

        let medlis = document.getElementsByName("med[]");
        let flag = false;
        for (let i =0 ; i <medlis.length; i++)
        {
            if (medlis[i].checked)
            {
                flag = true;
                break;
            }
        }

        if (!flag)
        {
            e.preventDefault();
            setError("Select At least one Medicine");
        }


        let equiplis = document.getElementsByName("equip[]");
        flag = false;
        for (let i =0 ; i <equiplis.length; i++)
        {
            if (equiplis[i].checked)
            {
                flag = true;
                break;
            }
        }

        if (!flag)
        {
            e.preventDefault();
            setError("Select At least one Equipment");
        }
    }

    function setError(er) {
        let error = document.querySelector(".error");
        document.querySelector(".error").style.visibility = "visible";
        error.innerHTML = er;
    }
</script>

<?php
    if (isset($_GET['add']))
    {
            $exists = 0;
            $totPrice =0;
            if ($exists == 0)
            {

                $medList = $_GET['med'];
                foreach ($medList as $med)
                {
                    $quer = "select price from medicine where medId=$med";
                    $res = mysqli_query($con, $quer);

                    while ($row = mysqli_fetch_array($res))
                    {
                        $totPrice += $row['price'];
                    }
                }


                $equipList = $_GET['equip'];
                foreach ($equipList as $equip)
                {
                    $quer = "select price from equipment where equipId=$equip";
                    $res = mysqli_query($con, $quer);

                    while ($row = mysqli_fetch_array($res))
                    {
                        $totPrice += $row['price'];
                    }
                }

                $quer = "insert into treatment(treatmentId, name, description, price) values ($_GET[treatmentId], '$_GET[name]', '$_GET[desc]', $totPrice)";
                echo $quer;
                mysqli_query($con, $quer);

                $medList = $_GET['med'];
                foreach ($medList as $med)
                {
                    $quer = "insert into medsReq (treatmentId, medId) values ($_GET[treatmentId], $med)";
                    echo $quer;
                    mysqli_query($con, $quer);
                }


                $equipList = $_GET['equip'];
                foreach ($equipList as $equip)
                {
                    $quer = "insert into equipsReq (treatmentId, equipId) values ($_GET[treatmentId], $equip)";
                    mysqli_query($con, $quer);
                }

                header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully added a treatment!");
            }
            else {
                echo "<script>setError('ID already exists!')</script>";
            }
    }
?>
</body>
</html>
