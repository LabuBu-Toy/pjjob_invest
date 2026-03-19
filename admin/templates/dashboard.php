<?php
/**
 * Admin dashboard template
 *
 * @package PJJob_Invest
 * @var array $dashboard_data Dashboard data
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap pjjob-invest-admin">
	<h1><?php esc_html_e( 'Investment Dashboard', 'pjjob-invest' ); ?></h1>

	<div class="dashboard-container">
		<!-- Total Assets Card -->
		<div class="dashboard-card total-assets-card">
			<h3><?php esc_html_e( 'Total Assets', 'pjjob-invest' ); ?></h3>
			<div class="asset-value">
				$<?php echo esc_html( number_format( $dashboard_data['total_assets'], 2 ) ); ?>
			</div>
		</div>

		<!-- Chart Container -->
		<div class="dashboard-card chart-card">
			<h3><?php esc_html_e( 'Growth/Loss Wealth Over Time', 'pjjob-invest' ); ?></h3>
			<canvas id="wealthChart"></canvas>
		</div>

		<!-- Categories Section -->
		<div class="dashboard-card categories-section">
			<h3><?php esc_html_e( 'Assets by Category', 'pjjob-invest' ); ?></h3>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Category', 'pjjob-invest' ); ?></th>
						<th><?php esc_html_e( 'Total Value', 'pjjob-invest' ); ?></th>
						<th><?php esc_html_e( 'Count', 'pjjob-invest' ); ?></th>
						<th><?php esc_html_e( 'Percentage', 'pjjob-invest' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ( ! empty( $dashboard_data['categories'] ) ) :
						foreach ( $dashboard_data['categories'] as $category ) :
							$percentage = $dashboard_data['total_assets'] > 0
								? ( floatval( $category['total'] ) / $dashboard_data['total_assets'] ) * 100
								: 0;
							?>
							<tr>
								<td><?php echo esc_html( $category['category'] ); ?></td>
								<td>$<?php echo esc_html( number_format( floatval( $category['total'] ), 2 ) ); ?></td>
								<td><?php echo esc_html( $category['count'] ); ?></td>
								<td><?php echo esc_html( number_format( $percentage, 2 ) ); ?>%</td>
							</tr>
						<?php
						endforeach;
					else :
						?>
						<tr>
							<td colspan="4"><?php esc_html_e( 'No assets found', 'pjjob-invest' ); ?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>

		<!-- Assets List -->
		<div class="dashboard-card assets-list-section">
			<h3><?php esc_html_e( 'All Assets', 'pjjob-invest' ); ?></h3>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Asset Name', 'pjjob-invest' ); ?></th>
						<th><?php esc_html_e( 'Amount', 'pjjob-invest' ); ?></th>
						<th><?php esc_html_e( 'Category', 'pjjob-invest' ); ?></th>
						<th><?php esc_html_e( 'Date purchased', 'pjjob-invest' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ( ! empty( $dashboard_data['assets_list'] ) ) :
						foreach ( $dashboard_data['assets_list'] as $asset ) :
							?>
							<tr>
								<td><?php echo esc_html( $asset['asset_name'] ); ?></td>
								<td>$<?php echo esc_html( number_format( floatval( $asset['holding_amount'] ), 2 ) ); ?></td>
								<td><?php echo esc_html( $asset['category'] ); ?></td>
								<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $asset['created_date'] ) ) ); ?></td>
							</tr>
						<?php
						endforeach;
					else :
						?>
						<tr>
							<td colspan="4"><?php esc_html_e( 'No assets found', 'pjjob-invest' ); ?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const monthlyData = <?php echo wp_json_encode( $dashboard_data['monthly_data'] ); ?>;
			const labels = Object.keys(monthlyData);
			const data = Object.values(monthlyData);

			const ctx = document.getElementById('wealthChart');
			if (ctx) {
				new Chart(ctx, {
					type: 'line',
					data: {
						labels: labels,
						datasets: [{
							label: '<?php esc_html_e( 'Wealth Growth', 'pjjob-invest' ); ?>',
							data: data,
							borderColor: '#0073aa',
							backgroundColor: 'rgba(0, 115, 170, 0.1)',
							tension: 0.4,
							fill: true
						}]
					},
					options: {
						responsive: true,
						maintainAspectRatio: true,
						plugins: {
							legend: {
								display: true,
								position: 'top'
							}
						},
						scales: {
							y: {
								beginAtZero: true,
								ticks: {
									callback: function(value) {
										return '$' + value.toFixed(2);
									}
								}
							}
						}
					}
				});
			}
		});
	</script>
</div>
