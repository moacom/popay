<?php
define('G5_MYSQL_ROOT', 'mpoint');//$mysql_db
define('G5_MYSQL_DB', $mysql_db);
define('G5_DISPLAY_SQL_ERROR', TRUE);
define('G5_PATH', '/home');
$g5 = $g4;
$g5['root_table'] = "g4_write_i01_store_mhm";
$g5['root_bo_table'] = "i01_store_mhm";

function select_db_($db = G5_MYSQL_ROOT)
{
	global $connect_db, $select_db;
	if($connect_db) $select_db = sql_select_db($db, $connect_db);
}

function sql_query_($sql, $db=G5_MYSQL_ROOT, $error=G5_DISPLAY_SQL_ERROR)
{
    global $connect_db;

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    $select_db = sql_select_db($db, $connect_db);	
	//echo "sds";
    //if ($error){
    //    $result = @mysql_query($sql, $connect_db) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['PHP_SELF']}");
	//}else{
		//echo "3423";
        $result = @mysql_query($sql, $connect_db);
		if(strpos($sql,'insert')!==false){
			//echo "fdfs";
			$result = mysql_insert_id();
		}
	//}
    $select_db = sql_select_db(G5_MYSQL_DB, $connect_db);  
    return $result;
} //function sql_query() 기존파일 있음

function sql_fetch_($sql, $db=G5_MYSQL_ROOT, $error=G5_DISPLAY_SQL_ERROR)
{
    global $connect_db;
    $select_db = sql_select_db($db, $connect_db);	
    $list = sql_fetch($sql, $error);
    $select_db = sql_select_db(G5_MYSQL_DB, $connect_db);
    return $list;
} //function sql_fetch() 기존파일 있음

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array_($result, $db=G5_MYSQL_ROOT)
{
    global $connect_db;
    $select_db = sql_select_db($db, $connect_db);	
    $row = @mysql_fetch_assoc($result);
    $select_db = sql_select_db(G5_MYSQL_DB, $connect_db);    
    return $row;
}




// PHPMyAdmin 참고
function get_table_define_($table, $crlf="\n", $db)
{
    global $g5;

    // For MySQL < 3.23.20
    $schema_create .= 'CREATE TABLE ' . $table . ' (' . $crlf;

    $sql = 'SHOW FIELDS FROM ' . $table;
    $result = sql_query_($sql, $db);
    while ($row = sql_fetch_array_($result, $db))
    {
        $schema_create .= '    ' . $row['Field'] . ' ' . $row['Type'];
        if (isset($row['Default']) && $row['Default'] != '')
        {
            $schema_create .= ' DEFAULT \'' . $row['Default'] . '\'';
        }
        if ($row['Null'] != 'YES')
        {
            $schema_create .= ' NOT NULL';
        }
        if ($row['Extra'] != '')
        {
            $schema_create .= ' ' . $row['Extra'];
        }
        $schema_create     .= ',' . $crlf;
    } // end while
    sql_free_result($result);

    $schema_create = preg_replace('/,' . $crlf . '$/', '', $schema_create);

    $sql = 'SHOW KEYS FROM ' . $table;
    $result = sql_query_($sql, $db);
    while ($row = sql_fetch_array_($result, $db))
    {
        $kname    = $row['Key_name'];
        $comment  = (isset($row['Comment'])) ? $row['Comment'] : '';
        $sub_part = (isset($row['Sub_part'])) ? $row['Sub_part'] : '';

        if ($kname != 'PRIMARY' && $row['Non_unique'] == 0) {
            $kname = "UNIQUE|$kname";
        }
        if ($comment == 'FULLTEXT') {
            $kname = 'FULLTEXT|$kname';
        }
        if (!isset($index[$kname])) {
            $index[$kname] = array();
        }
        if ($sub_part > 1) {
            $index[$kname][] = $row['Column_name'] . '(' . $sub_part . ')';
        } else {
            $index[$kname][] = $row['Column_name'];
        }
    } // end while
    sql_free_result($result);

    while (list($x, $columns) = @each($index)) {
        $schema_create     .= ',' . $crlf;
        if ($x == 'PRIMARY') {
            $schema_create .= '    PRIMARY KEY (';
        } else if (substr($x, 0, 6) == 'UNIQUE') {
            $schema_create .= '    UNIQUE ' . substr($x, 7) . ' (';
        } else if (substr($x, 0, 8) == 'FULLTEXT') {
            $schema_create .= '    FULLTEXT ' . substr($x, 9) . ' (';
        } else {
            $schema_create .= '    KEY ' . $x . ' (';
        }
        $schema_create     .= implode($columns, ', ') . ')';
    } // end while

    $schema_create .= $crlf . ') ENGINE=MyISAM DEFAULT CHARSET=utf8';

    return $schema_create;
} //function get_table_define 로컬함수가 따로 존제

