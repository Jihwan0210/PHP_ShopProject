<?php
include "common.php";

// POST 데이터 받기
$id = $_POST["id"] ?? "";
$uid = $_POST["uid"] ?? "";
$pwd = $_POST["pwd"] ?? "";
$pwd1 = $_POST["pwd1"] ?? "";
$name = $_POST["name"] ?? "";
$tel1 = $_POST["tel1"] ?? "";
$tel2 = $_POST["tel2"] ?? "";
$tel3 = $_POST["tel3"] ?? "";
$zip = $_POST["zip"] ?? "";
$juso = $_POST["juso"] ?? "";
$email = $_POST["email"] ?? "";
$birthday1 = $_POST["birthday1"] ?? "";
$birthday2 = $_POST["birthday2"] ?? "";
$birthday3 = $_POST["birthday3"] ?? "";

// 유효성 체크
if (!$id || !$name || !$tel1 || !$zip || !$juso) {
    echo "<script>alert('필수 항목이 누락되었습니다.'); history.back();</script>";
    exit;
}

// 전화번호, 생일 조합
$tel = $tel1 . $tel2 . $tel3;
$birthday = $birthday1 . "-" . $birthday2 . "-" . $birthday3;

// 비밀번호 확인 일치 검사
if ($pwd !== $pwd1) {
    echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
    exit;
}

// SQL 실행
$sql = "UPDATE member SET 
            pwd = '$pwd',
            name = '$name',
            tel = '$tel',
            zip = '$zip',
            juso = '$juso',
            email = '$email',
            birthday = '$birthday'
        WHERE id = $id";

$result = mysqli_query($db, $sql);
$result=mysqli_query($db, $sql);
	if (!$result) exit("에러 : $sql");
	
	echo("<script>location.href='index.html'</script>");
?>
