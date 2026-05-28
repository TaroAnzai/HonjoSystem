--//
--// 会社沿革情報
--//
DROP TABLE history_data ;
CREATE TABLE history_data(
	historyid			serial primary key ,					--// index
	corpid				int4 not null ,							--// 企業会員情報idなど（別のidもありえる）
	history_date		date not null ,							--// 沿革情報年月
	body				text not null ,							--// 沿革情報

	status				int2 default 0 ,						--// 状態（0:不定 1：標準 -1:削除）
	create_date			timestamp not null default( LOCALTIMESTAMP(0) ) ,	--// 作成日付
	update_date			timestamp not null default( LOCALTIMESTAMP(0) )		--// 更新日付
);
DROP INDEX idx_history_data ;
CREATE INDEX idx_history_data ON history_data USING btree (
	corpid			,
	history_date	,
	status
) ;
