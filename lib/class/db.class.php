<?php
/**
* DB処理クラス
*
* DBアクセス<br>
* 
* @author H.Saitoh <hsaitoh@blazinghills.com>
* @copyright Copyright(c)  Blazinghills.com. All rights reserved.
* @filesource
* @package BLAMS Blazinghills Contents Managemant System.
*/

/**
* DBアクセスクラス (PostgreSQL) 
*
* DBへのアクセスメソッドを提供します<br>
*
* @author H.Saitoh <hsaitoh@blazinghills.com>
* @copyright Copyright(c)  Blazinghills.com. All rights reserved.
* @filesource
* @package BLAMS Blazinghills Contents Managemant System.
*/
// //ini_set( "display_errors" ,1 ) ;

/** Error reporting */
if ( defined( "DEF_ERROR_LEVEL" ) == true )
	error_reporting( DEF_ERROR_LEVEL ) ;

if ( !function_exists( "stripos" ) )
{
	function stripos( $str , $needle , $offset = 0 )
	{
		return strpos( strtolower( $str ) , strtolower( $needle ) , $offset ) ;
	}
}

if ( !function_exists( "str_ireplace" ) )
{
	function str_ireplace( $search , $replace , $subject )
	{
		$search = preg_quote( $search , "/" ) ;
		return preg_replace( "/" . $search . "/i " , $replace , $subject ) ;
	}
}


// テンプレートエンコードが未定義の場合、初期値を設定する
if ( defined( "DEF_TEMPLATE_ENCODE" ) != true )
	define( "DEF_TEMPLATE_ENCODE" , "UTF-8" ) ;

// 内部エンコードが未定義の場合、初期値を設定する
if ( defined( "DEF_INTERNAL_ENCODE" ) != true )
	define( "DEF_INTERNAL_ENCODE" , "sjis-win" ) ;

define( "JUMP_PER_PAGE"			,	20	) ;		// 行数／ページ
define( "NUMBER_PER_PAGE"		,	20	) ;		// 行数／ページ

//
// 許可状態
//
$_FUNC = 0 ;
define( "DEF_AGREEMENTSTATUS_DENY"	,	$_FUNC ++	) ;		// 不可
define( "DEF_AGREEMENTSTATUS_ALLOW"	,	$_FUNC ++	) ;		// 許可

global	$arAgreement ;
$arAgreement = array(
	DEF_AGREEMENTSTATUS_DENY	=> "不可" ,
	DEF_AGREEMENTSTATUS_ALLOW	=> "許可" ,
) ;

//
// 編集状態
//
$_FUNC = 0 ;
define( "DEF_EDITSTATUS_EDITTING"	,	$_FUNC ++	) ;		// 編集中
define( "DEF_EDITSTATUS_OPENED"		,	$_FUNC ++	) ;		// 公開ＯＫ
define( "DEF_EDITSTATUS_APPROVAL"	,	$_FUNC ++	) ;		// 承認
define( "DEF_EDITSTATUS_DELETED"	,	$_FUNC ++	) ;		// 削除

global	$arEditStatus ;
$arEditStatus = array(
	DEF_EDITSTATUS_EDITTING	=> "非公開" ,
	DEF_EDITSTATUS_OPENED	=> "公開" ,
	DEF_EDITSTATUS_APPROVAL	=> "承認" ,
	DEF_EDITSTATUS_DELETED	=> "削除" ,
) ;

//
// 日付関連
//
define( "DEF_DATE_MAX_YEAR"				,	9999	) ;
define( "DEF_DATE_MAX_MONTH"			,	12		) ;
define( "DEF_DATE_MAX_DAY"				,	31		) ;
define( "DEF_DATE_MAX_HOUR"				,	23		) ;
define( "DEF_DATE_MAX_MINUTE"			,	59		) ;
define( "DEF_DATE_MAX_SECOND"			,	59		) ;
define( "DEF_DATE_MAX"					,	sprintf( "%04d-%02d-%02d %02d:%02d:%02d" 
												, DEF_DATE_MAX_YEAR 
												, DEF_DATE_MAX_MONTH 
												, DEF_DATE_MAX_DAY 
												, DEF_DATE_MAX_HOUR 
												, DEF_DATE_MAX_MINUTE 
												, DEF_DATE_MAX_SECOND ) ) ;
