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

define( "DEF_DB_RESOURCE"				,	"pgsql link"	) ;

class DB_PostgreSQL	extends	DB_CommonBase
{
	function	connectDatabase( $dbname = "" , $user = "" , $passwd = "" , $host = "" , $port = "" )
	{
		if ( is_resource( $dbname ) == true )
			return $this -> conn ;

		if ( $dbname == "" || $dbname == -1 )
			$dbname = DB_NAME ;
	
		if ( $user == "" )
			$user = DB_USER ;
	
		if ( $passwd == "" )
			$passwd = DB_PASSWD ;
	
		if ( $host == "" && defined( "DB_HOST" ) == true )
			$host = DB_HOST ;
	
		if ( $port == "" && defined( "DB_PORT" ) == true )
			$port = DB_PORT ;
	
		$dbstr = "" ;
		if ( $host != "" )
			$dbstr = sprintf( "host=%s " , $host ) ;
	
		if ( $port != "" )
			$dbstr .= sprintf( "port=%s " , $port ) ;

		$dbstr .= sprintf( "dbname=%s user=%s password=%s" , $dbname , $user , $passwd ) ;
		$this -> conn = pg_connect( $dbstr , PGSQL_CONNECT_FORCE_NEW ) ;
		if ( $this -> conn )
		{
			$client = "" ;
			switch ( DEF_INTERNAL_ENCODE )
			{
			case	"sjis-win" :
				$client = "sjis" ;
				break ;
			}
		
			if ( $client != "" )
				pg_set_client_encoding( $this -> conn , $client ) ;
				
			$this -> dbname		= $dbname ;
			$this -> dbuser		= $user ;
			$this -> dbpasswd	= $passwd ;
			$this -> dbhost		= $host ;
			$this -> dbport		= $port ;
		}
		return $this -> conn ;
	}
	
	// Disconnect DataBase
	function	disconnectDatabase()
	{
		$result = false ;

		if ( is_resource( $this -> conn ) == true && $this -> bChild == false )
			$result = pg_Close( $this -> conn ) ;
		
		if ( $this -> bChild == true )
			$this -> bChild = false ;
		$this -> conn = -1 ;
		
		return $result ;
	}

	// Execute SQL
	function	executeSQL( $sql )
	{
		$result = false ;
		
		if ( is_resource( $this -> conn ) == true )
		{
			// 日付フォーマットの変換
			$sql = $this -> mb2sb( $sql ) ;
			$this -> record = pg_Exec( $this -> conn  , $sql ) ;
			$result = $this -> record ;
		}
		else
		{
			$result = false ;
		}
		
		return $result ;
	}

	// Exists Table
	function	tableExists( $tablename )
	{
		$result = false ;
	
		if ( is_resource( $this -> conn ) == true )
		{
			$sql = sprintf( "SELECT * FROM pg_tables WHERE tablename = '%s' " , $tablename ) ;
			$record = $this -> executeSQL( $sql ) ;
			if ( $record )
			{
				if ( DB_PostgreSQL::getDataCount( $record ) > 0 )
					$result = true ;
			
				$this -> closeRecord( $record ) ;
			}
		}
	
		return $result ;
	}

	// ID の取得
	function getID( $index = 0 )
	{
		$id = -1 ;
		
		if ( $this -> isOpen() == true )
		{
			if ( is_array( $this -> arData ) == true )
			{
				$alias		= $this -> alias ;
				$primarykey	= $this -> primarykey ;
				$keyname	= sprintf( "%s_%s" , $alias , $primarykey ) ;
				
				if ( isset( $this -> arData[ $index ][ $keyname ] ) == true )
				{
					$id = $this -> arData[ $index ][ $keyname ] ;
				}
			}
		}
		
		return $id ;
	}

	// 指定されたIDのデータを1件だけ取得する。
	function getAt( $id )
	{
		$arWhere = array() ;
		$arWhere[ $this -> primarykey ] = $id ;
		$arWhere[ "order"		] = sprintf( "%s.update_date DESC" , $this -> alias ) ;

		$arResult = $this -> getData( $arWhere ) ;
		if ( count( $arResult ) > 0 )
			$arResult = $arResult[ 0 ] ;

		return $arResult ;
	}

