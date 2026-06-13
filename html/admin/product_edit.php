<?php
include "../common.php";

$id = $_REQUEST['id'] ?? 0;
if (!$id) exit("상품 ID 없음");

$query = "SELECT * FROM product WHERE id=$id";
$result = mysqli_query($db, $query);
if (!$result) exit("쿼리 오류: $query");
$row = mysqli_fetch_array($result);


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
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/my.css" rel="stylesheet">
	<script src="../js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>
<div class="container">
<script> document.write(admin_menu()); </script>

<form name="form1" method="post" action="product_update.php" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$id?>">

<div class="row mx-1 justify-content-center">
<div class="col" align="center">
<h4 class="m-0 mb-3">제품 수정</h4>

<table class="table table-sm table-bordered myfs12 m-0 p-0">

<tr>
	<td class="bg-light" width="15%">상품분류</td>
	<td align="left" class="ps-2">
		<select name="menu" class="form-select form-select-sm bg-light myfs12" style="width:120px">
									<?php
for ($i = 0; $i < $n_menu; $i++) {
    $tmp = ($i == $row["menu"]) ? "selected" : "";
    echo("<option value='$i' $tmp>" . $a_menu[$i] . "</option>");
}
echo("</select>");
    ?>
	</td>
</tr>

<tr>
	<td class="bg-light">상품코드</td>
	<td align="left" class="ps-2">
<input type="text" name="code" value="<?=$row["code"]?>" class="form-control form-control-sm" style="width: 200px; text-align: left;">

	</td>
</tr>

<tr>
	<td class="bg-light">상품명</td>
	<td align="left" class="ps-2">
		<input type="text" name="name" value="<?=$row["name"]?>" class="form-control form-control-sm" style="width: 1000px; text-align: left;">
	</td>
</tr>

<tr>
	<td class="bg-light">제조사</td>
	<td align="left" class="ps-2">
<input type="text" name="coname" value="<?=$row["coname"]?>" class="form-control form-control-sm text-start" style="width: 400px;">

	</td>
</tr>

<tr>
	<td class="bg-light">판매가</td>
	<td align="left" class="ps-2">
<input type="text" name="price" value="<?=$row["price"]?>" 
	class="form-control form-control-sm text-start d-inline" 
	style="width: 100px;"> 원


	</td>
</tr>

<tr>
		<td class="bg-light">옵션</td>
	<td align="left" class="ps-2">
		<div class="d-inline-flex align-items-center gap-2">
    <select name="opt1" class="form-select form-select-sm bg-light myfs12" style="width:100px; text-align:left;">
        <option value="0" selected>옵션 선택</option>
        <?php
			foreach ($opt_list as $row1) {
            $selected = ($row["opt1"] == $row1["id"]) ? "selected" : ""; 
            echo("<option value='{$row1['id']}' $selected>{$row1['name']}</option>");
        }
        ?>
    </select>
			<select name="opt2" class="form-select form-select-sm bg-light myfs12" style="width:100px; text-align:left;">
				<option value="0" selected>옵션 선택</option>
				<?php
			foreach ($opt_list as $row1) {
            $selected = ($row["opt2"] == $row1["id"]) ? "selected" : ""; 
            echo("<option value='{$row1['id']}' $selected>{$row1['name']}</option>");
        }
        ?>
				
			</select>
		</div>
	</td>
</tr>


<tr>
	<td class="bg-light">제품설명</td>
	<td align="left" class="ps-2">
		<textarea name="contents" rows="5" class="form-control"><?=$row["contents"]?></textarea>
	</td>
</tr>

<tr>
	<td class="bg-light">상품상태</td>
	<td align="left" class="ps-2 pt-2">
		<input type="radio" name="status" value="1" <?=$row["status"]==1?"checked":""?>> 판매중 &nbsp;
		<input type="radio" name="status" value="2" <?=$row["status"]==2?"checked":""?>> 판매중지 &nbsp;
		<input type="radio" name="status" value="3" <?=$row["status"]==3?"checked":""?>> 품절
	</td>
</tr>

