<?
$sub_menu = "200290";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

//if ($is_admin != "super" && $w == "") alert("최고관리자만 접근 가능합니다.");

$html_title = "포인트몰관리";
if ($w == "") 
{
    $po_id_attr = "required";
    $order[gr_use_access] = 0;
    $html_title .= " 생성";
} 
else if ($w == "u") 
{
    $po_id_attr = "readonly style='background-color:#dddddd'";
    $order = sql_fetch(" select * from g4_board_order2 where bn_id = '$bn_id' ");
    $html_title .= " 수정";
	//$order = sql_fetch(" select * from $g4[exchange_table] where po_id= ");
} 
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

$g4[title] = $html_title;
include_once("./admin.head.php");
?>

<form name=fgitc method=post onsubmit="return fgitc_check(this);" autocomplete="off">
<input type=hidden name=w     value='<?=$w?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>
<input type=hidden name=bn_id value='<?=$order[bn_id]?>'>
<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>

<tr class='ht'>
    <td>주문일</td>
    <td colspan=3>
        <input type='text' class=ed name="bn_datetime" size=40 value='<?=$order[bn_datetime]?>' placeholder="2015-12-25 01:15:38">
    </td>
</tr>

<tr class='ht'>
    <td>상품명</td>
    <td colspan=3>
        <input type='text' class=ed name="orderlist" size=40 value='<?=$order[orderlist]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>등록ID</td>
    <td colspan=3>
        <input type='text' class=ed name="mb_id" size=40 value='<?=$order[mb_id]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>소개자ID</td>
    <td colspan=3>
        <input type='text' class=ed name="receive_id" size=40 value='<?=$order[receive_id]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>구매자</td>
    <td colspan=3>
        <input type='text' class=ed name="owner_name" size=40 value='<?=$order[owner_name]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>입금자</td>
    <td colspan=3>
        <input type='text' class=ed name="seller_name" size=40 value='<?=$order[seller_name]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>연락처</td>
    <td colspan=3>
        <input type='text' class=ed name="receive_phone" size=40 value='<?=$order[receive_phone]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>금액</td>
    <td colspan=3>
        <input type='text' class=ed name="total_price" size=40 value='<?=$order[total_price]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>결제수단</td>
    <td colspan=3>
        <input type='text' class=ed name="pay_type" size=40 value='<?=$order[pay_type]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>결제상태(날짜, 미처리시 공백)</td>
    <td colspan=3>
        <input type='text' class=ed name="confirmdate" value='<?=$order[confirmdate]?>' <?php echo "readonly"; //if(!$order['confirmdate']) echo "readonly"; ?> >
    </td>
</tr>

<tr class='ht'>
    <td>배송</td>
    <td colspan=3>
        <input type='radio' class=ed name="is_confirm" value='1' <? if($order[is_confirm] ==1){echo " checked";}?>> 처리
        <input type='radio' class=ed name="is_confirm" value='0' <? if($order[is_confirm] ==0){echo " checked";}?>> 미처리
    </td>
</tr>

<tr class='ht'>
	<td>취소여부</td>
    <td colspan=3>
    	<input type="hidden" name="is_cancel" value="<?php echo $order[is_cancel]?>" />
    	<input type="checkbox" name="is_cancel_temp" value="1" disabled="disabled" <?php echo ($order[is_cancel] == "1")?"checked":"" ?> />
    </td>
</tr>

<tr class='ht'>
    <td>주문자주소</td>
    <td colspan=3>
        <input type='text' class=ed name="owner_address" size=40 value='<?=$order[owner_address]?>'>
    </td>
</tr>


<tr class='ht'>
    <td>상품게시판(bo_table)</td>
    <td colspan=3>
        <input type='text' class=ed name="bo_table" size=40 value='<?=$order[bo_table]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>상품글번호(wr_id)</td>
    <td colspan=3>
        <input type='text' class=ed name="wr_id" size=40 value='<?=$order[wr_id]?>'>
    </td>
</tr>

<tr class='ht'>
    <td>적립번호(bn_sr_id)</td>
    <td colspan=3>
        <input type='text' class=ed name="bn_sr_id" size=40 value='<?=$order[bn_sr_id]?>'>
    </td>
</tr>


<tr class='ht'>
    <td>입금확인시적립율(bn_rate)</td>
    <td colspan=3>
        <input type='text' class=ed name="bn_rate" size=40 value='<?=$order[bn_rate]?>'>
    </td>
</tr>

<tr><td colspan=4 class='line2'></td></tr>
</table>
<?


?>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>&nbsp;
    <input type=button class=btn1 value='  목  록  ' onclick="document.location.href='./pointmall_list.php?<?=$qstr?>';">
</form>

<script type='text/javascript'>
if (document.fgitc.w.value == '')
    document.fgitc.po_id.focus();
else
    document.fgitc.gr_subject.focus();

function fgitc_check(f)
{
    f.action = "./pointmall_form_update.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php");
?>