	// Get Fields on Table
	function	getFieldsOnTable( $tablename )
	{
		$arFields = array() ;
	
		if ( $this -> isOpen() == true )
		{
			$sql  = sprintf( "SELECT attname , format_type(atttypid,atttypmod) as typename FROM pg_class " ) ;
			$sql .= sprintf( "INNER JOIN pg_attribute ON pg_attribute.attrelid = pg_class.oid " ) ;
			$sql .= sprintf( "WHERE pg_class.relname = '%s' " , $tablename ) ; 
			$sql .= sprintf( "AND pg_attribute.attnum > 0 " ) ;
			$sql .= sprintf( "AND pg_attribute.attisdropped = 'f' " ) ;
			$sql .= sprintf( "AND pg_class.relkind = 'r' " ) ;
			$sql .= sprintf( "ORDER BY attnum " ) ;
			$record = $this -> executeSQL( $sql ) ;
			if ( $record )
			{
				$cnt = DB_PostgreSQL::getDataCount( $record ) ;
				for ( $i = 0 ; $i < $cnt ; $i ++ )
				{
					$arResult	= $this -> getValues( $record , $i ) ;
					$typename	= $arResult[ "typename" ] ;
					$attname	= $arResult[ "attname" ] ;
					
					$format = "" ;
					switch ( $typename )
					{
					case	"integer" :
					case	"smallint" :
						$format = "%d" ;
						break ;
					case	"real" :
					case	"double precision" :
						$format = "%f" ;
						break ;
					case	"text" :
						$format = "'%s'" ;
						break ;
					case	"date" :
					case	"timestamp without time zone" :
					case	"timestamp with time zone" :
						$format = "%s" ;
						break ;
					default :
						if ( ( $pos = strrpos( $typename , "[]" ) ) !== false )
						{
							if ( $pos == ( strlen( $typename ) - 2 ) )
								$format = "'{%s}'" ;
						}
					}
					$arFields[] = array( "name" => $attname , "type" => $typename , "format" => $format ) ;
				}
				$this -> closeRecord( $record ) ;
			}
		}
		
		return $arFields ;
	}

	function	getFieldsnameOnTable( $arFields )
	{
		$arFieldsname = array() ;
		$cnt = count( $arFields ) ;
		for ( $i = 0 ; $i < $cnt ; $i ++ )
			$arFieldsname[] = $arFields[ $i ][ "name" ] ;
			
		return $arFieldsname ;
	}
	
	// Make Aliase Fields Name
	function	makeAliaseFields( $arFields = array() , $tablename = "" , $alias = "" )
	{
		if ( $tablename == "" )
			$tablename = $this -> tname ;

		if ( $alias == "" )
			$alias = $this -> alias ;

		$fields = "" ;
		if ( count( $arFields ) == 0 )
			$arFields = $this -> fieldsData ;
		for ( $i = 0 ; $i < count( $arFields ) ; $i ++ )
		{
			$arData = $arFields[ $i ] ;
			if ( is_array( $arData ) == true )
			{
				if ( $arData[ "type" ] != "" )
					$fieldsname = $arData[ "name" ] ;
				else
					continue ;
			}
			else
			{
				$fieldsname = $arData ;
			}
			
			if ( $fields != "" )
				$fields .= " , " ;
			
			$fields .= sprintf( "%s.%s AS %s_%s " , $alias , $fieldsname , $alias , $fieldsname ) ;
		}
		return $fields ;
	}

	// 最終更新IDの取得
	function getLastInsertedID()
	{
		$id = -1 ;

		$tname		= $this -> tname ;
		$alias		= $this -> alias ;
		$primarykey	= $this -> primarykey ;
		$keyname	= sprintf( "%s_%s" , $alias , $primarykey ) ;

		// 直前のシーケンスID取得
		$sql = sprintf( "SELECT CURRVAL( '%s_%s_seq' ) " , $tname , $primarykey ) ;
		$record = $this -> executeSQL( $sql ) ;
		if ( $record )
		{
			$id = $this -> getValue( $record , "currval" ) ;
			$this -> closeRecord( $record ) ;
		}
		return $id ;
	}

	// Close and Free Memory
	function	closeRecord( $record )
	{
		$result = false ;
		if ( $record )
			$result = pg_FreeResult( $record ) ;
		
		return $result ;
	}

	// Get Data Count
	function	getDataCount( $record )
	{
		$result = 0 ;
		if ( $record )
			$result = pg_NumRows( $record ) ;

		return $result ;
	}