function copy_table_($table, $table2, $db=G5_MYSQL_ROOT, $db2=G5_MYSQL_ROOT){
	$sql = get_table_define_($table, "\n", $db);
	$sql = str_replace($table,$table2, $sql);
	//if() //테이블유무확인
	//SHOW TABLES FROM [DB명] LIKE ‘[TABLE명]';
	//SHOW TABLES LIKE ‘[TABLE명]';
	//SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = ‘[DB명]’ AND table_name = ‘[TABLE명]';
	sql_query_($sql, $db2);
	
} function copy_table($table, $table2){ return copy_table_($table, $table2, G5_MYSQL_DB, G5_MYSQL_DB);}

function drop_table_($table, $db=G5_MYSQL_ROOT){
	$is_table = sql_fetch_(" SHOW TABLES LIKE '$table' ", $db);
	if($is_table){
		@sql_query("drop table {$table}");
	}else{
		echo "해당 DB($db)에 해당 table($table)이 없습니다";
	}
} function drop_table($table){ return drop_table_($table, G5_MYSQL_DB);}


function get_table_($table, $key, $value, $db=G5_MYSQL_ROOT){
	$data = sql_fetch_(" select * from {$table} where $key = '$value' ",  $db);
	return $data;
} function get_table($table, $key, $value){ return get_table_($table, $key, $value, G5_MYSQL_DB);}

function get_table_field_($table, $db){
	$result = sql_query_("SHOW COLUMNS FROM $table", $db);
	if (!$result) {
		echo '테이블을 찾을 수 없다';
		return false;
	}
	/*[Field] => id
    [Type] => int(7)
    [Null] =>  
    [Key] => PRI
    [Default] =>
    [Extra] => auto_increment*/
	if (mysql_num_rows($result) > 0) {
		$field = array();
		while ($row = mysql_fetch_assoc($result)) {
			$field[]=$row['Field'];
		}
		return $field;
	}	
} function get_table_field($table){ return get_table_field_($table, G5_MYSQL_DB); }

function in_table_field_($field, $table, $db=G5_MYSQL_ROOT){
	$fields = get_table_field_($table, $db);
	if (in_array($field, $fields)) { //테이블 필드에 항목이 없으면
		return true;
	}else{
		return false;
	}
}function in_table_field($field, $table){ return in_table_field_($field, $table, G5_MYSQL_DB); }

//$data = array(array('name','type','is_null','position'),array('','',''),...);
function add_table_field_($data, $table, $db=G5_MYSQL_ROOT){
	//$fields = get_table_field($table);
	foreach ($data as &$value) {
		if (!in_table_field_($value[0], $table, $db)) { //테이블 필드에 항목이 없으면
			sql_query_(" ALTER TABLE `{$table}` ADD `$value[0]` $value[1] $value[2] AFTER `$value[3]` ", $db);
		}
	}
} function add_table_field($data, $table){ return add_table_field_($data, $table, G5_MYSQL_DB); }



















// 게시판의 다음글 번호를 얻는다.
function get_next_num_($table, $db=G5_MYSQL_ROOT)
{
    // 가장 작은 번호를 얻어
    $sql = " select min(wr_num) as min_wr_num from $table ";
    $row = sql_fetch_($sql, $db);
    // 가장 작은 번호에 1을 빼서 넘겨줌
    return (int)($row['min_wr_num'] - 1);
} //function get_next_num가 따로 존재





function array2cvs($data){
	$i = 0;
	foreach($data as $key=>$value) {
		if($i != 0){ $output .= ', ';  }
		$output .= $key . "= '" . $value . "'";
		$i++;
	}
	return $output;	

}

//$data = array('wr_1'=>'aaa','wr_2'=>'bb');
function insert_($data, $table, $db=G5_MYSQL_ROOT){
    global $connect_db;
	$output = "insert into " . $table . " set ";
    $output .= array2cvs($data);
	
	//echo "실행:";
    $return_value = sql_query_($output, $db);
	//$return_id = mysql_insert_id();
	//echo $return_value;

	return $return_value;
}function insert($data, $table, $db=G5_MYSQL_DB){return insert_($data, $table, $db);}

//$data = array('wr_1'=>'aaa','wr_2'=>'bb');
function update_($data, $table, $key, $value, $db=G5_MYSQL_ROOT){
    $output = "update " . $table . " set ";
    $output .= array2cvs($data);
	$output .= "where $key = '$value' ";
	//echo $output;
    @sql_query_($output, $db);
}function update($data, $table, $db=G5_MYSQL_DB){return update_($data, $table, $db);}







