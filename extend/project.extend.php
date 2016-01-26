<?
function get_project($project_code)
{
    global $g4;
    $sql = " select wr_id,wr_subject,wr_datetime,wr_1,wr_2,wr_3,wr_5 from g4_write_i01_project where wr_1 = '{$project_code}' ";   //원본
    $result = sql_fetch($sql);
	
	$group = get_group($project_code);
	if($group['gr_id']){
		$result['group'] = $group;
	}else{
		$result['group'] = "그룹이존재하지않는다";
	}
	
    return $result;
}







$project_frame = "mcard";
if(!$_GET['project_code'] && !$get_project_code){
	if($bo_table){
		if($bo_table!=$grid."_project"){
			$arr_code=explode("_",$bo_table);
			$project_frame = $arr_code[2];
		}
	}
}else{
	$project_frame = $get_project_code;
	if($_GET['project_code'])$project_frame = $_GET['project_code'];
}


$str_service_brand = "포인트페이";
$str_service_hp = "070-7201-0107";
$str_service_sms = $config['cf_4'];
$str_service_url="popay.kr";
$str_service_app_details ="kr.or.moa.app";
$menu_css_name = "service-menu-a";



if($project_code=="card") {
	if($wr_id==2) $hdH2_theme="q";
	if($wr_id==3) $hdH2_theme="r";
	if($wr_id==4) $hdH2_theme="s";	
}else {
	$hdH2_theme="p";
}



//$project_frames = get_project_id_by_code($project_frame);
//$str_service_brand = $project_frames['subject'];
//$str_service_hp = $project_frames['subject'];
if($project_frame=="mcard") {
	$str_service_brand = "포인트페이";
	//$str_service_hp = "070-8959-7088";
	//$str_service_sms = "07089597088";
	$str_service_hp = "02-6674-0383";
	$str_service_sms = "025538892";
	$str_service_app_details ="kr.or.moa.app";
	$str_service_url="popay.kr";
	$hdH2_theme="j";
	$menu_css_name = "service-menu-c";
}

if($project_frame=="hlzone") {
	$str_service_brand = "땡겨페이";
	//$str_service_hp = "070-8959-7088";
	//$str_service_sms = "07089597088";
	$str_service_hp = "02-6674-0383";
	$str_service_sms = "025538892";
	$str_service_app_details ="kr.uhome.www";
	$str_service_url="ghome.kr/hlzone";
	$hdH2_theme="p";
	$menu_css_name = "service-menu-a";
}

if($project_frame=="moapay") {
	$str_service_brand = "모아페이";
	//$str_service_hp = "02-6674-0383";
	//$str_service_sms = "025538892";
	$str_service_app_details ="kr.uhome.www";
	$str_service_url="moapay.popay.kr";
	$hdH2_theme="p";
	$menu_css_name = "service-menu-a";
}

$str_service_app_link = (strpos($_SERVER['HTTP_USER_AGENT'],"Android"))?"market://details?id=".$str_service_app_details.".".$project_frame."&target=blank":"https://play.google.com/store/apps/details?id=".$str_service_app_details.".".$project_frame;

if($bo_table!=$grid."_project"){
	$qstr .= "&project_code=".$project_frame;
}


//프로젝트 모듈
//$is_project=true
//$is_local=false

//프로젝트(프로젝트 리스트 게시판)
//$is_project=true
//$is_local=true

//지사 모듈
//$is_local=true
//$is_project=false



//프로젝트 정보 가지고 오기...

$arr_code=explode("_",$bo_table);
//$grid="i01";
if($bo_table==$grid."_project"&&$wr_id&&$project_code=="") $project_id=$wr_id;
if($bo_table!=$grid."_project"&&$project_code==""&&$arr_code[2]) $project_code=($project_code)?$project_code:$arr_code[2]; 
//이 문서의 초기 입력값 프로젝트 코드...
//$bo_table에서 추출하거나... 인클루드시에 코드를 직접 추가...
//echo "[[[".$grid."]]]";
//echo "[[[".$bo_table."]]]";
//echo "[[[".$wr_id."]]]";
//echo "[[[".$project_code."]]]";
//echo "[[[".$project_id."]]]";

if($_SESSION['location_home'] && $project_code == ""){
	$project_code = $_SESSION['location_home'];
}




/*if($project_code) $project_write = sql_fetch(" select * from {$g4['write_prefix']}{$grid}_project where wr_1 = '{$project_code}' ");
if($project_id) $project_write = sql_fetch(" select * from {$g4['write_prefix']}{$grid}_project where wr_id = '{$project_id}' ");

$project_board  = array();
$project_board = sql_fetch(" select * from {$g4['board_table']} where bo_table = '{$grid}_project' ");
$project_board_skin_path = '';
if (isset($project_board['bo_skin'])) $project_board_skin_path = "{$g4['path']}/skin/board/{$store_board['bo_skin']}"; // 게시판 스킨 경로
$project_view = get_view($project_write, $project_board, $project_board_skin_path, 255);*/





$project_view = get_project($project_code);


if($project_code){
	set_session("ss_project_code", $project_code);
	set_session("ss_project_name", $project_view['wr_subject']);
	if($project_view['wr_6']&&$project_view['wr_7']&&$project_view['wr_8']){
	$payapp_userid	= $project_view['wr_6'];
	$payapp_linkkey	= $project_view['wr_7'];
	$payapp_linkval	= $project_view['wr_8'];
	}
}

$project_modules = array();
//기본 모듈
$project_modules[] = array('menu','메뉴');
$project_modules[] = array('page','페이지');
$project_modules[] = array('list','리스트');
$project_modules[] = array('banner','배너');

//컨테이너 모듈
$project_modules[] = array('store','업체');
$project_modules[] = array('people','인물');

//특수 모듈
$project_modules[] = array('shop','쇼핑몰');
$project_modules[] = array('guest','리스트2(고객)');
$project_modules[] = array('career','경력');
$project_modules[] = array('deal','매매');
//poll 설문
//reservation 예약
//객실...리스트 및 주문리스트 연결...


//샵입 모듈(기본...)
$project_modules[] = array('movie','동영상');
$project_modules[] = array('photo','사진');
$project_modules[] = array('sound','소리');
$project_modules[] = array('icon','아이콘');
//상품 (기존 댓글형태에서 별도로 movie)
//쿠폰 

//요청게시판 부분 지역별로 하나씩 하고....



	
$project_menus=array();
$project_menus[]=array('setting','설정');
//$project_menus[]='회원';
//$project_menus[]='아이콘';

if($project_view)
{
	$project = $project_view;
	$project['name'] = $project['wr_subject'];
	$project['code'] = $project['wr_1'];
	$project['version'] = $project['wr_9'];
	$project['id'] = $project['wr_id'];
	$project['modules'] = explode("|",$project["wr_5"]);
	$isNotCateMenu = true;
	for ($i=0; $i<count($project['modules']); $i++) 
	{ 
		if($project['modules'][$i])
			$project_menus[] = $project_modules[$i];
//				if(($project_modules[$i][0]=="list" ||
//				$project_modules[$i][0]=="banner" ||
//				$project_modules[$i][0]=="store" ||
//				$project_modules[$i][0]=="people" ||
//				$project_modules[$i][0]=="guest"
//				)&&$isNotCateMenu) $isNotCateMenu = false;
	}
}


//선거포털만을 위한 옵션
if($project['code']=="election") $project_menus[] = array('elect','후보자');

	
//echo "[[[".$project_view[wr_1]."]]]";
	

// 게시판 테이블에서 하나의 행을 읽음


?>
