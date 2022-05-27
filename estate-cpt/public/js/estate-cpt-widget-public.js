(function(window, document, undefined) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	 
	 
	 
	//function get_pagination_page()
	 
	 
	 
	document.addEventListener('DOMContentLoaded', () => {
		
		
		const estateFilter = document.getElementsByClassName('js-estate-filter')[0];
		if (estateFilter) {
			const estateFilterForm = estateFilter.getElementsByClassName('js-estate-filter__form')[0];
			const btnSubmit = estateFilterForm.getElementsByClassName('js-estate-filter__submit')[0];
			const estateFilterContent = estateFilter.getElementsByClassName('js-estate-filter__content')[0];
			const estatePaginationWrap = estateFilter.getElementsByClassName('js-estate-filter__pagination')[0];
			
			estateFilterForm.addEventListener('submit', event => {
				event.preventDefault();

				// vars
				const spinnerClassname = 'spinner-border';
				const spinner = `<div class="${spinnerClassname}" role="status"><span class="visually-hidden">Loading...</span></div>`;
				const form = event.currentTarget;
				const method = form.getAttribute('method');
				const contentType = form.getAttribute('enctype') || 'application/x-www-form-urlencoded';
				const ajaxURL = npEstateAjaxData.url;
				const formData = new FormData(form);
				formData.append('action', npEstateAjaxData.action);
				formData.append('_ajax_nonce', npEstateAjaxData.nonce);
				
				
				
				// Set Preloader
				btnSubmit.disabled = true; // changing the button state
				estateFilterContent.innerHTML = spinner;
				estatePaginationWrap.innerHTML = '';
				
				axios
					.post(ajaxURL, formData, {
						headers: {'Content-type': contentType}
					})
					.then(function (response) {
						console.log(response.data.data);
						
						btnSubmit.disabled = false;
						estateFilterContent.querySelector(`.${spinnerClassname}`).remove();
						if (!response.data.data.posts) return;
						
						estateFilterContent.insertAdjacentHTML('afterbegin', response.data.data.posts); // insert data
						estateFilterContent.scrollIntoView({block: "start", behavior: "smooth"});
						
						if (response.data.data.pagination) {
							estatePaginationWrap.insertAdjacentHTML('afterbegin', response.data.data.pagination); // insert data
						}
					})
					.catch(function (error) {
						btnSubmit.disabled = false;
						estateFilterContent.querySelector('.spinner-border').remove();
						estateFilterContent.insertAdjacentHTML('afterbegin', error); // insert data
						console.log(error);
					});
				
			});
			
			
			
			
			// Pagination
			estateFilter.addEventListener('click', event => {
				if (!event.target.closest('a.page-numbers')) return;
				event.preventDefault();
				
				// Get Paged Value
				const url = new URL(event.target.href);
				const number = url.searchParams.get('paged');
				
				// Create hidden input with paged value
				const input = document.createElement("input");
                input.type = 'hidden';
                input.name = 'paged';
				input.value = number;
				
				// Put input to the form
				estateFilterForm.appendChild(input);
				
				// Submit form
				btnSubmit.click();						
			});
			
			
			
			// Show/Hide Appartments Filters
			const appFiltersTrigger = estateFilter.getElementsByClassName('js-appFiltersTrigger')[0];
			const appFiltersContainer = estateFilter.getElementsByClassName('js-appartments-filters')[0];
			const checkAppTrigger = () => {
				if (appFiltersTrigger.checked) appFiltersContainer.hidden = false;
				if (!appFiltersTrigger.checked) appFiltersContainer.hidden = true;
			};
			
			checkAppTrigger();
			appFiltersTrigger.addEventListener('change', () => checkAppTrigger() );
			
			
		} // end if estateFilter
		
		
	}); // dom ready
	

})(window, document);