//
function get_write_($bo_table, $wr_id, $db=G5_MYSQL_ROOT){
	global $g5;
	$write_table = $g5['write_prefix'] . $bo_table;
	//$write = sql_fetch_(" select * from {$write_table} where wr_id = '$wr_id' ",  $db);
	$write = get_table_($write_table, "wr_id", $wr_id, $db);
	
	//$board = get_board_extend($bo_table);
	//$view = get_view($write, $board, $board['bo_skin']);
	
	/*추가할 확장 필드*/
	return $write;
}//function get_write(){}


function insert_write_($data, $bo_table, $db=G5_MYSQL_ROOT){
	global $connect_db;
	global $g5, $member;
	
	$write_table = $g5['write_prefix'] . $bo_table;
    //if(!$data['wr_password']) $data['wr_password'] = $wr_password;
    //if(!$data['wr_name']) $data['wr_name'] = $wr_name;
	unset($data['wr_id']);
	unset($data['wr_comment']);
    if(!$data['mb_id']) $data['mb_id'] = $member['mb_id'];
    if(!$data['wr_reply']) $data['wr_reply'] = '';
	//if(!$data['wr_num']) $data['wr_num'] = get_next_num_($write_table, $db);
	$data['wr_num'] = get_next_num_($write_table, $db);
    if(!$data['wr_ip']) $data['wr_ip'] = $_SERVER['REMOTE_ADDR'];
    if(!$data['wr_datetime']) $data['wr_datetime'] = $g5['time_ymdhis'];
    if(!$data['wr_last']) $data['wr_last'] = $g5['time_ymdhis'];
	
	$data['wr_21'] = addslashes($data['wr_21']);

	//$output = "insert into " . $write_table . " set ";
	//$output .= array2cvs($data);
	//sql_query($output);
	
	$wr_id = insert_($data, $write_table, $db);
	
	//$wr_id = insert_($data, $write_table, $db);
	//echo $output;
	//return false;
	
    //$wr_id = mysql_insert_id();
    sql_query_("update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ", $db);
	sql_query_("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'", $db);
	
	
    return $wr_id;
}function insert_write($data, $bo_table, $db=G5_MYSQL_DB){return insert_write_($data, $bo_table, $db);}




