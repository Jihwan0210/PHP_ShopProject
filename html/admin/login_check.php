<?
    include "../common.php";
    $adminid =$_POST["adminid"];
    $adminpw =$_POST["adminpw"];

    if ($adminid == $admin_id && $adminpw == $admin_pw)
    {
        setcookie("cookie_admin","yes", 0, "/");
        echo("<script>location.href='member.php'</script>");
    }
    else
		setcookie("cookie_admin","", -1, "/");
        echo("<script>location.href='index.html'</script>");
?>
