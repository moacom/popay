<?
$sub_menu = "200100";
include_once("./_common.php");
auth_check($auth[$sub_menu], "w");

$token = get_token();

function get_type_select($data,$name,$id,$selected=''){
	$i=0;
	echo '<input type="hidden" name="'.$name.'" id="'.$id.'" value="'.$selected.'">';
	echo '<select name="'.$name.'_select" id="'.$id.'_select">';
	foreach ($data as $k => $v){
		if($k == $i){
			$k = $v;	
		}
		$selected_str = "";
		if($k == $selected){
			$selected_str = 'selected="selected"';
			$is_selected = true;
		}
		echo '<option value="'.$k.'" '.$selected_str.'>'.$v.'</option>';
		$i++;
	}
	if(!$is_selected){
		$selected_str = 'selected="selected"';
	}else{
		$selected_str = "";
	}
	echo '<option value="" '.$selected_str.'>�����Է�</option>';
	echo '</select>';
	
	echo '<script>';
	if(!$is_selected){
		echo '$("#'.$id.'").attr("type","text");';
		
	}
	
	echo '$("#'.$id.'_select").change(function(e) {';
	echo 'if($(this).val()==""){';
	echo '$("#'.$id.'").attr("type","text");';
	echo '}else{';
	echo '$("#'.$id.'").attr("type","hidden");';
	echo '$("#'.$id.'").val($(this).val());';
	echo '}';
	echo '});';
	
	
	echo '</script>';
}


if ($w == "") 
{
    $required_mb_id = "required minlength=3 alphanumericunderline itemname='ȸ�����̵�'";
    $required_mb_password = "required itemname='�н�����'";

    $mb[mb_mailling] = 1;
    $mb[mb_open] = 1;
    $mb[mb_level] = $config[cf_register_level];
    $html_title = "���";
}
else if ($w == "u") 
{
    $mb = get_member($mb_id);
    if (!$mb[mb_id])
        alert("�������� �ʴ� ȸ���ڷ��Դϴ�."); 

    if ($is_admin != 'super' && $mb[mb_level] >= $member[mb_level])
        alert("�ڽź��� ������ ���ų� ���� ȸ���� ������ �� �����ϴ�.");

    $required_mb_id = "readonly style='background-color:#dddddd;'";
    $required_mb_password = "";
    $html_title = "����";
	
	
	$sql_card = " select * from g4_card where cd_code ='".$mb['mb_4']."' ";
	$result_card = sql_fetch($sql_card);
	
	$sql_reco = " select * from g4_member where mb_name ='".$mb['mb_7']."' ";
	$result_reco = sql_fetch($sql_reco);
} 
else 
    alert("����� �� ���� �Ѿ���� �ʾҽ��ϴ�.");

if ($mb[mb_mailling]) $mailling_checked = "checked"; // ���� ����
if ($mb[mb_sms])      $sms_checked = "checked"; // SMS ����
if ($mb[mb_open])     $open_checked = "checked"; // ���� ����
if ($mb[mb_is_ad])     $is_ad_checked = "checked"; // ȫ�������
//if ($mb[mb_is_partner1])     $is_partner1_checked = "checked"; // ȫ�������
//if ($mb[mb_is_partner2])     $is_partner2_checked = "checked"; // ���������
//if ($mb[mb_is_partner3])     $is_partner3_checked = "checked"; // ��������
//if ($mb[mb_is_partner4])     $is_partner4_checked = "checked"; // ���������

$g4[title] = "ȸ������ " . $html_title;
include_once("./admin.head.php");
//echo $_SERVER['HTTP_REFERER']."<br/>";
//echo $_SERVER['HTTP_USER_AGENT']."<br/>";
//echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."<br/>";
//echo $_SERVER['REQUEST_METHOD'];

?>

<table width=100% align=center cellpadding=0 cellspacing=0>
<form name=fmember method=post onsubmit="return fmember_submit(this);" enctype="multipart/form-data" autocomplete="off">
<input type=hidden name=w     value='<?=$w?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<tr>
    <td colspan=4 class=title align=left><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> <?=$g4[title]?></td>
