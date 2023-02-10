-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-12-11 19:16:05
-- サーバのバージョン： 10.4.24-MariaDB
-- PHP のバージョン: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `pbl2022`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_review`
--

CREATE TABLE `t_review` (
  `REVIEW_ID` bigint(20) NOT NULL COMMENT '口コミID',
  `RST_ID` bigint(20) NOT NULL COMMENT '店舗ID',
  `USER_ID` varchar(16) DEFAULT NULL COMMENT 'ユーザID',
  `REVIEW_POINT` int(2) NOT NULL COMMENT '評価点',
  `REVIEW_COMMENT` varchar(32) DEFAULT NULL COMMENT 'コメント',
  `REVIEW_DATE` datetime NOT NULL COMMENT '最終更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='口コミ';

--
-- テーブルのデータのダンプ `t_review`
--

INSERT INTO `t_review` (`REVIEW_ID`, `RST_ID`, `USER_ID`, `REVIEW_POINT`, `REVIEW_COMMENT`, `REVIEW_DATE`) VALUES
(1, 33, 'u0001', 4, '美味しかったです。', '2022-12-05 00:49:00'),
(2, 33, 'u0002', 4, 'よい雰囲気だった。', '2022-12-05 01:52:54'),
(3, 33, 'u0003', 5, 'コメント25', '2022-12-05 01:59:53'),
(8, 33, 'u0004', 2, NULL, '2022-12-07 08:51:31'),
(9, 33, 'u0005', 1, 'コメント32', '2022-12-07 08:52:18'),
(11, 33, 'u0007', 4, NULL, '2022-12-07 08:52:56'),
(17, 34, 'u0001', 4, 'また来ます。', '2022-12-10 12:56:30'),
(19, 38, 'u0002', 2, 'ふつうのばーがー', '2022-12-10 19:01:51'),
(21, 38, 'u0003', 4, 'ばーがーおいしい', '2022-12-10 21:58:15'),
(22, 33, 'u0006', 2, 'そこそこ', '2022-12-10 22:00:35'),
(23, 53, 'u0001', 4, '22のコメント', '2022-12-12 00:13:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_rstinfo`
--

