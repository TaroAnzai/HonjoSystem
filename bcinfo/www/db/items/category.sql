--//
--// カテゴリ管理情報
--//
DROP TABLE category_data ;
CREATE table category_data(
	categoryid			serial primary key ,					--// index
	corpid				int4 not null default -1 ,				--// 自社情報ID
	kind				int2 not null default 0 ,				--// 種類（1:業種 2:商品 3:メニュー 4:役職 5:リンク）
	name				text not null ,							--// カテゴリ名
	category1			int4 default 0 ,						--// カテゴリno（大項目no1～32）
	category2			int4 default 0 ,						--// カテゴリno（中項目no1～32）
	category3			int4 default 0 ,						--// カテゴリno（小項目no1～32）

	status				int2 default 0 ,						--// 状態（0:不定 1：標準 -1:削除）
	create_date			timestamp not null default( LOCALTIMESTAMP(0) ) ,	--// 作成日付
	update_date			timestamp not null default( LOCALTIMESTAMP(0) )		--// 更新日付
);
DROP INDEX idx_category_data ;
CREATE INDEX idx_category_data ON category_data USING btree (
	kind				,
	category1			,
	category2			,
	category3			,
	status
) ;

INSERT INTO category_data ( kind , category1 , category2 , category3 , status , name ) VALUES ( 1 , 99 , 0 , 0 , 1 , 'その他' ) ;
INSERT INTO category_data ( kind , category1 , category2 , category3 , status , name ) VALUES ( 2 , 99 , 0 , 0 , 1 , 'その他' ) ;
INSERT INTO category_data ( kind , category1 , category2 , category3 , status , name ) VALUES ( 3 , 1  , 0 , 0 , 1 , '標準' ) ;
INSERT INTO category_data ( kind , category1 , category2 , category3 , status , name ) VALUES ( 3 , 99 , 0 , 0 , 1 , 'その他' ) ;
