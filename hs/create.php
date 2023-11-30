<html lang="en">
<head>
    <title>
        Add Helping Staff
    </title>
    <link rel="stylesheet" href="../index.css">

</head>
<body>

<header>
    <a href="http://localhost/dbw/project">HospMan</a>
</header>
<main>
<form action="#" method="get" onsubmit="validate(event);">
    <div class="empIdG inGroup">
        <label for="empId">Employee Id</label>
        <input type="number" min="0" id="empId" name="empId" >
    </div>

    <div class="name inGroup">
        <div class="fnameG">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" >
        </div>
        <div class="lnameG">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" >
        </div>
    </div>

    <div class="salG inGroup">
        <label for="salary">Salary</label>
        <input type="text" name="salary" id="salary">
    </div>

    <div class="sexG inGroup">
        <label for="sex">Sex</label>
        <select name="sex" id="sex">
            <option value="m">Male</option>
            <option value="f">Female</option>
        </select>
    </div>

    <div class="ageG inGroup">
        <label for="age">Age</label>
        <input type="number" name="age" id="age" min="20">
    </div>

    <div class="type inGroup">
        <label for="type">Type</label>
        <select name="type" id="type">
            <option value="n">Nurse</option>
            <option value="j">Janitor</option>
        </select>
    </div>

    <input type="submit" value="Add" name="add">

</form>
<div class="error"></div>
</main>

<script>
    function validate(e)
    {
        let empid = document.querySelector("#empId").value;
        let fname = document.querySelector("#fname").value;
        let lname = document.querySelector("#lname").value;
        let sal = document.querySelector("#salary").value;
        let sex = document.querySelector("#sex").value;
        let age = document.querySelector("#age").value;
        let type = document.querySelector("#type").value;

        let error = document.querySelector(".error");
        error.innerHTML = "";

        const re = /^[a-z]+$/i;
        if (!(empid && fname && lname && sal && sex && age && type))
        {
            e.preventDefault();
            setError("Please Fill all the values!");
        }else if (!re.test(fname) || !re.test(lname)) {
            e.preventDefault();
            setError("Please enter correct name");
        }
        else if (isNaN(sal)){
            e.preventDefault();
            setError("Please enter correct salary");
            // console.log("Please enter numeric salary");
        }
    }

    function setError(er) {
        document.querySelector(".error").style.visibility = "visible";
        let error = document.querySelector(".error");
        error.innerHTML = er;
    }
</script>

<?php
    if (isset($_GET['add']))
    {
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
        } else {
//            $exists = mysqli_query($con, "select checkEmpExists($_GET[empId]) as res");
//            while ($row = mysqli_fetch_array($exists))
//            {
//                echo "$row{res}";
//            }
//            echo $exists;
            $exists = 0;
            if ($exists == 0)
            {
                $quer = "call addHs($_GET[empId], '$_GET[fname]', 
                '$_GET[lname]', $_GET[salary], '$_GET[sex]',
                 $_GET[age], '$_GET[type]')";
                if (mysqli_query($con, $quer)){
                    header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully added a Helping staff!");
                }
            }
            else {
                echo "<script>setError('ID already exists!')</script>";
            }

        }
    }
?>
</body>
</html>
