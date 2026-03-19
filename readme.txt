=== PJJob Invest ===
Contributors: Your Name
Tags: investment, portfolio, assets, finance, stocks, crypto
Requires at least: 5.0
Requires PHP: 7.4
Tested up to: 6.4
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A comprehensive WordPress plugin to manage and track your investment portfolio with visual analytics and category-based organization.

== Description ==

PJJob Invest is a powerful WordPress plugin designed to help you track, manage, and visualize your investment portfolio. Whether you're investing in stocks, cryptocurrencies, real estate, bonds, mutual funds, or ETFs, this plugin provides an intuitive interface to log your investments and monitor your wealth growth over time.

**Key Features:**

* **Easy Asset Management**: Add your investments with stock name, purchase amount, category, and purchase date
* **Investment Dashboard**: Visualize your total assets, wealth growth over time with interactive charts
* **Category Breakdown**: Organize assets by category and see detailed breakdowns
* **Category Rankings**: Automatically rank your categories by total investment value  
* **Admin Panel**: Full admin interface for purchasing and managing assets
* **Public Shortcodes**: Display dashboard and form on front-end pages
* **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
* **Security**: Nonce validation and proper sanitization of all inputs
* **Performance**: Optimized database queries and transient caching

**Asset Categories Supported:**

* Stock
* Cryptocurrency
* Real Estate
* Bonds
* Mutual Funds
* ETF
* Other (custom categories)

**Available Shortcodes:**

`[pjjob_invest_dashboard]` - Display the investment dashboard with all analytics
`[pjjob_invest_form]` - Display the form to add new investments

== Installation ==

1. Upload the `pjjob-invest` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to "Invest" menu in the WordPress admin panel to get started

== Usage ==

**In Admin Panel:**

1. Go to Invest > Add Asset to add new investments
2. Fill in the asset details:
   - Stock/Asset Name (e.g., Apple Inc - AAPL)
   - Buy Amount (investment amount in USD)
   - Category (stock, crypto, real estate, etc.)
   - Date Purchased (when you made the investment)
3. Click "Add Asset"
4. View your dashboard at Invest > Dashboard to see:
   - Total Assets value
   - Wealth growth chart
   - Assets by category breakdown
   - Complete list of all assets

**On Front-End:**

Add the shortcodes to any page or post:

`[pjjob_invest_dashboard]` - Shows the complete dashboard with analytics
`[pjjob_invest_form]` - Shows the form for visitors to add investments

== Frequently Asked Questions ==

= Is there a limit to how many investments I can add? =
No, you can add unlimited investments. The plugin is optimized to handle large portfolios efficiently.

= Can I access the dashboard from the front-end? =
Yes! Use the `[pjjob_invest_dashboard]` shortcode on any page or post to display the dashboard publicly.

= Can I delete assets I've added? =
Currently, assets are soft-deleted (marked as deleted but data is preserved). Direct deletion support can be added in future versions.

= Is my data safe? =
The plugin uses:
- WordPress nonce verification for security
- Input sanitization to prevent injection attacks
- Prepared database queries to prevent SQL injection
- Proper user capability checks

= What happens to my data when I uninstall? =
When you uninstall the plugin, all asset data is permanently deleted. Please export or backup your data before uninstalling.

= Can I export my investment data? =
Future versions will include export functionality (CSV, Excel). Currently you can view all data in the admin dashboard.

== Changelog ==

= 1.0.0 =
* Initial release
* Investment tracking functionality
* Dashboard with analytics and charts
* Admin panel for asset management
* Public shortcodes for front-end display
* Responsive design for all devices
* Chart.js integration for wealth visualization

== Upgrade Notice ==

= 1.0.0 =
Initial release of PJJob Invest. Fresh install only.

== Support ==

For support and feature requests, please visit the plugin repository or contact the developer.

== Credits ==

This plugin uses:
* Chart.js (https://www.chartjs.org/) - For data visualization
* WordPress Coding Standards - For best practices

== License ==

This plugin is released under the GPL v2.0 License.
See License URI for details.
