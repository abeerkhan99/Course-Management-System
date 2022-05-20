<?php
    require_once "config.php";
    
    $email = $password = $f = $l = $e = $p = "";
    $email_err = $password_err = $login_err = "";

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        if(isset($_SESSION["Student"]) && $_SESSION["Teacher"] == false)
        {
            header("Location: student_homepage.php");
        }
        elseif(isset($_SESSION["Teacher"]) && $_SESSION["Student"] == false)
        {
            header("Location: homepage.php");
        }

        exit;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // If email is empty
        if(empty(trim($_POST["email"])))
        {
            $email_err = "Please enter your email address.";
        } 
        else
        {
            $email = trim($_POST["email"]);   
        }
        // If password is empty
        if(empty(trim($_POST["password"])))
        {
            $password_err = "Please enter your password.";
        } 
        else
        {
            $password = trim($_POST["password"]);
        }
        // If both are filled
        if(empty($email_err) && empty($password_err))
        {
            // Prepare a select statement
            if (str_contains($email, 'st'))
            {
                $sql = "SELECT StudentEmail, Pass, FirstName, LastName FROM Student WHERE StudentEmail = '$email' OR Pass = '$password' "; 

            }
            else
            {
                $sql = "SELECT EmailAddress, Pass, FirstName, LastName FROM Teacher WHERE EmailAddress = '$email' OR Pass = '$password' "; 

            }
            $result = sqlsrv_query( $conn, $sql);  
            while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC))  
            {  
                $e = $row[0];  
                $p = $row[1];
                $f = $row[2];  
                $l = $row[3];
            }
            if($email == $e && $password == $p)
            {
                session_start();
                                
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["FirstName"] = $f;
                $_SESSION["LastName"] = $l; 
                $_SESSION["Course Name"] = null;
                $_SESSION["Course Section"] = null;

                
                $login_err = "Login Successful!";
                if (str_contains($email, 'st'))
                {
                    $_SESSION["Student"] = true;
                    $_SESSION["Teacher"] = false;
                    header("Location: student_homepage.php?success=studentLogin");
                }
                else
                {
                    $_SESSION["Teacher"] = true;
                    $_SESSION["Student"] = false;
                    header("Location: homepage.php?success=teacherLogin");
                }
                
            }
            else if ($email != $e && $password != $p)
            {
                $login_err = "This account does not exist";
            }
            else
            {
                $login_err = "Incorrect";
            }
            sqlsrv_free_stmt( $result);
        }
        else if(empty($email) && empty($password))
        {
            $login_err = "Please enter your email address and password to login";
        }
    }
        sqlsrv_close( $conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="body">

        <div class="logo">
            <i class="fa fa-weibo" aria-hidden="true"></i>
        </div>

        <div class="header">
            <h2>Welcome.</h2>
        </div>

        <div id="loginform">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <?php if (isset($_GET['success'])) { ?>
                <p class="error"><?php echo $_GET['success']; ?></p>
            <?php } ?>

                <div class="info">
                    <input type="email" name = "email" placeholder="Email Address" value="<?php echo $email; ?>"/>
                    <span style="position:relative; top:5px; left:2px;" class="email_err"><?php echo $email_err; ?></span>

                    <input type="password"  name = "password" placeholder="Password"/>
                    <span style="position:relative; top:-8px; left:0px;" class="password_err"><?php echo $password_err; ?></span>
                </div>

                <div class="login">
                    <input type="submit" value="Log in" />
                    <!-- <span class="invalid-feedback"><?php echo $login_err; ?></span> -->
                    <?php if(!empty($login_err)) { ?>
                        <p class = "error"><?php echo $login_err; ?></p>
                    <?php } ?>
                </div>
        </form>
        </div>      
    </div>
</body>
</html>


