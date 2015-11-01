/* Copyright: The Onion Technology
 * Author: Toni Lam
 * Create Date: 2015-10-29
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Action to be taken on page loading
 */

$(window).load(function() {
	equalHeight($('.product-box'));
});

$(window).on('resize',function() {
	equalHeight($('.product-box'));
});
/* 
 * End of onload action
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Custom function to equalize the height of items in the same row
 */
function equalHeight(collection) {
	MARGIN = 0;
	heightLevel = 0;
	rowGroup = [];
	maxHeight = 0;
	
	collection.find('.content').css('height',"auto");
	collection.each(function() {			
		currentPositionY = $(this).offset().top;
		if (currentPositionY > heightLevel) {
			console.log("*** new row ***");
			heightLevel = currentPositionY;
			rowGroup = [];
			maxHeight = 0;
		}
		rowGroup.push($(this));
		currentHeight = $(this).find('.content').height();
		maxHeight = Math.max(currentHeight, maxHeight);
		
		rowGroup.forEach(function(element,index,array) {
			element.find('.content').height(maxHeight+MARGIN);
		});
	});
}
/* 
 * End of custom function
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
