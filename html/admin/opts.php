<?php
// ---------------------------------------------------------------------------------------------
// 실습 제목 : PHP 쇼핑몰 소옵션 목록 페이지
// 담당 교수 : 윤형태 / 컴퓨터소프트웨어학과
// ---------------------------------------------------------------------------------------------
include "../common.php";

// 요청된 옵션 ID 및 검색어 처리
$optId = $_REQUEST["id"];
$keyword = $_REQUEST["text1"] ?? "";

// 옵션 이름 조회
$nameQuery = "SELECT name FROM opt WHERE id = $optId";
$nameResult = mysqli_query($db, $nameQuery);
$optRow = mysqli_fetch_array($nameResult);

// 소옵션 리스트 조회
$listQuery = "SELECT * FROM opts WHERE opt_id = $optId ORDER BY id";
$args = "text1=$keyword";
$result = mypagination($listQuery, $args, $count, $pagebar);
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

            <h4 class="m-0">소옵션 목록</h4>

            <div class="row myfs13 mb-2">
                <div class="col text-start pt-2">
                    &nbsp;옵션명 : <span class="text-danger"><?= $optRow["name"] ?></span>
                </div>
                <div class="col text-end">
                    <a href="opts_new.php?id=<?= $optId ?>" class="btn btn-sm mycolor1 myfs12">소옵션 추가</a>
                </div>
            </div>

            <table class="table table-sm table-bordered table-hover my-1">
                <thead class="bg-light text-center">
                    <tr>
                        <th width="25%">소옵션 번호</th>
                        <th>소옵션명</th>
                        <th width="25%">수정 / 삭제</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row): ?>
                    <tr class="text-center">
                        <td><?= $row["id"] ?></td>
                        <td class="text-start"><?= $row["name"] ?></td>
                        <td>
                            <a href="opts_edit.php?id=<?= $row['id'] ?>&id1=1" class="btn btn-sm mybutton-blue">수정</a>
                            <a href="opts_delete.php?id=<?= $row['id'] ?>&id1=1" class="btn btn-sm mybutton-red"
                               onclick="return confirm('삭제할까요?');">삭제</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?= $pagebar ?>

            <a href="opt.php" class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

        </div>
    </div>
</div>

</body>
</html>
