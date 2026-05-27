--//
--// 諸設定情報
--//
drop table config_data ;
create table config_data(
	configid			serial primary key ,					--// index
	corpid				int4 default -1 ,						--// 会社ID
	yen_per_point		float4 default 1 ,						--// ポイント還元率 円/pt 500円＝1ptなど
	point_per_yen		float4 default 1 ,						--// ポイント加算率 円/pt 1000円で1pt加算など
	point_unit			int4 ,									--// ポイント使用単位 10pt単位など
	under_limit			int4 ,									--// 最低ポイント使用数 100pt以上など
	upper_limit			int4 ,									--// ポイント使用上限 100pt以下など（未使用）

	price_wrapping		int4 ,									--// 包装料金
	price_decoration	int4 ,									--// のし料金
	price_coolpack		int4 ,									--// クール便料金
	unit_per_box		int4 ,									--// 1箱あたりの 内容数 個/1箱
	deliver_start		int4 default 0 ,						--// 受注してから配送までの期間
	deliver_limittime	int4 default -1 ,						--// ～時以降はdeliver_start +1 日

	mail_timing			text ,									--// メール送信タイミング
	add_timing			int2 default 1 ,						--// 1:入金時 2:発送時

	twitter				text not null default '' ,				--// twitterアカウント
	facebook			text not null default '' ,				--// facebookアカウント

	status				int2 default 0 ,						--// 状態（0:不定 1：標準 -1:削除）
	create_date			timestamp not null default( LOCALTIMESTAMP(0) ) ,	--// 作成日付
	update_date			timestamp not null default( LOCALTIMESTAMP(0) )		--// 更新日付
);

