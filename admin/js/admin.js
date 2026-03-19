/* Admin JavaScript */

document.addEventListener('DOMContentLoaded', function() {
	// Initialize admin functionality
	initializeAdminCharts();
	initializeAdminForms();
});

/**
 * Initialize admin charts
 */
function initializeAdminCharts() {
	const charts = document.querySelectorAll('[id$="Chart"]');
	charts.forEach(function(chart) {
		if (chart && typeof Chart !== 'undefined') {
			// Chart initialization is already handled in templates
		}
	});
}

/**
 * Initialize admin forms
 */
function initializeAdminForms() {
	const forms = document.querySelectorAll('.pjjob-form');
	forms.forEach(function(form) {
		form.addEventListener('submit', function(e) {
			e.preventDefault();
			// Form submission handling is in templates
		});
	});
}

/**
 * Format currency
 */
function formatCurrency(value) {
	return new Intl.NumberFormat('en-US', {
		style: 'currency',
		currency: 'USD'
	}).format(value);
}

/**
 * Show notice message
 */
function showNotice(message, type = 'success') {
	const notice = document.createElement('div');
	notice.className = 'notice notice-' + type + ' is-dismissible';
	notice.innerHTML = '<p>' + message + '</p>';
	
	const container = document.querySelector('.wrap');
	if (container) {
		container.insertBefore(notice, container.firstChild);
		
		setTimeout(function() {
			notice.remove();
		}, 5000);
	}
}
