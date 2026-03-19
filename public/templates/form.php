<?php
/**
 * Public form template
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="pjjob-invest-form">
	<div class="pjjob-container">
		<div class="pjjob-card form-card">
			<h2><?php esc_html_e( 'Add Your Investment', 'pjjob-invest' ); ?></h2>
			
			<form id="pjjob-invest-form" class="pjjob-form">
				<div class="form-group">
					<label for="asset_name"><?php esc_html_e( 'Stock/Asset Name', 'pjjob-invest' ); ?> <span class="required">*</span></label>
					<input type="text" id="asset_name" name="asset_name" class="form-control" required
						placeholder="<?php esc_attr_e( 'e.g., Apple Inc (AAPL)', 'pjjob-invest' ); ?>">
					<small><?php esc_html_e( 'Enter the name of the stock or asset you purchased', 'pjjob-invest' ); ?></small>
				</div>

				<div class="form-group">
					<label for="holding_amount"><?php esc_html_e( 'Investment Amount ($)', 'pjjob-invest' ); ?> <span class="required">*</span></label>
					<input type="number" id="holding_amount" name="holding_amount" class="form-control" step="0.01" min="0" required
						placeholder="<?php esc_attr_e( '0.00', 'pjjob-invest' ); ?>">
					<small><?php esc_html_e( 'Enter the amount you invested', 'pjjob-invest' ); ?></small>
				</div>

				<div class="form-group">
					<label for="category"><?php esc_html_e( 'Investment Category', 'pjjob-invest' ); ?> <span class="required">*</span></label>
					<select id="category" name="category" class="form-control" required>
						<option value=""><?php esc_html_e( '-- Select Category --', 'pjjob-invest' ); ?></option>
						<option value="Stock"><?php esc_html_e( 'Stock', 'pjjob-invest' ); ?></option>
						<option value="Crypto"><?php esc_html_e( 'Cryptocurrency', 'pjjob-invest' ); ?></option>
						<option value="Real Estate"><?php esc_html_e( 'Real Estate', 'pjjob-invest' ); ?></option>
						<option value="Bonds"><?php esc_html_e( 'Bonds', 'pjjob-invest' ); ?></option>
						<option value="Mutual Funds"><?php esc_html_e( 'Mutual Funds', 'pjjob-invest' ); ?></option>
						<option value="ETF"><?php esc_html_e( 'ETF', 'pjjob-invest' ); ?></option>
						<option value="Other"><?php esc_html_e( 'Other', 'pjjob-invest' ); ?></option>
					</select>
					<small><?php esc_html_e( 'Select the category of your investment', 'pjjob-invest' ); ?></small>
				</div>

				<div class="form-group">
					<label for="created_date"><?php esc_html_e( 'Purchase Date', 'pjjob-invest' ); ?> <span class="required">*</span></label>
					<input type="date" id="created_date" name="created_date" class="form-control" required>
					<small><?php esc_html_e( 'When did you purchase this investment?', 'pjjob-invest' ); ?></small>
				</div>

				<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Add Investment', 'pjjob-invest' ); ?></button>
			</form>

			<div id="form-message" class="message hidden"></div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const form = document.getElementById('pjjob-invest-form');
			const messageDiv = document.getElementById('form-message');

			if (form) {
				form.addEventListener('submit', function(e) {
					e.preventDefault();

					const formData = new FormData(form);
					formData.append('action', 'pjjob_invest_add_asset');
					formData.append('nonce', pjjobInvestData.nonce);

					fetch(pjjobInvestData.ajaxUrl, {
						method: 'POST',
						body: formData
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							messageDiv.className = 'message success';
							messageDiv.innerHTML = '<p>' + data.data.message + '</p>';
							form.reset();
							setTimeout(() => {
								messageDiv.classList.add('hidden');
							}, 3000);
						} else {
							messageDiv.className = 'message error';
							messageDiv.innerHTML = '<p>' + data.data.message + '</p>';
						}
						messageDiv.classList.remove('hidden');
					})
					.catch(error => {
						messageDiv.className = 'message error';
						messageDiv.innerHTML = '<p><?php esc_html_e( 'An error occurred. Please try again.', 'pjjob-invest' ); ?></p>';
						messageDiv.classList.remove('hidden');
						console.error('Error:', error);
					});
				});
			}
		});
	</script>
</div>
