<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"]) || !$_SESSION["islogin"] == 'admin') {
    header("Location: index.php");
    exit();
}
?>

<h1 style="text-align:center">管理者ページ</h1>

<table align="center">
    <tr>
        <td>
            <button style="height: 50px; width: 200px;" onclick="location.href = '?do=usr_list'">ユーザー一覧</button>
        </td>
    </tr>
    <tr>
        <td>
            <br>
        </td>
    </tr>
    <tr>
        <td>
            <button style="height: 50px; width: 200px;" onclick="location.href = '?do=rst_list'">店舗一覧</button>
        </td>
    </tr>
    <tr>
        <td>
            <br>
        </td>
    </tr>
    <tr>
        <td>
            <button style="height: 50px; width: 200px;" onclick="location.href = '?do=sys_logout'">ログアウト</button>
        </td>
    </tr>
</table>