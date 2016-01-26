<?
$sub_menu = "200290";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4['title'] = '엑셀파일로 등록';
include_once ("./admin.head.php");

?>

<link rel="stylesheet" href="../plugin/bootstrap/css/bootstrap.min.css">
<ul class="nav nav-tabs">
  <li role="presentation"><a href="./smarthome_list.php">스마트홈쇼핑관리</a></li>
  <li role="presentation" class="active"><a href="./smarthome_list_excel.php">스마트홈쇼핑관리 엑셀일괄등록</a></li>
</ul>

<div class="new_win">
    <h1><?php echo $g4['title']; ?></h1>

    <div class="local_desc01 local_desc">
        <p>
            엑셀파일을 이용하여 일괄등록할 수 있습니다.<br>
            형식은 <strong>해당일괄등록용 엑셀파일</strong>을 다운로드하여 정보를 입력하시면 됩니다.<br>
            수정 완료 후 엑셀파일을 업로드하시면 일괄등록됩니다.<br>
            엑셀파일을 저장하실 때는 <strong>Excel 97 - 2003 통합문서 (*.xls)</strong> 로 저장하셔야 합니다.
        </p>
        <p>
        	<a href="../lib/Excel/orderlist_excel2.xls">스마트홈쇼핑관리 엑셀파일 다운로드</a><br />
        </p>
    </div>

    <form name="fitemexcel" id="fitemexcel" method="post" action="./excel_form_update.php" onsubmit="excelfrom_submit(this.form)" enctype="MULTIPART/FORM-DATA" autocomplete="off">
    <input type="hidden" id="table_sel" name="table_sel" value="order_list" />
    
    <div id="excelfile_upload">
		<label for="excelfile">파일선택</label>
        <input type="file" name="excelfile" id="excelfile" required>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="엑셀파일 등록" class="btn_submit">
        <input type="button" id="excel_view_btn" value="엑셀파일 보기" class="btn_submit" style="display:none">
    </div>

    </form>
 
</div>

<script>
function excelfrom_submit(f){
	$(".btn_submit").attr("disabled",true);
}
$(".btn_submit").click(function(e) {
	//$(".btn_submit").attr("disabled",true);
	//$("#fitemexcel").submit();
});
$("#excel_view_btn").click(function(e){
    $("#fitemexcel").attr("action","excel_form_view.php");
	$("#fitemexcel").submit();
});
</script>
<?php
include_once ("./admin.tail.php");
?>
