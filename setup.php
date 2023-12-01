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
    function execute ($query)
    {
        global $con;
        mysqli_query($con, $query);
    }

    //TODO Remove from Final
//    $dropDB = "Drop database if exists project";
//    execute($dropDB);

    $createDb = "create database if not exists project";
    execute($createDb);

    $useDb = "use project";
    execute($useDb);

    $createRoom = "create table if not exists room (
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
    description varchar(50),
    price decimal(8, 2),
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
    sex char,
    age int,
    constraint primary key (employeeId)
)";
    execute($createEmployee);

    $createDoc = "create table if not exists doctor (
    docId int,
    constraint primary key (docId),
    qualification varchar(50),
    experience int,
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


    execute("drop procedure if exists addDoc");
    $createProcAddDoc = "create procedure if not exists addDoc(fname varchar(30), lname varchar(30),
    sal decimal(8, 2), qual varchar(50), sex char, age int, exp int, type char)
    begin
    
    declare id int;
    select getLastDocId() into id;
    set id = id+1;
    insert into employee(employeeId, firstName, lastName, salary, sex, age) 
    values (id, fname, lname, sal, sex, age);
    insert into doctor(docId, qualification, experience) values (id, qual, exp);
        
    if type='v' then
    insert into visiting values (id);
    elseif type='t' then
    insert into trainee values (id);
    elseif type='p' then 
    insert into permanent values (id);
    end if;
    end ;
    ";

    execute($createProcAddDoc);


    execute("drop function if exists checkEmpExists");
    $createProcCheckEmp = "create function if not exists checkEmpExists(empid int)
    returns int
    deterministic
    begin
    declare ans int default 0;
    select count(*) into ans from employee where employeeId=empid;
    return (ans);
    end;";
    execute($createProcCheckEmp);

    execute("drop procedure if exists deleteDoc");
    $createProcDelDoc = "create procedure if not exists deleteDoc(empid int)
    begin
    delete from visiting where visId=empid;
    delete from trainee where trainId=empid;
    delete from permanent where permId=empid;
    delete from doctor where docId=empid;
    delete from employee where employeeId=empid;
    end;
    ";
    execute($createProcDelDoc);



    execute("drop procedure if exists addHs");
    $createProcAddHs = "create procedure if not exists addHs(fname varchar(30), lname varchar(30),
    sal decimal(8, 2), sex char, age int, type char)
    begin
    
    declare id int;
    select getLastHsId() into id;
    set id = id + 1;
    
    insert into employee(employeeId, firstName, lastName, salary, sex, age) 
    values (id, fname, lname, sal, sex, age);
    
    insert into helpingStaff values (id);
        
    if type='j' then
    insert into janitor values (id);
    elseif type='n' then
    insert into nurse values (id);
    end if;
    end ;
    ";

    execute($createProcAddHs);

    execute("drop procedure if exists deleteHs");
    $createProcDelHs = "create procedure if not exists deleteHs(empid int)
    begin
    delete from janitor where janitorId=empid;
    delete from nurse where nurseId=empid;
    delete from helpingStaff where staffId=empid;
    delete from employee where employeeId=empid;
    end;
    ";
    execute($createProcDelHs);


    execute("drop procedure if exists addRoomGov");
    execute("drop procedure if exists addRoomJan");
    $createProcAddRoomJan = "create procedure if not exists addRoomGov(roomid int, govid int)
    begin
    insert into governs(roomId, nurseId) values (roomid, govid);
    end;
    ";
    execute($createProcAddRoomJan);

    $createProcAddRoomJan = "create procedure if not exists addRoomJan(roomid int, janid int)
    begin
    insert into cleans(roomId, janitorId) values (roomid, janid);
    end;
    ";
    execute($createProcAddRoomJan);

    execute("drop procedure if exists getLastPatId");
    $createFuncGetLastPatId = "create function if not exists getLastPatId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(patientId) into ans from patient;
    return ans;
    end;";
    execute($createFuncGetLastPatId);

    execute("drop procedure if exists addPat");
    $createProcAddPat = "create procedure if not exists addPat(fname varchar(20), lname varchar(20), 
    sex char, age int, al1 varchar(50), al2 varchar(50), city varchar(40), s varchar(40), 
    zip varchar(6), cou varchar(20), doa date)
    begin
    declare id int;
    select getLastPatId() into id;
    if isnull(id) then
    set id = 1;
    else
    set id = id + 1;
    end if;
    
    insert into patient(patientId, firstName, lastName, sex, age, addressLine1, 
    addressLine2, city, state, zipCode, country, dateAdmitted) values (
    id, fname, lname, sex, age, al1, al2, city, s, zip, cou, doa);
    
    end;
    ";
    execute($createProcAddPat);

    execute("drop procedure if exists assignPatDoc");
    $createProcAssignPatDoc = "create procedure if not exists assignPatDoc(pat int, doc int)
    begin
    insert into attends(patientId, docId) values (pat, doc);
    end;
    ";
    execute($createProcAssignPatDoc);

    execute("drop procedure if exists assignPatRoom");
    $createProcAssignPatRoom = "create procedure if not exists assignPatRoom(pat int, room int)
    begin
    update patient set roomId=room where patientId=pat;
    end;
    ";
    execute($createProcAssignPatRoom);

    execute("drop procedure if exists assignPatTreatment");
    $createProcAssignPatTreatment = "create procedure if not exists assignPatTreatment(pat int, treat int)
    begin
    insert into billed(patientId, treatmentId) values (pat, treat);
    end;
    ";
    execute($createProcAssignPatTreatment);


    execute("drop procedure if exists getLastDocId");
    $createFuncGetLastDocId = "create function if not exists getLastDocId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(docId) into ans from doctor;
    if isnull(ans) then
    set ans = 1000;
    end if;
    return ans;
    end;";
    execute($createFuncGetLastDocId);


    execute("drop procedure if exists getLastHsId");
    $createFuncGetLastHsId = "create function if not exists getLastHsId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(staffId) into ans from helpingStaff;
    if isnull(ans) then
    set ans = 5000;
    end if;
    return ans;
    end;";
    execute($createFuncGetLastHsId);

    execute("drop procedure if exists getLastRoomId");
    $createFuncGetLastRoomId = "create function if not exists getLastRoomId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(roomId) into ans from room;
    if isnull(ans) then
    set ans = 100;
    end if;
    return ans;
    end;";
    execute($createFuncGetLastRoomId);

    execute("drop procedure if exists getNextRoomId");
    $createFuncGetNextRoomId = "create function if not exists getNextRoomId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(roomId) into ans from room;
    if isnull(ans) then
    set ans = 100;
    end if;
    set ans = ans + 1;
    return ans;
    end;";
    execute($createFuncGetNextRoomId);

    execute("drop procedure if exists getNextMedId");
    $createFuncGetNextMedId = "create function if not exists getNextMedId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(medId) into ans from medicine;
    if isnull(ans) then
    set ans = 200;
    end if;
    set ans = ans + 1;
    return ans;
    end;";
    execute($createFuncGetNextMedId);

    execute("drop procedure if exists getNextEquipId");
    $createFuncGetNextEquipId = "create function if not exists getNextEquipId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(equipId) into ans from equipment;
    if isnull(ans) then
    set ans = 500;
    end if;
    set ans = ans + 1;
    return ans;
    end;";
    execute($createFuncGetNextEquipId);

    execute("drop procedure if exists getNextTreatmentId");
    $createFuncGetNextTreatmentId = "create function if not exists getNextTreatmentId()
    returns int
    deterministic
    begin
    declare ans int default 0;
    select max(treatmentId) into ans from treatment;
    if isnull(ans) then
    set ans = 100;
    end if;
    set ans = ans + 1;
    return ans;
    end;";
    execute($createFuncGetNextTreatmentId);


    mysqli_close($con);

    header("Location: http://localhost/dbw/project/index.php?connected=true");
}
die();
?>
</html>
