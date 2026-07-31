# CHANGE IMPLEMENTATION GUIDE

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Folder Structure](#2-folder-structure)
3. [Theme Architecture](#3-theme-architecture)
4. [Learning Resource System (Robo LMS)](#4-learning-resource-system-robo-lms)
5. [Custom Post Types](#5-custom-post-types)
6. [Meta Fields](#6-meta-fields)
7. [Relationship Fields](#7-relationship-fields)
8. [Frontend Templates](#8-frontend-templates)
9. [Backend Logic](#9-backend-logic)
10. [WooCommerce Integration](#10-woocommerce-integration)
11. [Helper Functions](#11-helper-functions)
12. [404 Issue Analysis](#12-404-issue-analysis)
13. [Bug Fix History](#13-bug-fix-history)
14. [Hooks & Filters](#14-hooks--filters)
15. [Security](#15-security)
16. [Performance](#16-performance)
17. [Troubleshooting](#17-troubleshooting)
18. [Change Log](#18-change-log)
19. [Future Improvements](#19-future-improvements)

---

## 1. Project Overview

### Purpose
The **RoboScaler Theme (`robo`)** is a custom WordPress theme engineered specifically for robotics education, hardware development, e-commerce, and technical resource delivery. Beyond traditional blog and shop capabilities, the theme includes a custom-built **Robo LMS (Learning Management System)** architecture that manages technical documentation (PDFs), firmware/software repositories (Source Code), and video courses/tutorials.

### Core Technology Stack
- **Theme Name**: `robo` (RoboScaler Theme)
- **Programming Language**: PHP 7.4+ / PHP 8.x (uses strict types, PSR-4 autoloading, type-hinted methods, null coalescing operators)
- **WordPress Version**: 6.0+
- **WooCommerce Version**: 8.0+
- **CSS Framework**: Bootstrap 5.3+ (`assets/css/bootstrap.min.css`)
- **JavaScript Stack**: jQuery 3.6+, jQuery UI Sortable (admin repeaters), Bootstrap 5 Bundle (`assets/js/bootstrap.bundle.min.js`)
- **Iconography**: WordPress Dashicons & FontAwesome

---

## 2. Folder Structure

```text
wp-content/themes/robo/
├── 404.php                           # Fallback 404 Error Page
├── README.md                         # Theme Documentation Summary
├── CHANGE_IMPLEMENTATION_GUIDE.md    # Complete Developer Implementation Guide
├── archive-learning-code.php         # Archive Template for Source Code CPT
├── archive-learning-pdf.php          # Archive Template for PDF Resources CPT
├── archive-learning-video.php        # Archive Template for Learning Videos CPT
├── archive.php                       # Standard Blog Archive Template
├── author.php                        # Author Archive Template
├── category.php                      # Category Archive Template
├── comments.php                      # Comments Template
├── footer.php                        # Global Footer Template
├── front-page.php                    # Homepage Template
├── functions.php                     # Core Theme Bootstrap & Extension Loader
├── header.php                        # Global Header Template
├── home.php                          # Blog Index Template
├── index.php                         # Fallback Main Index Template
├── page-about-us.php                 # About Us Custom Page Template
├── page-contact-us.php               # Contact Us Custom Page Template
├── page.php                          # Default Static Page Template
├── search.php                        # Search Results Template
├── sidebar.php                       # Global Sidebar Template
├── single-learning-code.php          # Single Post Template for Source Code CPT
├── single-learning-pdf.php           # Single Post Template for PDF CPT
├── single-learning-video.php         # Single Post Template for Video CPT
├── single.php                        # Standard Blog Single Post Template
├── style.css                         # Main Theme Stylesheet & Header Info
├── tag.php                           # Tag Archive Template
├── assets/
│   ├── css/
│   │   ├── bootstrap.min.css         # Bootstrap 5 Framework Styles
│   │   ├── lms-admin.css             # Robo LMS Admin & Repeater Styles
│   │   ├── lms-frontend.css          # Robo LMS Frontend & Card Styles
│   │   ├── single-product.css        # WooCommerce Single Product Styles
│   │   ├── style.css                 # Custom Theme Component Styles
│   │   └── woocommerce.css           # WooCommerce Compatibility Overrides
│   ├── js/
│   │   ├── bootstrap.bundle.min.js   # Bootstrap JavaScript Components
│   │   ├── lms-admin.js              # Admin Tabs, Repeaters & Media Uploader JS
│   │   ├── lms-frontend.js           # AJAX Archive Filter & Pagination JS
│   │   ├── main.js                   # Main Theme Frontend Script
│   │   ├── single-product.js         # Single Product Gallery JS
│   │   └── woocommerce.js            # WooCommerce UI Adjustments
│   └── images/                       # Theme Graphics & Placeholder Media
├── inc/
│   ├── breadcrumbs.php               # Breadcrumb Generator
│   ├── customizer.php                # WP Live Customizer Panels
│   ├── enqueue.php                   # Theme Asset Enqueue Callbacks
│   ├── helpers.php                   # General Theme Utility Functions
│   ├── navwalker.php                 # Bootstrap 5 NavWalker for WP Menus
│   ├── pagination.php                # Custom Bootstrap 5 Pagination Function (`robo_pagination`)
│   ├── setup.php                     # Theme Supports & Activation Hooks (`after_switch_theme`)
│   ├── template-functions.php        # Template Tag Helpers
│   ├── widgets.php                   # Widget Areas Registration
│   ├── woocommerce.php               # WooCommerce Hooks & Overrides
│   └── lms/                          # Robo LMS Framework (Object-Oriented)
│       ├── Init.php                  # Singleton Entry Point & PSR-4 Autoloader
│       ├── Helper.php                # Utility Functions (URL Parsing, Sanitization, MIME Types)
│       ├── Admin/
│       │   ├── Ajax.php              # Admin Relationship Search & Frontend AJAX Filter Handlers
│       │   ├── MetaBox.php           # Admin Tabbed Meta Box & Repeater Renderer
│       │   └── SaveHandler.php       # Meta Box Data Sanitization & `save_post` Listener
│       ├── CPT/
│       │   ├── AbstractCPT.php       # Abstract Base CPT Registration Handler
│       │   ├── LearningCode.php      # `learning-code` CPT Registration
│       │   ├── LearningPdf.php       # `learning-pdf` CPT Registration
│       │   └── LearningVideo.php     # `learning-video` CPT Registration
│       ├── Frontend/
│       │   ├── Query.php             # Archive WP_Query Modifier & Parameter Builder
│       │   ├── Render.php            # Frontend HTML Component Renderer
│       │   └── TemplateLoader.php    # `template_include` Filter & Asset Loader
│       └── Taxonomies/
│           └── LearningTaxonomies.php# `learning-category` & `learning-tag` Taxonomies
├── page-templates/                   # Custom Page Layout Templates
├── template-parts/                   # Reusable UI Partials (Header, Footer, Sections)
└── woocommerce/                      # WooCommerce Template Overrides
```

---

## 3. Theme Architecture

The Robo theme combines standard WordPress template hierarchy with an object-oriented modular framework (`Robo\LMS`) located inside `inc/lms/`.

```
                        +----------------------------+
                        |       functions.php        |
                        +--------------+-------------+
                                       |
                                       v
                        +----------------------------+
                        |      \Robo\LMS\Init        |
                        +--------------+-------------+
                                       |
         +-----------------------------+-----------------------------+
         |                             |                             |
         v                             v                             v
+------------------+         +-------------------+         +-------------------+
|  Init CPTs       |         | Init Taxonomies   |         | Init Admin/Front  |
+--------+---------+         +---------+---------+         +---------+---------+
         |                             |                             |
         v                             v                             v
  AbstractCPT                  LearningTaxonomies             MetaBox / Save
  ├── LearningPdf              ├── learning-category          TemplateLoader
  ├── LearningCode             └── learning-tag               Query / Render
  └── LearningVideo
```

### Architecture Key Principles
1. **Singleton Initialization**: `\Robo\LMS\Init::get_instance()` manages component registration without global variable pollution.
2. **PSR-4 Autoloading**: Defined in `Init::register_autoloader()`, mapping `Robo\LMS\*` namespace directly to file paths under `inc/lms/`.
3. **Abstraction Base Classes**: `AbstractCPT` standardizes label generation, supports, capability mapping, archive configuration, and rewrite rules for all custom post types.
4. **Decoupled Frontend Rendering**: `Render.php` handles all HTML card, hero, and gallery output, separating template routing logic from presentation markup.

---

## 4. Learning Resource System (Robo LMS)

The **Robo LMS** system provides a structured catalog of technical assets:
- **PDF Documentation**: Datasheets, user manuals, schematics, and lab guides.
- **Source Code**: Firmware repositories (Arduino, C/C++, Python) and downloadable ZIP archives.
- **Learning Videos**: Embedded YouTube, Vimeo, or self-hosted MP4 tutorial courses.

### Core LMS Components
- `Init.php`: Main class triggering PSR-4 autoloader and registering components on `after_setup_theme`.
- `Helper.php`: Utility suite for string parsing, repository detection, repeater sanitization, and video embedding.
- `Taxonomies/LearningTaxonomies.php`: Registers shared `learning-category` (hierarchical) and `learning-tag` (non-hierarchical) taxonomies across all LMS CPTs.

---

## 5. Custom Post Types

The system registers three primary custom post types using `AbstractCPT.php`.

### A. Learning PDF (`learning-pdf`)
- **Purpose**: Technical documentation, PDF manuals, hardware schematics.
- **Slug**: `learning-pdf`
- **Supports**: `title`, `editor`, `thumbnail`, `excerpt`, `revisions`, `author`
- **Rewrite**: `array('slug' => 'learning-pdf', 'with_front' => false)`
- **Archive**: `has_archive => true` (URL: `/learning-pdf/`)
- **Single Template**: `single-learning-pdf.php`
- **Archive Template**: `archive-learning-pdf.php`
- **Admin UI Icon**: `dashicons-media-document`

### B. Learning Source Code (`learning-code`)
- **Purpose**: Code repositories, firmware packages, software examples.
- **Slug**: `learning-code`
- **Supports**: `title`, `editor`, `thumbnail`, `excerpt`, `revisions`, `author`
- **Rewrite**: `array('slug' => 'learning-code', 'with_front' => false)`
- **Archive**: `has_archive => true` (URL: `/learning-code/`)
- **Single Template**: `single-learning-code.php`
- **Archive Template**: `archive-learning-code.php`
- **Admin UI Icon**: `dashicons-editor-code`

### C. Learning Video (`learning-video`)
- **Purpose**: Video courses, project demonstrations, video tutorials.
- **Slug**: `learning-video`
- **Supports**: `title`, `editor`, `thumbnail`, `excerpt`, `revisions`, `author`
- **Rewrite**: `array('slug' => 'learning-video', 'with_front' => false)`
- **Archive**: `has_archive => true` (URL: `/learning-video/`)
- **Single Template**: `single-learning-video.php`
- **Archive Template**: `archive-learning-video.php`
- **Admin UI Icon**: `dashicons-video-alt3`

---

## 6. Meta Fields

Meta fields are managed via `MetaBox.php` and saved using `SaveHandler.php`. All keys use the `_robo_lms_` prefix to prevent collision with other plugins.

### General Meta Fields (Shared Across All 3 CPTs)

| Field Name | Meta Key | Field Type | Sanitization Method | Purpose / Usage |
| :--- | :--- | :--- | :--- | :--- |
| **Short Description** | `_robo_lms_short_description` | Textarea | `sanitize_textarea_field` | Brief summary shown on cards and hero headers. |
| **Difficulty Level** | `_robo_lms_difficulty` | Select | `sanitize_key` | Options: `beginner`, `intermediate`, `advanced`. |
| **Estimated Duration** | `_robo_lms_estimated_duration` | Text Input | `sanitize_text_field` | Duration string (e.g. `2 Hours`, `45 Mins`). |
| **Custom Thumbnail** | `_robo_lms_thumbnail_id` | Hidden (Media) | `absint` | Attachment ID for card thumbnail display. |
| **Custom Banner** | `_robo_lms_banner_id` | Hidden (Media) | `absint` | Attachment ID for single page hero header background. |
| **Featured Badge** | `_robo_lms_is_featured` | Checkbox | Condition (`'1'` or `'0'`) | Displays a "Featured" badge on cards. |
| **Recommended Badge**| `_robo_lms_is_recommended` | Checkbox | Condition (`'1'` or `'0'`) | Displays a "Recommended" badge on cards. |

### Repeater Meta Fields

#### 1. PDF Resources Repeater (`_robo_lms_pdf_resources`)
Stored as a serialized array of items. Each item contains:
- `title` *(string)*: Resource title.
- `description` *(string)*: Short item description.
- `file_id` *(int)*: Attachment ID of uploaded PDF.
- `file_url` *(string)*: Direct URL of uploaded PDF file.
- `preview_id` *(int)*: Attachment ID of preview cover image.
- `preview_url` *(string)*: Direct URL of preview image (display only).
- `button_text` *(string)*: Custom button text (default: "Download PDF").
- `order` *(int)*: Sort order index.

#### 2. Code Resources Repeater (`_robo_lms_code_resources`)
- `title` *(string)*: Code module title.
- `description` *(string)*: Description of firmware/code.
- `repo_url` *(string)*: External repository URL (GitHub, GitLab, Bitbucket).
- `file_id` *(int)*: Attachment ID of ZIP/RAR archive.
- `file_url` *(string)*: Direct URL of ZIP/RAR archive.
- `preview_id` *(int)*: Attachment ID of preview cover image.
- `preview_url` *(string)*: Direct URL of preview image.
- `language` *(string)*: Programming language key (`arduino`, `c`, `cpp`, `python`, `java`, `javascript`, `php`, `other`).
- `order` *(int)*: Sort order index.

#### 3. Video Resources Repeater (`_robo_lms_video_resources`)
- `title` *(string)*: Video lesson title.
- `description` *(string)*: Video overview/notes.
- `video_url` *(string)*: Video URL (YouTube embed, Vimeo, or MP4).
- `thumbnail_id` *(int)*: Attachment ID of video poster frame.
- `thumbnail_url` *(string)*: Direct URL of thumbnail image.
- `duration` *(string)*: Video length string (e.g. `15:30`).
- `order` *(int)*: Sort order index.

---

## 7. Relationship Fields

The LMS supports bidirectional-ready relationship mapping between learning resources and WooCommerce products.

### Relationship Keys

| Meta Key | Target Post Type | Storage Format |
| :--- | :--- | :--- |
| `_robo_lms_related_pdfs` | `learning-pdf` | Array of integer Post IDs |
| `_robo_lms_related_code` | `learning-code` | Array of integer Post IDs |
| `_robo_lms_related_videos` | `learning-video` | Array of integer Post IDs |
| `_robo_lms_related_products`| `product` | Array of integer Post IDs (WooCommerce) |

### Loading and Sanitization
1. **Sanitization**: All relationship inputs pass through `Helper::sanitize_post_ids()`, which strips non-numeric characters, removes duplicates, and converts values to `absint`.
2. **Rendering**: On single pages, `Render::related_resources($post_id)` executes queries for each relationship array and renders responsive product and CPT card grids.
3. **WooCommerce Integration**: `Render::render_related_products_grid()` verifies WooCommerce is active, retrieves `WC_Product` objects via `wc_get_product()`, checks product visibility via `$prod->is_visible()`, and displays product cards linked strictly to product permalinks (`get_permalink($product_id)`).

---

## 8. Frontend Templates

Frontend rendering relies on dedicated templates located in the theme root and modular rendering callbacks in `Render.php`.

### Template Summary

| Template File | Purpose | Main Data Query | Primary Helper Methods |
| :--- | :--- | :--- | :--- |
| `single-learning-pdf.php` | Single post view for PDFs | Single `WP_Query` | `Render::single_hero()`, `Render::resource_gallery()`, `Render::related_resources()` |
| `single-learning-code.php` | Single post view for Code | Single `WP_Query` | `Render::single_hero()`, `Render::resource_gallery()`, `Render::related_resources()` |
| `single-learning-video.php` | Single post view for Videos | Single `WP_Query` | `Render::single_hero()`, `Render::resource_gallery()`, `Render::related_resources()` |
| `archive-learning-pdf.php` | Archive listing for PDFs | Main Archive Query | `Render::filter_bar()`, `Render::archive_card()`, `robo_pagination()` |
| `archive-learning-code.php` | Archive listing for Code | Main Archive Query | `Render::filter_bar()`, `Render::archive_card()`, `robo_pagination()` |
| `archive-learning-video.php` | Archive listing for Videos | Main Archive Query | `Render::filter_bar()`, `Render::archive_card()`, `robo_pagination()` |

---

## 9. Backend Logic

### Admin Meta Box Architecture
Registered in `MetaBox::add_meta_boxes()` for all three LMS CPTs.
- **Tabbed Interface**: JavaScript tab navigation (`General Details`, `Resource Repeater`, `Related Resources`).
- **Dynamic Repeaters**: Uses HTML5 `<template>` tags (`.robo-lms-row-template`) and JavaScript row cloners to allow adding, duplicating, reordering, and deleting resource items dynamically.
- **Media Frame Selector**: Integrates `wp.media()` to handle image, PDF, and archive uploads directly from the WordPress Media Library.

### Save Handler Logic (`SaveHandler.php`)
When a post is saved:
1. **Nonce Verification**: Verifies `robo_lms_meta_nonce` against `robo_lms_save_meta`.
2. **Autosave Guard**: Exits if `DOING_AUTOSAVE` is active.
3. **Post Type Validation**: Ensures `post_type` is an allowed LMS CPT.
4. **User Capability Check**: Validates `current_user_can('edit_post', $post_id)`.
5. **Data Processing**: Sanitizes input fields and stores clean values in `wp_postmeta`.

---

## 10. WooCommerce Integration

The theme seamlessly integrates LMS learning content with WooCommerce product offerings:
- **Product Cross-Selling**: Custom field `_robo_lms_related_products` lets instructors attach robotics hardware kits directly to learning resources.
- **Safe Linking**: `Render::render_related_products_grid()` ensures that image cards and action buttons link exclusively to WooCommerce product permalinks (`get_permalink($product_id)`), preventing accidental links to raw media uploads.

---

## 11. Helper Functions

Located in `inc/lms/Helper.php`:

### `get_difficulty_options(): array`
Returns translatable array of difficulty levels (`beginner`, `intermediate`, `advanced`).

### `get_language_options(): array`
Returns translatable array of programming languages (`arduino`, `c`, `cpp`, `python`, `java`, `javascript`, `php`, `other`).

### `parse_video_url( string $url ): array`
Parses a video URL string and extracts provider (`youtube`, `vimeo`, `self_hosted`), video ID, and formatted embed URL.

### `render_video_embed( string $url, string $title = '' ): string`
Generates responsive Bootstrap 16:9 ratio wrapper containing an `<iframe>` (for YouTube/Vimeo) or a `<video>` HTML5 tag (for MP4 files).

### `parse_repo_url( string $url ): array`
Detects code repository provider (`github`, `gitlab`, `bitbucket`, `repository`) and returns styling badges and Dashicons.

### `render_repo_button( string $url ): string`
Renders an external link button with appropriate repository provider badge.

### `sanitize_repeater_data( array $input, string $cpt_slug ): array`
Sanitizes repeater input arrays based on the specific CPT schema and sorts rows by their `order` index using `usort()`.

### `sanitize_post_ids( $input ): array`
Normalizes comma-separated string inputs or raw arrays into unique, non-zero positive integer arrays (`absint`).

### `add_mime_types( array $mimes ): array`
Filter callback on `upload_mimes` allowing `.zip`, `.rar`, `.pdf`, and `.mp4` file uploads in WordPress.

---

## 12. 404 Issue Analysis

### 1. Root Cause
The `404 Not Found` error previously encountered on CPT single and archive pages was caused by missing CPT registrations on `init` and missing matching rewrite rules in WordPress's database (`wp_options` -> `rewrite_rules`).

### 2. Files Involved
- `functions.php`
- `inc/setup.php`
- `inc/lms/Init.php`
- `inc/lms/CPT/AbstractCPT.php`
- `inc/lms/Frontend/TemplateLoader.php`

### 3. Problematic Code
Previously, custom post types were either unregistered during standard initialization or lacked explicit rewrite slug definitions (`with_front => false`). Furthermore, theme switch hooks had not been established to register rewrite rules into WordPress's database cache.

### 4. How WordPress Routing Works
When a request comes in (e.g. `/learning-pdf/sample-pdf/`):
1. WordPress matches the request URI against the array of regex rules in `rewrite_rules`.
2. If matched, it populates `WP_Query` query variables (`post_type=learning-pdf`, `name=sample-pdf`).
3. If no matching rule is found, `WP_Query` sets `is_404 = true` and loads `404.php`.

### 5. How Rewrite Rules Work
Rewrite rules translate pretty permalinks into internal WordPress database queries:
`^learning-pdf/([^/]+)/?$` -> `index.php?learning-pdf=$matches[1]`

### 6. Why CPT Returned a 404
Because the CPT rewrite rules were not present in the database, WordPress attempted to parse `/learning-pdf/` as a static page or post category slug. Finding no matching page, it returned a 404 response.

### 7. Changes Made to Fix It
- Updated `AbstractCPT.php` to register CPTs on `init` with `'public' => true`, `'publicly_queryable' => true`, `'has_archive' => true`, `'query_var' => true`, and `'rewrite' => array('slug' => $this->slug, 'with_front' => false)`.
- Updated `functions.php` to instantiate `\Robo\LMS\Init::get_instance()`.
- Added `robo_rewrite_flush()` in `inc/setup.php` attached to `after_switch_theme`.

### 8. Rewrite Rule Flush Status
Rewrite rules were flushed cleanly via `flush_rewrite_rules()` attached **exclusively to `after_switch_theme`**. They are **not** flushed on every page load.

### 9. Code Comparison

**Before (`inc/setup.php`):**
```php
function robo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'robo_content_width', 1140 );
}
add_action( 'after_setup_theme', 'robo_content_width', 0 );
```

**After (`inc/setup.php`):**
```php
function robo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'robo_content_width', 1140 );
}
add_action( 'after_setup_theme', 'robo_content_width', 0 );

/**
 * Flush rewrite rules on theme activation.
 */
function robo_rewrite_flush() {
	if ( class_exists( '\Robo\LMS\Init' ) ) {
		\Robo\LMS\Init::get_instance()->init_components();
	}
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'robo_rewrite_flush' );
```

### 10. Verification
- Verified `/learning-pdf/`, `/learning-code/`, and `/learning-video/` return HTTP 200 responses for both archive indexes and single posts.
- Confirmed `is_404` evaluates to `false`.

---

## 13. Bug Fix History

### Bug Fix 1: 404 Routing on LMS CPTs
- **Problem**: Accessing custom post type URLs produced a 404 error.
- **Root Cause**: CPT rewrite rules were not registered in WordPress's database cache.
- **Solution**: Standardized CPT registration parameters in `AbstractCPT.php` and flushed rewrite rules on `after_switch_theme`.

### Bug Fix 2: PDF Download vs Image URL Resolution
- **Problem**: PDF download buttons were occasionally taking users to image preview URLs instead of the uploaded document.
- **Root Cause**: In `Render::pdf_resources_section()`, file URL fallback logic did not distinguish between preview image IDs and document attachment IDs.
- **Solution**: Added strict MIME type checking (`application/pdf`) and extension verification in `Render.php` to ensure download links point exclusively to valid document URLs.

### Bug Fix 3: AJAX Archive Filter Pagination Sync
- **Problem**: Submitting the archive filter bar reset the page HTML but broke standard pagination links.
- **Root Cause**: Pagination links navigated to standard URLs instead of triggering AJAX requests.
- **Solution**: Bound AJAX click handlers to `#robo-lms-archive-pagination a.page-link` in `lms-frontend.js`, dynamically passing the target page index to `wp_ajax_robo_lms_filter_archive`.

---

## 14. Hooks & Filters

### Custom Action Hooks Used
- `after_setup_theme`: Initializes LMS components (`Init::init_components()`).
- `after_switch_theme`: Flushes rewrite rules (`robo_rewrite_flush()`).
- `add_meta_boxes`: Registers LMS admin meta box (`MetaBox::add_meta_boxes()`).
- `save_post`: Processes and sanitizes meta box inputs (`SaveHandler::save_post_meta()`).
- `wp_ajax_robo_lms_search_posts`: Admin AJAX endpoint for searching posts in relationship fields.
- `wp_ajax_robo_lms_filter_archive` / `wp_ajax_nopriv_robo_lms_filter_archive`: Public AJAX endpoint for filtering LMS archive grids.
- `pre_get_posts`: Modifies main query on archive pages (`Query::modify_archive_query()`).

### Custom Filter Hooks Used
- `template_include`: Dynamically maps single and archive CPT requests to theme templates (`TemplateLoader::load_cpt_template()`).
- `upload_mimes`: Adds support for `.pdf`, `.zip`, `.rar`, and `.mp4` file uploads (`Helper::add_mime_types()`).

---

## 15. Security

1. **Data Escaping**: All dynamic outputs are escaped using contextual WordPress functions (`esc_html`, `esc_attr`, `esc_url`, `esc_textarea`).
2. **Input Sanitization**: All user inputs are sanitized before storage (`sanitize_text_field`, `sanitize_textarea_field`, `sanitize_key`, `absint`, `esc_url_raw`).
3. **Nonce Verification**: Form submissions and AJAX requests verify nonces via `wp_verify_nonce()` and `check_ajax_referer()`.
4. **Capability Checks**: Admin actions verify user permissions (`current_user_can('edit_post', $post_id)`).
5. **MIME Type Validation**: Restricts media uploads to safe extensions.

---

## 16. Performance

1. **Targeted Asset Loading**: Admin and frontend LMS scripts are enqueued exclusively on LMS-related screens (`MetaBox::enqueue_admin_assets()` & `TemplateLoader::enqueue_frontend_assets()`).
2. **Selective Query Execution**: Custom queries utilize `posts_per_page`, `no_found_rows` (where applicable), and indexed meta queries.
3. **One-Time Rewrite Flushes**: Flushes rewrite rules only on theme activation (`after_switch_theme`), avoiding overhead during regular page loads.
4. **Lazy Loading**: Images use native browser lazy loading (`loading="lazy"`).

---

## 17. Troubleshooting

| Symptom | Possible Cause | Diagnosis | Fix |
| :--- | :--- | :--- | :--- |
| **404 Error on CPT URL** | Rewrite rules not flushed or CPT unregistered. | Check Settings -> Permalinks or log `$wp_query->is_404`. | Visit **Settings -> Permalinks** and click **Save Changes** to flush rules. |
| **Meta fields not saving** | Nonce failure, autosave intervention, or missing user caps. | Inspect browser network tab on post save for missing nonce. | Verify `robo_lms_meta_nonce` field presence and user capabilities. |
| **Relationship dropdown empty** | Target CPT has no published items. | Check if posts of target post type exist in Published status. | Publish at least one item of the target post type. |
| **PDF Download opens image** | Incorrect URL stored in repeater row. | Check `_robo_lms_pdf_resources` array values in `wp_postmeta`. | Re-upload PDF using the PDF uploader button in the metabox. |
| **AJAX Archive Filter stuck** | JavaScript error or missing AJAX nonce. | Open browser developer console and inspect AJAX response. | Verify `roboLMSParams.nonce` and ensure jQuery is loaded. |

---

## 18. Change Log

### Version 1.0.0
- **Files Changed**: Entire `inc/lms/` directory, CPT templates (`single-learning-*.php`, `archive-learning-*.php`), asset stylesheets, and javascript modules.
- **Summary**: Initial release of the Robo LMS Learning Resource System.
- **Reason**: Implement technical documentation, code repository management, and video course delivery inside the RoboScaler theme.

---

## 19. Future Improvements

1. **REST API Endpoint Customization**: Expose repeater metadata directly in standard WordPress REST API responses for mobile app integration.
2. **User Progress Tracking**: Implement user state tracking to mark video lessons or PDF guides as "Completed".
3. **Transient Caching**: Cache relationship queries and complex archive filter responses using WordPress Transients API (`set_transient`).