	// データの取得
	function	getData( $sql )
	{
		$this -> arData		= array() ;

		$arData = array() ;
		
		if ( $this -> isOpen() == true )
		{
			$record = $this -> executeSQL( $sql ) ;
			if ( $record )
			{
				$cnt = DB_PostgreSQL::getDataCount( $record ) ;
				for ( $i = 0 ; $i < $cnt ; $i ++ )
				{
					$arResult = $this -> getValues( $record , $i ) ;
					
					$arImages = $this -> images ;
					foreach( $arImages as $images )
					{
						$id = $this -> alias . "_" . $images ;
						if ( isset( $arResult[ $id ] ) )
						{
							$arResult[ $id . "_org" ] = $arResult[ $id ] ;
		
							// テンポラリ画像ファイルIDを初期化
							$arResult[ $id . "_tmp" ] = -1 ;
							$arResult[ $id . "_img" ] = "" ;
						}
					}
					$arData[] = $arResult ;
				}
			
				$this -> closeRecord( $record ) ;
			}
		}
		
		$this -> arData		= $arData ;
		
		return $arData ;
	}

	function	getCount( $arParam , $page = -1 , $per_page = -1 )
	{
		if ( $per_page == -1 )
			$per_page = $this -> per_page ;
	
		$this -> arData = array() ;
		$cnt = 0 ;

		$arData = array() ;
		if ( $this -> isOpen() == true )
		{
			$fields  = sprintf( "count( %s.%s ) as count " , $this -> alias , $this -> primarykey ) ;

			$arParam[ "order" ] = "" ;
			$sql = $this -> makeSQL( $arParam , $fields , $page , $per_page ) ;
			$arData = DB_PostgreSQL::getData( $sql ) ;

			if ( isset( $arData[ 0 ][ "count" ] ) == true )
				$cnt = $arData[ 0 ][ "count" ] ;
		}

		return $cnt ;
	}

	// クエリー結果の指定行の指定フィールド値を返す
	function	getValue( $record , $name , $pos = 0 )
	{
		$result = "" ;
		if ( $record )
			$result = pg_Result( $record , $pos , $name ) ;

		return $result ;
	}

	// クエリー結果の指定行を配列として返す
	function	getValues( $record , $pos = 0 )
	{
		$result = array() ;
		if ( $record )
			$result = pg_fetch_array( $record , $pos , PGSQL_ASSOC ) ;

		return $result ;
	}

	// クエリーを実行し結果を配列として返す（１行目の結果のみ）
	function	getValueAll( $sql )
	{
		$arResult = array() ;
	
		if ( $this -> isOpen() == true )
		{
			// クエリー実行
			$record = $this -> executeSQL( $sql ) ;
			if ( $record )
			{
				// クエリー結果を配列として取得（１行目のみ）
				if ( DB_PostgreSQL::getDataCount( $record ) > 0 )
				{
					$arResult = $this -> getValues( $record , 0 ) ;
				}
				else
				{
	//				printf( "SQL = [ %s ]<br>" , HTMLencode( $sql ) ) ;
				}
				$this -> closeRecord( $record ) ;
			}
		}
	
		return $arResult ;
	}
	
