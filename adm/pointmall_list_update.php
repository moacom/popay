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
    // 실제 번호를 넘김
    $k = $chk[$i];
	$sql = "select * from $this_table where bn_id = '{$_POST[bn_id][$k]}' ";
		
	$bn = sql_fetch($sql);
	
	if($bn['is_cancel'] == "1") {	
		$msg .= "$bn[bn_id] : 취소 처리가 되어 입금확인을 하실 수 없습니다.\\n";
	} else if($bn['confirmdate'] && $bn['confirmdate'] != "0000-00-00") {
		$msg .= "$bn[bn_id] : 이미 입금확인이 되었습니다.\\n";
	} else {
	
	
	
	
	if($bn['mb_id']){ // 적립해주기
		$mb = get_member($bn['mb_id']);
		$cd = get_cd_by_code($mb['mb_4']);
		$mc_ = get_merchants('1533');
		$mc = get_merchants($cd[mb_id2]);

		
		
		if($bn['bo_table'] && !$bn['total_price']){

			$sql_bo = " SELECT * FROM `g4_write_".$bn[bo_table]."` where wr_id='$bn[wr_id]'  ";
			$bn_bo = sql_fetch($sql_bo);
								
			$temp_ = explode("(",$bn['orderlist']);
			$object_count = str_replace("개)","",$temp_[(count($temp_)-1)]);
			$object = str_replace("(".$temp_[(count($temp_)-1)],"",$bn['orderlist']);
			$price = $object_count * $bn_bo['wr_4'];
		}else
			$price = $bn['total_price'];

		
		
		
		if($bn['pay_type'] == "point4"){ // 쇼핑포인트로 결제처리해주기..
			if($mb['mb_point4'] >= $price){
				$po_point_temp = $price * -1;
				$po_content = '쇼핑포인트결제:'.$bn['bn_id'];
				insert_point4($mb['mb_id'], $po_point_temp, $po_content, '@passive', $mb['mb_id'], $member[mb_id]."-".uniqid(""));
			}else{
				$msg .= $bn['bn_id'].'번 구매건 쇼핑포인트('.number_format($mb['mb_point4']).'P)가 결제할금액('.number_format($price).'원)보다 부족합니다.';
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
			
			if(!$mc[mc_manager]){// 관리사업자가 없을때에는 사업자가 10% 다 먹어야함..
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
				$price_type = $bn['pay_type']; //결재방식
				$rt_id = $cd['rt_id'];
				if($bn['bn_rate']){
					$price_rate_value = $bn['bn_rate'];
				}else{
					$price_rate_value = $mc_['mc_rate_cash']; //적립율
				}
				
				
		
		
			
			
			//각적립율
				$price_1_rate = $result['price_1_rate']; //전체
				$price_2_rate = $result['price_2_rate']; //카드
				$price_3_rate = $result['price_3_rate']; //업체
				$price_4_rate = $result['price_4_rate']; //사업자
				$price_41_rate = $result['price_41_rate']; //소개자(유치사업자)
				$price_42_rate = $result['price_42_rate']; //관리사업자
				
				$price_5_rate = $result['price_5_rate']; //지사
				$price_51_rate = $result['price_51_rate']; //지점 ($jijim[$member[mb_8]])
				$price_52_rate = $result['price_52_rate']; //지사(moa4)
				$price_53_rate = $result['price_53_rate']; //대리점A
				$price_54_rate = $result['price_54_rate']; //대리점B
				$price_55_rate = $result['price_55_rate']; //대리점사업자
				$price_56_rate = $result['price_56_rate']; //지사사업자
				$price_57_rate = $result['price_57_rate']; //광역사업자
				
				$price_6_rate = $result['price_6_rate']; //본사 
				$price_61_rate = $result['price_61_rate']; //총판(moa3)
				$price_62_rate = $result['price_62_rate']; //직급(moa2) -> 센터 - > 지점사업자
				$price_63_rate = $result['price_63_rate']; //멀티보너스(moa1) -> 고도
				$price_64_rate = $result['price_64_rate']; //본사(moa)
				$price_65_rate = $result['price_65_rate']; //단체
				$price_66_rate = $result['price_66_rate']; //단체소개자
			//각실제적립율	


				$price_1_value = $price * ($price_rate_value / 100); //전체
				if($price_rate_value > 100) $price_1_value = $price_rate_value * $bn['count'];
				
				$price_2_value = $price_1_value * ($price_2_rate / 100); //카드
				$price_3_value = $price_1_value * ($price_3_rate / 100); //업체
				$price_4_value = $price_1_value * ($price_4_rate / 100); //사업자
				$price_41_value = $price_1_value * ($price_41_rate / 100); //소개자(유치사업자)
				$price_42_value = $price_1_value * ($price_42_rate / 100); //관리사업자	
				$price_5_value = $price_1_value * ($price_5_rate / 100); //지사
				$price_51_value = $price_1_value * ($price_51_rate / 100); //지점 ($jijim[$member[mb_8]])
				$price_52_value = $price_1_value * ($price_52_rate / 100); //지사(moa4)
				$price_53_value = $price_1_value * ($price_53_rate / 100); //대리점A
				$price_54_value = $price_1_value * ($price_54_rate / 100); //대리점B
				$price_55_value = $price_1_value * ($price_55_rate / 100); //영업대리점
				$price_56_value = $price_1_value * ($price_56_rate / 100); //영업지사
				$price_57_value = $price_1_value * ($price_57_rate / 100); //영업광역
				
				
				$price_6_value = $price_1_value * ($price_6_rate / 100); //본사 
				$price_61_value = $price_1_value * ($price_61_rate / 100); //총판(moa3)
				$price_62_value = $price_1_value * ($price_62_rate / 100); //직급(moa2)
				$price_63_value = $price_1_value * ($price_63_rate / 100); //멀티보너스(moa1)
				$price_64_value = $price_1_value * ($price_64_rate / 100); //본사(moa)
				$price_65_value = $price_1_value * ($price_65_rate / 100); //단체
				$price_66_value = $price_1_value * ($price_66_rate / 100); //단체소개자		


				$is_testing=false;	
				if($mc[mc_id]=="1") $is_testing=true; //테스트 가맹점일때 실포인트 처리가 일어나지 않도록 처리
				$sql = "insert into g4_share set mb_id = '$member[mb_id]',mc_id = '$mc_[mc_id]', sr_datetime='$g4[time_ymdhis]',cd_id='$cd[cd_id]',po_point='$po_point',price_type='$price_type',price_rate_value='$price_rate_value',price_1_value='$price_1_value',price_2_value='$price_2_value',price_3_value='$price_3_value',price_4_value='$price_4_value',price_41_value='$price_41_value',price_42_value='$price_42_value', price_5_value='$price_5_value', price_51_value='$price_51_value', price_52_value='$price_52_value', price_53_value='$price_53_value', price_54_value='$price_54_value', price_55_value='$price_55_value', price_56_value='$price_56_value', price_57_value='$price_57_value',price_6_value='$price_6_value', price_61_value='$price_61_value', price_62_value='$price_62_value', price_63_value='$price_63_value', price_64_value='$price_64_value',price_65_value='$price_65_value',price_66_value='$price_66_value', sr_is_pos = '$sr_is_pos',rt_id='$rt_id' ";		
				if(!$is_testing) sql_query($sql);
				$share_uniq = mysql_insert_id();
				//가맹점의 적립횟수기록		
				$mc_count = $mc_['mc_count'] + 1;
				sql_query("update g4_merchants set mc_count = '".$mc_count."' where mc_id = '".$mc_['mc_id']."' ");
				



		//카드
		$point_id = "@".$cd[cd_id]; 	$point_price = $price_2_value;  $point_price2 = -1 * $point_price;
		$price_2_id = $cd[mb_id3];
		if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:카드) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point($point_id, $point_price2, "적립포인트($share_uniq:카드->회원)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point($cd[mb_id3], $point_price, "적립포인트($share_uniq:회원<-카드) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		
		//카드의 적립횟수를 기록
		$cd_count = $cd[cd_count] + 1;
		sql_query("update g4_card set cd_count = '".$cd_count."' where cd_id = '".$cd[cd_id]."' ");
		//현재까지의 누적 적립금액을 계산함
		$cd_Cumulative_amount = sql_fetch("select sum(po_point) as sum from g4_point where mb_id = '@".$cd[cd_id]."'  and po_content like '적립포인트%' and po_content like '%:카드)%'   ");
		//누적 적립금액이 1000원넘을시 성공 유치사업자에게 포인트를줌.

		if($cd_Cumulative_amount['sum'] >= 1000 && ($cd_Cumulative_amount['sum'] - $price_2_value) < 1000 ){
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
				insert_point($rc_mb[mb_id], "1000", "적립포인트($share_uniq:카드추천) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
				if($rc_mb[mb_nick] == "사업자회원" && $rc_mb[mb_level]=="3"){
					insert_point2($rc_mb[mb_id], "1000", "광고보기($share_uniq:카드추천) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
					
					$sql_search = "select * from g4_monthly_point where mp_year = '".date('Y')."' and mp_month = '".(int)date('m')."' and mb_id = '".$rc_mb[mb_id]."' ";
					$result_search = sql_fetch($sql_search);
					if($result_search['mp_id']){
						//echo "이미있다.<br/>";
						sql_query("update g4_monthly_point set mp_point = (mp_point + '1000') where mp_id = '".$result_search['mp_id']."' ");
					}else{
						//echo "아직없다.<br/>";
						sql_query("insert into g4_monthly_point set mb_id = '".$rc_mb[mb_id]."', mp_year = '".date('Y')."' , mp_month = '".(int)date('m')."', mp_point = '1000' ");
					}
					
					
				}
			}//if($rc_mb[mb_id]){



			
		}//if($cd_Cumulative_amount['sum'] > 1000){

		$msg_temp = "<h2>".$price_1_value."P 적립내용</h2>";
		$msg_temp .= "<div style=\"border-bottom:4px dotted #999999; margin:5px 0 10px 0;\"></div>";
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
		//
		if($point_price){
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb3[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(카드회원) ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
		$msg_temp .= "<div style='font-size:20px;line-height:25px;'>카드회원(".$mb3[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
		}
		
		
		
		//업체
		$point_id = "#".$cd[mb_id2]; 	$point_price = $price_3_value;
		$price_3_id = $cd[mb_id2];
		if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:가맹점)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mb2 = get_merchants($cd[mb_id2]);
		$mb2_mem = get_member($mb2[mb_id]);
		//카드를발급해준가맹점을 소유한 회원의 전화번호로 문자 (3)
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
		if($point_price){
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb2_mem[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(가맹점) ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
		$msg_temp .= "<br/>가맹점(".$mb2[mc_subject].")님 <span style='color:red'>".$point_price."P</span>";

		}


		//관리사업자
		if($mb2[mc_manager]){
			$point_id = $mb2[mc_manager];
		}else{
			$point_id = "moa";
		}
		$point_price = $price_42_value;
		$price_42_id = $point_id;
		if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:사업자(관리))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mc_manager = get_member($point_id);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
		//
		if($point_price){
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mc_manager[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(사업자(관리)) ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
		//$msg_temp .= "<br/>사업자(".$mc_manager[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
		$temp_price = (int)$point_price + (int)$temp_price;
		}


		//소개자(유치사업자)
		$point_id = $cd[mb_id1]; 	$point_price = $price_41_value;
		$price_41_id = $point_id;
		if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:사업자(유치))", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mb1 = get_member($cd[mb_id1]);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
		//
		if($point_price){
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb1[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(사업자(유치)) ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
		$temp_price = (int)$point_price + (int)$temp_price;
		$msg_temp .= "<br/>사업자(".$mb1[mb_name].")님 <span style='color:red'>".$temp_price."P</span>";
		}



		unset($result);
		$share_id = get_tp_parents($cd[mb_id1],$result);
		if($share_id[1]){
						$mb55 = get_member($share_id[1]);  // 대리점사업자
						if($mb55['mb_id']){
							$owner_id = $mb55['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="대리점사업자";
						$point_price = $price_55_value;
						$price_55_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb55;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.		
							$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
						}
						
						
						$mb62 = get_member($share_id[2]);  // 지점사업자
						if($mb62['mb_id']){
							$owner_id = $mb62['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="지점사업자";
						$point_price = $price_62_value;
						$price_62_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb62;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.		
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
						}
						
						
						
						$mb56 = get_member($share_id[3]);  // 지사사업자
						if($mb56['mb_id']){
							$owner_id = $mb56['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="지사사업자";
						$point_price = $price_56_value;
						$price_56_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb56;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
						//$msg_temp .= "<br/>지사사업자 point_id = ".$point_id." /  point_price = ".$point_price." is_testing = ".$is_testing." ";

						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.		
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
						}
						
						
						
						$mb57 = get_member($share_id[4]);  // 광역사업자
						if($mb57['mb_id']){
							$owner_id = $mb57['mb_id'];
						}else{
							$owner_id = "moa";
						}
						$point_name="광역사업자";
						$point_price = $price_57_value;
						$price_57_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = $mb57;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.		
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
						}
															
			
			
		}else{//if($share_id[1]){
						//지점 및 지사				
				
				
						$sql_mc = "select * from g4_merchants where mc_subject = '".mysql_real_escape_string('MP'.$mb1['mb_8'].'지점')."' ";
						$row_mc = sql_fetch($sql_mc);
				
				
						//$owner_id = $jijum[$mb1['mb_8']];
						$owner_id = $row_mc['mb_id'];
						$point_price = $price_51_value; $point_name="지점";
						if($owner_id=='') $owner_id='moa';
						$price_51_id = $owner_id;
						if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:지점)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						
						$mb_temp = get_member($owner_id);
						//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";
						$etc_price = (int)$etc_price + (int)$price_51_value;
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						//
						//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
						//strpos('','강릉')
						
						
						
						
						$bc = get_jisa($mb2[mc_jisa]);
						
						if($bc[mb_id] && $bc[bc_contract]){
							$owner_id = $bc[mb_id];
						}else{
							$owner_id = "moa4";
						}
						$price_52_id = $owner_id;
						$point_price = $price_52_value; $point_name="지사";
						$point_price3 = -1 * $point_price;
				
						
						$point_id = "###".$owner_id;
						if($point_price){
							if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:지사) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price3, "적립포인트($share_uniq:지사->회원)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:회원<-지사) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						}
						
						
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						if($point_price){
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(지사) ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
						
							
							if($mb2[mb_id]!='01022222222' && $bc['bc_subject'] == "강릉시"){
								$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
								//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(지사) ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
							}
							
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";
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
					
						$point_name="대리점사업자";
						
						$point_price = $price_55_value;
						$price_55_id = $owner_id;
						$point_id = $owner_id;
						if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:$point_name) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.		
						$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span>";
				
						}
					
					
						if($mb_partner2['mb_id'] && $mb_partner2['mb_is_partner2']){
							$owner_id = $mb_partner2[mb_id];
						}else{
							$owner_id = "moa";
						}//if($mb_partner2['mb_is_partner2']){
						//직급 -> 센터 - >지점사업자
						$point_price = $price_62_value; $point_name="지점사업자";
						$price_62_id = $owner_id;
						
						if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:지점사업자)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						$mb_temp = get_member($owner_id);
						
						if($point_price){
							//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";	
							$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
							//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"적립포인트(".$point_name.")를 ".number_format($point_price)."P 만큼 적립하였습니다.");// 5개의 인자로 함수를 호출합니다.
							$etc_price = (int)$etc_price + (int)$price_62_value;
						}
							
						
						$hq = get_headquarters($mb2[mc_headquarters]);
				
						if($hq[mb_id] && $hq[hq_contract]){
							$owner_id = $hq[mb_id];
						}else{
							$owner_id = "moa3";
						}
						
						$point_name="광역본부";
						$point_price = $price_61_value;
						$point_price6 = -1 * $point_price;
						$price_61_id = $owner_id;
						$point_id = "####".$owner_id;
						
						if($point_price){
							if(!$is_testing) insert_point($point_id, $point_price, "적립포인트($share_uniq:광역본부) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($point_id, $point_price6, "적립포인트($share_uniq:광역본부->회원)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
							if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:회원<-광역본부) ", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
						}
						$mb_temp = get_member($owner_id);
						$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
						
						if($point_price){
						
						//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
						 //$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";
							$etc_price = (int)$etc_price + (int)$price_61_value;
						}
		
		

		}//if($share_id[1]


		//단체
		$org = get_organization($cd[cd_organization]);

		if($org[mb_id]){
			$owner_id = $org[mb_id];
		}else{
			$owner_id = "moa";
		}
		$price_65_id = $owner_id;
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
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
		//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";
		$etc_price = (int)$etc_price + (int)$price_65_value;
		}




		//단체소개자
		if($org[mb_id1]){
			$owner_id = $org[mb_id1];
		}else{
			$owner_id = "moa";
		}
		$price_66_id = $owner_id;
		$point_name="단체소개자";
		
		$point_price = $price_66_value;
		$price_66_id = $owner_id;
		if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:단체소개자)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		$mb_temp = get_member($owner_id);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
		
		if($point_price){
		
		//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
		//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";
		$etc_price = (int)$etc_price + (int)$price_66_value;
		}
		






		$owner_id = "01036473178,01099087833"; 	 // 조재현회장님 , 조재도회장님
		$point_price = $price_63_value; $point_name="고도";
		$price_63_id = $owner_id;
		$point_price = $point_price / $price_63_rate;
		$price_rate = $price_63_rate / 6;
		if(!$is_testing) insert_point("01036473178", ($point_price * ($price_rate * 3)), "적립포인트($share_uniq:고도)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		if(!$is_testing) insert_point("01099087833", ($point_price * ($price_rate * 3)), "적립포인트($share_uniq:고도)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		//$mb_temp = get_member($owner_id);
		if($point_price && $mb2[mb_id]!='01022222222'){// && $mb2[mb_id]!='01022222222'
			$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
			//조재현회장님
			//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","010-3647-3178",substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(고도) ".number_format(($point_price * ($price_rate * 3)))."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
			//조재도회장님
			//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","010-9908-7833",substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(고도) ".number_format(($point_price * ($price_rate * 3)))."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
			
			//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";			
			//$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
			//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106",$mb_temp[mb_hp],"적립포인트(".$point_name.")를 ".number_format($point_price)."P 만큼 적립하였습니다.");// 5개의 인자로 함수를 호출합니다.
			$etc_price = (int)$etc_price + (int)$price_63_value;
		}



		$owner_id = "moa"; 	$point_price = $price_64_value; $point_name="본사";
		$price_64_id = $owner_id;
		//if($member['mb_id'] != "01022222222"){
			//if(!$is_testing) insert_point($owner_id, $point_price, "적립포인트($share_uniq:본사)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		//}else{
			$price_64_id .= ",moa9";
			$point_price = $point_price / $price_64_rate;
			$price_rate = $price_64_rate / 7;
			if(!$is_testing) insert_point($owner_id, ($point_price * ($price_rate * 6)), "적립포인트($share_uniq:본사)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
			if(!$is_testing) insert_point("moa9", ($point_price * ($price_rate * 1)), "적립포인트($share_uniq:예비)", '@passive', $mb_id, $member[mb_id]."-".uniqid(""));
		//}
		$mb_temp = get_member($owner_id);
		$sms = new SMS("http://webservice.tongkni.co.kr/sms.3/ServiceSMS.asmx?WSDL"); //SMS 객체 생성
		//
	 	if($point_price){
			//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$point_price."P</span></div>";	
			//$msg_temp .= "<br/>$point_name (".$mb_temp[mb_name].")님 <span style='color:red'>".$price_64_value."P</span></div>";				
			$etc_price = (int)$etc_price + (int)$price_64_value;
			if($mb2[mb_id]!='01022222222'){
				//2015-12-18//$result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01053766511",substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format(($point_price * ($price_rate * 6)))."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
				//2015-10-23// $result=$sms->SendSMS("moamoa1234","yein6510","070-7201-0106","01075374008",substr($mb3['mb_name'],0,2).$sec_name." 카드회원이 ".$mc_mer['mc_subject']."에서 적립한 포인트(".$point_name.") ".number_format($point_price)."P 가 적립되었습니다.");// 5개의 인자로 함수를 호출합니다.
			}
		}
		
		$price_share_rate = $price_2_rate.",".$price_3_rate.",".$price_4_rate.",".$price_41_rate.",".$price_42_rate.",".$price_51_rate.",".$price_52_rate.",".$price_53_rate.",".$price_54_rate.",".$price_55_rate.",".$price_56_rate.",".$price_57_rate.",".$price_61_rate.",".$price_62_rate.",".$price_63_rate.",".$price_64_rate.",".$price_65_rate.",".$price_66_rate;
		
		
		sql_query("update g4_share set price_2_id ='$price_2_id',price_3_id='$price_3_id',price_4_id='$price_4_id',price_41_id='$price_41_id',price_42_id='$price_42_id',price_51_id='$price_51_id', price_52_id='$price_52_id',price_53_id='$price_53_id',price_54_id='$price_54_id',price_55_id='$price_55_id',price_56_id='$price_56_id',price_57_id='$price_57_id',price_61_id='$price_61_id',price_62_id='$price_62_id',price_63_id ='$price_63_id',price_64_id='$price_64_id',price_65_id='$price_65_id',price_66_id='$price_66_id',price_share_rate='$price_share_rate',price_41_value='$price_41_value',price_42_value='$price_42_value' where sr_id = '$share_uniq'");
		insert_log($share_uniq."번 적립건을 적립하였습니다.","c");

				


			
		
	}// 적립해주기
	
    $sql = " update $this_table
                set confirmdate = '{$g4['time_ymdhis']}',bn_sr_id = '{$share_uniq}'
              where bn_id         = '{$_POST[bn_id][$k]}' ";
	    sql_query($sql);
		
	
	
		
	
	//1533 가맹점 = 스마트홈쇼핑
	insert_log($_POST[bn_id][$k]."번 직접주문을 입금확인 하였습니다.","u");
	
	
	}//if($bn['confirmdate'] && $bn['confirmdate'] != "0000-00-00") {
}//for ($i=0; $i<count($chk); $i++) 


if($msg){
	alert($msg,"./smarthome_list.php?$qstr");
}else{
	goto_url("./smarthome_list.php?$qstr");
}
?>
