<?php
if ( !$_GET['connected'] or $_GET['connected'] == 'false' ) {
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
    HospMan
</header>
<div id="cont">
    <aside>
        <ul class="headers">
            <li>Doctor
                <ul class="options">
                    <li><a href="#">Add Doctor</a></li>
                    <li><a href="#">Remove Doctor</a></li>
                    <li><a href="#">Update Doctor</a></li>
                </ul>
            </li>
            <li>Helping Staff
                <ul class="options">
                    <li><a href="#">Add Helping Staff</a></li>
                    <li><a href="#">Remove Helping Staff</a></li>
                    <li><a href="#">Update Helping Staff</a></li>
                </ul>
            </li>
            <li>Patient
                <ul class="options">
                    <li><a href="#">Add Patient</a></li>
                    <li><a href="#">Remove Patient</a></li>
                    <li><a href="#">Update Patient</a></li>
                </ul>
            </li>
            <li>Room
                <ul class="options">
                    <li><a href="#"></a></li>
                    <li><a href=""></a></li>
                    <li><a href=""></a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <main>
        <h3>Welcome!</h3>
        Please select an option from the side menu to continue :)

    </main>
</div>
</body>
</html>