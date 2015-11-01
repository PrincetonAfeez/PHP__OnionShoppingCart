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
$headingBannerImages = [document_root()."/asset/images/jubileeAusbuy_home_banner_1.png",
		document_root()."/upload/images/home_big_banner_ittybittys.png",
		document_root()."/asset/images/dummy_1200x444.jpg"
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