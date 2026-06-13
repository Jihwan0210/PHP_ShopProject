<?php
include "../common.php";

// ✅ 어제~오늘 기본값 설정
$today = date("Y-m-d");
$yesterday = date("Y-m-d", strtotime("-1 day"));

$day1 = $_REQUEST["day1"] ?? $yesterday;
$day2 = $_REQUEST["day2"] ?? $today;

$sel1 = $_REQUEST["sel1"] ?? 0;
$sel2 = $_REQUEST["sel2"] ?? 1;
$text1 = $_REQUEST["text1"] ?? "";

$s = array(); $k = 0;
if ($day1 && $day2) $s[$k++] = "jumunday BETWEEN '$day1' AND '$day2'";
if ($sel1 != 0) $s[$k++] = "state=$sel1";

if ($text1) {
    if ($sel2 == 1) $s[$k++] = "id LIKE '%$text1%'";
    else if ($sel2 == 2) $s[$k++] = "o_name LIKE '%$text1%'";
    else if ($sel2 == 3) $s[$k++] = "product_names LIKE '%$text1%'";
}

$condition = implode(" AND ", $s);
if ($condition) $condition = "WHERE " . $condition;

$sql = "SELECT * FROM jumun $condition ORDER BY id DESC";

$args = "day1=$day1&day2=$day2&sel1=$sel1&sel2=$sel2&text1=$text1";

$result = mypagination($sql, $args, $count, $pagebar);

$order_states = [
    1 => "주문신청", 2 => "주문확인", 3 => "입금확인",
    4 => "배송중", 5 => "주문완료", 6 => "주문처리취소"
];
$state_colors = [
    1 => "black", 2 => "black", 3 => "black",
    4 => "red", 5 => "blue", 6 => "green"
];
$pay_kinds = [0 => "카드", 1 => "무통장"];
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall 주문관리</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/my.css" rel="stylesheet">
	<script src="../js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<script> document.write(admin_menu());</script>

<script>
	function go_update(id,pos) {
		state = form1.state[pos].value;
		location.href="jumun_update.php?id="+id+"&state="+state+"&<?=$args?>&page="+form1.page.value;
	}
	function search_clear() {
		form1.day1.value = "";
		form1.day2.value = "";
		form1.sel1.value = "0";
		form1.sel2.value = "1";
		form1.text1.value = "";
		form1.page.value = 1;
		form1.submit();
	}
</script>

<div class="row mx-1 justify-content-center">
	<div class="col" align="center">

	<h4 class="m-0 mb-3">주문 관리</h4>

	<form name="form1" method="post" action="jumun.php">
		<input type="hidden" name="page" value="1">

		<table class="table table-sm table-borderless m-0 p-0">
			<tr>
				<td width="20%" align="left" style="padding-top:8px">
					주문수 : <font color="red"><?=$count?></font>
				</td>
				<td align="right">
					기간:
					<div class="d-inline-flex">
						<input type="date" name="day1" value="<?=$day1?>" class="form-control form-control-sm" style="width:120px">~
						<input type="date" name="day2" value="<?=$day2?>" class="form-control form-control-sm" style="width:120px">
					</div>
					<div class="d-inline-flex">
						<select name="sel1" class="form-select form-select-sm bg-light myfs12" style="width:100px">
							<option value="0" <?=($sel1==0)?"selected":""?>>전체</option>
							<?php foreach ($order_states as $key => $val) : ?>
								<option value="<?=$key?>" <?=($sel1==$key)?"selected":""?>><?=$val?></option>
							<?php endforeach; ?>
						</select>&nbsp;
						<select name="sel2" class="form-select bg-light myfs12" style="width:105px">
							<option value="1" <?=($sel2==1)?"selected":""?>>주문번호</option>
							<option value="2" <?=($sel2==2)?"selected":""?>>주문자명</option>
							<option value="3" <?=($sel2==3)?"selected":""?>>상품명</option>
						</select>
					</div>
					<div class="d-inline-flex">
						<div class="input-group input-group-sm">
							<input type="text" name="text1" value="<?=$text1?>" class="form-control myfs12" style="width:100px"
							onKeydown="if(event.keyCode==13){form1.page.value=1; form1.submit();}">
							<button class="btn mycolor1 myfs12" type="submit" onclick="form1.page.value=1;">검색</button>
						</div>
					</div>
					<div class="d-inline-flex">
						<a href="javascript:search_clear()" class="btn btn-sm mycolor1 myfs12 ms-2">초기화</a>
					</div>
				</td>
			</tr>
		</table>

		<table class="table table-sm table-bordered table-hover my-1">
			<tr class="bg-light">
				<td>주문번호</td>
				<td>주문일</td>
				<td width="30%">상품명</td>
				<td width="5%">수량</td>
				<td>금액</td>
				<td>주문자</td>
				<td width="5%">결제</td>
				<td width="20%">주문상태</td>
				<td width="5%">삭제</td>
			</tr>
			<?php
			$pos = 0;
			while ($row = mysqli_fetch_array($result)) {
				$id = $row['id'];
				$date = $row['jumunday'];
				$products = $row['product_names'];

				$sql2 = "SELECT SUM(num) as total_qty FROM jumuns WHERE jumun_id='$id' AND product_id > 0";
				$res2 = mysqli_query($db, $sql2);
				$row2 = mysqli_fetch_array($res2);
				$count = $row2['total_qty'] ?? 0;

				$price = number_format($row['totalprice']);
				$name = $row['o_name'];
				$pay = $pay_kinds[$row['pay_kind']] ?? "기타";
				$state = $row['state'];
				$state_text = $order_states[$state] ?? "미정";
				$color = $state_colors[$state] ?? "black";
			?>
			<tr>
				<td class="mywordwrap"><a href="jumun_info.php?id=<?=$id?>" style="color:#0085dd"><?=$id?></a></td>
				<td><?=$date?></td>
				<td align="left" class="mywordwrap"><?=$products?></td>
				<td><?=$count?></td>
				<td align="right" class="mywordwrap"><?=$price?></td>
				<td><?=$name?></td>
				<td><?=$pay?></td>
				<td>
					<div class="d-sm-inline-flex">
						<select name="state" class="form-select form-select-sm myfs12 me-1" style="color:<?=$color?>">
							<?php foreach ($order_states as $key => $val) : ?>
								<option value="<?=$key?>" <?=($key==$state)?"selected":""?>><?=$val?></option>
							<?php endforeach; ?>
						</select>
						<a href="javascript:go_update('<?=$id?>', <?=$pos?>)" class="btn btn-sm mybutton-blue" style="width:50px;">수정</a>
					</div>
				</td>
				<td><a href="jumun_delete.php?id=<?=$id?>&<?=$args?>&page=<?=$page?>" class="btn btn-sm mybutton-red" onclick="return confirm('삭제할것인가요?');">삭제</a></td>
			</tr>
			<?php $pos++; } ?>
		</table>

		<?=$pagebar?>

	</form>

	</div>
</div>

</div>

</body>
</html>