	//
	// 新規データの初期化
	//
	function	initData( &$arParam )
	{
		$alias		= $this -> alias ;
		$primarykey	= $this -> primarykey ;
		$keyname	= sprintf( "%s_%s" , $alias , $primarykey ) ;
		
		$fields		= $this -> fieldsData ;
		foreach( $fields as $values )
		{
			$name = $alias . "_" . $values[ "name" ] ;
			$type = $values[ "type" ] ;
			switch ( $type )
			{
			case	"integer" :
			case	"smallint" :
				$arParam[ $name ] = 0 ;
				break ;
			case	"integer[]" :
			case	"smallint[]" :
				$arParam[ $name ] = "'{0}'" ;
				break ;
			case	"real" :
			case	"double precision" :
				$arParam[ $name ] = 0.0 ;
				break ;
			case	"real[]" :
			case	"double precision[]" :
				$arParam[ $name ] = "'{0.0}'" ;
				break ;
			case	"text" :
				$arParam[ $name ] = "" ;
				break ;
			case	"text[]" :
				$arParam[ $name ] = "'{\"\"}'" ;
				break ;
			case	"date" :
				$arParam[ $name ] = sprintf( "%s" , "0001-01-01" ) ;
				break ;
			case	"date[]" :
				$arParam[ $name ] = sprintf( "'{\"%s\"}'" , "0001-01-01" ) ;
				break ;
			case	"timestamp without time zone" :
			case	"timestamp with time zone" :
				$arParam[ $name ] = sprintf( "%s" , DEF_DATE_MIN ) ;
				break ;
			case	"timestamp without time zone[]" :
			case	"timestamp with time zone[]" :
				$arParam[ $name ] = sprintf( "'{\"%s\"}'" , DEF_DATE_MIN ) ;
				break ;
			default :
				$arParam[ $name ] = "" ;
			}
		}

		// 写真データ用のパラメータを初期化する
		$arImages	= $this -> images ;
		foreach( $arImages as $name )
		{
			$key = $alias . "_" . $name ;
			$arParam[ $key				] = "" ;
			$arParam[ $key . "_name"	] = "" ;
			$arParam[ $key . "_size"	] = "" ;
			$arParam[ $key . "_type"	] = "" ;
			$arParam[ $key . "_org"		] = -1 ;
			$arParam[ $key . "_tmp"		] = -1 ;
		}

		$arParam[ $keyname					] = -1 ;
		$arParam[ $alias . "_create_date"	] = "LOCALTIMESTAMP(0)" ;
		$arParam[ $alias . "_update_date"	] = "LOCALTIMESTAMP(0)" ;
	}

	
	//
	// 新規データ登録
	//
	function insertData( &$arParam , $kind = -1 , $caption = "" , &$error = "" )
	{
		$tname		= $this -> tname ;
		$alias		= $this -> alias ;
		$primarykey	= $this -> primarykey ;
		$keyname	= sprintf( "%s_%s" , $alias , $primarykey ) ;

		$arParam[ $keyname ] = -1 ;
		$result = false ;
		if ( $this -> isOpen() )
		{
			// checkDataの為のパスワードの復号化
			if ( empty( $arParam[ $alias . "_passwd" ] ) == false )
			{
				$arParam[ $alias . "_passwd" ] = $this -> decrypt( $arParam[ $alias . "_passwd" ] ) ;
				if ( isset( $arParam[ $alias . "_clear_passwd" ] ) == true )
					 $arParam[ $alias . "_clear_passwd" ] = $arParam[ $alias . "_passwd" ] ;
			}
			
			$error = "" ;
			if ( $this -> skip_check == false )
				$error = $this -> checkData( "append" , "database" , $arParam ) ;
				
			if ( $error == "" )
			{
				$arParam[ $alias . "_status"		] = 1 ;
				$arParam[ $alias . "_create_date"	] = "LOCALTIMESTAMP(0)" ;
				$arParam[ $alias . "_update_date"	] = "LOCALTIMESTAMP(0)" ;
				
				$arImages = $this -> images ;
				foreach( $arImages as $name )
					$arParam[ $alias . "_" . $name ] = $arParam[ $alias . "_" . $name . "_tmp" ] ;
				
				// データ挿入
				$fields = "" ;
				$values = "" ;
				foreach( $this -> fieldsData as $arFields )
				{
					if ( is_array( $arFields ) && $arFields[ "name" ] != $primarykey )
					{
						$name	= $arFields[ "name"		] ;
						$type	= $arFields[ "type"		] ;
						$format	= $arFields[ "format"	] ;
						
						if ( $type != "" && isset( $arParam[ $alias . "_" . $name ] ) )
						{
							if ( $fields != "" )
								$fields .= " , " ;
							$fields .= sprintf( "%s" , $name ) ;

							if ( $values != "" )
								$values .= " , " ;
							if ( $type == "text" )
								$values .= sprintf( $format , $this -> mb_addslashes( $arParam[ $alias . "_" . $name ] ) ) ;
							else
								$values .= sprintf( $format , $this -> checkTimestamp( $arParam[ $alias . "_" . $name ] ) ) ;
						}
					}
				}
				$sql  = sprintf( "INSERT INTO %s ( %s ) VALUES ( %s ) " , $this -> tname , $fields , $values ) ;

				$record = $this -> executeSQL( $sql ) ;
				if ( $record )
				{
					$this -> closeRecord( $record ) ;
					
					$arParam[ $keyname ] = $this -> getLastInsertedID() ;
					if ( $arParam[ $keyname ] != -1 )
						$result = true ;

					// TOPICSの指定がある場合は、自動に作成
					if ( $kind != -1 )
					{
						$edit_flg = DEF_EDITSTATUS_OPENED ;
						if ( isset( $arParam[ $alias . "_edit_flg" ] ) )
							$edit_flg = $arParam[ $alias . "_edit_flg" ] ;
						$start_date = "LOCALTIMESTAMP(0)" ;
						if ( isset( $arParam[ $alias . "_start_date" ] ) )
							$start_date = $arParam[ $alias . "_start_date" ] ;

						$subject = sprintf( "【新規】%sが追加されました" , $caption ) ;
						$obTopics = new PARTS_Topics( $this -> conn ) ;
						$obTopics -> autoInsert( $subject , $kind , $start_date , $edit_flg , $arParam[ $keyname ] , EVENT_SORT_NORMAL) ;
					}
				}
			}
		}

		return $result ;
	}
	