function copy_write_($bo_table, $wr_id, $bo_table2, $db=G5_MYSQL_ROOT, $db2=G5_MYSQL_ROOT){
	global $g5, $db_is_root;
	
	$write_table = $g5['write_prefix'] . $bo_table;
	$write_table2 = $g5['write_prefix'] . $bo_table2;
	
    $data = get_write_($bo_table, $wr_id, $db);
    //unset($data['wr_id']);
    //unset($data['wr_num']);
    $insert_id = insert_write_($data, $bo_table2, $db2);
	
	//return $insert_id;
	
	//g4의 경우다름..(원본)
//	if($db == G5_MYSQL_ROOT){
//		$file_path1 = "";
//	}elseif(strpos($db,"g5") !==false){
//		$file_path1 = "/../../".$_SERVER['DB']."/_";
//	}elseif(strpos($db,"emoa") !==false){
//		$file_path1 = "/../../emoa/public_html_old";
//	}else{
//		//$file_path1 = "/_/".$_SERVER['DB'];
//		$file_path1 = "/../../".$_SERVER['DB']."/public_html";
//	}
//
//	if($db2 == G5_MYSQL_ROOT){
//		$file_path2 = "";
//	}elseif(strpos($db2,"g5") !==false){
//		$file_path2 = "/../../".$_SERVER['DB']."/_";
//	}elseif(strpos($db2,"emoa") !==false){
//		$file_path2 = "/../../emoa/public_html_old";
//	}else{
//		//$file_path2 = "/_/".$_SERVER['DB'];
//		$file_path2 = "/../../".$_SERVER['DB']."/public_html";
//	}
	
	//g4의 경우다름..
	if(strpos($db,"g5") !==false){
		$file_path1 = "/".$db."/_";
	}elseif(strpos($db,"emoa") !==false){
		$file_path1 = "/emoa/public_html_old";
	}elseif($db){
		//$file_path1 = "/_/".$_SERVER['DB'];
		$file_path1 = "/".$db."/public_html";
	}

	if(strpos($db2,"g5") !==false){
		$file_path2 = "/".$db2."/_";
	}elseif(strpos($db2,"emoa") !==false){
		$file_path2 = "/emoa/public_html_old";
	}elseif($db2){
		//$file_path2 = "/_/".$_SERVER['DB'];
		$file_path2 = "/".$db2."/public_html";
	}
	

	$dir1 = G5_PATH.$file_path1."/data/file/$bo_table"; // 원본 디렉토리
	$dir2 = G5_PATH.$file_path2."/data/file/$bo_table2"; // 복사본 디렉토리
	
	
	//$dir1 = './data/file/i01_store_mcard';
	//$dir2 = './../../mpoint/public_html/data/file/i01_store_testg4';
	//echo "SERVER = ".$_SERVER['DB']."<br/>db = ".$db."<br/>dir1 = ".$dir1."<br/>db2 = ".$db2."<br/>dir2 = ".$dir2."<br/";
	
	@mkdir($dir2, 0707);
	@chmod($dir2, 0707);
	$file = $dir2 . "/index.php";// 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
	$f = @fopen($file, "w");
	@fwrite($f, "");
	@fclose($f);
	@chmod($file, 0606);

	$save = array();
	$save_count_write = 0;
	$save_count_comment = 0;
	$cnt = 0;

	$count_write = 0;
	$count_comment = 0;
	
	//파일복사모듈 넣기...
	if (!$data[wr_is_comment]) // 코멘트가 아니라면
	{
		$save_parent = $insert_id;
		$sql = " select * from $g5[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
		$result = sql_query_($sql, $db);
		for ($k=0; $row = sql_fetch_array_($result, $db); $k++) 
		{
			if ($row[bf_file]) 
			{
				@copy("$dir1/$row[bf_file]", "$dir2/$row[bf_file]"); // 원본파일을 복사하고 퍼미션을 변경
				@chmod("$dir2/$row[bf_file]", 0606);
			}
			$row['bo_table'] = $bo_table2;
			$row['wr_id'] = $insert_id;
			$row['bf_content'] = addslashes($row['bf_content']);
			insert_($row, $g5[board_file_table], $db2);
		}
		$count_write++;
	} 
	else 
	{
		$count_comment++;
	}
	sql_query_(" update $write_table2 set wr_parent = '$save_parent' where wr_id = '$insert_id' ", $db2);
	$cnt++;
	
	
	//내가추가한것
	return $insert_id;
}function copy_write($bo_table, $wr_id, $bo_table2){ return copy_write_($bo_table, $wr_id, $bo_table2, G5_MYSQL_DB, G5_MYSQL_DB); }

function update_write_($data, $bo_table, $wr_id, $db=G5_MYSQL_ROOT){
	global $g5;
	$write_table = $g5['write_prefix'] . $bo_table;
	$output = "update " . $write_table . " set ";
	$output .= array2cvs($data);
	$output .= " where wr_id = '{$wr_id}' ";
	@sql_query_($output, $db);
}function update_write($data, $bo_table, $wr_id){ return update_write_($data, $bo_table, $wr_id, G5_MYSQL_DB); }







function get_root_by_view_($bo_table, $wr_id, $db_id, $db=G5_MYSQL_ROOT){//코드로 검색
	global $g5;
	//$data = get_table_($g5['root_table'], "ro_code", $ro_code, $db);
	
	$write_table = $g5['write_prefix'] . $bo_table;
	
	
	if($write_table==$g5['root_table'] && $db_id==G5_MYSQL_ROOT){
		$data = sql_fetch_(" select * from ".$write_table." where wr_id='$wr_id' ", $db);
	}else{
		$data = sql_fetch_(" select * from ".$g5['root_table']." where rel_db='$db_id' and rel_table='$bo_table' and rel_id = '$wr_id' ", $db);
		//echo " select * from ".$g5['root_table']." where rel_db='$db_id' and rel_table='$bo_table' and rel_id = '$wr_id' ";
		if(!$data) {
			$ro_id =  insert_root_write_($bo_table, $wr_id , $db_id , $db);
			$data = get_root_($ro_id, $db);
		}
	}
	return $data;
}function get_root_by_view($bo_table, $wr_id, $db_id, $db=G5_MYSQL_DB){ return get_root_by_view_($bo_table, $wr_id, $db_id, $db); }

function get_root_($ro_id, $db=G5_MYSQL_ROOT){
	global $g5;
	$data = get_table_($g5['root_table'], "wr_id", $ro_id, $db);
	return $data;
}function get_root($ro_id, $db=G5_MYSQL_DB){ return get_root_($ro_id, $db); }

