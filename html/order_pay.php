<?php
include "common.php";

// 장바구니 데이터
$order_direct = isset($_POST['kind']) && $_POST['kind'] === 'direct';

if ($order_direct) {
    $cart = [];
    $id = $_POST['id'];
    $num = $_POST['num'];
    $opts1 = $_POST['opts1'];
    $opts2 = $_POST['opts2'];
    $cart[] = "$id^$num^$opts1^$opts2";
    $n_cart = 1;
} else {
    $cart = isset($_COOKIE["cart"]) ? unserialize($_COOKIE["cart"]) : [];
    $n_cart = isset($_COOKIE["n_cart"]) ? $_COOKIE["n_cart"] : 0;
}
$sum = 0;
$baesongbi = 2500;

// 주문자/수령자 정보
$o_name = $_POST["o_name"];
$o_tel = $_POST["o_tel1"] . "-" . $_POST["o_tel2"] . "-" . $_POST["o_tel3"];
$o_email = $_POST["o_email"];
$o_zip = $_POST["o_zip"];
$o_juso = $_POST["o_juso"];

$r_name = $_POST["r_name"];
$r_tel = $_POST["r_tel1"] . "-" . $_POST["r_tel2"] . "-" . $_POST["r_tel3"];
$r_email = $_POST["r_email"];
$r_zip = $_POST["r_zip"];
$r_juso = $_POST["r_juso"];
$memo = $_POST["memo"];
?>

<!doctype html>
<html lang="kr">
<head>
  <meta charset="utf-8">
  <title>INDUK Mall - 결제정보</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/my.css" rel="stylesheet">
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    function check_value() {
      let f = document.form2;
      if (f.pay_kind[0].checked) {
        if (f.card_kind.value == 0) { alert("카드종류 선택!"); f.card_kind.focus(); return; }
        if (!f.card_no1.value || !f.card_no2.value || !f.card_no3.value || !f.card_no4.value) {
          alert("카드번호 입력!"); return;
        }
        if (!f.card_month.value || !f.card_year.value) {
          alert("카드기간 입력!"); return;
        }
        if (!f.card_pw.value) {
          alert("비밀번호 2자리 입력!"); return;
        }
      } else {
        if (f.bank_kind.value == 0) {
          alert("은행 선택!"); f.bank_kind.focus(); return;
        }
        if (!f.bank_sender.value) {
          alert("입금자 이름 입력!"); f.bank_sender.focus(); return;
        }
      }
      f.submit();
    }

    function pay_sel(n) {
      let dis_card = (n === 0) ? false : true;
      let dis_bank = (n === 1) ? false : true;
      let c = document.form2;
      c.card_kind.disabled = dis_card;
      c.card_no1.disabled = dis_card;
      c.card_no2.disabled = dis_card;
      c.card_no3.disabled = dis_card;
      c.card_no4.disabled = dis_card;
      c.card_month.disabled = dis_card;
      c.card_year.disabled = dis_card;
      c.card_pw.disabled = dis_card;
      c.card_halbu.disabled = dis_card;
      c.bank_kind.disabled = dis_bank;
      c.bank_sender.disabled = dis_bank;
    }
  </script>
</head>
<body>
<div class="container">
<?php include "main_top.php"; ?>

<!-- 상품 목록 출력 -->
<div class="row m-1 mb-0">
  <div class="col" align="center">
    <h4 class="m-3">주문(결제정보)</h4>
    <hr class="m-0">

    <table class="table table-sm mb-5" style="font-size:14px;">
      <thead>
        <tr class="bg-light">
          <th width="15%">이미지</th>
          <th width="35%">상품정보</th>
          <th width="15%">판매가</th>
          <th width="15%">수량</th>
          <th width="20%">금액</th>
        </tr>
      </thead>
      <tbody>
      <?php
      for ($i = 0; $i < $n_cart; $i++) {
        if (!$cart[$i]) continue;
        list($id, $num, $opts1, $opts2) = explode("^", $cart[$i]);
        $result = mysqli_query($db, "SELECT * FROM product WHERE id=$id");
        if (!$result) continue;
        $row = mysqli_fetch_array($result);

        $price = $row["price"];
        if ($row["icon_sale"] == 1 && $row["discount"] > 0)
          $price = round($price * (100 - $row["discount"]) / 100, -2);
        $total = $price * $num;
        $sum += $total;
        if ($sum >= 50000) $baesongbi = 0;

        echo "<tr height='85'>";
        echo "<td><img src='product/{$row['image1']}' width='60' height='70'></td>";
        echo "<td align='left'>{$row['name']}<br><small><b>[옵션]</b> $opts1 &nbsp; $opts2</small></td>";
        echo "<td>" . number_format($price) . "</td>";
        echo "<td>$num</td>";
        echo "<td>" . number_format($total) . "</td>";
        echo "</tr>";
      }
      ?>
      <tr class="bg-light" align="right">
        <td align="center"><img src="images/cart_image1.gif" alt="배송아이콘"></td>
        <td colspan="4" class="pe-4">
          <font color="#0066CC">총금액</font> : 상품(<?=number_format($sum)?>) + 배송비(<?=number_format($baesongbi)?>)
          = <b><?=number_format($sum + $baesongbi)?></b>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- 결제 입력 폼 -->
