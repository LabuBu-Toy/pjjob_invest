<?php
/**
 * Public dashboard template
 *
 * @package PJJob_Invest
 * @var array $dashboard_data Dashboard data
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="pjjob-invest-dashboard">
	<div class="pjjob-container">
		<!-- Total Assets Card -->
		<div class="pjjob-card total-assets-card">
			<div class="card-content">
				<h3><?php esc_html_e( 'Total Assets', 'pjjob-invest' ); ?></h3>
				<div class="asset-value">
					$<?php echo esc_html( number_format( $dashboard_data['total_assets'], 2 ) ); ?>
				</div>
			</div>
		</div>

		<!-- Chart Container -->
		<div class="pjjob-card chart-card">
			<h3><?php esc_html_e( 'Growth/Loss Wealth Over Time', 'pjjob-invest' ); ?></h3>
			<div class="chart-container">
				<canvas id="wealthChart"></canvas>
			</div>
		</div>

		<!-- Categories Section -->
		<div class="pjjob-card categories-section">
			<h3><?php esc_html_e( 'Assets by Category', 'pjjob-invest' ); ?></h3>
			<div class="category-list">
				<?php
				if ( ! empty( $dashboard_data['categories'] ) ) :
					foreach ( $dashboard_data['categories'] as $index => $category ) :
						$percentage = $dashboard_data['total_assets'] > 0
							? ( floatval( $category['total'] ) / $dashboard_data['total_assets'] ) * 100
							: 0;
						$colors = array( '#0073aa', '#d32f2f', '#388e3c', '#f57c00', '#7b1fa2', '#0288d1' );
						$color  = $colors[ $index % count( $colors ) ];
						?>
						<div class="category-item">
							<div class="category-info">
								<span class="category-name"><?php echo esc_html( $category['category'] ); ?></span>
								<span class="category-count"><?php echo esc_html( $category['count'] ); ?> <?php esc_html_e( 'items', 'pjjob-invest' ); ?></span>
							</div>
							<div class="category-value">
								$<?php echo esc_html( number_format( floatval( $category['total'] ), 2 ) ); ?>
							</div>
							<div class="category-bar">
								<div class="bar-fill" style="width: <?php echo esc_attr( $percentage ); ?>%; background-color: <?php echo esc_attr( $color ); ?>;"></div>
							</div>
							<span class="category-percentage"><?php echo esc_html( number_format( $percentage, 1 ) ); ?>%</span>
						</div>
					<?php
					endforeach;
				else :
					?>
					<p><?php esc_html_e( 'No assets found', 'pjjob-invest' ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<!-- Assets List -->
		<div class="pjjob-card assets-list-section">
			<h3><?php esc_html_e( 'All Assets', 'pjjob-invest' ); ?></h3>
			<div class="assets-table-wrapper">
				<table class="assets-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Asset Name', 'pjjob-invest' ); ?></th>
							<th><?php esc_html_e( 'Amount', 'pjjob-invest' ); ?></th>
							<th><?php esc_html_e( 'Category', 'pjjob-invest' ); ?></th>
							<th><?php esc_html_e( 'Date', 'pjjob-invest' ); ?></th>
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
									<td><span class="category-badge"><?php echo esc_html( $asset['category'] ); ?></span></td>
									<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $asset['created_date'] ) ) ); ?></td>
								</tr>
							<?php
							endforeach;
						else :
							?>
							<tr>
								<td colspan="4" style="text-align: center; padding: 20px;"><?php esc_html_e( 'No assets found', 'pjjob-invest' ); ?></td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const monthlyData = <?php echo wp_json_encode( $dashboard_data['monthly_data'] ); ?>;
			const labels = Object.keys(monthlyData);
			const data = Object.values(monthlyData);

			const ctx = document.getElementById('wealthChart');
			if (ctx && typeof Chart !== 'undefined') {
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
							fill: true,
							borderWidth: 2,
							pointRadius: 5,
							pointBackgroundColor: '#0073aa'
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
