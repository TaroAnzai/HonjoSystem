--//
--// カテゴリ管理情報
--//
DROP TABLE permission_data ;
CREATE table permission_data(
	permissionid		serial primary key ,					--// index
	kind				int2 not null default 0 ,				--// 種類（100:管理者）
	name				text not null ,							--// カテゴリ名
	category1			int4 default 0 ,						--// カテゴリno（大項目no1～32）
	category2			int4 default 0 ,						--// カテゴリno（中項目no1～32）
	category3			int4 default 0 ,						--// カテゴリno（小項目no1～32）

	permission1			int4 default 0 ,						--// bit0 ～ bit32 機能が使える場合、bit ON
	permission2			int4 default 0 ,						--// bit0 ～ bit32 機能が使える場合、bit ON
	permission3			int4 default 0 ,						--// bit0 ～ bit32 機能が使える場合、bit ON
	permission4			int4 default 0 ,						--// bit0 ～ bit32 機能が使える場合、bit ON

	status				int2 default 0 ,						--// 状態（0:不定 1：標準 -1:削除）
	create_date			timestamp not null default( LOCALTIMESTAMP(0) ) ,	--// 作成日付
	update_date			timestamp not null default( LOCALTIMESTAMP(0) )		--// 更新日付
);
DROP INDEX idx_permission_data ;
CREATE INDEX idx_permission_data ON permission_data USING btree (
	kind				,
	category1			,
	category2			,
	category3			,
	status
) ;

INSERT INTO permission_data ( kind , category1 , category2 , category3 , permission1 , permission2 , permission3 , permission4 , status , name ) 
VALUES ( 100 , 1  , 0 , 0 , cast(X'bffffff8' as int4) , cast(X'0ffb7' as int4) , 0 , 0 , 1 , 'システム管理者' ) ;
INSERT INTO permission_data ( kind , category1 , category2 , category3 , permission1 , permission2 , permission3 , permission4 , status , name ) 
VALUES ( 100 , 99 , 0 , 0 ,  0 ,  0 ,  0 ,  0 , 1 , 'ゲスト' ) ;

INSERT INTO permission_data ( kind , category1 , category2 , category3 , permission1 , permission2 , permission3 , permission4 , status , name ) 
VALUES ( 101 , 1  , 0 , 0 , cast(X'bffffff8' as int4) , cast(X'0ffb7' as int4) , 0 , 0 , 1 , '無料' ) ;
INSERT INTO permission_data ( kind , category1 , category2 , category3 , permission1 , permission2 , permission3 , permission4 , status , name ) 
VALUES ( 101 , 99 , 0 , 0 ,  0 ,  0 ,  0 ,  0 , 1 , 'ゲスト' ) ;

INSERT INTO permission_data ( kind , category1 , category2 , category3 , permission1 , permission2 , permission3 , permission4 , status , name ) 
VALUES ( 102 , 1  , 0 , 0 , cast(X'bffffff8' as int4) , cast(X'0ffb7' as int4) , 0 , 0 , 1 , '無料' ) ;
INSERT INTO permission_data ( kind , category1 , category2 , category3 , permission1 , permission2 , permission3 , permission4 , status , name ) 
VALUES ( 102 , 99 , 0 , 0 ,  0 ,  0 ,  0 ,  0 , 1 , 'ゲスト' ) ;
