<!DOCTYPE html>
<html lang = "bg">
<head>
    <title>
        Курсов проект по Уеб Технологии
    </title>
    <meta charset="UTF-8">
    <link href="css/style_for_index.css" rel="stylesheet">
</head>
    <body>
       <h3>Please select a .xml or  .csv file from which you desire to import data</h3>
       <form method="POST" action="add_file.php" enctype="multipart/form-data">
            <input type="file" name="file"><br><br>
            <button type="submit" name="submit"> UPLOAD FILE </button>
       </form>

        <?php 
            if(isset($_GET['error'])){
                echo "The file was not uploaded";
            }
        ?>
    </body>
</html>