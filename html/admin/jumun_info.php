<?php
include "../common.php";

$id = $_REQUEST['id'] ?? "";

if (!$id) {
    echo "<script>alert('주문번호가 없습니다.'); history.back();</script>";
    exit;
}

// 주문 요약 정보
$sql = "SELECT * FROM jumun WHERE id='$id'";
$result = mysqli_query($db, $sql);
if (!$row = mysqli_fetch_array($result)) {
    echo "<script>alert('해당 주문이 없습니다.'); history.back();</script>";
    exit;
}

// 상태, 주문일
$order_states = [
    1 => "주문신청", 2 => "주문확인", 3 => "입금확인",
    4 => "배송중", 5 => "주문완료", 6 => "주문취소"
];
$state_text = $order_states[$row['state']] ?? "미정";
$jumunday = $row['jumunday'];

// 하이픈 형식으로 전화번호 포맷 함수
function format_tel($tel) {
    $original = $tel;
    $tel = preg_replace("/[^0-9]/", "", $tel);
    if (strlen($tel) == 10)
        $formatted = preg_replace("/(\d{2,3})(\d{3})(\d{4})/", "$1-$2-$3", $tel);
    elseif (strlen($tel) == 11)
        $formatted = preg_replace("/(\d{3})(\d{4})(\d{4})/", "$1-$2-$3", $tel);
    else
        $formatted = $tel;
    echo "<!-- format_tel('$original') => '$formatted' -->";
    return $formatted;
}

// 주문자/수신자 정보
$o_name = $row['o_name'];
$o_tel_fmt = format_tel($row['o_tel']);
$o_email = $row['o_email'];
$o_juso = $row['o_juso'];
$o_gubun = $row['member_id'] == 0 ? "비회원" : "회원";

$r_name = $row['r_name'];
$r_tel_fmt = format_tel($row['r_tel']);
$r_email = $row['r_email'];
$r_juso = $row['r_juso'];
$r_memo = $row['memo'];

// 결제 정보
$card_okno = $row['card_okno'];
$card_halbu = $row['card_halbu'];
$card_kind = $row['card_kind'];
$bank_kind = $row['bank_kind'];
$bank_sender = $row['bank_sender'];

// 총액
$totalprice = (int)$row['totalprice'];
?>
<!doctype html>
<html lang="kr">
<head>
  <meta charset="utf-8">
  <title>INDUK Mall 주문상세 (<?php echo $id; ?>)</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/my.css" rel="stylesheet">
  <script src="../js/jquery-3.7.1.min.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<script>document.write(admin_menu());</script>

<div class="row mx-1 justify-content-center">
<div class="col-sm-10" align="center">

<h4 class="m-0 mb-3">주문 ( <b><?php echo $id; ?></b> )</h4>

<table class="table table-sm table-bordered mb-3">
  <tr><td width="15%" class="bg-light">상태</td><td width="35%"><?php echo $state_text; ?></td>
      <td width="15%" class="bg-light">주문일</td><td><?php echo $jumunday; ?></td></tr>
</table>

<table class="table table-sm table-bordered mb-2">
  <tr><td width="15%" class="bg-light"><b>주문자</b></td><td width="35%"><?php echo $o_name; ?></td>
      <td width="15%" class="bg-light">구분</td><td><?php echo $o_gubun; ?></td></tr>
  <tr><td class="bg-light">전화</td><td>
      <?php echo $o_tel_fmt ? $o_tel_fmt : "없음"; ?>
      <!-- DEBUG: raw o_tel = '<?php echo $row['o_tel']; ?>' -->
  </td>
      <td class="bg-light">E-Mail</td><td><?php echo $o_email; ?></td></tr>
  <tr><td class="bg-light">주소</td><td colspan="3" align="left">&nbsp;<?php echo $o_juso; ?></td></tr>
</table>

<table class="table table-sm table-bordered mb-3">
  <tr><td width="15%" class="bg-light"><b>수신자</b></td><td width="35%"><?php echo $r_name; ?></td><td width="15%" class="bg-light"></td><td></td></tr>
  <tr><td class="bg-light">전화</td><td>
      <?php echo $r_tel_fmt ? $r_tel_fmt : "없음"; ?>
      <!-- DEBUG: raw r_tel = '<?php echo $row['r_tel']; ?>' -->
  </td>
      <td class="bg-light">E-Mail</td><td><?php echo $r_email; ?></td></tr>
  <tr><td class="bg-light">주소</td><td colspan="3" align="left">&nbsp;<?php echo $r_juso; ?></td></tr>
  <tr height="50"><td class="bg-light">메모</td><td colspan="3" align="left" valign="top">&nbsp;<?php echo $r_memo; ?></td></tr>
