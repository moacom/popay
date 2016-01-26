<?
$sub_menu = "200100";
include_once("./_common.php");
$is_sms = $_POST[is_sms];
$sms_msg = $_POST[sms_msg];
if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

$mb_geo = $_POST[mb_geo1].",".$_POST[mb_geo2].",".$_POST[mb_geo3].",".$_POST[mb_geo4];
$mb_id = mysql_real_escape_string(trim($_POST['mb_id']));
$_POST['mb_8'] = str_replace("지점","",$_POST['mb_8']);
$cd_recommend = '';
if($_POST['mb_tp_recom']){
	$cd_recommend = $_POST['mb_tp_recom'];
}elseif($_POST['mb_9']){
	$cd_recommend = $_POST['mb_9'];
}

/*
				mb_is_partner1	= '$_POST[mb_is_partner1]',
				mb_partner1		= '$_POST[mb_partner1]',
				mb_is_partner2	= '$_POST[mb_is_partner2]',
				mb_partner2		= '$_POST[mb_partner2]',
				mb_is_partner3	= '$_POST[mb_is_partner3]',
				mb_partner3		= '$_POST[mb_partner3]',
				mb_is_partner4	= '$_POST[mb_is_partner4]',
				mb_partner4		= '$_POST[mb_partner4]',
*/

$sql_common = " mb_name         = '$_POST[mb_name]',
                mb_nick         = '$_POST[mb_nick]',
                mb_email        = '$_POST[mb_email]',
                mb_homepage     = '$_POST[mb_homepage]',
                mb_tel          = '$_POST[mb_tel]',
                mb_hp           = '$_POST[mb_hp]',
                mb_zip1         = '$_POST[mb_zip1]',
                mb_zip2         = '$_POST[mb_zip2]',
                mb_addr1        = '$_POST[mb_addr1]',
                mb_addr2        = '$_POST[mb_addr2]',
                mb_birth        = '$_POST[mb_birth]',
				mb_birth2       = '$_POST[mb_birth2]',
                mb_sex          = '$_POST[mb_sex]',
                mb_signature    = '$_POST[mb_signature]',
                mb_leave_date   = '$_POST[mb_leave_date]',
                mb_intercept_date='$_POST[mb_intercept_date]',
                mb_memo         = '$_POST[mb_memo]',
                mb_mailling     = '$_POST[mb_mailling]',
                mb_sms          = '$_POST[mb_sms]',
                mb_open         = '$_POST[mb_open]',
                mb_profile      = '$_POST[mb_profile]',
                mb_level        = '$_POST[mb_level]',
                mb_1            = '$_POST[mb_1]',
                mb_2            = '$_POST[mb_2]',
                mb_3            = '$_POST[mb_3]',
                mb_4            = '$_POST[mb_4]',
                mb_5            = '$_POST[mb_5]',
                mb_6            = '$_POST[mb_6]',
                mb_7            = '$_POST[mb_7]',
                mb_8            = '$_POST[mb_8]',
                mb_9            = '$_POST[mb_9]',
                mb_10           = '$_POST[mb_10]', 
                mb_reg          = '$_POST[mb_reg]',
				mb_ctotal		= '$_POST[mb_ctotal]',
				mb_cused		= '$_POST[mb_cused]',
				mb_0504			= '$_POST[mb_0504]',
				mb_is_ad		= '$_POST[mb_is_ad]',
				mb_cate			= '$_POST[mb_cate]',
				mb_area			= '$_POST[mb_area]',
				mb_project		= '$_POST[mb_project]',
				mb_tp_recom		= '$_POST[mb_tp_recom]',
				mb_tp_parent	= '$_POST[mb_tp_parent]',
				mb_tp_floor		= '$_POST[mb_tp_floor]',
				mb_biz_recom	= '$_POST[mb_biz_recom]',
				mb_biz_parent	= '$_POST[mb_biz_parent]',
				mb_biz_floor	= '$_POST[mb_biz_floor]',
				mb_geo			= '$mb_geo'";