define( "DEF_DATE_MIN_YEAR"				,	1		) ;
define( "DEF_DATE_MIN_MONTH"			,	1		) ;
define( "DEF_DATE_MIN_DAY"				,	1		) ;
define( "DEF_DATE_MIN_HOUR"				,	0		) ;
define( "DEF_DATE_MIN_MINUTE"			,	0		) ;
define( "DEF_DATE_MIN_SECOND"			,	0		) ;
define( "DEF_DATE_MIN"					,	sprintf( "%04d-%02d-%02d %02d:%02d:%02d" 
												, DEF_DATE_MIN_YEAR 
												, DEF_DATE_MIN_MONTH 
												, DEF_DATE_MIN_DAY 
												, DEF_DATE_MIN_HOUR 
												, DEF_DATE_MIN_MINUTE 
												, DEF_DATE_MIN_SECOND ) ) ;

define( "DEF_DATE_LIMIT_YEAR"				,	1000	) ;

define( "DEF_DUMMY_PASSWORD"	,	"********"	) ;		// 非表示で使うダミーパスワード

// 秘密キー
if ( defined( "DEF_BLAMS_CRYPT_PRIVATEKEY" ) != true )
{
	define( "DEF_BLAMS_CRYPT_PRIVATEKEY" ,	"-----BEGIN RSA PRIVATE KEY-----\n" .
											"MIICXQIBAAKBgQDpOtKmASKe2EAhrVLbEu1Hi/thM+D0rGnPlImgicWVp7ZE4+qG\n" .
											"JIDYleSmJXG0WVrBk23ZD70GRQM2GtnWZwKCrvfkKWWp5279HTQQVs0bQMxP1e/P\n" .
											"60m2JNxCkxNTAS/3eJPMoqsl7sQpZfAx9AOYq2TyS9axRAqx0xgRJ9InXwIDAQAB\n" .
											"AoGATcFPowpz2VMtJk0bd2/67URs3T4nfErSx+K0c3IbDkaojJUThf87eXmXjhCj\n" .
											"tMWpbSnSkHAfy6xMYshW4ZTcD8R0CKmLd8xRZQOihQeyDLUlq4MAR4KNiFpLi2ao\n" .
											"dAv5sZ64ib2DLLyWDx/Od0gGk6DT6HerGJvkGaqiqkpp6bECQQD8aRvhzoAYwSuK\n" .
											"aqA6lmwPFo8+RSj1BNqHfRHDGExBC5YY1qMHxU8s+1SEiDxO7oxwj4nz4Mf7ZuA6\n" .
											"zXz/lMYnAkEA7IvjDrQ3h7tJ/4YqAZSW8ylOpoyjt+lo09IoyLfGhp2hYL6lKHAD\n" .
											"Epj4zkQC7QlhxPHdPDVpuSjbNKvdMt1QCQJAfZlD4Yni3e6JXvgNwPmGzb85ChBa\n" .
											"AAopP5AxnXXiw98jEjsDpuM8sbJibQxpjhFP2tbiG3O3r1aSr0//KiJ6swJBALk7\n" .
											"cbp59WIcj33BGfPS38HafvR8/VdvN99nmvhSsOuJVG3l3H8l98IAeBVNvNzRk/Yd\n" .
											"UBlt2jRcggtk6fqCw8ECQQDDq7qZB0kTWjCazDp0GrknV9pnfuCX4AblIZwGGCUv\n" .
											"MVTnRsGJ/3LbTZfx2DZF4HuZ1zuF6h1CFf+OdK85wUOI\n" .
											"-----END RSA PRIVATE KEY-----"
										) ;
}

// 公開キー
if ( defined( "DEF_BLAMS_CRYPT_PUBLICKEY" ) != true )
{
	define( "DEF_BLAMS_CRYPT_PUBLICKEY" ,	"-----BEGIN PUBLIC KEY-----\n" .
											"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpOtKmASKe2EAhrVLbEu1Hi/th\n" .
											"M+D0rGnPlImgicWVp7ZE4+qGJIDYleSmJXG0WVrBk23ZD70GRQM2GtnWZwKCrvfk\n" .
											"KWWp5279HTQQVs0bQMxP1e/P60m2JNxCkxNTAS/3eJPMoqsl7sQpZfAx9AOYq2Ty\n" .
											"S9axRAqx0xgRJ9InXwIDAQAB\n" .
											"-----END PUBLIC KEY-----"
										) ;
}

session_name( "SSID" ) ;

