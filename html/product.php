<?php
include "common.php";
include "main_top.php";

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM product WHERE id = $id";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($result);

// 옵션용 정보
$is_clothing = ($row['menu'] == 1); // menu가 1이면 의류
$opt1_id = $row['opt1'];
$opt2_id = $row['opt2'];

if ($is_clothing) {
    $sql_opts1 = "SELECT * FROM opts WHERE opt_id = $opt1_id";
    $result_opts1 = mysqli_query($db, $sql_opts1);	

    $sql_opts2 = "SELECT * FROM opts WHERE opt_id = $opt2_id";
    $result_opts2 = mysqli_query($db, $sql_opts2);

    if (!$result_opts1 || !$result_opts2) {
        die('옵션 쿼리 실패: ' . mysqli_error($db));
    }
}

$sold_out = ($row['status'] == 3 || $row['status'] == 2);
$disabled_attr = $sold_out ? "disabled" : "";
?>

<?php if ($sold_out): ?>
    <div class="alert alert-warning text-center my-3" style="font-size:18px; font-weight:bold;">
        판매하지 않는 상품입니다.
    </div>
<?php endif; ?>

<input type="hidden" name="discounted_price" id="discounted_price" value="<?= $row['price'] * (100 - $row['discount']) / 100 ?>">

<script>
function cal_price() {
    let discountedPrice = parseFloat(document.getElementById('discounted_price').value);
    let quantity = parseInt(form2.num.value);
    if (!quantity || quantity < 1) quantity = 1;
    form2.prices.value = (discountedPrice * quantity).toLocaleString();
    form2.num.focus();
}

function check_form2(str) {
    <?php if ($is_clothing): ?>
    if (form2.opts1.value == 0) { alert("옵션1을 선택하십시요."); form2.opts1.focus(); return; }
    if (form2.opts2.value == 0) { alert("옵션2를 선택하십시요."); form2.opts2.focus(); return; }
    <?php endif; ?>
    if (!form2.num.value) { alert("수량을 입력하십시요."); form2.num.focus(); return; }

    form2.action = (str === "D") ? "order.php" : "cart_edit.php";
    form2.kind.value = (str === "D") ? "direct" : "insert";
    form2.submit();
}
</script>

<form name="form2" method="post" action="">
<input type="hidden" name="kind" value="insert">
<input type="hidden" name="id" value="<?=$row['id']?>">
<input type="hidden" name="price" value="<?=$row['price']?>">
<input type="hidden" name="buy_now" value="0">

<div class="row mx-1 my-4">
    <div class="col" align="center">
        <table class="table table-sm table-borderless">
        <tr>
            <td valign="top" align="center" width="50%">
                <img src="product/<?=$row['image1'] ?: 'nopic.png'?>" width="80%" class="img-thumbnail img-fluid mt-2" style="cursor:zoom-in" data-bs-toggle="modal" data-bs-target="#zoomModal">
            </td>
            <td width="50%" align="center" valign="top" class="px-0">
                <hr size="5px" width="100%" class="my-2">
                <table width="100%" style="font-size:12px;" class="table table-sm table-borderless p-0 m-0">
                    <tr height="50">
                        <td colspan="2" align="center" style="font-size:20px; color: #222222;">
                            <?=$row['name']?>
                        </td>
                    </tr>
                    <tr height="35">
                        <td colspan="2" align="center">
                            <?php
                            if ($row['icon_new']) echo "<img src='images/i_new.gif'> ";
                            if ($row['icon_hit']) echo "<img src='images/i_hit.gif'> ";
                            if ($row['icon_sale']) echo "<img src='images/i_sale.gif'> 
                            <font color='red' size='3'>{$row['discount']}%</font>";
                            ?>
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr class="my-2"></td></tr>
                    <tr height="35">
                        <td width="30%" align="center">판매가</td>
                        <td width="70%" align="left" style="font-size:15px;"><strike><?=number_format($row['price'])?></strike></td>
                    </tr>
                    <tr height="35">
                        <td align="center">할인가</td>
                        <td style="font-size:15px;" align="left">
                            <?=number_format($row['price'] * (100 - $row['discount']) / 100)?>
                        </td>
                    </tr>

                    <?php if ($is_clothing): ?>
                    <tr><td colspan="2"><hr class="my-2"></td></tr>
                    <tr>
                        <td align="center">옵션1</td>
                        <td align="left">
                            <select name="opts1" class="form-select form-select-sm mb-2" style="width:90%;font-size:12px;">
                                <option value="0" selected>옵션을 선택하세요.</option>
                                <?php while ($row1 = mysqli_fetch_array($result_opts1)) {
                                    echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
                                } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">옵션2</td>
                        <td align="left">
                            <select name="opts2" class="form-select form-select-sm" style="width:90%;font-size:12px;">
                                <option value="0" selected>옵션을 선택하세요.</option>
                                <?php while ($row2 = mysqli_fetch_array($result_opts2)) {
                                    echo "<option value='{$row2['id']}'>{$row2['name']}</option>";
                                } ?>
                            </select>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr><td colspan="2"><hr class="my-2"></td></tr>
                    <tr>
                        <td align="center">수량</td>
                        <td align="left">
                            <input type="text" name="num" size="5" value="1"
                            class="form-control form-control-sm"
                            style="text-align:center; width: 80px;" 
                            onChange="javascript:cal_price()">
                        </td>
                    </tr>
                    <tr>
                        <td align="center">금액</td>
                        <td align="left">
                            <input type="text" name="prices" value="<?=number_format($row['price'] * (100 - $row['discount']) / 100)?>" size="10" class="form-control form-control-sm" style="border:0;background-color:white;text-align:left;font-size:18px;font-weight:bold;" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" height="100" align="center">
                            <a href="javascript:check_form2('D')" class="btn btn-sm btn-secondary text-light">바로 구매</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="javascript:check_form2('C')" class="btn btn-sm btn-outline-secondary">장바구니</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
</div>
</form>

<!-- ✅ 상세 이미지 및 설명 출력 영역 추가 -->
<div class="row mx-1 mb-5">
  <div class="col text-center">
    <?php if ($row['image2']) : ?>
      <img src="product/<?=$row['image2']?>" class="img-fluid mb-3" style="max-width:100%;">
    <?php endif; ?>
    <?php if ($row['image3']) : ?>
      <img src="product/<?=$row['image3']?>" class="img-fluid mb-3" style="max-width:100%;">
    <?php endif; ?>
    <div style="text-align:left; font-size:14px; padding:20px; border-top:1px solid #ccc;">
      <?= nl2br($row['contents']) ?>
    </div>
  </div>
</div>

<!-- ✅ 확대 이미지 모달 -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center p-0">
        <img src="product/<?=$row['image1'] ?: 'nopic.png'?>" class="img-fluid rounded" style="max-height:90vh;">
      </div>
    </div>
  </div>
</div>

<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
