<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"])) {
    header("Location: index.php");
    exit();
}
?>

<?php
require_once('db_inc.php');
$user_id = $_SESSION['user_id']; // ユーザーID
$act = $_GET['act']; // 新規登録か編集か
$rst_id = $_GET['rst_id']; // 店舗ID

$review_point = $_POST['review']; // 点数
$review_comment = $_POST['review_comment']; // コメント
date_default_timezone_set('Asia/Tokyo'); //タイムゾーンを東京に設定
$review_date = date('Y-m-d H:i:s'); //最終更新日時

// 口コミ登録
if ($act === 'insert') {
    $sql = "INSERT INTO t_review(RST_ID,REVIEW_POINT,REVIEW_COMMENT,USER_ID,REVIEW_DATE) VALUES ('{$rst_id}','{$review_point}','{$review_comment}','{$user_id}','{$review_date}')";
} else { // 口コミ編集
    $sql = "UPDATE t_review SET REVIEW_POINT='{$review_point}', REVIEW_COMMENT='{$review_comment}' WHERE RST_ID = '{$rst_id}' AND USER_ID='{$user_id}'";
}
$conn->query($sql);
echo '<h3>口コミが登録されました</h3>';
echo '<button onclick = "location.href=\'?do=rst_detail&rst_id=' . $rst_id . '\'">店舗詳細へ戻る</button>';
