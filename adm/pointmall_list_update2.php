<?
$sub_menu = "200290";
include_once("./_common.php");
$this_table = "g4_board_order2";

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

//exit();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $chk[$i];

	$sql = "select * from $g4[board_order_table2] where bn_id = '{$_POST[bn_id][$k]}' ";
	$bn = sql_fetch($sql);
	
	if($bn['is_cancel'] == "1") {
		$msg .= "$bn[bn_id] : 취소 처리가 되어 배송상태를 변경하실 수 없습니다.\\n";
	} else {
		$sql = " update $this_table
					set is_confirm = '1'
				  where bn_id         = '{$_POST[bn_id][$k]}' ";
		//if ($is_admin != "super")
		//    $sql .= " and gr_admin    = '{$_POST[gr_admin][$k]}' ";
		sql_query($sql);
		insert_log($_POST[bn_id][$k]."번 직접주문을 수정하였습니다.","u");
	}
}

if($msg){
	alert($msg,"./pointmall_list.php?$qstr");
}else{
	goto_url("./pointmall_list.php?$qstr");
}
?>
