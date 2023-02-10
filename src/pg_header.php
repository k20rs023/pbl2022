<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-TYPE" content="text/html; charset=UTF-8">
  <link rel="stylesheet" TYPE="text/css" href="css/style.css">
</head>

<body>
 <div class="wrapper">
    <div id="navbar">
      <?php
      if (isset($_SESSION['usertype_id'])) {
        $user_id = $_SESSION['user_id'];
        $user_nickname = $_SESSION['user_nickname'];
        $account_name = $_SESSION['user_accountname'];
        // echo '<a href="?do=nnpw&user_id=' . $user_id . '">' . $account_name . '&nbsp;(' . $user_nickname . ')</a>&nbsp;&nbsp;&nbsp;';
        // //echo $_SESSION['user_name'].' &nbsp;&nbsp;&nbsp;';
        // $menu = array(); //メニュー項目：プログラム名（拡張子.php省略）
        // if ($_SESSION['usertype_id'] === '1') {  //社員
        //   $menu = array(   //社員メニュー
        //     //'店舗一覧'  => 'rst_list',
        //     '新規店舗登録'  => 'rst_add',
        //     //'ログアウト'  => 'sys_logout',
        //   );
        // } else if ($_SESSION['usertype_id'] === '2') {  //管理者
        //   $menu = array(   //管理者メニュー
        //     '管理者ページ'  => 'manage',
        //     //'店舗一覧'  => 'rst_list',
        //     //'ユーザ一覧'  => 'usr_list',
        //   );
        // } else {
        //   $menu = array(   //ゲストメニュー
        //     //'店舗一覧'  => 'rst_list',
        //   );
        }
      //   foreach ($menu as $label => $action) {
      //     echo  '<a href="?do=' . $action . '">' . $label . '</a>&nbsp;&nbsp;';
      //   }

      //   echo  '<a href="?do=sys_logout">ログアウト</a>&nbsp;&nbsp;';
      // } else {
      //   echo  '<a href="?do=sys_login">ログイン</a>';
      // }
      ?>
      <h2 align="center" class="sansfont">安うまシェフ</h2>
    </div>