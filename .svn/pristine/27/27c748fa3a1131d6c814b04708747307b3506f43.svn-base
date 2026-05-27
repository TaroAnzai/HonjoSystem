--//
--// メニュー情報
--//
DROP TABLE menu_data ;
CREATE TABLE menu_data(
	menuid				serial	 primary key ,					--// INDEX
	corpid				int4 default -1 ,						--// 自社情報ID
	class				text default '' ,						--// CSSクラス名
	url					text default '' ,						--// ＵＲＬ
	anchor				text default '' ,						--// アンカー文字
	subject				text default '' ,						--// 名称
	width				int2 default 128 ,						--// 幅
	height				int2 default 32 ,						--// 高さ
	standard			int2 default 0 ,						--// 標準メニュー（ 99：ユーザ定義 )
	menucategoryid		int4 default -1 ,						--// メニューカテゴリーID
	category1			int4 default 0 ,						--// 大項目
	category2			int4 default 0 ,						--// 中項目
	category3			int4 default 0 ,						--// 小項目
	status				int2 default 0 ,						--// 状態（0:不定 1：標準 -1:削除）
	create_date			timestamp not null default LOCALTIMESTAMP(0) ,		--// 作成日付
	update_date			timestamp not null default LOCALTIMESTAMP(0)		--// 更新日付
);
DROP INDEX idx_menu_data ;
CREATE INDEX idx_menu_data ON menu_data USING btree (
	standard		,
	corpid			,
	class			,
	url				,
	anchor			,
	menucategoryid	,
	category1		,
	category2		,
	category3		,
	status
) ;