if ($w == "")
{
    $mb = get_member($mb_id);
    if ($mb[mb_id])
        alert("이미 존재하는 회원입니다.\\n\\nＩＤ : $mb[mb_id]\\n\\n이름 : $mb[mb_name]\\n\\n별명 : $mb[mb_nick]\\n\\n메일 : $mb[mb_email]");

    sql_query(" insert into $g4[member_table] set mb_id = '$mb_id', mb_password = '".sql_password($mb_password)."', mb_datetime = '$g4[time_ymdhis]', mb_ip = '$_SERVER[REMOTE_ADDR]', mb_email_certify = '$g4[time_ymdhis]', $sql_common  ");
	
	
	if (("가상포인트계정" == $mb[mb_nick])&&(3 == $mb_level))
		insert_point($mb_id, "1650000", "가상포인트계정 세팅", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
	      
		insert_point($mb_id, '1000', '적립포인트(기본포인트적립)', '@passive', $mb_id, "moa-".uniqid(""));
//	if($_POST[is_sms]){
//		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
//		$result=$sms->SendSMS("moamoa1234","yein6510",$str_service_sms,$_POST[mb_hp],$_POST[is_sms]);// 5개의 인자로 함수를 호출합니다.
//	}
		
		
		
		//카드추가 부분
		$sql_card = " select * from g4_card where mb_id1='' and mb_id2='' and mb_id3='' order by cd_id asc";
		$row_card = sql_fetch($sql_card);
		if($_POST[mb_level] == 3 && $_POST[mb_nick] == "사업자회원"){
			$mb_id1 = $mb_id;
			$sql_mc = "select * from g4_merchants where mc_subject = '".mysql_real_escape_string('MP'.$_POST['mb_8'].'지점')."' ";
			$row_mc = sql_fetch($sql_mc);
			$mb_id2 = $row_mc['mc_id'];
			if(!$row_mc && $_POST['mb_8']){
				$sql = "insert into g4_merchants set mc_datetime='$g4[time_ymdhis]',mb_id='moa',mc_subject='".mysql_real_escape_string('MP'.$_POST['mb_8'].'지점')."',mb_id1='moa' ";
				sql_query($sql);
				$mb_id2 = mysql_insert_id();
			}
		}
		if(!$mb_id2){
			$mb_id2 = "95";
		}
		if(!$mb_id1){
			$mb_id1 = "moa";
		}
		
		
		if($row_card['cd_id']){//원래 $_POST[mb_9] 인데 사업자의 카드의 경우 사업자에게 본사가받는 10%를 주기때문에 사업자란에 사업자id를 넣는다.
			sql_query("update g4_card set mb_id1='$mb_id1', mb_id2='".$mb_id2."', mb_id3='$mb_id', cd_datetime = '$g4[time_ymdhis]' where cd_id = '".$row_card['cd_id']."' ,cd_recommend='$cd_recommend' ");
		}else{//if($row_card['cd_id'])
			$sql = " select cd_code from g4_card order by cd_code desc limit 0, 1";
			$new_card = sql_fetch($sql);
			$new_cd_code = substr($new_card[cd_code],0,7).(substr($new_card[cd_code],7,9) +1);
			sql_query("insert g4_card set cd_code = '$new_cd_code', cd_datetime = '$g4[time_ymdhis]',mb_id = 'moa', cd_datetime1 = '$g4[time_ymdhis]', mb_id1 = '$mb_id1', mb_id2 = '$mb_id2', mb_id3 = '$mb_id',cd_recommend = '$cd_recommend' ");
			$row_card['cd_code'] = $new_cd_code;
		}//if(!$row_card['cd_id'])
		sql_query("update $g4[member_table] set mb_4 = '".$row_card['cd_code']."' where mb_id = '".$mb_id."'");
		$mb_cused = sql_fetch(" select count(*) as cnt from g4_card where mb_id1 = '".$row_card['mb_id1']."' ");
		sql_query(" update $g4[member_table] set mb_cused = '".$mb_cused['cnt']."' where mb_id = '".$row_card['mb_id1']."' ");
						
		$mb_card = sql_fetch("select count(*) as cnt from g4_card where mb_id3 = '$mb_id'");
		sql_query("update $g4[member_table] set mb_card = '$mb_card[cnt]' where mb_id = '$mb_id' ");
		//카드추가 부분
		if($is_sms == "1"){
			if($_POST[mb_hp]){
				$get_pe = $_POST[mb_hp];
			} elseif($_POST[mb_tel]){
				$get_pe = $_POST[mb_tel];
			} else {
				$get_pe = $_POST[mb_id];
			}

			$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL");
			$result=$sms->SendSMS("moamoa1234","yein6510",$str_service_sms,"$get_pe","$sms_msg".PHP_EOL."".PHP_EOL."http://moapoint.kr/");
		}

	insert_groupmember_by_mb_project($mb_id);
	
	
	insert_log($mb_id." 회원을 생성하였습니다.","c");
}
else if ($w == "u")
{
    $mb = get_member($mb_id);
    if (!$mb[mb_id])
        alert("존재하지 않는 회원자료입니다.");

    if ($is_admin != "super" && $mb[mb_level] >= $member[mb_level])
        alert("자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.");

    if ($_POST[mb_id] == $member[mb_id] && $_POST[mb_level] != $mb[mb_level])
        alert("$mb[mb_id] : 로그인 중인 관리자 레벨은 수정 할 수 없습니다.");

    $mb_dir = substr($mb_id,0,2);

    // 회원 아이콘 삭제
    if ($del_mb_icon)
        @unlink("$g4[path]/data/member/$mb_dir/$mb_id.gif");

    // 아이콘 업로드
    if (is_uploaded_file($_FILES[mb_icon][tmp_name])) {
        if (!preg_match("/(\.gif)$/i", $_FILES[mb_icon][name])) {
            alert($_FILES[mb_icon][name] . '은(는) gif 파일이 아닙니다.');
        }

        if (preg_match("/(\.gif)$/i", $_FILES[mb_icon][name])) {
            @mkdir("$g4[path]/data/member/$mb_dir", 0707);
            @chmod("$g4[path]/data/member/$mb_dir", 0707);

            $dest_path = "$g4[path]/data/member/$mb_dir/$mb_id.gif";

            move_uploaded_file($_FILES[mb_icon][tmp_name], $dest_path);
            chmod($dest_path, 0606);

            if (file_exists($dest_path)) {
                $size = getimagesize($dest_path);
                // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                if ($size[0] > $config[cf_member_icon_width] || $size[1] > $config[cf_member_icon_height]) {
                    @unlink($dest_path);
                }
            }
        }
    }

    if ($mb_password)
        $sql_password = " , mb_password = '".sql_password($mb_password)."' ";
    else
        $sql_password = "";

    if ($passive_certify)
        $sql_certify = " , mb_email_certify = '$g4[time_ymdhis]' ";
    else
        $sql_certify = "";

    if ($_POST['mb_datetime']){
        $sql_datetime = " , mb_datetime = '$_POST[mb_datetime]' ";
	}
		
    $sql = " update $g4[member_table]
                set $sql_common
                    $sql_password
					$sql_datetime
                    $sql_certify
              where mb_id = '$mb_id' ";
    sql_query($sql);
	insert_log($mb[mb_id]." 회원을 수정하였습니다.","u");
}
else
    alert("제대로 된 값이 넘어오지 않았습니다.");


	goto_url("./member_form.php?$qstr&w=u&mb_id=$mb_id");
?>