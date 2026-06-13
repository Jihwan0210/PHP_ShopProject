<?php
// ---------------------------------------------------------------------------------------------
// 제목 : 내 손으로 만드는 PHP 쇼핑몰 (옵션 목록 화면)
// ---------------------------------------------------------------------------------------------
include "../common.php";

$text1 = $_REQUEST["text1"] ?? "";

$sql = "SELECT * FROM opt 
        WHERE id LIKE '%$text1%' 
        ORDER BY id";

$args = "text1=$text1";
$result = mypagination($sql, $args, $count, $pagebar);
?>
<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INDUK Mall</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/my.css" rel="stylesheet">
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/my.js"></script>
</head>
<body>

<div class="container">

    <!-- 관리자 메뉴 출력 -->
    <script> document.write(admin_menu()); </script>

    <div class="row mx-1 justify-content-center">
        <div class="col-sm-10 text-center">

            <h4 class="m-0">옵션 관리</h4>

            <div class="row myfs13 mb-2">
                <div class="col text-start pt-2">
                    옵션 수 : <span class="text-danger"><?= $count ?></span>
                </div>
                <div class="col text-end">
                    <a href="opt_new.php" class="btn btn-sm mycolor1 myfs12">옵션 추가</a>
                </div>
            </div>

            <table class="table table-sm table-bordered table-hover my-1">
                <thead class="bg-light text-center">
                    <tr>
                        <th width="10%">번호</th>
                        <th>옵션명</th>
                        <th width="25%">수정 / 삭제</th>
                        <th width="25%">소옵션 편집</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($result as $row) {
                    $id = $row["id"];
                ?>
                    <tr class="text-center">
                        <td><?= $row["id"] ?></td>
                        <td class="text-start"><?= $row["name"] ?></td>
                        <td>
                            <a href="opt_edit.php?id=<?= $id ?>" class="btn btn-sm mybutton-blue">수정</a>
                            <a href="opt_delete.php?id=<?= $id ?>" class="btn btn-sm mybutton-red"
                               onclick="return confirm('삭제할까요?');">삭제</a>
                        </td>
                        <td>
                            <a href="opts.php?id=<?= $id ?>" class="btn btn-sm mybutton-gray">소옵션 편집</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <!-- 페이지네이션 출력 -->
            <?= $pagebar ?>

        </div>
    </div>

</div>
</body>
</html>
