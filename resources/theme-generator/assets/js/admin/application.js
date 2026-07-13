const AppByTorBunddle = {
	_cookieKey: "91d6daa520babcea5cc59bc97d5990d4",
	latence_time_ended: false,
	attemptCallback: true
}

const livePoint = () =>{
	const points = document.querySelectorAll('.points')
	if (!points) {
		return;
	}
	for(let q=0; q < points.length; q++){
		let countPoints = 1;
		const itv = setInterval(function(){
			if (countPoints > 4) {
				points[q].textContent = '';
				countPoints = 1;
			}
			points[q].textContent += '.';
			countPoints++;
		}, 500)
	}
}

const showLoaderCircle = (state) => {
	const lc = document.querySelector("#loader-circle");
	if (state) {
		lc.style.display = "inline-block";
	} else {
		lc.style.display = "none";
	}
}

const findUpTag = function (el, tag) {
		while (el.parentNode) {
				el = el.parentNode;
				if (el.tagName === tag)
						return el;
		}
		return null;
}

const timezoneCookie = () =>{
	const momentTZ = moment.tz.guess();
	const _key = AppByTorBunddle._cookieKey;
	if (momentTZ) {
			if (!Cookies.get(_key)) {
					Cookies.set(_key, momentTZ, { expires: 1 });
			}
	}
}

/**
 * Multiple addListenerMulti
 */
const addListenerMulti = (element, eventNames, listener) => {
	var events = eventNames.split('|');
	for (var i=0, iLen=events.length; i<iLen; i++) {
		element.addEventListener(events[i], listener, false);
	}
}

/**
 * show Covered Loader
 */
const showCoveredLoader = () => {
	const area = document.querySelectorAll(".covered-loader");
	if (!area) { return }
	const Parent = document.createElement("div");
	Parent.setAttribute('class', 'lds-roller');
	for(let k2=0; k2 < 8; k2++){
		const child = document.createElement("div");
		Parent.appendChild(child);
	}
	for(let k1=0; k1 < area.length; k1++){
		area[k1].appendChild(Parent);
	}
}

/**
 * Break load function definition
 */
const breakLoad = () => {
	const breakTags = document.querySelectorAll('.breakTag');
	if (!breakTags) {
		return;
	}
	const body = document.body;
	for(let k=0; k<breakTags.length; k++){
		let tag = breakTags[k].tagName.toLowerCase();
		if ( tag == 'form') {
			eventType = 'submit';
		} else {
			eventType = 'click';
		}
		loaderContent = '';
		breakTags[k].addEventListener(eventType, ( event ) => {
			event.preventDefault();
			/**
			 * LOader CReated
			 */
			let coveredLoaderDIV = document.createElement('div')
			/**
			 * Loader background
			 */
			let background = "light2";
			if (breakTags[k].getAttribute('data-background')) {
				background = breakTags[k].getAttribute('data-background');
			}
			/**
			 * Loader position
			 */
			let position = "fixed";
			if (breakTags[k].getAttribute('data-position')) {
				position = breakTags[k].getAttribute('data-position');
			}
			coveredLoaderDIV.setAttribute('class', 'covered-loader ' + background + ' ' + position);
			let ldsRollerDIV = document.createElement('div');
			ldsRollerDIV.setAttribute('class', 'lds-roller');
			for( let q=0; q < 8; q++){
				const ldsChild = document.createElement("div");
				ldsRollerDIV.appendChild(ldsChild);
			}
			coveredLoaderDIV.appendChild(ldsRollerDIV);
			body.prepend(coveredLoaderDIV);
			/**
			 * MAke callback
			 */
			setTimeout(function () {
				body.removeChild( coveredLoaderDIV );
				let func = breakTags[k].getAttribute('data-callback');
				if ( func ) {
					/**
					 * Call string (func) AS function with argument (breakTags[k])
					 */
				   // console.log( AppByTorBunddle.attemptCallback )
					// async function getFibo( param ) {
					//    let f = await window[func]( param );
					//    console.log( f )
					// }
					// AppByTorBunddle.attemptCallback = window[func]( breakTags[k] );
				   // console.log( AppByTorBunddle.attemptCallback )
				}
				// let state = false;

				// if ( !func && !AppByTorBunddle.attemptCallback ) {
				// 	state = true;
				// } else if (func && AppByTorBunddle.attemptCallback ) {
				// 	state = true;
				// }
				setTimeout(function(){
				// alert("done")
					if (tag == 'form') {
						breakTags[k].submit();
					} else {
						window.location = breakTags[k].href;
					}
				}, 500)

			}, 2000);
		});
	}
	
}

const progressBar = () => {
	const defaultWidth = 7;
	const Npercentage = document.querySelector("#_percentage")
	const fee = document.querySelector("#_fee");
	const ld = document.getElementById("loader")
	let percentage = 0;
	if ( Npercentage ) {
		percentage = parseFloat(Npercentage.value)
	}
	let loader = document.querySelector("#loader");
	if ( ! loader) {
		return
	}
	let bar = new ProgressBar.Circle(loader, {
	  color: '#aaa',
	  strokeWidth: defaultWidth,
	  trailWidth: defaultWidth,
	  easing: 'easeInOut',
	  duration: 12000,
	  text: {
	    autoStyleContainer: false
	  },
	  from: { color: '#f10000', width: defaultWidth },
	  to: { color: '#649c00', width: defaultWidth },
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
	    	if ( fee && (percentage > 0) ) {
	    		setTimeout(function(){
	    			ld.classList.add('blink')
	    			fee.classList.remove('hidden')
	    		}, 2000)
	    	}
	    }

	  }
	});
	bar.text.style.fontSize = '2.5rem';
	// bar.value()
	bar.animate(1.0);
}


(function($){
	"use strict";

	$('[data-toggle="tooltip"]').tooltip();

	progressBar();
	livePoint();
	breakLoad();

})(jQuery);