//$data = array('wr_1'=>'aaa','wr_2'=>'bb');
function insert_root_write_($bo_table, $wr_id , $db=G5_MYSQL_DB , $db2=G5_MYSQL_ROOT){
	global $g5;
	$data = sql_fetch_(" select * from {$g5['root_table']} where rel_db='$db' and rel_table='$bo_table' and rel_id = '$wr_id' ", $db2);
	if(!$data){
		$ro_id = copy_write_($bo_table, $wr_id,$g5['root_bo_table'], $db, $db2);
		unset($data);
		$data = array('rel_table'=>$bo_table,'rel_id'=>$wr_id,'rel_db'=>$db);
		update_write_($data, $g5['root_bo_table'], $ro_id, $db2);
		unset($data);
		$data = array('wr_10'=>$ro_id);
		update_write_($data, $bo_table, $wr_id, $db);
	}else{
		$ro_id = $data[wr_id];
	}

	return $ro_id;
}















function exchange_mydas($mb_id,$po_point){
//mydas용
			//$conn=mssql_connect("210.105.192.236:1433","moacomm_user","moacomm");
			$conn=mssql_connect("db12.binsoft.co.kr:5000","moacomm_user","moacomm");
			mssql_select_db("MOACOMM");
			$query="
			  set ansi_null_dflt_on on
			  -- network protocol: TCP/IP
			  set quoted_identifier on
			  set arithabort off
			  set numeric_roundabort off
			  set ansi_warnings on
			  set ansi_padding on
			  set ansi_nulls on
			  set concat_null_yields_null on
			  set cursor_close_on_commit off
			  set implicit_transactions off
			  set language 한국어
			  set dateformat ymd
			  set datefirst 7
			  set transaction isolation level read committed
			 ";
			 mssql_query($query);   //위 쿼리는 반드시 실행시킨후 밑에 쿼리 실행해주세요. (위 쿼리는 페이지에서 1번만 호출하면 됩니다.)
//

			$mb = get_member($mb_id);
			//echo "아이디는".$mb[mb_id]."<br/>";
			$sucess_xml_cnt = 0;
			if($mb[mb_10]){
				$mb_10_point = floor($po_point / $mb[mb_10]);
						$customerid = $mb['mb_reg'];
						$value = $mb_10_point;
						if($customerid){
							if($conn){
								 $query="";
								 $xml="";
								 $xml="
								  <row>
								   <creator>System</creator>
								   <entryday>".date('Y-m-d')."</entryday>
								   <customerid>".$customerid."</customerid>
								   <value>".$value."</value>
								   <comment>모아포인트 전환</comment>
								</row>
								 ";
								 $query="EXECUTE up_ProcessCustomerPointFamilyShare N'$xml'";
								 //echo $query."<br/>";
								 $sucess_xml = mssql_query($query);
								 if($sucess_xml){
									 $sucess_xml_cnt++;
								 }
							}
						}//if($customerid && $value)
						
				for($l=1; $l<$mb[mb_10]; $l++) {
					$customerid = $mb['mb_reg']."-".$l;
					$value = $mb_10_point;
					
					if($customerid){
						if($conn){
							 $query="";
							 $xml="";
							 $xml="
							  <row>
							   <creator>System</creator>
							   <entryday>".date('Y-m-d')."</entryday>
							   <customerid>".$customerid."</customerid>
							   <value>".$value."</value>
							   <comment>모아포인트 전환</comment>
							</row>
							 ";
							 $query="EXECUTE up_ProcessCustomerPointFamilyShare N'$xml'";
							 //echo $query."<br/>";
							 $sucess_xml = mssql_query($query);
							 if($sucess_xml){
								 $sucess_xml_cnt++;
							 }	 
						}
					}//if($customerid && $value)
					
				}
			}else{
				$customerid = $mb['mb_reg'];
				$value = $po_point;
				//echo "customerid:".$customerid."<br/>";
				if($customerid){
					if($conn){
						 $query="";
						 $xml="";
						 $xml="
						  <row>
						   <creator>System</creator>
						   <entryday>".date('Y-m-d')."</entryday>
						   <customerid>".$customerid."</customerid>
						   <value>".$value."</value>
						   <comment>모아포인트 전환</comment>
						</row>
						 ";
						 $query="EXECUTE up_ProcessCustomerPointFamilyShare N'$xml'";
						 //echo $query."<br/>";
						 $sucess_xml = mssql_query($query);
						 if($sucess_xml){
							 $sucess_xml_cnt++;
						 }						 
					}
				}//if($customerid && $value)


			}

			
			//echo $query;
			return $sucess_xml_cnt;
}

// 추천 정보를 얻는다.
function get_recommend($rc_id, $fields='*')
{
    global $g4;

    return sql_fetch(" select $fields from g4_recommend where rc_id = TRIM('$rc_id') ");
}


