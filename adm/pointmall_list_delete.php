<?
$sub_menu = "200290";
include_once("./_common.php");
$this_table = "g4_board_order2";

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];

    $sql = " delete from $this_table where bn_id = '{$_POST['bn_id'][$k]}' ";
    sql_query($sql);
	insert_log($_POST['bn_id'][$k]."번 직접주문을 삭제하였습니다.","d");
//    $sql = " select sum(po_point) as sum_po_point from $g4[point_table] where mb_id = '{$_POST['mb_id'][$k]}' ";
//    $row = sql_fetch($sql);
//    $sum_point = $row[sum_po_point];
//
//    $sql= " update $g4[member_table] set mb_point = '$sum_point' where mb_id = '{$_POST['mb_id'][$k]}' ";
//    sql_query($sql);
}

goto_url("./smarthome_list.php?$qstr");
?>
