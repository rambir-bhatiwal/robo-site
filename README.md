# Robo Theme

* **Theme Name**: Robo
* **Version**: 1.0.0
* **Description**: A highly customizable, modern, and responsive Bootstrap 5 WordPress theme designed for businesses, portfolios, and blogs. Features extensive custom homepage sections and a robust, styled WooCommerce integration.
* **Requirements**:
  * **WordPress**: 6.0+
  * **PHP**: 8.0+
  * **WooCommerce**: 8.0+
  * **Bootstrap**: 5.3.3

---

## Theme Features

* **Bootstrap 5 Integration**: CDN-free layout engine enqueuing compiled Bootstrap 5.3.3 core stylesheets and bundle scripts locally.
* **Responsive Layout**: Designed with a fluid grid system optimized for all mobile, tablet, and desktop viewports.
* **Custom Header**: Supports a primary navigation navbar, dynamic site logo, secondary top utility bar (with contact info and social icons), and interactive actions.
* **Custom Footer**: Features a flexible 4-column widgetized area and a customizer-controlled copyright footer text.
* **Navigation Menu**: 5 menu locations registered out of the box (Primary, Footer, Topbar, Mobile, and Social).
* **Mobile Menu**: Responsive toggle navigation supporting mobile-specific layouts.
* **Dropdown Navigation**: Standard-compliant multi-level nested dropdown navigation implemented via a custom walker.
* **Hero Section**: Fully customizable banner supporting uploader background images, headings, subheadings, call-to-action buttons, and up to 4 statistics slots.
* **Home Page Sections**: Dynamic homepage (`front-page.php`) rendering 14 customizable sections in the following order:
  1. Hero
  2. About
  3. Services
  4. Popular Products
  5. Features
  6. Portfolio
  7. Counter
  8. Testimonials
  9. Team
  10. Pricing
  11. FAQ
  12. Latest Blog
  13. Newsletter
  14. Contact
* **WooCommerce Integration**: Custom-styled shop loop, pages, and widgets styled using Bootstrap classes.
* **Shop Page**: Overridden templates to replace standard layouts with clean product grids, sidebar filters, styled sorting forms, and result count elements.
* **Single Product Page**: Dual-column details template featuring AJAX-enabled Frequently Bought Together (FBT) bundles, direct "Buy Now" checkout redirect buttons, tab blocks, and related/upsell carousels.
* **Cart Page**: Table layouts, coupon fields, quantity fields, and AJAX-driven "Clear Cart" features.
* **Theme Assets**: Dedicated script modules and stylesheets split by context (general main theme actions vs WooCommerce details).
* **Custom CSS**: Color controls and accent definitions injected dynamically into the site `<head>` based on Customizer inputs.
* **Custom JavaScript**: Client-side logic for navigation walker triggers, AJAX quick-view modals, product bundle forms, and postcode shipping checkers.
* **Theme Support**: Enriched native support for:
  * `automatic-feed-links`
  * `title-tag`
  * `post-thumbnails`
  * `html5` (search-form, comment-form, comment-list, gallery, caption, style, script)
  * `custom-background`
  * `custom-logo`
  * `custom-header`
  * `customize-selective-refresh-widgets`
  * `wp-block-styles`
  * `align-wide`
  * `responsive-embeds`
  * `editor-styles`

---

## Theme Structure

