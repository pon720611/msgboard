<?php
require "dbconfig.php";
session_start();
//使用者新增留言
if(isset($_POST["create-btn"])){

    $title = $_POST["title"];
    $content = $_POST["message"];

    //上傳圖片取得圖片路徑
    if(!empty($_FILES["photo"]["name"])){
        $fileName = $_FILES["photo"]["name"];
        $explodedName = explode('.',$fileName);
        $newFileName = $explodedName[0].date("YmdHis").".".$explodedName[1];
        $fileStorePath = "images/".$newFileName;
        move_uploaded_file($_FILES["photo"]["tmp_name"],$fileStorePath);
    }else{
        $fileStorePath = null;
    }
    
    $sql = "INSERT INTO messagetable (name, title, content, img, time)
                VALUE (:name, :title, :content,:img,:time)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name",$_SESSION["userName"]);
    $stmt->bindParam(":title",$title);
    $stmt->bindParam(":content",$content);
    $stmt->bindParam(":img",$fileStorePath);
    $stmt->bindParam(":time",date("Y-m-d H:i:s"));
    $stmt->execute();
    unset($pdo);
    header("Location: index.php");

}
//管理者登出
if($_GET['action']=="admin_logout"){
    session_start();
    session_destroy();
    echo "<script>
    alert('管理員登出');
    window.location='index.php';
    </script>";
}

//使用者登出
if($_GET["action"] == "user_logout"){
    session_start();
    session_destroy();
    echo "<script>
        alert('已登出');
        window.location='index.php';
        </script>";
}

//刪除留言
if($_GET["action"]=="delete"){
    $id = $_GET["id"];
    $imgPath = $_GET["img"];
    $sql = "DELETE FROM messagetable WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    //刪檔案
    if(file_exists($imgPath)){
        unlink($imgPath);
    }
    unset($pdo);

    if($_GET['source']=="admin"){
        echo "<script>
        alert('已刪除留言');
        window.location='adminPage.php';
        </script>";
    }else{
        echo "<script>
        alert('已刪除留言');
        window.location='myMsg.php';
        </script>";
    }
}

//管理者登入驗證
if(isset($_POST['admin-login'])){
    $id=$_POST['admin-account'];
    $pwd = $_POST['admin-password'];
    if(!empty($id)&&!empty($pwd)){
        $sql = "SELECT admin_account, admin_password FROM admin WHERE admin_account = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if($stmt->rowCount()==1){
            $data = $stmt->fetch();
            //直接在mysql將密碼加密:UPDATE admin SET admin_password = ENCRYPT(admin_password) WHERE admin_account = "admin123";
            $hashedPassword = $data['admin_password'];
            if(password_verify($pwd,$hashedPassword)){
                session_start();
                $_SESSION["userName"]="版主";
                $_SESSION['loginStatus']=1;
                header("Location:index.php");
            }else{
                echo "<script>
                alert('請重新確認帳密');
                window.location= 'adminLogin.php';
                </script>";
            }
        }else{
            echo "<script>
            alert('查無此帳號');
            window.location= 'adminLogin.php';
            </script>";
        }
        unset($stmt);
    }else{
        echo "<script>
        alert('請確實填寫欄位');
        window.location= 'adminLogin.php';
        </script>";
    }
    unset($pdo);
};

?>