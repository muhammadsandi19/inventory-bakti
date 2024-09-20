<?php 
require 'function.php';


//cek login terdaftar atau tidak
if (isset($_POST['login'])){
    $email = $_POST ['email'];
    $password = $_POST ['password'];

    //cocokin dengan database.. mencari ada atau tidak
    $cekdatabase = mysqli_query($conn,"SELECT * FROM login where email='$email' and password='$password'");
    //hitung jumlah data
    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung>0){
        $_SESSION['log'] = 'True'; 
        header('location:index.php');
    } else {
        header('location:login.php');
    };

};

if(!isset($_SESSION['log'])){
    
} else {
    header('location:index.php');
};


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/login.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
            <div class="login-box">
                <h2>LOGIN INVENTORY</h2>
                <form method="post">
                    <div class="user-box">
                        <input class="form-control" type="email" id="inputEmail" name="email" required="">
                        <label>Email</label>
                    </div>
                    <div class="user-box">
                        <input class="form-control" type="password" id="inputPassword" name="password" required="">
                        <label>Password</label>
                    </div> 
                    
                    <button class="btn-succes" name="login">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Submit
                    </button>
                    
                      
                </form>
            </div>
        </body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
</html>
