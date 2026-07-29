# Robo Theme & Learning Resources CPT — Comprehensive Developer Guide & Technical Architecture

> **Single Source of Truth** for developers maintaining, extending, or debugging the **Robo** WordPress theme and the **Learning Resources** Custom Post Type engine.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Complete Folder Structure](#2-complete-folder-structure)
3. [Every File & Module](#3-every-file--module)
4. [Classes Reference](#4-classes-reference)
5. [Theme Customizer System](#5-theme-customizer-system)
6. [Custom Post Types & Taxonomies](#6-custom-post-types--taxonomies)
7. [Custom Admin Meta Boxes & Fields](#7-custom-admin-meta-boxes--fields)
8. [Templates & Layout System](#8-templates--layout-system)
9. [Template Parts & Components](#9-template-parts--components)
10. [Helper Functions Reference](#10-helper-functions-reference)
11. [WooCommerce Integration](#11-woocommerce-integration)
12. [Bootstrap 5 & Styling Architecture](#12-bootstrap-5--styling-architecture)
13. [JavaScript Modules & Handlers](#13-javascript-modules--handlers)
14. [AJAX Actions & Endpoints](#14-ajax-actions--endpoints)
15. [WordPress Hooks & Filters Registry](#15-wordpress-hooks--filters-registry)
16. [Database & Options Schema](#16-database--options-schema)
17. [Security & Sanitization Standards](#17-security--sanitization-standards)
18. [Performance & Optimization](#18-performance--optimization)
19. [How to Add New Features](#19-how-to-add-new-features)
20. [Debugging & Troubleshooting Guide](#20-debugging--troubleshooting-guide)
21. [Code Examples](#21-code-examples)
22. [Change Log](#22-change-log)
23. [Future Improvements](#23-future-improvements)

---

## 1. Project Overview

### What This Project Is
The **Robo** theme is a high-performance, responsive WordPress parent theme crafted specifically for robotics, engineering, electronics, and technical e-commerce platforms. It incorporates a completely native **Learning Resources** Custom Post Type engine built strictly with native WordPress APIs (no third-party plugins like ACF).

### Primary Objectives
- **Zero Heavy Plugins**: Build custom post types, tabbed admin meta boxes, repeaters, media pickers, and AJAX filtering using core WordPress APIs.
- **WooCommerce Synergy**: Seamlessly link hardware components/kits from WooCommerce store products directly to tutorials and technical schematics.
- **Enterprise Standards**: Follow WordPress Coding Standards (WPCS), strict escaping, input sanitization, nonces, and capability checks.
- **Modern Responsive Design**: Built on **Bootstrap 5.3** with dark/light themes, glassmorphism, responsive cards, and dynamic action buttons.

### Technical Stack & Compatibility Matrix
| Component | Supported Version / Technology |
| :--- | :--- |
| **Theme Name** | Robo |
| **Theme Slug** | `robo` |
| **Theme Version** | `1.0.1` |
| **PHP Version** | `7.4` to `8.3+` |
| **WordPress Core** | `6.0+` (Gutenberg & REST API enabled) |
| **WooCommerce** | `7.0+` to `9.0+` |
| **CSS Framework** | Bootstrap `5.3.3` |
| **Icon Libraries** | Bootstrap Icons `1.11.3` & WordPress Dashicons |
| **JavaScript Framework** | Vanilla JS ES6 + jQuery 3.x (WordPress Core jQuery) |

---

## 2. Complete Folder Structure

Below is the complete tree layout of the theme:

```text
robo/
├── 404.php                                   # 404 Error page template
├── README.md                                  # Theme introduction readme
├── DEVELOPER_GUIDE.md                         # (This File) Technical documentation
├── archive.php                                # Default post archive fallback
├── archive-learning-resource.php              # CPT Archive template with vertical cards & AJAX filters
├── author.php                                 # Author post archive template
├── category.php                               # Category archive template
├── comments.php                               # Standard comment list & form template
├── footer.php                                 # Site footer template (Widgets, Bottom Bar, Back-To-Top)
├── front-page.php                             # Homepage template loader
├── functions.php                              # Core theme initialization file
├── header.php                                 # Site head section and header wrapper
├── home.php                                   # Blog posts home template
├── index.php                                  # Main fallback template
├── page.php                                   # Default single page template
├── page-about-us.php                          # Custom About Us page template
├── page-contact-us.php                        # Custom Contact Us page template
├── search.php                                 # Main search results template
├── sidebar.php                                # Main widgetized sidebar template
├── single.php                                 # Default single post template
├── single-learning-resource.php               # CPT Single resource template with 17 ordered sections
├── style.css                                  # Main theme header stylesheet & overrides
├── tag.php                                    # Tag archive template
├── template-learning-resources.php            # Custom Page Template with horizontal cards & dynamic filters
│
├── assets/
│   ├── css/
│   │   ├── bootstrap.min.css                  # Bootstrap 5.3.3 framework styles
│   │   ├── learning-resources.css             # Frontend Learning Resources components & card styles
│   │   ├── learning-resources-admin.css       # Tabbed Admin Meta Box UI & repeater styles
│   │   ├── single-product.css                 # WooCommerce single product custom styles
│   │   ├── style.css                          # Custom design tokens & theme utilities
│   │   └── woocommerce.css                    # Custom WooCommerce design overrides
│   │
│   ├── js/
│   │   ├── bootstrap.bundle.min.js            # Bootstrap 5 JS bundle (Popper included)
│   │   ├── learning-resources.js              # Frontend AJAX filters, Likes, Favorites, Copy Link toasts
│   │   ├── learning-resources-admin.js        # Admin tab switching, media pickers, repeaters, WC AJAX search
│   │   ├── main.js                            # Theme main JS (Mobile menu, sticky header, back-to-top)
│   │   ├── single-product.js                  # WooCommerce product gallery & quantity controls
│   │   └── woocommerce.js                     # AJAX cart & fragment refresh handlers
│   │
│   └── images/                                # Theme static assets & default placeholders
│
├── inc/
│   ├── breadcrumbs.php                        # Breadcrumbs generator (`robo_breadcrumbs()`)
│   ├── customizer.php                         # Theme Customizer controls, sections, and sanitization
│   ├── enqueue.php                            # Frontend & admin script/style enqueuer
│   ├── helpers.php                            # Global helper functions (Company info, SVGs, views, reading time)
│   ├── navwalker.php                          # Custom Bootstrap 5 NavWalker (`Robo_Bootstrap_Navwalker`)
│   ├── pagination.php                         # Dynamic pagination helper (`robo_pagination()`)
│   ├── setup.php                              # Theme setup, features support, and WP.org HTTP update suppressor
│   ├── template-functions.php                 # Body classes, pingback headers, and HTML helpers
│   ├── widgets.php                            # Widget area registration
│   ├── woocommerce.php                        # WooCommerce integration hooks & template overrides
│   │
│   └── learning-resources/                    # Learning Resources CPT Dedicated Engine
│       ├── init.php                           # Module entry file & asset loader
│       ├── cpt-setup.php                      # CPT & Taxonomies registration (`Robo_Learning_Resources_CPT`)
│       ├── meta-boxes.php                     # 14 Tabbed Meta Box sections (`Robo_Learning_Resources_Meta_Boxes`)
│       ├── ajax-handlers.php                  # AJAX endpoints (`Robo_Learning_Resources_AJAX`)
│       └── helpers.php                        # Resource helpers (Views, Likes, Embeds, SEO Tags)
│
└── template-parts/
    ├── content/                               # Core post content sub-templates
    ├── footer/                                # Footer widget sub-templates
    ├── header/                                # Navigation bar & topbar components
    ├── sections/                              # Reusable homepage/about sections (Hero, CTA, Features, etc.)
    ├── content-learning-resource-card.php     # Vertical card template part
    └── content-learning-resource-horizontal-card.php # Horizontal card template part (5 dynamic action buttons)
```

---

## 3. Every File & Module

### Root Theme Files

#### `functions.php`
- **Purpose**: Theme bootstrapping file loaded by WordPress core on execution.
- **Responsibilities**: Defines constants (`ROBO_THEME_VERSION`, `ROBO_THEME_DIR`, `ROBO_THEME_URI`), requires all sub-modules inside `inc/`, and initializes the Learning Resources engine.
- **Dependencies**: Files in `inc/`.

#### `header.php`
- **Purpose**: Opens HTML structure, renders `<head>`, outputs `wp_head()`, opens `<body>`, and includes the navigation bar (`template-parts/header/navigation`).

#### `footer.php`
- **Purpose**: Closes main content wrapper, renders site footer (`#colophon`), footer widget columns, bottom copyright bar, back-to-top button, and calls `wp_footer()`.

#### `single-learning-resource.php`
- **Purpose**: Single template for `learning-resource` post type.
- **Responsibilities**: Renders 17 ordered sections (Hero, Breadcrumb, Featured Image, Title, Short Description, Main Content, Resource Snapshot, Learning Outcomes, Requirements, Embedded Videos, PDF Resources, GitHub Repos, Downloads, External Links, Related Products, FAQs, CTA, Next/Prev navigation, Related Resources).

#### `archive-learning-resource.php`
- **Purpose**: Post type archive for `learning-resource` (`/learning-resources/`).
- **Responsibilities**: Renders vertical resource cards in a Bootstrap 5 grid with AJAX filter controls.

#### `template-learning-resources.php`
- **Purpose**: Custom Page Template ("Learning Resources") for landing pages.
- **Responsibilities**: Renders a Hero banner, breadcrumb, `the_content()`, dynamic search & filter bar, horizontal resource cards ([content-learning-resource-horizontal-card.php](file:///home/cat/Public/wp/roboscaler/wp-content/themes/robo/template-parts/content-learning-resource-horizontal-card.php)), pagination, and CTA section.

---

## 4. Classes Reference

### 1. `Robo_Bootstrap_Navwalker`
- **Location**: `inc/navwalker.php`
- **Purpose**: Extends WordPress `Walker_Nav_Menu` to output valid Bootstrap 5 navbar dropdown markup (`nav-item`, `nav-link`, `dropdown-menu`, `dropdown-item`).

### 2. `Robo_Learning_Resources_CPT`
- **Location**: `inc/learning-resources/cpt-setup.php`
- **Purpose**: Registers CPT `learning-resource` and Taxonomies `learning_category` & `learning_tag`.
- **Methods**:
  - `register_post_type()`: Defines CPT capabilities, REST API support, rewrite rules (`with_front => false`).
  - `register_taxonomies()`: Registers hierarchical category taxonomy and non-hierarchical tag taxonomy.
  - `seed_default_terms()`: Populates initial terms (*Arduino, Robotics, STEM, AI, Beginner, Project, etc.*).
  - `maybe_flush_rewrite_rules()`: Executes a one-time database rewrite flush on version updates.

### 3. `Robo_Learning_Resources_Meta_Boxes`
- **Location**: `inc/learning-resources/meta-boxes.php`
- **Purpose**: Generates tabbed admin meta boxes with 14 sections and handles sanitization/saving.
- **Methods**:
  - `add_meta_boxes()`: Hooks `add_meta_box()`.
  - `render_main_meta_box( $post )`: Renders admin tabbed UI with native repeaters and media pickers.
  - `save_meta_boxes( $post_id, $post )`: Verifies nonces, capability checks, autosave status, and updates post meta keys.

### 4. `Robo_Learning_Resources_AJAX`
- **Location**: `inc/learning-resources/ajax-handlers.php`
- **Purpose**: Handles AJAX endpoints for both admin and frontend.
- **Methods**:
  - `search_wc_products()`: Admin product picker search.
  - `filter_archive()`: Live frontend card filtering and pagination.
  - `toggle_like()`: Toggles post like counter.
  - `toggle_favorite()`: Manages user bookmarks.
  - `download_file()`: Streams single files and tracks download counts.
  - `download_all_zip()`: Bundles resource PDFs, downloads, and attachments into a single `.zip` file using PHP `ZipArchive`.

---

## 5. Theme Customizer System

Located in `inc/customizer.php`, registered via `robo_customize_register()`.

### Customizer Panels & Sections
1. **Robo Header Options**: Topbar contact info, show/hide topbar, social links toggle.
2. **Robo Layout Settings**: Container width (`container` vs `container-fluid`).
3. **Robo Footer Options**: Copyright text, social icon toggles, footer columns grid.
4. **Company Information**: Address, phone, email, WhatsApp number, Instagram, YouTube links.

### Data Retrieval Helper
```php
$company_email = robo_get_company_info( 'email' );
$copyright     = get_theme_mod( 'robo_copyright_text', '© 2026 RoboScaler' );
```

---

## 6. Custom Post Types & Taxonomies

### Post Type: `learning-resource`
- **Slug**: `learning-resource`
- **Rewrite Slug**: `learning-resources` (`with_front => false`)
- **Menu Icon**: `dashicons-welcome-learn-more`
- **Supports**: `title`, `editor`, `thumbnail`, `excerpt`, `revisions`
- **REST API**: Enabled (`show_in_rest => true`)
- **Query Var**: `true`

### Taxonomy 1: `learning_category`
- **Hierarchical**: `true`
- **Slug**: `learning-category`
- **Default Terms**: Arduino, Robotics, Electronics, Programming, STEM, AI, PCB Design, IoT, Drones, Combat Robotics.

### Taxonomy 2: `learning_tag`
- **Hierarchical**: `false`
- **Slug**: `learning-tag`
- **Default Terms**: Beginner, Intermediate, Advanced, Workshop, Competition, Project.

---

## 7. Custom Admin Meta Boxes & Fields

All stored in `wp_postmeta` table prefixed with `_robo_lr_`:

| Section | Meta Field Key | Field Type | Purpose |
| :--- | :--- | :--- | :--- |
| **1. Basic Info** | `_robo_lr_short_desc` | Textarea | Concise summary for cards/hero |
| | `_robo_lr_difficulty` | Select | `beginner`, `intermediate`, `advanced` |
| | `_robo_lr_duration` | Text | e.g. "45 Minutes", "2 Hours" |
| | `_robo_lr_instructor` | Text | Instructor/Author name |
| | `_robo_lr_has_certificate` | Checkbox | `1` or `0` |
| **2. Media** | `_robo_lr_cover_image_id` | Media Attachment ID | High-res cover image |
| | `_robo_lr_list_image_id` | Media Attachment ID | Card thumbnail image |
| | `_robo_lr_gallery_image_ids`| Array of IDs | Sortable gallery images |
| **3. PDFs** | `_robo_lr_pdf_resources` | Repeater Array | Title, file_id, file_url, description |
| **4. Videos** | `_robo_lr_video_resources` | Repeater Array | Title, URL (YouTube/Vimeo/MP4) |
| **5. GitHub** | `_robo_lr_github_resources` | Repeater Array | Title, repo URL, description |
| **6. Downloads** | `_robo_lr_downloads` | Repeater Array | Title, file_id, file_url, description |
| **7. WooCommerce** | `_robo_lr_related_product_ids`| Array of Product IDs | Related store products |
| **8. External** | `_robo_lr_external_resources`| Repeater Array | Title, URL, Icon type, description |
| **9. Outcomes** | `_robo_lr_outcomes` | Repeater Array | Skill outcomes list |
| **10. Requirements**| `_robo_lr_requirements` | Repeater Array | Hardware/software requirements |
| **11. FAQs** | `_robo_lr_faqs` | Repeater Array | Question & Answer items |
| **12. SEO** | `_robo_lr_meta_title` | Text | Custom head meta title |
| | `_robo_lr_meta_description`| Textarea | Custom meta description |
| | `_robo_lr_og_image_id` | Media Attachment ID | Open Graph social share image |
| | `_robo_lr_canonical_url` | URL | Canonical URL link |
| **13. Attachments** | `_robo_lr_attachment_ids` | Array of IDs | Attached files/docs |
| **14. Badges** | `_robo_lr_badge_featured` | Checkbox | `1` or `0` |
| | `_robo_lr_badge_popular` | Checkbox | `1` or `0` |
| | `_robo_lr_badge_recommended`| Checkbox | `1` or `0` |
| | `_robo_lr_badge_new` | Checkbox | `1` or `0` |
| | `_robo_lr_badge_trending` | Checkbox | `1` or `0` |

---

## 8. Templates & Layout System

### Page Templates Summary
1. `single-learning-resource.php`: Single learning resource template.
2. `archive-learning-resource.php`: CPT post type archive template.
3. `template-learning-resources.php`: Landing page template with horizontal card layout.

---

## 9. Template Parts & Components

### `content-learning-resource-horizontal-card.php`
Renders horizontal cards with **5 Dynamic Action Buttons**:
1. **Learn More**: Always visible (`the_permalink()`).
2. **Watch Video**: First video URL / `#section-videos` anchor / dropdown. Hidden if empty.
3. **PDF**: PDF link / dropdown list. Hidden if empty.
4. **Source Code**: GitHub repo link / dropdown list. Hidden if empty.
5. **View Kit**: WooCommerce product link / dropdown list. Hidden if empty.

---

## 10. Helper Functions Reference

Located in `inc/learning-resources/helpers.php` & `inc/helpers.php`:

```php
// 1. Reading Time (in minutes)
$minutes = robo_lr_get_reading_time( $post_id );

// 2. Views Counter
robo_lr_increment_views( $post_id );
$views = robo_lr_get_views( $post_id );

// 3. Likes & Downloads Counter
$likes     = robo_lr_get_likes( $post_id );
$downloads = robo_lr_get_downloads( $post_id );

// 4. Badges Renderer
echo robo_lr_render_badges( $post_id );

// 5. Video Embed Helper
echo robo_lr_render_video_embed( 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' );

// 6. Social Share Buttons
echo robo_lr_render_social_share( $post_id );
```

---

## 11. WooCommerce Integration

Located in `inc/woocommerce.php`:
- Unhooks default WooCommerce wrappers that break Bootstrap layout grid (`woocommerce_output_content_wrapper`, `woocommerce_breadcrumb`, etc.).
- Enqueues `assets/css/woocommerce.css` & `assets/js/woocommerce.js`.
- Renders related WooCommerce product cards inside Learning Resource single pages and horizontal card action buttons.

---

## 12. Bootstrap 5 & Styling Architecture

Built on **Bootstrap 5.3.3**:
- Responsive grid containers (`container`, `row`, `col-lg-4`, `col-lg-8`, `row-cols-1`, etc.).
- Flexbox alignment (`d-flex`, `align-items-center`, `justify-content-between`, `gap-2`, `flex-wrap`).
- Utility classes (`rounded-4`, `shadow-sm`, `shadow-lg`, `bg-white`, `border-0`, `p-4`, `m-0`).

---

## 13. JavaScript Modules & Handlers

- `assets/js/learning-resources.js`: Frontend AJAX filtering, Likes toggle, Favorites toggle, Copy link buttons with toast notifications.
- `assets/js/learning-resources-admin.js`: Tab switching, `wp.media` uploader frames, jQuery UI sortable drag-and-drop repeaters, live WooCommerce product AJAX search.

---

## 14. AJAX Actions & Endpoints

| Action Name | Privileged / Guest | Purpose |
| :--- | :--- | :--- |
| `robo_lr_search_wc_products` | Admin only (`wp_ajax`) | Live product search in admin meta box |
| `robo_lr_filter_archive` | Public (`wp_ajax` & `nopriv`) | Live archive card filtering and pagination |
| `robo_lr_toggle_like` | Public (`wp_ajax` & `nopriv`) | Toggles resource like counter |
| `robo_lr_toggle_favorite` | Public (`wp_ajax` & `nopriv`) | Toggles user bookmarks |
| `robo_lr_download_file` | Public (`wp_ajax` & `nopriv`) | File download counter & redirect stream |
| `robo_lr_download_all_zip` | Public (`wp_ajax` & `nopriv`) | On-the-fly `.zip` archive generator |

---

## 15. WordPress Hooks & Filters Registry

### Actions Hooked
- `init`: Registers post types, taxonomies, and clear scheduled cron checks.
- `add_meta_boxes`: Adds `robo_lr_main_meta_box`.
- `save_post_learning-resource`: Saves all 14 meta box sections.
- `wp_head`: Injects SEO meta tags (`robo_lr_output_seo_meta_tags`).
- `wp_enqueue_scripts`: Enqueues Bootstrap and custom frontend assets.
- `admin_enqueue_scripts`: Enqueues admin tab & media uploader assets.

### Filters Hooked
- `pre_http_request`: Intercepts calls to `api.wordpress.org` to prevent server cURL warning messages (`robo_block_wordpress_org_http_requests`).
- `template_include`: Routes single/archive templates (`robo_lr_template_loader`).
- `document_title_parts`: Custom SEO document title override (`robo_lr_filter_wp_title`).

---

## 16. Database & Options Schema

- `wp_posts`: Contains posts with `post_type = 'learning-resource'`.
- `wp_postmeta`: Stored meta fields (`_robo_lr_short_desc`, `_robo_lr_difficulty`, `_robo_lr_pdf_resources`, etc.).
- `wp_term_taxonomy`: Taxonomies `learning_category` & `learning_tag`.
- `wp_options`: Option flag `robo_lr_default_terms_seeded` and `robo_lr_rewrite_flushed_v4`.

---

## 17. Security & Sanitization Standards

1. **Nonces**: Every form submission and AJAX request verifies a WP Nonce (`robo_lr_meta_box_nonce`, `robo_lr_admin_nonce`, `robo_lr_nonce`).
2. **Input Sanitization**:
   - `sanitize_text_field()` for string inputs.
   - `sanitize_textarea_field()` for multiline descriptions.
   - `esc_url_raw()` for URLs.
   - `absint()` for attachment IDs and numbers.
3. **Escaping Output**:
   - `esc_html()` for HTML text strings.
   - `esc_attr()` for input attributes.
   - `esc_url()` for links and image sources.
   - `wp_kses_post()` for sanitized rich text.
4. **Capability Checks**: Verifies `current_user_can('edit_post', $post_id)` before meta updates.

---

## 18. Performance & Optimization

- **Zero Heavy Plugins**: Native PHP execution minimizes memory overhead.
- **Lazy Loading**: `loading="lazy"` on all post thumbnails.
- **Efficient Database Queries**: Uses indexed meta keys and light `WP_Query` loops with explicit `posts_per_page`.

---

## 19. How to Add New Features

### How to Add a New Meta Box Section
1. Add tab `<li>` in `render_main_meta_box()` inside `inc/learning-resources/meta-boxes.php`.
2. Add corresponding field panel HTML markup inside `.robo-lr-tabs-content`.
3. Add sanitization & `update_post_meta()` logic in `save_meta_boxes()`.
4. Display field value in `single-learning-resource.php` or card template parts.

---

## 20. Debugging & Troubleshooting Guide

- **404 Error on Single Resource Page**:
  - Solution: Re-save Permalinks in **Settings → Permalinks** or clear option `robo_lr_rewrite_flushed_v4` to trigger automatic rewrite rule regeneration.
- **Media Picker Not Opening**:
  - Solution: Ensure `wp_enqueue_media()` is loaded via `admin_enqueue_scripts`.
- **WooCommerce Section Hidden**:
  - Explanation: Section 7 automatically hides itself on frontend if WooCommerce is deactivated or no products are selected.

---

## 21. Code Examples

### Querying Learning Resources in PHP
```php
$query = new WP_Query( array(
    'post_type'      => 'learning-resource',
    'posts_per_page' => 5,
    'tax_query'      => array(
        array(
            'taxonomy' => 'learning_category',
            'field'    => 'slug',
            'terms'    => 'robotics',
        ),
    ),
) );

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
        get_template_part( 'template-parts/content-learning-resource-horizontal-card' );
    }
    wp_reset_postdata();
}
```

---

## 22. Change Log

### Version 1.0.1
- Added **Learning Resources** Custom Post Type engine with 14 tabbed meta box sections.
- Created `template-learning-resources.php` with horizontal card layout and 5 dynamic action buttons (*Learn More, Watch Video, PDF, Source Code, View Kit*).
- Implemented ZIP file archive generator for resource files (`robo_lr_download_all_zip`).
- Added cURL warning interceptor for `api.wordpress.org`.

---

## 23. Future Improvements

- Add AJAX pagination to `template-learning-resources.php`.
- Add front-end user resource bookmark dashboard tab.
- Add REST API custom endpoints for headless WordPress consumption.
