<?php
include "common.php";
$order_direct = $_POST['kind'] === 'direct';

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

// 로그인 정보 가져오기
$o_name = $o_tel1 = $o_tel2 = $o_tel3 = $o_email = $o_zip = $o_juso = "";
if (isset($_COOKIE["cookie_id"]) && $_COOKIE["cookie_id"]) {
    $uid = $_COOKIE["cookie_id"];
    $res = mysqli_query($db, "SELECT * FROM member WHERE uid='$uid'");
    if ($res && $row = mysqli_fetch_array($res)) {
        $o_name = $row["name"];
        $o_email = $row["email"];

        // 전화번호 나누기
        $tel_raw = preg_replace("/[^0-9]/", "", $row["tel"]);
        if (strlen($tel_raw) >= 10) {
            $o_tel1 = substr($tel_raw, 0, 3);
            $o_tel2 = substr($tel_raw, 3, 4);
            $o_tel3 = substr($tel_raw, 7, 4);
        }

        // 주소 나누기
        $o_zip = $row["zip"];
        $o_juso = $row["juso"];
    }
}
?>

<!doctype html>
<html lang="kr">
<head>
  <meta charset="utf-8">
  <title>INDUK Mall</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/my.css" rel="stylesheet">
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<?php include "main_top.php"; ?>

<script>
function SameCopy(str) {
  if (str === "Y") {
    form2.r_name.value = form2.o_name.value;
    form2.r_tel1.value = form2.o_tel1.value;
    form2.r_tel2.value = form2.o_tel2.value;
    form2.r_tel3.value = form2.o_tel3.value;
    form2.r_email.value = form2.o_email.value;
    form2.r_zip.value = form2.o_zip.value;
    form2.r_juso.value = form2.o_juso.value;
  } else {
    form2.r_name.value = "";
    form2.r_tel1.value = "";
    form2.r_tel2.value = "";
    form2.r_tel3.value = "";
    form2.r_email.value = "";
    form2.r_zip.value = "";
    form2.r_juso.value = "";
  }
}

function FindZip(kind) {
  window.open("zipcode.php?zip_kind=" + kind, "", "scrollbars=no,width=500,height=300");
}
</script>

<!-- 장바구니 상품 출력 -->
<div class="row m-1 mb-0">
  <div class="col" align="center">
    <h4 class="m-3">주문(배송정보)</h4>
    <hr class="m-0">
    <table class="table table-sm mb-5" style="font-size:14px;">
      <tr height="40" class="bg-light">
        <td width="15%">이미지</td>
        <td width="35%">상품정보</td>
        <td width="15%">판매가</td>
        <td width="20%">수량</td>
        <td width="15%">금액</td>
      </tr>
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

        // 옵션명 조회
        $opt1_name = $opt2_name = "";
        if (is_numeric($opts1) && $opts1 > 0) {
          $res_opt1 = mysqli_query($db, "SELECT name FROM opts WHERE id='$opts1'");
          if ($res_opt1 && $row_opt1 = mysqli_fetch_array($res_opt1)) {
            $opt1_name = $row_opt1["name"];
          }
        }
        if (is_numeric($opts2) && $opts2 > 0) {
          $res_opt2 = mysqli_query($db, "SELECT name FROM opts WHERE id='$opts2'");
          if ($res_opt2 && $row_opt2 = mysqli_fetch_array($res_opt2)) {
            $opt2_name = $row_opt2["name"];
          }
        }

        echo "<tr height='85'>";
        echo "<td><img src='product/{$row['image1']}' width='60' height='70'></td>";
        echo "<td align='left'>{$row['name']}<br><small><b>[옵션]</b> $opt1_name &nbsp; $opt2_name</small></td>";
        echo "<td>" . number_format($price) . "</td>";
        echo "<td>$num</td>";
        echo "<td>" . number_format($total) . "</td>";
        echo "</tr>";
      }

      if ($sum >= 50000) {
        $baesongbi = 0;
      }
      ?>
      <tr height="40" align="right" class="bg-light">
        <td align="center"><img src="images/cart_image1.gif"></td>
        <td colspan="4" class="pe-4">
          <font color="#0066CC">총금액</font> :
          상품( <?=number_format($sum)?> ) + 배송비( <?=number_format($baesongbi)?> )
          = <font style="font-size:16px"><b><?=number_format($sum + $baesongbi)?></b></font>
        </td>
      </tr>
    </table>
  </div>
</div>

