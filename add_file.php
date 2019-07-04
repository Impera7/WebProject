<!DOCTYPE html>
<html lang="bg">
<head>
    <title>
        Курсов проект по Уеб Технологии
    </title>
    <meta charset="UTF-8">

    <link href="css/style.css" rel="stylesheet">

</head>
<body>

<?php

if(isset($_POST['submit'])){
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('xml', 'csv');

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            $fileNameNew = uniqid('', true).".".$fileActualExt;
            $fileDestination = 'uploads/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            //header("Location: index.php?uploadsuccess");

            $servername = "localhost";
            $username = "root";
            $password = "";
        
            // Create connection
            $conn = mysqli_connect($servername, $username, $password);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            ///////////////////////////////////////////////////////////////////////////////////
            //-----------izbirane na baza ili syzdavane ako nqma takava + tablica
        
            $db_selected = mysqli_select_db($conn, "dropOut62040");
        
            if(!$db_selected){
                //if we cant then it either doesnt exist or we cant see it
                $sql = 'CREATE DATABASE dropOut62040';
        
                if(!mysqli_query($conn, $sql)){
                    echo "error creating database". mysqli_error($conn) . "<br>";
                }
            }
            
            $dbname = "dropOut62040";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $table = "SELECT * FROM STUDENTS";
            $checkTable = mysqli_query($conn, $table);
            if(!$checkTable)
            {
                //echo "table not found, creating one<br>";
                $createTable = "CREATE TABLE STUDENTS (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    fn VARCHAR(10) NOT NULL,
                    fname VARCHAR(30) NOT NULL,
                    lname VARCHAR(30) NOT NULL,
                    major VARCHAR(3) NOT NULL,
                    _year INT(1) NOT NULL,
                    _group INT(1) NOT NULL,
                    _absence INT(2) NOT NULL,
                    gradeAvr FLOAT(4) NOT NULL,
                    failedExams INT(1) NOT NULL
                    )";
                if(!mysqli_query($conn, $createTable)){
                    echo "error creating table: " . mysqli_error($conn) . "<br>";
                }
            }
        
            ///////////////////////////////////////////////////////////////////////////////////
            //---------- vkarvane na danni ot xml file
            if($fileActualExt == "xml")
            {
                $xml = simplexml_load_file($fileDestination) or die("error: cannot create obj");
        
            foreach($xml->children() as $row){
                $fn = $row->fn;
                $fname = $row->fname;
                $lname = $row->lname;
                $major = $row->major;
                $year = $row->year;
                $group = $row->group;
                $absence = $row->absence;
                $gradeavr = $row->gradeavr;
                $failedexams = $row->failedexams;
        
                $sql = "INSERT INTO STUDENTS(fn,fname,lname,major,_year,_group,_absence,gradeAvr,failedExams) VALUES ('" . $fn . "','" . $fname . "','" . $lname . "','" . $major . "','" . $year . "','" . $group . "','" . $absence . "','" . $gradeavr . "','" . $failedexams . "')";
                
                $result = mysqli_query($conn, $sql);
            }
            }
            //////////////////////////////////////////////////////////////////////////////////
            //------------- vkarvane na danni ot csv file
            if($fileActualExt == "csv")
            {
                $handle = fopen($fileDestination,"r");
                $c = 0;

                while(($csvdata = fgetcsv($handle,1000,",")) !== FALSE){
                    $fn = $csvdata[0];
                    $fname = $csvdata[1];
                    $lname = $csvdata[2];
                    $major = $csvdata[3];
                    $year = $csvdata[4];
                    $group = $csvdata[5];
                    $absence = $csvdata[6];
                    $gradeavr = $csvdata[7];
                    $failedexams = $csvdata[8];

                    $sql = "INSERT INTO STUDENTS(fn,fname,lname,major,_year,_group,_absence,gradeAvr,failedExams) VALUES ('" . $fn . "','" . $fname . "','" . $lname . "','" . $major . "','" . $year . "','" . $group . "','" . $absence . "','" . $gradeavr . "','" . $failedexams . "')";
                
                    $result = mysqli_query($conn, $sql);

                    $c = $c + 1; 
                }
            }
            ////////////////////////////////////////////////////////////////

        } else{
            echo "there was an error";
        }
    } else{
        echo "wrong type of file";
    }
}

?>


<form>
<h3>Please choose an option:</h3>
    <a href="dropOutByGrades.php" class="button">By Grades</a><br>
    <a href="dropOutByAbs.php" class="button">By Absence</a><br>
    <a href="dropOutByFails.php" class="button">By Failed Exams</a><br>
    <a href="dropOutAll.php" class="button">All</a><br>
    <a href="index.php" class="button">Go back</a><br>
</form> 



</body>
</html>