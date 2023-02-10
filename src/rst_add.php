<?php
//不正にURLにアクセスした場合は強制的に店舗一覧ページにリダイレクト
if (!isset($_SESSION["islogin"])) {
    header("Location: index.php");
    exit();
}
?>

<button onclick="location.href = '?do=rst_list'">店舗一覧へ戻る</button>
<h1 style="text-align:center">新規店舗登録</h1>

<form action="?do=rst_save" method="post">
    <input type="hidden" name="rst_act" value="add">
    <table align="center">
        <tr>
            <td>
                <font color="red">店舗名(必須)：</font>
            </td>
            <td>
                <input type="text" name="rst_name" minlength="1" maxlength="20" size="30" placeholder="20字以内でお願いします" required>
            </td>
        </tr>
        <tr>
            <td>住所：</td>
            <td>
                <input type="text" name="rst_address" size="30" maxlength="50" placeholder="50字以内でお願いします">
            </td>
        </tr>
        <tr>
            <td>電話番号：</td>
            <td>
                <input type="text" name="rst_telnum" size="30" maxlength="15" placeholder="15字以内でお願いします">
            </td>
        </tr>
        <tr>
            <td>営業曜日：</td>
            <td>
                <input type="checkbox" name="rst_holiday_mon" checked>月&nbsp;
                <input type="checkbox" name="rst_holiday_tue" checked>火&nbsp;
                <input type="checkbox" name="rst_holiday_wed" checked>水&nbsp;
                <input type="checkbox" name="rst_holiday_thu" checked>木&nbsp;
                <input type="checkbox" name="rst_holiday_fri" checked>金&nbsp;
                <input type="checkbox" name="rst_holiday_sat" checked>土&nbsp;
                <input type="checkbox" name="rst_holiday_sun" checked>日&nbsp;
            </td>
        </tr>
        <tr>
            <td>営業時間：</td>
            <td>
                <select name="rst_starttime">
                    <option value="選択なし">選択なし</option>
                    <?php //00:00～23:30までforループ
                    for ($i = 0; $i <= 23; $i++) {
                        echo '<option value = "' . sprintf("%02d:00", $i) . '">' . sprintf("%02d:00", $i) . '</option>'; //時間を2桁ゼロ埋め
                        echo '<option value = "' . sprintf("%02d:30", $i) . '">' . sprintf("%02d:30", $i) . '</option>';
                    }
                    ?>
                </select>
                &nbsp;～&nbsp;
                <select name="rst_closetime">
                    <option value="選択なし">選択なし</option>
                    <?php
                    for ($i = 0; $i <= 23; $i++) {
                        echo '<option value = "' . sprintf("%02d:00", $i) . '">' . sprintf("%02d:00", $i) . '</option>';
                        echo '<option value = "' . sprintf("%02d:30", $i) . '">' . sprintf("%02d:30", $i) . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>店舗の種類：</td>
            <td>
                <select name="rst_type">
                    <option value="選択なし">選択なし</option>
                    <option value="喫茶店">喫茶店</option>
                    <option value="ファストフード">ファストフード</option>
                    <option value="居酒屋">居酒屋</option>
                    <option value="バイキング">バイキング</option>
                    <option value="レストラン">レストラン</option>
                    <option value="ファミリーレストラン">ファミリーレストラン</option>
                    <option value="定食屋">定食屋</option>
                    <option value="その他">その他</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>料理のジャンル：</td>
            <td>
                <table>
                    <tr>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_japanese">和食&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_western">洋食&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_chinese">中華&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_ethnic">エスニック&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_meat">焼肉&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_noodle">麺類&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_curry">カレー&nbsp;
                        </td>
                        <td>
                            <input type="checkbox" name="rst_foodgenre_creative">創作料理&nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>価格帯：</td>
            <td>
                <select name="rst_price">
                    <option value="選択なし">選択なし</option>
                    <option value="￥0～￥500">￥0～￥500</option>
                    <option value="￥501～￥1000">￥501～￥1000</option>
                    <option value="￥1001～￥2000">￥1001～￥2000</option>
                    <option value="￥2001～">￥2001～</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>テイクアウト可：</td>
            <td>
                <input type="checkbox" name="rst_takeout">
            </td>
        </tr>
        <tr>
            <td>備考：</td>
            <td>
                <textarea name="rst_note" rows="5" cols="30" maxlength="100" placeholder="100字以内でお願いします"></textarea>
            </td>
        </tr>
    </table>
    <p style="text-align:center"><input type="submit" value="決定" class="button"></p>
</form>