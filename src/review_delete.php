<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (isset($_SESSION["islogin"]) && ($_SESSION["user_id"] == $_GET['user_id'] || $_SESSION["user_id"] == 'admin')) {
} else {
    header("Location: index.php");
    exit();
}
?>

<?php
require_once('db_inc.php');
$rst_id = $_GET['rst_id'];
if (isset($_GET['review_id2'])) {
    $review_id = $_GET['review_id2'];
    $sql = "DELETE FROM t_review WHERE review_id='{$review_id}'";
    $conn->query($sql);
    header('Location:?do=rst_detail&rst_id=' . $rst_id);
} else {
    $review_id = $_GET['review_id'];
    echo '<h2>レビューを本当に削除しますか?</h2>';
    echo '<button onclick= "location.href=\'?do=review_delete&review_id=' . $review_id . '&user_id=' . $user_id . '&rst_id=' . $rst_id . '&review_id2=' . $review_id . '\'" class="deletebutton">削除</button>';
    echo '<button onclick= "location.href=\'?do=rst_detail&rst_id=' . $rst_id . '\'" class="button">戻る</button>';
}