```text
robo/
├── 404.php                       # 404 Error page template
├── archive.php                   # Archive template (categories, tags, dates)
├── author.php                    # Author profile page template
├── category.php                  # Category archive template
├── comments.php                  # Comments list and comment form template
├── footer.php                    # Theme footer template
├── front-page.php                # Homepage layout (loads homepage sections)
├── functions.php                 # Core functions loader
├── header.php                    # Theme header template
├── home.php                      # Blog index template
├── index.php                     # Main fallback template
├── page.php                      # Single page template
├── README.md                     # Theme documentation
├── screenshot.png                # Theme screenshot
├── search.php                    # Search results template
├── sidebar.php                   # Standard sidebar template
├── single.php                    # Single post template
├── style.css                     # Primary stylesheet containing theme metadata
├── tag.php                       # Tag archive template
├── assets/                       # Static assets
│   ├── css/
│   │   ├── bootstrap.min.css     # Local Bootstrap 5 stylesheet
│   │   ├── single-product.css    # Single product custom styles
│   │   ├── style.css             # Main theme styles
│   │   └── woocommerce.css       # WooCommerce customization styles
│   ├── images/                   # Empty directory for theme images
│   └── js/
│       ├── bootstrap.bundle.min.js # Bootstrap bundle (with Popper.js)
│       ├── main.js               # Theme core JS
│       ├── single-product.js     # Single product AJAX and FBT scripts
│       └── woocommerce.js        # Core WooCommerce AJAX scripts
├── inc/                          # PHP Helper files & controllers
│   ├── breadcrumbs.php           # Breadcrumbs rendering class/function
│   ├── customizer.php            # Customizer controls panel configuration
│   ├── enqueue.php               # Scripts and styles registration
│   ├── helpers.php               # Utility functions (reading time, views count)
│   ├── navwalker.php             # Custom Bootstrap 5 NavWalker
│   ├── pagination.php            # Bootstrap 5 styled pagination generator
│   ├── setup.php                 # Theme setup hooks and supports
│   ├── template-functions.php    # Post details & layout rendering tags
│   ├── widgets.php               # Register sidebars and widget locations
│   └── woocommerce.php           # WooCommerce compatibility & AJAX callbacks
├── languages/                    # Internationalization translations folder
├── template-parts/               # Modular theme template parts
│   ├── content/
│   │   ├── content-none.php      # Content fallback when no posts found
│   │   ├── content-page.php      # Page content template
│   │   ├── content-single.php    # Single post content template
│   │   └── content.php           # Index/Archive post list template
│   ├── footer/
│   │   └── footer-widgets.php    # Footer 4-column widget display
│   ├── header/
│   │   ├── navigation.php        # Primary header navigation bar
│   │   └── topbar.php            # Secondary header topbar
│   └── sections/                 # Static front page sections
│       ├── about.php             # About Us section
│       ├── contact.php           # Contact Form & Details section
│       ├── counter.php           # Statistics Counter section
│       ├── faq.php               # FAQ Accordion section
│       ├── features.php          # Core Features section
│       ├── hero.php              # Customizer-powered Hero section
│       ├── latest-blog.php       # Latest Blog posts feed section
│       ├── newsletter.php        # Newsletter signup section
│       ├── popular-products.php  # Best-seller product cards section
│       ├── portfolio.php         # Portfolio grid section
│       ├── pricing.php           # Pricing tables section
│       ├── services.php          # Company Services section
│       ├── team.php              # Team members section
│       └── testimonials.php      # Testimonial slider section
└── woocommerce/                  # WooCommerce template overrides
    ├── archive-product.php       # Main catalog / shop page layout
    ├── content-product.php       # Custom product card layout
    ├── content-single-product.php# Custom single product page layout
    ├── single-product.php        # Wraps single products in container
    ├── cart/
    │   ├── cart-totals.php       # Styled cart totals breakdown block
    │   └── cart.php              # Styled shopping cart table with actions
    ├── checkout/
    │   └── form-checkout.php     # Custom checkout form layout
    ├── loop/
    │   ├── no-products-found.php # Alert for empty query search/categories
    │   └── pagination.php        # Custom styled loop pagination
    └── single-product/
        ├── product-image.php     # Styled product gallery block
        ├── product-thumbnails.php # Custom product image thumbnail strip
        ├── related.php           # Related products carousel layout
        └── up-sells.php          # Product upsells container layout
```

---

## WooCommerce Templates