<form name="form2" method="post" action="order_pay.php">
  <input type="hidden" name="baesong" value="<?= $baesongbi ?>">
  <input type="hidden" name="total_sum" value="<?= $sum ?>">
    <?php if ($order_direct) { ?>
    <input type="hidden" name="kind" value="direct">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="hidden" name="num" value="<?= $num ?>">
    <input type="hidden" name="opts1" value="<?= $opts1 ?>">
    <input type="hidden" name="opts2" value="<?= $opts2 ?>">
  <?php } ?>

<!-- 주문자 정보 -->
<div class="row mx-1 mt-4">
  <div class="col" align="center">
    <font size="4" color="#B90319"><b>주문정보</b></font>
    <hr class="m-2">
    <table style="font-size:13px;">
      <tr>
        <td align="left" width="20%">이름 <font color="red">*</font></td>
        <td align="left"><input type="text" name="o_name" value="<?=$o_name?>" class="form-control form-control-sm"></td>
      </tr>
      <tr>
        <td align="left">휴대폰 <font color="red">*</font></td>
        <td align="left">
          <input type="text" name="o_tel1" value="<?=$o_tel1?>" maxlength="3" class="form-control form-control-sm d-inline" style="width:70px;"> -
          <input type="text" name="o_tel2" value="<?=$o_tel2?>" maxlength="4" class="form-control form-control-sm d-inline" style="width:80px;"> -
          <input type="text" name="o_tel3" value="<?=$o_tel3?>" maxlength="4" class="form-control form-control-sm d-inline" style="width:80px;">
        </td>
      </tr>
      <tr>
        <td align="left">이메일 <font color="red">*</font></td>
        <td align="left"><input type="text" name="o_email" value="<?=$o_email?>" class="form-control form-control-sm"></td>
      </tr>
      <tr>
        <td align="left">주소 <font color="red">*</font></td>
        <td align="left">
          <input type="text" name="o_zip" value="<?=$o_zip?>" maxlength="5" class="form-control form-control-sm d-inline" style="width:120px;">
          <a href="javascript:FindZip(1)" class="btn btn-sm btn-secondary text-white" style="font-size:12px;">우편번호 찾기</a><br>
          <input type="text" name="o_juso" value="<?=$o_juso?>" class="form-control form-control-sm mt-1">
        </td>
      </tr>
    </table>
  </div>
</div>

<!-- 배송자 정보 -->
<div class="row mx-1 mt-4 mb-4">
  <div class="col" align="center">
    <font size="4" color="#B90319"><b>배송정보</b></font>
    <hr class="m-2">
    <table style="font-size:13px;">
      <tr>
        <td align="left" width="20%">위 내용 복사</td>
        <td align="left">
          <input type="radio" name="same" onclick="SameCopy('Y')"> 예 &nbsp;
          <input type="radio" name="same" onclick="SameCopy('N')"> 아니오
        </td>
      </tr>
      <tr>
        <td align="left">이름 <font color="red">*</font></td>
        <td align="left"><input type="text" name="r_name" class="form-control form-control-sm"></td>
      </tr>
      <tr>
        <td align="left">휴대폰 <font color="red">*</font></td>
        <td align="left">
          <input type="text" name="r_tel1" value="010" maxlength="3" class="form-control form-control-sm d-inline" style="width:70px;"> -
          <input type="text" name="r_tel2" maxlength="4" class="form-control form-control-sm d-inline" style="width:80px;"> -
          <input type="text" name="r_tel3" maxlength="4" class="form-control form-control-sm d-inline" style="width:80px;">
        </td>
      </tr>
      <tr>
        <td align="left">이메일 <font color="red">*</font></td>
        <td align="left"><input type="text" name="r_email" class="form-control form-control-sm"></td>
      </tr>
      <tr>
        <td align="left">주소 <font color="red">*</font></td>
        <td align="left">
          <input type="text" name="r_zip" maxlength="5" class="form-control form-control-sm d-inline" style="width:120px;">
          <a href="javascript:FindZip(2)" class="btn btn-sm btn-secondary text-white" style="font-size:12px;">우편번호 찾기</a><br>
          <input type="text" name="r_juso" class="form-control form-control-sm mt-1">
        </td>
      </tr>
      <tr>
        <td align="left">요구사항</td>
        <td align="left">
          <textarea name="memo" rows="3" class="form-control form-control-sm"></textarea>
        </td>
      </tr>
    </table>
    <div class="mt-3">
      <button type="submit" class="btn btn-dark text-white">&nbsp;다 &nbsp;&nbsp; 음&nbsp;</button>
    </div>
  </div>
</div>

</form>

<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
