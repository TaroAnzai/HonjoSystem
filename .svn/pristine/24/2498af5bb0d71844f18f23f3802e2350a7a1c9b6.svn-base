--//
--// セッション管理情報
--//
drop table session_data ;
create table session_data (
	sessionid		serial primary key ,						--// index
	sid				text not null default '' ,					--// セッションid
	userid			int4 not null default -1 ,					--// ユーザid
	level			int2 not null default 0 ,					--// ユーザレベル
	remote_host		text not null default '' , 					--// リモートホスト
	status			int2 default 0 ,							--// 状態（0:不定 1：標準 -1:削除）
	login_date		timestamp default( LOCALTIMESTAMP(0) ) ,	--// ログイン日時
	logout_date		timestamp default( LOCALTIMESTAMP(0) ) ,	--// ログアウト日時
	active_date		timestamp default( LOCALTIMESTAMP(0) )		--// 滞在時間
);

DROP INDEX idx_session ;
CREATE INDEX idx_session ON session_data USING btree (
	sid				,
	userid			,
	level			,
	login_date		,
	logout_date		,
	active_date		
) ;

DROP INDEX idx_session_data_sid ;
CREATE INDEX idx_session_data_sid ON session_data USING btree ( sid ) ;

DROP INDEX idx_session_data_userid ;
CREATE INDEX idx_session_data_userid ON session_data USING btree ( userid ) ;

DROP INDEX idx_session_data_level ;
CREATE INDEX idx_session_data_level ON session_data USING btree ( level ) ;

DROP INDEX idx_session_data_status ;
CREATE INDEX idx_session_data_status ON session_data USING btree ( status ) ;

DROP INDEX idx_session_data_login_date ;
CREATE INDEX idx_session_data_login_date ON session_data USING btree ( login_date ) ;

DROP INDEX idx_session_data_logout_date ;
CREATE INDEX idx_session_data_logout_date ON session_data USING btree ( logout_date ) ;

DROP INDEX idx_session_data_active_date ;
CREATE INDEX idx_session_data_active_date ON session_data USING btree ( active_date ) ;
