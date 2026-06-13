<!---------------------------------------------------------------------------------------------
	제목 : 내 손으로 만드는 PHP 쇼핑몰무 따라하기 (실습용 디자인 HTML)
	소속 : 인덕대학교 컴퓨터소프트웨어학과
	이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->
<?php
$db = mysqli_connect("localhost", "zip", "zips", "zip");
if (!$db) exit("DB연결에러");
$sel = $_REQUEST["sel"] ?? 1;
$text1 = $_REQUEST["text1"] ?? "";
$zip_kind = $_REQUEST["zip_kind"] ?? 1;
?>

<!doctype html>
<html lang="kr" style="overflow:hidden">
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

<div class="container-fluid">
<script>
function SearchZip() {
  if (!form.text1.value) {
    alert("검색하실 도로명이나 건물명을 입력해 주십시오.");
    form.text1.focus();
    return;
  }
  form.submit();
}

function SendZip(zip_kind) {
  zip_kind = zip_kind || parseInt(document.form.zip_kind.value);

  if (form1.jusor.value === "") {
    alert("나머지 주소를 입력하여 주십시오.");
    form1.jusor.focus();
    return;
  }
  var str = form1.post_no.value;
  var parts = str.split("^^");
  var zip = parts[0];
  var juso = parts[1] + " " + form1.jusor.value;

  if (zip_kind === 1) {
    opener.form2.o_zip.value = zip;
    opener.form2.o_juso.value = juso;
  } else if (zip_kind === 2) {
    opener.form2.r_zip.value = zip;
    opener.form2.r_juso.value = juso;
  } else {
    opener.form2.zip.value = zip;
    opener.form2.juso.value = juso;
  }
  self.close();
}
</script>

<div class="row m-0">
  <div class="col bg-light" align="center">
    <h4 class="m-2">우편번호 (Zipcode)</h4>
  </div>
  <hr class="my-0">
</div>

<div class="row m-1 mb-0">
  <div class="col" align="center">
    <br><br>
    <form name="form" method="post" action="zipcode.php">
      <input type="hidden" name="zip_kind" value="<?= $zip_kind ?>">
      <div align="left">
        <font size="2" color="#666666"><b>검색할 도로명이나 건물명 일부를 입력해 주세요</b></font>
        <div class="d-inline-flex mt-1">
          <div class="input-group input-group-sm">
            <select name="sel" class="form-select form-select-sm bg-light" style="width:100px;font-size:13px">
              <option value="1" <?= $sel==1 ? 'selected' : '' ?>>서울</option>
              <option value="2" <?= $sel==2 ? 'selected' : '' ?>>경기</option>
              <option value="3" <?= $sel==3 ? 'selected' : '' ?>>인천</option>
              <option value="4" <?= $sel==4 ? 'selected' : '' ?>>강원</option>
              <option value="5" <?= $sel==5 ? 'selected' : '' ?>>충북</option>
              <option value="6" <?= $sel==6 ? 'selected' : '' ?>>세종</option>
              <option value="7" <?= $sel==7 ? 'selected' : '' ?>>충남</option>
              <option value="8" <?= $sel==8 ? 'selected' : '' ?>>대전</option>
              <option value="9" <?= $sel==9 ? 'selected' : '' ?>>경북</option>
              <option value="10" <?= $sel==10 ? 'selected' : '' ?>>대구</option>
              <option value="11" <?= $sel==11 ? 'selected' : '' ?>>울산</option>
              <option value="12" <?= $sel==12 ? 'selected' : '' ?>>부산</option>
              <option value="13" <?= $sel==13 ? 'selected' : '' ?>>경남</option>
              <option value="14" <?= $sel==14 ? 'selected' : '' ?>>전북</option>
              <option value="15" <?= $sel==15 ? 'selected' : '' ?>>전남</option>
              <option value="16" <?= $sel==16 ? 'selected' : '' ?>>광주</option>
              <option value="17" <?= $sel==17 ? 'selected' : '' ?>>제주</option>
            </select>
            <input type="text" name="text1" value="<?= $text1 ?>" class="form-control" style="width:150px;">
            <a href="javascript:SearchZip()" class="btn btn-sm btn-outline-secondary" style="width:50px;font-size:13px">검색</a>
          </div>
        </div>
      </div>
    </form>
    <br>
    <form name="form1">
      <div class="d-inline-flex w-100 mb-1">
        <select name="post_no" class="form-select form-select-sm bg-light" style="font-size:13px">
          <?php
          if ($text1) {
            $sql = "SELECT * FROM zip$sel WHERE juso4 LIKE '%$text1%' OR juso7 LIKE '%$text1%'";
            $result = mysqli_query($db, $sql);
            if (!$result) exit("에러: $sql <br>" . mysqli_error($db));
            foreach ($result as $row) {
              $zip = $row["zip"];
              $A = $row["juso1"] . " " . $row["juso2"] . " " . $row["juso3"] . " " . $row["juso4"];
              if ($row["juso5"]) $A .= " " . $row["juso5"];
              if ($row["juso6"] != "0") $A .= "-" . $row["juso6"];
              if ($row["juso7"]) $A .= " " . $row["juso7"];
              echo "<option value='$zip^^$A'>[$zip] $A</option>";
            }
          } else {
            echo "<option></option>";
          }
          ?>
        </select>
      </div>
      <div class="d-inline-flex w-100 mb-2">
        <input type="text" name="jusor" id="jusor" value="" class="form-control form-control-sm" style="font-size:13px">
      </div>
      <font size="2" color="#666666"><b>나머지 주소를 입력해 주세요</b></font>
    </form>
    <br><br>
    <a href="javascript:SendZip();" class="btn btn-sm btn-dark text-white myfont">확 인</a>
  </div>
</div>
</div>
</body>
</html>