// 基本的なメソッドを持ったクラスを作成する
class	DB_CommonBase
{
	var	$conn ;			// Connection
	var	$record ;		// Record
	
	var	$dbname ;
	var	$dbuser ;
	var	$dbpasswd ;
	var	$dbhost ;
	var	$dbport ;

	var	$tname ;
	var	$alias ;
	var	$primarykey ;
	var $searchkey ;
	
	var $fieldsData ;
	var $fields ;
	var $images ;

	var $bChild ;

	var $per_page = -1 ;

	var	$arData ;

	var	$privkey ;
	var	$pubkey ;

	var $skip_check ;

	function	__construct( $dbname = "" , $user = "" , $passwd = "" , $host = "" , $port = "" , $tname = "" , $alias = "" , $primarykey = "" )
	{
		$this -> conn = -1 ;
		$this -> bChild = false ;

		if ( is_resource( $dbname ) == true )
		{
			$typename = get_resource_type( $dbname ) ;
			if ( strpos( $typename , DEF_DB_RESOURCE ) !== false )
			{
				$this -> conn = $dbname ;
				$this -> bChild = true ;
			}
		}

		if ( $tname == "" )
			$tname = "pg_class" ;

		$this -> dbname			= $dbname ;
		$this -> dbuser			= $user ;
		$this -> dbpasswd		= $passwd ;
		$this -> dbhost			= $host ;
		$this -> dbport			= $port ;
	
		$this -> tname			= $tname ;
		$this -> alias			= $alias ;
		$this -> primarykey		= $primarykey ;
		$this -> searchkey		= array() ;

		$this -> fieldsData		= array() ;
		$this -> fields			= array() ;
		$this -> images			= array() ;

		$this -> arData			= array() ;

		$this -> privkey		= DEF_BLAMS_CRYPT_PRIVATEKEY ;
		$this -> pubkey			= DEF_BLAMS_CRYPT_PUBLICKEY ;

		$this -> skip_check		= false ;

		$this -> connectDatabase( $dbname , $user , $passwd , $host , $port ) ;
		if ( $this -> isOpen() == true )
		{
			$this -> fieldsData	= $this -> getFieldsOnTable( $this -> tname ) ;
			$this -> fields		= $this -> getFieldsnameOnTable( $this -> fieldsData ) ;
		}
		else
		{
			// 代替接続にテーブルが存在をしなければクローズ
			if (
					defined( "DB_MAIN_NAME"   ) == true &&
					defined( "DB_MAIN_USER"   ) == true &&
					defined( "DB_MAIN_PASSWD" ) == true 
			)
			{
				$host = "" ;
				if ( defined( "DB_MAIN_HOST" ) == true )
					$host = DB_MAIN_HOST ;
			
				$port = "" ;
				if ( defined( "DB_MAIN_PORT" ) == true )
					$port = DB_MAIN_PORT ;
				
				// 既存の接続を保存
				if ( $this -> connectDatabase( DB_MAIN_NAME , DB_MAIN_USER , DB_MAIN_PASSWD , $host , $port ) )
				{
					if ( $this -> isOpen() == true )
					{
						if ( $this -> bChild == true )
							$this -> bChild = false ;
						
						$this -> fieldsData	= $this -> getFieldsOnTable( $this -> tname ) ;
						$this -> fields		= $this -> getFieldsnameOnTable( $this -> fieldsData ) ;
					}
				}
			}
		}
	}

	function	__destruct()
	{
		$this -> disconnectDatabase() ;
	}

	function	isOpen()
	{
		if ( is_resource( $this -> conn ) == true )
		{
			// テーブル名が指定されていれば オープン成功
			if ( $this -> tname != "" )
			{
				// テーブルが存在をしなければクローズ
				if ( $this -> tableExists( $this -> tname ) != true )
					$this -> disconnectDatabase() ;
			}
			else
			{
				// テーブル名が指定されてなければ クローズ
				$this -> disconnectDatabase() ;
			}
		}
		else
		{
			$this -> disconnectDatabase() ;
		}
		return is_resource( $this -> conn ) ;
	}

	// 暗号化キーペアの作成
	function	createCryptKey()
	{
		if ( ( $res = openssl_pkey_new() ) != false )
		{
			if ( openssl_pkey_export( $res , $privkey ) == true )
				echo $privkey ;
		
			$pubkey = openssl_pkey_get_details( $res ) ;
			if ( empty( $pubkey[ "key" ] ) == false )
				echo $pubkey[ "key" ] ;

			openssl_free_key( $res ) ;
		}
	}
	
