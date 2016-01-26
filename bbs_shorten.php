<?
include_once("_common.php");
//echo $wr_id;



$str_wr_id = $_GET['wr_id'];

if (substr($str_wr_id,0,2)=="01") {


$temp_domains = explode(".",$_SERVER[HTTP_HOST]);
$project_code = "mcard";
if(count($temp_domains) == 3) $project_code = $temp_domains[0];
$project = get_project($project_code);
//echo "[[".$project_code."]]".PHP_EOL;
//$proejct['code'] = $proejct['wr_1'];
//var_dump($project);
//echo $project['wr_1'];
//echo $_GET['wr_id'];


	//var_dump($project);
	//exit;
	//첫페이지일 경우
	//if($project) {
	if($project['wr_1']) {
		//echo "Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project['code']."&wr_id=1&is_intro=true&mb_id={$wr_id}";
		//echo "프로젝트 존재";
		//exit;
		header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project['wr_1']."&wr_id=1&is_intro=true&mb_id={$str_wr_id}");
		return;
	}else{
		//echo "프로젝트 미존재";
		//exit;
		alert("존재하지 않는 프로젝트 입니다","http://".$_SERVER[HTTP_HOST]."/bbs/board.php?bo_table=i01_project");
		return;
	}
	//}
	
		
	
	
}else{
	
	
	
	$arr_wr=get_serial2($wr_id);
	$wr_id=$arr_wr[wr_id];
	$bo_table=$arr_wr[bo_table];
	
	goto_url("{$g4[bbs_path]}/board.m.php?bo_table=$bo_table&wr_id=$wr_id");
	
	
}
?>