</tr>
<tr><td colspan=4 class=line1></td></tr>
<tr class='ht'>
    <td>���̵�</td>
    <td>
        <input type=text class=ed name='mb_id' id='mb_id' size=20 maxlength=20 minlength=2 <?=$required_mb_id?> itemname='���̵�' value='<? echo $mb[mb_id] ?>'>
        <?if ($w=="u"){?><a href='./boardgroupmember_form.php?mb_id=<?=$mb[mb_id]?>'>���ٰ��ɱ׷캸��</a><?}?>
        <?php if($w==''){?>
        <a href="javascript:member_check()">���̵��ߺ��˻�</a>
             <div id="asign_id" style="border:0px solid red;font-size:12px; color:#0269b6;"></div>
        <?php }?>
    </td>
    <td>�н�����</td>
    <td><input type=password class=ed name='mb_password' size=20 maxlength=20 <?=$required_mb_password?> itemname='��ȣ'></td>
</tr>
<tr class='ht'>
    <td>�̸�(�Ǹ�)</td>
    <td><input type=text class=ed name='mb_name' maxlength=20 minlength=2 required itemname='�̸�(�Ǹ�)' value='<? echo $mb[mb_name] ?>'><br/>'��������Ʈ����'�̶� �̸��� ȸ������'3'�� �ο��ϸ� �����ڷ� 495���� ����Ʈ�� ����</td>
    <td>����</td>
    <td>
	<?php 
	$data = array('ī��ȸ��','��üȸ��','�����ȸ��');
	echo get_type_select($data,'mb_nick','mb_nick',$mb['mb_nick']);
	?>
    <!--<input type=text class=ed id='mb_nick' name='mb_nick' maxlength=20 minlength=2 required itemname='����' value='<? echo $mb[mb_nick] ?>'>-->
    </td>
</tr>
<tr class='ht'>
    <td>ȸ�� ����</td>
    <td><?=get_member_level_select("mb_level", 1, $member[mb_level], $row[bo_list_level])?></td>
    <td>����Ʈ</td>
    <td><a href='./point_list.php?sfl=mb_id&stx=<?=$mb[mb_id]?>' class='bold'><?=number_format($mb[mb_point])?></a> ��/ <a href='./point2_list.php?sfl=mb_id&stx=<?=$mb[mb_id]?>' class='bold'><?=number_format($mb[mb_point2])?></a> ��/ <a href='./point3_list.php?sfl=mb_id&stx=<?=$mb[mb_id]?>' class='bold'><?=number_format($mb[mb_point3])?></a> ��</td>
</tr>
<tr class='ht'>
    <td>ȫ�������</td>
    <td><input type=checkbox name="mb_is_ad" id="mb_is_ad" value='1' <?=$is_ad_checked?>><label for="mb_is_ad">ȫ��������̸�üũ</label></td>
    <td>����</td>
    <td>
   	<?php 
	$data = array('TP�Ϲ�ȸ��','TP�����ȸ��','TP�븮��ȸ��','TP����ȸ��','TP����ȸ��','TP����ȸ��');
	echo get_type_select($data,'mb_cate','mb_cate',$mb['mb_cate']);
	?>
    <!--<input type=text class=ed id='mb_cate' name='mb_cate' maxlength=20 value='<? echo ($mb_cate && $w=="")?$mb_cate:$mb[mb_cate] ?>'>-->
    </td>
</tr>

<tr><td colspan="4" style="border-top:1px solid silver; padding-top:6px;"></td></tr>

