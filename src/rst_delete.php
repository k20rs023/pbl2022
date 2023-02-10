<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"])) {
    header("Location: index.php");
    exit();
}
?>

<?php
require_once('db_inc.php');
if (isset($_GET['rst_id'])) {
    $rst_id = $_GET['rst_id'];
    $rst_name = $_GET['rst_name'];

    echo '<h2>' . $rst_name . 'を本当に削除しますか?</h2>';
    echo '<button onclick= "location.href=\'?do=rst_delete&rst_id2=' . $rst_id . '\'" class="deletebutton">削除</button>';
    echo '<button onclick= "location.href=\'?do=rst_list\'" class="button">戻る</button>';
} else if (isset($_GET['rst_id2'])) {
    $rst_id = $_GET['rst_id2'];
    $sql = "DELETE FROM t_rstinfo WHERE rst_id='{$rst_id}'";
    $conn->query($sql);
    header('Location:?do=rst_list');
} else {
    echo '<h2>削除する店舗IDは与えられていません</h2>';
    echo '<a href="?rst_list">戻る</a>';
}
