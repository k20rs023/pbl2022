<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"]) || !$_SESSION["islogin"] == 'admin') {
  header("Location: index.php");
  exit();
}
?>

<?php
require_once('db_inc.php');
if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
  echo '<h2>' . $user_id . 'を本当に削除しますか?</h2>';
  echo '<button onclick= "location.href=\'?do=usr_delete&user_id2=' . $user_id . '\'" class="deletebutton">削除</button>';
  echo '<button onclick= "history.back()" class="button">戻る</button>';
} else if (isset($_GET['user_id2'])) {
  $user_id = $_GET['user_id2'];
  $sql = "DELETE FROM t_user WHERE user_id='{$user_id}'";
  $conn->query($sql);
  header('Location:?do=usr_list');
} else {
  echo '<h2>削除するユーザIDは与えられていません</h2>';
  echo '<a href="?do=usr_list">戻る</a>';
}
