<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>好牧人澳洲產品代購</title>
    
	<!-- Plug-in goes here -->
			
		<!--jQuery -->
		<script src="./asset/lib/jquery/jquery-2.1.4.min.js"></script>
		<script src="./asset/lib/jquery/jquery-migrate-1.2.1.min.js"></script>
				
	    <!-- Bootstrap -->
	    <link href="./asset/lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
	    <script src="./asset/lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
	    		
	<!-- Plug-in end -->
	<!-- User define CSS -->
	<link href="./asset/css/main.css" rel="stylesheet">
	<link href="./asset/css/override_bootstrap.css" rel="stylesheet">
	<!-- User define CSS end -->
</head>
<?php
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();
$sql = "SELECT *
			FROM categories
			WHERE parent_cat is NULL
			ORDER BY name";
$sqlResult = $db->fetchall($sql);
?>
<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">       	
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="./asset/images/jubilee_nav_logo.png" height="46px"/></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">首頁</a></li>
            <li><a href="#about">購物需知</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="badge">1</span> 購物車<span class="caret"></span></a>
              <ul class="dropdown-menu">
              	<li><a href="">登入賬號</a></li>
              	<li><a href="">檢示購物車</a></li>
              	<li><a href="">結賬</a></li>
              	
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">產品分類  <span class="caret"></span></a>
              <ul class="dropdown-menu">
<?php
/* This block loop all the root categories */
foreach ($sqlResult as $row){
	echo ' 
				<li><a href="showpage.php?cat='.$row["cat_id"].'">'.$row["name"].'</a></li>
					';
}
?>
              </ul>
            </li>
            <li>
            	<form id="site-search">
	            	<div class="input-group">
				    	<input type="text" name="keyword" class="form-control" placeholder="Search for...">
				      	<span class="input-group-btn">
				        	<button id="site-search-submit" class="btn btn-default glyphicon glyphicon-search" type="button" />
				      	</span>
				    </div>
			    </form>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	<div class="container theme-showcase" role="main">
		<hr id="page-top" class="after-navbar" />
		
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  			<!-- Indicators -->
  			<ol class="carousel-indicators">
    			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
    			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
  			</ol>

  			<!-- Wrapper for slides -->
  			<div class="carousel-inner" role="listbox">
<?php
/* This block loop the heading slide image */
$headingBannerImages = ["./asset/images/jubileeAusbuy_home_banner_1.png",
		"./asset/images/dummy_1200x444.jpg",
		"./asset/images/dummy_1200x444.jpg"
	];
$slideCounter = 0;
foreach ($headingBannerImages as $thisImage){
	if ($slideCounter == 0){
		$active = 'active';
	}
	else {
		$active = '';
	}
	echo '
			<div class="item '.$active.'">
      				<img src="'.$thisImage.'" alt="Slide '.$slideCounter++.'">
      				<div class="carousel-caption"></div>
    			</div>
		';
}
?>
  			</div>

  			<!-- Controls -->
  			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    			<span class="sr-only">Previous</span>
  			</a>
  			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    			<span class="sr-only">Next</span>
  			</a>
		</div>
		
		<div id="category-list" class="row">
<?php
/* This block loop all the root categories as gallery */
foreach ($sqlResult as $row){
	echo ' 
			<div class="display-box col-xs-6 col-sm-6 col-md-3">
				<a href="showpage.php?cat='.$row["cat_id"].'">
					<div class="content">
    	';
	$sql = "SELECT uri
			FROM attachment
			WHERE post_type='categories' and post_id='".$row["cat_id"]."'";
	$catIcon = $db->fetchall($sql);
	$catIconRows = sizeof($catIcon);
	if ($catIconRows > 0){
		echo '<img src="'.$catIcon[$catIconRows-1]['uri'].'" /><br />';
		
	} else {
		echo '<img src="./asset/images/dummy_1200x444.jpg" /><br />';
	}
	echo '				'.$row["name"].'
    				</div>
    			</a>
			</div>
		';
}
?>
		</div>
		
		<div id="news-board" class="row">
			<div class="page-header col-xs-12">
				<h1><small>最新消息</small></h1>
			</div>
			<div class="news-post col-xs-12">
				<div class="tags col-xs-2"><span class="glyphicon glyphicon-tags"></span>
					<a href="#">TEST</a>,
					<a href="#">TEST TAG</a>
				</div>
				<div class="col-xs-10">
					<h3>NEWS TITLE</h3>
					<p>TEXT</p>
				</div>
			</div>
		</div>
			
    </div> <!-- /container -->
    
    <nav id="footer" class="footer-nav">
		<div class="container theme-showcase">
			<div class="back-to--top col-xs-12 text-center"><a href="#"><span class="glyphicon glyphicon-triangle-top"></span> 回到頁頂</a></div>
			<div class="left-col col-xs-12 col-sm-6">
				<ul>
					<li><h4><span class="glyphicon glyphicon-star"></span> 常用連結</h4></li>
					<li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> 購物需知</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-question-sign"></span> 常見問題</a></li>
				</ul>
				<ul>
					<li><h4><span class="glyphicon glyphicon-comment"></span> 本站聲明</h4></li>
					<li><a href="#"><span class="glyphicon glyphicon-book"></span> 個人資料保密協議</a></li>
					<li><span class="glyphicon glyphicon-duplicate"></span> 版權所有 &copy; 2015 JubileeAusBuy.com</li>
					
				</ul>
			</div>
			<div class="right-col col-xs-12 col-sm-6">
				<ul>
					<li class="social-media-link"><h4><span class="glyphicon glyphicon-bookmark"></span> 保持聯系</h4>
						<a href="https://instagram.com/jubileeausbuy" data-toggle="tooltip" title="Follow us in Facebook" target="_blank">
							<img src="./asset/images/icon/Facebook-icon.png" alt="Facebook"></a>
						<a href="https://instagram.com/jubileeausbuy" data-toggle="tooltip" title="Follow us in Instagram" target="_blank">
							<img src="./asset/images/icon/instagram-icon.png" alt="Instagram"></a>
						<a href="https://instagram.com/jubileeausbuy" data-toggle="tooltip" title="Follow us in Youtube" target="_blank">
							<img src="./asset/images/icon/subscribe-to-youtube-channel.png" alt="Youtube"></a>
					</li>
				</ul>
				<ul>
					<li>Whatsapp: +61 424 056 983</li>
					<li>Email: <a href="mailto:info@JubileeAusBuy.com">info@JubileeAusBuy.com</a></li>
				</ul>
			</div>
		</div>
	</nav>


</body>
</html>