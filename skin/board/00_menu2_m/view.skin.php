<?
if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ� 
include ("../inc/inc_project.php");

$pg_prevlink = $view[wr_link1];
if(!$pg_prevlink){$pg_prevlink="javascript:history.go(-1);";}

$app_link=(strpos($_SERVER['HTTP_USER_AGENT'],"Android"))?"market://details?id=kr.or.moa.app.".$project_code."&target=blank":"https://play.google.com/store/apps/details?id=kr.or.moa.app.".$project_code;

$custom_menu_bg1=($view[wr_4])?$view[wr_4]:"#f0f0f0";
$custom_menu_bg2=($view[wr_5])?$view[wr_5]:"#dddddd";
$custom_menu_bd1=($view[wr_6])?$view[wr_6]:"#eff1f4";
$custom_menu_bd2=($view[wr_7])?$view[wr_7]:"#c3c9d4";
$custom_menu_color=($view[wr_8])?$view[wr_8]:"#313F53";
$custom_menu_color_shadow=($view[wr_9])?$view[wr_9]:"1px 1px 1px #FFFFFF";

$css_name=($view[wr_10])?$view[wr_10]:"custom-menu";
?>

<style>
/*�űԽ�Ÿ��*/
.custom-menu {}
.custom-menu div{
	text-align:center;border-top:1px solid <?=$custom_menu_bd1?>; border-left:1px solid <?=$custom_menu_bd1?>; border-bottom:1px solid <?=$custom_menu_bd2?>; border-right:1px solid <?=$custom_menu_bd2?>; font-size:14px;
}
.custom-menu div.ui-block-c {border-right:0px;}


.custom-menu div a{display:block; text-decoration:none; padding:13px 0 12px 0; height:100%;background-image: -webkit-gradient(linear, left top, left bottom, from( <?php echo $custom_menu_bg1?> ), to( <?php echo $custom_menu_bg2?>));
	background-image: -webkit-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: -moz-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: -ms-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: -o-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);}
.custom-menu div a:hover{background-image: -webkit-gradient(linear, left top, left bottom, from( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/), to( <?=$custom_menu_bg1?> /*{l-bar-background-end}*/));
	background-image: -webkit-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: -moz-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: -ms-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: -o-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);}
.custom-menu div span {display:block; color:<?=$custom_menu_color?>; text-shadow:<?=$custom_menu_color_shadow?>}
</style>

<style>
/*�űԽ�Ÿ��*/
.custom-menu2 {}
.custom-menu2 div{
	text-align:center;border-top:1px solid <?=$custom_menu_bd1?>; border-left:1px solid <?=$custom_menu_bd1?>; border-bottom:1px solid <?=$custom_menu_bd2?>; border-right:1px solid <?=$custom_menu_bd2?>; font-size:20px; position:relative; padding-bottom:10px;
}
.custom-menu2 div a span{  font-size:14px; position:absolute; bottom:5px;left:0px;width:100%; ; 
}
.custom-menu2 div a{ color:<?=$custom_menu_color?> !important;}
.custom-menu2 div img{
	width:90%; height:auto;
}

.custom-menu3 div.ui-block-c {border-right:0px;}


.custom-menu3 div a{display:block; padding:13px 0 12px 0; height:100%;background-image: -webkit-gradient(linear, left top, left bottom, from( <?php echo $custom_menu_bg1?> ), to( <?php echo $custom_menu_bg2?>));
	background-image: -webkit-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: -moz-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: -ms-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: -o-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/);
	background-image: linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg2?> /*{l-bar-background-end}*/); }
	
.custom-menu3 div a:hover{background-image: -webkit-gradient(linear, left top, left bottom, from( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/), to( <?=$custom_menu_bg1?> /*{l-bar-background-end}*/));
	background-image: -webkit-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: -moz-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: -ms-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: -o-linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/);
	background-image: linear-gradient( <?=$custom_menu_bg1?> /*{l-bar-background-start}*/, <?=$custom_menu_bg1?> /*{l-bar-background-end}*/); }
.custom-menu3 div span {display:block; color:<?=$custom_menu_color?>; text-shadow:<?=$custom_menu_color_shadow?>}
</style>

<? 
$str_temp="";
if($pgt){$str_temp=$pgt;}
elseif($wr_id){$str_temp=$view[wr_subject];}
elseif($wr_6){$str_temp=$wr_5.":".$wr_6;}
elseif($wr_5){$str_temp=$sca.":".$wr_5;}
elseif($sca){$str_temp=$board[bo_subject].":".$sca;}
else{$str_temp=$board[bo_subject];}
$header_title_text=$str_temp;
$header_position_fix=" data-position=\"\" ";
$is_header_button_left = true;
$is_header_button_right = true;

if(!$is_project){
	$grid2="app.".$project_code;
}else{
	$grid2=$grid;
}