	// 文字列の暗号化
	function	encrypt( $data )
	{
		$privkey = $this -> privkey ;

		if ( openssl_private_encrypt( $data , $dest , $privkey ) )
			$data = bin2hex( $dest ) ;
		return $data ;
	}
	
	// 文字列の復号化
	function	decrypt( $data )
	{
		$pubkey = $this -> pubkey ;
		
		$data = pack( "H*" , $data ) ;
		if ( openssl_public_decrypt( $data , $src , $pubkey ) )
			$data = $src ;
		return $data ;
	}

	// 全角スペース から 半角スペース へ
	// 全角英数文字 から 半角英数文字 へ
	// 半角カタカナ から 全角カタカナ へ
	// 濁点を含むカタカナを 1文字へ
	function mb2sb_toupper( $data )
	{
		// SJIS から EUC へ
		$data = mb_convert_encoding( $data , DEF_TEMPLATE_ENCODE , DEF_INTERNAL_ENCODE ) ;
	
		// 全角スペース から 半角スペース へ
		// 全角英数文字 から 半角英数文字 へ
		// 半角カタカナ から 全角カタカナ へ
		// 濁点を含むカタカナを 1文字へ
		$data = mb_convert_kana( $data , "saVK" , DEF_TEMPLATE_ENCODE ) ;
	
		// 削除：小文字から 大文字へ
		$data = mb_strtoupper( $data , DEF_TEMPLATE_ENCODE ) ;
	
		// EUC から SJISへ
		$data = mb_convert_encoding( $data , DEF_INTERNAL_ENCODE , DEF_TEMPLATE_ENCODE ) ;
	
		return $data ;
	}

	// 全角スペース から 半角スペース へ
	// 全角英数文字 から 半角英数文字 へ
	// 半角カタカナ から 全角カタカナ へ
	// 濁点を含むカタカナを 1文字へ
	function mb2sb( $data )
	{
		// SJIS から EUC へ
		$data = mb_convert_encoding( $data , DEF_TEMPLATE_ENCODE , DEF_INTERNAL_ENCODE ) ;
	
		// 全角スペース から 半角スペース へ
		// 全角英数文字 から 半角英数文字 へ
		// 半角カタカナ から 全角カタカナ へ
		// 濁点を含むカタカナを 1文字へ
		$data = mb_convert_kana( $data , "saVK" , DEF_TEMPLATE_ENCODE ) ;
	
		// EUC から SJISへ
		$data = mb_convert_encoding( $data , DEF_INTERNAL_ENCODE , DEF_TEMPLATE_ENCODE ) ;
	
		return $data ;
	}

	function hira2kana( $data )
	{
		// SJIS から EUC へ
		$data = mb_convert_encoding( $data , DEF_TEMPLATE_ENCODE , DEF_INTERNAL_ENCODE ) ;
	
		// 全角スペース から 半角スペース へ
		// 全角英数文字 から 半角英数文字 へ
		// 半角カタカナ から 全角カタカナ へ
		// 濁点を含むカタカナを 1文字へ
		$data = mb_convert_kana( $data , "KC" , DEF_TEMPLATE_ENCODE ) ;
	
		// EUC から SJISへ
		$data = mb_convert_encoding( $data , DEF_INTERNAL_ENCODE , DEF_TEMPLATE_ENCODE ) ;
	
		return $data ;
	}

	// 特殊文字対応（マルチバイト対策）
	function mb_addslashes( $src )
	{
		$data = $src ;
		$data = $this -> mb2sb( $data ) ;
		$data = pg_escape_string( $this -> conn , $data ) ;
		return $data ;
	}

	// マルチバイトの文字列置換
	function	mb_str_replace( $from , $to , $data , $enc = DEF_INTERNAL_ENCODE )
	{
		$pos = mb_strpos( $data , $from , 0 , $enc ) ;
		if ( $pos !== false )
		{
			$prev = mb_substr( $data , 0 , $pos , $enc ) ;
			$bottom = mb_substr( $data , $pos + mb_strlen( $from , $enc ) , mb_strlen( $data , $enc ) , $enc ) ;
			$data = $prev . $to . $bottom ;
		}
		
		return $data ;
	}

	//パスワード生成
	function makePassword( $len = 8 )
	{
		$pw = '';

		for ( $i = 0 ; $i < $len ; $i ++ )
		{
			$pw = $pw . $this -> makePasswordSub() ;
		}

		return $pw ;
	}

