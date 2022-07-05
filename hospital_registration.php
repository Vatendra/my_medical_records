<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Hospital Registration</title>
    <link rel="stylesheet" href="style.css" ?v=<?php echo time(); ?>/>
</head>
<body>
    <h1 align="center">My Medical Records</h1>
<?php
    include('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $create_datetime = date("Y-m-d H:i:s");
        $name = $_POST['name'];
        // Check if user already exists
        $query = "SELECT * FROM `hospital` WHERE username='$username'";
        $result = mysqli_query($con, $query) or die("Connection Failed");
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            echo "<div class='form'>
                  <h3>Username already exists.</h3><br/>
                  <p class='link'>Click here to <a href='hospital_registration.php'>Register</a> again.</p>
                  </div>";
        } else {
            // Insert user data into database
            $query = "INSERT INTO `hospital` (username, password, email, name, create_datetime)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$name', '$create_datetime')";
            $result = mysqli_query($con, $query) or die("Connection Failed");
            if ($result) {
                echo "<div class='form'>
                      <h3>You are registered successfully.</h3><br/>
                      <p class='link'>Click here to <a href='login.php'>Login</a>.</p>
                      </div>";
            } else {
                echo "<div class='form'>
                      <h3>Registration failed.</h3><br/>
                      <p class='link'>Click here to <a href='hospital_registration.php'>Register</a> again.</p>
                      </div>";
            }
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Hospital Registration</h1>
        <input type="text" class="login-input" name="name" placeholder="Institution Name" required />
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="text" class="login-input" name="email" placeholder="Email Adress" required>
        <input type="password" class="login-input" name="password" placeholder="Password" required>
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link">Already have an account? <a href="login.php">Login here</a></p>
    </form>
<?php
    }
?>
</body>
</html>
