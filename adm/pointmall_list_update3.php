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
    // 실제 번호를 넘김
    $k = $chk[$i];
	$bn_id = $_POST[bn_id][$k];


	if($bn_id){
		//$sql_common = array2cvs($udata);
		
		$sql = "select * from $g4[board_order_table2] where bn_id = '{$bn_id}' ";
		$bn = sql_fetch($sql);
		
		if($bn['is_cancel'] == "1") {
			$msg .= "$bn[bn_id] : 이미 취소처리가 되었습니다.\\n";
		} else {
		
		$mb_id = $bn[mb_id];
		$mb = get_member($mb_id);

			//---------------------------------------------------------------------------------------
				if($bn['total_price'] && $bn['pay_type'] == "point4" && $bn[confirmdate] && $bn[confirmdate]!="0000-00-00" ){
					$po_point_temp = $bn['total_price'];
					$po_content = '쇼핑포인트결제취소:'.$bn['bn_id'];
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
					if($mc_[mc_id]=="1") $is_testing=true; //테스트 가맹점일때 실포인트 처리가 일어나지 않도록 처리
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
							//1. 회원에게서 포인트를 차감한다 결제포인트 차감
							$point_id = $mb3['mb_id']; 	$point_price = -1 * $po_point;
							if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:결제 차감) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							//2015-12-28// $sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
							//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb3['mb_hp'],$mc_mer['mc_subject']."에서 결제한 포인트 ".number_format($point_price)."P 가 차감취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
							//2. 가맹점에 포인트를 부여한다 결체포인트 부여
							$point_id = "#".$mc_[mc_id]; $point_price = $po_point;
							if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:결제 입금) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							//가맹점주에게 포인트가 얼마나 입금이 되었는지 문자보내기(1)
							$mc_mem = get_member($mc_mer['mb_id']);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mc_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 결제한 포인트 ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
				
						}
				
						
						//$share_uniq = uniqid("");
						$po_point2 = -1 * $po_point;
						
						
						
						
						//가맹점에서 전체 적립포인트 차감
						$point_id = "#".$mc_[mc_id]; 	$point_price = -1 * $price_1_value;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:전체 차감) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//가맹점에서 얼마가 차감됬는지 문자로보내주기(2)
						$mc_mem = get_member($mc_mer['mb_id']);		
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mc_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트 ".number_format(-1 * $point_price)."P 가 차감취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						
						//가맹점의 적립횟수기록
						$mc_count = $mc_mer['mc_count'] - 1;
						
						sql_query("update g4_merchants set mc_count = '".$mc_count."' where mc_id = '".$mc_mer['mc_id']."' ");
						//현재까지의 누적 적립금액을 계산함
						$mc_Cumulative_amount = sql_fetch("select sum(price_1_value) as sum from g4_share where mc_id = '".$mc_mer['mc_id']."' ");
				/*		if($mc_Cumulative_amount['sum'] < 10000 && ($mc_Cumulative_amount['sum'] - $price_1_value) >= 10000){
							//추천을 통해 준 포인트를 다시 차감시킴
							if($mc_mer['mb_id1']){
								insert_point($mc_mer['mb_id1'], "-10000", "적립포인트($share_uniq:가맹점추천) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
								insert_point2($mc_mer['mb_id1'], "-10000", "광고보기($share_uniq:가맹점추천) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
								$sql_search = "select * from g4_monthly_point where mp_year = '".date('Y')."' and mp_month = '".(int)date('m')."' and mb_id = '".$mc_mer['mb_id1']."' ";
								$result_search = sql_fetch($sql_search);
								if($result_search['mp_id']){
									//echo "이미있다.<br/>";
									sql_query("update g4_monthly_point set mp_point = (mp_point - '10000') where mp_id = '".$result_search['mp_id']."' ");
								}
								
							}//if($mc_mer['mb_id1'])
						}	
				*/		// && $_SERVER['REMOTE_ADDR']=="118.44.65.232"
				
						//카드
						$point_id = "@".$sr[cd_id]; 	$point_price = $price_2_value;  $point_price2 = -1 * $point_price;
						$price_2_id = $sr[price_2_id];
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:카드) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						if(!$is_testing) insert_point($point_id, $point_price2, "적립포인트($share_uniq:카드->회원)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						if(!$is_testing) insert_point($price_2_id, $point_price, "적립포인트($share_uniq:회원<-카드) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						
						//카드의 적립횟수를 기록
						$cd = get_card($sr[cd_id]);
						$cd_count = $cd[cd_count] - 1;
						sql_query("update g4_card set cd_count = '".$cd_count."' where cd_id = '".$cd[cd_id]."' ");	
						
						//현재까지의 누적 적립금액을 계산함
						$cd_Cumulative_amount = sql_fetch("select sum(po_point) as sum from g4_point where mb_id = '@".$cd[cd_id]."' and po_content like '적립포인트%' and po_content like '%:카드)%'   ");
						//누적 적립금액이 1000원보다 낮아지고 원래포인트는 1000원이 넘었을경우..
						if($cd_Cumulative_amount['sum'] < 1000 && ($cd_Cumulative_amount['sum'] - $price_2_value) >= 1000 ){
							//첫적립 성공 추천인에게 포인트를줌.
							if($cd[rc_id]){//추천으로 가입된경우
								$rc = get_recommend($cd[rc_id]);
								if($cd[cd_recommend]){
									$rc_mb = get_member($cd[cd_recommend]);
								}
								if(!$rc_mb['mb_id']){
									if($cd[mb_id]){//로그인상태로 추천한경우
										if($rc[mb_id]){
											$rc_mb = get_member($rc[mb_id]);
										}
									}else{//비로그인상태로 추천한경우
										if($rc[mb_hp]){
											$rc_mb = get_member($rc[mb_hp]);
										}
									}//if($cd[mb_id])
								}
							}else{//바로등록으로가입된경우
								if($cd[mb_id]){//로그인상태로 추천한경우
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
							}//if($cd[rc_id]){//추천으로 가입된경우
							
							if($rc_mb[mb_id]){
								insert_point($rc_mb[mb_id], "-1000", "적립포인트($share_uniq:카드추천) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
								if($rc_mb[mb_nick] == "사업자회원" && $rc_mb[mb_level]=="3"){
									insert_point2($rc_mb[mb_id], "-1000", "광고보기($share_uniq:카드추천) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
									
									$sql_search = "select * from g4_monthly_point where mp_year = '".date('Y')."' and mp_month = '".(int)date('m')."' and mb_id = '".$rc_mb[mb_id]."' ";
									$result_search = sql_fetch($sql_search);
									if($result_search['mp_id']){
										//echo "이미있다.<br/>";
										sql_query("update g4_monthly_point set mp_point = (mp_point - '1000') where mp_id = '".$result_search['mp_id']."' ");
									}					
									
								}
							}//if($rc_mb[mb_id]){
												
						}//if($cd_Cumulative_amount['sum'] < 1000 && ($cd_Cumulative_amount['sum'] + $price_2_value) > 1000 ){
						
						
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb3[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(카드회원) ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						}
						
						//업체
						$point_id = "#".$sr[price_3_id]; 	$point_price = $price_3_value;
						$price_3_id = $sr[price_3_id];
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:가맹점)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb2 = get_merchants($sr[price_3_id]);
						$mb2_mem = get_member($mb2[mb_id]);
						//카드를발급해준가맹점을 소유한 회원의 전화번호로 문자 (3)
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb2_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(가맹점) ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						}
				
				
						//사업자
				//		$point_id = $sr[price_4_id]; 	$point_price = $price_4_value;
				//		$price_4_id = $point_id;
				//		if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:사업자)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
				//		$mb1 = get_member($sr[price_4_id]);
				//		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
				//		//
				//		$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb1[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(사업자) ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						
						
						
						//관리사업자
						$point_id = $sr[price_42_id]; 	$point_price = $price_42_value;
						$price_42_id = $point_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:사업자(관리))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb42 = get_member($sr[price_42_id]);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb42[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(사업자(관리)) ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.		
						}
						
						
						//유치사업자
						$point_id = $sr[price_41_id]; 	$point_price = $price_41_value;
						$price_41_id = $point_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:사업자(관리))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb41 = get_member($sr[price_41_id]);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb41[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(사업자(관리)) ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.		
						}		
						
						
						
						
						
						
						
						//지점 및 지사
				//		$point_id = "moa"; 	$point_price = $price_5_value;
				//		if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:지사)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
				//		$mb5 = get_member("moa");
				//		$msg_temp .= "<br/>지사(".$mb5[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
				
						$owner_id = $sr[price_51_id]; 	$point_price = $price_51_value; $point_name="지점";
						if($owner_id=='') $owner_id='moa';
						$price_51_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//
				
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						}
						
						
						if($sr[price_55_id]){
							
							//영업대리점
							$owner_id = $sr[price_55_id];
							$point_name="영업대리점";
							
							$point_price = $price_55_value;
							$price_55_id = $owner_id;
							$point_id = $owner_id;
							if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:영업대리점) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							$mb_temp = get_member($owner_id);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
							
							if($point_price){
							
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
					
							}		
				
						}else{
						
							//대리점1
							$owner_id = $sr[price_53_id];
							$point_name="대리점";
							
							$point_price = $price_53_value;
							$point_price4 = -1 * $point_price;
							$price_53_id = $owner_id;
							$point_id = "##".$owner_id;
							if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:대리점) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price4, "적립포인트($share_uniq:대리점->회원)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:회원<-대리점) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							$mb_temp = get_member($owner_id);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
							
							if($point_price){
							
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
					
							}		
					
							
							
							//대리점2
							$owner_id = $sr[price_54_id];
							$point_name="대리점";
							
							$point_price = $price_54_value;
							$point_price5 = -1 * $point_price;
							$price_54_id = $owner_id;
							$point_id = "##".$owner_id;
							if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:대리점) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price4, "적립포인트($share_uniq:대리점->회원)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:회원<-대리점) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							$mb_temp = get_member($owner_id);
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
							
							if($point_price){
							
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
					
							}			
					
						}//if($sr[price_55_id]){
						
						
						
						
						
						
						
						
						
						
						
						$owner_id = $sr[price_52_id];
						$price_52_id = $owner_id;
						$point_price = $price_52_value; $point_name="지사";
						if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"적립포인트(".$point_name.")를 ".number_format($point_price)."P 만큼 적립하였습니다.");// 5개의 인자로 함수를 호출합니다.
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(지사) ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						}
						
						
						//본사
						//$point_id = "moa"; 	$point_price = $price_6_value;
						//if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:본사)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//$mb6 = get_member("moa");
						//$msg_temp .= "<br/>본사(".$mb6[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";
						$owner_id = $sr[price_61_id]; 	$point_price = $price_61_value; $point_name="광역본부";
						$price_61_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						//$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"적립포인트(".$point_name.")를 ".number_format($point_price)."P 만큼 적립하였습니다.");// 5개의 인자로 함수를 호출합니다.
				
				
				
				
				
						//단체
						$owner_id = $sr[price_65_id];
						$point_name="단체";
						
						$point_price = $price_65_value;
						$point_price7 = -1 * $point_price;
						$price_65_id = $owner_id;
						$point_id = "@@".$owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:단체) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						if(!$is_testing) insert_point($point_id, $point_price7, "적립포인트($share_uniq:단체->회원)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:회원<-단체) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						
						}
				
				
				
				
						//단체소개자
						$owner_id = $sr[price_66_id];	
						$point_name="단체소개자";
						
						$point_price = $price_66_value;
						$price_66_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:단체소개자)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						
						if($point_price){
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
				
						}
				
						if($sr[price_56_id]){
							$owner_id = $sr[price_56_id]; 	$point_price = $price_56_value; $point_name="지사사업자";
							$price_56_id = $owner_id;
							if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							$mb_temp = get_member($owner_id);
						}
						
						if($sr[price_57_id]){
							$owner_id = $sr[price_57_id]; 	$point_price = $price_57_value; $point_name="광역사업자";
							$price_57_id = $owner_id;
							if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							$mb_temp = get_member($owner_id);		
						}
							
							$owner_id = $sr[price_62_id]; 	$point_price = $price_62_value; $point_name="지점사업자";
							$price_62_id = $owner_id;
							if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							$mb_temp = get_member($owner_id);
							//$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
							//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"적립포인트(".$point_name.")를 ".number_format($point_price)."P 만큼 적립하였습니다.");// 5개의 인자로 함수를 호출합니다.
					
					
							$owner_id = $sr[price_63_id]; 	$point_price = $price_63_value; $point_name="고도";
							$price_63_id = $owner_id;
							$owner_id  = explode(',',$owner_id);
							$price_63_rate = $point_price / $price_1_value * 100;
							$point_price = $point_price / $price_63_rate;
							$price_rate = $price_63_rate / 6;
							if(!$is_testing) insert_point($owner_id[0], ($point_price * ($price_rate * 3)), "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id[1], ($point_price * ($price_rate * 3)), "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							
							if($point_price && $mb2[mb_id]!='01022222222'){// 
								//2015-12-28// $sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
								//조재현회장님
								//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$owner_id[0],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(고도) ".number_format(($point_price * ($price_rate * 3) * -1 ))."P 가 적립취소되었습니다.");// 5개의 인자로 함수를 호출합니다.
								//조재도회장님
								//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$owner_id[1],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(고도) ".number_format(($point_price * ($price_rate * 3) * -1 ))."P 가 적립취소되었습니다.");// 5개의 인자로 함수를 호출합니다.
								
							}
						
						
						$owner_id = $sr[price_64_id]; 	$point_price = $price_64_value; $point_name="본사";
						$price_64_id = $owner_id;
						//if($member['mb_id'] != "01022222222"){
							//if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:$point_name)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//}else{
							$owner_id  = explode(',',$owner_id);
							$price_64_rate = $point_price / $price_1_value * 100;
							$point_price = $point_price / $price_64_rate;
							$price_rate = $price_64_rate / 7;
							if(!$is_testing) insert_point($owner_id[0], ($point_price * ($price_rate * 6)), "적립포인트($share_uniq:본사)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id[1], ($point_price * ($price_rate * 1)), "적립포인트($share_uniq:예비)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						//}
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//
						
						if($point_price){
							if($mb2[mb_id]!='01022222222'){
								//2015-12-28// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01053766511",substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(본사) ".number_format(($point_price * ($price_rate * 6) * -1 ))."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
								//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01075374008",substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
							}
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(-1 * $point_price)."P 가 적립취소 되었습니다.");// 5개의 인자로 함수를 호출합니다.
						}
				
						
						sql_query("update g4_share set price_2_id ='$price_2_id',price_3_id='$price_3_id',price_4_id='$price_4_id',price_41_id='$price_41_id',price_42_id='$price_42_id',price_51_id='$price_51_id', price_52_id='$price_52_id',price_53_id='$price_53_id',price_54_id='$price_54_id',price_55_id='$price_55_id',price_56_id = '$price_56_id',price_57_id = '$price_57_id',price_61_id='$price_61_id',price_62_id='$price_62_id',price_63_id ='$price_63_id',price_64_id='$price_64_id',price_65_id='$price_65_id',price_66_id='$price_66_id',price_share_rate='$price_share_rate' where sr_id = '$share_uniq'");
					
						//직전 적립건을 취소하기위해 sr_id 를 출력함.
						$point = $mc_[mc_point] - $price_1_value + $price_3_value;
						insert_log($sr_id."번 적립건을 취소하였습니다.","d");
						}					
					}//if($bn['bn_sr_id'])
				
			//--------------------------------------------------------------------------
		
		
		$sql_common = " is_cancel = '1' ";
		$sql = " update $this_table
			set $sql_common
		  where bn_id = '".$bn_id."' ";
		$result = sql_query($sql);
		insert_log($bn_id."번 주문정보를 주문취소하였습니다.","u");

		}//if($bn['confirmdate'] && $bn['confirmdate'] != "0000-00-00") {
	}//if($bn_id){
}


if($msg){
	alert($msg,"./pointmall_list.php?$qstr");
}else{
	goto_url("./pointmall_list.php?$qstr");
}
?>