function exchange_mydas2($mb_id,$po_point){
//mydas용
			$conn=mssql_connect("210.105.192.236:1433","moacomm_user","moacomm");
			$query="
			  set ansi_null_dflt_on on
			  -- network protocol: TCP/IP
			  set quoted_identifier on
			  set arithabort off
			  set numeric_roundabort off
			  set ansi_warnings on
			  set ansi_padding on
			  set ansi_nulls on
			  set concat_null_yields_null on
			  set cursor_close_on_commit off
			  set implicit_transactions off
			  set language 한국어
			  set dateformat ymd
			  set datefirst 7
			  set transaction isolation level read committed
			 ";
			 mssql_query($query);   //위 쿼리는 반드시 실행시킨후 밑에 쿼리 실행해주세요. (위 쿼리는 페이지에서 1번만 호출하면 됩니다.)
//

			$mb = get_member($mb_id);
			//echo "아이디는".$mb[mb_id]."<br/>";
			$sucess_xml_cnt = 0;
			if($mb[mb_10]){
				$mb_10_point = floor($po_point / $mb[mb_10]);
						$customerid = $mb['mb_reg'];
						$value = $mb_10_point;
						if($customerid){
							if($conn){
								 $query="";
								 $xml="";
								 $xml="
								  <row>
								   <creator>System</creator>
								   <entryday>".date('Y-m-d')."</entryday>
								   <customerid>".$customerid."</customerid>
								   <value>".$value."</value>
								   <comment>모아포인트 전환</comment>
								</row>
								 ";
								 $query="EXECUTE up_ProcessCustomerPointFamilyShare N'$xml'";
								 echo $query."<br/>";

							}
						}//if($customerid && $value)
						
				for($l=1; $l<$mb[mb_10]; $l++) {
					$customerid = $mb['mb_reg']."-".$l;
					$value = $mb_10_point;
					
					if($customerid){
						if($conn){
							 $query="";
							 $xml="";
							 $xml="
							  <row>
							   <creator>System</creator>
							   <entryday>".date('Y-m-d')."</entryday>
							   <customerid>".$customerid."</customerid>
							   <value>".$value."</value>
							   <comment>모아포인트 전환</comment>
							</row>
							 ";
							 $query="EXECUTE up_ProcessCustomerPointFamilyShare N'$xml'";
							 echo $query."<br/>";

						}
					}//if($customerid && $value)
					
				}
			}else{
				$customerid = $mb['mb_reg'];
				$value = $po_point;
				//echo "customerid:".$customerid."<br/>";
				if($customerid){
					if($conn){
						 $query="";
						 $xml="";
						 $xml="
						  <row>
						   <creator>System</creator>
						   <entryday>".date('Y-m-d')."</entryday>
						   <customerid>".$customerid."</customerid>
						   <value>".$value."</value>
						   <comment>모아포인트 전환</comment>
						</row>
						 ";
						 $query="EXECUTE up_ProcessCustomerPointFamilyShare N'$xml'";
						 echo $query."<br/>";

					}
				}//if($customerid && $value)


			}
}


