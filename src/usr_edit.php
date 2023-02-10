<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"]) || !$_SESSION["islogin"] == 'admin') {
  header("Location: index.php");
  exit();
}
?>

<?php
require_once('db_inc.php');
$user_id = $_GET['user_id'];
$sql = "SELECT * FROM t_user WHERE USER_ID ='{$user_id}'";
$rs = $conn->query($sql);;
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();;
if ($row) {
  $act = 'update';
  $user_accountname = $row['USER_ACCOUNTNAME'];
  $usertype_id = $row['USERTYPE_ID'];
}
?>

<button onclick="location.href='?do=usr_list'">ユーザー一覧画面へ戻る</button>
<h1 style="text-align:center">ユーザー情報編集</h1>
<form action="?do=usr_save&user_id=<?= $user_id ?>" method="post">
  <input type="hidden" name="act" value="<?php echo $act; ?>">
  <table align="center">
    <tr>
      <td>ユーザID：</td>

      <td><?php echo $user_id; ?></td>

    <tr>
      <td>アカウント名：</td>
      <td><input type="text" name="user_accountname" required value="<?php echo $user_accountname; ?>"></td>
    </tr>
    <tr>
      <td>新しいパスワード：</td>
      <td>
        <input type="password" name="pass1">
      </td>
    </tr>
    <tr>
      <td>新しいパスワード（確認用）：</td>
      <td>
        <input type="password" name="pass2">
      </td>
    </tr>
  </table>
  <p style="text-align:center"><input type="submit" value="決定" class="button"></p>
</form>