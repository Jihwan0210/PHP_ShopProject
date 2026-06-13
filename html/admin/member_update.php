<?php
    include "../common.php";

    $id = $_REQUEST["id"];
    $pwd = $_REQUEST["pwd"];
    $name = $_REQUEST["name"];
    $pwd1 = $_REQUEST["pwd1"];
    $tel1 = $_REQUEST["tel1"];
    $tel2 = $_REQUEST["tel2"];
    $tel3 = $_REQUEST["tel3"];
    $zip = $_REQUEST["zip"];
    $juso = $_REQUEST["juso"];
    $email = $_REQUEST["email"];
    $birthday1 = $_REQUEST["birthday1"];
    $birthday2 = $_REQUEST["birthday2"];
    $birthday3 = $_REQUEST["birthday3"];
    $gubun = $_REQUEST["gubun"];

    $tel = sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3);
    $birthday = sprintf("%04d-%02d-%02d", $birthday1, $birthday2, $birthday3);

    // id가 문자열일 경우를 대비해서 작은따옴표로 감싸기
    $sql = "UPDATE member SET 
                pwd='$pwd', 
                name='$name', 
                tel='$tel', 
                zip='$zip', 
                juso='$juso', 
                email='$email', 
                birthday='$birthday', 
                gubun='$gubun' 
            WHERE id='$id'";

    $result = mysqli_query($db, $sql);
    if (!$result) exit("에러: $sql");

    echo("<script>location.href='member.php'</script>");
?>