	// ランダムなパスワードの生成
	function makePasswordSub()
	{
		$i = 0 ;

		mt_srand( (double)microtime() * 1000000 ) ;
		$i = mt_rand( 0 , 2 ) ;

		$c = "" ;

		switch ( $i )
		{
		case	0 :	// 大文字英文字
			$c = chr( ord( "A" ) + mt_rand( 0 , 25 ) ) ;
			break ;
		case	1 :	// 小文字英文字
			$c = chr( ord( "a" ) + mt_rand( 0 , 25 ) ) ;
			break ;
		case	2 :	// 数字
			$c = chr( ord( "0" ) + mt_rand( 0 , 9 ) ) ;
			break ;
		}
		return $c ;

	}

	// パラメータのグローバル変数への登録
	function assignGlobal( $additional = array() , &$arParam = array() )
	{
		// 検索キーをGET形式にしてクッキーに保存する
		$cookiepath = rtrim( $_SERVER[ "REQUEST_URI" ] , "/" ) ;
		if ( ( $pos = strrpos( $cookiepath , "/" ) ) !== false )
			$cookiepath = substr( $cookiepath , 0 , $pos ) ;

		// 既存のクッキーデータ内のセッションIDと現在のセッションIDを比べる
		$cookie = $_COOKIE ;
		$sname		= session_name() ;
		if ( empty( $cookie[ $sname  ] ) == false )
		{
			$bClear = true ;
			if ( empty( $cookie[ $sname . "PATH" ] ) == false )
			{
				$snamepath = $cookie[ $sname . "PATH" ] ;
				if ( $snamepath == $cookie[ $sname  ] )
					$bClear = false ;
			}
			
			unset( $cookie[ $sname ] ) ;
			if ( $bClear == true )
			{
				foreach ( $cookie as $key => $value )
				{
					setcookie( $key , $value ,  time() - 86400 , $cookiepath , $_SERVER[ "HTTP_HOST" ] , false , true ) ;
					unset( $_COOKIE[ $key  ] ) ;
				}
			}
		}
		
		$keys = $this -> searchkey ;
		
		if ( $this -> alias != "" )
		{
			foreach ( $this -> fields as $value )
				$keys[] = sprintf( "%s_%s" , $this -> alias , $value ) ;
		}
		else
		{
			$keys = array_merge( $keys , $this -> fields ) ;
		}

		$keys = array_merge( $keys , $additional ) ;

		$arRequest = array() ;
		foreach ( $keys as $value )
		{
			global	${ $value } ;
			if ( isset( $_POST[ $value ] ) )
				$arRequest[ $value ] = $_POST[ $value ] ;
			else if ( isset( $_GET[ $value ] ) )
				$arRequest[ $value ] = $_GET[ $value ] ;
			else if ( isset( $_COOKIE[ $value ] ) )
				$arRequest[ $value ] = $_COOKIE[ $value ] ;
			else
				$arRequest[ $value ] = "" ;
			if ( is_array( $arRequest[ $value ] ) == false )
				$arRequest[ $value ] = $this -> mb2sb( $arRequest[ $value ] ) ;
		}
		foreach ( $arRequest as $key => $value )
			${ $key } = $value ;

		// 検索パラメータ用にセッションIDを保存する
		if ( empty( $_COOKIE[ $sname  ] ) == false )
		{
			$cnt = 0 ;
			foreach ( $this -> searchkey as $key )
			{
				if ( empty( ${ $key } ) == false )
				{
					setcookie( $key , ${ $key } ,  time() + 86400 , $cookiepath , $_SERVER[ "HTTP_HOST" ] , false , true ) ;
					$cnt ++ ;
				}
			}
			
			if ( $cnt > 0 )
			{
				${ $sname . "PATH" }	= $_COOKIE[ $sname  ] ;
				setcookie( $sname . "PATH" , ${ $sname . "PATH" } ,  time() + 86400 , $cookiepath , $_SERVER[ "HTTP_HOST" ] , false , true ) ;
			}
		}
		
		// プライマリキーが空白の場合、-1を設定する
		$primarykey = $this -> primarykey ;
		if ( $this -> alias != "" )
			$primarykey = sprintf( "%s_%s" , $this -> alias , $primarykey ) ;

		if ( empty( ${ $primarykey } ) == true )
			${ $primarykey } = -1 ;

		// 配列に読み込んだデータを保存する。
		$this -> makeParam( $arParam ) ;
	}