$app_link=(strpos($_SERVER['HTTP_USER_AGENT'],"Android"))?"market://details?id=kr.or.moa.".$grid2."&target=blank":"https://play.google.com/store/apps/details?id=kr.or.moa.".$grid2;

$is_app=false;
if(get_session('ss_app')!="") $is_app=true;
if($project_code) {$appver =$project['version'];}
	
if($is_app){//������ ���� ��
	if(get_session('ss_app')<$appver){//������Ʈ�� �ִ�..
		$header_button_left_text="������Ʈ";
		$header_button_left_link=$app_link."\" data-theme=\"e\" style=\"width:80px;border-radius:7px;";
	}else{
		$header_button_left_text="ver".get_session('ss_app');
		$header_button_left_link="#\" data-theme=\"b\" style=\"width:80px;border-radius:7px; color:white";
	}
}else{//������ ���� ��...
	$header_button_left_text="�ۼ�ġ";
	$header_button_left_link=$app_link."\" style=\"width:80px;border-radius:7px;";
	
}
$header_subtitle="&nbsp;";


if(!$is_project){
	$url_short="http://".$domain."/".$view[wr_id];
}else{
	$result_serial = get_serial($wr_id,$bo_table);
	$url_short="http://myme.kr/".$result_serial;
}

if($project['code']=='election'&&get_cookie('ss_coords')&&get_cookie('ss_address1')&&get_cookie('ss_address2')&&get_cookie('ss_address3')){

preg_match("/����:(.*),����:(.*),�ִ�:(.*),��ü:(.*)/", $config[cf_visit], $visit);
	
	
	$header_subtitle="<span style='float:left; padding-left:10px;'>��ġ: ".get_cookie('ss_address1')." ".get_cookie('ss_address2')." ".get_cookie('ss_address3')."</span><span style='float:right;padding-right:10px;'>��ȸ��: ".number_format($visit[4]+1500000)."</span><br style='clear:both'/>";
	
	
}

if($project['code']!='election'&&$wr_id==1){
	$header_subtitle="http://<span style='color:yellow'>".$project['code']."</span>."."kr";
}

if($project['code']=='mhm'&&$wr_id==1){
	$header_subtitle="http://".$_SERVER['HTTP_HOST'];
}
if($project_code=="one"&&$wr_id==2){
	$header_subtitle="���� 257-01-167696  (��)���";
}

if($project_code=="one"&&$wr_id==1){
	$header_subtitle="http://<span style='color:yellow'>".$project['code']."p</span>.kr";
}

$suffix="";
if($_GET['mb_id']) $suffix="/".$_GET['mb_id'];

// ��ܿ� �ּ� ��������
if($project_code=="mcard"&&$wr_id==1){
	$hdH2="<div style='margin:0 auto; text-align:center; font-size:14px'>http://popay.kr{$suffix}</div>";
}else if($project_code && $wr_id==1){
	$hdH2="<div style='margin:0 auto; text-align:center; font-size:14px'>http://".$project_code.".popay.kr{$suffix}</div>";
}





$include_head="_header.php";
$include_foot="_footer.php";

$include_menu_name="_content.menu.php";

if($project['code']=="ihb") {
	$css_name="service-menu_ihb";
	$include_menu_name="_content.menu_ihb.php";
	$include_head="_header_ihb.php";
	$include_foot="_footer_ihb.php";
	$header_theme="p";
}

$css_name="service-menu_card";
$include_menu_name="_content.menu_card.php";

//if($member['mb_id'] == "01054341861") $include_menu_name="_content.menu_test.php";

$hdH1 = $header_title_text;
?>
<div data-role="page" data-theme="u" data-title="<?=$hdH1?>" >

<? include_once("../m/_header2.php"); ?>
    
<div data-role="content" style="padding:0;  <? if($project_code=="ihb"&&$wr_id==1){?> ;background:#fff; <? }?>">


