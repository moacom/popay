<?
$sub_menu = "200290";
include_once("./_common.php");
$this_table = "g4_board_order2";

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

//exit();
$msg = '';
$qstr .= "&delivery=".$delivery;
$qstr .= "&payment=".$payment;
$qstr.="&bn_datetime_s=$bn_datetime_s";
$qstr.="&bn_datetime_e=$bn_datetime_e";
$qstr.="&paytype=$paytype";

for ($i=0; $i<count($chk); $i++) 
{
    // ���� ��ȣ�� �ѱ�
    $k = $chk[$i];
	$sql = "select * from $this_table where bn_id = '{$_POST[bn_id][$k]}' ";
		
	$bn = sql_fetch($sql);
	
	if($bn['is_cancel'] == "1") {	
		$msg .= "$bn[bn_id] : ��� ó���� �Ǿ� �Ա�Ȯ���� �Ͻ� �� �����ϴ�.\\n";
	} else if($bn['confirmdate'] && $bn['confirmdate'] != "0000-00-00") {
		$msg .= "$bn[bn_id] : �̹� �Ա�Ȯ���� �Ǿ����ϴ�.\\n";
	} else {
	
	
	
	
	if($bn['mb_id']){ // �������ֱ�
		$mb = get_member($bn['mb_id']);
		$cd = get_cd_by_code($mb['mb_4']);
		$mc_ = get_merchants('1533');
		$mc = get_merchants($cd[mb_id2]);

		
		
		if($bn['bo_table'] && !$bn['total_price']){

			$sql_bo = " SELECT * FROM `g4_write_".$bn[bo_table]."` where wr_id='$bn[wr_id]'  ";
			$bn_bo = sql_fetch($sql_bo);
								
			$temp_ = explode("(",$bn['orderlist']);
			$object_count = str_replace("��)","",$temp_[(count($temp_)-1)]);
			$object = str_replace("(".$temp_[(count($temp_)-1)],"",$bn['orderlist']);
			$price = $object_count * $bn_bo['wr_4'];
		}else
			$price = $bn['total_price'];

		
		
		
		if($bn['pay_type'] == "point4"){ // ��������Ʈ�� ����ó�����ֱ�..
			if($mb['mb_point4'] >= $price){
				$po_point_temp = $price * -1;
				$po_content = '��������Ʈ����:'.$bn['bn_id'];
				insert_point4($mb['mb_id'], $po_point_temp, $po_content, '@passive', $mb['mb_id'], $member[mb_id]."-".uniqid(""));
			}else{
				$msg .= $bn['bn_id'].'�� ���Ű� ��������Ʈ('.number_format($mb['mb_point4']).'P)�� �����ұݾ�('.number_format($price).'��)���� �����մϴ�.';
				continue;
			}
		}	
		
		
		
		if($cd[rt_id]){
			$result = get_rate($cd[rt_id]);
		}else{
			$result = get_rate('1');
		}
		
			$cd_share_rate_array = array();
			$cd_share_rate = explode(",",$cd[cd_share_rate]);
			$result_temp = array_keys($result);
			
			for($j=0;$j<count($cd_share_rate);$j++){
				$sum = $j+4;
				if($cd_share_rate[$j]!=""){
				$result[$result_temp[$sum]] = $cd_share_rate[$j];
				}
			}
		
		
		$mc = get_merchants($cd[mb_id2]);
		//echo $mc[mc_subject];
			if($mc[mc_manager_rate] > 0 && $mc[mc_manager]){
					//			$price_42_rate =  $price_42_value / $price_1_value * 100;
					//			$price_41_rate =  $price_41_value / $price_1_value * 100;
					$result[price_42_rate] =  $result[price_4_rate] * $mc[mc_manager_rate] / 100;
					$result[price_41_rate] =  $result[price_4_rate] - $result[price_42_rate];
			}
			
			if(!$mc[mc_manager]){// ��������ڰ� ���������� ����ڰ� 10% �� �Ծ����..
					$result[price_41_rate] = $result[price_4_rate];
					$result[price_42_rate] = 0;
			}
		
			$share_id = get_tp_parents($cd[mb_id1],$result);
			if($share_id[1]){
				$result[price_61_rate] = 0;
				$result[price_52_rate] = 0;
			}else{
				$result[price_56_rate] = 0;
				$result[price_57_rate] = 0;
			}
		
				$po_point = $price;
				$price_type = $bn['pay_type']; //������
				$rt_id = $cd['rt_id'];
				if($bn['bn_rate']){
					$price_rate_value = $bn['bn_rate'];
				}else{
					$price_rate_value = $mc_['mc_rate_cash']; //������
				}
				
				
		
		
			
			
			//��������
				$price_1_rate = $result['price_1_rate']; //��ü
				$price_2_rate = $result['price_2_rate']; //ī��
				$price_3_rate = $result['price_3_rate']; //��ü
				$price_4_rate = $result['price_4_rate']; //�����
				$price_41_rate = $result['price_41_rate']; //�Ұ���(��ġ�����)
				$price_42_rate = $result['price_42_rate']; //���������
				
				$price_5_rate = $result['price_5_rate']; //����
				$price_51_rate = $result['price_51_rate']; //���� ($jijim[$member[mb_8]])
				$price_52_rate = $result['price_52_rate']; //����(moa4)
				$price_53_rate = $result['price_53_rate']; //�븮��A
				$price_54_rate = $result['price_54_rate']; //�븮��B
				$price_55_rate = $result['price_55_rate']; //�븮�������
				$price_56_rate = $result['price_56_rate']; //��������
				$price_57_rate = $result['price_57_rate']; //���������
				
				$price_6_rate = $result['price_6_rate']; //���� 
				$price_61_rate = $result['price_61_rate']; //����(moa3)
				$price_62_rate = $result['price_62_rate']; //����(moa2) -> ���� - > ���������
				$price_63_rate = $result['price_63_rate']; //��Ƽ���ʽ�(moa1) -> ��
				$price_64_rate = $result['price_64_rate']; //����(moa)
				$price_65_rate = $result['price_65_rate']; //��ü
				$price_66_rate = $result['price_66_rate']; //��ü�Ұ���
			//������������	


				$price_1_value = $price * ($price_rate_value / 100); //��ü
				if($price_rate_value > 100) $price_1_value = $price_rate_value * $bn['count'];
				
				$price_2_value = $price_1_value * ($price_2_rate / 100); //ī��
				$price_3_value = $price_1_value * ($price_3_rate / 100); //��ü
				$price_4_value = $price_1_value * ($price_4_rate / 100); //�����
				$price_41_value = $price_1_value * ($price_41_rate / 100); //�Ұ���(��ġ�����)
				$price_42_value = $price_1_value * ($price_42_rate / 100); //���������	
				$price_5_value = $price_1_value * ($price_5_rate / 100); //����
				$price_51_value = $price_1_value * ($price_51_rate / 100); //���� ($jijim[$member[mb_8]])
				$price_52_value = $price_1_value * ($price_52_rate / 100); //����(moa4)
				$price_53_value = $price_1_value * ($price_53_rate / 100); //�븮��A
				$price_54_value = $price_1_value * ($price_54_rate / 100); //�븮��B
				$price_55_value = $price_1_value * ($price_55_rate / 100); //�����븮��
				$price_56_value = $price_1_value * ($price_56_rate / 100); //��������
				$price_57_value = $price_1_value * ($price_57_rate / 100); //��������
				
				
				$price_6_value = $price_1_value * ($price_6_rate / 100); //���� 
				$price_61_value = $price_1_value * ($price_61_rate / 100); //����(moa3)
				$price_62_value = $price_1_value * ($price_62_rate / 100); //����(moa2)
				$price_63_value = $price_1_value * ($price_63_rate / 100); //��Ƽ���ʽ�(moa1)
				$price_64_value = $price_1_value * ($price_64_rate / 100); //����(moa)
				$price_65_value = $price_1_value * ($price_65_rate / 100); //��ü
				$price_66_value = $price_1_value * ($price_66_rate / 100); //��ü�Ұ���		


				$is_testing=false;	
				if($mc[mc_id]=="1") $is_testing=true; //�׽�Ʈ �������϶� ������Ʈ ó���� �Ͼ�� �ʵ��� ó��
				$sql = "insert into g4_share set mb_id = '$member[mb_id]',mc_id = '$mc_[mc_id]', sr_datetime='$g4[time_ymdhis]',cd_id='$cd[cd_id]',po_point='$po_point',price_type='$price_type',price_rate_value='$price_rate_value',price_1_value='$price_1_value',price_2_value='$price_2_value',price_3_value='$price_3_value',price_4_value='$price_4_value',price_41_value='$price_41_value',price_42_value='$price_42_value', price_5_value='$price_5_value', price_51_value='$price_51_value', price_52_value='$price_52_value', price_53_value='$price_53_value', price_54_value='$price_54_value', price_55_value='$price_55_value', price_56_value='$price_56_value', price_57_value='$price_57_value',price_6_value='$price_6_value', price_61_value='$price_61_value', price_62_value='$price_62_value', price_63_value='$price_63_value', price_64_value='$price_64_value',price_65_value='$price_65_value',price_66_value='$price_66_value', sr_is_pos = '$sr_is_pos',rt_id='$rt_id' ";		
				if(!$is_testing) sql_query($sql);
				$share_uniq = mysql_insert_id();
				//�������� ����Ƚ�����		
				$mc_count = $mc_['mc_count'] + 1;
				sql_query("update g4_merchants set mc_count = '".$mc_count."' where mc_id = '".$mc_['mc_id']."' ");
				



		//ī��
		$point_id = "@".$cd[cd_id]; 	$point_price = $price_2_value;  $point_price2 = -1 * $point_price;
		$price_2_id = $cd[mb_id3];
		if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:ī��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point($point_id, $point_price2, "��������Ʈ($share_uniq:ī��->ȸ��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point($cd[mb_id3], $point_price, "��������Ʈ($share_uniq:ȸ��<-ī��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		
		//ī���� ����Ƚ���� ���
		$cd_count = $cd[cd_count] + 1;
		sql_query("update g4_card set cd_count = '".$cd_count."' where cd_id = '".$cd[cd_id]."' ");
		//��������� ���� �����ݾ��� �����
		$cd_Cumulative_amount = sql_fetch("select sum(po_point) as sum from g4_point where mb_id = '@".$cd[cd_id]."'  and po_content like '��������Ʈ%' and po_content like '%:ī��)%'   ");
		//���� �����ݾ��� 1000�������� ���� ��ġ����ڿ��� ����Ʈ����.

		if($cd_Cumulative_amount['sum'] >= 1000 && ($cd_Cumulative_amount['sum'] - $price_2_value) < 1000 ){
			//ù���� ���� ��õ�ο��� ����Ʈ����.
			if($cd[rc_id]){//��õ���� ���ԵȰ��
				$rc = get_recommend($cd[rc_id]);
				if($cd[cd_recommend]){
					$rc_mb = get_member($cd[cd_recommend]);
				}
				if(!$rc_mb['mb_id']){
					if($cd[mb_id]){//�α��λ��·� ��õ�Ѱ��
						if($rc[mb_id]){
							$rc_mb = get_member($rc[mb_id]);
						}
					}else{//��α��λ��·� ��õ�Ѱ��
						if($rc[mb_hp]){
							$rc_mb = get_member($rc[mb_hp]);
						}
					}//if($cd[mb_id])
				}
			}else{//�ٷε�����ΰ��ԵȰ��
				if($cd[mb_id]){//�α��λ��·� ��õ�Ѱ��
					$cd[mb_id_temp] = $cd[mb_id];
					if($cd[cd_recommend]){
						$cd[mb_id_temp] = $cd[cd_recommend];
					}
					$rc_mb = get_member($cd[mb_id_temp]);
				}else{
					if($cd[cd_recommend]){
						$rc_mb = get_member($cd[cd_recommend]);
					}				
				}
			}//if($cd[rc_id]){//��õ���� ���ԵȰ��
			
			if($rc_mb[mb_id]){
				insert_point($rc_mb[mb_id], "1000", "��������Ʈ($share_uniq:ī����õ) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
				if($rc_mb[mb_nick] == "�����ȸ��" && $rc_mb[mb_level]=="3"){
					insert_point2($rc_mb[mb_id], "1000", "������($share_uniq:ī����õ) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
					
					$sql_search = "select * from g4_monthly_point where mp_year = '".date('Y')."' and mp_month = '".(int)date('m')."' and mb_id = '".$rc_mb[mb_id]."' ";
					$result_search = sql_fetch($sql_search);
					if($result_search['mp_id']){
						//echo "�̹��ִ�.<br/>";
						sql_query("update g4_monthly_point set mp_point = (mp_point + '1000') where mp_id = '".$result_search['mp_id']."' ");
					}else{
						//echo "��������.<br/>";
						sql_query("insert into g4_monthly_point set mb_id = '".$rc_mb[mb_id]."', mp_year = '".date('Y')."' , mp_month = '".(int)date('m')."', mp_point = '1000' ");
					}
					
					
				}
			}//if($rc_mb[mb_id]){



			
		}//if($cd_Cumulative_amount['sum'] > 1000){

		$msg_temp = "<h2>".$price_1_value."P ��������</h2>";
		$msg_temp .= "<div style=\"border-bottom:4px dotted #999999; margin:5px 0 10px 0;\"></div>";
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
		//
		if($point_price){
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb3[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(ī��ȸ��) ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
		$msg_temp .= "<div style='font-size:20px;line-height:25px;'>ī��ȸ��(".$mb3[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
		}
		
		
		
		//��ü
		$point_id = "#".$cd[mb_id2]; 	$point_price = $price_3_value;
		$price_3_id = $cd[mb_id2];
		if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:������)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mb2 = get_merchants($cd[mb_id2]);
		$mb2_mem = get_member($mb2[mb_id]);
		//ī�带�߱����ذ������� ������ ȸ���� ��ȭ��ȣ�� ���� (3)
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
		if($point_price){
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb2_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(������) ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
		$msg_temp .= "<br/>������(".$mb2[mc_subject].")�� <span style='color:red'>".$point_price."P</span>";

		}


		//���������
		if($mb2[mc_manager]){
			$point_id = $mb2[mc_manager];
		}else{
			$point_id = "moa";
		}
		$point_price = $price_42_value;
		$price_42_id = $point_id;
		if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�����(����))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mc_manager = get_member($point_id);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
		//
		if($point_price){
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mc_manager[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(�����(����)) ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
		//$msg_temp .= "<br/>�����(".$mc_manager[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
		$temp_price = (int)$point_price + (int)$temp_price;
		}


		//�Ұ���(��ġ�����)
		$point_id = $cd[mb_id1]; 	$point_price = $price_41_value;
		$price_41_id = $point_id;
		if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�����(��ġ))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mb1 = get_member($cd[mb_id1]);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
		//
		if($point_price){
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb1[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(�����(��ġ)) ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
		$temp_price = (int)$point_price + (int)$temp_price;
		$msg_temp .= "<br/>�����(".$mb1[mb_name].")�� <span style='color:red'>".$temp_price."P</span>";
		}



		unset($result);
		$share_id = get_tp_parents($cd[mb_id1],$result);
		if($share_id[1]){
						$mb55 = get_member($share_id[1]);  // �븮�������
						if($mb55['mb_id']){
							$owner_id = $mb55['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="�븮�������";
						$point_price = $price_55_value;
						$price_55_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb55;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.		
							$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
						}
						
						
						$mb62 = get_member($share_id[2]);  // ���������
						if($mb62['mb_id']){
							$owner_id = $mb62['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="���������";
						$point_price = $price_62_value;
						$price_62_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb62;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.		
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
						}
						
						
						
						$mb56 = get_member($share_id[3]);  // ��������
						if($mb56['mb_id']){
							$owner_id = $mb56['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="��������";
						$point_price = $price_56_value;
						$price_56_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb56;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
						//$msg_temp .= "<br/>�������� point_id = ".$point_id." /  point_price = ".$point_price." is_testing = ".$is_testing." ";

						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.		
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
						}
						
						
						
						$mb57 = get_member($share_id[4]);  // ���������
						if($mb57['mb_id']){
							$owner_id = $mb57['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="���������";
						$point_price = $price_57_value;
						$price_57_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb57;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.		
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
						}
															
			
			
		}else{//if($share_id[1]){
						//���� �� ����				
				
				
						$sql_mc = "select * from g4_merchants where mc_subject = '".mysql_real_escape_string('MP'.$mb1['mb_8'].'����')."' ";
						$row_mc = sql_fetch($sql_mc);
				
				
						//$owner_id = $jijum[$mb1['mb_8']];
						$owner_id = $row_mc['mb_id'];
						$point_price = $price_51_value; $point_name="����";
						if($owner_id=='') $owner_id='moa';
						$price_51_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						
						$mb_temp = get_member($owner_id);
						//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";
						$etc_price = (int)$etc_price + (int)$price_51_value;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//
						//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						//strpos('','����')
						
						
						
						
						$bc = get_jisa($mb2[mc_jisa]);
						
						if($bc[mb_id] && $bc[bc_contract]){
							$owner_id = $bc[mb_id];
						}else{
							$owner_id = "moa4";
						}
						$price_52_id = $owner_id;
						$point_price = $price_52_value; $point_name="����";
						$point_price3 = -1 * $point_price;
				
						
						$point_id = "###".$owner_id;
						if($point_price){
							if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:����) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price3, "��������Ʈ($share_uniq:����->ȸ��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:ȸ��<-����) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						}
						
						
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(����) ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						
							
							if($mb2[mb_id]!='01022222222' && $bc['bc_subject'] == "������"){
								$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
								//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(����) ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
							}
							
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";
							$etc_price = (int)$etc_price + (int)$price_52_value;
						}
						
						
						
					
						if($mb1['mb_partner1']){
							$mb_partner1 = get_member($mb1['mb_partner1']);
						}
						if($mb_partner1['mb_is_partner1']){
							$owner_id = $mb_partner1['mb_id'];
							if($mb_partner1['mb_partner2']){
								$mb_partner2 = get_member($mb_partner1['mb_partner2']);
							}
						}else{
							$owner_id = "moa";
							if($mb1['mb_partner2']){
								$mb_partner2 = get_member($mb1['mb_partner2']);
							}		
						}
					
						$point_name="�븮�������";
						
						$point_price = $price_55_value;
						$price_55_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.		
						$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
				
						}
					
					
						if($mb_partner2['mb_id'] && $mb_partner2['mb_is_partner2']){
							$owner_id = $mb_partner2[mb_id];
						}else{
							$owner_id = "moa";
						}//if($mb_partner2['mb_is_partner2']){
						//���� -> ���� - >���������
						$point_price = $price_62_value; $point_name="���������";
						$price_62_id = $owner_id;
						
						if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:���������)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						
						if($point_price){
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";	
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"��������Ʈ(".$point_name.")�� ".number_format($point_price)."P ��ŭ �����Ͽ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
							$etc_price = (int)$etc_price + (int)$price_62_value;
						}
							
						
						$hq = get_headquarters($mb2[mc_headquarters]);
				
						if($hq[mb_id] && $hq[hq_contract]){
							$owner_id = $hq[mb_id];
						}else{
							$owner_id = "moa3";
						}
						
						$point_name="��������";
						$point_price = $price_61_value;
						$point_price6 = -1 * $point_price;
						$price_61_id = $owner_id;
						$point_id = "####".$owner_id;
						
						if($point_price){
							if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:��������) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price6, "��������Ʈ($share_uniq:��������->ȸ��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:ȸ��<-��������) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						}
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						 //$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";
							$etc_price = (int)$etc_price + (int)$price_61_value;
						}
		
		

		}//if($share_id[1]


		//��ü
		$org = get_organization($cd[cd_organization]);

		if($org[mb_id]){
			$owner_id = $org[mb_id];
		}else{
			$owner_id = "moa";
		}
		$price_65_id = $owner_id;
		$point_name="��ü";
		
		$point_price = $price_65_value;
		$point_price7 = -1 * $point_price;
		$price_65_id = $owner_id;
		$point_id = "@@".$owner_id;
		if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:��ü) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point($point_id, $point_price7, "��������Ʈ($share_uniq:��ü->ȸ��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:ȸ��<-��ü) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mb_temp = get_member($owner_id);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
		
		if($point_price){
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
		//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";
		$etc_price = (int)$etc_price + (int)$price_65_value;
		}




		//��ü�Ұ���
		if($org[mb_id1]){
			$owner_id = $org[mb_id1];
		}else{
			$owner_id = "moa";
		}
		$price_66_id = $owner_id;
		$point_name="��ü�Ұ���";
		
		$point_price = $price_66_value;
		$price_66_id = $owner_id;
		if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:��ü�Ұ���)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mb_temp = get_member($owner_id);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
		
		if($point_price){
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
		//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";
		$etc_price = (int)$etc_price + (int)$price_66_value;
		}
		






		$owner_id = "01036473178,01099087833"; 	 // ������ȸ��� , ���絵ȸ���
		$point_price = $price_63_value; $point_name="��";
		$price_63_id = $owner_id;
		$point_price = $point_price / $price_63_rate;
		$price_rate = $price_63_rate / 6;
		if(!$is_testing) insert_point("01036473178", ($point_price * ($price_rate * 3)), "��������Ʈ($share_uniq:��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point("01099087833", ($point_price * ($price_rate * 3)), "��������Ʈ($share_uniq:��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		//$mb_temp = get_member($owner_id);
		if($point_price && $mb2[mb_id]!='01022222222'){// && $mb2[mb_id]!='01022222222'
			$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
			//������ȸ���
			//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","010-3647-3178",substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(��) ".number_format(($point_price * ($price_rate * 3)))."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
			//���絵ȸ���
			//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","010-9908-7833",substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(��) ".number_format(($point_price * ($price_rate * 3)))."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
			
			//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";			
			//$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
			//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"��������Ʈ(".$point_name.")�� ".number_format($point_price)."P ��ŭ �����Ͽ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
			$etc_price = (int)$etc_price + (int)$price_63_value;
		}



		$owner_id = "moa"; 	$point_price = $price_64_value; $point_name="����";
		$price_64_id = $owner_id;
		//if($member['mb_id'] != "01022222222"){
			//if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		//}else{
			$price_64_id .= ",moa9";
			$point_price = $point_price / $price_64_rate;
			$price_rate = $price_64_rate / 7;
			if(!$is_testing) insert_point($owner_id, ($point_price * ($price_rate * 6)), "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
			if(!$is_testing) insert_point("moa9", ($point_price * ($price_rate * 1)), "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		//}
		$mb_temp = get_member($owner_id);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
		//
	 	if($point_price){
			//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";	
			//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")�� <span style='color:red'>".$price_64_value."P</span></div>";				
			$etc_price = (int)$etc_price + (int)$price_64_value;
			if($mb2[mb_id]!='01022222222'){
				//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01053766511",substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(($point_price * ($price_rate * 6)))."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
				//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01075374008",substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
			}
		}
		
		$price_share_rate = $price_2_rate.",".$price_3_rate.",".$price_4_rate.",".$price_41_rate.",".$price_42_rate.",".$price_51_rate.",".$price_52_rate.",".$price_53_rate.",".$price_54_rate.",".$price_55_rate.",".$price_56_rate.",".$price_57_rate.",".$price_61_rate.",".$price_62_rate.",".$price_63_rate.",".$price_64_rate.",".$price_65_rate.",".$price_66_rate;
		
		
		sql_query("update g4_share set price_2_id ='$price_2_id',price_3_id='$price_3_id',price_4_id='$price_4_id',price_41_id='$price_41_id',price_42_id='$price_42_id',price_51_id='$price_51_id', price_52_id='$price_52_id',price_53_id='$price_53_id',price_54_id='$price_54_id',price_55_id='$price_55_id',price_56_id='$price_56_id',price_57_id='$price_57_id',price_61_id='$price_61_id',price_62_id='$price_62_id',price_63_id ='$price_63_id',price_64_id='$price_64_id',price_65_id='$price_65_id',price_66_id='$price_66_id',price_share_rate='$price_share_rate',price_41_value='$price_41_value',price_42_value='$price_42_value' where sr_id = '$share_uniq'");
		insert_log($share_uniq."�� �������� �����Ͽ����ϴ�.","c");

				


			
		
	}// �������ֱ�
	
    $sql = " update $this_table
                set confirmdate = '{$g4['time_ymdhis']}',bn_sr_id = '{$share_uniq}'
              where bn_id         = '{$_POST[bn_id][$k]}' ";
	    sql_query($sql);
		
	
	
		
	
	//1533 ������ = ����ƮȨ����
	insert_log($_POST[bn_id][$k]."�� �����ֹ��� �Ա�Ȯ�� �Ͽ����ϴ�.","u");
	
	
	}//if($bn['confirmdate'] && $bn['confirmdate'] != "0000-00-00") {
}//for ($i=0; $i<count($chk); $i++) 


if($msg){
	alert($msg,"./smarthome_list.php?$qstr");
}else{
	goto_url("./smarthome_list.php?$qstr");
}
?>
