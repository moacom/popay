<?
include_once("./_common.php");

$is_project_admin = false;
if ($_REQUEST['is_project_admin']=='true')
	$is_project_admin = true;
else if ($_REQUEST['is_project_admin']=='false')
	$is_project_admin = false;
else if (isset($_SESSION['ss_is_project_admin']))
	$is_project_admin = $_SESSION['ss_is_project_admin'];

$_SESSION['ss_is_project_admin'] = $is_project_admin;

$is_jisa = false;
$is_project = false;
$is_project_exist = false;
$arrTemps = explode(".",$_SERVER['HTTP_HOST']);
if(count($arrTemps)>=3){ //~~.kr같은 도메인일 때
	$key_position = count($arrTemps) - 3;
	$project_code = $arrTemps[$key_position];
	$is_project = true;
	$project_id=get_project_id_by_code($project_code);
	if($project_id) $is_project_exist = true;
}
$jisa_codes = array("www","i01","i02");

if(in_array($project_code,$jisa_codes)){
	$is_project = false;
	$is_jisa = true;
}

//if(_DEVELOP_){
//	echo (strpos($_SERVER[HTTP_HOST],"emoa.kr")!==false);
//	exit;
//}


if(strpos($_SERVER[HTTP_HOST],"emoa.kr")!==false){

	//첫페이지일 경우
	if($is_project) {
		if($is_project_exist) {
			if($_REQUEST['is_project_admin']=='true') {
				header("Location:"."/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				//goto_url("/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				return;
				
			}else{
				
				//if($project_code!="emapt") 
				header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				//goto_url("/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				return;
			}
		}else{
			alert("존재하지 않는 프로젝트 입니다","http://emoa.kr/bbs/board.php?bo_table=i01_project");
			return;
		}
	}else{
		$is_jisa = true;
		//set_cookie('ck_is_project_admin', '', 0);
		header("Location:"."/bbs/board.m.php?bo_table=i01_menu_election&wr_id=1");
		return;
		//goto_url("/bbs/board.php?bo_table=i01_project");
	}//if($is_project) {

}//if(strpos($_SERVER[HTTP_HOST],"emoa.kr")!==false){
	
elseif(strpos($_SERVER[HTTP_HOST],"card.onep.kr")!==false){
		header("Location:"."/bbs/board.m.php?bo_table=i01_menu_mcard&wr_id=1");
		return;
}
	
elseif(strpos($_SERVER[HTTP_HOST],"onep.kr")!==false){
	

	
	//첫페이지일 경우
	if($is_project) {
		if($is_project_exist) {
			if($_REQUEST['is_project_admin']=='true') {
				header("Location:"."/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				//goto_url("/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				return;
				
			}else{
				
				
				
				if($project_code=="ihb"){
					header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				}else{
					header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1&is_intro=true");
				}
				//goto_url("/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				return;
			}
		}else{
			alert("존재하지 않는 프로젝트 입니다","http://mhm.kr/bbs/board.php?bo_table=i01_project");
			return;
		}
	}else{
		$is_jisa = true;
		//set_cookie('ck_is_project_admin', '', 0);
		header("Location:"."/bbs/board.m.php?bo_table=i01_menu_one&wr_id=1");
		return;
		//goto_url("/bbs/board.php?bo_table=i01_project");
	}//if($is_project) {
	
}
elseif(strpos($_SERVER[HTTP_HOST],"moapoint.kr")!==false){
	
	//첫페이지일 경우
	if($is_project) {
		if($is_project_exist) {
			if($_REQUEST['is_project_admin']=='true') {
				header("Location:"."/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				//goto_url("/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				return;
				
			}else{
				
				
				
				if($project_code=="ihb"){
					header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				}else{
					header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1&is_intro=true");
				}
				//goto_url("/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				return;
			}
		}else{
			alert("존재하지 않는 프로젝트 입니다","http://mhm.kr/bbs/board.php?bo_table=i01_project");
			return;
		}
	}else{
		$is_jisa = true;
		//set_cookie('ck_is_project_admin', '', 0);
		header("Location:"."/bbs/board.m.php?bo_table=i01_menu_mpoint&wr_id=1");
		return;
		//goto_url("/bbs/board.php?bo_table=i01_project");
	}//if($is_project) {
	
}
elseif(strpos($_SERVER[HTTP_HOST],"moacard.com")!==false || strpos($_SERVER[HTTP_HOST],"popay.kr")!==false){
	
	//첫페이지일 경우
	if($is_project) {
		if($is_project_exist) {
			if($_REQUEST['is_project_admin']=='true') {
				header("Location:"."/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				//goto_url("/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				return;
				
			}else{
				
				header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1&is_intro=true&reg_id={$reg_id}");
				//goto_url("/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				return;
			}
		}else{
			alert("존재하지 않는 프로젝트 입니다","http://mhm.kr/bbs/board.php?bo_table=i01_project");
			return;
		}
	}else{
		$is_jisa = true;
		//set_cookie('ck_is_project_admin', '', 0);
		if($rc){
			$sql = "select * from g4_recommend where rc_id = '".$rc."' ";
			$rc = sql_fetch($sql);
			//var_dump($rc);
			
			header("Location:"."/onep/card_recommend.m.php?project=mcard&rc_id=".$rc['rc_id']."&project_code=".$rc['pj_id']);
			
			//header("Location:"."/onep/card_recommend.m.php?project=mcard&rc_id=".$rc."");
		}else if($r6) {
			$num_62 = gmp_init($r6, 62);
			$r6 = gmp_strval($num_62, 10);  // 62진수 값
			$sql = "select * from g4_recommend where rc_id = '".$r6."' ";
			$rc = sql_fetch($sql);
			
			header("Location:"."/onep/card_recommend.m.php?project=mcard&rc_id=".$rc['rc_id']."&project_code=".$rc['pj_id']);
		}else if($pvs){
			$sql = "select * from g4_uniq_mb where un_id='$pvs' ";
			$pvs_ =  sql_fetch($sql);
			if($pvs_){
				header("Location:"."/onep/provisional_form.m.php?pvs=".$pvs."&project_code=".$pvs_['project_code']);
			}else{
				header("Location:"."/onep/provisional_form.m.php?$sql");
			}
		}else{
			header("Location:"."/bbs/board.m.php?bo_table=i01_menu_mcard&wr_id=1&reg_id={$reg_id}");
		}
		return;
		//goto_url("/bbs/board.php?bo_table=i01_project");
	}//if($is_project) {
	
}

elseif(strpos($_SERVER[HTTP_HOST],"mhm.kr")!==false){

	//첫페이지일 경우
	if($is_project) {
		if($is_project_exist) {
			if($_REQUEST['is_project_admin']=='true') {
				header("Location:"."/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				//goto_url("/bbs/board.php?bo_table=i01_project&wr_id=$project_id");
				return;
				
			}else{
				
				if($project_code=="ihb"){
					header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				}else{
					header("Location:"."/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1&is_intro=true");
				}
				//goto_url("/bbs/board.m.php?bo_table=i01_menu_".$project_code."&wr_id=1");
				return;
				
			}
		}else{
			alert("존재하지 않는 프로젝트 입니다","http://mhm.kr/bbs/board.php?bo_table=i01_project");
			return;
		}
	}else{
		$is_jisa = true;
		
		if($rc){
			$sql = "select * from g4_recommend where rc_id = '".$rc."' ";
			$rc = sql_fetch($sql);
			//var_dump($rc);
			
			header("Location:"."/onep/card_recommend.m.php?project=mcard&rc_id=".$rc['rc_id']."&project_code=".$rc['pj_id']);

			//header("Location:"."/onep/card_recommend.m.php?project=mcard&rc_id=".$rc."");
		}else if($r6) {
			$num_62 = gmp_init($r6, 62);
			$r6 = gmp_strval($num_62, 10);  // 62진수 값			
			$sql = "select * from g4_recommend where rc_id = '".$r6."' ";
			$rc = sql_fetch($sql);
			
			header("Location:"."/onep/card_recommend.m.php?project=mcard&rc_id=".$rc['rc_id']."&project_code=".$rc['pj_id']);
		}else{
			//set_cookie('ck_is_project_admin', '', 0);
			header("Location:"."/bbs/board.m.php?bo_table=i01_menu_mhm&wr_id=1");
		}
		return;
		//goto_url("/bbs/board.php?bo_table=i01_project");
	}//if($is_project) {

}


// 쿠키변수 생성
function set_cookie0($cookie_name, $value, $expire)
{
    global $g4;

    setcookie(md5($cookie_name), base64_encode($value), $expire, '/', $g4[cookie_domain]);
}

// 쿠키변수값 얻음
function get_cookie0($cookie_name)
{
    return base64_decode($_COOKIE[md5($cookie_name)]);
}

function MobileCheck() { 
	global $HTTP_USER_AGENT; 
	$MobileArray  = array("iphone","ipad","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone");
	$checkCount = 0; 
		for($i=0; $i<sizeof($MobileArray); $i++){ 
			if(preg_match("/$MobileArray[$i]/", strtolower($HTTP_USER_AGENT))){ $checkCount++; break; } 
		} 
	return ($checkCount >= 1) ? "Mobile" : "Computer"; 
}

if($domain=="ggnn.net" || $domain=="scmoa.kr" || $domain=="wwjj.kr" || $domain=="djmoa.kr" || $domain=="gdmoa.kr" || $domain=="cjmoa.kr" || $domain=="sjmoa.kr" || $domain=="gymoa.kr"|| $domain=="camoa.kr"|| $domain=="ddhh.kr" || $domain=="schmoa.kr" || $domain=="asmoa.kr" || $domain=="dgmoa.kr"){
	//if(get_cookie0("mmpp2")!="pc"){
		if(MobileCheck() == "Mobile"&& $mmpp!="pc"){ 
			header("Location:/m/");
			
		}
	//}
	//if($mmpp=="pc"){
	//	set_cookie0("mmpp2", "pc",0);
	//}
}

exit();

include_once("$g4[path]/head.sub.php");
include_once("$g4[path]/lib/thumb.lib.php");
?>


<script language="javascript" src="<?=$g4['path']?>/js/jsRolling.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
.style2 {color: #990033}
.style3 {color: #990099}
.style4 {color: #FFFFFF}
.style5 {color: #CCCCCC}

#main_right_shop_css {color:#bacfda}
#main_right_shop_css a {letter-spacing:-1px; font-size:11px; font-weight:bold; font-family:돋움; color:#62a853}

#main_store_banner_div {width:900px; padding:0 0 10px 0; margin:0; /* ; border-top:2px solid #ccc ; border-bottom:2px solid #ccc*/}
#main_store_banner_div img {margin:0 2px 0 1px}

#main_store_banner_title {position:relative ; height:35px}
#main_store_banner_title img.btn_detail  {position:absolute ; right:0 ; top:10px}
-->
</style>
<?//=$_SERVER['abcde'].":".$_SERVER['fgh']?>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td style="padding:0" valign="top">


			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="90" style="background:url(img/00_main/logo_main_bg.jpg) no-repeat left top;">
				<tr> 
					<td align="right" style="padding:0 40 5 0" valign="bottom"> 
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr> 
								<td rowspan="2" align="right" style="padding:10px 30 0 0" width="150" valign="top"> 
									<table border="0" cellspacing="0" cellpadding="0">
										<tr> 
											<td valign="bottom">
												<a href="http://<?=$domain?>"><img src="<?=$g4[path]?>/img/00_main/logo_main_<?=$image?>.gif" border="0"></a>
											</td>
										</tr>
									</table>
								</td>
								<td style="padding:5 0 0 0"><!-- 검색바 --><? include_once("$g4[path]/inc/inc_se_b.php");?></td>
							</tr>
							<tr> 
								<td align="center" style="padding:5 0 0 0">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr> 
											<td style="padding:0 18px"><a href="http://naver.com" target="_blank"><img src="/inc/img/na_logo.gif" alt="" /></a></td>
											<td style="padding:0 18px"><a href="http://daum.net" target="_blank"><img src="/inc/img/da_logo.gif" alt="" /></a></td>
											<!--<td style="padding:0 12px"><a href="http://m.kr.yahoo.com" target="_blank"><img src="/inc/img/ya_logo.gif" alt="" /></a></td>-->
											<td style="padding:0 18px"><a href="http://www.nate.com" target="_blank"><img src="/inc/img/nt_logo.gif" alt="" /></a></td>
											<td style="padding:0 18px"><a href="http://www.google.co.kr" target="_blank"><img src="/inc/img/go_logo.gif" alt="" /></a></td>                                   
										</tr>
									</table>
								</td>
							</tr>
							<tr><td height="15px"></td></tr>
						</table>
					</td>
					<td width="200" valign="top" align="center" style="padding:0 0 5 0"><?=latest("news_banner_top_ran", "{$grid}_banner", 10, 0, "", "", "메인상단" ,""); ?></td>
				</tr>
			</table>
	
		</td>
  </tr>
</table>



<!-- <table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="#629dd9" style="border-width:0 0 3 0; border-color:#407997; border-style:solid;" align="center" height="35"> -->
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$common_top_menu_color1?>" style="border-width:0 0 4 0; border-color:<?=$common_top_menu_color2?>; border-style:solid;" align="center" height="35">
  <tr> 
    <td style="padding:0 20 6 20" valign="bottom"> 
      <?include_once("$g4[path]/inc/inc_main_menu.php");?>
    </td>
    <td style="padding:0 20px 6 0" valign="bottom" align="right"> 
      <?include_once("$g4[path]/inc/inc_top_right.php");?>
    </td>
  </tr>
</table>



<table width="900" border="0" cellspacing="0" cellpadding="5" height="30" style="border-width:0 1 1 1; border-color:#dddddd; border-style:solid;" align="center">
  <tr align="center"> 

    <td width="45%" style="padding:3px 0 0 0"><?//=visit("line"); // 방문자수 ?> </td>

    <td width="20%" align="right" style="font-weight:bold ; padding-top:8px">
		
			<a href="http://mymoa.kr" style="" target="_blank"><img src="<?=$g4[path]?>/img/00_main/logo_moa.gif" border="0"></a>
			<a href="http://<?=$domain?>/bbs/board.php?bo_table=02_form" target="_blank"><img src="/img/00_main/icon_doc.gif" alt="무료서식" /></a>

		</td>


    <td width="35%">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td style="padding:0 5px"><a href="https://twitter.com/#!/gn_moa" target="_blank"><img src="<?=$g4[path]?>/inc/img/t_logo.gif" alt="" /></a></td>
			<td style="padding:0 5px"><a href="http://www.facebook.com/" target="_blank"><img src="<?=$g4[path]?>/inc/img/f_logo.gif" alt="" /></a></td>
			<td style="padding:0 5px"><a href="http://www.youtube.com/?gl=KR&amp;hl=ko" target="_blank"><img src="<?=$g4[path]?>/inc/img/y_logo.gif" alt="" /></a></td>
			<td style="padding:0 5px"><a href="http://me2day.net/" target="_blank"><img src="<?=$g4[path]?>/inc/img/m_logo.gif" alt="" /></a></td>
			<td style="padding:0 5px"><a href="http://<?=$domain?>/inc/inc_webhard.php" target="_blank"><img src="<?=$g4[path]?>/inc/img/w_logo.gif" alt="" /></a></td>
		  </tr>
		</table>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="5">
  <tr> 
    <td></td>
  </tr>
</table>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr valign="top"> 
    <td style="padding:0 5px 0 0"> 

      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="132">
        <tr> 
          <td valign="top">
						<div style="border:1px solid #dddddd ; width:183px ; margin-bottom:2px">
            <?=outlogin("basic"); // 외부 로그인 ?>
						</div>
						<?if($grid == "i01"){?>
						<a href="http://news.<?=$domain?>/bbs/board.php?bo_table=<?=$grid?>_news&sca=<?=urlencode("단오특집")?>"><img src="/img/00_main/main_banner_culumculture.gif" alt=""  usemap="#main_culumculture" /></a>
						<?}else{?>
						<img src="/img/00_main/main_banner_vivakor.gif" alt="" usemap="#main_vivakor" />
						<?}?>
					</td>
          <td bgcolor="#FFFFFF" width="450" valign="top"> 
            <?=latest("popup", "{$grid}_notice", 1, 35, "", "", ""); ?>
						<? if($grid=="i04"){?>
<a href="http://sokcho.gangwon.kr/"><img src="scmoa20.gif" border=0 /></a><? }else{?>
            <?=latest("main_banner_center", "{$grid}_banner", 100 , 0, "RAND()", "", "메인중앙"); ?><? }?></td>
        </tr>
      </table>

			<map name="main_vivakor">
				<area shape="rect" coords="0,0,91,46" href="http://cult.<?=$domain?>/bbs/board.php?bo_table=i01_art&sca=문예공간" title="서민기자석" />
				<area shape="rect" coords="91,0,183,46" href="http://vivakor.kr" title="vivakor" target="_blank" />
			</map>

			<map name="main_culumculture">
				<area shape="rect" coords="0,0,96,46" href="http://news.ggnn.net/bbs/board.php?bo_table=i01_news&sca=칼럼" title="뉴스모아 컬럼" />
				<area shape="rect" coords="96,0,183,46" href="http://news.ggnn.net/bbs/board.php?bo_table=i01_news&sca=문학산책" title="문학산책" />
			</map>

    </td>
    <td width="260" height="132"><? if($grid=="i01") {?><div style=" position:absolute; z-index:1000;width:339px;text-align:right; display:none"><a href="#" onclick="window.open('/html/moacall.html','moacall','width=638,height=913,menubar=no,status=no,toolbar=no');"><img src="/html/btn-moacall-tag.gif" style="margin:0px 0px 3px 0px;" /></a><br/><a href="#" onclick="window.open('/bbs/board.php?bo_table=i01_manbank','manbank','width=606,height=603,menubar=no,scrollbars=yes,status=no,toolbar=no,resizable=yes');"><img src="/html/btn-manbank-tag.gif" style="margin:0px 0px 3px 0px;" /></a><br/><a href="http://mymoa.kr/bbs/board.php?bo_table=01_cd_sto" target="_blank"><img src="/html/btn-card-tag.gif" /></a>
            </div><? }?>
			<?=latest("date00", "00_notice", 3, 35, "", "", ""); ?>

 
<?=latest("date", "{$grid}_notice", 2, 35, "", "", ""); ?>

		</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="5">
  <tr> 
    <td></td>
  </tr>
</table>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr valign="top"> 
    <td height="420" style="padding-right:5"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dddddd">
        <tr bgcolor="#FFFFFF"> 
          <td align="center" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <? if($grid!="f00"){?>
              <tr> 
                <td style="border-width:0 0 1 0; border-color:#dddddd; border-style:solid;" height="24">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%" valign="middle"><b>ㆍ<a href="http://<?=$domain?>/bbs/board.php?bo_table=i01_news&sca=자유기고"><span style='font color:#666666;'>자유기고</span></a></b></td>
                      <td valign="middle"><b>ㆍ<a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=03_morning"><span style='font color:#666666;'>아침명상</span></a>&nbsp;</b></td>
                    </tr>
                  </table>
                </td>
              </tr>
            <? }?>  
              
              
              <tr>  
                <td style="padding:5"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  
                  <? if($grid=="f00"){?>
                     <tr> 
                      <td><a href="http://<?=$domain?>/bbs/board.php?bo_table=i01_news&sca=자유기고"><font color="#666666">자유기고</font></a></td>
                      <td><a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=03_morning"><font color="#666666">아침명상</font></a></td>
                    </tr>
                  <? }?>
                  
                    <tr> 
                      <td><a href="http://news.<?=$domain?>/bbs/board.php?bo_table=<?=$grid?>_news&sca=인터뷰"><font color="#666666">인터뷰</font></a></td>
                      <td><a href="http://news.<?=$domain?>/bbs/board.php?bo_table=<?=$grid?>_news&sca=칼럼"><font color="#666666">칼럼/기고/수필</font></a></td>
                    </tr>
                    <tr> 
                      <td><a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=<?=$grid?>_free"><font color="#666666">자유게시판</font></a></td>
                      <!--td><a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=<?=$grid?>_isu"><font color="#666666">핫이슈</font></a></td-->
                      <td><a href="http://<?=$domain?>/bbs/board.php?bo_table=<?=$grid?>_relay"><font color="#666666">칭찬릴레이</font></a></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td style="border-width:1 0 0 0; border-color:#dddddd; border-style:solid;padding:5"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr> 
                      <td><a href="http://stoo.asiae.co.kr/" target="_blank"><font color="#666666">스포츠투데이</font></a></td>
                      <td><a href="http://www.gooddaysports.co.kr/" target="_blank"><font color="#666666">굿데이스포츠</font></a></td>
                    </tr>

                    <tr> 
                      <td><a href="http://www.sportsseoul.com/" target="_blank"><font color="#666666">스포츠서울</font></a></td>
                      <td><a href="http://isplus.joins.com/" target="_blank"><font color="#666666">일간스포츠</font></a></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr> 
                      <td><a href="http://www.yonhapnews.co.kr/" target="_blank"><font color="#666666">연합뉴스</font></a></td>
                      <td><a href="http://www.ddanzi.com/" target="_blank"></a><a href="http://www.ohmynews.com/" target="_blank"><font color="#666666">오마이뉴스</font></a></td>
                      <td><a href="http://www.newstoon.net/" target="_blank"><font color="#666666">뉴스툰</font></a></td>
                    </tr>
                    <tr> 
                      <td><a href="http://www.edaily.co.kr/" target="_blank"></a><a href="http://www.edaily.co.kr/" target="_blank"><font color="#666666">이데일리</font></a></td>
                      <td><a href="http://www.ohmynews.com/" target="_blank"></a><a href="http://www.ddanzi.com/" target="_blank"><font color="#666666">딴지일보</font></a></td>
                      <td><a href="http://www.newstoon.net/" target="_blank"></a></td>
                    </tr>
                  </table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr><td><a href="/jisa_list.php" onclick="window.open('http://ggnn.net/jisa_list.php' , '' , 'width=700px , height=800px , scrollbars=yes , status=no') ; return false;" target="_blank"><img src="/img/00_main/main_banner_jisa.gif" alt="" /></a></td></tr>
									</table>
                </td>
              </tr>
            </table>
							
          </td>
          <td width="449" valign="top" height="173"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="25" valign="middle" style="border-bottom-width:1px; border-bottom-color:#dddddd; border-bottom-style:solid;padding:3 10 3 3;"> 
                  <? include_once("$g4[path]/vote/inc_news_{$grid}.php");?></td>
              </tr>
              <tr> 
                <td>
                  <table width="100%" border="0" cellspacing="0">
                    <tr> 
						<? // (($grid_news)?$grid_news:$grid)?>					
											<!-- 메인중앙뉴스 - 포토 -->
                      <td width="160" align="right" valign="middle" style="padding:10px 0 0 10px"><? if($grid=="i01"){?><?=latest_sql("img_main2", (($grid_news)?$grid_news:$grid)."_news", 1, 30, " wr_21='1' and wr_16<>'' and Not(ca_name in ('문학산책','컬럼')) ", "RAND()", "10");?><? }elseif($grid=="k02"&&false){?><?=latest("img_main2_rotate", (($grid_news)?$grid_news:$grid) . "_news", 4, 30, "wr_datetime", "", "포토뉴스");?><? }else{?><?=latest("img_main2", (($grid_news)?$grid_news:$grid) . "_news", 1, 30, "wr_datetime", "", "포토뉴스");?><? }?></td>
											
											<!-- 메인중앙뉴스 - 텍스트 -->
                      <td valign="top"style="padding:12px 0 0 0">
                      <? if($grid=="i01"){
						  	$where_seg="and (ca_name not in ('문학산책')) and wr_21='1'";
						  }else{
						  	$where_seg="and ca_name not in ('문학산책')";
						  }
					  ?>
                      
					  <?=latest_main_left("default", (($grid_news)?$grid_news:$grid) . "_news", 6 , 36 , "wr_datetime desc" , $where_seg , "") ;?>
                      </td>

                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="5">
        <tr> 
          <td></td>
        </tr>
      </table>


      <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dddddd">
        <tr bgcolor="#FFFFFF">
          <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="25">ㆍ<a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=03_cartoon"><span style='font:normal 11px 돋움;color:#666666;'><b>오늘의 만화</b></span></a>&nbsp;&nbsp;</td>
            </tr>
            <tr>
              <td height="117" style="border-width:1 0 1 0; border-color:#dddddd; border-style:solid;padding:5" align="center"><? echo latest_sql("03_img_s", "03_cartoon", 2, 25, "","RAND()", "3650"); ?></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="26" valign="middle">ㆍ<span style='font:normal 11px 돋움;color:#666666;'><b>커뮤니티/여성포털</b></span></td>
              </tr>
              <tr>
                <td style="border-width:1 0 0 0; border-color:#dddddd; border-style:solid;padding:5" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td><a href="http://video.pullbbang.com" target="_blank"><font color="#666666">풀빵닷컴</font></a></td>
                    <td><a href="http://tvpot.daum.net" target="_blank"><font color="#666666">다음TV팟</font></a></td>
                    <td><a href="http://www.mgoon.com" target="_blank"><font color="#666666">엠군</font></a></td>
                  </tr>
                  <tr>
                    <td><a href="http://www.pandora.tv" target="_blank"><font color="#666666">판도라TV</font></a></td>
                    <td><a href="http://www.afreeca.com" target="_blank"><font color="#666666">아프리카TV</font></a></td>
                    <td><a href="http://kr.youtube.com" target="_blank"><font color="#666666">유튜브</font></a></td>
                  </tr>
                </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="10">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td><a href="http://www.miclub.com" target="_blank"><font color="#666666">마이클럽</font></a></td>
                      <td><a href="http://www.ezday.co.kr" target="_blank"><font color="#666666">이지데이</font></a></td>
                      <td><a href="http://patzzi.joins.com" target="_blank"><font color="#666666">팟찌</font></a></td>
                    </tr>
                    <tr>
                      <td><a href="http://www.azoomma.com" target="_blank"><font color="#666666">아줌마닷컴</font></a></td>
                      <td><a href="http://www.women.go.kr" target="_blank"><font color="#666666">위민넷</font></a></td>
                      <td><a href="http://www.miz.co.kr" target="_blank"><font color="#666666">미즈</font></a></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
						
						</td>



          <td align="center" width="450" valign="top">
		  
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
							<td align="center"></td>
            </tr>
<script type="text/javascript">
function display_change(arg){
	document.getElementById('zone01').style.display='none';
	document.getElementById('zone02').style.display='none';
	document.getElementById('zone03').style.display='none';
	document.getElementById('zone04').style.display='none';
	document.getElementById('zone05').style.display='none';
	var elem=document.getElementById(arg);
	elem.style.display='block';
}
</script>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="25" style="border-width:1 0 0 0; border-color:#dddddd; border-style:solid;padding:0"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="10">&nbsp;</td>
											<td>
											ㆍ<a href="http://fun.<?=$domain?>"><span style='font:normal 11px 돋움;color:#666666;'><b>FUN &amp; JOY</b></span></a>
											ㆍ<a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=03_movie" onmouseover="display_change('zone05')"><span style='font:normal 11px 돋움;color:#666666;'>화제의 영상</span></a>
											ㆍ<a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=03_bizarre" onmouseover="display_change('zone03')"><span style='font:normal 11px 돋움;color:#666666;'>코믹</span></a>
											ㆍ<a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=03_cartoon" onmouseover="display_change('zone02')"><span style='font:normal 11px 돋움;color:#666666;'>웹툰</span></a>
											ㆍ<a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=03_game" onmouseover="display_change('zone04')"><span style='font:normal 11px 돋움;color:#666666;'>게임</span></a>
											ㆍ<a href="http://fun.<?=$domain?>/bbs/board.php?bo_table=<?=$grid?>_free" onmouseover="display_change('zone01')"><span style='font:normal 11px 돋움;color:#666666;'>자유게시판</span></a>
										</td>
                  </tr>
                </table></td>
              </tr>


              <tr>
                <td style="border-width:1 0 0 0; border-color:#dddddd; border-style:solid;padding:5px 5px 0 5px">
				
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
										<td width="10">&nbsp;</td>
										<td>
                                        <div id="zone01" style="display:none"><?=latest("main_joy_latest2", "{$grid}_free", 4, 30, "RAND()", "", "");?></div>
                                        <div id="zone02" style="display:none"><?=latest_sql("main_joy_latest2", "03_cartoon", 4, 30,"", "RAND()", "3650");?></div>
                                        <div id="zone03" style="display:none"><?=latest_sql("main_joy_latest2", "03_bizarre", 4, 30, "", "RAND()", "7");?></div>
                                        <div id="zone04" style="display:none"><?=latest("main_joy_latest2", "03_game", 4, 30,"","", "");?></div>
                                        <div id="zone05" style="display:block"><?=latest_sql("main_joy_latest2", "03_movie", 4, 30, "", "RAND()", "7");?></div>
                                       
                                        </td>
										</tr>
									</table>
								</td>
              </tr>

            </table>
		
		
					</td>
        </tr>
      </table>
	 
	 
	</td>
    <td width="260"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td colspan="2">
        <img src="/img/00_main/main_banner_tv2.gif" alt="" usemap="#main_tv" style="margin-bottom:6px;" />
			<map name="main_tv">
				<area shape="rect" coords="0,0,152,50" href="http://news.<?=$domain?>" title="뉴스모아" />
				<!--<area shape="rect" coords="152,0,260,50" href="http://damoum.tv/" target="_blank" title="imTV" />-->
				<area shape="rect" coords="152,0,260,50" href="http://tv.ggnn.net/" target="_blank" title="모아티비" />
			</map>
        
        </td></tr>
        <!--<tr> 
          <td style="padding:0 ; vertical-align:top ; background:#efefef">
          

          
          <img src="/img/00_main/weather_left.gif" alt="" style="border:0" /></td>
					<td style="padding:0 ; background:#efefef"><iframe src="<?=$weather?>" width="195" height="145" scrolling="no" frameborder="0" allowtransparency="true"></iframe></td>
        </tr>
        <tr> 
          <td height="5" colspan="2"></td>
        </tr>-->
      </table>

      <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dddddd" height="145">

        <tr> 
          <td bgcolor="#FFFFFF" height="26" align="center">
						<div id="main_right_shop_css">
							<a href="http://shop.<?=$domain?>" style="color:#985c3d">모아몰</a> |
							<a href="http://shop.<?=$domain?>/shop/list.php?ca_id=<?=$sid?>">지역특산물</a> |
							<a href="http://shop.<?=$domain?>/shop/list.php?ca_id=ca">모아쿠폰</a> |
							<a href="http://shop.<?=$domain?>/shop/listtype.php?type=2">추천상품</a> 
						</div>
					</td>
        </tr>
        <tr>
          <td height="40" valign="top" bgcolor="#FFFFFF"><? //display_type(2, "maintype11_1.inc.php", 4, 6, 55, 48, "%' and ca_id not like 'da%' and ca_id not like 'ea%");?></td>
        </tr>

<tr><td style="background-color:#FFF"><br />

          <img src="/img/00_main/main_banner_tv2.gif" alt="" usemap="#main_tv2" style="margin-bottom:6px;" />
			<map name="main_tv2">
				<area shape="rect" coords="0,0,152,50" href="http://news.<?=$domain?>" title="뉴스모아" />
				<!--<area shape="rect" coords="152,0,260,50" href="http://damoum.tv/" target="_blank" title="imTV" />-->
				<area shape="rect" coords="152,0,260,50" href="http://tv.ggnn.net/" target="_blank" title="모아티비" />
			</map>

</td></tr>

<!-- 
        <tr>
          <td height="24" valign="middle" bgcolor="#FFFFFF" class="style2"> <span class="style1">ㆍ</span>오픈마켓<span class="style1">ㆍ</span></td>
        </tr>
        <tr>
          <td height="36" valign="middle" bgcolor="#FFFFFF"><p align="center"><font color="#000000"><a href="http://www.auction.co.kr" target="_blank"><font color="#666666"> 옥션 </font></a></font><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><font color="#000000"><a href="http://www.gmarket.co.kr" target="_blank"><font color="#666666">G마켓 </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a></font><a href="http://www.11st.co.kr" target="_blank"><font color="#666666">11번가 </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://www.interpark.com" target="_blank"><font color="#666666">인터파크</font></a><a href="http://www.gsshop.com" target="_blank"><font color="#666666"> </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://www.gsshop.com" target="_blank"><font color="#666666">GS SHOP</font></a><a href="http://www.hmall.com" target="_blank"><font color="#666666"> Hmall </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://mall.shinsegae.com" target="_blank"></a><a href="http://www.dnshop.com" target="_blank"><font color="#666666">D&amp;SHOP </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://www.lotte.com" target="_blank"><font color="#666666">롯데닷컴 </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://www.akmall.com" target="_blank"><font color="#666666">AK몰 </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://www.cjmall.com" target="_blank"><font color="#666666">CJ홈쇼핑</font></a></p>
          </td>
        </tr>
        <tr>
          <td height="20" valign="middle" bgcolor="#FFFFFF" class="style3"><span class="style1">ㆍ</span>가격비교<span class="style1">ㆍ</span></td>
        </tr>
        <tr> 
          <td height="14" valign="middle" bgcolor="#FFFFFF"><p><a href="http://shopping.naver.com" target="_blank"><span class="style4">-</span><span class="style4">-</span><font color="#666666">네이버쇼핑</font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://shopping.naver.com" target="_blank"><font color="#666666">          </font></a><a href="http://www.danawa.com" target="_blank"><font color="#666666">다나와</font></a><a href="http://www.enuri.com/" target="_blank"><font color="#666666"> </font></a><a href="http://www.auction.co.kr" target="_blank"><span class="style5">|</span></a><a href="http://www.enuri.com/" target="_blank"><font color="#666666"> 에누리닷컴</font></a></p>
          </td>
        </tr> -->
      </table>
    </td>
  </tr>
</table>

<!-- 가맹점 -->
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" id="main_rolling">
  <tr> 
    <td align="center">

			<div id="main_store_banner_title"><a href="http://store.<?=$domain?>/bbs/board.php?bo_table=01_store&wr_5=<?=urlencode(str_replace("모아" , "" , $SITE_NAME))?>&wr_51=<?=urlencode(str_replace("모아" , "" , $SITE_NAME))?>"><img src="/img/00_main/main_store_title.gif" alt="" /></a><a href="" onclick="window.open('/popup/popup.php','','width=615px , height=842px , scrollbars=yes , status=no') ; return false ;"><img src="/img/00_main/icon_detail.gif" alt="상세보기" class="btn_detail" /></a></div>
      <div id="main_store_banner_div">
				<?=latest_main_left("main_store_banner", "01_store", 1000, 0, "rand()", "and wr_link2='1'", ""); ?>
			</div>
    </td>
  </tr>
</table>

<script type="text/javascript">
<!--// 배너 롤링
var main_banner_rolling = new jsRolling(document.getElementById('main_store_banner_div'));
main_banner_rolling.setDirection(4);
main_banner_rolling.start();
//-->
</script>

<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td align="center">
      <? include_once("$g4[path]/vote/inc_vote.php");?>
    </td>
  </tr>
</table>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"><? include_once("$g4[path]/inc/inc_copy.php"); ?></td>
  </tr>
</table>
<?
include_once("$g4[path]/tail.sub.php"); 
//include_once("$g4[path]/bbs/counter/zerocounter.php");
?>