	// パスワードのチェック
	function	checkPassword( &$passwd , &$crypt_passwd )
	{
		$error = "" ;

		// パスワード
		if ( empty( $passwd ) == true )
		{
			// 暗号化パスワードも空白の場合、自動生成する
			if ( empty( $crypt_passwd ) == true )
			{
				$passwd			= $this -> makePassword() ;
				$passwd			= $this -> encrypt( $passwd ) ;
				$crypt_passwd	= $passwd ;
			}
			else
			{
				$error .= "・パスワードが入力されていません\n" ;
			}
		}
		else if ( $passwd == DEF_DUMMY_PASSWORD )
		{
			if ( empty( $crypt_passwd ) == false )
			{
				$passwd = $crypt_passwd ;
			}
			else
			{
				$passwd = "" ;
				$error .= "・パスワードに使用できない文字が入力されています。\n" ;
			}
		}
		else if ( preg_match( "/[^!-~]+/" , $passwd ) )
		{
			$passwd = "" ;
			$error .= "・パスワードに使用できない文字が入力されています。\n" ;
		}
		else
		{
			$len = strlen( $passwd ) ;
			if ( $len < 8 || $len > 16 )
			{
				$passwd = "" ;
				$error .= "・パスワードは8文字以上16文字以下で入力してください。\n" ;
			}
			else
			{
				$passwd			= $this -> encrypt( $passwd ) ;
				$crypt_passwd	= $passwd ;
			}
		}
		
		return $error ;
	}

	// 郵便番号の入力チェック
	function	checkZip( &$zip , $zip1 , $zip2 )
	{
		$error = "" ;
		
		if ( is_numeric( $zip1 ) == true && is_numeric( $zip2 ) == true )
			$zip = sprintf( "%s-%s" , $zip1 , $zip2 ) ;
		else
			$error = "・郵便番号が正しく入力されていません。\n" ; ;
		return $error ;
	}
	
	// 電話番号の入力チェック
	function	checkTel( &$tel , $skip , $tel1 , $tel2 , $tel3 )
	{
		$error = "" ;
		
		if ( $tel1 != "" || $tel2 != "" || $tel3 != "" )
		{
			if ( is_numeric( $tel1 ) != true && is_numeric( $tel2 ) != true && is_numeric( $tel3 ) != true )
				$error = "・電話番号が正しく入力されていません。\n" ;
			else
				$tel = sprintf( "%s-%s-%s" , $tel1 , $tel2 , $tel3 ) ;
		}
		else if ( $skip != true )
		{
			$error = "・電話番号が入力されていません。\n" ;
		}
		return $error ;
	}
	
	// 日付の入力チェック
	// his : dateに時刻がいらない場合はfalse ( date型に対応 )
	function	checkDate( &$date , $skip , $year , $month = null , $day = null , $his = true , $word = "日付" )
	{
		$error = "" ;

		$hour = 0 ;
		$min = 0 ;
		$sec = 0 ;
		
		// 省略が可能か？
		if ( $skip == true )
		{
			// すべて空白なら $dateのデータを使用する
			if (	$year == "" &&
					( is_null( $month ) == true || $month == "" ) &&
					( is_null( $day   ) == true || $day   == "" )
				)
			{
				$obDate	= new DateTime( $date ) ;
				$year	= intval( $obDate -> format( "Y" ) ) ;
				$month	= intval( $obDate -> format( "m" ) ) ;
				$day	= intval( $obDate -> format( "d" ) ) ;

				$hour	= intval( $obDate -> format( "H" ) ) ;
				$min	= intval( $obDate -> format( "i" ) ) ;
				$sec	= intval( $obDate -> format( "s" ) ) ;
			}
		}

		if ( is_null( $month ) == true )
			$month = 1 ;
			
		if ( is_null( $day ) == true )
			$day = 1 ;

		if ( is_numeric( $year ) == true && is_numeric( $month ) == true && is_numeric( $day ) == true )
		{
			if ( checkdate( $month , $day , $year ) == true )
			{
				$obDate = new DateTime( sprintf( "%04d-%02d-%02d %02d:%02d:%02d" , $year , $month , $day , $hour , $min , $sec ) ) ;
				if( $his == true )
					$date = $obDate -> format( "'Y-m-d H:i:s'" ) ;
				else
					$date = $obDate -> format( "'Y-m-d'" ) ;
				$result = true ;
			}
			else
			{
				$error = sprintf( "・指定された%sは正しくありません。\n" , $word ) ;
			}
		}
		else
		{
			$error = sprintf( "・%sが正しく入力されていません。\n" , $word ) ;
		}

		return $error ;
	}