<? if(($project_code=="one" || $project_code=="card")&& ($member[mb_id]!="moa"&&$member[mb_id]!="01055555555"&&$member[mb_id]!="01011111111"&&$member[mb_id]!="01022222222"&&$member[mb_id]!="01033333333"&&$member[mb_id]!="01044444444"&&$member[mb_id]!="saintsad") ){ ?>	


    


<? }else{?>


<? if($project_code=="sopoong"&& $wr_id==1){?> 
<iframe width="100%" height="205" src="//www.youtube.com/embed/BUSAXBbRkT0" frameborder="0" allowfullscreen></iframe>
<? }?>    

 <? if($project_code=="camp"&& $wr_id==1){?> 
<iframe width="100%" height="205" src="//www.youtube.com/embed/yki8ZIpIBL0" frameborder="0" allowfullscreen></iframe>
<? }?> 
    
    
 <? if($project_code=="dano"&& $wr_id==1){?> 
<iframe width="100%" height="205" src="//www.youtube.com/embed/fxaND9UaeO8" frameborder="0" allowfullscreen></iframe>
<? }?> 


<? if($project_code=="ksb"&& $wr_id==2){?>

<style>
.video-container{position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;  } 
.video-container iframe,.video-container object,.video-container embed{position:absolute;top:0;left:0;width:100%;height:100%;} 
</style>
<div class="div_iframe" style="padding:10px; font-size:12.4px; line-height:22px; background:#666; color:#fff; text-shadow:0px 0px 0px #666;">����� �ð��� �ƴҰ�� �������(VOD)�� ��û �����մϴ�. <br/>�ε�(15~20��) �� ��(�÷���)��ư�� Ŭ���ϼ���</div>
<div class="video-container">

<? if($config[cf_3]=="1"){?>
	<iframe src="http://www.ustream.tv/embed/14342631?v=3&wmode=direct" scrolling="no" style="border: 0px none transparent;" frameborder="0" height="315" width="100%"></iframe> 
<? }elseif($config[cf_3]=="2"){?>
	<iframe width="100%" height="315" src="http://www.ustream.tv/embed/20413309?v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0px none transparent;"></iframe>
<? }//if($config[cf_3]=="1"){?>

</div>
<div style="height:50px; background-color:#666;"></div>
<? }?> 

<?
$banner_table=$grid."_banner";
if($project_code && $project_code!="saxo") $banner_table=$banner_table."_".$project_code;
?>  

<?//=$view[wr_2]?>
<? if($view[wr_2]!=""){?>
<?=latest("mobile_banner_top", $banner_table , 100 , 0, "RAND()", "", $view[wr_2],"");?>
<? }?> 
<? if($project_code=="mhm"&&$wr_id==1){?>
<div style="position:absolute; top:33%; width:100%; text-align:center" >
<a href="/bbs/board.m.php?bo_table=i01_store_mhm&sca=&wr_5=&wr_6=&sop=and&sfl=&sst=wr_datetime&sod=desc"><img src="/m/img/bt01.png" width="22%" style=" float:left; padding-left:20px; padding-top:25px;" /></a> 
<a href="/bbs/write.m.php?bo_table=i01_store_mhm"><img  src="/m/img/bt02.png"  width="30%"  /></a>
<a href="http://www.mhm.kr/bbs/board.m.php?bo_table=i01_menu_ksb&wr_id=2&target=blank" target="_blank"><img src="/m/img/bt03.png" width="22%"  style=" float:right; padding-right:20px; padding-top:25px;" /></a>
</div>
<? }?>




<!-- ������ ����/���� ��ư -->
<? if($project_code=="card" && $wr_id==1 && $member['mb_6']){?>
<div style="position:absolute; top:120px; width:100%; text-align:center" >
<a href="/onep/merchants_earn.m.php?project=mcard&type=2&project_code=mcard"><img src="/m/img/bts01.png" width="18%" style=" float:right; padding-right:20px; padding-top:25px;" /></a>
</div>
<? }else if($project_code && $wr_id==1 && $member['mb_6']) {?>
<div style="position:absolute; top:120px; width:100%; text-align:center" >
<a href="/onep/merchants_earn.m.php?project=mcard&type=2&project_code=<?=$project_code?>"><img src="/m/img/bts01.png" width="18%" style=" float:right; padding-right:20px; padding-top:25px;" /></a>
</div>
<? }?>


<!-- Ȩ��������, ����Ʈ���� ��ư -->
<? if($project_code=="rocket" && $wr_id==1){ ?>
<div style="position:absolute; top:195px; width:100%; text-align:center" >
<a href="http://www.uhome.kr/app/board.php?bo_table=rocket_00&wr_id=2&target=blank" target="_blank"><img src="/m/img/btn3.png" width="20%" style=" float:right; padding-right:20px; padding-top:25px;" /></a>
</div>
<? }else if($project_code && $wr_id==1) {?>
<div style="position:absolute; top:195px; width:100%; text-align:center" >
<a href="/bbs/board.m.php?bo_table=i01_ad_mcard&wr_id=130&project_code=<?=$project_code?>"><img src="/m/img/btn3.png" width="20%" style=" float:right; padding-right:20px; padding-top:25px;" /></a>
</div>

<div style="position:absolute; top:220px; left:15px; width:50%; pa text-align:left" >
<a href="/onep/point_buy2.m.php?project=<?=$project_code?>&project_code=<?=$project_code?>&type=1"><img src="/m/img/pobtn.png" width="40%" style=" " /></a>
</div>
<? }?>





<? if(($project_code=="one" || $project_code=="mpoint")&&$wr_id==1){?>
<div style="position:absolute; top:29%; width:100%; text-align:center" >
<a href="/bbs/board.m.php?bo_table=i01_store_mhm&sca=&wr_5=&wr_6=&sop=and&sfl=&sst=wr_datetime&sod=desc"><img src="/m/img/bt01.png" width="22%" style=" float:left; padding-left:20px; padding-top:25px;" /></a> 
<a href="/bbs/write.m.php?bo_table=i01_store_mhm"><img  src="/m/img/bt02.png"  width="30%"  /></a>
<a href="http://www.mhm.kr/bbs/board.m.php?bo_table=i01_menu_ksb&wr_id=2&target=blank" target="_blank"><img src="/m/img/bt03.png" width="22%"  style=" float:right; padding-right:20px; padding-top:25px;" /></a>
</div>
<? }?>


<? if($project_code=="ihb"&&$wr_id==1){?>

<div style="position:absolute; top:0;text-align:right; width:100%; padding:15px 20px 0 0; box-sizing:border-box;  ">

<? if(!get_session('ss_app')){?>


<span><a href="market://details?id=kr.or.moa.app.ihb&target=blank" >
<img src="/m/img/appsetup.png" style="width:58px;">
</a></span>


<? }else{?>


<span><a href="market://details?id=kr.or.moa.app.ihb&target=blank" ><? if( get_session('ss_app') < 2){?><img src="/m/img/appsetup2.png" style="width:48px;"><? }else{?><img src="/m/img/appsetup.png" style="width:58px;"><? }?></a></span>
<? }?>
<? if($member[mb_id]){?><span style="margin-left:20px;"><a href="/bbs/logout.m.php?wr_id=1&url=%2Fbbs%2Fboard.m.php%3Fbo_table%3Di01_menu_ihb%26wr_id%3D1"><img src="/m/img/logout.png" style="width:45px;" /></a></span>
<? } else {?>
<span style="margin-left:20px;"><a href="/bbs/login.m.php?wr_id=1&url=%2Fbbs%2Fboard.m.php%3Fbo_table%3Di01_menu_ihb%26wr_id%3D1"><img src="/m/img/login.png" style="width:34px;" /></a></span>
<? }?>
</div>

<?


	$isNew=false;
	//echo get_cookie('ck_i01_list_ihb');
	//if(isReaded('ck_i01_list_ihb','')) $isNew=true;

	$strdate=(get_cookie("ck_i01_list_ihb"))?get_cookie("ck_i01_list_ihb"):mktime(date("H")-24,date("i"),date("s"),date("m"),date("d"),date("y"));
	$sql = " select count(*) as cnt from g4_write_i01_list_ihb where wr_is_comment=0 and wr_datetime > '".date("Y-m-d H:i:s", $strdate)."' ";
	$row_temp = sql_fetch($sql);
	$count = $row_temp['cnt'];
	
	$isNew=($count)?true:false;
	
	//if($isNew){	
	//echo $count."-".$strdate;
  //}
	
?>


<div style="position:absolute; top:81%; width:100%; text-align:center; padding:0 2.5%; box-sizing:border-box;">
<span style="display:block; width:32%; text-align:center; padding:0px ; border-radius:0.5em;  float:right;"><a href="<? if($member&&($member[mb_id]=="2014ihb" || $member[mb_id]=="moa" || $member[mb_id]=="ihb_adm")){?>/bbs/board.m.php?bo_table=i01_menu_ihb&wr_id=125<? }else{?>/bbs/login.m.php?wr_id=&url=board.m.php%3Fbo_table%3Di01_menu_ihb%26wr_id%3D125<? }?>"><img src="/m/img/mainbt03.png"  style="width:100%;" /></a></span>
<span style="display:block; width:32%; text-align:center; padding:0px ; border-radius:0.5em; float:left;"><a href="<? if($member&&($member[mb_id]=="2014ihb" || $member[mb_id]=="moa" || $member[mb_id]=="ihb_adm")){?>/bbs/board.m.php?bo_table=i01_menu_ihb&wr_id=2<? }else{?>/bbs/login.m.php?wr_id=&url=board.m.php%3Fbo_table%3Di01_menu_ihb%26wr_id%3D2<? }?>"><img src="/m/img/mainbt01.png"  style="width:100%;" /></a></span>
<span style=" position:relative;display:block; width:32%; text-align:center; padding:0px ; border-radius:0.5em; margin:0 auto; "><a href="<? if($member&&($member[mb_id]=="2014ihb" || $member[mb_id]=="moa" || $member[mb_id]=="ihb_adm")){?>/bbs/board.m.php?bo_table=i01_menu_ihb&wr_id=3<? }else{?>/bbs/login.m.php?wr_id=&url=board.m.php%3Fbo_table%3Di01_menu_ihb%26wr_id%3D3<? }?>"><img src="/m/img/mainbt022.png"  style="width:100%;" /></a></span>
</div>

<div style="position:absolute; top:89%; width:100%; text-align:center; padding:0 2.5%; box-sizing:border-box;">
<span style="display:block; width:32%; text-align:center; padding:0px ; border-radius:0.5em;  float:right;"><a href="<? if($member&&($member[mb_id]=="2014ihb" || $member[mb_id]=="moa" || $member[mb_id]=="ihb_adm")){?>/bbs/board.m.php?bo_table=i01_menu_ihb&wr_id=4<? }else{?>/bbs/login.m.php?wr_id=&url=board.m.php%3Fbo_table%3Di01_menu_ihb%26wr_id%3D4<? }?>"><img src="/m/img/mainbt062.png" style="width:100%;" /><!--<img src="/m/img/n.png" width="27" height="27" style="position:absolute; top:-7px;right:-7px;" />--></a></span> 
<span style="display:block; width:32%; text-align:center; padding:0px ; border-radius:0.5em; float:left;"><a href="<? if($member&&($member[mb_id]=="2014ihb" || $member[mb_id]=="moa" || $member[mb_id]=="ihb_adm")){?>/bbs/board.m.php?bo_table=i01_menu_ihb&wr_id=5<? }else{?>/bbs/login.m.php?wr_id=&url=board.m.php%3Fbo_table%3Di01_menu_ihb%26wr_id%3D5<? }?>"><img src="/m/img/mainbt04.png"  style="width:100%;" /></a></span>
<span style="display:block; width:32%; text-align:center; padding:0px ; border-radius:0.5em; margin:0 auto; "><a href="<? if($member&&($member[mb_id]=="2014ihb" || $member[mb_id]=="moa" || $member[mb_id]=="ihb_adm")){?>/bbs/board.m.php?bo_table=i01_list_ihb<? }else{?>/bbs/login.m.php?wr_id=&url=board.m.php%3Fbo_table%3Di01_list_ihb<? }?>"><img src="/m/img/mainbt05.png"  style="width:100%;" /><? if($isNew){echo "<img style=\"position:absolute; margin-top:-6px; margin-left:-15px;\"src=\"/m/img/n.png\" width=\"25\" height=\"25\" />";}?></a></span>
</div>

<? }?>



<?
$wr_mn = $view;
$input_menu_string=trim($wr_mn[wr_content]);
$row_count=trim($wr_mn[wr_1]);
$colnum = $row_count;
?>

<? include_once("../m/_function.php");?>

<?php $temp_project = $project;?>
<? include_once("../m/_content.menu.filter.php");?>
<?php $project = $temp_project;?>

<?php

if($member['mb_name'] == "�����ȸ��") {  // ���� �α����� ������� �̸��� "�����ȸ��" �̸� �̸����ȭ������
	alert("�̸��� ����ϼž� �մϴ�.", "../onep/provisional_form.m.php?project_code=$project_code");
}

if($menu_css_name){
	$css_name = $menu_css_name;
}

?>









<div class="<?=$css_name?>" ><!--�߰� �޴����� �κ�-->

<?php if($project['code']=="mcard"&& $_GET[wr_id]==1){?>
<div class="ui-grid-b" style="position:relative; top:-3px; border:0px">
    <div class="ui-block-a">
        <a href="/bbs/board.m.php?bo_table=i01_page_mcard&wr_id=11" title="�Ŵ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #62bf8c ), to( #62bf8c ));background-image: -webkit-linear-gradient( #62bf8c , #62bf8c);background-image: -moz-linear-gradient( #62bf8c, #62bf8c );background-image: -ms-linear-gradient( #62bf8c , #62bf8c);background-image: -o-linear-gradient( #62bf8c , #62bf8c );background-image: linear-gradient( #62bf8c , #62bf8c );
color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">�Ŵ���</span>
        </a>
    </div>
    
    <div class="ui-block-b">
    	<!--/onep/card_form2.m.php?w=&cd_id=&project=mcard&type=3-->
        <a href="/bbs/board.m.php?bo_table=i01_menu_mcard&wr_id=6" title="������õ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #e6646d ), to( #e6646d ));background-image: -webkit-linear-gradient( #e6646d , #e6646d);background-image: -moz-linear-gradient( #e6646d, #e6646d );background-image: -ms-linear-gradient( #e6646d , #e6646d);background-image: -o-linear-gradient( #e6646d , #e6646d );background-image: linear-gradient( #e6646d , #e6646d );color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������õ���</span>
        </a>
    </div>
    
    <div class="ui-block-c">
        <a href="/bbs/board.m.php?bo_table=i01_store_mcard&" title="������ã��" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #ffac0b ), to( #ffac0b ));background-image: -webkit-linear-gradient( #ffac0b , #ffac0b);background-image: -moz-linear-gradient( #ffac0b, #ffac0b );background-image: -ms-linear-gradient( #ffac0b , #ffac0b);background-image: -o-linear-gradient( #ffac0b , #ffac0b );background-image: linear-gradient( #ffac0b , #ffac0b );color:#ffffff; text-shadow:0 1px  0  #004134 ; padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������ã��</span>
        </a>
        </div>
</div>
<?php }?>
<?php if($project['code']=="hlzone"&& $_GET[wr_id]==1){?>
<div class="ui-grid-b" style="position:relative; top:-3px; border:0px">
    <div class="ui-block-a">
        <a href="/bbs/board.m.php?bo_table=i01_page_hlzone&wr_id=10" title="�Ŵ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #62bf8c ), to( #62bf8c ));background-image: -webkit-linear-gradient( #62bf8c , #62bf8c);background-image: -moz-linear-gradient( #62bf8c, #62bf8c );background-image: -ms-linear-gradient( #62bf8c , #62bf8c);background-image: -o-linear-gradient( #62bf8c , #62bf8c );background-image: linear-gradient( #62bf8c , #62bf8c );
color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">�Ŵ���</span>
        </a>
    </div>
    
    <div class="ui-block-b">
    	<!--/onep/card_form2.m.php?w=&cd_id=&project=mcard&type=3-->
        <a href="/bbs/board.m.php?bo_table=i01_menu_hlzone&wr_id=6" title="ī����õ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #e6646d ), to( #e6646d ));background-image: -webkit-linear-gradient( #e6646d , #e6646d);background-image: -moz-linear-gradient( #e6646d, #e6646d );background-image: -ms-linear-gradient( #e6646d , #e6646d);background-image: -o-linear-gradient( #e6646d , #e6646d );background-image: linear-gradient( #e6646d , #e6646d );color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������õ���</span>
        </a>
    </div>
    
    <div class="ui-block-c">
        <a href="/bbs/board.m.php?bo_table=i01_store_mcard&project_code=hlzone"  title="������ã��" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #ffac0b ), to( #ffac0b ));background-image: -webkit-linear-gradient( #ffac0b , #ffac0b);background-image: -moz-linear-gradient( #ffac0b, #ffac0b );background-image: -ms-linear-gradient( #ffac0b , #ffac0b);background-image: -o-linear-gradient( #ffac0b , #ffac0b );background-image: linear-gradient( #ffac0b , #ffac0b );color:#ffffff; text-shadow:0 1px  0  #004134 ; padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������ã��</span>
        </a>
        </div>
</div>
<?php }?>

<?php if($project['code']=="rocket"&& $_GET[wr_id]==1){?>
<div class="ui-grid-b" style="position:relative; top:-3px; border:0px">
    <div class="ui-block-a">
        <a href="/bbs/board.m.php?bo_table=i01_page_rocket&wr_id=10" title="�Ŵ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #62bf8c ), to( #62bf8c ));background-image: -webkit-linear-gradient( #62bf8c , #62bf8c);background-image: -moz-linear-gradient( #62bf8c, #62bf8c );background-image: -ms-linear-gradient( #62bf8c , #62bf8c);background-image: -o-linear-gradient( #62bf8c , #62bf8c );background-image: linear-gradient( #62bf8c , #62bf8c );
color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">�Ŵ���</span>
        </a>
    </div>
    
    <div class="ui-block-b">
    	<!--/onep/card_form2.m.php?w=&cd_id=&project=mcard&type=3-->
        <a href="/bbs/board.m.php?bo_table=i01_menu_rocket&wr_id=6" title="ī����õ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #e6646d ), to( #e6646d ));background-image: -webkit-linear-gradient( #e6646d , #e6646d);background-image: -moz-linear-gradient( #e6646d, #e6646d );background-image: -ms-linear-gradient( #e6646d , #e6646d);background-image: -o-linear-gradient( #e6646d , #e6646d );background-image: linear-gradient( #e6646d , #e6646d );color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������õ���</span>
        </a>
    </div>
    
    <div class="ui-block-c">
        <a href="/bbs/board.m.php?bo_table=i01_store_mcard&project_code=rocket"  title="������ã��" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #ffac0b ), to( #ffac0b ));background-image: -webkit-linear-gradient( #ffac0b , #ffac0b);background-image: -moz-linear-gradient( #ffac0b, #ffac0b );background-image: -ms-linear-gradient( #ffac0b , #ffac0b);background-image: -o-linear-gradient( #ffac0b , #ffac0b );background-image: linear-gradient( #ffac0b , #ffac0b );color:#ffffff; text-shadow:0 1px  0  #004134 ; padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������ã��</span>
        </a>
        </div>
</div>
<?php }?>
<?php if($project['code']=="moapay"&& $_GET[wr_id]==1){?>
<div class="ui-grid-b" style="position:relative; top:-3px; border:0px">
    <div class="ui-block-a">
        <a href="/bbs/board.m.php?bo_table=i01_page_moapay&wr_id=11" title="�Ŵ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #62bf8c ), to( #62bf8c ));background-image: -webkit-linear-gradient( #62bf8c , #62bf8c);background-image: -moz-linear-gradient( #62bf8c, #62bf8c );background-image: -ms-linear-gradient( #62bf8c , #62bf8c);background-image: -o-linear-gradient( #62bf8c , #62bf8c );background-image: linear-gradient( #62bf8c , #62bf8c );
color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">�Ŵ���</span>
        </a>
    </div>
    
    <div class="ui-block-b">
    	<!--/onep/card_form2.m.php?w=&cd_id=&project=mcard&type=3-->
        <a href="/bbs/board.m.php?bo_table=i01_menu_moapay&wr_id=6" title="������õ���" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #e6646d ), to( #e6646d ));background-image: -webkit-linear-gradient( #e6646d , #e6646d);background-image: -moz-linear-gradient( #e6646d, #e6646d );background-image: -ms-linear-gradient( #e6646d , #e6646d);background-image: -o-linear-gradient( #e6646d , #e6646d );background-image: linear-gradient( #e6646d , #e6646d );color:#ffffff; text-shadow:0 1px  0  #004134 ;  padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������õ���</span>
        </a>
    </div>
    
    <div class="ui-block-c">
        <a href="/bbs/board.m.php?bo_table=i01_store_mcard&project_code=moapay" title="������ã��" class="ui-link" style="background-image: -webkit-gradient(linear, left top, left bottom, from( #ffac0b ), to( #ffac0b ));background-image: -webkit-linear-gradient( #ffac0b , #ffac0b);background-image: -moz-linear-gradient( #ffac0b, #ffac0b );background-image: -ms-linear-gradient( #ffac0b , #ffac0b);background-image: -o-linear-gradient( #ffac0b , #ffac0b );background-image: linear-gradient( #ffac0b , #ffac0b );color:#ffffff; text-shadow:0 1px  0  #004134 ; padding:0px">
        <span style="position:relative; top:-6px; padding-top:12px;font-size:16px">������ã��</span>
        </a>
    </div>
</div><!--�߰� �޴����� �κг�-->
<?php }?>

<? 
$project_code_temp = $project_code;
include_once("../m/".$include_menu_name);
$project_code = $project_code_temp;
?>
</div>









<? 
$get_wr_id=$_GET[wr_id];
if($project_code=="election" && $get_wr_id=="1"){?>
	<? if(get_cookie('ss_coords')!=""){?>
	<script>
		//alert('������ GPS���� �ֽ��ϴ�');
		//lcs_set_current_location()
	</script>
	<? }else{?>
	<script>
		//alert('������ GPS���� �����ϴ�');
		//alert('nhn');
		$(document).ready(function() { 
			//lcs_set_current_location();
		}); 
 
 		 
	</script>
    <? }?>
<? }?>

<?
if($_GET[bo_table]=="i01_menu_".$project_code && $view[wr_3]){

echo '<div >';

echo latest("mobile_banner_bottom", "i01_banner_".$project_code , 100 , 0, "RAND()", "", $view[wr_3],"");

echo '</div>';
}
?>

<?
if(_DEVELOP_){
	include('./visit_insert.inc.php');
	include('./visit.inc.php'); 
}
?>


<script>
<? if($view[wr_11]>=2){?>
	page_request_login = true;
<? }?>

<? if($wr_id==3&&$bo_table=="i01_menu_card"){
	if(!$mb_merchants){
?>
	alert('�� ������ �������� �Ѱ� �̻��̿��� �̿� �����մϴ�');
	history.go(-1);
<?	
	}else{
?>
	//alert('�� ������ ������: <?=$mb_merchants[mc_subject]?>');
<?	
	}
}
?>	


</script>

<? }// if(($project_code=="one" || $project_code=="card")&& $member[mb_id]!="01055555555"){?>

