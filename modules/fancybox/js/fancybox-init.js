// ******* Auto-generated file. Please do not change. ***

$(document).ready(function() {
  $("a.g-sb-preview").fancybox({
     'titlePosition' : 'over'
    ,'titleFormat' : function(title, currentArray, currentIndex, currentOpts) { return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + ' : ' + title + '</span>'; }
,'onComplete' :	function() { $("#fancybox-wrap").hover(function() { $("#fancybox-title").show(); }, function() { $("#fancybox-title").hide(); });	}
  });

  $("a.g-fullsize-link").fancybox({
     'titlePosition' : 'over'
    ,'titleFormat' : function(title, currentArray, currentIndex, currentOpts) { return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + ' : ' + title + '</span>'; }
,'onComplete' :	function() { $("#fancybox-wrap").hover(function() { $("#fancybox-title").show(); }, function() { $("#fancybox-title").hide(); });	}
  });

});