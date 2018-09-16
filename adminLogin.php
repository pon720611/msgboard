<?php
include "header.php";
session_start();
if ($_SESSION["loginStatus"] == 1) {
    header("Location:adminPage.php");
}
?>







<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="dbfunction.php" method="post">
                <h5 align="center">管理員登入</h5>
                <div class="form-group">
                <label class="col-form-label" for="admin-account">帳號</label>
                <input type="text" class="form-control" placeholder="請輸入帳號" name="admin_account">
                </div>

                <div class="form-group">
                <label class="col-form-label" for="admin_password">密碼</label>
                <input type="password" class="form-control" placeholder="請輸入密碼" name="admin_password">
                </div>


                <div class="form-group" align="center">
                <button type="submit" class="btn btn-warning" name="admin-login">登入</button>
                <a href="index.php" class="btn btn-outline-warning">取消</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