* **`woocommerce/archive-product.php`**: Wraps WooCommerce product listings inside Bootstrap containers, configures widgets sidebar, and inserts layout wrapper grids.
* **`woocommerce/content-product.php`**: Overrides loops to display products as modern Bootstrap 5 cards containing rating stars, badge tags, price points, and custom quick-view triggers.
* **`woocommerce/content-single-product.php`**: Tailors the structure of single product detail views, loading custom AJAX fields, FBT bundle selectors, up-sell carousels, and review layouts.
* **`woocommerce/single-product.php`**: Main layout container wrapping individual product information details.
* **`woocommerce/cart/cart.php`**: Styled cart page with Bootstrap table overrides, customized coupon forms, and an added AJAX-friendly "Clear Cart" utility button.
* **`woocommerce/cart/cart-totals.php`**: Replaces the styling of shipping and checkout total components using styled card lists.
* **`woocommerce/checkout/form-checkout.php`**: Adapts checkout process grids to styled inputs and responsive layouts.
* **`woocommerce/loop/no-products-found.php`**: Generates styled alert panels when search returns empty catalog queries.
* **`woocommerce/loop/pagination.php`**: Reformats standard catalog page loops as Bootstrap-aligned lists.
* **`woocommerce/single-product/product-image.php`**: Styled single product primary image layout and gallery bounds.
* **`woocommerce/single-product/product-thumbnails.php`**: Adjusts secondary image strip formatting.
* **`woocommerce/single-product/related.php`**: Overrides default loop layout grid structures to list matched products.
* **`woocommerce/single-product/up-sells.php`**: custom layout listing checkout suggestions.

---

## Template Parts

* **`template-parts/content/content-none.php`**: Layout wrapper displayed when search lists or post archives have no content.
* **`template-parts/content/content-page.php`**: Formats content displays inside standard static pages.
* **`template-parts/content/content-single.php`**: Formats the layout of single blog posts.
* **`template-parts/content/content.php`**: Formats post loop list cards inside index feeds.
* **`template-parts/footer/footer-widgets.php`**: Generates the 4-column widgets layout in the footer.
* **`template-parts/header/navigation.php`**: Builds the primary navigation header navbar enqueuing Bootstrap logo components and navwalkers.
* **`template-parts/header/topbar.php`**: Renders the top secondary ribbon containing social buttons, navigation items, and contact numbers.
* **`template-parts/sections/hero.php`**: Displays Customizer-defined hero title headers, CTA buttons, and stats fields.
* **`template-parts/sections/about.php`**: Displays homepage summary grids explaining who we are.
* **`template-parts/sections/services.php`**: Showcases company service catalog options.
* **`template-parts/sections/popular-products.php`**: Queries and displays top WooCommerce items on the homepage.
* **`template-parts/sections/features.php`**: Displays company feature lists with custom vector icons.
* **`template-parts/sections/portfolio.php`**: Renders visual grid items showcasing previous works.
* **`template-parts/sections/counter.php`**: Lists core company stats with numerical counters.
* **`template-parts/sections/testimonials.php`**: Builds slide blocks containing client testimonial statements.
* **`template-parts/sections/team.php`**: Profiles employee records in team layouts.
* **`template-parts/sections/pricing.php`**: Provides comparison pricing boxes for client tiers.
* **`template-parts/sections/faq.php`**: Groups dynamic frequently asked questions in accordion widgets.
* **`template-parts/sections/latest-blog.php`**: Shows index summary cards for the 3 most recent posts.
* **`template-parts/sections/newsletter.php`**: Generates inline newsletter registration cards.
* **`template-parts/sections/contact.php`**: Combines physical maps, phone metrics, and mail forms.

---

## Assets

* **CSS Files**:
  * `assets/css/bootstrap.min.css`: Local Bootstrap v5.3.3 core grid and layout framework.
  * `assets/css/style.css`: Theme-specific custom element styles.
  * `assets/css/woocommerce.css`: Shop override styles for product grids and catalog lists.
  * `assets/css/single-product.css`: Isolated single product details customization style.
* **JavaScript Files**:
  * `assets/js/bootstrap.bundle.min.js`: Local Bootstrap script bundle (includes Popper.js).
  * `assets/js/main.js`: Primary theme interactions.
  * `assets/js/woocommerce.js`: AJAX catalog scripts, search, and loop actions.
  * `assets/js/single-product.js`: AJAX handlers for single product zip checks and FBT bundles.
* **Images**:
  * *None* (assets/images directory is initialized and ready for custom branding).
* **Fonts**:
  * Standard system typography (Inter, Roboto, sans-serif) configured inside local Bootstrap stylesheets.
* **Icons**:
  * Bootstrap Icons (v1.11.3) conditionally loaded via public CDN.
  * Inline custom vector SVGs enqueued via helper function.

