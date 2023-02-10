<?php
require_once('db_inc.php'); //データベースが必要なので読み込ませる
$u = $_POST['uid'];
$p = $_POST['pass'];
$sql = "SELECT * FROM t_user WHERE USER_ID = '{$u}' AND USER_PASSWORD ='{$p}'";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();
if ($row) { //Login succeeded
  $_SESSION['islogin'] = true;
  $_SESSION['user_id']  = $row['USER_ID'];
  $_SESSION['user_nickname'] = $row['USER_NICKNAME'];
  $_SESSION['user_password']  = $row['USER_PASSWORD'];
  $_SESSION['user_accountname']  = $row['USER_ACCOUNTNAME'];
  $_SESSION['usertype_id'] = $row['USERTYPE_ID'];
  $usertype_id = $row['USERTYPE_ID']; //ユーザー種別ID
  if ($usertype_id === '1') { //社員
    header('Location:index.php');
    exit();
  } else if ($usertype_id === '2') { //管理者
    header('Location:?do=manage');
    exit();
  }
} else {
  header('Location:?do=sys_login');
  exit();
}
