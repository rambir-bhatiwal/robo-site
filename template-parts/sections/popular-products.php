<?php
/**
 * Popular Products Section
 *
 * @package Robo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$args = array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'meta_key'       => 'total_sales',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
?>

<section class="popular-products py-5">

	<div class="container">

		<div class="row justify-content-center text-center mb-5">

			<div class="col-lg-7">

				<span class="section-subtitle">
					Our Best Sellers
				</span>

				<h2 class="section-title">
					Popular Products
				</h2>

				<p class="section-description">
					Discover our most popular robotics products designed for students,
					hobbyists, educators and robotics competitions.
				</p>

			</div>

		</div>

		<div class="row g-4">

		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			global $product;

			if ( ! $product ) {
				continue;
			}

			$categories = get_the_terms( get_the_ID(), 'product_cat' );
		?>

			<div class="col-xl-4 col-lg-4 col-md-6">

				<div class="product-card">

					<div class="product-image">

						<?php if ( $product->is_on_sale() ) : ?>

							<span class="sale-badge">
								Sale
							</span>

						<?php endif; ?>

						<a href="<?php the_permalink(); ?>">

							<?php

							if ( has_post_thumbnail() ) {

								the_post_thumbnail(
									'woocommerce_thumbnail',
									array(
										'class' => 'img-fluid',
										'loading' => 'lazy',
									)
								);

							} else {

								echo wc_placeholder_img( 'woocommerce_thumbnail' );

							}

							?>

						</a>

					</div>

					<div class="product-body">

						<?php
						if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
						?>

							<div class="product-category">

								<span class="category-badge">

									<?php echo esc_html( $categories[0]->name ); ?>

								</span>

							</div>

						<?php endif; ?>

						<h4 class="product-title">

							<a href="<?php the_permalink(); ?>">

								<?php the_title(); ?>

							</a>

						</h4>

						<div class="product-rating">

							<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>

						</div>

						<div class="product-excerpt">

							<?php

							echo esc_html(
								wp_trim_words(
									get_the_excerpt(),
									12,
									'...'
								)
							);

							?>

						</div>

						<div class="product-price">

							<?php echo wp_kses_post( $product->get_price_html() ); ?>

						</div>

						<div class="product-actions">

							<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary rounded-pill w-100">

								View Product

							</a>

						</div>

					</div>

				</div>

			</div>

		<?php endwhile; ?>

		</div>

		<div class="text-center mt-5">

			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary btn-lg rounded-pill px-5">

				View All Products

			</a>

		</div>

	</div>

</section>


<style>
/*==================================================
    Robo Theme - Popular Products
==================================================*/

.popular-products{
    padding:90px 0;
    background:#f8fafc;
}

/*=========================
    Section Heading
=========================*/

.section-subtitle{
    display:inline-block;
    padding:8px 18px;
    border-radius:30px;
    background:#eef4ff;
    color:#2563eb;
    font-size:14px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:1px;
    margin-bottom:18px;
}

.section-title{
    font-size:42px;
    font-weight:700;
    color:#1e293b;
    margin-bottom:15px;
}

.section-description{
    max-width:650px;
    margin:auto;
    color:#64748b;
    line-height:1.8;
}

/*=========================
    Product Card
=========================*/

.product-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    transition:.35s ease;
    border:1px solid #edf2f7;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
    height:100%;
}

.product-card:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 50px rgba(15,23,42,.15);
}

/*=========================
    Product Image
=========================*/

.product-image{
    margin-top:16px;
    position:relative;
    height:260px;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#ffffff;
    padding:25px;
    overflow:hidden;
    border-bottom:1px solid #f1f5f9;
}

.product-image img{
    max-width:100%;
    max-height:100%;
    width:auto;
    height:auto;
    object-fit:contain;
    transition:.4s;
}

.product-card:hover .product-image img{
    transform:scale(1.08);
}

/*=========================
    Sale Badge
=========================*/

.sale-badge{
    position:absolute;
    top:18px;
    left:18px;
    background:#ef4444;
    color:#fff;
    padding:6px 12px;
    font-size:12px;
    font-weight:600;
    border-radius:30px;
    z-index:10;
}

/*=========================
    Card Body
=========================*/

.product-body{
    padding:28px;
}

/*=========================
    Category
=========================*/

.category-badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:30px;
    background:#eef4ff;
    color:#2563eb;
    font-size:12px;
    font-weight:600;
    margin-bottom:15px;
}

/*=========================
    Title
=========================*/

.product-title{
    font-size:24px;
    font-weight:700;
    margin-bottom:12px;
    line-height:1.4;
}

.product-title a{
    color:#1e293b;
    text-decoration:none;
    transition:.3s;
}

.product-title a:hover{
    color:#2563eb;
}

/*=========================
    Rating
=========================*/

.product-rating{
    margin-bottom:15px;
}

.product-rating .star-rating{
    margin:0;
}

/*=========================
    Description
=========================*/

.product-excerpt{
    color:#64748b;
    line-height:1.8;
    font-size:15px;
    height:80px;
    overflow:hidden;
    /* margin-bottom:25px; */
}

/*=========================
    Price
=========================*/

.product-price{
    font-size:20px;
    font-weight:700;
    color:#2563eb;
    margin-bottom:20px;
}

.product-price del{
    color:#94a3b8;
    font-size:18px;
    margin-right:8px;
}

.product-price ins{
    text-decoration:none;
}

/*=========================
    Button
=========================*/

.product-actions .btn{
    width:100%;
    border-radius:50px;
    padding:12px;
    font-weight:600;
    transition:.3s;
}

.product-actions .btn:hover{
    transform:translateY(-2px);
}

/*=========================
    Responsive
=========================*/

@media(max-width:991px){

.section-title{
    font-size:34px;
}

.product-image{
    height:230px;
}

}

@media(max-width:767px){

.popular-products{
    padding:70px 0;
}

.section-title{
    font-size:28px;
}

.product-image{
    height:200px;
}

.product-body{
    padding:22px;
}

.product-title{
    font-size:20px;
}

.product-price{
    font-size:26px;
}

}
</style>
<?php
wp_reset_postdata();

endif;