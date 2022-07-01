 AOS.init({
 	duration: 800,
 	easing: 'slide'
 });
 function validateForm(){
	 let p1 = document.forms["formregistrazione"]["password1"].value;
	 let p2 = document.forms["formregistrazione"]["password2"].value;
	 let n = document.forms["formregistrazione"]["nome"].value;
	 let c = document.forms["formregistrazione"]["cognome"].value;
	 let u = document.forms["formregistrazione"]["username"].value;
	 let m = document.forms["formregistrazione"]["mail"].value;
	 let fileInput = document.forms["formregistrazione"]["immagine"].value;

	 if(n==="" || c==="" || m==="" || u==="" || p1==="" || p2==="" || fileInput===""){
		 alert("Inserire i campi mancanti");
		 return false;
	 }
	 if(p1 !== p2){
		 alert("Le password non corrispondono!");
		 return false;
	 }
	 var allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;

	 if (!allowedExtensions.exec(fileInput)) {
		 alert('Tipo di file non permesso');
		 fileInput.value = '';
		 return false;
	 }
 }
 function validateImg(){
	 let fileInput = document.forms["formImg"]["formFile"].value;
	 var allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;

	 if (!allowedExtensions.exec(fileInput)) {
		 alert('Tipo di file non permesso');
		 return false;
	 }
 }

 function validateDate(){
	 let dataarrivo = document.forms["formDate"]["book_pick_date"].value;
	 let datapartenza = document.forms["formDate"]["book_off_date"].value;

	 var DATAarrivo = new Date(dataarrivo);

	 var DATApartenza = new Date(datapartenza);

	 var DATAoggi = new Date();

	 if(datapartenza==="" || dataarrivo===""){
		 alert("Inserire i campi mancanti");
		 return false;
	 }
	 if(DATAarrivo.getTime() > DATApartenza.getTime())
	 {
		 alert('La data di inizio è successiva a quella di fine')
		 return false;
	 }

	 if(DATApartenza.getTime() < DATAoggi.getTime()){
		 alert('La data di fine è successiva ad oggi')
		 return false;
	 }

 }
 function validateFormRicerca() {
	 let citta = document.forms["formRicerca"]["citta"].value;
	 let dataarrivo = document.forms["formRicerca"]["book_pick_date"].value;
	 let datapartenza = document.forms["formRicerca"]["book_off_date"].value;
	 let oraarrivo = document.forms["formRicerca"]["time_pick_hour"].value;
	 let orapartenza = document.forms["formRicerca"]["time_off_hour"].value;
	 let taglia = document.forms["formRicerca"]["taglia"].value;

	 console.log(orapartenza.substring(0,2),orapartenza.substring(3,5));

	 var DATAarrivo = new Date(dataarrivo);
	 DATAarrivo.setHours(oraarrivo.substring(0,2),oraarrivo.substring(3,5));

	 var DATApartenza = new Date(datapartenza);
	 DATApartenza.setHours(orapartenza.substring(0,2),orapartenza.substring(3,5));

	 var DATAoggi = new Date();


	 if (citta === "" || datapartenza === "" || dataarrivo === "" || orapartenza === "" || oraarrivo === "" || taglia ==="") {
		 alert("Inserire i campi mancanti");
		 return false;
	 }

	 if(DATAarrivo.getTime() > DATApartenza.getTime())
	 {
		 alert('La data di arrivo è successiva a quella di partenza')
		 return false;
	 }

	 if(DATAarrivo.getTime() < DATAoggi.getTime()){
		 alert('La data di arrivo è precedente ad adesso')
		 return false;
	 }
 }


(function($) {

	"use strict";

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};


	$(window).stellar({
    responsive: true,
    parallaxBackgrounds: true,
    parallaxElements: true,
    horizontalScrolling: false,
    hideDistantElements: false,
    scrollProperty: 'scroll'
  });


	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	// Scrollax
   $.Scrollax();

	var carousel = function() {
		$('.carousel-car').owlCarousel({
			center: true,
			loop: true,
			autoplay: true,
			items:1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 2
				},
				1000:{
					items: 3
				}
			}
		});
		$('.carousel-testimony').owlCarousel({
			center: true,
			loop: true,
			items:1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 2
				},
				1000:{
					items: 3
				}
			}
		});

	};
	carousel();

	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
	  console.log('show');
	});

	// scroll
	var scrollWindow = function() {
		$(window).scroll(function(){
			var $w = $(this),
					st = $w.scrollTop(),
					navbar = $('.ftco_navbar'),
					sd = $('.js-scroll-wrap');

			if (st > 150) {
				if ( !navbar.hasClass('scrolled') ) {
					navbar.addClass('scrolled');	
				}
			} 
			if (st < 150) {
				if ( navbar.hasClass('scrolled') ) {
					navbar.removeClass('scrolled sleep');
				}
			} 
			if ( st > 350 ) {
				if ( !navbar.hasClass('awake') ) {
					navbar.addClass('awake');	
				}
				
				if(sd.length > 0) {
					sd.addClass('sleep');
				}
			}
			if ( st < 350 ) {
				if ( navbar.hasClass('awake') ) {
					navbar.removeClass('awake');
					navbar.addClass('sleep');
				}
				if(sd.length > 0) {
					sd.removeClass('sleep');
				}
			}
		});
	};
	scrollWindow();

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	var counter = function() {
		
		$('#section-counter, .hero-wrap, .ftco-counter').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.number').each(function(){
					var $this = $(this),
						num = $this.data('number');
						console.log(num);
					$this.animateNumber(
					  {
					    number: num,
					    numberStep: comma_separator_number_step
					  }, 7000
					);
				});
				
			}

		} , { offset: '95%' } );

	}
	counter();


	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


	// navigation
	var OnePageNav = function() {
		$(".smoothscroll[href^='#'], #ftco-nav ul li a[href^='#']").on('click', function(e) {
		 	e.preventDefault();

		 	var hash = this.hash,
		 			navToggler = $('.navbar-toggler');
		 	$('html, body').animate({
		    scrollTop: $(hash).offset().top
		  }, 700, 'easeInOutExpo', function(){
		    window.location.hash = hash;
		  });


		  if ( navToggler.is(':visible') ) {
		  	navToggler.click();
		  }
		});
		$('body').on('activate.bs.scrollspy', function () {
		  console.log('nice');
		})
	};
	OnePageNav();


	// magnific popup
	$('.image-popup').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    fixedContentPos: true,
    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
     gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    },
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: true,
      duration: 300 // don't foget to change the duration also in CSS
    }
  });

  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,

    fixedContentPos: false
  });


	$('#book_pick_date,#book_off_date').datepicker({
	  'format': 'yyyy-mm-dd',
	  'autoclose': true
	});
	$('#time_pick_hour, #time_off_hour').timepicker({
		timeFormat: 'H:i',
		interval: 30,
		defaultTime: 'now',
		dynamic: true,
		dropdown: true,
		scrollbar: true
	});
})(jQuery);