CREATE TABLE `t_rstinfo` (
  `RST_ID` bigint(20) NOT NULL COMMENT '店舗ID',
  `USER_ID` varchar(16) DEFAULT NULL COMMENT 'ユーザID',
  `RST_NAME` varchar(32) NOT NULL COMMENT '店舗名',
  `RST_ADDRESS` varchar(64) DEFAULT NULL COMMENT '住所',
  `RST_START` varchar(8) DEFAULT NULL COMMENT '営業開始時間',
  `RST_CLOSE` varchar(8) DEFAULT NULL COMMENT '営業終了時間',
  `RST_TELNUM` varchar(16) DEFAULT NULL COMMENT '電話番号',
  `RST_TYPE` int(2) DEFAULT NULL COMMENT '店舗の種類',
  `RST_PRICE` int(2) DEFAULT NULL COMMENT '価格帯',
  `RST_NOTE` varchar(128) DEFAULT NULL COMMENT '備考',
  `RST_TAKEOUT` int(2) DEFAULT NULL COMMENT 'テイクアウト可',
  `RST_HOLIDAY` int(8) DEFAULT NULL COMMENT '営業日',
  `RST_FOODGENRE` int(9) DEFAULT NULL COMMENT '料理のジャンル',
  `RST_DATE` datetime DEFAULT NULL COMMENT '最終更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='店舗情報:';

--
-- テーブルのデータのダンプ `t_rstinfo`
--

INSERT INTO `t_rstinfo` (`RST_ID`, `USER_ID`, `RST_NAME`, `RST_ADDRESS`, `RST_START`, `RST_CLOSE`, `RST_TELNUM`, `RST_TYPE`, `RST_PRICE`, `RST_NOTE`, `RST_TAKEOUT`, `RST_HOLIDAY`, `RST_FOODGENRE`, `RST_DATE`) VALUES
(33, 'u0002', '喫茶店きゅうさん', '福岡県東区松香台2丁目3-1', '8:00', '20:30', '090-1234-5678', 1, 1, '年末年始は休み', 1, 11111100, 101000001, '2022-12-05 06:29:04'),
(34, 'u0002', 'たこ焼ききゅうさん', '福岡県東区松香台2丁目4−4', '8:30', '18:30', '090-5678-1234', 2, 1, '年末年始とお盆は休み', 1, 11101110, 110000000, '2022-12-05 06:48:23'),
(35, 'u0001', '蕎麦処たくみ', '福岡県西区愛宕1丁目4-3', '11:00', '22:00', '090-2345-6789', 5, 2, '年末年始は休みです。', 0, 11101110, 101000100, '2022-12-07 20:25:06'),
(36, 'u0001', '松香台食堂', '福岡県福岡市西区今宿1-1', '10:00', '22:00', '090-3456-7890', 7, 1, '第1月曜日は休み', 1, 11101011, 111111111, '2022-12-07 20:45:26'),
(37, 'u0001', '満腹中華屋', '福岡県福岡市西区野方1-5', '11:30', '21:30', '080-6788-2314', 5, 2, '第3火曜日は休み', 0, 10111011, 100100100, '2022-12-07 20:46:30'),
(38, 'u0001', 'ファミリーバーガー', '福岡市西区姪浜3-3', '10:30', '21:00', '080-6873-8364', 2, 1, '年中無休', 1, 11110011, 101000000, '2022-12-07 20:47:18'),
(47, 'u0001', '居酒屋ひなた', '福岡市中央区今泉2丁目3-31 プロペ今泉１F', '18:00', '0:00', '050-1234-5678', 3, 2, '不定休', 0, 11111111, 110000000, '2022-12-11 17:18:40');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_user`
--

CREATE TABLE `t_user` (
  `USER_ID` varchar(16) NOT NULL COMMENT 'ユーザID',
  `USER_NICKNAME` varchar(32) NOT NULL COMMENT 'ニックネーム',
  `USER_PASSWORD` varchar(32) NOT NULL COMMENT 'パスワード',
  `USER_ACCOUNTNAME` varchar(32) NOT NULL COMMENT 'アカウント名',
  `USERTYPE_ID` int(2) NOT NULL COMMENT 'ユーザ種別ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='ユーザ';

--
-- テーブルのデータのダンプ `t_user`
--

INSERT INTO `t_user` (`USER_ID`, `USER_NICKNAME`, `USER_PASSWORD`, `USER_ACCOUNTNAME`, `USERTYPE_ID`) VALUES
('admin', 'kannrisyanick', '5678', '管理者 太郎', 2),
('u0001', 'syainnick1', '1234', '社員 太郎1', 1),
('u0002', 'syainnick2', '1234', '社員 太郎2', 1),
('u0003', 'syainnick3', '1234', '社員 太郎3', 1),
('u0004', 'syainnick4', '1234', '社員 太郎4', 1),
('u0005', 'syainnick5', '1234', '社員 太郎5', 1),
('u0006', 'syainnick6', '1234', '社員 太郎6', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `t_usertype`
--

CREATE TABLE `t_usertype` (
  `USERTYPE_ID` int(2) NOT NULL COMMENT 'ユーザ種別ID',
  `USERTYPE` varchar(5) NOT NULL COMMENT 'ユーザ種別'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='ユーザ種別:';

--
-- テーブルのデータのダンプ `t_usertype`
--

INSERT INTO `t_usertype` (`USERTYPE_ID`, `USERTYPE`) VALUES
(0, 'ゲスト'),
(1, '社員'),
(2, '管理者');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `t_review`
--
ALTER TABLE `t_review`
  ADD PRIMARY KEY (`REVIEW_ID`);

--
-- テーブルのインデックス `t_rstinfo`
--
ALTER TABLE `t_rstinfo`
  ADD PRIMARY KEY (`RST_ID`);

--
-- テーブルのインデックス `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`USER_ID`);

--
-- テーブルのインデックス `t_usertype`
--
ALTER TABLE `t_usertype`
  ADD PRIMARY KEY (`USERTYPE_ID`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `t_review`
--
ALTER TABLE `t_review`
  MODIFY `REVIEW_ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '口コミID', AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `t_rstinfo`
--
ALTER TABLE `t_rstinfo`
  MODIFY `RST_ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '店舗ID', AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
