# Shortcode Usage Guide

> **See Also**: [SPECIFICATIONS.md](SPECIFICATIONS.md#page-structure--wireframes) | [Developer Guide](../DEVELOPMENT.md)

## Table of Contents

1. [Quick Start](#quick-start)
2. [Shortcodes Reference](#shortcodes-reference)
3. [Basic Usage](#basic-usage)
4. [Advanced Usage](#advanced-usage)
5. [Examples](#examples)
6. [Troubleshooting](#troubleshooting)
7. [Best Practices](#best-practices)
8. [Developer Information](#developer-information)

---

## Quick Start

The PJJob Invest plugin provides two main shortcodes to display investment portfolio management functionality on your WordPress site:

| Shortcode | Purpose | Use Case |
|-----------|---------|----------|
| `[pjjob_invest_dashboard]` | Display analytics dashboard | Portfolio overview |
| `[pjjob_invest_form]` | Display investment form | Add new investments |

### Add a Shortcode to Your Site

1. Go to **WordPress Admin** → **Pages** or **Posts**
2. Click **Edit** on the page where you want to add the shortcode
3. Click in the content area and type the shortcode:
   ```
   [pjjob_invest_dashboard]
   ```
4. Click **Publish** or **Update**

---

## Shortcodes Reference

### 1. Dashboard Shortcode

`[pjjob_invest_dashboard]`

**Purpose**: Display the complete investment portfolio dashboard with analytics and visualizations.

**Parameters**: None (currently no parameters available)

**Displays**:
- Total assets value
- Wealth growth chart (monthly trend)
- Assets by category breakdown
- Complete assets list table

**Requires**: 
- jQuery enqueued (WordPress default)
- Chart.js library (automatically loaded)
- At least one asset in database

**Example**:
```
[pjjob_invest_dashboard]
```

---

### 2. Form Shortcode

`[pjjob_invest_form]`

**Purpose**: Display the investment form allowing users to add new investments.

**Parameters**: None (currently no parameters available)

**Displays**:
- Stock/Asset name input
- Investment amount input
- Category dropdown
- Purchase date picker
- Submit button

**User Capabilities**: 
- Anyone can view the form
- Form submission requires nonce validation

**Example**:
```
[pjjob_invest_form]
```

---

## Basic Usage

### Display Dashboard Only

To show just the portfolio dashboard on a page:

1. Create a new Page in WordPress
2. Add the content:
   ```
   # My Investment Portfolio
   
   [pjjob_invest_dashboard]
   ```
3. Publish and view

### Display Form Only

To show only the investment form:

1. Create a new Page in WordPress
2. Add the content:
   ```
   # Add New Investment
   
   Use the form below to add a new investment to your portfolio.
   
   [pjjob_invest_form]
   ```
3. Publish and view

### Display Both (Typical Layout)

Create a comprehensive investment management page:

```
# Investment Portfolio Manager

## Dashboard
[pjjob_invest_dashboard]

---

## Add New Investment
[pjjob_invest_form]
```

---

## Advanced Usage

### In Custom Templates

You can also use shortcodes programmatically in your WordPress theme templates:

```php
<?php
// Display dashboard
echo do_shortcode('[pjjob_invest_dashboard]');
?>
```

```php
<?php
// Display form
echo do_shortcode('[pjjob_invest_form]');
?>
```

### Conditional Display

Display shortcode only to specific user roles:

```
<?php if (current_user_can('manage_options')) { ?>
    <?php echo do_shortcode('[pjjob_invest_dashboard]'); ?>
<?php } ?>
```

### Multiple Instances

You can display multiple shortcode instances on the same page, but they will share the same data source:

```
# Portfolio #1
[pjjob_invest_dashboard]

# Portfolio #2
[pjjob_invest_dashboard]

Both will display the same data
```

---

## Examples

### Example 1: Simple Portfolio Page

**Page Title**: My Investments

**Content**:
```
# Portfolio Overview

Below is my complete investment portfolio with current holdings and performance.

[pjjob_invest_dashboard]
```

**Result**: Visitors see the dashboard with all portfolio analytics

---

### Example 2: Investment Entry Page

**Page Title**: Add to My Portfolio

**Content**:
```
# Add New Investment

To add a new investment to your portfolio, please fill out the form below:

- **Stock Name**: The ticker symbol or company name (e.g., AAPL, Bitcoin)
- **Amount**: How much you invested in USD
- **Category**: Type of investment (Stock, Crypto, etc.)
- **Date**: When you made the investment

[pjjob_invest_form]

*Note: Your investment will appear in the dashboard immediately after submission.*
```

**Result**: Visitors see a form and can add new investments

---

### Example 3: Complete Management Portal

**Page Title**: Investment Management Center

**Content**:
```
# Investment Management Center

## 📊 Current Portfolio Overview

View your complete investment portfolio with detailed analytics:

[pjjob_invest_dashboard]

---

## ➕ Add New Investment

Ready to add another investment? Use the form below:

[pjjob_invest_form]

---

### 📚 Quick Tips

- Review your portfolio monthly
- Diversify across different categories
- Track your investments consistently
```

**Result**: Comprehensive management page with instructions

---

### Example 4: Multiple Sections Layout

**Page Title**: Finance Hub

**Content**:
```
# Finance Hub

## Section 1: Dashboard
[pjjob_invest_dashboard]

## Section 2: Quick Add
[pjjob_invest_form]

## Section 3: Information
Check back monthly to monitor your portfolio performance.
```

**Result**: Multi-section page with dashboard and form

---

## Troubleshooting

### Shortcode Not Displaying

**Problem**: The shortcode text appears as-is on the page instead of showing the dashboard or form.

**Solutions**:
1. Check spelling: `[pjjob_invest_dashboard]` (exact lowercase)
2. Ensure plugin is activated: WordPress Admin → Plugins
3. Check that you're in the page/post content area, not a widget
4. Try clearing WordPress cache if using a caching plugin
5. Disable all other plugins to check for conflicts

---

### Dashboard Shows "No Assets Found"

**Problem**: The dashboard appears but shows empty state.

**Solutions**:
1. Add assets using: WordPress Admin → Invest → Add Asset
2. Verify you've added at least one investment in the admin panel
3. Clear any caching (transient cache is cleared automatically on new asset)
4. Check that you're logged in as admin (if permission restricted)

---

### Form Not Accepting Submissions

**Problem**: The form appears but submissions don't work.

**Solutions**:
1. Check browser console (F12) for JavaScript errors
2. Verify jQuery is enabled in WordPress settings
3. Check that Chart.js library loads (open DevTools Network tab)
4. Disable WordPress security plugins temporarily to test
5. Ensure you're not on a page that disables AJAX

---

### Styling Issues

**Problem**: Shortcode content looks misaligned or poorly styled.

**Solutions**:
1. Check theme compatibility by switching to a default theme (Twenty Twenty-Three, etc.)
2. Disable other CSS-heavy plugins temporarily
3. Add custom CSS to override conflicts:
   ```css
   .pjjob-card {
       max-width: 100% !important;
   }
   ```
4. Clear WordPress and browser cache

---

### Chart Not Displaying

**Problem**: Dashboard shows but chart appears blank or broken.

**Solutions**:
1. Verify Chart.js loads from CDN (check Network tab in DevTools)
2. Check for JavaScript console errors (F12 → Console)
3. Ensure your browser supports ES6 (modern browsers)
4. Check that you have data (at least one asset in database)
5. Try in a different browser to isolate issue

---

### Form Field Validation Fails

**Problem**: Form rejects valid data with error messages.

**Solutions**:
1. Stock Name: Must not be empty (required field)
2. Buy Amount: Must be a positive number (0.01 minimum)
3. Category: Must select from dropdown (not custom text)
4. Date: Must be a valid date in past (not future)
5. Check file uploads if any (future enhancement)

---

## Best Practices

### ✅ DO

1. **Use Descriptive Page Titles**
   ```
   # My Investment Portfolio Dashboard
   ```

2. **Add Instructions**
   ```
   Use this dashboard to monitor your investments and track portfolio growth.
   
   [pjjob_invest_dashboard]
   ```

3. **Separate Dashboard and Form**
   ```
   ## View Portfolio
   [pjjob_invest_dashboard]
   
   ## Add Investment
   [pjjob_invest_form]
   ```

4. **Restrict Access if Needed**
   Use WordPress capabilities to restrict who sees the shortcode:
   ```php
   <?php if (current_user_can('manage_options')) {
       echo do_shortcode('[pjjob_invest_dashboard]');
   } ?>
   ```

5. **Test Before Publishing**
   - Create draft first
   - Preview shortcode
   - Check on mobile devices
   - Test form submission

6. **Optimize Page Load**
   - Minimize shortcodes per page (1-2 is ideal)
   - Use caching plugins for better performance
   - Don't put shortcodes in widgets unnecessarily

### ❌ DON'T

1. **Don't Edit Shortcode Code Directly**
   ```
   ❌ [pjjob_invest_dashboard param="value"]
   (parameters not supported in v1.0)
   ```

2. **Don't Nest Shortcodes**
   ```
   ❌ [pjjob_invest_dashboard [pjjob_invest_form] ]
   (won't work)
   ```

3. **Don't Place in Site Header/Footer**
   - Use pages or posts instead
   - Only put in main content area

4. **Don't Modify Plugin Files**
   - Changes will be lost on updates
   - Use hooks instead (see Developer section)

5. **Don't Display on Every Page**
   - Dashboard only on dedicated page
   - Will impact page load times
   - Create dedicated investment pages

---

## Developer Information

### For Plugin Developers

#### Registering Shortcodes

Shortcodes are registered in `pjjob-invest.php`:

```php
/**
 * Register shortcodes
 */
public function register_shortcodes() {
    add_shortcode('pjjob_invest_dashboard', array('PJJob_Invest_Shortcode', 'render_dashboard'));
    add_shortcode('pjjob_invest_form', array('PJJob_Invest_Shortcode', 'render_form'));
}
```

#### Shortcode Handler Class

See `includes/class-shortcode.php`:

```php
class PJJob_Invest_Shortcode {
    public static function render_dashboard($atts = array(), $content = null) {
        // Enqueue assets
        wp_enqueue_style('pjjob-invest-public-css');
        wp_enqueue_script('pjjob-invest-public-js');
        wp_enqueue_script('chart-js');
        
        // Get data and render
        $assets_manager = new PJJob_Invest_Assets_Manager();
        $dashboard_data = $assets_manager->get_dashboard_data();
        
        ob_start();
        include PJJOB_INVEST_PLUGIN_DIR . 'public/templates/dashboard.php';
        return ob_get_clean();
    }
    
    public static function render_form($atts = array(), $content = null) {
        // Similar pattern for form
    }
}
```

#### Adding Parameters to Shortcodes (Future Enhancement)

Example for future versions with parameters:

```php
public static function render_dashboard($atts = array(), $content = null) {
    $atts = shortcode_atts(array(
        'show_chart' => true,
        'show_categories' => true,
        'show_list' => true,
        'rows_per_page' => 10
    ), $atts, 'pjjob_invest_dashboard');
    
    // Use $atts in rendering
}

// Usage: [pjjob_invest_dashboard show_chart="true" show_list="false"]
```

#### Creating Custom Hooks

Add hooks for extensibility:

```php
// Before rendering
do_action('pjjob_invest_before_dashboard_render', $dashboard_data);

// After rendering
do_action('pjjob_invest_after_dashboard_render');

// Filter data
$dashboard_data = apply_filters('pjjob_invest_dashboard_data', $dashboard_data);
```

#### Extending Shortcode Output

```php
// Add custom HTML after dashboard
add_action('pjjob_invest_after_dashboard_render', function() {
    echo '<div class="custom-section">';
    echo 'Your custom content here';
    echo '</div>';
});
```

---

### Security Considerations

#### Nonce Validation

Shortcode forms include nonce verification:

```php
wp_nonce_field('pjjob_invest_nonce_action');

// Verify in AJAX handler
check_ajax_referer('pjjob_invest_nonce_action', 'nonce');
```

#### Input Sanitization

All form inputs are sanitized:

```php
sanitize_text_field($_POST['asset_name'])
floatval($_POST['holding_amount'])
sanitize_text_field($_POST['category'])
sanitize_text_field($_POST['created_date'])
```

#### User Capabilities

Admin pages check for `manage_options`:

```php
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions');
}
```

---

### AJAX - Form Submissions

#### Form Submit Endpoint

**Action**: `pjjob_invest_add_asset`  
**Method**: POST  
**Required Fields**: asset_name, holding_amount, category, created_date, nonce

#### JavaScript Handler

In `public/js/public.js`:

```javascript
fetch(pjjobInvestData.ajaxUrl, {
    method: 'POST',
    body: formData
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Show success message
        // Optionally refresh dashboard
    } else {
        // Show error message
    }
});
```

#### PHP Handler

In `pjjob-invest.php`:

```php
add_action('wp_ajax_pjjob_invest_add_asset', array($this, 'handle_add_asset'));
add_action('wp_ajax_nopriv_pjjob_invest_add_asset', array($this, 'handle_add_asset'));

public function handle_add_asset() {
    check_ajax_referer('pjjob_invest_nonce', 'nonce');
    
    // Validate and process
    $assets_manager = new PJJob_Invest_Assets_Manager();
    $result = $assets_manager->add_asset(...);
    
    if ($result) {
        wp_send_json_success(array(...));
    } else {
        wp_send_json_error(array(...));
    }
}
```

---

### Custom Styling

Override shortcode styles in your theme:

```css
/* Override dashboard card style */
.pjjob-card {
    background: #f0f0f0;
    border-radius: 10px;
}

/* Override form styling */
.pjjob-form input,
.pjjob-form select {
    border: 2px solid #0073aa;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .pjjob-card {
        margin-bottom: 15px;
    }
}
```

Add to your theme's `style.css` or custom CSS plugin.

---

## FAQ

**Q: Can I use both shortcodes on the same page?**  
A: Yes! They work independently and share the same data source.

**Q: Can I customize the shortcode appearance?**  
A: Yes, using CSS or custom hooks (see Developer section).

**Q: Do I need to be logged in to use the shortcodes?**  
A: Dashboard is public. Form includes AJAX with nonce for security.

**Q: Can I add parameters to shortcodes?**  
A: Currently no, but this is planned for future versions.

**Q: What if the shortcode breaks after plugin update?**  
A: Clear cache and deactivate/reactivate the plugin.

**Q: Can I use shortcodes in widgets?**  
A: Built-in widgets don't support shortcodes by default. Use a custom widget or plugin.

---

**Reference**: [Shortcode Handbook](../DEVELOPMENT.md#shortcodes)  
**Last Updated**: 2026-03-19  
**Status**: ✅ Complete
