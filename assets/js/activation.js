    !(function($){
    		
    	// Check if element exists
		$.fn.elExists = function() {
			return this.length > 0;
		};

		var swiperAnimation = new SwiperAnimation();
		/************************************************************
		Primary Slider Settings
		*************************************************************/

		var $pSlider = $(".primary_slider");
		if ($pSlider.elExists()) {

			var interleaveOffset = 0.5;

			if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
				// Firefox-related activities
				var interleaveOffset = 0;
			}

			var swiperOptions = {
				loop: true,
				speed: 1000,
				effect: (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) ? 'fade' : 'slide', // Show fade effect instead of parallax slide in Firefox
				watchSlidesProgress: true,
				mousewheelControl: true,
				keyboardControl: true,
				disableOnInteraction: true,

				autoplay: {
					delay: 7000
				},

				navigation: {
					nextEl: ".swiper-arrow.next.slide",
					prevEl: ".swiper-arrow.prev.slide"
				},

				pagination: {
					el: '.swiper-pagination',
					clickable: true
				},

				// Giving slider a background parallax sliding effect
				on: {

					progress: function() {
						 
						var swiper = this;
						// console.log(swiper.slides.length);
						for (var i = 0; i < swiper.slides.length; i++) {
							var slideProgress = swiper.slides[i].progress;
							var innerOffset = swiper.width * interleaveOffset;
							var innerTranslate = slideProgress * innerOffset;
							swiper.slides[i].querySelector(".slide-inner").style.transform =
								"translate3d(" + innerTranslate + "px, 0, 0)";
						}

					},

					touchStart: function() {

						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							swiper.slides[i].style.transition = "";
						}

					},

					setTransition: function(speed) {

						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							swiper.slides[i].style.transition = speed + "ms";
							swiper.slides[i].querySelector(".slide-inner").style.transition =
								speed + "ms";
						}
					},

					
					init: function () {
				        swiperAnimation.init(this).animate();
				    },

				    slideChange: function () {
				        swiperAnimation.init(this).animate();
				    }
					
				}
			};

			var swiper = new Swiper($pSlider, swiperOptions);
		}

    })(jQuery);
    