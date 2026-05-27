<?php
	// 実行ファイル情報
	$self = dirname( __FILE__ ) ;
	if ( defined( "SELF_PATH" ) == false )
		define( "SELF_PATH"			, realpath( $self . "/../uplink" ) ) ;
	if ( defined( "SELF_COMMAND" ) == false )
		define( "SELF_COMMAND"		, "server.php" ) ;
	if ( defined( "SELF_LIB" ) == false )
		define( "SELF_LIB"			, realpath( $self . "/../lib" ) ) ;
	if ( defined( "SELF_UPLINK" ) == false )
		define( "SELF_UPLINK"		, SELF_PATH ) ;
	if ( defined( "SELF_FULLCOMMAND" ) == false )
		define( "SELF_FULLCOMMAND"	, SELF_PATH . "/" . SELF_COMMAND ) ;
	
	ini_set( "include_path"		,	ini_get( "include_path" ) . ":" . SELF_LIB . ":" . SELF_UPLINK ) ;

	// コマンド
	define( "NAC_STORAGE_WASH"			,	"SENNYUKO" ) ;
	define( "NAC_STORAGE_PRODUCT"		,	"SEINYUKO" ) ;
	define( "NAC_SHIPPING_REQ"			,	"BCUSYUKO" ) ;
	define( "NAC_BCRDATA"				,	"BCRDATA" ) ;
	define( "NAC_STORAGE_LIST"			,	"ZAIKO" ) ;
	define( "NAC_FREE_LOCATION"			,	"AKITANA" ) ;
	define( "NAC_REPORT"				,	"REPORT" ) ;

	// 場所
	define( "NAC_LINE_PRODUCT"			,	1 ) ;
	define( "NAC_LINE_WASH"				,	2 ) ;

	// 商品コード
	define( "NAC_BCU_ON"				,	"B2" ) ;
	define( "NAC_BCU_OFF"				,	"C2" ) ;
	define( "NAC_BCU_REAL"				,	"E2" ) ;

	// 要求区分
	define( "NAC_KIND_START"			,	1 ) ;
	define( "NAC_KIND_NORML"			,	2 ) ;

	define( "NAC_DELIM"					,	"\r\n" ) ;

	// 自動倉庫データ長
	define( "NAC_MAX_LINE"				,	1 ) ;	// ライン区分
	define( "NAC_MAX_PRODUCTID"			,	2 ) ;	// 商品コード
	define( "NAC_MAX_BCUID"				,	10 ) ;	// ボトルコンテナID
	define( "NAC_MAX_COOL"				,	3 ) ;	// クールNO
	define( "NAC_MAX_STORAGE_DATE"		,	8 ) ;	// 入庫日
	define( "NAC_MAX_KIND"				,	1 ) ;	// 要求区分
	define( "NAC_MAX_AREAID"			,	4 ) ;	// エリアNO
	define( "NAC_MAX_LOCATIONNO"		,	9 ) ;	// 棚NO
	define( "NAC_MAX_NUMBER"			,	7 ) ;	// 在庫数
	define( "NAC_MAX_STORAGE_DATETIME"	,	12 ) ;	// 入庫日時
	define( "NAC_MAX_UPDATE_DATETIME"	,	12 ) ;	// 最終更新日時
	define( "NAC_MAX_IGNORE_FLG"		,	1 ) ;	// 最終更新日時
	define( "NAC_MAX_EMPTY"				,	4 ) ;	// 空棚数

	define( "NAC_DATA_FOLDER_SEND"		,	"/home/adpc/share/" ) ;		// 送信フォルダー
	define( "NAC_DATA_FOLDER_RECV"		,	"/home/adpc/share/" ) ;		// 受信フォルダー
	define( "NAC_DATA_FOLDER_REPORT"	,	"/home/adpc/report/" ) ;	// レポートフォルダー

	// シーケンサデータ長
	define( "SEQ_MAX_LINE"				,	2 ) ;	// ライン区分
	define( "SEQ_MAX_PRODUCTID"			,	2 ) ;	// 商品コード
	define( "SEQ_MAX_BCUID"				,	10 ) ;	// ボトルコンテナID
	define( "SEQ_MAX_STORAGE_DATE"		,	8 ) ;	// 入庫日
	define( "SEQ_MAX_KIND"				,	2 ) ;	// 要求区分
	define( "SEQ_MAX_BOTTLECODE"		,	24 ) ;	// ボトルコード

	define( "SEQ_LEN_STORAGE"			,	SEQ_MAX_LINE  + SEQ_MAX_PRODUCTID + ( SEQ_MAX_BCUID + ( SEQ_MAX_BOTTLECODE ) * 10 ) * 3 ) ;
	define( "SEQ_LEN_WASH"				,	SEQ_MAX_LINE + ( SEQ_MAX_PRODUCTID + SEQ_MAX_BCUID ) * 3 ) ;

	define( "SEQ_MAX_LIMITDATE"			,	10 ) ;	// 賞味期限
	define( "SEQ_MAX_LABELNO"			,	3 ) ;	// ラベル (No.)
	define( "SEQ_MAX_NOCOUNTER"			,	5 ) ;	// NOカウンター
	define( "SEQ_MAX_SEP"				,	1 ) ;	// ラベル ( - )
	define( "SEQ_MAX_COOL"				,	3 ) ;	// クール
	
	define( "SEQ_MAX_CNT_BCU"			,	3 ) ;	// BCU段積み数
	define( "SEQ_MAX_CNT_BOTTLE"		,	10 ) ;	// BCU内ボトル数
?>
