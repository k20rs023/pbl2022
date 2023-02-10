<style>
  caption {
    font-weight: bold;
    font-size: large;
  }

  reviewbutton {
    text-align: right;
  }
</style>

<button onclick="location.href='?do=rst_list'">店舗一覧へ戻る</button>
<h1 style="text-align:center">店舗詳細</h1>

<?php
require_once('db_inc.php');
if (isset($_SESSION["user_id"])) {
  $loginuser = $_SESSION['user_id'];
} else {
  $loginuser = 'guest';
}
$rst_id = $_GET['rst_id'];

// 既存の店舗情報を検索するSQL文
$sql = "SELECT * FROM t_rstinfo WHERE RST_ID='{$rst_id}'";
// データベースへ問合せのSQL($sql)を実行する・・・
$rs = $conn->query($sql);;
if (!$rs) die('エラー: ' . $conn->error);

//問合せ結果を取得し、それぞれの変数に代入しておく
$row = $rs->fetch_assoc();;
if ($row) { // 既存の店舗情報を編集するために、変数に代入
  $_SESSION['rst_id'] = $row['RST_ID'];
  $user_id = $row['USER_ID'];
  $rst_id = $row['RST_ID']; //店舗ID
  $rst_name = $row['RST_NAME']; //店舗名
  $rst_address = $row['RST_ADDRESS'];  //住所
  $rst_start = $row['RST_START']; //営業開始時間
  $rst_close = $row['RST_CLOSE']; //営業終了時間
  $rst_telnum = $row['RST_TELNUM']; //電話番号
  $rst_type = $row['RST_TYPE']; //店舗の種類
  $rst_price = $row['RST_PRICE']; //価格帯
  $rst_takeout = $row['RST_TAKEOUT']; //テイクアウト
  $rst_note = $row['RST_NOTE']; //備考
  $rst_date = $row['RST_DATE']; //最終更新日
  $rst_holiday = $row['RST_HOLIDAY']; //営業曜日
  $rst_foodgenre = $row['RST_FOODGENRE']; //料理のジャンル
}

$sql = "SELECT AVG(REVIEW_POINT) FROM t_review WHERE RST_ID='{$rst_id}'";
$rs = $conn->query($sql);;
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();;
if ($row) {
  $averagepoint =  $row['AVG(REVIEW_POINT)'];
}
?>



