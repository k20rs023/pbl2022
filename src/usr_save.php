<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"]) || !$_SESSION["islogin"] == 'admin') {
  header("Location: index.php");
  exit();
}
require_once('db_inc.php');
$user_id = $_GET['user_id'];
if (isset($_POST['act'])) {
  $act = $_POST['act'];
  $user_accountname = $_POST['user_accountname'];
  if ($user_accountname === ''){
    echo '<h3>エラー：アカウント名が空なので登録できません</h3>';
    echo '<button onclick="history.back()">ユーザー情報編集へ戻る</button>';
  }
  else if ($_POST['pass1'] === '' && $_POST['pass2'] === '') {
    $sql = "UPDATE t_user SET user_accountname ='{$user_accountname}' WHERE USER_ID='{$user_id}'";
    $sth = $conn->query($sql);
    echo '<h3>アカウントが更新されました</h3>';
    echo '<button onclick="location.href = \'?do=usr_list\'">ユーザー一覧へ戻る</button>';
  } else if ($_POST['pass1'] === $_POST['pass2']) {
    $user_accountname = $_POST['user_accountname'];
    $upass = $_POST['pass1'];
    $sql = "UPDATE t_user SET user_accountname ='{$user_accountname}',user_password='{$upass}' WHERE user_id='{$user_id}'";
    //echo $sql;
    $conn->query($sql);
    echo '<h3>アカウントが更新されました</h3>';
    echo '<button onclick="location.href = \'?do=usr_list\'">ユーザー一覧へ戻る</button>';
  } else {
    echo '<h3>エラー：パスワードが一致しないので登録できません</h3>';
    echo '<button onclick="history.back()">ユーザー情報編集へ戻る</button>';
  }
}
?>