let torskintComponent = {
	Init: function () {
		this.hoverEffect()
		this.multiStepForm()
		this.onlyFormValidator()
		this.partnerSlider($)
		this.scrollToId($)
	},
	hoverEffect: function () {
		let allList = document.querySelectorAll('#oc-list-group .list-group-item')
		if ( !allList ) {
			return
		}
		for (var i = 0; i < allList.length; i++) {
			
			let data = allList[i]
			data.addEventListener('mouseover', function (e) {
				for (var i = 0; i < allList.length; i++) {
					let data = allList[i]
					data.classList.remove('active')
				}
				this.classList.add('active');
			})

			data.addEventListener('mouseout', function (e) {
				for (var i = 0; i < allList.length; i++) {
					let data = allList[i]
					data.classList.remove('active')
				}
				allList[1].classList.add('active');
			})

		}
	},
	scrollToId: function ($) {
		let hash = window.location.hash
		if (!hash || hash.length <= 0) {
			let target = document.querySelector('#lazy-target')
			if (!target || target.length <= 0) {
				return
			} else {
				hash = '#' + target.id;
			}
		}

		$('html, body').animate({
		    scrollTop: $( hash ).offset().top
		}, 1500);

	},

	showTab: function (n) {
		// This function will display the specified tab of the form ...
		var x = document.getElementsByClassName("tab");
		x[n].style.display = "block";
		// ... and fix the Previous/Next buttons:
		if (n != 0) {
			this.prevBtn.classList.remove('d-none');
		} else {
			this.prevBtn.classList.add('d-none');
		}
		this.submitBtn.classList.add('d-none');

		if (n == (x.length - 1)) {
			this.submitBtn.classList.remove('d-none');
			this.nextBtn.classList.add('d-none');
		} else {
			this.nextBtn.classList.remove('d-none');
		}
		
		// ... and run a function that displays the correct step indicator:
		this.fixStepIndicator(n)
	},

	nextPrev: function (n) {
		// This function will figure out which tab to display
		var x = document.getElementsByClassName("tab");
		// Exit the function if any field in the current tab is invalid:
		if (n == 1 && !this.validateForm()) return false;
		// Hide the current tab:
		x[this.currentTab].style.display = "none";
		// Increase or decrease the current tab by 1:
		this.currentTab = this.currentTab + n;
		// if you have reached the end of the form... :
		if (this.currentTab >= x.length) {
			//...the form gets submitted:
			document.getElementById("multi-step-form").submit();
			return false;
		}
		// Otherwise, display the correct tab:
		this.showTab(this.currentTab);
	},

	validateForm: function () {
		// This function deals with validation of the form fields
		var x, y, i, valid = true;
		x = document.getElementsByClassName("tab");
		y = x[this.currentTab].querySelectorAll(".form-control");
		
		// A loop that checks every input field in the current tab:
		for (i = 0; i < y.length; i++) {
			let validInput = y[i].validity.valid || false;
			if ( y[i].value == "" || !validInput) {
				// add an "invalid" class to the field:
				y[i].className += " invalid";
				// and set the current valid status to false:
				valid = false;
			} else {
				y[i].classList.remove('invalid')
			}
		}
		
		// If the valid status is true, mark the step as finished and valid:
		if (valid) {
			document.getElementsByClassName("step")[this.currentTab].className += " finish";
		}
		return valid; // return the valid status
	},

	fixStepIndicator: function (n) {
		// This function removes the "active" class of all steps...
		var i, x = document.getElementsByClassName("step");
		for (i = 0; i < x.length; i++) {
			x[i].className = x[i].className.replace(" active", "");
		}
		//... and adds the "active" class to the current step:
		x[n].className += " active";
	},

	multiStepForm: function () {
		this.currentTab = 0; // Current tab is set to be the first tab (0)

		let j = document.getElementById("multi-step-form");
		if ( !j || j.length <= 0 ) {
			return false;
		}
		this.prevBtn = document.getElementById("prevBtn");
		this.nextBtn = document.getElementById("nextBtn");
		this.submitBtn = document.getElementById("submit-form");
		this.showTab(this.currentTab); // Display the current tab

		this.prevBtn.addEventListener('click', function (e) {
			e.preventDefault()
			torskintComponent.nextPrev(-1)
		});

		this.nextBtn.addEventListener('click', function (e) {
			e.preventDefault()
			torskintComponent.nextPrev(1)
		});
	},

	partnerSlider: function ($) {
		$('.partners-section-horizontal-slider-block').owlCarousel({
		    loop: true,
		    margin: 30,
		    nav: false,
		    autoplay:true,
		    autoplayTimeout:3000,
		    autoplayHoverPause:true,
		    dots: false,
		    smartSpeed: 1500,
		    items: 4,
		    responsive: {
		        0: {
		            items: 2,
		        },
		        575: {
		            items: 2,
		        },
		        768: {
		            items: 3,
		        },
		        992: {
		            items: 4,
		        }
		    }
		});
	},

	onlyFormValidator: function () {
		let b = document.querySelector('.form-need-validation');
		if (!b || b.length <= 0) {
			return
		}
		b.addEventListener('submit', function (e) {
			let valid = true;
			y = b.querySelectorAll(".form-control");
			for (i = 0; i < y.length; i++) {
				let validInput = y[i].validity.valid || false;
				if ( y[i].value == "" || !validInput) {
					y[i].classList.add('invalid');
					valid = false;
				} else {
					y[i].classList.remove('invalid')
				}
			}

			if (!valid) {
				e.preventDefault()
			}
			
		})
		
	}
};



(function($){

	torskintComponent.Init($)

})(jQuery)