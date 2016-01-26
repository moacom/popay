<?
$sub_menu = "200290";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4['title'] = '�������Ϸ� ���';
include_once ("./admin.head.php");

?>

<link rel="stylesheet" href="../plugin/bootstrap/css/bootstrap.min.css">
<ul class="nav nav-tabs">
  <li role="presentation"><a href="./smarthome_list.php">����ƮȨ���ΰ���</a></li>
  <li role="presentation" class="active"><a href="./smarthome_list_excel.php">����ƮȨ���ΰ��� �����ϰ����</a></li>
</ul>

<div class="new_win">
    <h1><?php echo $g4['title']; ?></h1>

    <div class="local_desc01 local_desc">
        <p>
            ���������� �̿��Ͽ� �ϰ������ �� �ֽ��ϴ�.<br>
            ������ <strong>�ش��ϰ���Ͽ� ��������</strong>�� �ٿ�ε��Ͽ� ������ �Է��Ͻø� �˴ϴ�.<br>
            ���� �Ϸ� �� ���������� ���ε��Ͻø� �ϰ���ϵ˴ϴ�.<br>
            ���������� �����Ͻ� ���� <strong>Excel 97 - 2003 ���չ��� (*.xls)</strong> �� �����ϼž� �մϴ�.
        </p>
        <p>
        	<a href="../lib/Excel/orderlist_excel2.xls">����ƮȨ���ΰ��� �������� �ٿ�ε�</a><br />
        </p>
    </div>

    <form name="fitemexcel" id="fitemexcel" method="post" action="./excel_form_update.php" onsubmit="excelfrom_submit(this.form)" enctype="MULTIPART/FORM-DATA" autocomplete="off">
    <input type="hidden" id="table_sel" name="table_sel" value="order_list" />
    
    <div id="excelfile_upload">
		<label for="excelfile">���ϼ���</label>
        <input type="file" name="excelfile" id="excelfile" required>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="�������� ���" class="btn_submit">
        <input type="button" id="excel_view_btn" value="�������� ����" class="btn_submit" style="display:none">
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
