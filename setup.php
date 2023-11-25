<html lang="en">
<head>
    <title>
        Connecting...
    </title>
</head>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$pass = "password 3";
$con = mysqli_connect($host, $user, $pass);

if ( !$con or mysqli_connect_errno() ) {
    echo "Some error! < /br> </br>";
    header("Location: http://localhost/dbw/project/index.php?connected=false");
} else {
    echo "Connected!";
    function test ()
    {
        echo "HERE";
    }

    function execute ($query)
    {
        global $con;
        mysqli_query($con, $query);
    }

    //TODO Remove from Final
    $dropDB = "Drop database if exists project";
    execute($dropDB);

    $createDb = "create database if not exists project";
    execute($createDb);

    $useDb = "use project";
    execute($useDb);

    $createRoom = "create table room (
    roomId int,
    roomType varchar(20),
    constraint roomPK primary key (roomId)
)";
    execute($createRoom);

    $createPatient = "create table if not exists patient (
    patientId int,
    firstName varchar(30),
    lastName varchar(30),
    sex char,
    age int,
    addressLine1 varchar(50),
    addressLine2 varchar(50),
    city varchar(40),
    state varchar(40),
    zipCode varchar(6),
    country varchar(20),
    dateAdmitted date,
    dateDischarged date,
    roomId int,
    constraint patientPK primary key (patientId),
    constraint patientToRoomFK foreign key (roomId) references room(roomId)
)";
    execute($createPatient);

    $createPhone = "create table if not exists patPhone (
    patientId int,
    number varchar(10),
    constraint phoneToPatientFK foreign key (patientId) references patient (patientId),
    constraint phonePK primary key (patientId, number)
)";
    execute($createPhone);

    $createMed = "create table if not exists medicine (
    medId int,
    name varchar(30),
    description varchar(50),
    price decimal(8, 2),
    constraint medicinePK primary key (medId)
)";
    execute($createMed);


    $createEquipment = "create table if not exists equipment (
    equipId int,
    name varchar(30),
    description varchar(50),
    price decimal (8, 2),
    constraint equipmentPK primary key (equipId)
)";
    execute($createEquipment);


    $createTreatment = "create table if not exists treatment (
    treatmentId int,
    name varchar(30),
    constraint treatmentPK primary key (treatmentId)
)";
    execute($createTreatment);

    $createMedRequired = "create table if not exists medsReq (
    treatmentId int,
    medId int,
    constraint primary key (treatmentId, medId),
    constraint medsReqToTreatmentFK foreign key (treatmentId) references treatment(treatmentId),
    constraint medsReqToEquipmentFK foreign key (medId) references medicine(medId)
)";
    execute($createMedRequired);


    $createEquipRequired = "create table if not exists equipsReq (
    treatmentId int,
    equipId int,
    constraint primary key (treatmentId, equipId),
    constraint equipsReqToTreatmentFK foreign key (treatmentId) references treatment(treatmentId),
    constraint equipsReqToEquipmentFK foreign key (equipId) references equipment(equipId)
)";
    execute($createEquipRequired);


    $createBilled = "create table if not exists billed (
    treatmentId int,
    patientId int,
    constraint primary key (patientId, treatmentId),
    constraint billedToPatientFK foreign key (patientId) references patient (patientId),
    constraint billedToTreatmentFK foreign key (treatmentId) references treatment (treatmentId) 
)";
    execute($createBilled);


    $createEmployee = "create table if not exists employee (
    employeeId int,
    firstName varchar(30),
    lastName varchar(30),
    salary decimal(8, 2),
    qualification varchar(50),
    sex char,
    age int,
    experience int,
    constraint primary key (employeeId)
)";
    execute($createEmployee);

    $createEmpPhone = "create table if not exists empPhone (
    employeeId int,
    number varchar(10),
    constraint primary key (employeeId, number),
    constraint empPhoneToEmployeeFK foreign key (employeeId) references employee(employeeId)
)";
    execute($createEmpPhone);

    $createDoc = "create table if not exists doctor (
    docId int,
    constraint primary key (docId),
    constraint doctorToEmployeeFK foreign key (docId) references employee (employeeId)
)";
    execute($createDoc);


    $createVisiting = "create table if not exists visiting (
    visId int,
    constraint primary key (visId),
    constraint visitingToDoctorFK foreign key (visId) references doctor (docId)
)";
    execute($createVisiting);

    $createPermanent = "create table if not exists permanent (
    permId int,
    constraint primary key (permId),
    constraint permanentToDoctorFK foreign key (permId) references doctor (docId)
)";
    execute($createPermanent);

    $createTrainee = "create table if not exists trainee (
    trainId int,
    constraint primary key (trainId),
    constraint traineeToDoctorFK foreign key (trainId) references doctor (docId)
)";
    execute($createTrainee);

    $createAttends = "create table if not exists attends (
    patientId int,
    docId int,
    constraint primary key (patientId, docId),
    constraint attendsToPatientFK foreign key (patientId) references patient(patientId),
    constraint attendsToDoctorFK foreign key (docId) references doctor(docId)
)";
    execute($createAttends);


    $createHelpingStaff = "create table if not exists helpingStaff (
    staffId int,
    constraint primary key (staffId),
    constraint helpingStaffToEmployeeFK foreign key (staffId) references employee(employeeId)
)";
    execute($createHelpingStaff);


    $createJanitor = "create table if not exists janitor (
    janitorId int,
    constraint primary key (janitorId),
    constraint janitorToHelpingStaffFK foreign key (janitorId) references helpingStaff (staffId)
)";
    execute($createJanitor);

    $createNurse = "create table if not exists nurse (
    nurseId int,
    constraint primary key (nurseId),
    constraint nurseToHelpingStaffFK foreign key (nurseId) references helpingStaff (staffId)
)";
    execute($createNurse);


    $createGoverns = "create table if not exists governs (
    roomId int,
    nurseId int,
    constraint primary key (roomId, nurseId),
    constraint governsToNurseFK foreign key (nurseId) references nurse(nurseId),
    constraint governsToRoomFK foreign key (roomId) references room(roomId)
)";
    execute($createGoverns);


    $createClean = "create table if not exists cleans (
    roomId int,
    janitorId int,
    constraint primary key (roomId, janitorId),
    constraint cleansToJanitorFK foreign key (janitorId) references janitor(janitorId)
)";
    execute($createClean);

    mysqli_close($con);

    header("Location: http://localhost/dbw/project/index.php?connected=true");
}
die();
?>
</html>
