<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"])) {
    header("Location: index.php");
    exit();
}
?>

<?php
require_once('db_inc.php');

$rst_id = $_GET['rst_id'];
echo '<button onclick="?do=rst_detail&rst_id=' . $rst_id . '">店舗一覧画面へ戻る</button>';
echo '<h1 style="text-align:center">店舗編集</h1>';

// 既存の店舗情報を検索するSQL文
$sql = "SELECT * FROM t_rstinfo WHERE RST_ID='{$rst_id}'";
// データベースへ問合せのSQL($sql)を実行する・・・
$rs = $conn->query($sql);;
if (!$rs) die('エラー: ' . $conn->error);

//問合せ結果を取得し、それぞれの変数に代入しておく
$row = $rs->fetch_assoc();;
if ($row) { // 既存の店舗情報を編集するために、変数に代入
    $_SESSION['rst_id'] = $row['RST_ID'];
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
    $rst_holiday = $row['RST_HOLIDAY']; //営業曜日(ビット管理)
    $rst_foodgenre = $row['RST_FOODGENRE']; //料理のジャンル(ビット管理)
}
?>

<form action="?do=rst_save&rst_id=<?= $rst_id ?>" method="post">
    <input type="hidden" name="rst_act" value="edit">
    <table align="center">
        <tr>
            <td>
                <font color="red">店舗名(必須)：</font>
            </td>
            <td>
                <input type="text" name="rst_name" size="30" maxlength="20" placeholder="20字以内でお願いします" value="<?php echo $rst_name; ?>">
            </td>
        </tr>
        <tr>
            <td>住所：</td>
            <td>
                <input type="text" name="rst_address" size="30" maxlength="50" placeholder="50字以内でお願いします" value="<?php echo $rst_address; ?>">
            </td>
        </tr>
        <tr>
            <td>電話番号：</td>
            <td>
                <input type="text" name="rst_telnum" size="30" maxlength="15" placeholder="15字以内でお願いします" value="<?php echo $rst_telnum; ?>">
            </td>
        </tr>
        <tr>
            <td>営業曜日：</td>
            <td>
                <input type="checkbox" name="rst_holiday_mon" <?php if (substr($rst_holiday, 1, 1) === '1') echo 'checked'; ?>>月&nbsp;
                <input type="checkbox" name="rst_holiday_tue" <?php if (substr($rst_holiday, 2, 1) === '1') echo 'checked'; ?>>火&nbsp;
                <input type="checkbox" name="rst_holiday_wed" <?php if (substr($rst_holiday, 3, 1) === '1') echo 'checked'; ?>>水&nbsp;
                <input type="checkbox" name="rst_holiday_thu" <?php if (substr($rst_holiday, 4, 1) === '1') echo 'checked'; ?>>木&nbsp;
                <input type="checkbox" name="rst_holiday_fri" <?php if (substr($rst_holiday, 5, 1) === '1') echo 'checked'; ?>>金&nbsp;
                <input type="checkbox" name="rst_holiday_sat" <?php if (substr($rst_holiday, 6, 1) === '1') echo 'checked'; ?>>土&nbsp;
                <input type="checkbox" name="rst_holiday_sun" <?php if (substr($rst_holiday, 7, 1) === '1') echo 'checked'; ?>>日&nbsp;
            </td>
        </tr>
        <tr>
            <td>営業時間：</td>
            <td>
                <select name="rst_starttime">
                    <?php
                    if ($rst_start === '選択なし') {
                        echo '<option value="選択なし" selected>選択なし</option>';
                    }
                    for ($i = 0; $i <= 23; $i++) {
                        $time = str_pad($i . ':00', 2, 0, STR_PAD_LEFT);
                        if ($rst_start === $time) {
                            echo '<option value = "' . $time . '" selected>' . $time . '</option>';
                        } else {
                            echo '<option value = "' . $time . '">' . $time . '</option>';
                        }
                        $time = str_pad($i . ':30', 2, 0, STR_PAD_LEFT);
                        if ($rst_start === $time) {
                            echo '<option value = "' . $time . '" selected>' . $time . '</option>';
                        } else {
                            echo '<option value = "' . $time . '">' . $time . '</option>';
                        }
                    }
                    ?>
                </select>
                &nbsp;～&nbsp;
                <select name="rst_closetime">
                    <?php
                    if ($rst_start === '選択なし') {
                        echo '<option value="選択なし" selected>選択なし</option>';
                    }
                    for ($i = 0; $i <= 23; $i++) {
                        $time = str_pad($i . ':00', 2, 0, STR_PAD_LEFT);
                        if ($rst_close === $time) {
                            echo '<option value = "' . $time . '" selected>' . $time . '</option>';
                        } else {
                            echo '<option value = "' . $time . '">' . $time . '</option>';
                        }
                        $time = str_pad($i . ':30', 2, 0, STR_PAD_LEFT);
                        if ($rst_close === $time) {
                            echo '<option value = "' . $time . '" selected>' . $time . '</option>';
                        } else {
                            echo '<option value = "' . $time . '">' . $time . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>店舗の種類：</td>
            <td>
                <select name="rst_type">
                    <option value="選択なし" <?php if ($rst_type === '0') echo 'selected'; ?>>選択なし</option>
                    <option value="喫茶店" <?php if ($rst_type === '1') echo 'selected'; ?>>喫茶店</option>
                    <option value="ファストフード" <?php if ($rst_type === '2') echo 'selected'; ?>>ファストフード</option>
                    <option value="居酒屋" <?php if ($rst_type === '3') echo 'selected'; ?>>居酒屋</option>
                    <option value="バイキング" <?php if ($rst_type === '4') echo 'selected'; ?>>バイキング</option>
                    <option value="レストラン" <?php if ($rst_type === '5') echo 'selected'; ?>>レストラン</option>
                    <option value="ファミリーレストラン" <?php if ($rst_type === '6') echo 'selected'; ?>>ファミリーレストラン</option>
                    <option value="定食屋" <?php if ($rst_type === '7') echo 'selected'; ?>>定食屋</option>
                    <option value="その他" <?php if ($rst_type === '8') echo 'selected'; ?>>その他</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>料理のジャンル：</td>
            <td>
                <table>
                    <tr>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_japanese" <?php if (substr($rst_foodgenre, 1, 1) === '1') echo 'checked'; ?>>和食&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_western" <?php if (substr($rst_foodgenre, 2, 1) === '1') echo 'checked'; ?>>洋食&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_chinese" <?php if (substr($rst_foodgenre, 3, 1) === '1') echo 'checked'; ?>>中華&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_ethnic" <?php if (substr($rst_foodgenre, 4, 1) === '1') echo 'checked'; ?>>エスニック&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_meat" <?php if (substr($rst_foodgenre, 5, 1) === '1') echo 'checked'; ?>>焼肉&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_noodle" <?php if (substr($rst_foodgenre, 6, 1) === '1') echo 'checked'; ?>>麺類&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_curry" <?php if (substr($rst_foodgenre, 7, 1) === '1') echo 'checked'; ?>>カレー&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_creative" <?php if (substr($rst_foodgenre, 8, 1) === '1') echo 'checked'; ?>>創作料理&nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>価格帯：</td>
            <td>
                <select name="rst_price">
                    <option value="選択なし" <?php if ($rst_price === '0') echo 'selected'; ?>>選択なし</option>
                    <option value="￥0～￥500" <?php if ($rst_price === '1') echo 'selected'; ?>>￥0～￥500</option>
                    <option value="￥501～￥1000" <?php if ($rst_price === '2') echo 'selected'; ?>>￥501～￥1000</option>
                    <option value="￥1001～￥2000" <?php if ($rst_price === '3') echo 'selected'; ?>>￥1001～￥2000</option>
                    <option value="￥2001～" <?php if ($rst_price === '4') echo 'selected'; ?>>￥2001～</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>テイクアウト可：</td>
            <td>
                <input type="checkbox" name="rst_takeout" <?php if ($rst_takeout === '1') echo 'checked'; ?>>
            </td>
        </tr>
        <tr>
            <td>備考：</td>
            <td>
                <textarea name="rst_note" rows="5" cols="30" maxlength="100" placeholder="100字以内でお願いします"><?php echo $rst_note; ?></textarea>
            </td>
        </tr>
    </table>
    <p style="text-align:center"><input type=submit value="決定" class="button"></p>
</form>