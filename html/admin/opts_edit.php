<?php
include "../common.php";

// 소옵션 ID 안전하게 정수로 처리
$id1 = intval($_REQUEST["id"]);

// 해당 소옵션 정보 가져오기
$sql = "SELECT * FROM opts WHERE id = $id1";
$result = mysqli_query($db, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    exit("존재하지 않는 소옵션입니다.");
}
$row = mysqli_fetch_assoc($result);

// 소속 옵션 ID
$opt_id = $row["opt_id"];
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
    <!-- 관리자 메뉴 -->
    <script> document.write(admin_menu()); </script>

    <form name="form1" method="post" action="opts_update.php">
        <input type="hidden" name="id" value="<?= $opt_id ?>">
        <input type="hidden" name="id1" value="<?= $id1 ?>">

        <div class="row mx-1 justify-content-center">
            <div class="col-sm-10 text-center">

                <h4 class="m-0 mb-3">소옵션 수정</h4>

                <table class="table table-sm table-bordered myfs12">
                    <tr>
                        <td width="30%" class="bg-light p-2">소옵션번호</td>
                        <td align="left" class="ps-3"><?= $row["id"] ?></td>
                    </tr>
                    <tr>
                        <td class="bg-light">소옵션명</td>
                        <td align="left" class="ps-2">
                            <div class="d-inline-flex">
                                <input type="text" name="name" size="30" value="<?= htmlspecialchars($row["name"]) ?>" class="form-control form-control-sm">
                            </div>
                        </td>
                    </tr>
                </table>

                <a href="javascript:form1.submit();" class="btn btn-sm btn-dark text-white my-2">&nbsp;저 장&nbsp;</a>
                <a href="javascript:history.back();" class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

            </div>
        </div>
        <br>
    </form>
</div>

</body>
</html>
