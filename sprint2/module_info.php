<?php
    session_start();
    require_once "config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="homepage_style.css"> -->
</head>
<body>
    <div class = "body">
        <?php if ($_SESSION["loggedin"] == true && $_SESSION["Teacher"] == true) { ?>
            <?php  echo $c_section ?>
            <button id= "delete" onclick="location.href='delete.php'" > Delete </button>
            <button id= "home" onclick="location.href='homepage.php'" > Home </button>
            <button id= "logout" onclick="location.href='logout.php'" > Logout </button>
            
            <div class = "dropdown">
                <button id = coursebtn> View Students
                    <i class="fa fa-caret-down"></i>
                </button>

                <div class="dropdown-content">
                    <?php $c_name = $c_section = ""; ?>
                    <?php $first_name = $_SESSION["FirstName"]; ?>
                    <?php $last_name = $_SESSION["LastName"]; ?>

                    <?php $sql = "SELECT Course.CourseName, Course.CourseSection FROM Student_Course, Student, Course WHERE Student_Course.StudentID = Student.StudentID
                    AND Course.CourseID = Student_Course.CourseID
                    AND Student.FirstName = '$first_name' AND Student.LastName = '$last_name' "; ?>

                    <?php $result = sqlsrv_query( $conn, $sql); ?>

                    <?php while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC)) { ?>
                        <?php $c_name = $row[0]; ?>
                        <?php $c_section = $row[1]; ?>
                        
                        <?php $c_module = $c_name . '' . $c_section; ?>

                        <p><?php echo $c_name, " ", $c_section ?></p>
                    <?php } ?>
                </div>
            </div>


        <?php } elseif ($_SESSION["loggedin"] == true && $_SESSION["Student"] == true)  { ?>
            <button id= "home" onclick="location.href='student_homepage.php'" > Home </button>
            <button id= "logout" onclick="location.href='logout.php'" > Logout </button>
        <?php } else { ?>
            <?php header("location: login.php") ?>
        <?php } ?>
        
    </div>
</body>
</html>