	//
	// 既存データ更新
	//
	function updateData( $arParam , $topics_kind = -1 , $topics_caption = "" , $arWhere = array() , &$error = "" )
	{
		$alias		= $this -> alias ;
		$primarykey	= $this -> primarykey ;
		$keyname	= sprintf( "%s_%s" , $alias , $primarykey ) ;

		// ローカル変数へ展開する
		$keys = array_keys( $arParam ) ;
		foreach( $arWhere as $keys => $values )
			${ $keys } = $values ;

		$result = false ;
		if ( $this -> isOpen() )
		{
			// checkDataの為のパスワードの復号化
			if ( empty( $arParam[ $alias . "_passwd" ] ) == false )
			{
				$arParam[ $alias . "_passwd" ] = $this -> decrypt( $arParam[ $alias . "_passwd" ] ) ;

				if ( empty( $arParam[ $alias . "_clear_passwd" ] ) == false )
					 $arParam[ $alias . "_clear_passwd" ] = $arParam[ $alias . "_passwd" ] ;
			}
	
			$error = "" ;
			if ( $this -> skip_check == false )
				$error = $this -> checkData( "update" , "database" , $arParam ) ;

			if ( $error == "" )
			{
				$arParam[ $alias . "_status"		] = 1 ;
				$arParam[ $alias . "_update_date"	] = "LOCALTIMESTAMP(0)" ;
	
				if ( empty( $arParam[ $alias . "_create_date"	] ) == false )
					$arParam[ $alias . "_create_date"	] = sprintf( "'%s'" , $arParam[ $alias . "_create_date"	] ) ;

				$arImages = $this -> images ;
				foreach( $arImages as $name )
				{
					if ( $arParam[ $alias . "_" . $name . "_tmp" ] != -1 )
						$arParam[ $alias . "_" . $name ] = $arParam[ $alias . "_" . $name . "_tmp" ] ;
					else
						$arParam[ $alias . "_" . $name ] = $arParam[ $alias . "_" . $name . "_org" ] ;
				}
				// データ更新
				$sql  = sprintf( "UPDATE %s AS %s SET " , $this -> tname , $alias ) ;

				$values = "" ;
				foreach( $this -> fieldsData as $arFields )
				{
					if ( is_array( $arFields ) && $arFields[ "name" ] != $primarykey && $arFields[ "name" ] != "create_date" )
					{
						$name	= $arFields[ "name"		] ;
						$type	= $arFields[ "type"		] ;
						$format	= $arFields[ "format"	] ;
						
						if ( $type != "" && isset( $arParam[ $alias . "_" . $name ] ) )
						{
							$format = sprintf( "%s = %s" , $name , $format ) ;
							if ( $values != "" )
								$values .= " , " ;
								
							if ( $type == "text" )
								$values .= sprintf( $format , $this -> mb_addslashes( $arParam[ $alias . "_" . $name ] ) ) ;
							else
								$values .= sprintf( $format , $this -> checkTimestamp( $arParam[ $alias . "_" . $name ] ) ) ;
						}
					}
				}

				$sql .= $values ;
				$sql .= sprintf( " " ) ;

				if ( empty( $arWhere[ "from" ] ) == false )
					$sql .= sprintf( "FROM %s " , $arWhere[ "from" ] ) ;

				$sql .= sprintf( "WHERE %s.status = 1 " , $alias ) ;
				if ( count( $arWhere ) > 0 )
				{
					foreach( $this -> fieldsData as $fields )
					{
						if ( empty( $fields[ "type" ] ) == false && isset( $arWhere[ $fields[ "name" ] ] ) == true )
						{
							$format = sprintf( "AND %s.%%s = %s " , $alias , $fields[ "format" ] ) ;
							switch( $fields[ "type" ] )
							{
							case 'text' :
								$sql .= sprintf( $format ,	$fields[ "name" ] ,
															$this -> mb_addslashes( $arWhere[ $fields[ "name" ] ] ) ) ;
								break ;
							default :
								$sql .= sprintf( $format ,	$fields[ "name" ] ,
															$arWhere[ $fields[ "name" ] ] ) ;
							}
						}
					}
					
					if ( empty( $arWhere[ "where" ] ) == false )
					{
						$sql .= $arWhere[ "where" ] ;
					}
				}
				else
				{
					$sql .= sprintf( "AND %s.%s = %d " , $alias , $primarykey , $arParam[ $keyname ] ) ;
				}

				$record = $this -> executeSQL( $sql ) ;
				if ( $record )
				{
					$this -> closeRecord( $record ) ;
					$result = true ;
	
					// TOPICSの指定がある場合は、自動に作成
					if ( $topics_kind != -1 )
					{
						$edit_flg = DEF_EDITSTATUS_OPENED ;
						if ( isset( $arParam[ $alias . "_edit_flg" ] ) )
							$edit_flg = $arParam[ $alias . "_edit_flg" ] ;
						$start_date = "LOCALTIMESTAMP(0)" ;
						if ( isset( $arParam[ $alias . "_start_date" ] ) )
							$start_date = $arParam[ $alias . "_start_date" ] ;
						
						$subject = sprintf( "【更新】%sの内容が更新されました" , $topics_caption ) ;
						$obTopics = new PARTS_Topics( $this -> conn ) ;
						$obTopics -> autoInsert( $subject , $topics_kind , $start_date , $edit_flg , $arParam[ $keyname ] , EVENT_SORT_NORMAL ) ;
					}
					
					// 既存の画像ファイルがある場合は削除をする
					$arImages = $this -> images ;
					foreach( $arImages as $name )
					{
						if ( $arParam[ $alias . "_" . $name . "_tmp" ] != -1 )
						{
							if ( $arParam[ $alias . "_" . $name . "_org" ] != -1 )
							{
								$obPhoto = new PARTS_Photo( $this -> conn ) ;
								$obPhoto -> deleteData( $arParam[ $alias . "_" . $name . "_org" ] ) ;
							}
						}
					}
				}
			}
		}
		
		return $result ;
	}
	
