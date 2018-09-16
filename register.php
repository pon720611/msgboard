<?php
include "header.php";
require "dbconfig.php";

$username = $password = $confirmPassword = "";
$usernameError = $passwordError = $confirmPasswordError = "";

if (isset($_POST["register-btn"])) {
    //檢查使用者名稱
    if (empty($_POST["username"])) {
        $usernameError = "請輸入帳號";
    } else {
        $sql = "SELECT * FROM users
                WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", trim($_POST["username"]));
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $usernameError = "此名稱已被註冊過!";
        } else {
            $username = trim($_POST["username"]);
        }
        unset($stmt);
    }

    //檢查密碼
    $tmp_pwd = trim($_POST["password"]);
    $tmp_confirm_pwd = trim($_POST["confirm-password"]);
    if (empty($tmp_pwd) || empty($tmp_confirm_pwd)) {
        $passwordError = "請輸入兩次密碼";
    } else {
        if (strlen($tmp_pwd) < 6) {
            $passwordError = "請輸入大於6個字的密碼";
        } else {
            if ($tmp_pwd !== $tmp_confirm_pwd) {
                $confirmPasswordError = "請重新確認密碼";
            } else {
                $password = $tmp_pwd;
            }
        }
    }

    //將帳密存到資料庫
    if (!empty($username) && !empty($password)) {
        $sql = "INSERT INTO users (username, password)
                VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        //把密碼加密
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();
        echo "<script>
            alert('註冊成功!');
            window.location = 'login.php';
            </script>";
        unset($stmt);
    }
    unset($pdo);
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h5 align="center">註冊新帳號</h5>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <div class="form-group">
                    <label class="col-form-label" for="username">設定帳號</label>
                    <input type="text" class="form-control" name="username" value="<?= $username ?>">
                    <span><?= $usernameError ?></span>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="password">設定密碼</label>
                    <input type="password" class="form-control" name="password">
                    <span><?= $passwordError ?></span>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="confirm-password">確認密碼</label>
                    <input type="password" class="form-control" name="confirm-password">
                    <span><?= $confirmPasswordError ?></span>
                </div>
                <input type="submit" class="btn btn-primary" name="register-btn" value="註冊">
                <a href="index.php" class="btn btn-outline-primary">取消</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>