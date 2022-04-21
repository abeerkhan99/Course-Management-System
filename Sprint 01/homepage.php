<?php
    session_start();
    require_once "config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <title>Project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="homepage_style.css">
</head>
<body>
    <div class = "body">
        <?php if ($_SESSION["loggedin"] === true) { ?>

            <div class="logo">
                <i class="fa fa-weibo" aria-hidden="true"></i>
            </div>

            <div id = "user">
                <h1 class="Teacher"><?php  echo "Welcome, ", $_SESSION["FirstName"], " ", $_SESSION["LastName"]; ?></h1>
            </div>
   
            <div id="header">           
                <button id="btnhome" onclick = "location.href='homepage.php'">Home</button>          
                <button id="btncreate" onclick="location.href='create_module.php'">Create Module</button> 
            </div>

            <div id = "module">
                <?php $c_name = $c_section = ""; ?>
                <?php $first_name = $_SESSION["FirstName"]; ?>
                <?php $last_name = $_SESSION["LastName"]; ?>

                <?php $sql = "SELECT CourseName, CourseSection FROM Teacher, Course WHERE Teacher.TeacherID = Course.TeacherID
                    AND Teacher.FirstName = '$first_name' AND Teacher.LastName = '$last_name' 
                    AND Course.Module = 1"; ?>
                <?php $result = sqlsrv_query( $conn, $sql); ?>

                <?php while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC)) { ?>
                    <?php $c_name = $row[0]; ?>
                    <?php $c_section = $row[1]; ?>
                    
                    <?php $c_module = $c_name . '' . $c_section; ?>

                    <?php if (!file_exists("$c_module.php")) { ?>
                        <?php touch("$c_module.php"); ?>  
                    <?php } ?>
                    <button id = "modulebtn" onclick="location.href='<?php echo $c_module?>.php'"  type="button"><?php echo $c_name, " ", $c_section ?></button>
                <?php } ?>
            </div>

            <div class = "dropdown">
                <button id = coursebtn> My Courses
                    <i class="fa fa-caret-down"></i>
                </button>

                <div class="dropdown-content">
                    <?php $c_name = $c_section = ""; ?>
                    <?php $first_name = $_SESSION["FirstName"]; ?>
                    <?php $last_name = $_SESSION["LastName"]; ?>

                    <?php $sql = "SELECT CourseName, CourseSection FROM Teacher, Course WHERE Teacher.TeacherID = Course.TeacherID
                        AND Teacher.FirstName = '$first_name' AND Teacher.LastName = '$last_name'"; ?>
                    <?php $result = sqlsrv_query( $conn, $sql); ?>

                    <?php while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC)) { ?>
                        <?php $c_name = $row[0]; ?>
                        <?php $c_section = $row[1]; ?>
                        
                        <?php $c_module = $c_name . '' . $c_section; ?>

                        <p><?php echo $c_name, " ", $c_section ?></p>
                    <?php } ?>
                </div>
            </div>

            <div id = "header">
                <button id = "logoutbtn" onclick="location.href='logout.php'"  type="button">Logout</button>
            </div>
        <?php } else { ?>
            <?php header("location: login.php") ?>
        <?php } ?>
        
    </div>
</body>
</html>