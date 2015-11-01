<?php 
if (!isset($content)){
	$category = new Category($db);
	$rootCategoryList = $category->getRootCategoryList($db);
}
?>
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
          <a class="navbar-brand" href="#"><img src="<?php echo document_root(); ?>/asset/images/jubilee_nav_logo.png" height="46px"/></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo document_root(); ?>">首頁</a></li>
            <li><a href="<?php echo document_root(); ?>/about">購物需知</a></li>
            <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="badge">1</span> 購物車<span class="caret"></span></a>
              <ul class="dropdown-menu">
              	<li><a href="<?php echo document_root(); ?>/login">登入賬號</a></li>
              	<li><a href="<?php echo document_root(); ?>/cart">檢示購物車</a></li>
              	<li><a href="<?php echo document_root(); ?>/checkout">結賬</a></li>
              	
              </ul>
            </li>
            <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">產品分類  <span class="caret"></span></a>
              <ul class="dropdown-menu">
<?php
/* This block loop all the root categories */
foreach ($rootCategoryList as $row){
	$category->setCategoryRecord($row);
	echo ' 
				<li><a href="'.document_root().'/category/'.$category->getCategorySlug().'">'.$row["name"].'</a></li>
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
				        	<button id="site-search-submit" class="btn btn-default glyphicon glyphicon-search" type="button"></button>
				      	</span>
				    </div>
			    </form>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>