---

## Functions

* **`functions.php`**: Defines theme constants (`ROBO_THEME_VERSION`, `ROBO_THEME_DIR`, `ROBO_THEME_URI`) and loads required files from `inc/`.
* **`inc/setup.php`**:
  * `robo_setup()`: Registers support for custom-logo, custom-header, title-tag, post-thumbnails, editor-styles, etc.
  * `robo_content_width()`: Restricts max content bounds variables.
* **`inc/navwalker.php`**:
  * `Robo_WP_Bootstrap_Navwalker`: Extension class enabling dynamic WP menu generation styled as Bootstrap dropdown components.
* **`inc/helpers.php`**:
  * `robo_get_reading_time()`: Calculates word count to output reading times.
  * `robo_track_post_views()`: Custom counter registering pageview metas.
  * `robo_get_post_views()`: Returns formatted view count values.
  * `robo_custom_excerpt_length()`: Configures post excerpts to default to 25 words.
  * `robo_excerpt_more()`: Replaces post excerpt trails with "...".
  * `robo_get_svg()`: Renders raw inlined SVG markup for key icon assets.
  * `robo_date_format()`: Standardized date display helper.
* **`inc/enqueue.php`**:
  * `robo_scripts()`: Hooks theme styles and localizes params.
* **`inc/customizer.php`**:
  * `robo_customize_register()`: Declares Customizer settings sections (General, Colors, Hero, Socials) and fields.
  * `robo_customizer_css()`: Injects custom Customizer styles in site `<head>`.
* **`inc/widgets.php`**:
  * `robo_widgets_init()`: Declares Main Sidebar, Blog Sidebar, Shop Sidebar, and 4 Footer Widget Areas.
* **`inc/breadcrumbs.php`**:
  * `robo_breadcrumbs()`: Renders structured SEO breadcrumbs.
* **`inc/pagination.php`**:
  * `robo_pagination()`: Custom styled catalog loop pagination.
* **`inc/template-functions.php`**:
  * `robo_post_meta()`: Echoes meta details (author, date, views) for loop grids.
  * `robo_author_box()`: Renders bio blocks in single blog layouts.
  * `robo_related_posts()`: Queries related article cards.
* **`inc/woocommerce.php`**:
  * `robo_woocommerce_setup()`: Sets WooCommerce capabilities support.
  * `robo_dequeue_woocommerce_layout_styles()`: Disables baseline WooCommerce layouts to avoid conflicts.
  * `robo_woocommerce_wrapper_start()` / `robo_woocommerce_wrapper_end()`: Page layout wrappers.
  * `robo_woocommerce_add_to_cart_class()`: Class filters for Bootstrap buttons.
  * `robo_woocommerce_product_search_form()`: Customizes search bar.
  * `robo_woocommerce_get_badges()`: Renders sales, new, and featured badges.
  * `robo_woocommerce_get_rating_html()`: Returns star ratings.
  * `robo_woocommerce_quick_view_callback()`: AJAX handler building details modal views.
  * `robo_woocommerce_clear_cart_handler()`: Empty cart button hook.
  * `robo_add_buy_now_button_to_form()`: Renders Buy Now direct redirects.
  * `robo_ajax_add_bundle_to_cart()`: AJAX callback for bundle additions.

---

## Theme Setup

1. **Download**: Extract the theme package to a folder named `robo`.
2. **Upload**: Move the `robo` folder into your site's `/wp-content/themes/` directory.
3. **Activation**: Navigate to the WordPress Dashboard, open **Appearance > Themes**, find **Robo**, and click **Activate**.
4. **Navigation Menus**: Open **Appearance > Menus** to configure links and assign them to the registered locations (Primary, Footer, Topbar, Mobile, or Social Menu).
5. **Widget sidebars**: Go to **Appearance > Widgets** to place widgets in the sidebars (Main, Blog, Shop) and the four footer widget columns.
6. **Customizer Setup**: Visit **Appearance > Customize** to configure layouts, color accents, logos, and custom homepage hero content.

---

## Required Plugins

* **Required**:
  * *None* (functions as a standalone blog/portfolio theme out of the box).
