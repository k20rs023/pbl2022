<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"]) || !$_SESSION["islogin"] == 'admin') {
  header("Location: index.php");
  exit();
}
?>

<style>
  table {
    border-collapse: collapse
  }

  table tr {
    border: 2px solid #333;
  }

  caption {
    font-weight: bold;
    caption-side: bottom;
    text-align: right;
  }
</style>

<button onclick="location.href='?do=manage'">管理者ページへ戻る</button>
<h2 align="center">ユーザー一覧</h2>

<?php
require_once('db_inc.php');
define('MAX_ROWS', 5);

// 一覧するデータを検索するSQL
$sql = "SELECT * FROM t_user WHERE usertype_ID='1' ORDER BY USER_ID";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

$num_rows = mysqli_num_rows($rs);
$max_page = ceil($num_rows / MAX_ROWS);

$page = isset($_GET['p']) ? $_GET['p'] : 1;
if ($page < 1) $page = 1;
if ($page > $max_page) $page = $max_page;
$offset = ($page - 1) * MAX_ROWS;

$sql = sprintf("%s LIMIT %d OFFSET %d", $sql, MAX_ROWS, $offset);
$rs = $conn->query($sql);
?>


<table border=1 align="center">
  <caption>
    <?php
    // ページ切り替えのリンクを作る
    for ($j = 1; $j <= $max_page; $j++) {
      if ($j == $page) echo $j, ' ';
      else printf('<a href="?do=usr_list&p=%d">%d</a> ', $j, $j);
    }
    ?>
  </caption>
  <!-- まず、ヘッド部分（項目名）を出力 -->
  <tr>
    <th>アカウント名</th>
    <th>ニックネーム</th>
    <th>ユーザーID</th>
    <th>ユーザー編集</th>
    <th>ユーザー削除</th>
  </tr>
  <?php
  // ユーザID（user_id）、ユーザ名(user_name)、ユーザ種別(usertype_id)を一覧表示
  $row = $rs->fetch_assoc();
  while ($row) {
    //問合せ結果を取得
    echo '<tr align="center">';
    echo '<td>' . $row['USER_ACCOUNTNAME'] . '</td>';
    echo '<td>' . $row['USER_NICKNAME'] . '</td>';
    echo '<td>' . $row['USER_ID'] . '</td>';

    echo '<td><a href="?do=usr_edit&user_id=' . $row['USER_ID'] . '" class="button">編集</a></td>';
    echo '<td><a href="?do=usr_delete&user_id=' . $row['USER_ID'] . '" class="deletebutton">削除</a></td>';
    echo '</tr>';
    $row = $rs->fetch_assoc(); //次の行へ
  }
  ?>
</table>