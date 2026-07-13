/**
 * Copy to clipboard
 */
const copyTOClipboard = () => {
	const cps = document.querySelectorAll(".copy")
	if (!cps) {
		return;
	}
	for(let j=0; j<cps.length; j++){
		let g = cps[j];

		g.addEventListener('click', function() {
			g.classList.add('text-success');
			const input = document.createElement('input');
			input.setAttribute('value', g.getAttribute('data-copy') );
			document.body.appendChild(input);
			input.select();
			document.execCommand("copy");
			document.body.removeChild(input);
		});

		g.addEventListener('mouseout', () => {
			g.classList.remove('text-success');
		});
	}
}

const confirmBtnAction = () =>{
	const btns = document.querySelectorAll('.confirm-action, .btn-danger')
	if (!btns) {
		return;
	}
	let stopDefaultPrevention = false;
	for(let j=0; j < btns.length; j++){
		btns[j].addEventListener('click', function(e){
			const message = this.getAttribute('data-message')
			if (message) {
				const confirmation = confirm(message)
				if (confirmation) {
					stopDefaultPrevention = true;
				}
			}
			if (!stopDefaultPrevention) {
				e.preventDefault();
			}
		})
	}
}

const previewImageBeforeUpload = function () {
	let input = document.getElementById('preview-input')
	if ( ! input ) {
		return false;
	}
	let image = document.getElementById('preview-image')

	input.onchange = evt => {
		const [file] = input.files
		if (file) {
			image.src = URL.createObjectURL(file)
		}
	}
}

(function($){
	"use strict";

	confirmBtnAction();
	copyTOClipboard();

})(jQuery);