<style>
.type_tp th, .type_tp td{ background-color:#696; color:#FFF; padding:5px;}
</style>


<tr class="type_tp"><th colspan="4">TP����� ����</th></tr>

<tr class='ht type_tp'>
    <th>��õ�� </th>
    <td><input type=text name="mb_tp_recom" id="mb_tp_recom" value='<?php echo $mb[mb_tp_recom] ?>'></td>
    <th>���������</th>
    <td><input type=text name="mb_tp_parent" id="mb_tp_parent" value='<?php echo $mb[mb_tp_parent] ?>'></td>
</tr>

<tr class='ht type_tp'>
	<th>���������</th>
	<td>
		<select name="mb_tp_floor" id="mb_tp_floor">
        	<option value='9' <?php echo ($mb[mb_tp_floor] == '9')?"selected":""?>>----</option>
            <option value='5' <?php echo ($mb[mb_tp_floor] == '5')?"selected":""?>>�Ϲݻ����</option>
            <option value='4' <?php echo ($mb[mb_tp_floor] == '4')?"selected":""?>>�븮�������</option>
            <option value='3' <?php echo ($mb[mb_tp_floor] == '3')?"selected":""?>>���������</option>
            <option value='2' <?php echo ($mb[mb_tp_floor] == '2')?"selected":""?>>��������</option>
            <option value='1' <?php echo ($mb[mb_tp_floor] == '1')?"selected":""?>>���������</option>
            <option value='0' <?php echo ($mb[mb_tp_floor] == '0')?"selected":""?>>����</option>
        </select>
	</td>
    <th></th>
    <td></td>
</tr>

<tr><td colspan="4" style="border-top:1px solid silver; padding-top:6px;"></td></tr>





<!--
<style>
.type_biz th, .type_biz td{ background-color:#C90; color:#FFF; padding:5px;}
</style>

<tr class="type_biz"><th colspan="4">TP����� ����2</th></tr>

<tr class='ht type_biz'>
    <th>��õ�� </th>
    <td><input type=text name="mb_biz_recom" id="mb_biz_recom" value='<?php echo $mb[mb_biz_recom] ?>'></td>
    <th>���������</th>
    <td><input type=text name="mb_biz_parent" id="mb_biz_parent" value='<?php echo $mb[mb_biz_parent] ?>'></td>
</tr>

<tr class='ht type_biz'>
	<th>���������</th>
	<td>
		<select name="mb_biz_floor" id="mb_biz_floor">
        	<option value='9' <?php echo ($mb[mb_biz_floor] == '9')?"selected":""?>>----</option>
            <option value='6' <?php echo ($mb[mb_biz_floor] == '6')?"selected":""?>>�Ϲݻ����</option>
            <option value='5' <?php echo ($mb[mb_biz_floor] == '5')?"selected":""?>>����</option>
            <option value='4' <?php echo ($mb[mb_biz_floor] == '4')?"selected":""?>>�븮�������</option>
            <option value='3' <?php echo ($mb[mb_biz_floor] == '3')?"selected":""?>>���������</option>
            <option value='2' <?php echo ($mb[mb_biz_floor] == '2')?"selected":""?>>��������</option>
            <option value='1' <?php echo ($mb[mb_biz_floor] == '1')?"selected":""?>>���������</option>
            <option value='0' <?php echo ($mb[mb_biz_floor] == '0')?"selected":""?>>����</option>
        </select>
	</td>
    <td></td>
    <td></td>
</tr>
<tr><td colspan="4" style="border-bottom:1px solid silver; padding-bottom:6px;"></td></tr>
-->

<tr class='ht'>
    <td>E-mail</td>
    <td><input type=text class=ed name='mb_email' size=40 maxlength=100  email itemname='e-mail' value='<? echo $mb[mb_email] ?>'></td>
    <td>Ȩ������</td>
    <td><input type=text class=ed name='mb_homepage' size=40 maxlength=255 itemname='Ȩ������' value='<? echo $mb[mb_homepage] ?>'></td>
</tr>
<tr class='ht'>
    <td>��ȭ��ȣ</td>
    <td><input type=text class=ed name='mb_tel' maxlength=20 itemname='��ȭ��ȣ' value='<? echo $mb[mb_tel] ?>'></td>
    <td>�ڵ�����ȣ</td>
    <td><input type=text class=ed name='mb_hp' maxlength=20 itemname='�ڵ�����ȣ' value='<? echo $mb[mb_hp] ?>'></td>
</tr>
<tr class='ht'>
    <td>�ּ�</td>
    <td>
        <input type=text class=ed name='mb_zip1' size=4 maxlength=3 readonly itemname='�����ȣ ���ڸ�' value='<? echo $mb[mb_zip1] ?>'> -
        <input type=text class=ed name='mb_zip2' size=4 maxlength=3 readonly itemname='�����ȣ ���ڸ�' value='<? echo $mb[mb_zip2] ?>'>
        <a href="javascript:;" onclick="win_zip('fmember', 'mb_zip1', 'mb_zip2', 'mb_addr1', 'mb_addr2');"><img src='<?=$g4[bbs_img_path]?>/btn_zip.gif' align=absmiddle border=0></a>
        <br><input type=text class=ed name='mb_addr1' size=40 readonly value='<? echo $mb[mb_addr1] ?>'>
        <br><input type=text class=ed name='mb_addr2' size=25 itemname='���ּ�' value='<? echo $mb[mb_addr2] ?>'> ���ּ� �Է�</td>
    <td>ȸ��������</td>
    <td colspan=3>
        <input type=file name='mb_icon' class=ed><br>�̹��� ũ��� <?=$config[cf_member_icon_width]?>x<?=$config[cf_member_icon_height]?>���� ���ּ���.
        <?
        $mb_dir = substr($mb[mb_id],0,2);
        $icon_file = "$g4[path]/data/member/$mb_dir/$mb[mb_id].gif";
        if (file_exists($icon_file)) {
            echo "<br><img src='$icon_file' align=absmiddle>";
            echo " <input type=checkbox name='del_mb_icon' value='1' class='csscheck'>����";
        }   
        ?>
    </td>
</tr>
<tr class='ht'>
    <td>�������</td>
    <td><input type=text class=ed name=mb_birth size=9 maxlength=6 value='<? echo $mb[mb_birth] ?>'>-<input type=text class=ed name=mb_birth2 size=9 maxlength=6 value='<? echo $mb[mb_birth2] ?>'></td>
    <td>����</td>
    <td>
        <select name=mb_sex><option value=''>----<option value='F'>����<option value='M'>����</select>
        <script type="text/javascript"> document.fmember.mb_sex.value = "<?=$mb[mb_sex]?>"; </script></td>
</tr>
<tr class='ht'>
    <td>���� ����</td>
    <td><input type=checkbox name=mb_mailling value='1' <?=$mailling_checked?>> ���� ������ ����</td>
    <td>SMS ����</td>
    <td><input type=checkbox name=mb_sms value='1' <?=$sms_checked?>> ���ڸ޼����� ����</td>
</tr>
<tr class='ht'>
    <td>���� ����</td>
    <td colspan=3><input type=checkbox name=mb_open value='1' <?=$open_checked?>> Ÿ�ο��� �ڽ��� ������ ����</td>
</tr>
<tr class='ht'>
    <td>����</td>
    <td><textarea class=ed name=mb_signature rows=5 style='width:99%; word-break:break-all;'><? echo $mb[mb_signature] ?></textarea></td>
    <td>�ڱ� �Ұ�</td>
    <td><textarea class=ed name=mb_profile rows=5 style='width:99%; word-break:break-all;'><? echo $mb[mb_profile] ?></textarea></td>
</tr>
<tr class='ht'>
    <td>�޸�</td>
    <td colspan=3><textarea class=ed name=mb_memo rows=5 style='width:99%; word-break:break-all;'><? echo $mb[mb_memo] ?>
    </textarea></td>
</tr>

<? if ($w == "u") { ?>
<tr class='ht'>
    <td>ȸ��������</td>
    <!--<td><?=$mb[mb_datetime]?></td>-->
    <td><input type="datetime" name=mb_datetime value="<?=$mb[mb_datetime]?>" />
    </td>
    <td>�ֱ�������</td>
    <td><?=$mb[mb_today_login]?></td>
</tr>
<tr class='ht'>
    <td>IP</td>
    <td><?=$mb[mb_ip]?></td>
    
    <? if ($config[cf_use_email_certify]) { ?>
    <td>�����Ͻ�</td>
    <td><?=$mb[mb_email_certify]?> 
        <? if ($mb[mb_email_certify] == "0000-00-00 00:00:00") { echo "<input type=checkbox name=passive_certify>��������"; } ?></td>
    <? } else { ?>
    <td></td>
    <td></td>
    <? } ?>

</tr>
<? } ?>

<? if ($config[cf_use_recommend]) { // ��õ�� ��� ?>
<tr class='ht'>
    <td>��õ��</td>
    <td colspan=3><?=($mb[mb_recommend] ? get_text($mb[mb_recommend]) : "����"); // 081022 : CSRF ���� �������� ���� �ڵ� ���� ?></td>
</tr>
<? } ?>

<tr class='ht'>
    <td>Ż������</td>
    <td><input type=text class=ed name=mb_leave_date size=9 maxlength=8 value='<? echo $mb[mb_leave_date] ?>'></td>
    <td>������������</td>
    <td><input type=text class=ed name=mb_intercept_date size=9 maxlength=8 value='<? echo $mb[mb_intercept_date] ?>'> <input type=checkbox value='<? echo date("Ymd"); ?>' onclick='if (this.form.mb_intercept_date.value==this.form.mb_intercept_date.defaultValue) { this.form.mb_intercept_date.value=this.value; } else { this.form.mb_intercept_date.value=this.form.mb_intercept_date.defaultValue; } '>����</td>
</tr>

<tr class='ht'>
    <td>ȸ����ȣ</td>
    <td><input type=text class=ed name='mb_reg' maxlength=20 itemname='ȸ����ȣ' value='<? echo $mb[mb_reg] ?>'></td>
    <td>����Ƚɹ�ȣ</td>
    <td><input type=text class=ed name='mb_0504' maxlength=25 itemname='����Ƚɹ�ȣ' value='<? echo $mb[mb_0504] ?>'></td>
</tr>

<? for ($i=1; $i<=10; $i=$i+2) { $k=$i+1; ?>
<tr class='ht'>
    <td>
	<? if($i==5){?>ȯ����
	<? }elseif($i==7){?>��õ��
	<? }elseif($i==3){?>����
	<? }elseif($i==1){?>�����
	<? }elseif($i==9){?>��õ��ID
	<? }else{?>���� �ʵ� <?=$i?><? }?></td>
    <td><input type=text class=ed style='width:99%;' id='mb_<?=$i?>' name='mb_<?=$i?>' maxlength=255 value='<?=$mb["mb_$i"]?>'></td>
    <td>
	<? if($k==8){?>����(�� �������Ʈ)
	<? }elseif($k==2){?>���¹�ȣ
	<? }elseif($k==4){?><a href="/adm/card_form.php?w=u&cd_id=<?php echo $result_card['cd_id']?>">ī���ȣ</a>
	<? }elseif($k==6){?>��������ȣ
	<? }elseif($k==10){?>������
    <? }else{?>���� �ʵ� <?=$k?><? }?></td>
    
    <td><input type=text class=ed style='width:99%;' name='mb_<?=$k?>' maxlength=255 value='<?=$mb["mb_$k"]?>'></td>
</tr>

<? } ?>

<? if ($w == "") { ?>
<tr class='ht'>
    <td>SMS</td>
    <td colspan="3">
    <input type="checkbox" name="is_sms" value="1" />
    <input type="text" name="sms_msg"  style='width:90%;'  value="����Ʈ���� ����ڷ� ���ԵǼ̽��ϴ�." />
    </td>
</tr>

<? }?>
<tr class='ht'>
    <td>����ī���</td>
    <td><input type=text class=ed name='mb_ctotal' size=40 maxlength=255 readonly itemname='����ī���' value='<? echo $mb[mb_ctotal] ?>'></td>
    <td>���ī���</td>
    <td><input type=text class=ed name='mb_cused' size=40 maxlength=255 readonly itemname='���ī���' value='<? echo $mb[mb_cused] ?>'></td>
</tr>
<?php
	$mb_geo = explode(',',$mb[mb_geo]);
?>
<tr class='ht'>
    <td>GPS��ǥ��</td>
    <td><input type="text" class=ed size=40 name=mb_geo1 value="<?=$mb_geo[0].",".$mb_geo[1]?>" />
    </td>
    <td>GPS�ּ�(��)</td>
    <td><input type="text" class=ed name=mb_geo2 value="<?=$mb_geo[2]?>" />
    </td>
</tr>
<tr class='ht'>
    <td>GPS�ּ�(��)</td>
    <td><input type="text" class=ed name=mb_geo3 value="<?=$mb_geo[3]?>" />
    </td>
    <td>GPS�ּ�(��)</td>
    <td><input type="text" class=ed name=mb_geo4 value="<?=$mb_geo[4]?>" />
    </td>
</tr>
<tr class='ht'>
    <td>��籸��</td>
    <td><input type="text" class=ed name=mb_area value="<?=$mb['mb_area']?>" />
    </td>
    <td>����project</td>
    <td>
  	<?php 
		$data = array('hlzone','mcard','intro','root');
		echo get_type_select($data,'mb_project','mb_project',$mb['mb_project']);
	?>
    <!--<input type="text" class=ed name=mb_project value="<?=$mb['mb_project']?>" />-->
    </td>
</tr>



<tr><td colspan=4 class=line2></td></tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  Ȯ    ��  '>&nbsp;
    <input type=button class=btn1 value='  ��  ��  ' onclick="document.location.href='./member_list.php?<?=$qstr?>';">&nbsp;
    
    <? if ($w != '') { ?>
    <input type=button class=btn1 value='  ��  ��  ' onclick="del('./member_delete.php?<?=$qstr?>&w=d&mb_id=<?=$mb[mb_id]?>&url=<?=$_SERVER[PHP_SELF]?>');">&nbsp;
    <? } ?>
</form>
<script type='text/javascript'>


function member_check(){
		 //alert("aaa");
	if($("#mb_id").val() != ""){
		 var this_value = $("#mb_id").val();
		 //$.mobile.showPageLoadingMsg("b", "���� Ȯ�� ��...");
		 $.ajax(         
		 {
				   url : '../onep/member_check.ajax.m.php',                        
				   dataType: 'json',                                                 
				   type: "POST",                                                      
				   data : 'keyword='+this_value,                                  
				   success:function(data, textStatus, jqXHR){    
				   //$.mobile.hidePageLoadingMsg();
						   if(data['result']){
								$("#asign_id").html("ȸ�������̵� ȸ���Դϴ�. <a href='/adm/member_form.php?&w=u&mb_id="+data['data2'][0]['mb_id']+"'>ȸ����������</a>");
							}else {
								$("#asign_id").html("��ȸ���Դϴ�.");
							}
				   }
		 });
			e.preventDefault(); //STOP default action
			e.unbind(); //unbind. to stop multiple form submit.
	} //if($("#mb_id3").val() != "")
}



if (document.fmember.w.value == "")
    document.fmember.mb_id.focus();
else if (document.fmember.w.value == "u")
    document.fmember.mb_password.focus();

if (typeof(document.fmember.mb_level) != "undefined") 
    document.fmember.mb_level.value   = "<?=$mb[mb_level]?>"; 

function fmember_submit(f)
{
	if(document.fmember.mb_nick.value == '�����ȸ��' && document.fmember.mb_8.value == ''){
		alert('�����ȸ���ǰ�� �������� �ʼ��Դϴ�.');
		document.fmember.mb_8.focus();
		return false;
	}
    if (!f.mb_icon.value.match(/\.(gif|jp[e]g|png)$/i) && f.mb_icon.value) {
        alert('�������� �̹��� ������ �ƴմϴ�. (bmp ����)');
        return false;
    }

    f.action = './member_form_update.php';
    return true;
}
</script>

<?
include_once("./admin.tail.php");
?>
