<?php
include "common.php";

$uid = $_POST["uid"] ?? "";
$pwd = $_POST["pwd"] ?? "";

// 필수 항목 확인
if (!$uid || !$pwd) {
    echo "<script>alert('아이디와 비밀번호를 입력하세요.'); history.back();</script>";
    exit;
}

// 아이디와 비밀번호가 일치하는 사용자 조회
$sql = "SELECT * FROM member WHERE uid='$uid' AND pwd='$pwd'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($result);
$count = mysqli_num_rows($result);

// 로그인 성공 처리
if ($count > 0) {
    // uid 또는 id를 저장할 수 있음 (여기서는 uid 저장)
    setcookie("cookie_id", $row['uid'], time() + 86400, "/");
    echo "<script>location.href='index.html';</script>";
} else {
    echo "<script>alert('로그인 정보가 일치하지 않습니다.'); location.href='member_login.php';</script>";
}
?>
