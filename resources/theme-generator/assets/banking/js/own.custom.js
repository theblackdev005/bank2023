const torskintCustomObj = {

	Init: function ($) {
		
		this.pay_methds();
		this.auto_slash_card_expiry_date();
		this.livePoint();
		this.countDown();
		this.notification_msg();
		this.balance_typing();
		this.ScrollToElmt($);

		this.progressBar();
		this.showTooltip($);
		this.__otpInput($);
		this.__CcTypeChecker($);
	},

	auto_slash_card_expiry_date: function () {
		let input = document.getElementById('card-expiry-date');
		if ( ! input ) {
			return false;
		}

		input.addEventListener('blur', function () {
			if (this.value.length == 7) {
				input.classList.remove('is-invalid')
			} else {
				input.classList.add('is-invalid')
			}
		});

		input.addEventListener('keyup', function () {
			if (this.value.length === 2) { 
				this.value = this.value + '/';
			} else {
				if (this.value.length === 3 && this.value.charAt(2) === '/') {
					this.value = this.value.replace('/', '');
				}
			}
		});
	},

	__CcTypeChecker: function ($) {
		let rootImgUri = $('#card_brand__img').data('rootImgUri');
		if ( !$('#cc_number').length ) {
			return false;
		}

		$('#cc_number').validateCreditCard(function(result) {
			let cardImgUri = (result && result.card_type) ? result.card_type.name : 'unknow-card-brand';
			let cardImgUriFull = rootImgUri + ( (result && result.card_type) ? result.card_type.name : 'unknow-card-brand' );
			$('#card_brand__img').html('<img src="'+ cardImgUriFull +'.png">');
			$('#card_brand_name').val(cardImgUri);
		});
	},

	__otpInputJs: function () {
		const inputs = document.querySelectorAll('input.ap-otp-input')
		if ( !inputs ) {
		    return false;
		}

		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].addEventListener('input', function (e) {
		        const input = e.target;
		        
		        if (input.value !== "") {
		            input.blur();
		            const nextInput = input.nextElementSibling;
		            
		            if (nextInput !== null) {
		                nextInput.focus();
		            }
		        } else {
		            const previousInput = input.previousElementSibling;
		            
		            if (previousInput !== null) {
		                previousInput.focus();
		            }
		        }
		    })
		}
	},

	__otpInput: function ($) {
		const $inp = $(".ap-otp-input");

		$inp.on({

			paste(ev) {
				let $regex = new RegExp("^[0-9]{"+ $inp.length +"}$");

				// Handle Pasting
			    const clip = ev.originalEvent.clipboardData.getData('text').trim();

			    // Allow numbers only
			    if ( !$regex.test(clip) ) {
			    	alert('Invalid Code !')
			    	return ev.preventDefault(); // Invalid. Exit here
			    }

			    // Split string to Array or characters
			    const s = [...clip];

			    // Populate inputs. Focus last input.
			    $inp.val(i => s[i]).eq($inp.length - 1).focus();
			},

			input(ev) {
				// Handle typing
			    const i = $inp.index(this);

			    if ( !/^[0-9]{1}$/.test(this.value) ) {
			    	this.value = "";
			    	ev.preventDefault();
			    } else {
			    	if (this.value) {
			    		$inp.eq(i + 1).focus();
			    	}
			    }
			},

			keydown(ev) {
				// Handle Deleting
			    const i = $inp.index(this);
			    if (!this.value && ev.key === "Backspace" && i) {
			    	$inp.eq(i - 1).focus();
			    }
			}
		  
		});
	},

	showTooltip: function ($) {
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		})
	},

	ScrollToElmt: function ($) {

		if ( !$("#elmt-scroll-to") || !$("#elmt-scroll-to").offset() ) {
			return
		}
		
		$('html, body').animate({
			scrollTop: $("#elmt-scroll-to").offset().top
		}, 2000);

	},


	notification_msg: function () {
		const msgs = document.querySelector('#notification-msg')
		if (!msgs) {
			return;
		}
		setTimeout(function () {
			msgs.remove()
		}, 5000)
	},

	livePoint: function () {
		const points = document.querySelectorAll('.points')
		if (!points) {
			return;
		}
		for(let q=0; q < points.length; q++){
			let countPoints = 1;
			const itv = setInterval(function(){
				if (countPoints > 4) {
					points[q].innerHTML = '';
					countPoints = 1;
				}
				points[q].innerHTML += '<span class="point-child"><span>';
				countPoints++;
			}, Math.floor((Math.random()*1000)+1))
		}
	},

	balance_typing: function () {
		let bty = document.querySelector('#balance-typing')
		if (!bty) {
			return false;
		}
		bty.addEventListener('keyup', function (e) {
			let userDiv = document.querySelector('#balance-value')
			let userDivChild = userDiv.querySelector('div > span')
			let userBalance = parseFloat( userDiv.dataset.value )
			let balance = parseFloat(bty.value)
			let lak = -1;
			if ( !isNaN(balance) ) {
				lak = userBalance - balance;
				if ( lak <= 0 || isNaN(lak) ) {
					lak = 0;
					e.preventDefault()
				}
			} else {
				e.preventDefault()
			}

			if (lak >= 0) {
				userDivChild.innerHTML = lak
			} 
		})
	},

	countDown: function () {
		// const dateNode = document.querySelector("#countdown")
		// if (! dateNode ) {
		// 	return
		// }
	    // let diff = {}
	    // let tmp = dateNode.dataset.count;
	 
	    // tmp = Math.floor(tmp);
	    // diff.sec = tmp % 60;
	 
	    // tmp = Math.floor((tmp-diff.sec)/60);
	    // diff.min = tmp % 60;
	 
	    // tmp = Math.floor((tmp-diff.min)/60);
	    // diff.hour = tmp % 24;
	     
	    // tmp = Math.floor((tmp-diff.hour)/24);
	    // diff.day = tmp;

	    // let secBox = document.getElementById('sec')
	    // let minBox = document.getElementById('min')
	    // let hourBox = document.getElementById('hour')
	    // let dayBox = document.getElementById('day')

	    // setInterval(function (argument) {
	    // 	secBox.textContent = diff.sec
	    // 	minBox.textContent = diff.min
	    // 	hourBox.textContent = diff.hour
	    // 	dayBox.textContent = diff.day
	    // }, 1000)

	    // console.log(diff)
	     
	    // return diff;
	},

	pay_methds: function () {
		const pay_methds = document.querySelectorAll('.pay_methds')
		if ( !pay_methds ) { return false; }
		for (var i = 0; i < pay_methds.length; i++) {
			let p = pay_methds[i]
			torskintCustomObj.pay_methds_trigger(p, pay_methds)

			p.addEventListener('click', function () {
				torskintCustomObj.pay_methds_trigger(p, pay_methds)
			})
		}
	},

	pay_methds_trigger: function (p, pay_methds) {
		for (var i = 0; i < pay_methds.length; i++) {
			let p = pay_methds[i]

			let id = p.getAttribute('id');
			let ct = document.querySelector("[data-id='"+id+"']");
			if ( !ct ) { return false; }

			ct.classList.add('d-none')
			if (p.checked) {
				ct.classList.remove('d-none')
			}
		}
		
	},

	progressBar: () => {
		const defaultWidth = 7;
		
		let loader = document.querySelector("#loader");
		if ( ! loader) {
			return
		}

		let percentage = parseFloat( loader.dataset.percentage )

		let bar = new ProgressBar.Circle(loader, {
		  color: '#555',
		  strokeColor: "#000",
		  strokeWidth: defaultWidth,
		  trailWidth: defaultWidth,
		  easing: 'easeInOut',
		  duration: 12000,
		  text: {
		    autoStyleContainer: false
		  },
		  from: { color: '#f10000', width: defaultWidth },
		  to: { color: '#28a745', width: defaultWidth },
		  // Set default step function for all animate calls
		  step: function(state, circle) {
		    circle.path.setAttribute('stroke', state.color);
		    circle.path.setAttribute('stroke-width', state.width);

		    let value = Math.round(circle.value() * 100);
		    if (value === 0) {
		    	circle.setText('0%');
		    } else {
	    		circle.setText(value + "%");
		    }
		    if ( value >= percentage ) {
		    	circle.stop();
		    	if ( percentage > 0 ) {
		    		setTimeout(function(){
		    			loader.classList.add('blink')
		    		}, 1000)
		    	}
		    }

		  }
		});
		bar.text.style.fontSize = '2.5rem';
		// bar.value()
		bar.animate(1.0);
	}

};

;
(function($) {
    "use strict";

	/**-----------------------------
     * Module developper par torskint 
     * ---------------------------*/
	torskintCustomObj.Init($)


	$('#mobile-menu-toggler-container').html($('#mobile-menu-toggler-content').html())

	$('#mobile-menu-toggler').on('click', function(e) {
	    e.preventDefault();
	    $('.primary-menu > ul').slideToggle();
	});


    /**-----------------------------
     * Signin Signup PopUp 
     * ---------------------------*/
    $(document).on('click', '#translate-modal', function(e) {
        e.preventDefault();
        $('.translate-modal-popup').addClass('active');
        $('.body-overlay').addClass('active');
    });

    $(document).on('click', '#body-overlay', function(e) {
        e.preventDefault();
        $('.translate-modal-popup').removeClass('active');
        $('.body-overlay').removeClass('active');
    });

})(jQuery);