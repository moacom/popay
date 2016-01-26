<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// bg_name
$bg_name="/".mt_rand(1, 5).".jpg";
if($project){
	if($project[file][1][file]) $bg_name=$project_view[file][1][path]."/".$project_view[file][1][file];
}

?>










<style>
#left_nav a{display:block; font-size:18px; border:1px solid rgb(54,25,25);background-color:rgba(54,25,25,.5); color:#ffffff;padding:7px 10px 7px 10px; text-shadow:0px 0px #000000}
#left_nav a:hover{background-color:rgba(54,25,25,.9); }
#left_nav a:active{background-color:rgba(54,25,25,1.0);}
</style>

<div data-role="page" data-theme="p" id="view" style=" background:url(<?=$bg_name?>); background-size:cover; background-position:center center">

<?=latest("mobile_banner_top", "i01_banner_".$project_code , 100 , 0, "RAND()", "", "myhome_intro","");?>
<div style=" font-size:3.5em;   text-shadow:5px 5px 10px rgba(25,25,25,.4); background:rgba(25,25,25,.4); color:#ffffff; padding:4px 0px 0px 8px;">
<?=$view[subject]?>
</div>
<?
$result_serial = get_serial($wr_id,$bo_table);
$url_short="http://".$_SERVER['HTTP_HOST']."/".$result_serial;
//$url_short="http://emoa.kr/42354";

?>
<div style=" font-size:1.3em; padding:0px 12px 8px 12px; text-shadow:0px 0px 0px #000000; background:rgba(25,25,25,.4); color:#ffffff; ">
<div style=" float:right;font-size:12px; padding-top:3px;">(<span id="cdDiv">10</span>초 후 자동이동)</div><?=$url_short?>
</div>






<div id="left_nav" style="position:absolute; right:0px; top:50%; width:40%;">


<?
//$sql_menu = " select wr_id from $write_table where wr_subject='_intro' ";    //원본
$sql_menu = " select wr_id from $write_table where wr_subject='_intro' ";    //원본
//echo $sql_menu;
$count_menu = sql_fetch($sql_menu);
if($count_menu){//인트로 메뉴가 설정되어 있는 경우
	$result_menu = sql_fetch("select wr_content from $write_table where wr_id=$count_menu[wr_id]");
	//$row_menu = sql_fetch($result_menu);
	//$row_menu[wr_content];

	$input_menu_string=trim($result_menu[wr_content]);
	include_once("../m/_content.menu.filter.php");
	foreach($menus as $key=>$data){ 
		$cnt++;
		
		echo "<div style=\"margin-bottom:4px\">";
		echo "<a href=\"".$data[1]."\">".$data[0]."</a>";
		echo "</div>";
	}
}else{
	?>
	
    <div style="margin-bottom:4px">
        <a href="/bbs/board.m.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&mb_id=<?=$mb_id?>">들어가기</a>
    </div>
    
	<? if(!$member[mb_id]){?>
    <div style="margin-bottom:4px">
        <a href="/bbs/login.m.php?url=<?=$urlencode?>" >로그인</a>
    </div>
    <? }else{?>
        <a href="/bbs/logout.m.php?url=<?=$urlencode?>" >로그아웃</a>
    <? }?>
	
	<?
	
}


?>




</div><!--left_nav-->



<div>
<span>
  
</span>
</div>


<div style=" position:absolute; bottom:0px;"><img src="/logo.png" width="36%" /></div>

<div style=" position:absolute;width:100%;bottom:0px; text-align:center; padding-bottom:10px; color:#FFF; text-shadow:0px 0px #ffffff;"><span style="background-color:#900; padding:2px 4px 2px 4px; margin-left:30px;">copyright</span><span style="background-color:#000; padding:2px 4px 2px 4px; ">(주)모아커뮤니티</span></div>

</div><!-- /page -->

<script type="text/javascript">
	var clock = 10;
	var countdownId = 0;

	function start() {
		//Start clock
		countdownId = setInterval("countdown()", 1000);
	}

	function countdown(){
		if(clock > 0){
			clock = clock - 1;
			document.getElementById('cdDiv').innerHTML = clock;
		}
		else {
			//Stop clock
			clearInterval(countdownId);
			location.href='/bbs/board.m.php?bo_table=<?=$grid?>_menu_<?=$project_code?>&wr_id=1&mb_id=<?=$mb_id?>&is_intro=false';
		}
	}
	
	start();
	
	
	//$('#link_shop').click(function() {
	//	$('#view').animate({backgroundPosition: '-100px -50px'},'slow');
	//});
</script>