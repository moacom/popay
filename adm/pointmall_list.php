<?
$sub_menu = "200290";
include_once("./_common.php");
$this_table = "g4_board_order2";


auth_check($auth[$sub_menu], "r");

$token = get_token();

$sql_common = " from {$this_table} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "orderlist" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        case "mb_id" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        case "owner_name" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        case "seller_name" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        case "receive_phone" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
		case "confirmdate" :
			$sql_search .= " ($sfl like '$stx%') ";
            break;
        default : 
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

switch ($is_cancel) {  // 취소여부
	case "1" :
		$sql_search .= "and (is_cancel != '0')";	
		break;
	default :
		$sql_search .= "";
}
$qstr .= "&is_cancel=".$is_cancel;

switch ($delivery) {  // 배송상태
	case "1" :
		$sql_search .= "and (is_confirm != '0')";
		break;
	case "0" :
		$sql_search .= "and (is_confirm = '0')";
		break;	
	default :
		$sql_search .= "";		
}
$qstr .= "&delivery=".$delivery;

switch ($payment) {  // 결제상태
	case "1" :
		$sql_search .= "and (confirmdate is NOT NULL and confirmdate <> '0000-00-00')";
		break;
	case "0" :
		$sql_search .= "and (confirmdate is NULL or confirmdate = '0000-00-00')";
		break;
	default :
		$sql_search .= "";		
}



$sql_search .= "and bn_type = 'pointmall' ";
$qstr .= "&payment=".$payment;

if($bn_datetime_s) {$sql_search .= " and (bn_datetime >= '$bn_datetime_s 00:00:00') ";$qstr.="&bn_datetime_s=$bn_datetime_s";}
if($bn_datetime_e) {$sql_search .= " and (bn_datetime <= '$bn_datetime_e 23:59:59') ";$qstr.="&bn_datetime_e=$bn_datetime_e";}
if($paytype) {$sql_search .= " and pay_type = '".$paytype."' ";$qstr.="&paytype=$paytype";}