<tr>
	<td class="bg-light">아이콘</td>
	<td align="left" class="ps-2">
		<input type="checkbox" name="icon_new" value="1" <?=$row["icon_new"]==1?"checked":""?>> New &nbsp;
		<input type="checkbox" name="icon_hit" value="1" <?=$row["icon_hit"]==1?"checked":""?>> Hit &nbsp;
		<input type="checkbox" name="icon_sale" value="1" <?=$row["icon_sale"]==1?"checked":""?>> Sale &nbsp;
		할인율:
		<input type="text" name="discount" value="<?=$row["discount"]?>" size="3" class="form-control form-control-sm d-inline" style="width:60px"> %
	</td>
</tr>

<tr>
	<td class="bg-light">등록일</td>
	<td align="left" class="ps-2">
<input type="date" name="regday" value="<?=$row["regday"]?>" 
	class="form-control form-control-sm text-start" 
	style="width: 160px; display: inline-block;">

	</td>
</tr>

<tr>
	<td class="bg-light">이미지</td>
	<td align="left" class="ps-2">
		<!-- 이미지 1 -->
		<div class="mb-2 d-flex align-items-center">
			<img src="../product/<?=($row["image1"] ?: "nopic.png")?>" width="50" height="50" class="img-thumbnail me-2"
				data-bs-toggle="modal" data-bs-target="#zoomModal"
				onclick="document.getElementById('zoomModalLabel').innerText='이미지1'; picname.src='../product/<?=($row["image1"] ?: "nopic.png")?>'">
			<input type="hidden" name="imagename1" value="<?=$row["image1"]?>">
			<input type="checkbox" name="checkno1" value="1"> 삭제
			&nbsp;&nbsp;<?=$row["image1"]?>
			&nbsp;&nbsp;<input type="file" name="image1" class="form-control form-control-sm myfs12" style="width:250px">
		</div>

		<!-- 이미지 2 -->
		<div class="mb-2 d-flex align-items-center">
			<img src="../product/<?=($row["image2"] ?: "nopic.png")?>" width="50" height="50" class="img-thumbnail me-2"
				data-bs-toggle="modal" data-bs-target="#zoomModal"
				onclick="document.getElementById('zoomModalLabel').innerText='이미지2'; picname.src='../product/<?=($row["image2"] ?: "nopic.png")?>'">
			<input type="hidden" name="imagename2" value="<?=$row["image2"]?>">
			<input type="checkbox" name="checkno2" value="1"> 삭제
			&nbsp;&nbsp;<?=$row["image2"]?>
			&nbsp;&nbsp;<input type="file" name="image2" class="form-control form-control-sm myfs12" style="width:250px">
		</div>

		<!-- 이미지 3 -->
		<div class="mb-2 d-flex align-items-center">
			<img src="../product/<?=($row["image3"] ?: "nopic.png")?>" width="50" height="50" class="img-thumbnail me-2"
				data-bs-toggle="modal" data-bs-target="#zoomModal"
				onclick="document.getElementById('zoomModalLabel').innerText='이미지3'; picname.src='../product/<?=($row["image3"] ?: "nopic.png")?>'">
			<input type="hidden" name="imagename3" value="<?=$row["image3"]?>">
			<input type="checkbox" name="checkno3" value="1"> 삭제
			&nbsp;&nbsp;<?=$row["image3"]?>
			&nbsp;&nbsp;<input type="file" name="image3" class="form-control form-control-sm myfs12" style="width:250px">
		</div>
	</td>
</tr>

</table>

<a href="javascript:form1.submit();" class="btn btn-sm btn-dark text-white my-2">저 장</a>
<a href="javascript:history.back();" class="btn btn-sm btn-outline-dark my-2">돌아가기</a>

</div>
</div>
</form>
</div>

<!-- Zoom Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title" id="zoomModalLabel">이미지 확대</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="닫기"></button>
			</div>
			<div class="modal-body text-center">
				<img src="#" name="picname" class="img-fluid img-thumbnail" data-bs-dismiss="modal">
			</div>
		</div>
	</div>
</div>
</body>
</html>
