<style>
  ul {
    margin: 0px 0px 15px 0px;
    padding: 0px 0px 0px 0px;
  }

  li {
    color: #404040;
    border-left: solid 6px #1fa67a;
    /*左側の線*/
    border-bottom: solid 2px #dadada;
    /*下に灰色線*/
    background: whitesmoke;
    margin-bottom: 5px;
    /*下のバーとの余白*/
    line-height: 1.5;
    padding: 0.5em;
    list-style-type: none !important;
    /*ポチ消す*/
    font-weight: bold;
  }

  table {
    border-collapse: collapse
  }

  table tr {
    border: 2px solid #333;
  }
</style>
<?php
//絞り込み
if (!isset($_SESSION['type'])) {
  $type = 0;
  $foodgenre = 0;
  $price = 0;
  $takeout = 0;
} else {
  $type = $_SESSION['type'];
  $foodgenre = $_SESSION['foodgenre'];
  $price = $_SESSION['price'];
  $takeout = $_SESSION['takeout'];
}
if (isset($_POST['type'])) {
  $type = $_POST['type'];
  $foodgenre = $_POST['foodgenre'];
  $price = $_POST['price'];
  if (isset($_POST['takeout'])) {
    $takeout = 1;
  } else {
    $takeout = 0;
  }
}

