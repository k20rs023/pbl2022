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
$rst_id = $_GET['rst_id']; // 店舗ID

// 既存の口コミを探す
$sql = "SELECT * FROM t_review WHERE RST_ID = '{$rst_id}' AND USER_ID = '{$user_id}'";
// データベースへ問合せのSQL($sql)を実行
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

// 問合せ結果を取得
$row = $rs->fetch_assoc();
if ($row) { // 既存の口コミがあるなら既存の値を代入
  $act = 'update';
  $review_point = $row['REVIEW_POINT'];
  $review_comment = $row['REVIEW_COMMENT'];
} else { // 無ければ初期値を代入
  $act = 'insert';
  $review_comment = '';
}
?>

<button onclick="location.href='?do=rst_detail&rst_id=<?= $rst_id ?>'">店舗詳細へ戻る</button>
<h2 style="text-align:center">口コミ投稿・編集</h2>
<form action="?do=review_save&act=<?= $act ?>&rst_id=<?= $rst_id ?>" method="post">
  <input type="hidden" name="act">
  <table align="center">
    <tr>
      <td>
        <font color="red">点数（必須）</font>
      </td>
      <td>
        <div class="stars">
          <span>
            <input id="review5" type="radio" name="review" value="5" required<?php if (isset($review_point) && $review_point == "5") echo 'checked'; ?>><label for="review5">★</label>
            <input id="review4" type="radio" name="review" value="4" <?php if (isset($review_point) && $review_point == "4") echo 'checked'; ?>><label for="review4">★</label>
            <input id="review3" type="radio" name="review" value="3" <?php if (isset($review_point) && $review_point == "3") echo 'checked'; ?>><label for="review3">★</label>
            <input id="review2" type="radio" name="review" value="2" <?php if (isset($review_point) && $review_point == "2") echo 'checked'; ?>><label for="review2">★</label>
            <input id="review1" type="radio" name="review" value="1" <?php if (isset($review_point) && $review_point == "1") echo 'checked'; ?>><label for="review1">★</label>
          </span>
        </div>
      </td>
    </tr>
    <tr>
      <td>コメント</td>
      <td>
        <textarea name="review_comment" maxlength="100" rows="4" cols="35"><?= $review_comment ?></textarea>
      </td>
    </tr>
  </table>
  <p style="text-align:center"><input type="submit" value="登録" class="button"></p>
</form>