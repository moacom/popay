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
    // ���� ��ȣ�� �ѱ�
    $k = $chk[$i];
	$bn_id = $_POST[bn_id][$k];


	if($bn_id){
		//$sql_common = array2cvs($udata);
		
		$sql = "select * from $g4[board_order_table2] where bn_id = '{$bn_id}' ";
		$bn = sql_fetch($sql);
		
		if($bn['is_cancel'] == "1") {
			$msg .= "$bn[bn_id] : �̹� ���ó���� �Ǿ����ϴ�.\\n";
		} else {
		
		$mb_id = $bn[mb_id];
		$mb = get_member($mb_id);

			//---------------------------------------------------------------------------------------
				if($bn['total_price'] && $bn['pay_type'] == "point4" && $bn[confirmdate] && $bn[confirmdate]!="0000-00-00" ){
					$po_point_temp = $bn['total_price'];
					$po_content = '��������Ʈ�������:'.$bn['bn_id'];
					insert_point4($mb['mb_id'], $po_point_temp, $po_content, '@passive', $mb['mb_id'], $member[mb_id]."-".uniqid(""));
				}
				if($bn['bn_sr_id']){
					$sr = sql_fetch("select * from g4_share where sr_id = '".$bn['bn_sr_id']."' ");
					$mc_ = get_merchants($sr['mc_id']);					
					$isProcess=true;
					$point = $mc_[mc_point];
				
					$po_point = $sr[po_point] * -1;
					$price_type = $sr[price_type];
					$price_rate_value = $sr[price_rate_value] * -1;
					$price_1_value = $sr[price_1_value] * -1;
					$price_2_value=$sr[price_2_value] * -1;
					$price_3_value=$sr[price_3_value] * -1;
					$price_4_value=$sr[price_4_value] * -1;
					$price_41_value=$sr[price_41_value] * -1;
					$price_42_value=$sr[price_42_value] * -1;
					
					$price_5_value=$sr[price_5_value] * -1;
					$price_51_value=$sr[price_51_value] * -1;
					$price_52_value=$sr[price_52_value] * -1;
					$price_53_value=$sr[price_53_value] * -1;
					$price_54_value=$sr[price_54_value] * -1;
					$price_55_value=$sr[price_55_value] * -1;
					$price_56_value=$sr[price_56_value] * -1;
					$price_57_value=$sr[price_57_value] * -1;
				
					$price_6_value=$sr[price_6_value] * -1;
					$price_61_value=$sr[price_61_value] * -1;
					$price_62_value=$sr[price_62_value] * -1;
					$price_63_value=$sr[price_63_value] * -1;
					$price_64_value=$sr[price_64_value] * -1;
					$price_65_value=$sr[price_65_value] * -1;
					$price_66_value=$sr[price_66_value] * -1;
					$rt_id = $sr[rt_id];
					$price_share_rate = $sr[price_share_rate];
					$sr_is_pos = $sr[sr_is_pos];
				
					if($isProcess){
				
					$is_testing=false;	
					if($mc_[mc_id]=="1") $is_testing=true; //�׽�Ʈ �������϶� ������Ʈ ó���� �Ͼ�� �ʵ��� ó��
					$sql = "insert into g4_share set mb_id = '$member[mb_id]',mc_id = '$mc_[mc_id]', sr_datetime='$g4[time_ymdhis]',cd_id='$sr[cd_id]',po_point='$po_point',price_type='$price_type',price_rate_value='$price_rate_value',price_1_value='$price_1_value',price_2_value='$price_2_value',price_3_value='$price_3_value',price_4_value='$price_4_value',price_41_value='$price_41_value',price_42_value='$price_42_value', price_5_value='$price_5_value', price_51_value='$price_51_value', price_52_value='$price_52_value', price_53_value='$price_53_value', price_54_value='$price_54_value', price_55_value='$price_55_value',price_56_value='$price_56_value',price_57_value='$price_57_value',price_6_value='$price_6_value', price_61_value='$price_61_value', price_62_value='$price_62_value', price_63_value='$price_63_value', price_64_value='$price_64_value',price_65_value='$price_65_value',price_66_value='$price_66_value', sr_is_pos = '$sr_is_pos',rt_id='$rt_id' ";
					if(!$is_testing) sql_query($sql);
					
					//exchange_point($mb_id, $po_point, $po_content, '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
					$share_uniq = mysql_insert_id();
						$mc_mer = get_merchants($mc_[mc_id]);
						$mb3 = get_member($sr[price_2_id]);
						if(!$mb3['mb_hp']){
							$mb3['mb_hp'] = $mb3['mb_id'];
						}
						$sec_name = str_repeat("X",(strlen($mb3['mb_name'])-2)/2);
						if($price_type == "point"){
							//1. ȸ�����Լ� ����Ʈ�� �����Ѵ� ��������Ʈ ����
							$point_id = $mb3['mb_id']; 	$point_price = -1 * $po_point;
							if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:���� ����) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							//2015-12-28// $sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
							//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb3['mb_hp'],$mc_mer['mc_subject']."���� ������ ����Ʈ ".number_format($point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
							//2. �������� ����Ʈ�� �ο��Ѵ� ��ü����Ʈ �ο�
							$point_id = "#".$mc_[mc_id]; $point_price = $po_point;
							if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:���� �Ա�) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							//�������ֿ��� ����Ʈ�� �󸶳� �Ա��� �Ǿ����� ���ں�����(1)
							$mc_mem = get_member($mc_mer['mb_id']);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mc_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
				
						}
				
						
						//$share_uniq = uniqid("");
						$po_point2 = -1 * $po_point;
						
						
						
						
						//���������� ��ü ��������Ʈ ����
						$point_id = "#".$mc_[mc_id]; 	$point_price = -1 * $price_1_value;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:��ü ����) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//���������� �󸶰� ��������� ���ڷκ����ֱ�(2)
						$mc_mem = get_member($mc_mer['mb_id']);		
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mc_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						
						//�������� ����Ƚ�����
						$mc_count = $mc_mer['mc_count'] - 1;
						
						sql_query("update g4_merchants set mc_count = '".$mc_count."' where mc_id = '".$mc_mer['mc_id']."' ");
						//��������� ���� �����ݾ��� �����
						$mc_Cumulative_amount = sql_fetch("select sum(price_1_value) as sum from g4_share where mc_id = '".$mc_mer['mc_id']."' ");
				/*		if($mc_Cumulative_amount['sum'] < 10000 && ($mc_Cumulative_amount['sum'] - $price_1_value) >= 10000){
							//��õ�� ���� �� ����Ʈ�� �ٽ� ������Ŵ
							if($mc_mer['mb_id1']){
								insert_point($mc_mer['mb_id1'], "-10000", "��������Ʈ($share_uniq:��������õ) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
								insert_point2($mc_mer['mb_id1'], "-10000", "������($share_uniq:��������õ) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
								$sql_search = "select * from g4_monthly_point where mp_year = '".date('Y')."' and mp_month = '".(int)date('m')."' and mb_id = '".$mc_mer['mb_id1']."' ";
								$result_search = sql_fetch($sql_search);
								if($result_search['mp_id']){
									//echo "�̹��ִ�.<br/>";
									sql_query("update g4_monthly_point set mp_point = (mp_point - '10000') where mp_id = '".$result_search['mp_id']."' ");
								}
								
							}//if($mc_mer['mb_id1'])
						}	
				*/		// && $_SERVER['REMOTE_ADDR']=="118.44.65.232"
				
						//ī��
						$point_id = "@".$sr[cd_id]; 	$point_price = $price_2_value;  $point_price2 = -1 * $point_price;
						$price_2_id = $sr[price_2_id];
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:ī��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						if(!$is_testing) insert_point($point_id, $point_price2, "��������Ʈ($share_uniq:ī��->ȸ��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						if(!$is_testing) insert_point($price_2_id, $point_price, "��������Ʈ($share_uniq:ȸ��<-ī��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						
						//ī���� ����Ƚ���� ���
						$cd = get_card($sr[cd_id]);
						$cd_count = $cd[cd_count] - 1;
						sql_query("update g4_card set cd_count = '".$cd_count."' where cd_id = '".$cd[cd_id]."' ");	
						
						//��������� ���� �����ݾ��� �����
						$cd_Cumulative_amount = sql_fetch("select sum(po_point) as sum from g4_point where mb_id = '@".$cd[cd_id]."' and po_content like '��������Ʈ%' and po_content like '%:ī��)%'   ");
						//���� �����ݾ��� 1000������ �������� ��������Ʈ�� 1000���� �Ѿ������..
						if($cd_Cumulative_amount['sum'] < 1000 && ($cd_Cumulative_amount['sum'] - $price_2_value) >= 1000 ){
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
								insert_point($rc_mb[mb_id], "-1000", "��������Ʈ($share_uniq:ī����õ) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
								if($rc_mb[mb_nick] == "�����ȸ��" && $rc_mb[mb_level]=="3"){
									insert_point2($rc_mb[mb_id], "-1000", "������($share_uniq:ī����õ) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
									
									$sql_search = "select * from g4_monthly_point where mp_year = '".date('Y')."' and mp_month = '".(int)date('m')."' and mb_id = '".$rc_mb[mb_id]."' ";
									$result_search = sql_fetch($sql_search);
									if($result_search['mp_id']){
										//echo "�̹��ִ�.<br/>";
										sql_query("update g4_monthly_point set mp_point = (mp_point - '1000') where mp_id = '".$result_search['mp_id']."' ");
									}					
									
								}
							}//if($rc_mb[mb_id]){
												
						}//if($cd_Cumulative_amount['sum'] < 1000 && ($cd_Cumulative_amount['sum'] + $price_2_value) > 1000 ){
						
						
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb3[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(ī��ȸ��) ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						}
						
						//��ü
						$point_id = "#".$sr[price_3_id]; 	$point_price = $price_3_value;
						$price_3_id = $sr[price_3_id];
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:������)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb2 = get_merchants($sr[price_3_id]);
						$mb2_mem = get_member($mb2[mb_id]);
						//ī�带�߱����ذ������� ������ ȸ���� ��ȭ��ȣ�� ���� (3)
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb2_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(������) ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						}
				
				
						//�����
				//		$point_id = $sr[price_4_id]; 	$point_price = $price_4_value;
				//		$price_4_id = $point_id;
				//		if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
				//		$mb1 = get_member($sr[price_4_id]);
				//		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
				//		//
				//		$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb1[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(�����) ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						
						
						
						//���������
						$point_id = $sr[price_42_id]; 	$point_price = $price_42_value;
						$price_42_id = $point_id;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�����(����))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb42 = get_member($sr[price_42_id]);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb42[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(�����(����)) ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.		
						}
						
						
						//��ġ�����
						$point_id = $sr[price_41_id]; 	$point_price = $price_41_value;
						$price_41_id = $point_id;
						if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�����(����))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb41 = get_member($sr[price_41_id]);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb41[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(�����(����)) ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.		
						}		
						
						
						
						
						
						
						
						//���� �� ����
				//		$point_id = "moa"; 	$point_price = $price_5_value;
				//		if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
				//		$mb5 = get_member("moa");
				//		$msg_temp .= "<br/>����(".$mb5[mb_name].")�� <span style='color:red'>".$point_price."P</span>";
				
						$owner_id = $sr[price_51_id]; 	$point_price = $price_51_value; $point_name="����";
						if($owner_id=='') $owner_id='moa';
						$price_51_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//
				
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						}
						
						
						if($sr[price_55_id]){
							
							//�����븮��
							$owner_id = $sr[price_55_id];
							$point_name="�����븮��";
							
							$point_price = $price_55_value;
							$price_55_id = $owner_id;
							$point_id = $owner_id;
							if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�����븮��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							$mb_temp = get_member($owner_id);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
							
							if($point_price){
							
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
					
							}		
				
						}else{
						
							//�븮��1
							$owner_id = $sr[price_53_id];
							$point_name="�븮��";
							
							$point_price = $price_53_value;
							$point_price4 = -1 * $point_price;
							$price_53_id = $owner_id;
							$point_id = "##".$owner_id;
							if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�븮��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price4, "��������Ʈ($share_uniq:�븮��->ȸ��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:ȸ��<-�븮��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							$mb_temp = get_member($owner_id);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
							
							if($point_price){
							
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
					
							}		
					
							
							
							//�븮��2
							$owner_id = $sr[price_54_id];
							$point_name="�븮��";
							
							$point_price = $price_54_value;
							$point_price5 = -1 * $point_price;
							$price_54_id = $owner_id;
							$point_id = "##".$owner_id;
							if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:�븮��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price4, "��������Ʈ($share_uniq:�븮��->ȸ��)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:ȸ��<-�븮��) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							$mb_temp = get_member($owner_id);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
							
							if($point_price){
							
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
					
							}			
					
						}//if($sr[price_55_id]){
						
						
						
						
						
						
						
						
						
						
						
						$owner_id = $sr[price_52_id];
						$price_52_id = $owner_id;
						$point_price = $price_52_value; $point_name="����";
						if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"��������Ʈ(".$point_name.")�� ".number_format($point_price)."P ��ŭ �����Ͽ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(����) ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						}
						
						
						//����
						//$point_id = "moa"; 	$point_price = $price_6_value;
						//if(!$is_testing) insert_point($point_id, $point_price, "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//$mb6 = get_member("moa");
						//$msg_temp .= "<br/>����(".$mb6[mb_name].")�� <span style='color:red'>".$point_price."P</span></div>";
						$owner_id = $sr[price_61_id]; 	$point_price = $price_61_value; $point_name="��������";
						$price_61_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						//$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"��������Ʈ(".$point_name.")�� ".number_format($point_price)."P ��ŭ �����Ͽ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
				
				
				
				
				
						//��ü
						$owner_id = $sr[price_65_id];
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
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						
						}
				
				
				
				
						//��ü�Ұ���
						$owner_id = $sr[price_66_id];	
						$point_name="��ü�Ұ���";
						
						$point_price = $price_66_value;
						$price_66_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:��ü�Ұ���)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						
						if($point_price){
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
				
						}
				
						if($sr[price_56_id]){
							$owner_id = $sr[price_56_id]; 	$point_price = $price_56_value; $point_name="��������";
							$price_56_id = $owner_id;
							if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							$mb_temp = get_member($owner_id);
						}
						
						if($sr[price_57_id]){
							$owner_id = $sr[price_57_id]; 	$point_price = $price_57_value; $point_name="���������";
							$price_57_id = $owner_id;
							if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							$mb_temp = get_member($owner_id);		
						}
							
							$owner_id = $sr[price_62_id]; 	$point_price = $price_62_value; $point_name="���������";
							$price_62_id = $owner_id;
							if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							$mb_temp = get_member($owner_id);
							//$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
							//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"��������Ʈ(".$point_name.")�� ".number_format($point_price)."P ��ŭ �����Ͽ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
					
					
							$owner_id = $sr[price_63_id]; 	$point_price = $price_63_value; $point_name="��";
							$price_63_id = $owner_id;
							$owner_id  = explode(',',$owner_id);
							$price_63_rate = $point_price / $price_1_value * 100;
							$point_price = $point_price / $price_63_rate;
							$price_rate = $price_63_rate / 6;
							if(!$is_testing) insert_point($owner_id[0], ($point_price * ($price_rate * 3)), "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id[1], ($point_price * ($price_rate * 3)), "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							if($point_price && $mb2[mb_id]!='01022222222'){// 
								//2015-12-28// $sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
								//������ȸ���
								//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$owner_id[0],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(��) ".number_format(($point_price * ($price_rate * 3) * -1 ))."P �� ������ҵǾ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
								//���絵ȸ���
								//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$owner_id[1],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(��) ".number_format(($point_price * ($price_rate * 3) * -1 ))."P �� ������ҵǾ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
								
							}
						
						
						$owner_id = $sr[price_64_id]; 	$point_price = $price_64_value; $point_name="����";
						$price_64_id = $owner_id;
						//if($member['mb_id'] != "01022222222"){
							//if(!$is_testing) insert_point($owner_id, $point_price, "��������Ʈ($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//}else{
							$owner_id  = explode(',',$owner_id);
							$price_64_rate = $point_price / $price_1_value * 100;
							$point_price = $point_price / $price_64_rate;
							$price_rate = $price_64_rate / 7;
							if(!$is_testing) insert_point($owner_id[0], ($point_price * ($price_rate * 6)), "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id[1], ($point_price * ($price_rate * 1)), "��������Ʈ($share_uniq:����)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//}
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS ��ü ����
						//
						
						if($point_price){
							if($mb2[mb_id]!='01022222222'){
								//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01053766511",substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(����) ".number_format(($point_price * ($price_rate * 6) * -1 ))."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
								//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01075374008",substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format($point_price)."P �� �����Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
							}
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." ī��ȸ���� ".$mc_mer['mc_subject']."���� ������ ����Ʈ(".$point_name.") ".number_format(-1 * $point_price)."P �� ������� �Ǿ����ϴ�.");// 5���� ���ڷ� �Լ��� ȣ���մϴ�.
						}
				
						
						sql_query("update g4_share set price_2_id ='$price_2_id',price_3_id='$price_3_id',price_4_id='$price_4_id',price_41_id='$price_41_id',price_42_id='$price_42_id',price_51_id='$price_51_id', price_52_id='$price_52_id',price_53_id='$price_53_id',price_54_id='$price_54_id',price_55_id='$price_55_id',price_56_id = '$price_56_id',price_57_id = '$price_57_id',price_61_id='$price_61_id',price_62_id='$price_62_id',price_63_id ='$price_63_id',price_64_id='$price_64_id',price_65_id='$price_65_id',price_66_id='$price_66_id',price_share_rate='$price_share_rate' where sr_id = '$share_uniq'");
					
						//���� �������� ����ϱ����� sr_id �� �����.
						$point = $mc_[mc_point] - $price_1_value + $price_3_value;
						insert_log($sr_id."�� �������� ����Ͽ����ϴ�.","d");
						}					
					}//if($bn['bn_sr_id'])
				
			//--------------------------------------------------------------------------
		
		
		$sql_common = " is_cancel = '1' ";
		$sql = " update $this_table
			set $sql_common
		  where bn_id = '".$bn_id."' ";
		$result = sql_query($sql);
		insert_log($bn_id."�� �ֹ������� �ֹ�����Ͽ����ϴ�.","u");

		}//if($bn['confirmdate'] && $bn['confirmdate'] != "0000-00-00") {
	}//if($bn_id){
}


if($msg){
	alert($msg,"./pointmall_list.php?$qstr");
}else{
	goto_url("./pointmall_list.php?$qstr");
}
?>