<? if($member['mb_id']=='saintsad' || $member['mb_id']=='saintsad2'){?>
<script type="text/javascript">
     function callApp(arg1, arg2) {
	 //alert('sdfsd');
		if(window.android){
             window.android.doShare(arg1, arg2);
		}else{
			alert('�۳� ������ �Դϴ�');
		}
     }
     function callApp2() {
	 //alert('sdfsd');
		if(window.android){
             window.android.doMenu();
		}else{
			alert('�۳� ������ �Դϴ�');
		}
     } </script>
<div style="border:1px solid red">
<div></div>
<a href="/onep/push2_list.m.php" data-role="button">Ǫ������Ʈ</a>
<a href="javascript:callApp('������ ����','ABC123 �ѱ�');" data-role="button">����</a>
<a href="javascript:callApp2();" data-role="button">�޴���ư</a>
<div><?=$reg_id?></div>

</div>
<? }?>

</div><!-- /content -->




<?php if ($callback) { ?>
<div data-role="popup" id="popupCallback" data-overlay-theme="a" style="min-width:200px; max-width:300px;">
	<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
	<div class="ui-content">
    <div class="ui-bar ui-bar-a">�˸�</div>
    <p style="font-size:20px;" id="pop_callback_text"><?=$callback?></p>
    </div>
</div>
<script>
	$(function(){
		
		if(localStorage.callback !='' ){
			$("#pop_callback_text").html(localStorage.callback);
			$( "#popupCallback" ).popup( "open");
			localStorage.callback='';
		}
		//localStorage['']='aaa';
		
	});
</script>
<?php }?>