	//
	// 既存データ削除
	//
	function deleteData( $arParam , $topics_kind = -1 , $topics_caption = "" , $arWhere = array() )
	{
		$alias		= $this -> alias ;
		$primarykey	= $this -> primarykey ;
		$keyname	= sprintf( "%s_%s" , $alias , $primarykey ) ;

		$result = false ;
		if ( $this -> isOpen() )
		{
			// データ更新
			$sql  = sprintf( "UPDATE %s AS %s SET " , $this -> tname , $alias ) ;
			$sql .= sprintf( "status = -1 , " ) ;
			$sql .= sprintf( "update_date = LOCALTIMESTAMP(0) " ) ;

			$sql .= sprintf( "WHERE %s.status = 1 " , $alias ) ;
			if ( count( $arWhere ) > 0 )
			{
				foreach( $this -> fieldsData as $fields )
				{
					if ( empty( $fields[ "type" ] ) == false && empty( $arWhere[ $fields[ "name" ] ] ) == false )
					{
						$format = sprintf( "AND %s.%%s = %s " , $alias , $fields[ "format" ] ) ;
						switch( $fields[ "type" ] )
						{
						case 'text' :
							$sql .= sprintf( $format ,	$fields[ "name" ] ,
														$this -> mb_addslashes( $arWhere[ $fields[ "name" ] ] ) ) ;
							break ;
						default :
							$sql .= sprintf( $format ,	$fields[ "name" ] ,
														$arWhere[ $fields[ "name" ] ] ) ;
						}
					}
				}
				
				if ( empty( $arWhere[ "where" ] ) == false )
				{
					$sql .= $arWhere[ "where" ] ;
				}
			}
			else
			{
				$sql .= sprintf( "AND %s.%s = %d " , $alias , $primarykey , $arParam[ $keyname ] ) ;
			}

			$record = $this -> executeSQL( $sql ) ;
			if ( $record )
			{
				$this -> closeRecord( $record ) ;
				$result = true ;

				// TOPICSの指定がある場合は、自動に作成
				if ( $topics_kind != -1 )
				{
					$edit_flg = DEF_EDITSTATUS_OPENED ;
					if ( isset( $arParam[ $alias . "_edit_flg" ] ) )
						$edit_flg = $arParam[ $alias . "_edit_flg" ] ;
					$start_date = "LOCALTIMESTAMP(0)" ;
					if ( isset( $arParam[ $alias . "_start_date" ] ) )
						$start_date = $arParam[ $alias . "_start_date" ] ;

					$subject = sprintf( "【削除】%sが削除されました" , $topics_caption ) ;
					$obTopics = new PARTS_Topics( $this -> conn ) ;
					$obTopics -> autoInsert( $subject , $topics_kind , $start_date , $edit_flg , $arParam[ $keyname ] , EVENT_SORT_NORMAL ) ;
				}
				
				// 既存の画像ファイルがある場合は削除をする
				$arImages = $this -> images ;
				foreach( $arImages as $name )
				{
					if ( $arParam[ $alias . "_" . $name . "_org" ] != -1 )
					{
						$obPhoto = new PARTS_Photo( $this -> conn ) ;
						$obPhoto -> deleteData( $arParam[ $alias . "_" . $name . "_org" ] ) ;
					}
				}
			}
		}
		
		return $result ;
	}
	
