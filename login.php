<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css" ?v=<?php echo time(); ?>/>
    
</head>
<body>
    <h1 align="center">My Medical Records</h1>
<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $table_name = $_POST['category'];
        // Check user is exist in the database
        $query    = "SELECT * FROM `$table_name` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die("Connection Failed");
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = mysqli_fetch_array($result)['name'];
            // Redirect to user hospital dashboard page
            if ($table_name === "hospital"){
                header("Location: hospital_dashboard.php");
            }
            else{
                header("Location: patient_dashboard.php");
            }
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <label for="category">Acc Type:</label>
        <input type="radio" name="category" value="patient" checked> Patient
        <input type="radio" name="category" value="hospital"> Hospital
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link">Don't have an account? Register Now</p>
        <p class="link"><a href="patient_registration.php">Patient</a> <a href="hospital_registration.php">Hospital</a></p>
  </form>
<?php
    }
?>
</body>
</html>
