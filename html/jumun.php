<?php
include "common.php";

// 로그인 여부 확인
$cookie_id = $_COOKIE["cookie_id"] ?? "";
$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
if (!$cookie_id && (!$name || !$email)) {
    $name = $_COOKIE["non_member_name"] ?? "";
    $email = $_COOKIE["non_member_email"] ?? "";
}

// 쿼리 조건 설정
if ($cookie_id) {
    $where = "member_id = '$cookie_id'";
} else if ($name && $email) {
    $name = mysqli_real_escape_string($db, $name);
    $email = mysqli_real_escape_string($db, $email);
    $where = "o_name = '$name' AND o_email = '$email'";
} else {
    echo "<script>alert('비정상적인 접근입니다.'); history.back();</script>";
    exit;
}

// 주문 상태 텍스트
$states = [1 => "주문신청", 2 => "주문확인", 3 => "입금확인", 4 => "배송중", 5 => "주문완료", 6 => "주문취소"];
$colors = [1 => "#0066CC", 2 => "#0066CC", 3 => "#0066CC", 4 => "#0066CC", 5 => "black", 6 => "#D06404"];

// 페이지 설정
$page_line = 10;
$args = "name=$name&email=$email";
$sql = "SELECT * FROM jumun WHERE $where ORDER BY jumunday DESC";
$result = mypagination($sql, $args, $count, $pagebar);
?>

<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INDUK Mall</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
<?php include "main_top.php"; ?>

<div class="row m-1 mt-4 mb-0">
    <div class="col" align="center">
        <h4 class="m-3">주문조회</h4>
        <hr class="m-0">
        <table class="table table-sm mb-4">
            <tr height="40" class="bg-light">
                <td width="15%">주문일</td>
                <td width="15%">주문번호</td>
                <td width="35%">제품정보</td>
                <td width="15%" align="right">결제금액</td>
                <td width="20%">주문상태</td>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) : ?>
            <tr height="40">
                <td><?= $row['jumunday'] ?></td>
                <td class="mywordwrap">
                    <a href="jumun_info.php?id=<?= $row['id'] ?>" style="font-size:14px;color:#0066CC"><?= $row['id'] ?></a>
                </td>
                <td align="left"><?= htmlspecialchars($row['product_names']) ?></td>
                <td align="right" style="font-size:14px;"><?= number_format($row['totalprice']) ?></td>
                <td><font color="<?= $colors[$row['state']] ?>"><?= $states[$row['state']] ?></font></td>
            </tr>
            <?php endwhile; ?>
            <?php if ($count == 0): ?>
            <tr><td colspan="5" align="center">주문 내역이 없습니다.</td></tr>
            <?php endif; ?>
        </table>
        <!-- 페이지바 출력 -->
        <div class="text-center mb-5">
            <?= $pagebar ?>
        </div>
    </div>
</div>

<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
