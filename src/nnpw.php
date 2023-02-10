<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"])) {
    header("Location: index.php");
    exit();
}
?>

<?php
require_once('db_inc.php');
$user_id = $_GET['user_id'];
// 既存アカウントの情報を検索するSQL文
$sql = "SELECT * FROM t_user WHERE USER_ID='{$user_id}'";
// データベースへ問合せのSQL($sql)を実行する・・・
$rs = $conn->query($sql);;
if (!$rs) die('エラー: ' . $conn->error);

//問合せ結果を取得し、それぞれの変数に代入しておく
$row = $rs->fetch_assoc();;
if ($row) { // 既存アカウントを編集するために、変数に代入
    $user_nickname = $row['USER_NICKNAME'];
    $_SESSION['user_id'] = $row['USER_ID'];
}
?>
<button onclick="location.href='?do=rst_list'">店舗一覧へ戻る</button>
<h1 style="text-align:center">ニックネーム・パスワード編集</h1>
<form action="?do=nnpw_save" method="post">
    <table align="center">
        <tr>
            <td>
                <font color="red">現在のパスワード(必須)：</font>
            </td>
            <td>
                <input type="password" name="pw" required minlength="4" maxlength="12" size="20">
            </td>
        </tr>
        <tr>
            <td>ニックネーム</td>
            <td>
                <input type="text" name="nickname" required minlength="1" maxlength="12" size="20" value="<?php echo $user_nickname; ?>">
            </td>
        </tr>
        <tr>
            <td>新しいパスワード</td>
            <td>
                <input type="password" name="npw1" minlength="4" maxlength="12" size="20">
            </td>
        </tr>
        <tr>
            <td>新しいパスワード（再入力）</td>
            <td>
                <input type="password" name="npw2" minlength="4" maxlength="12" size="20">
            </td>
        </tr>
    </table>
    <p style="text-align:center"><input type="submit" value="登録" class="button"></p>
</form>