<? $project_view_kakaoment=($project_view[wr_4])?$project_view[wr_4]:"���� �� ��õ�մϴ�. ���� �˷��ּ���"; ?>



<!--�ڵ��α����׽�Ʈ-->
<script>
	
<?php  if($member[mb_id]=='01044444444' && $_GET[wr_id]=="1"){ ?>

//localStorage['auto_id']="LocalStorage";

//$("#testZone").html(localStorage['auto_id']);

//if(typeof(localStorage['sadsad']) == "undefined"){
//	$("#testZone").html('hjgjhgjh');
//}

/*if(localStorage['auto_id'] == ''){
	localStorage['auto_id'] = '<?=$member[mb_id]?>';
	localStorage['auto_name'] = '<?=$member[mb_name]?>';
	localStorage['auto_datetime'] = '<?=date('Y-m-d')?>';
}

if(localStorage['auto_id'] != ''){
		//alert('�ڵ��α�������\n'+localStorage['auto_id']+'\n'+localStorage['auto_name']+'\n'+localStorage['auto_datetime']);
}
*/
<?php } ?>	

</script>
<!--�ڵ��α����׽�Ʈ-->


 
<? 
	
	if($_SERVER['HTTP_HOST']=="moabiz.net" || $_SERVER['HTTP_HOST']=="www.moabiz.net"){
		$footer_title_text="&copy; ��ƺ��� 202-33-63633";
	}else{
		$footer_title_text="&copy; ".$project_view[wr_subject];
	}
	
	if($_GET[wr_id]=="1"){//ù ��������
		set_session('location_home', $project_code);
		//set_session('location_home', $project_code);
		$footer_button_right_text="ī�����";
		
		$footer_button_left_link="/bbs/board.m.php?bo_table=".$grid."_menu_".$project_view[wr_1]."&wr_id=1";

		
		if($project_code=="election"){
		
			$footer_button_right_link="kakaolink://sendurl?msg=".urlencode(iconv("EUC-KR", "UTF-8", $project_view_kakaoment))."&url=market://details?id=kr.or.moa.app.".$project_code."&appid=kr.or.moa.app.".$project_code."&appver=1.0&appname=".urlencode(iconv("EUC-KR", "UTF-8", $project_view[wr_subject]))."&metainfo={metainfo:[{os:'android',devicetype:'phone',installurl:'market://details?id=kr.or.moa.app.".$project_code."',executeurl : 'moaapp".$project_code."://'}]}"."\" style=\"width:80px;border-radius:7px;";
			
			if(get_cookie('ss_coords')&&get_cookie('ss_address1')&&get_cookie('ss_address2')&&get_cookie('ss_address3')){
			$footer_button_left_text=get_cookie('ss_address3');
			}else{
			$footer_button_left_text='��ġã��';
			}
			
			$footer_button_left_link="javascript:lcs_set_current_location();"."\" style=\"width:80px;border-radius:7px;";
			
			
		}else{

			if($project_code=="election"){
			if($project_view_kakaoment=="���� �� ��õ�մϴ�. ���� �˷��ּ���") $project_view_kakaoment="���漱�� �ĺ��� ".$project_view[wr_subject]."�Դϴ� ���� ���� ��Ź�帳�ϴ�.";
			}
			$footer_button_right_link="kakaolink://sendurl?msg=".urlencode(iconv("EUC-KR", "UTF-8", $project_view_kakaoment))."&url=http://".$project_code.".".$_SERVER['HTTP_HOST']."&appid=".$domain."&appver=1.0";
			$footer_button_left_link="";
			
		}

	
		
				
	}else{//ù �������� �ƴ� Ȩ...
		if(get_session('location_home')){
			$footer_button_right_text="Ȩ";
			$footer_button_right_link="/bbs/board.m.php?bo_table=".$grid."_menu_".get_session('location_home')."&wr_id=1"."\" style=\"width:80px;border-radius:7px;";;
		}else{
			$footer_button_right_text="Ȩ";
			$footer_button_right_link="/bbs/board.m.php?bo_table=".$grid."_menu_".$project_view[wr_1]."&wr_id=1"."\" style=\"width:80px;border-radius:7px;";;
		}
		
	}
	
?>



<?


if($project[code]=="card") $ftH4="������Ʈ";
if($project[code]=="mcard") $ftH4="����Ʈ����";
if($project[code]=="hlzone") $ftH4="��������";
if($project[code]=="rocket") $ftH4="��������";
if($project[code]=="moapay") $ftH4="�������";


include_once('../m/_footer2.php');
?>



</div><!-- /page -->