* **Recommended**:
  * **[WooCommerce](https://wordpress.org/plugins/woocommerce/)** - Necessary to enable e-commerce templates, product loops, cart controls, and shipping modules.
* **Optional**:
  * **[Contact Form 7](https://wordpress.org/plugins/contact-form-7/)** or **[WPForms](https://wordpress.org/plugins/wpforms-lite/)** - For contact forms and newsletter templates.

---

## Customizer Options

* **General & Layout**:
  * Container Width (Standard Grid / Full Width Fluid).
  * Copyright text inputs.
* **Theme Colors**:
  * Primary Accent Color Picker (Defaults to `#0052FF`).
  * Header Background Color.
  * Footer Background Color.
* **Hero Section Settings**:
  * Background Image selector.
  * Main Hero Title & Subtitle.
  * Button 1 & Button 2 customization (Text and link URLs).
  * Statistics 1 to 4 Values and Labels.
* **Social Media Links**:
  * Facebook, Twitter/X, Instagram, LinkedIn, and YouTube profile URLs.

---

## Navigation Menus

* **Primary Menu** (`primary`): Header main navigation links.
* **Footer Menu** (`footer`): Links placed in footer columns.
* **Top Menu** (`topbar`): Secondary utility menu placed in topbar.
* **Mobile Menu** (`mobile`): Drawer navigation for mobile viewports.
* **Social Menu** (`social`): Icon menu for profile links.

---

## Widget Areas

* **Main Sidebar** (`main-sidebar`): Default sidebar displayed on static pages.
* **Blog Sidebar** (`blog-sidebar`): Displayed next to blog lists, archives, search, and single post templates.
* **Shop Sidebar** (`shop-sidebar`): Displayed next to WooCommerce product archives, loops, and listing views.
* **Footer Widget Columns** (`footer-widget-1` to `footer-widget-4`): Four widgetized columns in the footer.

---

## Performance Optimizations

* **Local Core Enqueues**: Bootstrap 5.3.3 framework assets enqueued locally, eliminating third-party DNS dependencies.
* **Baseline Style Cleanup**: Dequeued default WooCommerce styles to reduce bloated CSS overlaps.
* **Targeted Asset Loads**: Single product CSS and JS modules load conditionally only when viewing individual product templates.
* **Inlined vector icons**: Utilized direct SVG helpers in place of loading heavy external icon libraries.
* **Optimized queries**: Custom query results count restrictions applied on related posts lists.

---

## Security

* **Direct Execution Blocks**: Placed ABSPATH verification headers in all core templates to avoid outside PHP requests.
* **Output Escaping**: Wrapped all render variables inside WordPress VIP compliant functions (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`).
* **Input Sanitization**: Enabled sanitization callbacks (`sanitize_text_field`, `esc_url_raw`, `sanitize_hex_color`, `sanitize_key`) for Customizer values.
* **Nonces Validation**: Checked security nonces (`robo_woo_nonce` and `robo_single_product_nonce`) inside WooCommerce AJAX controllers (Quick View and FBT bundles).

---

## Coding Standards

* Conforms to the standard WordPress Coding Standards.
* Integrates sanitize and escaping rules correctly across templates.
* Extends WooCommerce layouts via hooks and templates rather than core modifications to guarantee update compatibility.

---

## Compatibility

* **WordPress Version**: 6.0+
* **WooCommerce Version**: 8.0+
* **PHP Version**: 8.0+
* **Bootstrap Version**: 5.3.3

---

## Changelog

### v1.0.0
* Initial release of the Robo theme.
* Local integration of the Bootstrap 5.3.3 styling engine.
* 14 dynamic homepage section templates.
* Integrated Customizer options panel and settings fields.
* WooCommerce overrides for custom quick views, cart adjustments, and direct "Buy Now" checkout buttons.

---

## Known Issues

* WooCommerce templates require the core WooCommerce plugin to be active; otherwise, checkout redirects, product grids, and AJAX scripts are bypassed.

---

## Credits

* Theme developed by **[Rambir Bhatiwal](https://rambir-bhatiwal.github.io/portfolio/)**.
* Built using **[Bootstrap](https://getbootstrap.com/)**.
* Integrated with **[WooCommerce](https://woocommerce.com/)**.
