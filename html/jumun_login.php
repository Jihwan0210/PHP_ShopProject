<?php
include "common.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

// 비회원 주문조회 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($db, $_POST["name"] ?? "");
    $email = mysqli_real_escape_string($db, $_POST["email"] ?? "");

    if ($name && $email) {
        $sql = "SELECT * FROM jumun WHERE o_name='$name' AND o_email='$email' LIMIT 1";
        $result = mysqli_query($db, $sql);

        if ($row = mysqli_fetch_array($result)) {
            // 쿠키로 이름과 이메일 저장 후 jumun.php로 이동
            setcookie("non_member_name", $name, time() + 3600, "/");
            setcookie("non_member_email", $email, time() + 3600, "/");

            echo "<script>location.href='jumun.php';</script>";
            exit;
        } else {
            echo "<script>alert('정보가 틀렸습니다.'); history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('이름과 이메일을 입력하세요.'); history.back();</script>";
        exit;
    }
}
?>

<!-- 아래는 기존 HTML 입력 폼 유지 -->
<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INDUK Mall - 비회원 주문조회</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
<?php include "main_top.php"; ?>

<script>
    function NoMember_Check() {
        if (!form2.name.value) {
            alert("이름을 입력해 주십시오.");
            form2.name.focus();
            return;
        }
        if (!form2.email.value) {
            alert("E-Mail을 입력해 주십시오.");
            form2.email.focus();
            return;
        }
        form2.submit();
    }
</script>

<form name="form2" method="post" action="jumun_login.php">
    <div class="row mb-0">
        <div class="col"></div>
        <div class="col" align="center">
            <h3 class="mt-5">비회원 주문조회</h3>
            <hr size="4px" class="m-0 mb-5">
            <table width="340" height="200" style="border:4px solid #e2e2e2" bgcolor="#fcfcfc" class="table-borderless">
                <tr>
                    <td align="center">
                        <table class="table table-borderless mt-3">
                            <tr height="45">
                                <td width="20%">이름</td>
                                <td width="50%">
                                    <div class="d-inline-flex">
                                        <input type="text" name="name" size="20" value="" tabindex="1"
                                               class="form-control form-control-sm">
                                    </div>
                                </td>
                                <td width="30%" rowspan="2">
                                    <a href="javascript:NoMember_Check();" tabindex="3"
                                       class="btn btn-sm btn-dark text-white mx-0 pt-4"
                                       style="height:75px;width:75px;">로그인</a>
                                </td>
                            </tr>
                            <tr height="45">
                                <td>E-Mail</td>
                                <td>
                                    <div class="d-inline-flex">
                                        <input type="text" name="email" size="20" value="" tabindex="2"
                                               class="form-control form-control-sm">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td><hr class="m-0"></td></tr>
                <tr height="50">
                    <td align="center">※ 회원님은 로그인 후, 이용하세요.</td>
                </tr>
            </table>
        </div>
        <div class="col"></div>
    </div>
</form>

<br><br><br><br><br>
<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
