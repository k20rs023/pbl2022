<?php
require_once('db_inc.php');
if (isset($_POST['rst_act'])) {
    $rst_act = $_POST['rst_act'];
    $user_id = $_SESSION['user_id'];

    //エラーケース
    //もし店舗名が空だったら承認しない
    if ($_POST['rst_name'] === '') {
        echo '<h2>店舗名を入力してください！</h2>';
        echo '<input type="button" onclick="history.back()" value="入力画面に戻る">';
    }
    //もし営業時間が片方のみ選択されていたら承認しない
    else if ($_POST['rst_starttime'] === '選択なし' xor $_POST['rst_closetime'] === '選択なし') {
        echo '<h2>営業時間を選択する場合は両方選択してください！<h2>';
        echo '<input type="button" onclick="history.back()" value="入力画面に戻る">';
    }

    //正常ケース
    else {
        $rst_name = $_POST['rst_name']; //店舗名(VARCHAR(32))
        $rst_address = $_POST['rst_address']; //住所(VARCHAR(64))
        $rst_telnum = $_POST['rst_telnum']; //電話番号(VARCHAR(16))

        $rst_holiday = 10_000_000; //営業曜日(int(8))(ビット管理)
        if (isset($_POST['rst_holiday_mon'])) {
            $rst_holiday += 1_000_000;
        }
        if (isset($_POST['rst_holiday_tue'])) {
            $rst_holiday += 100_000;
        }
        if (isset($_POST['rst_holiday_wed'])) {
            $rst_holiday += 10_000;
        }
        if (isset($_POST['rst_holiday_thu'])) {
            $rst_holiday += 1_000;
        }
        if (isset($_POST['rst_holiday_fri'])) {
            $rst_holiday += 100;
        }
        if (isset($_POST['rst_holiday_sat'])) {
            $rst_holiday += 10;
        }
        if (isset($_POST['rst_holiday_sun'])) {
            $rst_holiday += 1;
        }

        $rst_starttime = $_POST['rst_starttime']; //営業開始時間(VARCHAR(8))
        $rst_closetime = $_POST['rst_closetime']; //営業終了時間(VARCHAR(8))

        $rst_type = 0; //店舗の種類(int(2))
        if ($_POST['rst_type'] === '選択なし') {
            $rst_type = 0;
        } else if ($_POST['rst_type'] === '喫茶店') {
            $rst_type = 1;
        } else if ($_POST['rst_type'] === 'ファストフード') {
            $rst_type = 2;
        } else if ($_POST['rst_type'] === '居酒屋') {
            $rst_type = 3;
        } else if ($_POST['rst_type'] === 'バイキング') {
            $rst_type = 4;
        } else if ($_POST['rst_type'] === 'レストラン') {
            $rst_type = 5;
        } else if ($_POST['rst_type'] === 'ファミリーレストラン') {
            $rst_type = 6;
        } else if ($_POST['rst_type'] === '定食屋') {
            $rst_type = 7;
        } else if ($_POST['rst_type'] === 'その他') {
            $rst_type = 8;
        }

        $rst_foodgenre = 100_000_000; //料理のジャンル(bigint(20))(ビット管理)
        if (isset($_POST['rst_foodgenre_japanese'])) {
            $rst_foodgenre += 10_000_000;
        }
        if (isset($_POST['rst_foodgenre_western'])) {
            $rst_foodgenre += 1_000_000;
        }
        if (isset($_POST['rst_foodgenre_chinese'])) {
            $rst_foodgenre += 100_000;
        }
        if (isset($_POST['rst_foodgenre_ethnic'])) {
            $rst_foodgenre += 10_000;
        }
        if (isset($_POST['rst_foodgenre_meat'])) {
            $rst_foodgenre += 1_000;
        }
        if (isset($_POST['rst_foodgenre_noodle'])) {
            $rst_foodgenre += 100;
        }
        if (isset($_POST['rst_foodgenre_curry'])) {
            $rst_foodgenre += 10;
        }
        if (isset($_POST['rst_foodgenre_creative'])) {
            $rst_foodgenre += 1;
        }

        $rst_price = 0; //価格帯(int(2))
        if ($_POST['rst_price'] === '選択なし') {
            $rst_price = 0;
        } else if ($_POST['rst_price'] === '￥0～￥500') {
            $rst_price = 1;
        } else if ($_POST['rst_price'] === '￥501～￥1000') {
            $rst_price = 2;
        } else if ($_POST['rst_price'] === '￥1001～￥2000') {
            $rst_price = 3;
        } else if ($_POST['rst_price'] === '￥2001～') {
            $rst_price = 4;
        }

        $rst_takeout = 0; //テイクアウト可(int(2))
        if (isset($_POST['rst_takeout'])) {
            $rst_takeout = 1;
        }

        $rst_note = $_POST['rst_note']; //備考(VARCHAR(128))

        date_default_timezone_set('Asia/Tokyo'); //タイムゾーンを東京に設定
        $rst_date = date('Y-m-d H:i:s'); //最終更新日時(datetime)←ソートするとき日付だけだと同一日時の場合ソートできないから時間も必要  

        if ($rst_act === 'add') { //新規店舗登録画面から遷移してきたら
            $sql = "INSERT INTO t_rstinfo(RST_NAME, RST_ADDRESS, RST_START, RST_CLOSE, RST_TELNUM, RST_TYPE, RST_PRICE, RST_TAKEOUT, RST_NOTE, USER_ID, RST_DATE, RST_HOLIDAY, RST_FOODGENRE) 
            VALUES ('{$rst_name}','{$rst_address}','{$rst_starttime}','{$rst_closetime}','{$rst_telnum}','{$rst_type}','{$rst_price}','{$rst_takeout}','{$rst_note}','{$user_id}','{$rst_date}','{$rst_holiday}','{$rst_foodgenre}')";
            $conn->query($sql); //登録
            echo '<h3>登録成功</h3>';
            echo '<button onclick="location.href = \'?do=rst_list\'">店舗一覧画面へ戻る</button>';
        } else { //店舗編集画面から遷移してきたら
            $rst_id = $_GET['rst_id'];
            $sql = "UPDATE t_rstinfo SET RST_NAME = '{$rst_name}', RST_ADDRESS = '{$rst_address}', RST_TELNUM = '{$rst_telnum}', RST_START = '{$rst_starttime}', RST_CLOSE = '{$rst_closetime}', 
            RST_TYPE = '{$rst_type}', RST_PRICE = '{$rst_price}', RST_TAKEOUT = '{$rst_takeout}', RST_NOTE = '{$rst_note}', RST_HOLIDAY = '{$rst_holiday}', RST_FOODGENRE = '{$rst_foodgenre}' WHERE RST_ID = '{$rst_id}'";
            $conn->query($sql);
            echo '<h3>登録成功</h3>';
            echo '<button onclick = "location.href=\'?do=rst_detail&rst_id=' . $rst_id . '\'">店舗詳細へ戻る</button>';
        }
    }
}
