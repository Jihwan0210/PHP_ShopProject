<?php
include "../common.php";
$sql = "SELECT * FROM opt ORDER BY name";
$result = mysqli_query($db, $sql);
if (!$result) exit("쿼리에러");

$opt_list = [];
while($row1 = mysqli_fetch_array($result)) {
	$opt_list[] = $row1;
}
?>
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<title>INDUK Mall</title>
	<link  href="../css/bootstrap.min.css" rel="stylesheet">
	<link  href="../css/my.css" rel="stylesheet">
	<script src="../js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<script> document.write(admin_menu());</script>

<form name="form1" method="post" action="product_insert.php" enctype="multipart/form-data">

<div class="row mx-1 justify-content-center">
	<div class="col" align="center">

	<h4 class="m-0 mb-3">제품 등록</h4>

	<table class="table table-sm table-bordered myfs12 m-0 p-0">
	<tr>
		<td class="bg-light" width="15%">상품분류</td>
		<td align="left" class="ps-2">
			<select name="menu" class="form-select form-select-sm bg-light myfs12" style="width:120px; text-align:left;">
				<?php
				for ($i = 0; $i < $n_menu; $i++) {
					echo("<option value='$i'>{$a_menu[$i]}</option>");
				}
				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="bg-light">상품코드</td>
		<td align="left" class="ps-2">
			<input type="text" name="code" value="" class="form-control form-control-sm" style="width:200px;">
		</td>
	</tr>

	<tr>
		<td class="bg-light">상품명</td>
		<td align="left" class="ps-2">
			<input type="text" name="name" value="" placeholder="예: 마크곤잘레스 - 블랙 " class="form-control form-control-sm" style="width:1000px;">
		</td>
	</tr>

	<tr>
		<td class="bg-light">제조사</td>
		<td align="left" class="ps-2">
			<input type="text" name="coname" value="" class="form-control form-control-sm" style="width:400px;">
		</td>
	</tr>

	<tr>
		<td class="bg-light">판매가</td>
		<td align="left" class="ps-2">
			<input type="text" name="price" value="" class="form-control form-control-sm d-inline" style="width:100px;"> 원
		</td>
	</tr>

	<tr>
		<td class="bg-light">옵션</td>
		<td align="left" class="ps-2">
			<div class="d-inline-flex align-items-center gap-2">
				<select name="opt1" class="form-select form-select-sm bg-light myfs12" style="width:100px;">
					<option value="0" selected>옵션 선택</option>
					<?php foreach ($opt_list as $row1) {
						echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
					} ?>
				</select>

				<select name="opt2" class="form-select form-select-sm bg-light myfs12" style="width:100px;">
					<option value="0" selected>옵션 선택</option>
					<?php foreach ($opt_list as $row1) {
						echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
					} ?>
				</select>
			</div>
		</td>
	</tr>

	<tr>
		<td class="bg-light">제품설명</td>
		<td align="left" class="ps-2">
			<textarea name="contents" rows="5" placeholder="상품 상세설명을 입력하세요" class="form-control form-control-sm myfs12" style="width:1000px;"></textarea>
		</td>
	</tr>

	<tr>
		<td class="bg-light">상품상태</td>
		<td align="left" class="ps-2 pt-2">
			<input class="form-check-input" type="radio" name="status" value="1" checked> 판매중 &nbsp;
			<input class="form-check-input" type="radio" name="status" value="2"> 판매중지 &nbsp;
			<input class="form-check-input" type="radio" name="status" value="3"> 품절
		</td>
	</tr>

	<tr>
		<td class="bg-light">아이콘</td>
		<td align="left" class="ps-2">
			<input type="checkbox" name="icon_new" value="1" checked> New &nbsp;
			<input type="checkbox" name="icon_hit" value="1"> Hit &nbsp;
			<input type="checkbox" name="icon_sale" value="1"> Sale &nbsp;
			할인율:
			<input type="text" name="discount" value="" size="2" maxlength="3"
				class="form-control form-control-sm d-inline"
				style="width:60px;"> %
		</td>
	</tr>

	<tr>
		<td class="bg-light">등록일</td>
		<td align="left" class="ps-2">
			<input type="date" name="regday" value="<?=date('Y-m-d')?>"
				class="form-control form-control-sm"
				style="width:160px; display:inline-block;">
		</td>
	</tr>

	<tr>
		<td class="bg-light">이미지</td>
		<td align="left" class="ps-2">
			<b>이미지1 :</b> <input type="file" name="image1" class="form-control form-control-sm myfs12 mb-1" style="width:250px">
			<small class="text-muted">※ .jpg 확장자 권장</small><br>
			<b>이미지2 :</b> <input type="file" name="image2" class="form-control form-control-sm myfs12 mb-1" style="width:250px"><br>
			<b>이미지3 :</b> <input type="file" name="image3" class="form-control form-control-sm myfs12" style="width:250px">
		</td>
	</tr>
	</table>

	<a href="javascript:form1.submit();" class="btn btn-sm btn-dark text-white my-2">저 장</a>
	<a href="javascript:history.back();" class="btn btn-sm btn-outline-dark my-2">돌아가기</a>

	</div>
</div>
</form>
</div>
</body>
</html>
