(function(window, document, undefined) {
	'use strict';

	
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
				estateFilterContent.scrollIntoView({block: "start", behavior: "smooth"});
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
						
						setTimeout( () => {
							estateFilterContent.insertAdjacentHTML('afterbegin', response.data.data.posts); // insert data
							if (response.data.data.pagination) {
								estatePaginationWrap.insertAdjacentHTML('afterbegin', response.data.data.pagination); // insert data
							}
						}, 250);
						
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
				const number = url.searchParams.get('paged') || 1;
				
				const inputPaged = estateFilter.getElementsByClassName('js-estate-filter-item__paged')[0];
				if (inputPaged) inputPaged.value = number;
				
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
