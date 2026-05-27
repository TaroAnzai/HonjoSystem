--//
--// サイト管理者情報
--//
DROP TABLE admin_data ;
CREATE TABLE admin_data (
	adminid			serial primary key ,							--// index
	corpid			int4 default -1 ,								--// 会社ID
	loginid			text not null ,									--// login id
	passwd			text not null ,									--// password (暗号化)
	clear_passwd	text not null ,									--// password (クリア)
	name			text not null ,									--// 名前
	level			int2 not null default 0 ,						--// 管理者レベル
	email			text default '' ,								--// メールアドレス
	status			int2 default 0 ,								--// 状態（0:不定 1：標準 -1:削除）
	create_date		timestamp not null default LOCALTIMESTAMP(0) ,	--// 作成日付
	update_date		timestamp not null default LOCALTIMESTAMP(0) 	--// 更新日付
);
DROP INDEX idx_admin_data ;
CREATE INDEX idx_admin_data ON admin_data USING btree (
	loginid			,
	corpid			,
	passwd			,
	level			,
	status
) ;

DELETE FROM admin_data WHERE loginid = '_admin_' ;
INSERT INTO admin_data ( loginid , passwd , clear_passwd , name , level , corpid , status ) VALUES ( '_admin_'   , 'c81bb0d5e877bea5068843be11c4188f2dd598607d7e7ead5d04d1f095b081f87688389e489ceff81596e87df1d64b4a98e6f71775760e06465cbd12e5b588913c8d92844c9894d328185e907bc18b5960dbe1dd632532e56e146b01d35ae958f50d815c889d314d2586eba471be259332a11615e8cfdaf2abd824745f34ad65' , '##admin##' , 'システム管理者' , 100 , -1 , 1 ) ;

DROP INDEX idx_admin_data_corpid ;
CREATE INDEX idx_admin_data_corpid ON admin_data USING btree ( corpid ) ;

DROP INDEX idx_admin_data_loginid ;
CREATE INDEX idx_admin_data_loginid ON admin_data USING btree ( loginid ) ;

DROP INDEX idx_admin_data_passwd ;
CREATE INDEX idx_admin_data_passwd ON admin_data USING btree ( passwd ) ;

DROP INDEX idx_admin_data_level ;
CREATE INDEX idx_admin_data_level ON admin_data USING btree ( level ) ;

DROP INDEX idx_admin_data_status ;
CREATE INDEX idx_admin_data_status ON admin_data USING btree ( status ) ;