	// DBからの完全消去をする
	function	destroyData( $id , $arWhere = array() )
	{
		$alias		= $this -> alias ;
		$primarykey	= $this -> primarykey ;
		$keyname	= sprintf( "%s_%s" , $alias , $primarykey ) ;

		if ( $this -> isOpen() )
		{
			if ( $id != -1 || count( $arWhere ) > 0 )
			{
				$sql  = sprintf( "DELETE FROM %s %s " , $this -> tname , $alias ) ;
				$sql .= sprintf( "WHERE %s.status != 0 " , $alias ) ;
				if ( count( $arWhere ) > 0 )
				{
					foreach( $this -> fieldsData as $fields )
					{
						if ( empty( $fields[ "type" ] ) == false && empty( $arWhere[ $fields[ "name" ] ] ) == false )
						{
							$format = sprintf( "AND %s.%%s = %s " , $alias , $fields[ "format" ] ) ;
							switch( $fields[ "type" ] )
							{
							case 'text' :
								$sql .= sprintf( $format ,	$fields[ "name" ] ,
															$this -> mb_addslashes( $arWhere[ $fields[ "name" ] ] ) ) ;
								break ;
							default :
								$sql .= sprintf( $format ,	$fields[ "name" ] ,
															$arWhere[ $fields[ "name" ] ] ) ;
							}
						}
					}
					
					if ( empty( $arWhere[ "where" ] ) == false )
					{
						$sql .= $arWhere[ "where" ] ;
					}
				}
				else
				{
					$sql .= sprintf( "AND %s.%s = %d " , $alias , $primarykey , $id ) ;
				}

				$record = $this -> executeSQL( $sql ) ;
				if ( $record )
					$this -> closeRecord( $record ) ;
			}
		}
	}

	// 現在の接続数を表示する
	function	checkConnection()
	{
		if ( $this -> isOpen() == true )
		{
			$sql = sprintf( "SELECT procpid || ' (' || usename || ' using ' || datname || ')' FROM pg_stat_activity ORDER BY procpid , usename , datname " ) ;
			$record = $this -> executeSQL( $sql ) ;
			if ( $record )
			{
				$cnt = $this -> getDataCount( $record ) ;
				if ( $cnt > 0 )
				{
					printf( "<pre><code>\n" ) ;
	
					for ( $i = 0 ; $i < $cnt ; $i ++ )
					{
						$arData = $this -> getValues( $record , $i ) ;
						print_r( $arData ) ;
//						printf( "data : %s\n" , $data ) ;
					}
	
					printf( "</code></pre>\n" ) ;
				}
			}
		}
	}
}
?>
