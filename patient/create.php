<html lang="en">
<head>
    <title>
        Add Patient
    </title>
    <link rel="stylesheet" href="../index.css">

</head>
<body>

<header>
    <a href="http://localhost/dbw/project">HospMan</a>
</header>
<main>
<form action="#" method="get" onsubmit="validate(event);">
    <div class="name inGroup">
        <div class="fnameG">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname">
        </div>
        <div class="lnameG">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname">
        </div>
    </div>

    <div class="phone1G inGroup">
        <label for="phone1">Phone number: +91</label>
        <input type="number" name="phone1" id="phone1">
    </div>

    <div class="phone2G inGroup">
        <label for="phone2">Alternate number: +91</label>
        <input type="number" name="phone2" id="phone2">
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
    
    <div class="addressG inGroup">
        <div class="addL1">
            <label for="addL1">Address Line 1: </label>
            <input type="text" id="addL1" name="addL1">
        </div>
        <div class="addL2">
            <label for="addL2">Address Line 2: </label>
            <input type="text" id="addL2" name="addL2">
        </div>
        <div class="city">
            <label for="city">City: </label>
            <input type="text" id="city" name="city">
        </div>
        <div class="state">
            <label for="state">State: </label>
            <input type="text" id="state" name="state">
        </div>
        <div class="country">
            <label for="country">Country: </label>
            <input type="text" id="country" name="cou">
        </div>
        <div class="zip">
            <label for="zip">Zip Code: </label>
            <input type="number" id="zip" name="zip">
        </div>
    </div>

    <div class="doa inGroup">
        <label for="doa">Date of Admission</label>
        <input type="date" name="doa" id="doa">
    </div>
    
    <input type="submit" value="Add" name="add">

</form>
<div class="error"></div>
</main>

<script>
    function validate(e)
    {
        let fname = document.querySelector("#fname").value;
        let lname = document.querySelector("#lname").value;
        let sex = document.querySelector("#sex").value;
        let age = document.querySelector("#age").value;
        let addL1 = document.querySelector("#addL1").value;
        let addL2 = document.querySelector("#addL2").value;
        let city = document.querySelector("#city").value;
        let state = document.querySelector("#state").value;
        let country = document.querySelector("#country").value;
        let zip = document.querySelector("#zip").value;
        let doa = document.querySelector("#doa").value;
        let ph1 = document.querySelector("#phone1").value;
        let ph2 = document.querySelector("#phone2").value;

        let error = document.querySelector(".error");
        error.innerHTML = "";

        const re = /^[a-z\s]+$/i;

        // console.log({empid, fname, lname, sal, qual, sex, age, experience, type});
        // console.log({sal});

        if (!(fname && lname && sex && age && addL1 && city && state && country && zip && doa && ph1))
        {
            e.preventDefault();
            setError("Please Fill all the values!");
        }else if (!(re.test(fname) && re.test(lname) && re.test(city) && re.test(state) && re.test(country))) {
            e.preventDefault();
            setError("Please enter correct values");
        } else if (zip.length !== 6 ){
            e.preventDefault();
            setError("Please enter correct zip code");
        } else if (ph1.length !== 10) {
            e.preventDefault();
            setError("Please enter correct phone number");
        } else if (ph2 && ph2.length!== 10) {
            e.preventDefault();
            setError("Please enter correct alternate phone number");
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
                $quer = "call addPat('$_GET[fname]', '$_GET[lname]', '$_GET[sex]', 
                $_GET[age], '$_GET[addL1]', '$_GET[addL2]', '$_GET[city]', '$_GET[state]', 
                '$_GET[zip]', '$_GET[cou]', '$_GET[doa]')";
//                echo $quer;
                mysqli_query($con, $quer);

                $quer = "select getLastPatId() as id";
                $res = mysqli_query($con, $quer);
                $id = 0;

                while ($row = mysqli_fetch_array($res))
                {
                    $id = $row['id'];
                }

                $quer = "insert into patPhone(patientId, number) values ($id, $_GET[phone1])";
                mysqli_query($con, $quer);

                if ($_GET['phone2'] != "") {
                    $quer = "insert into patPhone(patientId, number) values ($id, $_GET[phone2])";
                    mysqli_query($con, $quer);
                }

                if (true){
                    header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully added the patient!");
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
