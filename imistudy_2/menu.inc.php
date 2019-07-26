<?php
	$TITLE = $_POST['title'];
	
	$url = ($_SERVER['HTTPS'] == 'on')?'https://':'http://';
	$url .= ($_SERVER['SERVER_PORT'] != '80')?$_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT']:$_SERVER['HTTP_HOST']; 

?>
<style>
	#menu{
		text-align:right;
		font-size:30px;
		font-weight:bold;
		padding: 0 20px 40px 20px;
		border-bottom:1px dashed #101010;
	}
	
	#home{
		float:left;
	}
	#menu span{
		float:left;
		position:relative;
		left:40%;
	}
	#menu span div{
		float:right;
		position:relative;
		left:-50%;
		font-size:40px;
		font-weight:bold;
	}

	#menu a{
		padding:15px;
	}
</style>
<div id='menu'>
	<a id='home' href='<?php echo $url."/imistudy/imistudy_2"; ?>'>HOME</a>
	<span><div><?php echo($TITLE); ?></div></span>
	
	<a href='<?php echo $url."/imistudy/schedule_2/select_schedule.php";  ?>'>Plan</a>
	<a href='<?php echo $url."/imistudy/imistudy_2/myPage.php";  ?>'>Info</a>
	<a href='<?php echo $url."/imistudy/imistudy_2/logout.php";  ?>'>Log-out</a>
</div>