// 대리점 정보를 얻는다.
function get_agency($ac_id, $fields='*' , $where="ac_id =")
{
    global $g4;
	unset($data);
	$data = sql_fetch(" select $fields from g4_agency where $where TRIM('$ac_id') ");
/*	$data[subject] = $data[ac_subject];
	$data[jisa] = $data[ac_jisa];
	$data[headquarters] = $data[ac_headquarters];
	$data[datetime] = $data[ac_datetime];*/
    return $data;
}
// 지사 정보를 얻는다.
function get_jisa($wr_id, $fields='*' , $where="wr_id =")
{
    global $g4;
	unset($data);
	$sql = "select $fields from g4_write_00_jisa where $where TRIM('$wr_id')";
	$data = sql_fetch($sql);
	//지사 = branch
	if($data){
		$data[bc_id] = $data[wr_id];//고유번호
		$data[bc_subject] = $data[wr_subject];//제목
		//$data[bc_name] = $data[wr_name];//이름
		$data[bc_headquarters] = $data[ca_name];//광역본부
		$data[bc_population] = $data[wr_1];//인구수
		$data[bc_datetime] = $data[wr_datetime];//생성일
		$data[bc_contract] = $data[wr_11];//계약여부
		$data[bc_contract2] = $data[wr_12];//수석본부장지사 계약여부
		$data[mb_id] = $data[wr_13];//지사장
		$data[bc_point] = $data[wr_14];//포인트
		
		
	}
    return $data;
}
// 광역본부 정보를 얻는다.
function get_headquarters($wr_id, $fields='*' , $where="wr_id =")
{
    global $g4;
	unset($data);
	$data = sql_fetch(" select $fields from g4_write_00_headquarters where $where TRIM('$wr_id') ");
	//광역본부 = headquarters
	$data[hq_id] = $data[wr_id];//고유번호
	$data[hq_subject] = $data[wr_subject];//제목
	//$data[hq_name] = $data[wr_name];//이름
	$data[hq_population] = $data[wr_1];//인구수
	$data[hq_datetime] = $data[wr_datetime];//생성일
	$data[hq_contract] = $data[wr_11];//계약여부
	$data[mb_id] = $data[wr_13];//본부장
	$data[hq_point] = $data[wr_14];//포인트
	
	
	return $data;
}
// 멀티보너스 정보를 얻는다.
function get_multibonus($mt_id, $fields='*' , $where="mt_id =")
{
    global $g4;
	unset($data);
	$data = sql_fetch(" select $fields from g4_multibonus where $where TRIM('$mt_id') ");
/*	$data[subject] = $data[mt_subject];
	$data[tel] = $data[mt_tel];
	$data[hp] = $data[mt_hp];
	$data[datetime] = $data[mt_datetime];*/	
    return $data;
}// 단체 정보를 얻는다.
function get_organization($org_id, $fields='*' , $where="org_id =")
{
    global $g4;
	unset($data);
	$data = sql_fetch(" select $fields from g4_organization where $where TRIM('$org_id') ");
/*	$data[subject] = $data[org_subject];
	$data[tel] = $data[org_tel];
	$data[hp] = $data[org_hp];
	$data[datetime] = $data[org_datetime];	*/
    return $data;
}
function get_rate($rt_id, $fields='*' , $where="rt_id =")
{
    global $g4;
	unset($data);
	$data = sql_fetch(" select $fields from g4_rate where $where '$rt_id' ");
    return $data;
}
function insert_log($msg = "접근로그(메세지없음)",$key = "")
{
	global $g4,$member;
	unset($data);
	$sql = "insert into g4_log set 
				mb_id = '".$member['mb_id']."',
				log_datetime = '".$g4['time_ymdhis']."',
				log_msg ='".$msg."',
				log_ip = '".$_SERVER['REMOTE_ADDR']."',
				log_url = '".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."',
				log_referer = '".$_SERVER['HTTP_REFERER']."',
				log_user_agent = '".$_SERVER['HTTP_USER_AGENT']."',
				log_method = '".$_SERVER['REQUEST_METHOD']."',
				log_key = '".$key."' ";
	$data = sql_fetch($sql);
    return $data;
}


function get_tp_parents($tp_parents,$result = array()){
	$is_debug = false;
	$is_process = true;
	if(!is_array($tp_parents)){ //초기 입력값이 배열이 아닌 형태로 들어오면 배열형태로 만들어 줌...
		$temp_value = $tp_parents;
		$tp_parents = array();
		$tp_parents[] = $temp_value;
		$result[] = $temp_value;
	}
	
	$last_num = count($tp_parents)-1;
	if($is_debug) echo "<hr/>".$last_num."<br/>";




	
	$tp_parent = get_member($tp_parents[$last_num]);
	//echo "<hr/>".$temp_mem['mb_name'].':'.$temp_value."<br/>";
	
	
	//$sql = "select * from g4_member where mb_id='".$tp_parents[$last_num]."'";
	//echo $sql."<br/>";
	
	//$tp_parent = sql_fetch($sql);
	$mb_name =  $tp_parent['mb_name']."(".$tp_parent['mb_id'].")"; 
	$mb_tp_recom = trim($tp_parent['mb_tp_parent']); 
	$mb_tp_floor = $tp_parent['mb_tp_floor'];
	
	
	if($last_num == 0){
		$floor_start = 6 - $mb_tp_floor;
		if($is_debug) echo "floor_start=".$floor_start."<br/>";
		for($j=1;$j<$floor_start;$j++){
			//if($is_debug) echo "[".$i."]";
			$result[] = $tp_parent['mb_id'];
			//$last_num = $last_num + 1;
		}
	}
	
	
	
	
	if($is_debug) echo $mb_name." ";
	if($is_debug) echo "[".$mb_tp_floor."] ";
	//if($is_debug) echo " => 상위사업자:".$mb_tp_recom;
	

	
	
	//echo $mb_tp_recom;
	$tp_me = get_member($mb_tp_recom);
	if($is_debug) echo " => 상위사업자: ".$tp_me['mb_name']."(".$tp_me['mb_id'].")"." [".$tp_me['mb_tp_floor']."]";
	$floor_gap = $mb_tp_floor - $tp_me['mb_tp_floor'];
	if($is_debug) echo " floor_gap=".$floor_gap;
	for($i=1;$i<$floor_gap;$i++){
		//if($is_debug) echo "[".$i."]";
		$result[] = $mb_tp_recom;
	}
	
	
	//if($mb_tp_floor == 0) $is_process = false;
	if(!$mb_tp_recom) $is_process = false;
	//이미 나온 사업자가 또 나오면 무한루프가 돌리기 때문에...
	
	if(in_array($mb_tp_recom,$tp_parents)) {
		//직전값이 같이 않을경우
		//$tp_parents[]$mb_tp_recom
		$is_process = false;
		if($is_debug) echo " <= 중복된 값이 나온다 Error"."<br/>";
		
	}else{
		if($is_debug) echo "<br/>";
	}
	
	
	if($is_process) {
		//floor값을 확인하여 차이만큼 추가해 주어야
		//floor값을 확인하여 차이만큼 추가해 주어야
		//
		$tp_parents[] = $mb_tp_recom;
		$result[] = $mb_tp_recom;
		get_tp_parents(&$tp_parents,&$result);
	}else{
		if($is_debug) echo "<hr/>";
	}
	
	//(일반5, 대리점4, 지점3, 지사2, 광역1, 본사0) 총 값이 6개인 배열을 반환한다
	//return $tp_parents;
	return $result;
	

}

