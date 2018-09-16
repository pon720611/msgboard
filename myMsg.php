<?php
include "header.php";
require "dbconfig.php";
session_start();
$sql = "SELECT * FROM messagetable 
            WHERE name = :username ORDER BY time DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":username", $_SESSION["userName"]);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
unset($pdo);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-8">

        <?php if (sizeof($data) > 0) : ?>

        <?php foreach ($data as $row) : ?>
         <div class="card mb-3">
            <div class="card-header">
                標題: <?= $row["title"] ?>
                <a align="right" href="dbfunction.php?action=delete&id=<?= $row['id'] ?>&img=<?= $row['img'] ?>" class="right"><i class="far fa-trash-alt"></i></a>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if ($row["img"] != null) : ?>
                        <div class="col-md-6 col-sm-12">
                            <blockquote class="blockquote mb-0">
                            <p>作者：<?= $row["name"] ?></p>
                            <p><?= nl2br($row["content"]) ?></p>
                            <footer class="blockquote-footer"><?= $row["time"] ?></footer>
                            </blockquote>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <img src="<?= $row['img'] ?>" width="100%">
                        </div>
                    <?php else : ?>
                        <div class="col-12">
                            <blockquote class="blockquote mb-0">
                            <p>作者：<?= $row["name"] ?></p>
                            <p><?= nl2br($row["content"]) ?></p>
                            <footer class="blockquote-footer"><?= $row["time"] ?></footer>
                            </blockquote>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-primary" role="alert">
            趕快新增你的第一篇留言吧！
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>