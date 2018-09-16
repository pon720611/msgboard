<?php
include "header.php";
require "dbconfig.php";
$username = $password = "";
$usernameError = $passwordError = "";

if(isset($_POST["login-btn"])){
    //檢查帳號
    if(empty($_POST["username"])){
        $usernameError = "請輸入帳號";
    }else{
        $username = trim($_POST["username"]);
    }
    //檢查密碼
    if(empty($_POST["password"])){
        $passwordError = "請輸入密碼";
    }else{
        $password = trim($_POST["password"]);
    }
    //驗證帳密
    if(!empty($username)&&!empty($password)){
        //撈資料庫相同帳號的資料
        $sql = "SELECT * FROM users 
            WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username",$username);
        $stmt->execute();
        //如果帳號存在
        if($stmt->rowCount()==1){
            $data = $stmt->fetch();
            $hashedPassword = $data["password"];
            if(password_verify($password, $hashedPassword)){
                session_start();
                $_SESSION["userName"] = $username;
                $_SESSION["loginStatus"] = 2;
                header("location: index.php");
            }else{
                $passwordError = "密碼錯誤請重新輸入";
            }
        }else{
            $usernameError = "帳號不存在";
        }
        unset($stmt);
    }
    unset($pdo);
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h5 align="center">使用者登入</h5>
            <form action="<?= $_SERVER["PHP_SELF"]?>" method="post">
                <div class="form-group">
                    <label class="col-form-label" for="username">帳號</label>
                    <input type="text" class="form-control" name="username" value="<?= $username?>">
                    <span><?= $usernameError?></span>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="password">密碼</label>
                    <input type="password" class="form-control" name="password">
                    <span><?= $passwordError?></span>
                </div>
                <input type="submit" class="btn btn-primary" name="login-btn" value="登入">
                <a href="register.php" class="btn btn-outline-primary">註冊</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>