$_SESSION['type'] = $type;
$_SESSION['foodgenre'] = $foodgenre;
$_SESSION['price'] = $price;
$_SESSION['takeout'] = $takeout;
?>
<div class="container">
  <div class="side">
    <form action="?do=rst_list" method="post">
      <ul>
        <li>店舗の種類</li>
        <select name="type">
          <option value="0" <?php if ($type == 0) echo 'selected'; ?>> 選択なし</option>
          <option value="1" <?php if ($type == 1) echo 'selected'; ?>> 喫茶店</option>
          <option value="2" <?php if ($type == 2) echo 'selected'; ?>> ファストフード</option>
          <option value="3" <?php if ($type == 3) echo 'selected'; ?>> 居酒屋</option>
          <option value="4" <?php if ($type == 4) echo 'selected'; ?>> バイキング</option>
          <option value="5" <?php if ($type == 5) echo 'selected'; ?>> レストラン</option>
          <option value="6" <?php if ($type == 6) echo 'selected'; ?>> ファミリーレストラン</option>
          <option value="7" <?php if ($type == 7) echo 'selected'; ?>> 定食屋</option>
          <option value="8" <?php if ($type == 8) echo 'selected'; ?>> その他</option>
        </select>
      </ul>
      <br>
      <ul>
        <li>料理のジャンル</li>
        <select name="foodgenre">
          <option value="0" <?php if ($foodgenre == 0) echo 'selected'; ?>> 選択なし</option>
          <option value="1" <?php if ($foodgenre == 1) echo 'selected'; ?>> 和食</option>
          <option value="2" <?php if ($foodgenre == 2) echo 'selected'; ?>> 洋食</option>
          <option value="3" <?php if ($foodgenre == 3) echo 'selected'; ?>> 中華</option>
          <option value="4" <?php if ($foodgenre == 4) echo 'selected'; ?>> エスニック</option>
          <option value="5" <?php if ($foodgenre == 5) echo 'selected'; ?>> 焼肉</option>
          <option value="6" <?php if ($foodgenre == 6) echo 'selected'; ?>> 麺類</option>
          <option value="7" <?php if ($foodgenre == 7) echo 'selected'; ?>> カレー</option>
          <option value="8" <?php if ($foodgenre == 8) echo 'selected'; ?>> 創作料理</option>
        </select>
      </ul>
      <br>
      <ul>
        <li>価格帯</li>
        <select name="price">
          <option value="0" <?php if ($price == 0) echo 'selected'; ?>>選択なし</option>
          <option value="1" <?php if ($price == 1) echo 'selected'; ?>>￥0～￥500</option>
          <option value="2" <?php if ($price == 2) echo 'selected'; ?>>￥501～￥1000</option>
          <option value="3" <?php if ($price == 3) echo 'selected'; ?>>￥1001～￥2000</option>
          <option value="4" <?php if ($price == 4) echo 'selected'; ?>>￥2001～</option>
        </select>
      </ul>
      <br>
      <ul>
        <li>テイクアウト</li>
        <input type="checkbox" name="takeout" value="1" <?php if ($takeout == 1) echo 'checked'; ?> />テイクアウト可
      </ul>
      <br>
      <!--<input type="hidden" name="k" value="a">-->
      <p style="text-align:center"><input type="submit" value="絞り込む">
    </form>
  </div>

  <div class="main">
    <?php
    require_once('db_inc.php');
    echo '<div class="frame">';
    echo '<h1 style="display: inline-block;">店舗一覧</h1>';
    if (isset($_SESSION["user_id"])) {
      $loginuser = $_SESSION['user_id'];
      echo '<span style="text-align:right;">';
      echo '<a href="?do=nnpw&user_id=' . $user_id . '">' . $account_name . '&nbsp;(' . $user_nickname . ')</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      if ($_SESSION['usertype_id'] === '1') {  //社員
        echo  '<a href="?do=rst_add" class="button">新規店舗登録</a>&nbsp;&nbsp;';
        echo  '<a href="?do=sys_logout" class="button">ログアウト</a>&nbsp;&nbsp;';
      } else if ($_SESSION['usertype_id'] === '2') {  //管理者
        echo  '<a href="?do=manage" class="button">管理者ページ</a>&nbsp;&nbsp;';
      }
      echo '</span>';
    } else {
      $loginuser = 'guest';
      echo '<span style="text-align:right;">';
      echo 'ゲスト&nbsp;&nbsp;';
      echo  '<a href="?do=sys_login" class="button">ログイン</a>';
      echo '</span>';
    }
    echo '</div>';

    // 店舗名検索
    if (!isset($_SESSION['keywd']))
      $keywd = '';
    else
      $keywd = $_SESSION['keywd'];
    if (isset($_POST['keywd'])) $keywd = $_POST['keywd'];
    $_SESSION['keywd'] = $keywd;

    echo '<form action="?do=rst_list" method="post">';
    printf('<input type="text" name="keywd" value="%s" placeholder="店舗名検索">', $keywd);
    echo '<input type="submit" value="検索">';
    echo '</form>';
    ?>

    <!-- 並べ替え -->
    <?php
    $rst_sort = isset($_POST['rst_sort_pull']) ? $_POST['rst_sort_pull'] : '1';
    if (!isset($_POST['rst_sort_pull'])) {
      $rst_sort = isset($_SESSION['rst_sort']) ? $_SESSION['rst_sort'] : '1';
    }
    ?>
    <form action="?do=rst_list" method="post" align="right">
      <select name="rst_sort_pull">
        <option value="1" <?php if ($rst_sort == 1) echo 'selected'; ?>>更新日順(降順)</option>
        <option value="2" <?php if ($rst_sort == 2) echo 'selected'; ?>>更新日順(昇順)</option>
        <option value="3" <?php if ($rst_sort == 3) echo 'selected'; ?>>口コミの点数順(降順)</option>
        <option value="4" <?php if ($rst_sort == 4) echo 'selected'; ?>>口コミの点数順(昇順)</option>
      </select>
      <input type="submit" value="並び替え">
    </form>

    <br>

    <?php
    define('MAX_ROWS', 5); //MAX_ROWS: 1ページに表示する最大行数

    //SQL文作成
    $where = '';
    if (!empty($_SESSION['keywd']) || !empty($type) || !empty($foodgenre) || !empty($price) || !empty($takeout) || !empty($favorite)) {
      $where = 'WHERE ';

      //キーワード検索  
      if (!empty($_SESSION['keywd'])) {
        $keywd = $_SESSION['keywd'];
        $where .= "RST_NAME like '%$keywd%' AND ";
      }
      //絞り込み検索
      if (!empty($foodgenre)) {
        $sql_g = "SELECT RST_FOODGENRE FROM t_rstinfo";
        $rs = $conn->query($sql_g);
        if (!$rs) die('エラー: ' . $conn->error);
        $c = 0;
        while ($row = $rs->fetch_assoc()) {
          $genre = $row['RST_FOODGENRE'];
          if (substr($genre, $foodgenre, 1) === '1') {
            $genre_array[$c++] = $genre;
          }
        }
        if (!empty($genre_array)) {
          $where .= "RST_FOODGENRE in (";
          foreach ($genre_array as $g) {
            $where .= "'{$g}', ";
          }
          $where = rtrim($where, ', ');
          $where .= ') AND ';
        }
        if (substr($where, -6) == 'WHERE ') {
          $where .= " RST_TYPE = '-1' AND ";
        }
      }
      if (!empty($type)) $where .= "RST_TYPE = '{$type}' AND ";
      if (!empty($price)) $where .= "RST_PRICE = '{$price}' AND ";
      if (!empty($takeout)) $where .= "RST_TAKEOUT = '{$takeout}' AND ";
      //if (!empty($favorite)) $where .= "RST_ = '{$favorite}'";
      $where = rtrim($where, 'AND ');
      $sql = "SELECT t_rstinfo.RST_ID AS RST_ID,
      t_rstinfo.USER_ID, RST_NAME, RST_ADDRESS, RST_START, RST_CLOSE, RST_TELNUM, RST_TYPE, RST_PRICE, RST_NOTE, RST_TAKEOUT, RST_HOLIDAY, RST_FOODGENRE, RST_DATE 
      FROM t_rstinfo LEFT OUTER JOIN t_review ON t_rstinfo.RST_ID = t_review.RST_ID $where";
    } else {
      //全件表示
      $sql = "SELECT t_rstinfo.RST_ID AS RST_ID,
      t_rstinfo.USER_ID, RST_NAME, RST_ADDRESS, RST_START, RST_CLOSE, RST_TELNUM, RST_TYPE, RST_PRICE, RST_NOTE, RST_TAKEOUT, RST_HOLIDAY, RST_FOODGENRE, RST_DATE 
      FROM t_rstinfo LEFT OUTER JOIN t_review ON t_rstinfo.RST_ID = t_review.RST_ID";
    }

    //並べ替え選択
    if ($rst_sort == 1) {
      $sql .= ' GROUP BY t_rstinfo.RST_ID ORDER BY RST_DATE DESC';
    } else if ($rst_sort == 2) {
      $sql .= ' GROUP BY t_rstinfo.RST_ID ORDER BY RST_DATE';
    } else if ($rst_sort == 3) {
      $sql .= ' GROUP BY t_rstinfo.RST_ID ORDER BY AVG(REVIEW_POINT) DESC, t_rstinfo.RST_DATE DESC';
    } else {
      $sql .= ' GROUP BY t_rstinfo.RST_ID ORDER BY AVG(REVIEW_POINT) IS NULL ASC, AVG(REVIEW_POINT) ASC, t_rstinfo.RST_DATE DESC';
    }
    $_SESSION['rst_sort'] = $rst_sort;

    // echo $_SESSION['type'];
    // echo $_SESSION['foodgenre'];
    // echo $_SESSION['price'];
    // echo $_SESSION['takeout'];
    // echo $_SESSION['rst_sort'];
    // echo $sql;

    //sql登録
    $rs = $conn->query($sql);
    //if (!$rs) die('エラー: ' . $conn->error);

    //結果の行数$num_rows, 最大ページ数$max_pageを計算する
    $num_rows = mysqli_num_rows($rs);
    $max_page = ceil($num_rows / MAX_ROWS);
    if ($num_rows == 0) {
      echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;店舗が見つかりませんでした。<br>";
    } else {
      //表示したいページの番号、行番号を求める
      $page = isset($_GET['p']) ? $_GET['p'] : 1;
      if ($page < 1) $page = 1; //無効なページ番号を回避
      if ($page > $max_page) $page = $max_page;
      $offset = ($page - 1)  * MAX_ROWS;

      //指定ページの結果を取り出す
      $sql = sprintf("%s LIMIT %d OFFSET %d", $sql, MAX_ROWS, $offset);
      $rs = $conn->query($sql);
      if (!$rs) die('エラー: ' . $conn->error);
      $codes = [0 => '', 1 => '喫茶店', 2 => 'ファストフード', 3 => '居酒屋', 4 => 'バイキング', 5 => 'レストラン', 6 => 'ファミリーレストラン', 7 => '定食屋', 8 => 'その他'];

      // 店舗一覧表示
      echo '<table style="width: 100%">';
      while ($row = $rs->fetch_assoc()) {
        $rst_id = $row['RST_ID']; //店舗ID
        $sql_avg = "SELECT AVG(REVIEW_POINT) FROM t_review WHERE RST_ID='{$rst_id}'";
        $rs_avg = $conn->query($sql_avg);
        if (!$rs_avg) die('エラー: ' . $conn->error);
        $row_avg = $rs_avg->fetch_assoc();
        if ($row_avg) {
          $averagepoint =  $row_avg['AVG(REVIEW_POINT)']; // 口コミ平均点数
        }
        $rst_foodgenre = $row['RST_FOODGENRE']; //料理のジャンル
        $rst_type =  $row['RST_TYPE']; //店舗の種類

        //一覧内表示
        echo '<tr>';
        echo '<td>';
        echo '<b><font size="5">&nbsp;' .  $row['RST_NAME'] . '</font></b><br>'; // 店舗名
        if ($row['RST_TYPE'] != '0') { // 店舗の種類
          echo '&nbsp;<font color="#000066">店舗: ' . $codes[$row['RST_TYPE']] . '</font><br>';
        }
        if ($row['RST_FOODGENRE'] != '100000000') { //料理のジャンル
          $fgtmp = '';
          if (substr($rst_foodgenre, 1, 1) === '1') $fgtmp .= '和食&nbsp;/&nbsp;';
          if (substr($rst_foodgenre, 2, 1) === '1') $fgtmp .= '洋食&nbsp;/&nbsp;';
          if (substr($rst_foodgenre, 3, 1) === '1') $fgtmp .= '中華&nbsp;/&nbsp;';
          if (substr($rst_foodgenre, 4, 1) === '1') $fgtmp .= 'エスニック&nbsp;/&nbsp;';
          if (substr($rst_foodgenre, 5, 1) === '1') $fgtmp .= '焼肉&nbsp;/&nbsp;';
          if (substr($rst_foodgenre, 6, 1) === '1') $fgtmp .= '麺類&nbsp;/&nbsp;';
          if (substr($rst_foodgenre, 7, 1) === '1') $fgtmp .= 'カレー&nbsp;/&nbsp;';
          if (substr($rst_foodgenre, 8, 1) === '1') $fgtmp .= '創作料理&nbsp;/&nbsp;';
          $fgtmp = substr($fgtmp, 0, -13);
          echo '&nbsp;<font color="#800000">料理: ' . $fgtmp . '</font><br>';
        }
        if ($row['RST_HOLIDAY'] != '11111111') { //店休日
          $rhtmp = '';
          if (substr($row['RST_HOLIDAY'], 1, 1) === '0') $rhtmp .= '月&nbsp;/&nbsp;';
          if (substr($row['RST_HOLIDAY'], 2, 1) === '0') $rhtmp .= '火&nbsp;/&nbsp;';
          if (substr($row['RST_HOLIDAY'], 3, 1) === '0') $rhtmp .= '水&nbsp;/&nbsp;';
          if (substr($row['RST_HOLIDAY'], 4, 1) === '0') $rhtmp .= '木&nbsp;/&nbsp;';
          if (substr($row['RST_HOLIDAY'], 5, 1) === '0') $rhtmp .= '金&nbsp;/&nbsp;';
          if (substr($row['RST_HOLIDAY'], 6, 1) === '0') $rhtmp .= '土&nbsp;/&nbsp;';
          if (substr($row['RST_HOLIDAY'], 7, 1) === '0') $rhtmp .= '日&nbsp;/&nbsp;';
          $rhtmp = substr($rhtmp, 0, -13);
          echo '&nbsp;<font color="#800000">店休日: ' . $rhtmp . '</font><br>';
        }
        if ($row['RST_TAKEOUT'] == 1) { //テイクアウト可能
          echo '&nbsp;<font color="#9acd32">■&nbsp;テイクアウト可能&nbsp;■</font><br>';
        }

        echo '</td>';
        if ($averagepoint == '') {
          echo '<td><font size="4">★--&nbsp;&nbsp;</font><br>';
        } else {
          echo '<td><font size="4">★' . substr($averagepoint, 0, 4) . '&nbsp;&nbsp;</font><br>';
        }
        echo '&nbsp;' . '</td>';
        echo '<td>' . $row['RST_ADDRESS'] . '&nbsp;<br>';
        echo $row['RST_TELNUM'] . '</td>';
        echo '<td><a href="?do=rst_detail&rst_id=' . $rst_id . '" class="button">店舗詳細</a></td>';
        if ($row['USER_ID'] === $loginuser || $loginuser === 'admin') {
          echo '<td><a href="?do=rst_delete&rst_name=' . $row['RST_NAME'] . '&rst_id=' . $row['RST_ID'] . '" class="deletebutton">削除</a></td></tr>';
        }
      }
      echo '</table>';
      echo '<div style="text-align: right">';
      //page
      $pagef = 1 + ($page - 1) * 5;
      $pagel = $page * 5;
      if ($pagel >= $num_rows) $pagel = $num_rows;
      echo $pagef . '件目～' . $pagel . '件目/全' . $num_rows . '件';
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

      // ページ切り替えのリンク
      for ($j = 1; $j <= $max_page; $j++) {
        $f = $j;
        if ($j == $page)
          echo $j, ' ';
        else
          printf('<a href="?do=rst_list&p=%d">%d</a> ', $j, $j);
      }
      echo '</div>';
    }
    ?>
  </div>
</div>