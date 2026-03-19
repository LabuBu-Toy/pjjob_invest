/* Public JavaScript */

document.addEventListener('DOMContentLoaded', function() {
	initializePublicCharts();
	initializePublicForms();
	formatCurrencyValues();
});

/**
 * Initialize public charts
 */
function initializePublicCharts() {
	const ctx = document.getElementById('wealthChart');
	
	if (ctx && typeof Chart !== 'undefined') {
		// Chart initialization is handled in templates
	}
}

/**
 * Initialize public forms
 */
function initializePublicForms() {
	const form = document.getElementById('pjjob-invest-form');
	
	if (form) {
		// Set today's date as default
		const dateInput = form.querySelector('input[name="created_date"]');
		if (dateInput) {
			const today = new Date().toISOString().split('T')[0];
			dateInput.value = today;
		}

		form.addEventListener('submit', function(e) {
			e.preventDefault();
			// Form submission is handled in templates
		});
	}
}

/**
 * Format currency values on page
 */
function formatCurrencyValues() {
	const currencyElements = document.querySelectorAll('[data-currency]');
	currencyElements.forEach(function(el) {
		const value = parseFloat(el.textContent);
		if (!isNaN(value)) {
			el.textContent = formatCurrency(value);
		}
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
 * Show notification
 */
function showNotification(message, type = 'success', duration = 3000) {
	const notification = document.createElement('div');
	notification.className = 'notification notification-' + type;
	notification.innerHTML = '<p>' + message + '</p>';
	
	const container = document.querySelector('.pjjob-invest-form') || document.querySelector('.pjjob-invest-dashboard');
	if (container) {
		container.insertBefore(notification, container.firstChild);
		
		setTimeout(function() {
			notification.style.opacity = '0';
			setTimeout(function() {
				notification.remove();
			}, 300);
		}, duration);
	}
}

/**
 * Utility: Get query parameter
 */
function getQueryParam(param) {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get(param);
}

/**
 * Utility: Validation
 */
const Validation = {
	isEmail: function(email) {
		const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return regex.test(email);
	},
	
	isPositiveNumber: function(value) {
		return !isNaN(value) && parseFloat(value) > 0;
	},
	
	isValidDate: function(date) {
		return date instanceof Date && !isNaN(date);
	}
};
