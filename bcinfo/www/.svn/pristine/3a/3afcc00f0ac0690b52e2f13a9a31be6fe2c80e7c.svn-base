--//
--// 会社情報
--//
DROP TABLE corp_data ;
CREATE TABLE corp_data(
	corpid				serial primary key ,								--// index
	loginid				text not null ,										--// ログインid
	passwd				text not null ,										--// password (暗号化)
	clear_passwd		text not null ,										--// password (クリア)
	groupflg			int2 not null default 0 ,							--// グループ会社判定フラグ
																			--// 0:自社以外 1:自社
	groupparentid		int4 default -1 ,									--// 親会社id
	name				text not null ,										--// 社名
	name_en				text not null ,										--// 社名(英語)
	department			text not null default '' ,							--// 部署名
	department_en		text not null default '' ,							--// 部署名(英語)

	kana				text ,												--// 社名（カナ）
	title				int2 not null default 99 ,							--// 法人格
	position			int2 not null default 0 ,							--// 法人格位置（0：指定なし 1：前 2：後）

	level				int2 not null default 0 ,							--// ０：仮登録 １：有料 ２：web会員 ９９：デモ用

	url					text not null default '' ,							--// url (有料会員でかつurlが空白の場合、自動生成 ／ 子会社情報の場合 FQDNを指定）
	agent_name			text ,												--// 採用担当者
	agent_email			text ,												--// 連絡先Ｅメール
	style				int2 not null default -1 ,							--// スタイルno
	maxpage				int2 not null default 0 ,							--// 最大ページ数

	state				int2 not null default -1 ,							--// 都道府県
	cityindex			int2 not null default -1 ,							--// 市町村 （-1 ： その他）
	city				text ,												--// 市町村（その他用）
	addr1				text ,												--// 住所１
	addr2				text ,												--// 住所２（アパート、マンション）
	zip					text ,												--// 郵便番号
	tel					text ,												--// 電話番号
	fax					text ,												--// fax

	representative		text ,												--// 代表者名
	foundation_date		timestamp default '0001-01-01 00:00:00' not null ,	--// 設立年月
	capital				int4 ,												--// 資本金（万円）
	employees			int4 ,												--// 従業員数
	ave_age				text ,												--// 社員の平均年齢
	activities			text ,												--// 事業内容

	sort				int2 not null default 0 ,							--// 表示順

	dat_subject			text ,												--// 科目（カンマ区切り）
	closed_day			int2 default 0 ,									--// 休日(bit0:日曜 ～ bit6:土曜 bit7:祝祭日)
	logoid				int4 default -1 ,									--// ロゴ画像
	photoid				int4 default -1 ,									--// 写真情報id（外観）
	photoid1			int4 default -1 ,									--// 写真情報id（内装）
	photoid2			int4 default -1 ,									--// 写真情報id (代表者)
	photoid_map			int4 default -1 ,									--// 写真情報id（地図）
	submessage			text ,												--// 補足説明
	misc				text ,												--// 備考
	catch				text default '' ,									--// キャッチコピー
	catch_body			text default '' ,									--// キャッチ本文
	comment				text default '' ,									--// コメント
	subtitle			text default '' ,									--// サブタイトル

	catch2				text default '' ,									--// キャッチコピー2
	catch_body2			text default '' ,									--// キャッチ本文2
	comment2			text default '' ,									--// コメント
	subtitle2			text default '' ,									--// サブタイトル2
	
	headertitle			text default '' ,									--// ヘッダ用タイトル
	headermessage		text default '' ,									--// ヘッダ用メッセージ
	headermisc			text default '' ,									--// ヘッダ用その他

	business_hours		text default '' ,									--// 営業時間
	regular_holiday		text default '' ,									--// 定休日

	start_date			timestamp not null default '0001-01-01 00:00:00' ,	--// 掲載開始日

	remainder_email		text default '' ,									--// リマインダのfrom
	inquire_email		text default '' ,									--// 問い合わせのfrom
	registered_email	text default '' ,									--// 会員登録完了通知のfrom
	feedback_email		text default '' ,									--// システム通知用メールアドレス

	status				int2 default 0 ,									--// 状態（0:不定 1：標準 -1:削除）
	create_date			timestamp not null default( LOCALTIMESTAMP(0) ) ,	--// 作成日付
	update_date			timestamp not null default( LOCALTIMESTAMP(0) )		--// 更新日付
);
DROP INDEX idx_corp_data ;
CREATE INDEX idx_corp_data ON corp_data USING btree (
	loginid			,
	passwd			,
	groupflg		,
	groupparentid	,
	sort			,
	dat_subject		,
	level			,
	start_date		,
	status
) ;

DROP INDEX idx_corp_data_loginid ;
CREATE INDEX idx_corp_data_loginid ON corp_data USING btree ( loginid ) ;

DROP INDEX idx_corp_data_passwd ;
CREATE INDEX idx_corp_data_passwd ON corp_data USING btree ( passwd ) ;

DROP INDEX idx_corp_data_groupflg ;
CREATE INDEX idx_corp_data_groupflg ON corp_data USING btree ( groupflg ) ;

DROP INDEX idx_corp_data_groupparentid ;
CREATE INDEX idx_corp_data_groupparentid ON corp_data USING btree ( groupparentid ) ;

DROP INDEX idx_corp_data_sort ;
CREATE INDEX idx_corp_data_sort ON corp_data USING btree ( sort ) ;

DROP INDEX idx_corp_data_level ;
CREATE INDEX idx_corp_data_level ON corp_data USING btree ( level ) ;

DROP INDEX idx_corp_data_start_date ;
CREATE INDEX idx_corp_data_start_date ON corp_data USING btree ( start_date ) ;

DROP INDEX idx_corp_data_status ;
CREATE INDEX idx_corp_data_status ON corp_data USING btree ( status ) ;