	// 日付の入力チェック
	// ymd : dateに日付がいらない場合はfalse ( date型に対応 )
	function	checkTime( &$date , $skip , $hour , $minutes = null , $second = null , $ymd = true , $word = "時刻" )
	{
		$error = "" ;

		// 省略が可能か？
		if ( $skip == true )
		{
			// すべて空白なら $dateのデータを使用する
			if (	$hour == "" &&
					( is_null( $minutes ) == true || $minutes == "" ) &&
					( is_null( $second  ) == true || $second  == "" )
				)
			{
				$obDate		= new DateTime( $date ) ;
				$hour		= intval( $obDate -> format( "H" ) ) ;
				$minutes	= intval( $obDate -> format( "i" ) ) ;
				$second		= intval( $obDate -> format( "s" ) ) ;
			}
		}

		if ( is_null( $minutes ) == true )
			$minutes = 0 ;
			
		if ( is_null( $second ) == true )
			$second = 0 ;

		if ( is_numeric( $hour ) == true && is_numeric( $minutes ) == true && is_numeric( $second ) == true )
		{
			if (	( $hour >= 0 && $hour <= 23 ) &&
					( $minutes >= 0 && $minutes <= 59 ) &&
					( $second >= 0 && $second <= 59 )
				)
			{
				$obDate = new DateTime() ;
				$obDate -> setTime( $hour , $minutes , $second ) ;
				if( $ymd == true )
					$date = $obDate -> format( "'Y-m-d H:i:s'" ) ;
				else
					$date = $obDate -> format( "'H:i:s'" ) ;
				$result = true ;
			}
			else
			{
				$error = sprintf( "・指定された%sは正しくありません。\n" , $word ) ;
			}
		}
		else
		{
			$error = sprintf( "・%sが正しく入力されていません。\n" , $word ) ;
		}

		return $error ;
	}

	//
	// 画像関連の変数名の初期化
	function	initImageParam( $arKeys , &$arParam )
	{
		global	$_FILES ;
		global	$_POST ;
	
		$alias	= $this -> alias ;
	
		$arResult = array() ;
		foreach( $arKeys as $name )
		{
			$keys = $alias . "_" . $name ;
			
			// POSTデータに無い場合、ダミーでデータを作成する
			if ( empty( $_FILES[ $keys . "_img" ] ) == true )
			{
				$_FILES[ $keys . "_img" ] = array() ;
				$_FILES[ $keys . "_img" ][ "tmp_name" ] = "" ;
				$_FILES[ $keys . "_img" ][ "name" ] = "" ;
				$_FILES[ $keys . "_img" ][ "size" ] = "" ;
				$_FILES[ $keys . "_img" ][ "type" ] = "" ;
			}
			
			if ( empty( $_POST[ $keys ] ) == true )
				$_POST[ $keys ] = -1 ;
	
			if ( empty( $_POST[ $keys . "_org" ] ) == true )
				$_POST[ $keys . "_org" ] = -1 ;

			if ( empty( $_POST[ $keys . "_org_name" ] ) == true )
				$_POST[ $keys . "_org_name" ] = "" ;
			
			if ( empty( $_POST[ $keys . "_tmp" ] ) == true )
				$_POST[ $keys . "_tmp" ] = -1 ;
			
			$arResult[ $keys	 				] = $_POST[ $keys					] ;
			$arResult[ $keys . "_org"			] = $_POST[ $keys . "_org"			] ;
			$arResult[ $keys . "_org_name"		] = $_POST[ $keys . "_org_name"		] ;
			$arResult[ $keys . "_tmp"			] = $_POST[ $keys . "_tmp"			] ;
	
			$arResult[ $keys . "_img"			] = $_FILES[ $keys . "_img"			][ "tmp_name"	] ;
			$arResult[ $keys . "_img_name"		] = $_FILES[ $keys . "_img"			][ "name"		] ;
			$arResult[ $keys . "_img_size"		] = $_FILES[ $keys . "_img"			][ "size"		] ;
			$arResult[ $keys . "_img_type"		] = $_FILES[ $keys . "_img"			][ "type"		] ;
	                                                                      
			$arParam[ $keys 					] = $arResult[ $keys				] ;
			$arParam[ $keys . "_org"			] = $arResult[ $keys . "_org"		] ;
			$arParam[ $keys . "_org_name"		] = $arResult[ $keys . "_org_name"	] ;
			$arParam[ $keys . "_tmp"			] = $arResult[ $keys . "_tmp"		] ;
	                                                
			$arParam[ $keys . "_img"			] = $arResult[ $keys . "_img"		] ;
			$arParam[ $keys . "_img_name"		] = $arResult[ $keys . "_img_name"	] ;
			$arParam[ $keys . "_img_size"		] = $arResult[ $keys . "_img_size"	] ;
			$arParam[ $keys . "_img_type"		] = $arResult[ $keys . "_img_type"	] ;
		}
	
		if ( empty( $_POST[ "del_column" ] ) == true )
			$_POST[ "del_column" ] = -1 ;
	
		if ( empty( $_POST[ "del_photoid" ] ) == true )
			$_POST[ "del_photoid" ] = -1 ;
	
		$arResult[ "del_column"		] =	$_POST[ "del_column"		] ;
		$arResult[ "del_photoid"	] = $_POST[ "del_photoid"		] ;
		$arParam[ "del_column"		] =	$arResult[ "del_column"		] ;
		$arParam[ "del_photoid"		] = $arResult[ "del_photoid"	] ;
	
		return $arResult ;
	}

