<?php
/**
 * Admin add asset template
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap pjjob-invest-admin">
	<h1><?php esc_html_e( 'Add New Asset', 'pjjob-invest' ); ?></h1>

	<div class="add-asset-container">
		<form id="pjjob-invest-asset-form" class="pjjob-form">
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="asset_name"><?php esc_html_e( 'Stock Name', 'pjjob-invest' ); ?></label>
					</th>
					<td>
						<input type="text" id="asset_name" name="asset_name" class="regular-text" required
							placeholder="<?php esc_attr_e( 'e.g., Apple Inc (AAPL)', 'pjjob-invest' ); ?>">
						<p class="description"><?php esc_html_e( 'Enter the name of the stock or asset', 'pjjob-invest' ); ?></p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="holding_amount"><?php esc_html_e( 'Buy Amount', 'pjjob-invest' ); ?></label>
					</th>
					<td>
						<input type="number" id="holding_amount" name="holding_amount" class="regular-text" step="0.01" min="0" required
							placeholder="<?php esc_attr_e( '0.00', 'pjjob-invest' ); ?>">
						<p class="description"><?php esc_html_e( 'Enter the amount you invested', 'pjjob-invest' ); ?></p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="category"><?php esc_html_e( 'Category', 'pjjob-invest' ); ?></label>
					</th>
					<td>
						<select id="category" name="category" class="regular-text" required>
							<option value=""><?php esc_html_e( '-- Select Category --', 'pjjob-invest' ); ?></option>
							<option value="Stock"><?php esc_html_e( 'Stock', 'pjjob-invest' ); ?></option>
							<option value="Crypto"><?php esc_html_e( 'Crypto', 'pjjob-invest' ); ?></option>
							<option value="Real Estate"><?php esc_html_e( 'Real Estate', 'pjjob-invest' ); ?></option>
							<option value="Bonds"><?php esc_html_e( 'Bonds', 'pjjob-invest' ); ?></option>
							<option value="Mutual Funds"><?php esc_html_e( 'Mutual Funds', 'pjjob-invest' ); ?></option>
							<option value="Other"><?php esc_html_e( 'Other', 'pjjob-invest' ); ?></option>
						</select>
						<p class="description"><?php esc_html_e( 'Select the asset category', 'pjjob-invest' ); ?></p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="created_date"><?php esc_html_e( 'Date Purchased', 'pjjob-invest' ); ?></label>
					</th>
					<td>
						<input type="date" id="created_date" name="created_date" class="regular-text" required>
						<p class="description"><?php esc_html_e( 'Select the date you purchased this asset', 'pjjob-invest' ); ?></p>
					</td>
				</tr>
			</table>

			<p class="submit">
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Add Asset', 'pjjob-invest' ); ?></button>
			</p>
		</form>

		<div id="message" class="notice notice-info" style="display: none;"></div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const form = document.getElementById('pjjob-invest-asset-form');
			const messageDiv = document.getElementById('message');

			form.addEventListener('submit', function(e) {
				e.preventDefault();

				const formData = new FormData(form);
				formData.append('action', 'pjjob_invest_add_asset');
				formData.append('nonce', pjjobInvestAdmin.nonce);

				fetch(pjjobInvestAdmin.ajaxUrl, {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						messageDiv.className = 'notice notice-success is-dismissible';
						messageDiv.innerHTML = '<p>' + data.data.message + '</p>';
						form.reset();
						setTimeout(() => {
							window.location.reload();
						}, 1500);
					} else {
						messageDiv.className = 'notice notice-error is-dismissible';
						messageDiv.innerHTML = '<p>' + data.data.message + '</p>';
					}
					messageDiv.style.display = 'block';
				})
				.catch(error => {
					messageDiv.className = 'notice notice-error is-dismissible';
					messageDiv.innerHTML = '<p><?php esc_html_e( 'An error occurred. Please try again.', 'pjjob-invest' ); ?></p>';
					messageDiv.style.display = 'block';
					console.error('Error:', error);
				});
			});
		});
	</script>
</div>
