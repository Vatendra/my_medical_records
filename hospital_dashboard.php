<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
include("db.php");
/* file upload */
if (isset($_POST["submit"])){
    // alert if no file selected
    if (empty($_FILES['file']['name'])) {
        echo "<script>alert('Please select a file to upload.');</script>";
    }
    else{
        $p_id = $_POST['p_id'];
        $file = rand(1, 1000)."-".$_FILES["file"]["name"]; /* random number to avoid replacing of similar files */
        $temp_name = $_FILES["file"]["tmp_name"];
        $upload_dir = './uploads';
        $h_id = $_SESSION['username'];
        $status = move_uploaded_file($temp_name, $upload_dir.'/'.$file);
        // Check whether patient exists or not
        $sql = "SELECT * FROM patient WHERE username='$p_id'";
        $result = mysqli_query($con, $sql);
        if($result->num_rows > 0){
            $sql = "INSERT INTO records (p_id, h_id, url) VALUES ('$p_id', '$h_id', '$file')";
            if(mysqli_query($con, $sql)){
                // alert
                echo "<script>alert('Record added successfully');</script>";
            }
            else{
                // alert
                echo "<script>alert('Error adding record');</script>";
            }
        }
        else{
            // alert
            echo "<script>alert('Patient does not exist');</script>";
        }
    }
}
?>    
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Hospital</title>
    <link rel="stylesheet" href="style.css" ?v=<?php echo time(); ?>/>
</head>
<body>
    <h1 align="center"><?php echo $_SESSION['name']; ?></h1>
    <div class="navbar">
        <span>Welcome, <?php echo $_SESSION['username']; ?>!</span>
        <a class="link" href="logout.php">Logout</a>
    </div>
    <form method="post" enctype="multipart/form-data" class="form">
        <label for="">Patiend ID: </label>
        <input type="text" for="patient_id" name="p_id" class="login-input" >
        <input type="File" name="file" class="login-input">
        <input type="submit" name="submit" value="Add Record" class="login-button">
    </form>
    <form method="post" class="form">
    <input type="submit" name="view" value="View Records" class="login-button">
    </form>
    <?php
    if (isset($_POST["view"])){
        $sql = "SELECT * FROM records WHERE h_id = '$_SESSION[username]'";
        $result = mysqli_query($con, $sql);
        echo "<table align='center'>";
        echo "<tr>";
        echo "<th>Record ID</th>";
        echo "<th>Patient ID</th>";
        echo "<th>URL</th>";
        echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["p_id"]; ?></td>
                <td> <a href="./uploads/<?php echo $row["url"]; ?>"> <?php echo $row["url"]; ?> </a> </td>
            </tr>
            <?php
        }
        echo "</table>";
    }
    ?>
</body>
</html>
