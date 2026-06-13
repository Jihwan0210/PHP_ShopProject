<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include "common.php";

$id = $_GET['id'] ?? '';
if (!$id) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

// 주문 정보 가져오기
$sql = "SELECT * FROM jumun WHERE id = '$id'";
$result = mysqli_query($db, $sql) or die("주문 조회 오류: " . mysqli_error($db));
$jumun = mysqli_fetch_array($result);
if (!$jumun) {
    echo "<script>alert('주문 정보를 찾을 수 없습니다.'); history.back();</script>";
    exit;
}

// 주문 상품 목록 가져오기
$sql2 = "
    SELECT js.*, p.name, p.image1, o1.name AS opt1_name, o2.name AS opt2_name
    FROM jumuns js
    LEFT JOIN product p ON js.product_id = p.id
    LEFT JOIN opts o1 ON js.opts_id1 = o1.id
    LEFT JOIN opts o2 ON js.opts_id2 = o2.id
    WHERE js.jumun_id = '$id'
";
$result2 = mysqli_query($db, $sql2) or die("상품 조회 오류: " . mysqli_error($db));

// 상품 합계 계산
$sql_sum = "SELECT SUM(prices) AS sum_price FROM jumuns WHERE jumun_id = '$id' AND product_id != 0";
$result_sum = mysqli_query($db, $sql_sum);
$row_sum = mysqli_fetch_array($result_sum);
$sum = is_numeric($row_sum["sum_price"]) ? (int)$row_sum["sum_price"] : 0;

$baesongbi = ($sum >= 50000) ? 0 : 2500;
$total_price = $sum + $baesongbi;
?>

<!doctype html>
<html lang="kr">
<head>
  <meta charset="utf-8">
  <title>INDUK Mall - 주문상세</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/my.css" rel="stylesheet">
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
<?php include "main_top.php"; ?>

<div class="row m-1 mb-0">
  <div class="col" align="center">
    <h4 class="m-3">주문상품내역</h4>
    <hr class="m-0">
    <table class="table table-sm mb-5" style="font-size:14px;">
      <tr class="bg-light">
        <th width="15%">이미지</th>
        <th width="35%">상품정보</th>
        <th width="15%">판매가</th>
        <th width="15%">수량</th>
        <th width="20%">금액</th>
      </tr>
      <?php
      mysqli_data_seek($result2, 0);
      while ($row = mysqli_fetch_array($result2)) {
          if ((int)$row['product_id'] === 0) continue;
          $price = (int)$row["prices"] / max((int)$row["num"], 1); // 할인 적용된 단가
          $num = $row["num"];
          $opt1 = $row["opt1_name"] ?? '';
          $opt2 = $row["opt2_name"] ?? '';
          $img = $row["image1"] ?: "nopic.png";

          echo "<tr height='85'>";
          echo "<td><img src='product/{$img}' width='60' height='70'></td>";
          echo "<td align='left'>{$row['name']}<br><small><b>[옵션]</b> $opt1 &nbsp; $opt2</small></td>";
          echo "<td>" . number_format($price) . "</td>"; // 할인 가격
          echo "<td>$num</td>";
          echo "<td>" . number_format($row["prices"]) . "</td>";
          echo "</tr>";
      }
      ?>
      <tr class="bg-light" align="right">
        <td align="center"><img src="images/cart_image1.gif"></td>
        <td colspan="4" class="pe-4">
          <font color="#0066CC">총금액</font> :
          상품(<?=number_format($sum)?>)
          + 배송비(<?= number_format($baesongbi) ?>)
          = <b><?=number_format($total_price)?></b>
        </td>
      </tr>
    </table>
  </div>
</div>

<!-- 결제내역 -->
<div class="row m-1">
  <div class="col" align="center">
    <h4 class="m-0 text-danger"><b>결제내역</b></h4>
    <hr class="m-2">
    <?php
    $card_names = [0 => "선택안함", 1 => "국민카드", 2 => "신한카드", 3 => "우리카드", 4 => "하나카드"];
    $pay_kinds = [0 => "카드", 1 => "무통장"];
    $card_kind_label = $card_names[$jumun['card_kind']] ?? "기타";
    $pay_kind_label = $pay_kinds[$jumun['pay_kind']] ?? "미지정";
    ?>
    <table class="table table-sm table-borderless" style="font-size:13px;">
      <tr>
        <td width="20%">주문번호 :</td><td width="30%"><?= $jumun['id'] ?></td>
        <td width="20%">결제금액 :</td><td width="30%"><?= number_format($total_price) ?> 원</td>
      </tr>
      <tr>
        <td>결제방식 :</td><td><?= $pay_kind_label ?></td>
        <td>승인번호 :</td><td><?= $jumun['card_okno'] ?? '' ?></td>
      </tr>
      <tr>
        <td>카드종류 :</td><td><?= $card_kind_label ?></td>
        <td>할부 :</td><td><?= ($jumun['card_halbu'] ?? 0) == 0 ? '일시불' : $jumun['card_halbu'] . '개월' ?></td>
      </tr>
      <tr>
        <td>무통장 :</td><td><?= $jumun['bank'] ?? '' ?></td>
        <td>입금자 :</td><td><?= $jumun['bank_sender'] ?? '' ?></td>
      </tr>
    </table>
  </div>
</div>

<!-- 주문자 정보 -->
<div class="row m-1">
  <div class="col" align="center">
    <h4 class="m-0 text-danger"><b>주문자</b></h4>
    <hr class="m-2">
    <table class="table table-sm table-borderless" style="font-size:13px;">
      <tr>
        <td width="20%">주문자 :</td><td width="30%"><?= $jumun['o_name'] ?? '' ?></td>
        <td width="20%">핸드폰 :</td><td width="30%"><?= $jumun['o_tel'] ?? '' ?></td>
      </tr>
      <tr>
        <td>이메일 :</td><td colspan="3"><?= $jumun['o_email'] ?? '' ?></td>
      </tr>
      <tr>
        <td>주소 :</td><td colspan="3">[<?= $jumun['o_zip'] ?? '' ?>] <?= $jumun['o_juso'] ?? '' ?></td>
      </tr>
    </table>
  </div>
</div>

<!-- 배송자 정보 -->
<div class="row m-1">
  <div class="col" align="center">
    <h4 class="m-0 text-danger"><b>배송내역</b></h4>
    <hr class="m-2">
    <table class="table table-sm table-borderless" style="font-size:13px;">
      <tr>
        <td width="20%">수취인 :</td><td width="30%"><?= $jumun['r_name'] ?? '' ?></td>
        <td width="20%">핸드폰 :</td><td width="30%"><?= $jumun['r_tel'] ?? '' ?></td>
      </tr>
      <tr>
        <td>이메일 :</td><td colspan="3"><?= $jumun['r_email'] ?? '' ?></td>
      </tr>
      <tr>
        <td>주소 :</td><td colspan="3">[<?= $jumun['r_zip'] ?? '' ?>] <?= $jumun['r_juso'] ?? '' ?></td>
      </tr>
      <tr>
        <td>메모 :</td><td colspan="3"><?= $jumun['memo'] ?? '' ?></td>
      </tr>
    </table>
  </div>
</div>

<!-- 돌아가기 -->
<div class="row m-1 mb-5">
  <div class="col text-center">
    <a href="javascript:history.back();" class="btn btn-sm btn-dark text-white">돌아가기</a>
  </div>
</div>

<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
