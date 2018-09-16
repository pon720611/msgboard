<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>留言板</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://bootswatch.com/4/minty/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <style>
      .right{
        float:right;
      }
    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="./">留言板</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav ml-auto">
    <?php
      //透過session判斷登入狀態
      session_start();
      if(isset($_SESSION["loginStatus"])){

        if($_SESSION["loginStatus"] == 1){
          echo '<li class="nav-item">
              <a class="nav-link" href="create.php">新增留言</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="myMsg.php">我的留言</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="adminPage.php">留言管理</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="dbfunction.php?action=admin_logout">版主登出</a>
              </li>
              ';
        }
        
        if($_SESSION["loginStatus"] == 2){
          echo '<li class="nav-item">
              <a class="nav-link" href="create.php">新增留言</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="myMsg.php">我的留言</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="dbfunction.php?action=user_logout">會員登出</a>
              </li>';
        }
      }else{
        echo '<li class="nav-item">
          <a class="nav-link" href="login.php">會員登入</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="adminLogin.php">版主登入</a>
          </li>';
      }
    ?>
    </ul>
  </div>
</nav>
