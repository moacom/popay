<?
$sub_menu = "200290";
include_once("./_common.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

//if ($is_admin != "super" && $w == "") alert("최고관리자만 접근 가능합니다.");


check_token();

$bn_datetime      = $_POST['bn_datetime'];
$orderlist  = $_POST['orderlist'];
$mb_id        = $_POST['mb_id'];
$receive_id   = $_POST['receive_id'];
$owner_name       = $_POST['owner_name'];
$seller_name        = $_POST['seller_name'];
$receive_phone      = $_POST['receive_phone'];
$total_price  = $_POST['total_price'];
$pay_type     = $_POST['pay_type'];
$confirmdate       = $_POST['confirmdate'];
if($confirmdate=="") {$confirmdate="NULL";}else{$confirmdate="'".$confirmdate."'";}
$is_confirm       = $_POST['is_confirm'];
$owner_address       = $_POST['owner_address'];
$is_cancel       = $_POST['is_cancel_temp'];
$bn_rate = $_POST['bn_rate'];
$bn_sr_id = $_POST['bn_sr_id'];
$bo_table = $_POST['bo_table'];
$wr_id = $_POST['wr_id'];

if ($w == "") 
{
    $sql = "insert into g4_board_order2 set bn_datetime = '$bn_datetime', bo_table='$bo_table',wr_id='$wr_id',orderlist='$orderlist',mb_id='$mb_id',receive_id='$receive_id',owner_name='$owner_name',seller_name='$seller_name',receive_phone='$receive_phone',total_price='$total_price',pay_type='$pay_type',confirmdate=$confirmdate,is_confirm='$is_confirm',owner_address='$owner_address',is_cancel='$is_cancel',bn_type='pointmall',bn_project='adm',bn_rate='$bn_rate',bn_sr_id='$bn_sr_id'  ";
    sql_query($sql);
	$bn_id = mysql_insert_id();
	insert_log($bn_id."번 직접주문을 생성하였습니다.","c");
} 
else if ($w == "u") 
{

        $sql2 = " select * from g4_board_order2 where bn_id = '$bn_id' ";
        $mc = sql_fetch($sql2);


$sql_common = " bn_datetime = '$bn_datetime',  bo_table='$bo_table',wr_id='$wr_id',orderlist='$orderlist',mb_id='$mb_id',receive_id='$receive_id',owner_name='$owner_name',seller_name='$seller_name',receive_phone='$receive_phone',total_price='$total_price',pay_type='$pay_type',confirmdate=$confirmdate,is_confirm='$is_confirm',owner_address='$owner_address',is_cancel='$is_cancel',bn_rate='$bn_rate',bn_sr_id='$bn_sr_id' ";

    
	//$point = sql_fetch("select * from $g4[exchange_table] where po_id='$po_id' ");
	
	$sql = " update g4_board_order2 
                set $sql_common
              where bn_id = '$bn_id' ";
    sql_query($sql);
	insert_log($bn_id."번 직접주문을 수정하였습니다.","u");
	
	
	
			  
	
} 
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

goto_url("./pointmall_form.php?w=u&bn_id=$bn_id&$qstr");
?>
