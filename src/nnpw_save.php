<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"])) {
  header("Location: index.php");
  exit();
}
?>

<?php
require_once('db_inc.php');
$u = $_SESSION['user_id'];
$p = $_POST['pw'];
$sql = "SELECT * FROM t_user WHERE USER_ID= '{$u}' AND USER_PASSWORD='{$p}'";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();
if ($row) {
  $user_nickname = $_POST['nickname']; //ニックネーム

  if ($_POST['npw1'] == '') {
    $sql = "UPDATE t_user SET USER_NICKNAME='{$user_nickname}' WHERE USER_ID='{$user_id}'";
    $sth = $conn->query($sql);
    $_SESSION['user_accountname'] = $account_name;
    $_SESSION['user_nickname'] = $user_nickname;
    echo '<h3>アカウントが更新されました</h3>';
    echo '<button onclick="location.href = \'?do=rst_list\'">店舗一覧へ戻る</button>';
  } else {
    if ($_POST['npw1'] === $_POST['npw2']) {
      $npw1 = $_POST['npw1'];
      $sql = "UPDATE t_user SET USER_NICKNAME='{$user_nickname}', USER_PASSWORD='{$npw1}' WHERE USER_ID='{$user_id}'";
      $sth = $conn->query($sql);
      $_SESSION['user_accountname'] = $account_name;
      $_SESSION['user_nickname'] = $user_nickname;
      echo '<h3>アカウントが更新されました</h3>';
      echo '<button onclick="location.href = \'?do=rst_list\'">店舗一覧へ戻る</button>';
    } else {
      echo '<h3>「新しいパスワード」と「新しいパスワード(確認用)」には同じ内容を入力してください</h3>';
      echo '<input type="button" onclick="history.back()" value="戻る">';
    }
  }
} else {
  echo '<h3>現在のパスワードが違います</h3>';
  echo '<input type="button" onclick="history.back()" value="戻る">';
}
