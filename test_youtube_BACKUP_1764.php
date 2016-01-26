<!doctype html>
<html>
<head>
<<<<<<< HEAD



=======
>>>>>>> 4a32936841b172cb69e271e19dae5259e4dbcce4
<meta charset="euc-kr">
<title>무제 문서</title>
<style>
.video-container{ position:relative; padding-bottom:56.25%; padding-top:30px; height:0; overflow:hidden;}
.video-container iframe{position:absolute; top:0; left:0; width:100%; height:100%;}
</style>
<script src="https://www.youtube.com/iframe_api"></script>
</head>

<body>


<div class="video-container" style="border:1px solid red">
<iframe id="player" name="player" width="100%" height="315" src="http://www.youtube.com/embed/GUqY2xdY41w?enablejsapi=1&origin=http://example.com" frameborder="0" allowfullscreen></iframe>
</div>
  
<<<<<<< HEAD
=======
  
  
  
  
>>>>>>> 4a32936841b172cb69e271e19dae5259e4dbcce4

<script>
//var tag = document.createElement('script');
//tag.src = "https://www.youtube.com/iframe_api";
//var firstScriptTag = document.getElementsByTagName('sciprt')[0];
//firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady(){
	player = new YT.Player('player',{
		//height:'390',
		//width: '640',
		//videoId: 'GUqY2xdY41w',
		events: {
			'onReady':onPlayerReady,
			'onStateChange':onPlayerStateChange
		}
	});
}

function onPlayerReady(event){
	event.target.playVideo();
}

var done = false;
function onPlayerStateChange(event){
	if(event.data == YT.PlayerState.PLAYING && !done){
		setTimeout(stopVideo, 6000);
		done = true;
	}
}

function stopVideo(){
	player.stopVideo();
}

</script>

</body>
</html>