<!DOCTYPE html>
<html lang = "bg">
<head>
    <title>
        Курсов проект по Уеб Технологии
    </title>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
</head>
    <body>
    <h3>Всички студенти, които ще отпаднат!</h3>
       <table class="center">
       <tr>
            <th>FN</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Major</th>
            <th>Year</th>
            <th>Group</th>
            <th>Absence</th>
            <th>Grade Average</th>
            <th>Failed Exams</th>
       </tr>
       <?php
            $conn = mysqli_connect("localhost", "root", "", "dropout62040");
            if(!$conn){
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT fn, fname, lname, major, _year, _group, _absence, gradeAvr, failedExams FROM STUDENTS WHERE _absence>=10 OR gradeAvr<=3.5 OR failedExams>=3";
            $result = $conn->query($sql);

            if($result->num_rows>0){
                while($row = $result->fetch_assoc()){
                    echo "<tr><td>" . $row["fn"] . "</td><td>" . $row["fname"]
                    . "</td><td>" . $row["lname"] . "</td><td>" . $row["major"] . "</td><td>" . $row["_year"]
                    . "</td><td>" . $row["_group"] . "</td><td>" . $row["_absence"] . "</td><td>" . $row["gradeAvr"] . "</td><td>" . $row["failedExams"] . "</td></tr>";
                }
            echo "</table>";
            }
            else{
                echo "0 results";
            }
       ?>
       </table>

    <a href="add_file.php" class="button button2">Go back</a><br>
        
    </body>
</html>