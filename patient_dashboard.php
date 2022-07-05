<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Patient</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <!---patient dashboard--->
    <h1 align="center" >Patient Dashboard</h1>
    <!---navigation bar--->
    <div class="navbar">
        <span>Welcome, <?php echo $_SESSION['username']; ?>!</span>
        <a class="link" href="logout.php">Logout</a>
    </div>
    <form method="post">
    <?php
    $sql = "SELECT * FROM patient WHERE username = '$_SESSION[username]'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    ?>
        <table align="center">
            <tr>
                <td>Name:</td>
                <td> <?php echo $row['name']?> </td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><?php echo $row['dob']?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td> <?php echo $row['email']?> </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="View Records" name="submit" class="login-button"></td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_POST["submit"])){
        $p_id = $_SESSION['username'];
        $status = move_uploaded_file($temp_name, $upload_dir.'/'.$file);
        $sql = "SELECT * FROM records WHERE p_id='$p_id'";
        $result = mysqli_query($con, $sql);
        if($result->num_rows > 0){
            ?>
            <table align="center">
                <tr>
                    <th>ID</th>
                    <th>Hospital ID</th>
                    <th>URL</th>
                </tr>
                <?php
                while($row = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["h_id"]; ?></td>
                        <td> <a href="./uploads/<?php echo $row["url"]; ?>"> <?php echo $row["url"]; ?> </a> </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        else{
            ?> <h3> <?php echo "No records found" ?> </h3> <?php
        }
    }
    ?>
    

</body>
</html>
