<?php
    session_start();
    require_once "config.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="module_style.css">
</head>
<body>
<div class="navbar">
    <a href="homepage.php">Home</a>
    <a href="logout.php">Logout</a>
  
    <div class = "container">
        <div class="dropdown">
            <button class="dropbtn">Choose course
                <i class="fa fa-caret-down"></i>
            </button>

        <div class="dropdown-content">
            <?php $c_name = $c_section = ""; ?>
            <?php $first_name = $_SESSION["FirstName"]; ?>
            <?php $last_name = $_SESSION["LastName"]; ?>

            <?php $sql = "SELECT CourseName, CourseSection FROM Teacher, Course WHERE Teacher.TeacherID = Course.TeacherID
                AND Teacher.FirstName = '$first_name' AND Teacher.LastName = '$last_name' 
                AND Course.Module = 0"; ?>
            <?php $result = sqlsrv_query( $conn, $sql); ?>

            <?php while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC)) { ?>
                <?php $c_name = $row[0]; ?>
                <?php $c_section = $row[1]; ?>
                
                <?php $c_module = $c_name . '' . $c_section; ?>

                <?php if (!file_exists("$c_module.php")) { ?>
                    <?php touch("$c_module.php"); ?>  
                <?php } ?>

                <a href="#"><?php echo $c_name, " ", $c_section ?></a>

            <?php } ?>
        </div>
        </div> 
    </div>
</div>
</body>
</html>