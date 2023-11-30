<html lang="en">
<head>
    <title>
        Create Equipment
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
    <div class="equipIdG inGroup">
        <label for="equipId">Equipment Id</label>
        <input type="number" min="0" id="equipId" name="equipId">
    </div>

    <div class="name inGroup">
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
    </div>

    <div class="priceG inGroup">
        <label for="price">Cost</label>
        <input type="text" name="price" id="price">
    </div>

    <div class="descG inGroup">
        <label for="desc">Description</label>
        <input type="text" name="desc" id="desc">
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
        let equipid = document.querySelector("#equipID").value;
        let name = document.querySelector("#name").value;
        let price = document.querySelector("#price").value;
        let desc = document.querySelector("#desc").value;


        const re = /^[a-z\s]+$/i;

        // console.log({empid, fname, lname, sal, qual, sex, age, experience, type});
        // console.log({sal});

        if (!(equipid && name && price && desc))
        {
            e.preventDefault();
            setError("Please Fill all the values!");
        }else if (!re.test(name)) {
            e.preventDefault();
            setError("Please enter correct name");
        }
        else if (isNaN(price)){
            // console.log("Please enter numeric salary");
            e.preventDefault();
            setError("Please enter correct Price");
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
            if ($exists == 0)
            {
                $quer = "insert into equipment(equipId, name, description, price) values ($_GET[equipId], '$_GET[name]', '$_GET[desc]', $_GET[price])";
                echo $quer;
                if (mysqli_query($con, $quer)){
                    header("Location: http://localhost/dbw/project/index.php?connected=true&msg=Successfully added a equipment!");
                }
            }
            else {
                echo "<script>setError('ID already exists!')</script>";
            }
    }
?>
</body>
</html>