function insert_groupmember_by_mb_project($mb_id){
	global $g4;
	$mb = get_member($mb_id);
	if($mb['mb_project']){
		$gr = get_group($mb['mb_project']);
		if (!$gr[gr_id]) {
			//echo "<span style='color:red'>존재하지 않는 그룹입니다.</span>"; 
			return false;
		}
		$sql = " select count(*) as cnt 
				   from $g4[group_member_table]
				  where gr_id = '".$mb['mb_project']."'
					and mb_id = '".$mb['mb_id']."' ";
		$row = sql_fetch($sql);
		if ($row[cnt]) {
			//echo "이미 등록되어 있는 자료입니다.";
			return false;
		} 
		else 
		{
			//echo $mb['mb_id'].$mb['mb_project'];
			$sql = " insert into $g4[group_member_table]
						set gr_id       = '".$mb['mb_project']."',
							mb_id       = '".$mb['mb_id']."',
							gm_datetime = '$g4[time_ymdhis]' ";
			$result = sql_query($sql);
			insert_log($mb['mb_project']." 그룹의 ".$mb['mb_id']." 그룹회원을 생성하였습니다.","c");				
			return $result;	
		}
	}
}

function get_scrap_item($ms_id){
	global $g4;
	unset($data);
	$sql = "select * from g4_scrap_item where ms_id = '".$ms_id."' ";
	$data = sql_fetch($sql);
    return $data;
}






//사업자 id를 넣으면 회원정보의 mb_parents(상위사업자) 를 가지고 단계를 구함
function get_parents($mb_parents,$result = array()){ 
	$is_debug = false;
	$is_process = true;

	return $result;
}

function get_share_target($mb_id){
	
	/*
	$mb = get_member($mb_id);
	회원정보를 조회해서 카드정보가져옴..
	카드정보를 이용해 적립 타겟을 가져옴.
	- $target[0] = mb_id : 페이;
	- $target[1] = mc_id : 가맹점;
	- $target[2] = mc['mc_manager'] : 관리사업자;
	$parents = get_parents(사업자아이디) 
	- $target[3] = $parents[0] : 사업자;
	- $target[4] = $parents[1] : 대리점사업자;
	- $target[5] = $parents[2] : 지점사업자;
	- $target[6] = $parents[3] : 지사사업자;
	- $target[7] = $parents[4] : 광역사업자;
	- $target[8] = mc의주소 : 지역지사;
	- $target[9] = mc의주소 : 지역광역;
	- $target[10] = 고정된mb_id : 고도;
	- $target[11] =  : 단체;
	- $target[12] =  : 단체소개자;
	- $target[13] = moa : 본사;	
	*/
}

/*
- $point = $price;
- $target = get_share_target();
- $filter['project'] = "moapay";
- $filter['type'] = "pointmall";
*/
//각 단계=>id 를 넣으면 적립금액및 퍼센트를 구하는 함수
function get_shares($point,$target, $filter){
	/*
	
	$data[][id] = $target_value
	$data[][point] = $point
	$data[][msg] = $target_key 에 따라 적립포인트(사업자:242) 등 메세지수정.
	
	*/
	return $data;    
}

//적립해주는함수
function point_share($data){
	/*
		for($i=0;$i<count($data);$i++){
			
			insert_point($data[$i]['id'],$data[$i]['point'],$data[$i]['msg']);
			
			
			
		}
	
	*/
	return true;
}

?>