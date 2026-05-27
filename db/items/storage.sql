--//
--// 在庫情報
--//
DROP TABLE storage_data ;
CREATE TABLE storage_data(
	storageid			serial primary key ,								--// index
	code				int4 not null ,										--// 商品コード
	cool				date not null ,										--// クール
	bcuid				text not null ,										--// BCU ID
	areano				text not null ,										--// エリアNO
	locationno			text not null ,										--// 棚NO
	number				int4 not null ,										--// 在庫数
	storage_date		timestamp not null default( LOCALTIMESTAMP(0) ) ,	--// 入庫日
	maintenance_date	timestamp not null default( LOCALTIMESTAMP(0) )		--// 操作時間
	ignore_flg			
	create_date			timestamp not null default( LOCALTIMESTAMP(0) ) ,	--// 作成日付
	update_date			timestamp not null default( LOCALTIMESTAMP(0) )		--// 更新日付
);

DROP INDEX idx_storage_data_code ;
CREATE INDEX idx_storage_data_code ON storage_data USING btree (	code	) ;

DROP INDEX idx_storage_data_cool ;
CREATE INDEX idx_storage_data_cool ON storage_data USING btree (	cool	) ;

DROP INDEX idx_storage_data_bcuid ;
CREATE INDEX idx_storage_data_bcuid ON storage_data USING btree (	bcuid	) ;

DROP INDEX idx_storage_data_areano ;
CREATE INDEX idx_storage_data_areano ON storage_data USING btree (	areano	) ;

DROP INDEX idx_storage_data_locationno ;
CREATE INDEX idx_storage_data_locationno ON storage_data USING btree (	locationno	) ;

DROP INDEX idx_storage_data_number ;
CREATE INDEX idx_storage_data_number ON storage_data USING btree (	number	) ;

DROP INDEX idx_storage_data_storage_date ;
CREATE INDEX idx_storage_data_storage_date ON storage_data USING btree (	storage_date	) ;

DROP INDEX idx_storage_data_maintenance_date ;
CREATE INDEX idx_storage_data_maintenance_date ON storage_data USING btree (	maintenance_date	) ;

DROP INDEX idx_storage_data_maintenance_date ;
CREATE INDEX idx_storage_data_maintenance_date ON storage_data USING btree (	maintenance_date	) ;

DROP INDEX idx_storage_data_maintenance_date ;
CREATE INDEX idx_storage_data_maintenance_date ON storage_data USING btree (	maintenance_date	) ;
