<?php
    if(isset($_POST["logout"])):
        session_start();
        $_SESSION=array();
        header("Location:login.php");
    endif;?>
<?php
    $connection;
    $isAdmin = false;
    session_start();
    if(isset($_SESSION["role"]) && $_SESSION["role"]="admin"){
        $connection=@mysqli_connect("localhost","musadmin","sec1","music") or die("Соединение не удалось");
        $isAdmin = true;
    }
    else{
        $connection=@mysqli_connect("localhost","muspublic","","music") or die("Соединение не удалось");
    }
?>