<table align="center">
  <caption class="reviewbutton">
    <?php
    if (isset($_SESSION["islogin"]) && $_SESSION['usertype_id'] == 1) { //社員のみ口コミ投稿
      echo '<div align="right"><button onclick = "location.href=\'?do=review&rst_id=' . $rst_id . '\'" class="button">口コミ投稿・編集</button><div>';
    }
    ?>
  </caption>
  <tr>
    <td>
      <!-- 店舗情報表示用-->
      <table align="left">
        <tr>
          <td>
            <h2><?= $rst_name ?></h2>
          </td>
        </tr>
        <tr>
          <td>
            住所：<?= $rst_address ?>
          </td>
        </tr>
        <tr>
          <td>
            電話番号：<?= $rst_telnum ?>
          </td>
        </tr>
        <tr>
          <td>店休日：
            <?php
            $rhtmp = '';
            if (substr($rst_holiday, 1, 1) === '0') $rhtmp .= '月&nbsp;/&nbsp;';
            if (substr($rst_holiday, 2, 1) === '0') $rhtmp .= '火&nbsp;/&nbsp;';
            if (substr($rst_holiday, 3, 1) === '0') $rhtmp .= '水&nbsp;/&nbsp;';
            if (substr($rst_holiday, 4, 1) === '0') $rhtmp .= '木&nbsp;/&nbsp;';
            if (substr($rst_holiday, 5, 1) === '0') $rhtmp .= '金&nbsp;/&nbsp;';
            if (substr($rst_holiday, 6, 1) === '0') $rhtmp .= '土&nbsp;/&nbsp;';
            if (substr($rst_holiday, 7, 1) === '0') $rhtmp .= '日&nbsp;/&nbsp;';
            $rhtmp = substr($rhtmp, 0, -13);
            echo $rhtmp;
            ?>
          </td>
        </tr>
        <tr>
          <td>営業時間帯：<?= $rst_start ?>～<?= $rst_close ?></td>
        </tr>
        <tr>
          <td>店舗の種類：
            <?php
            if ($rst_type === '1') echo '喫茶店&nbsp;';
            if ($rst_type === '2') echo 'ファストフード&nbsp;';
            if ($rst_type === '3') echo '居酒屋&nbsp;';
            if ($rst_type === '4') echo 'バイキング&nbsp;';
            if ($rst_type === '5') echo 'レストラン&nbsp;';
            if ($rst_type === '6') echo 'ファミリーレストラン&nbsp;';
            if ($rst_type === '7') echo '定食屋&nbsp;';
            if ($rst_type === '8') echo 'その他&nbsp;';
            ?>
          </td>
        </tr>
        <tr>
          <td>料理のジャンル：
            <?php
            $fdtmp = '';
            if (substr($rst_foodgenre, 1, 1) === '1') $fdtmp .= '和食&nbsp;/&nbsp;';
            if (substr($rst_foodgenre, 2, 1) === '1') $fdtmp .= '洋食&nbsp;/&nbsp;';
            if (substr($rst_foodgenre, 3, 1) === '1') $fdtmp .= '中華&nbsp;/&nbsp;';
            if (substr($rst_foodgenre, 4, 1) === '1') $fdtmp .= 'エスニック&nbsp;/&nbsp;';
            if (substr($rst_foodgenre, 5, 1) === '1') $fdtmp .= '焼肉&nbsp;/&nbsp;';
            if (substr($rst_foodgenre, 6, 1) === '1') $fdtmp .= '麺類&nbsp;/&nbsp;';
            if (substr($rst_foodgenre, 7, 1) === '1') $fdtmp .= 'カレー&nbsp;/&nbsp;';
            if (substr($rst_foodgenre, 8, 1) === '1') $fdtmp .= '創作料理&nbsp;/&nbsp;';
            $fdtmp = substr($fdtmp, 0, -13);
            echo $fdtmp;
            ?>
          </td>
        </tr>
        <tr>
          <td>価格帯：
            <?php
            if ($rst_price === '1') echo '￥0～￥500&nbsp;';
            if ($rst_price === '2') echo '￥501～￥1000&nbsp;';
            if ($rst_price === '3') echo '￥1001～￥2000&nbsp;';
            if ($rst_price === '4') echo '￥2001～&nbsp;';
            ?>
          </td>
        </tr>
        <tr>
          <td>テイクアウト：
            <?php
            if ($rst_takeout === '1') echo '○';
            else echo '×';
            ?>
          </td>
        </tr>
        <tr>
          <td>備考：<?= $rst_note ?></td>
        </tr>
        <tr>
          <td>
            <?php
            if ($user_id == $loginuser || $loginuser == 'admin') { //店舗登録者or管理者なら店舗編集
              echo '<a href="?do=rst_edit&rst_id=' . $rst_id . '" class="button">店舗編集</a>';
            }
            ?>
          </td>
        </tr>
        <tr>
          <td>最終更新日：<?= $rst_date ?></td>
        </tr>
      </table>
    </td>
    <td>
      <!-- 口コミ一覧など表示用-->
      <table align="left">
        <caption>口コミ平均点数：★ <?= substr($averagepoint, 0, 4); ?></caption>
        <tr>
          <td>
          </td>
        </tr>
        <tr>
          <td align="right">
            <?php
            $review_sort = isset($_POST['review_sort_pull']) ? $_POST['review_sort_pull'] : '1';
            if (!isset($_POST['review_sort_pull'])) {
              $review_sort = isset($_SESSION['review_sort']) ? $_SESSION['review_sort'] : '1';
            }
            ?>
            <form action="?do=rst_detail&rst_id=<?= $rst_id ?>" method="post" align="right">
              <select name="review_sort_pull">
                <option value="1" <?php if ($review_sort == 1) echo 'selected'; ?>>更新日順(降順)</option>
                <option value="2" <?php if ($review_sort == 2) echo 'selected'; ?>>更新日順(昇順)</option>
                <option value="3" <?php if ($review_sort == 3) echo 'selected'; ?>>口コミの点数順(降順)</option>
                <option value="4" <?php if ($review_sort == 4) echo 'selected'; ?>>口コミの点数順(昇順)</option>
              </select>
              <input type="submit" value="並び替え">
            </form>
          </td>
        </tr>
        <tr>
          <br>
        </tr>

        <?php
        require_once('db_inc.php');
        define('MAX_ROWS', 5);

        // 一覧データを検索するSQL文(並べ替え選択によって変化)
        if ($review_sort == 1) {
          $sql = "SELECT * FROM t_review JOIN t_user ON t_review.user_id = t_user.user_id WHERE RST_ID='{$rst_id}' ORDER BY t_user.USER_ID='{$loginuser}'DESC, review_date DESC";
        } else if ($review_sort == 2) {
          $sql = "SELECT * FROM t_review JOIN t_user ON t_review.user_id = t_user.user_id WHERE RST_ID='{$rst_id}' ORDER BY t_user.USER_ID='{$loginuser}'DESC, review_date";
        } else if ($review_sort == 3) {
          $sql = "SELECT * FROM t_review JOIN t_user ON t_review.user_id = t_user.user_id WHERE RST_ID='{$rst_id}' ORDER BY t_user.USER_ID='{$loginuser}'DESC, review_point DESC";
        } else {
          $sql = "SELECT * FROM t_review JOIN t_user ON t_review.user_id = t_user.user_id WHERE RST_ID='{$rst_id}' ORDER BY t_user.USER_ID='{$loginuser}'DESC, review_point";
        }
        $_SESSION['review_sort'] = $review_sort;

        //データベースへ問合せのSQL文($sql)を実行
        $rs = $conn->query($sql);
        if (!$rs) die('エラー: ' . $conn->error);
        $num_rows = mysqli_num_rows($rs);
        $max_page = ceil($num_rows / MAX_ROWS);
        if ($num_rows == 0) {
          echo '<tr><td>&emsp;&emsp;&emsp;口コミはありません。</td></tr>';
        } else {
          $page = isset($_GET['p']) ? $_GET['p'] : 1;
          if ($page < 1) $page = 1;
          if ($page > $max_page) $page = $max_page;
          $offset = ($page - 1) * MAX_ROWS;
          $sql = sprintf("%s LIMIT %d OFFSET %d", $sql, MAX_ROWS, $offset);
          $rs = $conn->query($sql);
          $row = $rs->fetch_assoc();
        ?>
          <tr>
            <td>
              <table align="right" border=1>
                <caption>口コミ一覧</caption>
                <tr>
                  <th>ニックネーム</th>
                  <th>評価</th>
                  <th>コメント</th>

                </tr>
                <?php
                while ($row) {
                  //1行ずつ繰り返し出力
                  echo '<tr>';
                  echo '<td>' . $row['USER_NICKNAME'] . '</td>';
                  echo '<td>★' . $row['REVIEW_POINT'] . '</td>';
                  echo '<td>' . $row['REVIEW_COMMENT'] . '</td>';
                  if ($loginuser == $row['USER_ID'] || $loginuser == 'admin') { //口コミ投稿者or管理者
                    echo '<td><a href="?do=review_delete&rst_id=' . $rst_id . '&user_id=' . $row['USER_ID'] . '&review_id=' . $row['REVIEW_ID'] . '" class="deletebutton">削除</a></td></tr>';
                  }
                  echo '</tr>';
                  $row = $rs->fetch_assoc(); //次の行へ
                }
                ?>
              </table>
            </td>
          </tr>
          <tr>
            <td align="right">
            <?php
            $pagef = 1 + ($page - 1) * 5;
            $pagel = $page * 5;
            if ($pagel >= $num_rows) {
              $pagel = $num_rows;
            }
            echo $pagef . '件目～' . $pagel . '件目/全' . $num_rows . '件&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            // ページ切り替えのリンク
            for ($j = 1; $j <= $max_page; $j++) {
              $f = $j;
              if ($j == $page) {
                echo $j, ' ';
              } else {
                printf('<a href="?do=rst_detail&rst_id=' . $rst_id . '&reviewsort=' . $review_sort . '&p=%d">%d</a>&nbsp;&nbsp; ', $j, $j);
              }
            }
          }
            ?>
            </td>
          </tr>
      </table>
    </td>
  </tr>
</table>