<form name="form2" method="post" action="order_insert.php">
<?php
// 주문자/수령자 정보 hidden으로 전송
echo "<input type='hidden' name='o_name' value='$o_name'>";
$o_tel_parts = explode("-", $o_tel);
echo "<input type='hidden' name='o_tel1' value='$o_tel_parts[0]'>";
echo "<input type='hidden' name='o_tel2' value='$o_tel_parts[1]'>";
echo "<input type='hidden' name='o_tel3' value='$o_tel_parts[2]'>";
echo "<input type='hidden' name='o_email' value='$o_email'>";
echo "<input type='hidden' name='o_zip' value='$o_zip'>";
echo "<input type='hidden' name='o_juso' value='$o_juso'>";

echo "<input type='hidden' name='r_name' value='$r_name'>";
$r_tel_parts = explode("-", $r_tel);
echo "<input type='hidden' name='r_tel1' value='$r_tel_parts[0]'>";
echo "<input type='hidden' name='r_tel2' value='$r_tel_parts[1]'>";
echo "<input type='hidden' name='r_tel3' value='$r_tel_parts[2]'>";
echo "<input type='hidden' name='r_email' value='$r_email'>";
echo "<input type='hidden' name='r_zip' value='$r_zip'>";
echo "<input type='hidden' name='r_juso' value='$r_juso'>";
echo "<input type='hidden' name='memo' value='$memo'>";
echo "<input type='hidden' name='baesong' value='$baesongbi'>";
?>

<!-- 결제방법 -->
<div class="row mx-1">
  <div class="col" align="center">
    <font size="4" color="#B90319"><b>결제방법</b></font>
    <hr class="m-2">

    <table style="font-size:13px;">
      <tr>
        <td align="right" width="30%" class="pe-3">결제선택</td>
        <td align="left">
          <input type="radio" name="pay_kind" value="0" checked onclick="pay_sel(0)"> 카드
          <input type="radio" name="pay_kind" value="1" onclick="pay_sel(1)"> 무통장
        </td>
      </tr>
    </table>

    <!-- 카드 정보 -->
    <font size="4" color="#B90319"><b>카드</b></font>
    <hr class="m-2">
    <table style="font-size:13px;">
      <tr>
        <td align="right" class="pe-3">카드종류</td>
        <td>
          <select name="card_kind" class="form-select form-select-sm" style="width:220px;">
            <option value="0">카드종류를 선택하세요.</option>
            <option value="1">국민카드</option>
            <option value="2">신한카드</option>
            <option value="3">우리카드</option>
            <option value="4">하나카드</option>
          </select>
        </td>
      </tr>
      <tr>
        <td align="right" class="pe-3">카드번호</td>
        <td>
          <input type="text" name="card_no1" class="form-control d-inline w-auto" size="4" maxlength="4"> -
          <input type="text" name="card_no2" class="form-control d-inline w-auto" size="4" maxlength="4"> -
          <input type="text" name="card_no3" class="form-control d-inline w-auto" size="4" maxlength="4"> -
          <input type="text" name="card_no4" class="form-control d-inline w-auto" size="4" maxlength="4">
        </td>
      </tr>
      <tr>
        <td align="right" class="pe-3">카드기간</td>
        <td>
          <input type="text" name="card_month" class="form-control d-inline w-auto" size="2" maxlength="2"> 월
          <input type="text" name="card_year" class="form-control d-inline w-auto" size="2" maxlength="2"> 년
        </td>
      </tr>
      <tr>
        <td align="right" class="pe-3">카드비밀번호</td>
        <td>** <input type="password" name="card_pw" class="form-control d-inline w-auto" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td align="right" class="pe-3">할부</td>
        <td>
          <select name="card_halbu" class="form-select form-select-sm w-auto d-inline">
            <option value="0">일시불</option>
            <option value="3">3개월</option>
            <option value="6">6개월</option>
            <option value="12">12개월</option>
          </select>
        </td>
      </tr>
    </table>

    <!-- 무통장 -->
    <font size="4" color="#B90319"><b>무통장</b></font>
    <hr class="m-2">
    <table style="font-size:13px;">
      <tr>
        <td align="right" class="pe-3">은행선택</td>
        <td>
          <select name="bank_kind" class="form-select form-select-sm" style="width:250px;" disabled>
            <option value="0">입금할 은행을 선택하세요.</option>
            <option value="1">국민은행 111-00000-0000</option>
            <option value="2">신한은행 222-00000-0000</option>
          </select>
        </td>
      </tr>
      <tr>
        <td align="right" class="pe-3">입금자이름</td>
        <td><input type="text" name="bank_sender" class="form-control form-control-sm" style="width:250px;" disabled></td>
      </tr>
    </table>

    <!-- 버튼 -->
    <div class="mt-4">
      <button type="button" onclick="check_value()" class="btn btn-dark text-white">결제하기</button>
    </div>
  </div>
</div>
</form>

<?php include "main_bottom.php"; ?>
</div>
</body>
</html>