	// 画像ファイルが登録されているかどうかをチェックする
	function issetImage( $arParam )
	{
		$result = false ;
		
		$alias		= $this -> alias ;

		$arImages = $this -> images ;
		foreach( $arImages as $name )
		{
			$key = $alias . "_" . $name . "_org" ;
			if ( $arParam[ $key ] != -1 )
				$result = true ;
		}
		
		return $result ;
	}

	// 内部パラメータの作成
	function makeParam( &$arParam )
	{
		$alias		= $this -> alias ;
		$fields		= $this -> fields ;
		foreach( $fields as $name )
		{
			global	${ $alias . "_" . $name } ;
			$arParam[ $alias . "_" . $name ] = ${ $alias . "_" . $name } ;
		}
		
		$arImages	= $this -> images ;
		$arResult	= $this -> initImageParam( $arImages , $arParam ) ;
		$keys = array_keys( $arResult ) ;
		foreach( $arResult as $keys => $values )
		{
			${ $keys } = $values ;
			$arParam[ $keys ] = ${ $keys } ;
		}
	}

	//
	// 各クラスで実装する為、基本はエラーを返す
	//
	function	checkData( $mode , $func , &$arParam )
	{
		$error = "・データベースに異常があります。\n" ;
		
		return $error ;
	}

	function	checkTimestamp( $value )
	{
		// 検索できる文字は 'YYYY-MM-DD HH:II:SS"形式
		$data = $value ;
		
		$data = preg_replace( "/[0-9]/u" , "9" , $data ) ;

		if (
			$data == "9999-99-99 99:99:99" ||
			$data == "9999-99-99" ||
			$data == "99:99:99"
		)
		{
			$value = sprintf( "'%s'" , $value ) ;
		}
		return $value ;
	}

	function	debug( $data , $color = 0 )
	{
		printf( "<!-- \n" ) ;
		if ( $color != 0 )
			printf( "<font color=white>\n" ) ;
		printf( "<pre><code>\n" ) ;
		
		if ( is_array( $data ) == TRUE )
			print_r( $data ) ;
		else
			printf( "data : %s\n" , $data ) ;
		
		printf( "</code></pre>\n" ) ;
	
		if ( $color != 0 )
			printf( "</font>\n" ) ;
		printf( " --> \n" ) ;
	}
}

// DBエンジンの指定により読み込まれるクラスを変更する
if ( defined( "DEF_DATABASE_ENGINE" ) != true )
	define( "DEF_DATABASE_ENGINE" , "pgsql" ) ;

switch ( DEF_DATABASE_ENGINE )
{
case	"pgsql" :
	require_once( 'class/db_pgsql.class.php' ) ;
	class DB_Common extends DB_PostgreSQL {}
	break ;

case	"mysql" :
	require_once( 'class/db_mysql.class.php' ) ;
	class DB_Common extends DB_MySQL {}
	break ;
	
case	"oracle" :
	require_once( 'class/db_oci.class.php' ) ;
	class DB_Common extends DB_Oci {}
	break ;
}

?>