--//
--// シリアルNo管理情報
--//
drop table serialno_data;
create table serialno_data (
	serialnoid			serial primary key ,					--// index
	type				int2 ,									--// タイプ（0:仮会員ログインid、1:伝票番号）
	serialno			text									--// シリアルno
);
DROP INDEX idx_serialno_data ;
CREATE INDEX idx_serialno_data ON serialno_data USING btree (
	type			,
	serialno		
) ;
