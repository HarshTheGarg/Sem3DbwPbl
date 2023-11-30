<?php
if ( !$_GET['connected'] or $_GET['connected'] == 'false') {
    header("location: http://localhost/dbw/project/setup.php");
}
?>
<html lang="en">
<head>
    <title>Project</title>
    <link href="style/index.css" rel="stylesheet">
</head>
<body>
<header>
    <a href="http://localhost/dbw/project">HospMan</a>
</header>
<div id="cont">
    <aside>
        <ul class="headers">
            <li>Doctor
                <ul class="options">
                    <li><a href="./doctor/create.php">Add Doctor</a></li>
                    <li><a href="./doctor/remove.php">Remove Doctor</a></li>
<!--                    <li><a href="#">Update Doctor</a></li>-->
                </ul>
            </li>
            <li>Helping Staff
                <ul class="options">
                    <li><a href="./hs/create.php">Add Helping Staff</a></li>
                    <li><a href="./hs/remove.php">Remove Helping Staff</a></li>
<!--                    <li><a href="#">Update Helping Staff</a></li>-->
                </ul>
            </li>
            <li>Room
                <ul class="options">
                    <li><a href="./room/create.php">Create Room</a></li>
                    <li><a href=""></a></li>
                    <li><a href="#"></a></li>
                </ul>
            </li>
            <li>Treatment
                <ul class="options">
                    <li><a href="./treatment/createMed.php">Create Medicine</a></li>
                    <li><a href="./treatment/createEquipment.php">Create Equipment</a></li>
                    <li><a href="./treatment/createTreatment.php">Make Treatment</a></li>
                </ul>
            </li>
            <li>Patient
                <ul class="options">
                    <li><a href="./patient/create.php">Add Patient</a></li>
                    <li><a href="./patient/assign.php">Assign</a></li>
                    <li><a href="./patient/discharge.php">Discharge</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <main>
        <h3>Welcome!</h3>
        Please select an option from the side menu to continue :)
        <br>
        <?php
        if (isset($_GET['msg'])) {
            echo $_GET['msg'];
        }
        ?>
    </main>
</div>
</body>
</html>