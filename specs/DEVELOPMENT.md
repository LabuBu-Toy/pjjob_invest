# PJJob Invest Plugin - Development Guide

## Quick Start

### Installation

1. Navigate to your WordPress plugins directory: `/wp-content/plugins/`
2. Copy the `pjjob-invest` folder here
3. Go to WordPress Admin > Plugins
4. Activate "PJJob Invest"

### First Steps

After activation, you'll see a new "Invest" menu in the WordPress admin:
- **Dashboard**: View your portfolio analytics
- **Add Asset**: Add new investments

## Project Structure

```
pjjob-invest/
├── pjjob-invest.php          # Main plugin file
├── uninstall.php              # Cleanup on uninstall
├── readme.txt                 # Plugin documentation
├── includes/                  # Core plugin classes
│   ├── class-activator.php   # Plugin activation
│   ├── class-deactivator.php # Plugin deactivation
│   ├── class-database.php    # Database operations
│   ├── class-assets-manager.php # Asset management
│   └── class-shortcode.php   # Shortcode handlers
├── admin/                     # Admin panel files
│   ├── class-admin-pages.php # Admin page controllers
│   ├── templates/
│   │   ├── dashboard.php     # Admin dashboard
│   │   └── add-asset.php     # Add asset form
│   ├── css/
│   │   └── admin.css         # Admin styles
│   └── js/
│       └── admin.js          # Admin scripts
├── public/                    # Front-end files
│   ├── templates/
│   │   ├── dashboard.php     # Public dashboard
│   │   └── form.php          # Public form
│   ├── css/
│   │   └── public.css        # Public styles
│   └── js/
│       └── public.js         # Public scripts
├── languages/                # Translation files
└── assets/                   # Screenshots for plugin repo
```

## Database

**Table Name**: `wp_pjjob_invest_assets` (wp_ is the default WordPress prefix)

**Structure**:
```sql
CREATE TABLE wp_pjjob_invest_assets (
    asset_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    asset_name VARCHAR(255) NOT NULL,
    holding_amount DECIMAL(15, 2) NOT NULL,
    created_date DATETIME NOT NULL,
    deleted_date DATETIME NULL,
    category VARCHAR(100),
    KEY category (category)
);
```

## Core Classes

### PJJob_Invest_Database
Handles all database operations:
- `insert_asset()` - Add new asset
- `get_all_assets()` - Retrieve all active assets
- `get_assets_by_category()` - Filter by category
- `get_total_assets()` - Calculate total value
- `get_categories_with_totals()` - Category breakdown
- `delete_asset()` - Soft delete asset
- `get_asset()` - Get single asset

### PJJob_Invest_Assets_Manager
Business logic layer:
- `add_asset()` - Validate and add asset
- `get_all_assets()` - Get assets with caching
- `get_dashboard_data()` - Compile dashboard data
- `calculate_assets_by_month()` - Monthly trend

### PJJob_Invest_Shortcode
Renders front-end content:
- `render_dashboard()` - Display analytics dashboard
- `render_form()` - Display investment form

### PJJob_Invest_Admin_Pages
Admin interface:
- `display_dashboard()` - Admin dashboard page
- `display_add_asset()` - Asset form page

## Shortcodes

### Dashboard Shortcode
```
[pjjob_invest_dashboard]
```
Displays:
- Total assets value
- Wealth growth chart (monthly)
- Category breakdown
- All assets table

### Form Shortcode
```
[pjjob_invest_form]
```
Displays the investment form for adding new assets.

## Security Features

1. **Nonce Verification**: All AJAX requests use WordPress nonces
2. **Input Sanitization**: All user inputs are sanitized
3. **Capability Checks**: Admin pages require `manage_options`
4. **Prepared Queries**: All database queries use prepared statements
5. **CSRF Protection**: Implemented via nonce tokens

## AJAX Endpoints

### Add Asset
- **Action**: `pjjob_invest_add_asset`
- **Method**: POST
- **Required Fields**:
  - `asset_name` - String
  - `holding_amount` - Float
  - `category` - String
  - `created_date` - Date string
  - `nonce` - Security token

**Response**:
```json
{
    "success": true,
    "data": {
        "message": "Asset added successfully"
    }
}
```

## Development Tips

### Adding New Features

1. **New Database Field**: 
   - Update `class-activator.php` (CREATE TABLE)
   - Update `class-database.php` (queries)
   - Update templates to display the field

2. **New Admin Page**:
   - Add method to `class-admin-pages.php`
   - Create template in `admin/templates/`
   - Add submenu in main plugin file

3. **New Shortcode**:
   - Add method to `class-shortcode.php`
   - Create template in `public/templates/`
   - Register in main plugin file

### Testing Locally

1. Use WordPress local development tools (Local, XAMPP, Laragon, etc.)
2. Install WordPress
3. Copy plugin to `/wp-content/plugins/`
4. Activate and test

### Debugging

Enable WordPress debug mode in `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG_LOG', true);
```

Check logs in `/wp-content/debug.log`

## Performance Considerations

1. **Caching**: Dashboard data uses transients (cleared on asset changes)
2. **Queries**: Uses indexes on `category` column
3. **Scripts**: Chart.js loaded only when needed
4. **CSS**: Scoped to plugin classes to prevent conflicts

## Browser Support

- Chrome/Edge: Latest 2 versions
- Firefox: Latest 2 versions
- Safari: Latest 2 versions
- Mobile browsers: Latest versions

## Version History

**1.0.0** (Initial Release)
- Investment asset management
- Dashboard with analytics
- Chart visualization
- Category breakdown
- Admin and public interfaces

## Future Enhancements

- Data export (CSV, PDF)
- Current value tracking
- Return on investment (ROI) calculations
- Scheduled price updates
- Multi-currency support
- Asset performance analytics
- Admin email notifications
- Rest API endpoints
- Bulk import functionality

## Known Limitations

- Currently supports USD currency
- Simple price tracking (manual entry)
- No real-time data feeds
- Single-user support (not multi-site optimized)

## Support & Contribution

For bugs, feature requests, or contributions:
1. Report issues with detailed reproduction steps
2. Include WordPress version and plugin version
3. Provide error logs if available
4. Submit feature requests with use case descriptions

## License

GPL v2.0 or later - See LICENSE file