</table>

<table class="table table-sm table-bordered mb-3">
<?php
// 카드 할부 표시 포맷
$halbu_text = ($card_halbu == 0) ? "일시불" : $card_halbu . "개월";

// 카드/무통장 구분
if ($row['pay_kind'] == 0) { // 카드 결제
?>
<tr>
  <td width="15%" class="bg-light"><b>카드</b></td><td><?= $card_kind ?></td>
  <td width="15%" class="bg-light">승인</td><td><?= $card_okno ?></td>
</tr>
<tr>
  <td class="bg-light">할부</td><td><?= $halbu_text ?></td>
  <td class="bg-light">입금자</td><td></td>
</tr>
<tr>
  <td class="bg-light"><b>무통장</b></td><td></td>
  <td class="bg-light"></td><td></td>
</tr>
<?php
} else { // 무통장 결제
?>
<tr>
  <td width="15%" class="bg-light"><b>카드</b></td><td></td>
  <td width="15%" class="bg-light">승인</td><td></td>
</tr>
<tr>
  <td class="bg-light">할부</td><td></td>
  <td class="bg-light">입금자</td><td><?= $bank_sender ?: '없음' ?></td>
</tr>
<tr>
  <td class="bg-light"><b>무통장</b></td><td><?= $bank_kind ?></td>
  <td class="bg-light"></td><td></td>
</tr>
<?php
}
?>
</table>

<table class="table table-sm table-bordered mb-3">
  <tr class="bg-light">
    <td>제품명</td>
    <td width="10%">수량</td>
    <td width="10%">단가</td>
    <td width="10%">금액</td>
    <td width="10%">할인</td>
    <td width="20%">옵션</td>
  </tr>
<?php
$sql2 = "SELECT j.*, p.name FROM jumuns j 
         LEFT JOIN product p ON j.product_id = p.id 
         WHERE j.jumun_id = '$id'";
$res2 = mysqli_query($db, $sql2);
while ($r2 = mysqli_fetch_array($res2)) {
    if ($r2['product_id'] == 0) {
        echo "<tr><td align='left'>택배비</td><td>1</td>
              <td align='right'>" . number_format($r2['price']) . "</td>
              <td align='right'>" . number_format($r2['prices']) . "</td>
              <td></td><td></td></tr>";
    } else {
        $name     = $r2['name'];
        $num      = $r2['num'];
        $price    = $r2['price'];
        $discount = $r2['discount'];
        $opt1_name = $opt2_name = "";

if ($r2['opts_id1']) {
    $opt_res1 = mysqli_query($db, "SELECT name FROM opts WHERE id='{$r2['opts_id1']}'");
    if ($opt_res1 && $opt_row1 = mysqli_fetch_array($opt_res1)) {
        $opt1_name = $opt_row1['name'];
    }
}
if ($r2['opts_id2']) {
    $opt_res2 = mysqli_query($db, "SELECT name FROM opts WHERE id='{$r2['opts_id2']}'");
    if ($opt_res2 && $opt_row2 = mysqli_fetch_array($opt_res2)) {
        $opt2_name = $opt_row2['name'];
    }
}

$opt_str = trim($opt1_name . " / " . $opt2_name, " /");


        $dc_price = round($price * (100 - $discount) / 100);
        $amount   = $dc_price * $num;

        echo "<tr>";
        echo "<td align='left'>{$name}</td>";
        echo "<td>{$num}</td>";
        echo "<td align='right'>" . number_format($dc_price) . "</td>";
        echo "<td align='right'>" . number_format($amount) . "</td>";
        echo "<td>{$discount}</td>";
        echo "<td>{$opt_str}</td>";
        echo "</tr>";
    }
}
?>
</table>

<table class="table table-sm table-bordered mb-3 p-2">
  <tr><td width="15%" class="bg-light">총금액</td>
      <td width="85%" align="right" style="font-size:18px"><b><?php echo number_format($totalprice); ?> 원</b>&nbsp;</td></tr>
</table>

<a href="javascript:print();" class="btn btn-sm btn-dark text-white my-2">프린트</a>
<a href="javascript:history.back();" class="btn btn-sm btn-outline-dark my-2">돌아가기</a>

</div>
</div>
</div>

</body>
</html>
