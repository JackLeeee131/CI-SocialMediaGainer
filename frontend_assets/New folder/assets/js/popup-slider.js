$( document ).ready(function() {
	$('.btn-slider').on('click', function() {
	  $('.sliderPop').show();
	  $('.ct-sliderPop-container').addClass('open');
	  $('.sliderPop').addClass('flexslider');
	  $('.sliderPop .ct-sliderPop-container').addClass('slides');

	  $('.sliderPop').flexslider({
		selector: '.ct-sliderPop-container > .ct-sliderPop',
		slideshow: false,
		controlNav: false,
		controlsContainer: '.ct-sliderPop-container'
	  });
	});

	$('.ct-sliderPop-close').on('click', function() {
	  $('.sliderPop').hide();
	  $('.ct-sliderPop-container').removeClass('open');
	  $('.sliderPop').removeClass('flexslider');
	  $('.sliderPop .ct-sliderPop-container').removeClass('slides');
	});
});
