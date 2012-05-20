/**
 * Equal Heights Plugin
 * Equalize the heights of elements. Great for columns.
 *
 * Copyright (c) 2008 Rob Glazebrook (cssnewbie.com) 
 *
 * Usage Example: $('.columns').equalHeights();
 *
 */

(function($) {
	$.fn.equalHeights = function() {
		tallest = 0;
		this.each(function() {
			if($(this).height() > tallest) {
				tallest = $(this).height();
			}
		});
		return this.each(function() {
			$(this).height(tallest);
		});
	}
})(jQuery);

var rotateSpeed = 5000; // Milliseconds to wait until switching tabs.
var currentTab = 0; // Set to a different number to start on a different tab.
var numTabs; // These two variables are set on document ready.
var autoRotate;

function openTab(clickedTab) {
	var thisTab = $(".tabbed-box .tabs a").index(clickedTab);
	$(".tabbed-box .tabs li a").removeClass("active");
	$(".tabbed-box .tabs li a:eq("+thisTab+")").addClass("active");
	$(".tabbed-box .tabbed-content").hide();
	$(".tabbed-box .tabbed-content:eq("+thisTab+")").show();
	currentTab = thisTab;
}

function rotateTabs() {
	var nextTab = (currentTab == (numTabs - 1)) ? 0 : currentTab + 1;
	openTab($(".tabbed-box .tabs li a:eq("+nextTab+")"));
}

$(document).ready(function() {
	$(".tabbed-content").equalHeights();
	numTabs = $(".tabbed-box .tabs li a").length;
	$(".tabbed-box .tabs li a").click(function() { 
		openTab($(this)); return false; 
	});
	$(".tabbed-box").mouseover(function(){clearInterval(autoRotate)})
	.mouseout(function(){autoRotate = setInterval("rotateTabs()", rotateSpeed)});
	
	$(".tabbed-box .tabs li a:eq("+currentTab+")").click()
	$(".tabbed-box").mouseout();
	
});