if (!$sst) {
    $sst  = "bn_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
         $sql_common 
         $sql_search 
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";

$result = sql_query($sql);

$listall = "<a href='$_SERVER[PHP_SELF]'>처음</a>";

if ($sfl == "mb_id" && $stx)
    $mb = get_member($stx);





//if($test) echo $this_table;







//-------------------------------엑셀 다운로드----------------------------
if($output=="excel"){
$sql = " select *
          $sql_common
          $sql_search
          $sql_order";
			//and orderlist like '%곡물고기%'
$result = sql_query($sql);

if(!@mysql_num_rows($result))
    alert_close('월회비 정보가 없습니다.');

/*================================================================================
php_writeexcel http://www.bettina-attack.de/jonny/view.php/projects/php_writeexcel/
=================================================================================*/

include_once('../lib/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
include_once('../lib/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

$fname = tempnam('../data/', "tmp-smarthomelist.xls");
$workbook = new writeexcel_workbook($fname);
$worksheet = $workbook->addworksheet();

// Put Excel data
if($arrange){
	$data = array('주문번호','상품명', '수량','구매자ID','구매자성명','구매자연락처','금액','받는이성명','받는이연락처','주소','결제상태','배송상태','결제수단','취소여부');	
}else{
	$data = array('주문번호','주문일','상품명','구매자ID','구매자성명','구매자연락처','금액','받는이성명','받는이연락처','주소','결제상태','배송상태','결제수단','취소여부');	
}

//      주소
//$data = array_map('iconv_utf8', $data);

$col = 0;
foreach($data as $cell) {
    $worksheet->write(0, $col++, $cell);
}

$j=1;

$object_arr = array();

for($i=1; $row=sql_fetch_array($result); $i++) {
    //$row = array_map('iconv_utf8', $row);
	/*$mb['mb_10'] 개수대로 환전점수를 나누고, mb_10의 개수 -1 만큼 행을 만들고 생년월일-$i 처럼*/
		
			$temp_ = explode("(",$row['orderlist']);
			//$object_count = str_replace("개)","",$temp_[(count($temp_)-1)]);
			$object_count = $row['count'];
			$object = str_replace("(".$temp_[(count($temp_)-1)],"",$row['orderlist']);

			if(!$row['total_price'] && $row[bo_table]){
				$sql_bn = " SELECT * FROM `g4_write_".$row[bo_table]."` where wr_id='$row[wr_id]'  ";
				$row_bn = sql_fetch($sql_bn);
				$price = $object_count * $row_bn['wr_4'];
			}else{
				$price = $row['total_price'];
			}
			
			if($row['mb_id']){
				$mb =  get_member($row['mb_id']);
			}

			if($row['confirmdate']) $confirmdate = $row['confirmdate']; // 결제상태
			else $confirmdate = "미확인";
			
			if($row['is_confirm']) $is_confirm = "완료"; // 배송상태
			else $is_confirm = "미처리";
			
			$is_cancel = "";
			if($row['is_cancel'] == "1") $is_cancel = "취소"; // 취소여부
			
			$pay_type_text = $row[pay_type];
			if($row[pay_type] == "account") $pay_type_text = "무통장";
			if($row[pay_type] == "card") $pay_type_text = "카드";
			if($row[pay_type] == "point") $pay_type_text = "일반P";
			if($row[pay_type] == "point2") $pay_type_text = "가산P";
			if($row[pay_type] == "point3") $pay_type_text = "쇼핑몰P";
			if($row[pay_type] == "point4") {
				$pay_type_text = "쇼핑P";
				if($mb){
					$pay_type_text .= "(".number_format($mb['mb_point4']).")";
				}
			}
			
			
			/*if($row[pay_type] == "account"){
				$pay_type_text = "무통장입금";
			}elseif($row[pay_type] == "point4"){
				$pay_type_text = "쇼핑포인트구매";
			}elseif($row[pay_type] == "point"){
				$pay_type_text = "적립포인트";
			}elseif($row[pay_type] == "card"){
				$pay_type_text = "카드";
			}else{
				$pay_type_text = $row['pay_type'];
			}*/

			
			if($arrange){
				if($object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['bn_id']){
					$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['bn_id'] .= ",";
				}
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['bn_id'] .= $row['bn_id'];
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['object'] = $object;
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['object_count'] += $object_count;
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['owner_name'] = $row['owner_name'];
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['mb_id'] = $row['mb_id'];
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['owner_phone'] = $row['owner_phone'];
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['price'] += $price;
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['receive_name'] = $row['receive_name'];
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['receive_phone'] = $row['receive_phone'];
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['owner_address'] = $row['owner_address'];
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['confirmdate'] = $confirmdate;
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['is_confirm'] = $is_confirm;
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['pay_type_text'] = $pay_type_text;
				$object_arr[$object][$row['mb_id']][$is_confirm][$confirmdate][$pay_type_text][$is_cancel][$row['receive_name']][$row['receive_phone']][$row['owner_address']]['is_cancel'] = $is_cancel;
			}else{
				$worksheet->write_string($j, 0, $row['bn_id']);
				$worksheet->write($j, 1, $row['bn_datetime']);
				$worksheet->write($j, 2, $row['orderlist']);
				$worksheet->write_string($j, 3, $row['mb_id']);
				$worksheet->write_string($j, 4, $row['owner_name']);
				$worksheet->write_string($j, 5, $row['owner_phone']);
				$worksheet->write_string($j, 6, $price);
				$worksheet->write_string($j, 7, $row['receive_name']);
				$worksheet->write_string($j, 8, $row['receive_phone']);
				$worksheet->write_string($j, 9, $row['owner_address']);
				$worksheet->write_string($j, 10, $confirmdate);
				$worksheet->write_string($j, 11, $is_confirm);				
				$worksheet->write_string($j, 12, $pay_type_text);
				$worksheet->write_string($j, 13, $is_cancel);
				$j++;
			}

}
if($arrange){
	foreach($object_arr as $key => $value) {
		foreach($object_arr[$key] as $key2 => $value){
			foreach($object_arr[$key][$key2] as $key3 => $value){
				foreach($object_arr[$key][$key2][$key3] as $key4 => $value){
					foreach($object_arr[$key][$key2][$key3][$key4] as $key5 => $value){
						foreach($object_arr[$key][$key2][$key3][$key4][$key5] as $key6 => $value){
							foreach($object_arr[$key][$key2][$key3][$key4][$key5][$key6] as $key7 => $value){
								foreach($object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7] as $key8 => $value){
									foreach($object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8] as $key9 => $value){
										//echo var_dump($object_arr[$key]);
										$worksheet->write_string($j, 0,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['bn_id']);
										$worksheet->write_string($j, 1,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['object']);
										$worksheet->write_string($j, 2,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['object_count']);
										$worksheet->write_string($j, 3,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['mb_id']);
										$worksheet->write_string($j, 4,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['owner_name']);
										$worksheet->write_string($j, 5,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['owner_phone']);
										$worksheet->write_string($j, 6,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['price']);
										$worksheet->write_string($j, 7,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['receive_name']);
										$worksheet->write_string($j, 8,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['receive_phone']);
										$worksheet->write_string($j, 9,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['owner_address']);
										$worksheet->write_string($j, 10,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['confirmdate']);
										$worksheet->write_string($j, 11,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['is_confirm']);
										$worksheet->write_string($j, 12,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['pay_type_text']);
										$worksheet->write_string($j, 13,$object_arr[$key][$key2][$key3][$key4][$key5][$key6][$key7][$key8][$key9]['is_cancel']);
										$j++;
										//echo $j;		
									}
								}
							}
						}
					}
				}
			}
		}
	}
}


//exit();
$workbook->close();

header("Content-Type: application/x-msexcel; name=\"smarthomelist-".date("ymd", time()).".xls\"");
header("Content-Disposition: inline; filename=\"smarthomelist-".date("ymd", time()).".xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
//-------------------------------------------------------------------------------------------------------
}else{

$g4[title] = "가맹점관리";
include_once ("./admin.head.php");

$colspan = 16;
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<script type="text/javascript">
var list_update_php = "smarthome_list_update.php";
var list_update2_php = "smarthome_list_update2.php";
var list_delete_php = "smarthome_list_delete.php";
var list_update3_php = "smarthome_list_update3.php";
</script>

<script type="text/javascript">
function point_clear()
{
    if (confirm("환전 정리를 하시면 최근 50건 이전의 환전 부여 내역을 삭제하므로\n\n환전 부여 내역을 필요로 할때 찾지 못할 수도 있습니다.\n\n\n그래도 진행하시겠습니까?"))
    {
        document.location.href = "./point_clear.php?ok=1";
    }
}
</script>

<link rel="stylesheet" href="../plugin/bootstrap/css/bootstrap.min.css">
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="./smarthome_list.php">스마트홈쇼핑관리</a></li>
  <li role="presentation"><a href="./smarthome_list_excel.php">스마트홈쇼핑관리 엑셀일괄등록</a></li>
</ul>

<br/>
<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=40% align=left>
		<a href="<?php echo $_SERVER['PHP_SELF']."?output=excel".$qstr?>"  style="border:2px solid #000; padding:2px" >엑셀다운로드</a>
        <a href="<?php echo $_SERVER['PHP_SELF']."?output=excel&arrange=true".$qstr?>"  style="border:2px solid #000; padding:2px" >중복합친엑셀다운로드</a>
    </td>
    <td width=60% align=right>
		<select name="is_cancel">
        	<option value=''>취소여부</option>
            <option value='1' <?php echo ($is_cancel == "1")?"selected":""?>>취소</option>
        </select>
        <select name=paytype>
        	<option value=''>결제수단</option>
            <option value='account'<?php echo ($paytype == "account")?"selected":""?>>무통장</option>
            <option value='point4'<?php echo ($paytype == "point4")?"selected":""?>>쇼핑P</option>
            <option value='point'<?php echo ($paytype == "point")?"selected":""?>>적립P</option>
            <option value='card'<?php echo ($paytype == "card")?"selected":""?>>카드</option>
            
        </select>
	    <input type="date" name="bn_datetime_s" value="<?=$bn_datetime_s?>" style="height:19px;" />~<input type="date" name="bn_datetime_e" value="<?=$bn_datetime_e?>" style="height:19px;" />
	</td>
</tr>
<tr>
    <td width=40% align=left>
        <?=$listall?> (건수 : <?=number_format($total_count)?>)
        <?
        if ($mb[mb_id])
            echo "&nbsp;(" . $mb[mb_id] ." 님 환전 합계 : " . number_format($mb[mb_point]) . "점)";
        else {
           // $row2 = sql_fetch(" select sum(po_point) as sum_point from g4_card ");
          //  echo "&nbsp;(전체 환전 합계 : " . number_format($row2[sum_point]) . "점)";
        }
        ?>        
        <? if ($is_admin == "super") { ?><!-- <a href="javascript:point_clear();">환전정리</a> --><? } ?>
    </td>
    <td width=60% align=right>

    
    	<select name="payment">
        	<option value=''>결제상태</option>
            <option value='1'<?php echo ($payment == "1")?"selected":""?>>결제</option>
            <option value='0'<?php echo ($payment == "0")?"selected":""?>>미확인</option>
        </select>
        
        <select name="delivery">
        	<option value=''>배송상태</option>
			<option value='1'<?php echo ($delivery == "1")?"selected":""?>>완료</option>
			<option value='0'<?php echo ($delivery == "0")?"selected":""?>>미처리</option>
        </select>
    
        <select name=sfl class=cssfl>
        	<option value='orderlist'>상품명</option>
            <option value='mb_id'>등록ID</option>
            <option value='owner_name'>구매자</option>
            <option value='seller_name'>입금자</option>
            <option value='receive_phone'>연락처</option>
            <option value='confirmdate'>결제일자</option>
          </select>
        <input type=text name=stx class=ed itemname='검색어' value='<?=$stx?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</form>
</table>

<form name=fpointlist method=post>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>

<table width=100% cellpadding=0 cellspacing=1>
<colgroup width=30>
<colgroup width=30>
<colgroup width=90>
<colgroup width=100>
<colgroup width=100>
<colgroup width=''>
<colgroup width=70>
<colgroup width=70>

<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center' >
    <td><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td>주문번호</td>
    <td><?=subject_sort_link('bn_datetime')?>주문일</a></td>
    <td><?=subject_sort_link('orderlist')?>상품명</a></td>
    <td><?=subject_sort_link('mb_id')?>등록ID<br/><?=subject_sort_link('receive_id')?>소개자ID</a></td>
    <td><?=subject_sort_link('owner_name')?>구매자<br/><?=subject_sort_link('seller_name')?>입금자</a></td>
    
    <td><?=subject_sort_link('receive_phone')?>연락처</a><br/><?=subject_sort_link('count')?>수량</a></td>
    <td><?=subject_sort_link('receive_name')?>받는이<br/><?=subject_sort_link('receive_phone')?>받는이연락처</a></td>    
    <td>금액<br/><?=subject_sort_link('total_price')?>전체금액</a></td>
    <td>결제수단<br/>결제경로</td>
    <td>결제상태<br/>적립번호(%)</td>
    <td>배송<br/>취소여부</td>
    <!--<td>수정</td>-->
    <td><a href="./smarthome_form.php"><img src='<?=$g4[admin_path]?>/img/icon_insert.gif' border=0 title='추가'></a></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    //if ($row2[mb_id] != $row[mb_id])
    //{
        $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point, mb_1, mb_2, mb_5,mb_point,mb_point4,mb_project from $g4[member_table] where mb_id = '$row[mb_id]' ";
        $row2 = sql_fetch($sql2);
		
		
		
		
		if($row[bo_table]){
			$sql3 = " SELECT * FROM `g4_write_".$row[bo_table]."` where wr_id='$row[wr_id]'  ";
			$row3 = sql_fetch($sql3);
		}
		

		
		
    //}

    //$sql3 = " select sum(po_point) as pnt from g4_card where mb_id='{$row[mb_id]}' and po_datetime <= '{$row[po_datetime]}'";
	//$row3 = sql_fetch($sql3);
	

    $mb_nick = get_sideview($row[mb_id], $row2[mb_nick], $row2[mb_email], $row2[mb_homepage]);

    $link1 = $link2 = "";
    if (!preg_match("/^\@/", $row[po_rel_table]) && $row[po_rel_table])
    {
        $link1 = "<a href='$g4[bbs_path]/board.php?bo_table={$row[po_rel_table]}&wr_id={$row[po_rel_id]}' target=_blank>";
        $link2 = "</a>";
    }

    $list = $i%2;

     $s_mod = "<a href=\"./smarthome_form.php?$qstr&w=u&bn_id=$row[bn_id]\"><img src='img/icon_modify.gif' border=0 title='수정'></a>";
        //$s_del = "<a href=\"javascript:del('./member_delete.php?$qstr&w=d&mb_id=$row[mb_id]');\"><img src='img/icon_delete.gif' border=0 title='삭제'></a>";
	 $s_del="";	
     //$s_del = "<a href=\"javascript:post_delete('point_delete.php', '$row[mb_id]');\"><img src='img/icon_delete.gif' border=0 title='삭제'></a>";
	 $s_sms='<a onclick="window.open(\'./smarthome_sms.php?&i='.$i.'&bn_id='.$row[bn_id].'\',\'sms\',\'menubar=no,toolbar=no,scrollbars=no,width=450px,height=400px\');"><span style="color:red; font-size:12px">SMS</span></a>';
	 //$s_sms = "<input type='image' id='subsms' src='./img/icon_help.gif' value='$row[bn_id]' onclick='subsms()'>";
	 //"<input type='image' src='./img/icon_help.gif' onclick='subsms()'>";
//$po_datetime = date("Y-m-d H:i:s", time() - (3600 * 24));
	$po_datetime = strtotime($row[bn_datetime]);
	$pd_date = date("Y-m-d", $po_datetime);
	$pd_time = date("H:i:s", $po_datetime);
	$no_datetime = mktime(0,0,0,date("n"),date("j"),date("Y"));
	if($po_datetime>$no_datetime) {
		$now_date = $pd_time;
		$is_today = true;
	}else{
		$now_date = $pd_date;
		$is_today = false;
	}
	
	if($pd_date<>$pre_po_date){
		echo "<tr><td colspan='".$colspan."' class='line2'></td></tr>";
	}else{
		//echo "<tr><td colspan='".$colspan."' class='line3'></td></tr>";
	}
	$pre_po_date = $pd_date;
	
	if($row[is_nh]){ //타행 수수료 1000
		$exchange_fee = 1000;
		$price_style = " color:red;  ";
	}else{ //농협 수수료 500
		$exchange_fee = 500;
		$price_style = "";
	}
	$exchange_price = $row[po_point]-($row[po_point]*0.033)-$exchange_fee;
	if ($row[po_point]==0) $exchange_price =0;

	$po_price=$row[po_price];
	if ($po_price==0)    $po_price=$exchange_price;
	
	if ($row[confirmdate]&&$row[confirmdate]!="0000-00-00") {
		$confirmdate = strtotime($row[confirmdate]);
		$confirmdate = date("m-d", $confirmdate);
		//$confirmdate = "<span style='color:red'>".$confirmdate."</span>";
		//$confirmdate=$row[confirmdate];
	}else{
		$confirmdate="미확인";
		$confirmdate = "<span style='color:red'>".$confirmdate."</span>";
	}
	if ($row[is_confirm]) {
		$is_confirm = "완료";
		//$is_confirm = date("m-d", $confirmdate);
		//$confirmdate = "<span style='color:red'>".$confirmdate."</span>";
		//$confirmdate=$row[confirmdate];
	}else{
		$is_confirm="미처리";
		$is_confirm = "<span style='color:red'>".$is_confirm."</span>";
	}
	if ($row[receive_id]) {
		$receive_id = $row[receive_id];
		//$is_confirm = date("m-d", $confirmdate);
		//$confirmdate = "<span style='color:red'>".$confirmdate."</span>";
		//$confirmdate=$row[confirmdate];
	}else{
		$receive_id="비회원";
	}
	


	
	/*if($row[pay_type] == "account"){
		$pay_type_text = "무통장입금";
	}elseif($row[pay_type] == "point4"){
		$pay_type_text = "쇼핑포인트구매";
	}else{
		$pay_type_text = $row[pay_type];
	}*/
	$pay_type_text = $row[pay_type];
	if($row[pay_type] == "account") $pay_type_text = "무통장";
	if($row[pay_type] == "card") $pay_type_text = "카드";
	if($row[pay_type] == "point") $pay_type_text = "일반P";
	if($row[pay_type] == "point2") $pay_type_text = "가산P";
	if($row[pay_type] == "point3") $pay_type_text = "쇼핑몰P";
	if($row[pay_type] == "point4") $pay_type_text = "쇼핑P<br/>(<a href=\"/adm/point_list_recharge.php?prev_mb_id=&prev_po_content=&sfl=mb_id&stx=".$row[mb_id]."\" target=\"_blank\">".number_format($row2['mb_point4'])."</a>)";
	
	$is_cancel = "";
	if($row[is_cancel] == "1") $is_cancel = "취소";
	
	
	$bn_project_style = 'color:blue';
	if($row['bn_project'] == "hlzone") $bn_project_style = 'color:red';
	$mb_project_style = 'color:blue';
	if($row2['mb_project'] == "hlzone") $mb_project_style = 'color:red';
	
	if($row['bn_rate']) $bn_rate = $row['bn_rate'];
	else $bn_rate = '5';
	
	$bn_rate_char = "%";
	if($bn_rate > 100) $bn_rate_char = "P";
	
	if($row['bn_sr_id']) $bn_sr_id = "<a href='/adm/point_list.php?sfl=po_content&stx=".urlencode('적립포인트('.$row['bn_sr_id'])."' >".$row['bn_sr_id']."</a>";
	else $bn_sr_id = '';
	
    echo "
    <input type=hidden name=bn_id[$i] value='$row[bn_id]'>
    <tr class='list$list col1 ht center' >
        <td><input type=checkbox name=chk[] value='$i'></td>
		<td rowspan=3><a href='/adm/point_list.php?prev_mb_id=&prev_po_content=&sfl=po_content&stx=%B1%B8%B8%C5%C6%F7%C0%CE%C6%AE%28".$row[bn_id]."'>$row[bn_id]</a></td>
        <td rowspan=3>$now_date</td>
        <td rowspan=3 style='text-align:left; top:0px; '><span onmouseover=\"asasas('$i')\" onmouseout=\"asasas2('$i')\">$row[orderlist]</span></td>
        <td><a href=\"/adm/member_form.php?&w=u&mb_id=$row[mb_id]\">$row[mb_id]</a></td>
        <td style='".$mb_project_style."'>$row[owner_name]</td>
        <td>$row[owner_phone]</td>
		<td>$row[receive_name]</td>
		<td>$row3[wr_4]</td>
		<td>$pay_type_text</td>
        <td>$confirmdate</td>
        <td>$is_confirm</td>
		<td>$s_mod</td>
		
		<!--<td>".((true)?$s_mod." ".$s_del." ".$s_grp:"")."</td>-->

		
    </tr> ";
	
	    echo "
    <input type=hidden name=bn_id[$i] value='$row[bn_id]'>
    <tr class='list$list col1 ht center' >
        <td></td>
        <td>$receive_id</td>
        <td>$row[seller_name]</td>
        <td>".$row['count']."</td>		
		<td>$row[receive_phone]</td>
		<td>".number_format($row[total_price])."원</td>
		<td style='".$bn_project_style."'>".$row['bn_project']."</td>
        <td>".$bn_sr_id."(".$bn_rate."".$bn_rate_char.")</td>
        <td>".$is_cancel."</td>
		
		<!--<td>".((true)?$s_mod." ".$s_del." ".$s_grp:"")."</td>-->

		
    </tr> ";
	
$owner_address=$row[owner_address];
	
	//if($po_comments=="") $po_comments="관리자 코멘트가 없습니다.";


	echo "<tr class='list$list col1 ht center' style=\"position:relative;\">
	<td colspan='13' style='position:relative;'>" .
	"<span style=\"position:absolute; left:230px; top:7px; \">".$owner_address ."</span>".
	"<span style=\"position:absolute; left:550px;top:7px;\">".stripslashes($row[bn_content])."</span>".
	"<span id=\"span".$i."\" style=\"display:none;border:1px solid red; position:absolute; left:200px; z-index:100; padding:10px; background:#fff; top:-33px; text-align:left;\">".$row3[wr_2]."<br/>".$row3[wr_21]."<br/>".$row3[wr_3]."<br/>".$row3[wr_7]."<br/>".$row3[wr_9]."</span>
	</td>
	</tr>";
	


} 

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 bgcolor=#ffffff>자료가 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");
echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=50%>";
echo "<input type=button class='btn1' value='선택삭제' onclick=\"btn_check(this.form, 'delete')\">";
echo "<input type=button class='btn1' value='입금확인' onclick=\"btn_check(this.form, 'update')\">";
echo "<input type=button class='btn1' value='배송처리' onclick=\"btn_check(this.form, 'update2')\">";
echo "<input type=button class='btn1' value='선택취소' onclick=\"btn_check(this.form, 'update3')\">";
//echo "<input type=button class='btn1' value='선택수정' onclick=\"btn_check(this.form, 'update')\">&nbsp;";
echo "</td>";
echo "<td width=50% align=right>$pagelist</td></tr></table>\n";

if ($stx)
    echo "<script type='text/javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
?>
</form>

<script type='text/javascript'> document.fsearch.stx.focus(); </script>

<?$colspan=4?>
<p>
<form name=fpointlist2 method=post onsubmit="return fpointlist2_submit(this);" autocomplete="off">
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>
<table width=100% cellpadding=0 cellspacing=1 class=tablebg>
<colgroup width=150>
<colgroup width=''>
<colgroup width=100>
<colgroup width=100>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td>회원아이디</td>
    <td>환전 내용</td>
    <td>환전</td>
    <td>입력</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<tr class='ht center'>
    <td><input type=text class=ed name=mb_id required itemname='회원아이디' value='<?=$mb_id?>'></td>
    <td><input type=text class=ed name=po_content required itemname='내용' style='width:99%;'></td>
    <td><input type=text class=ed name=po_point required itemname='환전' size=10></td>
    <td><input type=submit class=btn1 value='확인'></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</table>
</form>

<script type="text/javascript">
function subsms(){
	var this_value = $("#subsms").val();
	window.open("./smarthome_sms.php?&bn_id="+this_value,"sms","menubar=no,toolbar=no,scrollbars=no,width=450px,height=400px");
}
function asasas(arg){
	//alert(arg);
	$("#span"+arg).show();
} 
function asasas2(arg){
	//alert(arg);
	$("#span"+arg).hide();
} 

function fpointlist2_submit(f)
{
    f.action = "./merchants_update.php";
    return true;
}
</script>

<?
$lms = new LMS("http://lmsservice.tongkni.co.kr/lms.1/ServiceLMS.asmx?WSDL"); //SMS 객체 생성
//$result=$lms->SendLMS("moamoa1234","yein6510","010-5877-9025","010-7277-9681","물건주문","아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다아기다리고기다리던대특가할인이벤트입니다 ");// 6개의 인자로 함수를 호출합니다.
//$result=$sms->SendSMS("moamoa1234","yein6510",$receive_phone_number,"010-5877-9025","관리알람 직접구매건[$total_product]이 등록되었습니다");// 5개의 인자로 함수를 호출합니다.

?>

<?
include_once ("./admin.tail.php");
} //if($output=
?>
