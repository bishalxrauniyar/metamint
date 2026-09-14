<?php
/**
 * Home page section blocks (server-rendered, arrange/remove in the Site Editor).
 * Content via SCF "Home Page" group with baked-in defaults.
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mm_register_block( string $name, string $title, callable $render ): void {
	$meta = get_template_directory() . '/blocks/' . $name . '/block.json';
	if ( ! file_exists( $meta ) ) {
		return;
	}
	register_block_type( $meta, [
		'render_callback' => $render,
	] );
}

add_action( 'init', function () {
	mm_register_block( 'home-hero', 'Home: Hero', 'mm_block_home_hero' );
	mm_register_block( 'home-marquee', 'Home: Marquee', 'mm_block_home_marquee' );
	mm_register_block( 'home-products', 'Home: Products', 'mm_block_home_products' );
	mm_register_block( 'home-features', 'Home: Features', 'mm_block_home_features' );
	mm_register_block( 'home-manifesto', 'Home: Manifesto', 'mm_block_home_manifesto' );
	mm_register_block( 'home-teamnote', 'Home: Team Note + Stats', 'mm_block_home_teamnote' );
	mm_register_block( 'home-testimonials', 'Home: Testimonials', 'mm_block_home_testimonials' );
	mm_register_block( 'home-cta', 'Home: CTA', 'mm_block_home_cta' );
} );

function mm_block_home_hero(): string {
	$hero_1   = mm_field( 'hero_line_1', 'Plugins with punch.' );
	$hero_2   = mm_field( 'hero_line_2', 'Software with soul.' );
	$hero_sub = mm_field( 'hero_sub', "We're Metamint — a tiny studio crafting mighty tools for WordPress and Shopify. Two products, zero fluff, all heart." );
	ob_start();
	?>
	<section class="mm-hero mm-dots" data-testid="home-hero">
		<div class="mm-orb mm-orb-teal" aria-hidden="true"></div>
		<div class="mm-orb mm-orb-coral" aria-hidden="true"></div>
		<div class="mm-wrap mm-hero-inner">
			<span class="mm-pill mm-pill-teal" data-testid="hero-badge-studio">Indie software studio — est. 2024</span>
			<h1 class="mm-display"><?php echo esc_html( $hero_1 ); ?><br><?php echo esc_html( $hero_2 ); ?></h1>
			<p class="mm-lede"><?php echo esc_html( $hero_sub ); ?></p>
			<div class="mm-btnrow">
				<a class="mm-btn mm-btn-ink" href="#products" data-testid="hero-explore-products-button">Meet the apps</a>
				<a class="mm-btn mm-btn-outline" href="<?php echo esc_url( home_url( '/about/' ) ); ?>" data-testid="hero-our-story-link">Our story</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_home_marquee(): string {
	$items = [ 'Built for speed', 'Zero bloat code', 'Intelligent agents', 'Rank #1 on Google', 'Optimized for Shopify', 'WordPress certified', 'Made by humans', '100% indie' ];
	ob_start();
	?>
	<div class="mm-marquee" data-testid="editorial-marquee" aria-hidden="true">
		<div class="mm-marquee-track">
			<?php for ( $r = 0; $r < 2; $r++ ) : ?>
				<?php foreach ( $items as $item ) : ?>
					<span class="mm-marquee-item"><?php echo esc_html( $item ); ?><i></i></span>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

function mm_block_home_products(): string {
	$products = [
		[
			'name' => 'Metamint Helpdesk', 'tag' => 'WordPress Plugin', 'accent' => '#0F7173', 'tid' => 'helpdesk',
			'desc' => 'Support, live chat and an AI agent that resolves tickets while you sleep. Built natively for WordPress.',
			'url'  => home_url( '/products/metamint-helpdesk/' ),
		],
		[
			'name' => 'Metamint SEO', 'tag' => 'Shopify App', 'accent' => '#F05D5E', 'tid' => 'seo',
			'desc' => 'A full SEO power-suite for Shopify: audits, meta magic, schema and rank tracking in one clean dashboard.',
			'url'  => home_url( '/products/metamint-seo/' ),
		],
	];
	ob_start();
	?>
	<section id="products" class="mm-section mm-wrap" data-testid="home-products">
		<p class="mm-eyebrow mm-teal">The lineup</p>
		<h2 class="mm-h2">Two apps. Infinite mischief.</h2>
		<p class="mm-lede mm-left">Each one built natively for its platform, polished until it disappears into your workflow.</p>
		<div class="mm-grid-2">
			<?php foreach ( $products as $p ) : ?>
				<article class="mm-card mm-product" data-testid="product-card-<?php echo esc_attr( $p['tid'] ); ?>">
					<div class="mm-product-body">
						<span class="mm-pill" style="background:<?php echo esc_attr( $p['accent'] ); ?>1a;color:<?php echo esc_attr( $p['accent'] ); ?>" data-testid="product-badge-<?php echo esc_attr( $p['tid'] ); ?>"><?php echo esc_html( $p['tag'] ); ?></span>
						<h3 class="mm-h3"><span class="mm-dot" style="background:<?php echo esc_attr( $p['accent'] ); ?>"></span><?php echo esc_html( $p['name'] ); ?></h3>
						<p class="mm-muted"><?php echo esc_html( $p['desc'] ); ?></p>
						<div class="mm-btnrow mm-left">
							<a class="mm-btn mm-btn-ink" href="<?php echo esc_url( mm_buy_url( $p['tid'], $p['tid'] === 'seo' ? 'https://apps.shopify.com/metamint-seo' : 'https://wordpress.org/plugins/metamint-helpdesk' ) ); ?>" data-testid="buy-<?php echo esc_attr( $p['tid'] ); ?>-button"><?php esc_html_e( 'Buy now', 'metamint' ); ?></a>
							<a class="mm-link" href="<?php echo esc_url( $p['url'] ); ?>" data-testid="explore-<?php echo esc_attr( $p['tid'] ); ?>-link">Explore →</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_home_features(): string {
	$features = [
		[ 'Fast by default', 'Lean code, zero jQuery bloat, sub-100ms footprint on your storefront.' ],
		[ 'AI where it helps', 'Agents draft, resolve and summarize — you keep the final word.' ],
		[ 'Native to your platform', 'Built inside WordPress and Shopify conventions, not bolted on.' ],
		[ 'Measurable results', 'Rank tracking, response times and resolution rates, always visible.' ],
		[ 'Private & secure', 'Your customer data stays yours. No resale, no shady telemetry.' ],
		[ 'Humans on support', 'Email us and the developers reply. Usually within the day.' ],
	];
	ob_start();
	?>
	<section class="mm-section mm-wrap" data-testid="home-features">
		<p class="mm-eyebrow mm-teal">Why Metamint</p>
		<h2 class="mm-h2">Everything you need. Nothing you don't.</h2>
		<div class="mm-grid-3">
			<?php foreach ( $features as $i => [ $t, $d ] ) : ?>
				<div class="mm-card mm-feature" data-testid="home-feature-<?php echo (int) $i + 1; ?>">
					<h3 class="mm-h4"><?php echo esc_html( $t ); ?></h3>
					<p class="mm-muted"><?php echo esc_html( $d ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_home_manifesto(): string {
	$chapters = [
		[ '01', 'Zero Bloat', 'Every kilobyte earns its place. Our plugins ship lean, load fast, and never hijack your admin panel with ads or nags.' ],
		[ '02', 'AI with a Human Heart', 'Smart agents that know when to help and when to hand off. Automation that feels like a great hire, not a robot wall.' ],
		[ '03', 'Indie & Proud', 'No VC roadmap, no growth hacks. When you email us, the people who wrote the code write back.' ],
		[ '04', 'Built to Last', 'WordPress and Shopify are our home turf. We track every core release so updates never break your store or site.' ],
	];
	ob_start();
	?>
	<section class="mm-section mm-wash" data-testid="home-manifesto">
		<div class="mm-wrap">
			<p class="mm-eyebrow mm-teal">The manifesto</p>
			<h2 class="mm-h2">Four rules we ship by</h2>
			<div class="mm-grid-2">
				<?php foreach ( $chapters as [ $n, $t, $d ] ) : ?>
					<article class="mm-card mm-chapter" data-testid="manifesto-chapter-<?php echo esc_attr( $n ); ?>">
						<span class="mm-chapter-n"><?php echo esc_html( $n ); ?></span>
						<h3 class="mm-h4"><?php echo esc_html( $t ); ?></h3>
						<p class="mm-muted"><?php echo esc_html( $d ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_home_teamnote(): string {
	$stats = [ [ '2', 'Products, crafted slowly' ], [ '1,200+', 'Stores & sites powered' ], [ '4.9 / 5', 'Average rating' ], [ '< 1 day', 'Median support reply' ] ];
	ob_start();
	?>
	<section class="mm-section mm-wash2" data-testid="team-note">
		<div class="mm-wrap mm-narrow mm-center">
			<p class="mm-eyebrow mm-teal">A note from the team</p>
			<blockquote class="mm-quote">
				"We started Metamint because the tools we needed didn't exist — or existed buried under ads, upsells and 40 settings pages. So we built the versions we wanted: quiet, fast, and genuinely helpful. If something ever feels off, our inbox is open and a developer will answer it."
			</blockquote>
			<p class="mm-sign"><b>The Metamint Team</b><span>Two developers, one support rota</span></p>
			<dl class="mm-stats-row">
				<?php foreach ( $stats as [ $v, $l ] ) : ?>
					<div><dt class="mm-sr"><?php echo esc_html( $l ); ?></dt><dd class="mm-stat-v"><?php echo esc_html( $v ); ?></dd><dd class="mm-stat-l"><?php echo esc_html( $l ); ?></dd></div>
				<?php endforeach; ?>
			</dl>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_home_testimonials(): string {
	$testimonials = mm_field( 'testimonials', [
		[ 'quote' => 'The AI agent clears 70% of our tickets before breakfast. I genuinely forgot what our support backlog looked like.', 'name' => 'Marta Kowalska', 'role' => 'Founder, Nordhaus Ceramics', 'product' => 'Metamint Helpdesk' ],
		[ 'quote' => 'We moved from a $400/month SEO agency to Metamint SEO. Rankings went up. Meetings went to zero.', 'name' => 'Devon Reyes', 'role' => 'E-commerce Lead, Fieldnotes Supply', 'product' => 'Metamint SEO' ],
		[ 'quote' => "It's the only WordPress support plugin that doesn't feel like it was designed in 2011. Our customers actually use the chat.", 'name' => 'Priya Nair', 'role' => 'Store Owner, Bloom & Loom', 'product' => 'Metamint Helpdesk' ],
		[ 'quote' => 'Installed at 9am, fixed 200 missing meta descriptions by lunch. The audit checklist alone is worth the price.', 'name' => 'Tom Beckett', 'role' => 'Marketer, Kettle & Oak', 'product' => 'Metamint SEO' ],
	] );
	ob_start();
	?>
	<section class="mm-section mm-wrap" data-testid="home-testimonials">
		<p class="mm-eyebrow mm-coral">Testimonials</p>
		<h2 class="mm-h2">Loved by shops that ship</h2>
		<div class="mm-grid-2">
			<?php foreach ( (array) $testimonials as $i => $t ) : ?>
				<figure class="mm-card mm-quote-card" data-testid="testimonial-<?php echo (int) $i + 1; ?>">
					<div class="mm-stars" aria-label="5 star review">★★★★★</div>
					<blockquote>"<?php echo esc_html( $t['quote'] ); ?>"</blockquote>
					<figcaption>
						<b><?php echo esc_html( $t['name'] ); ?></b>
						<span><?php echo esc_html( $t['role'] ); ?> · <?php echo esc_html( $t['product'] ); ?></span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_home_cta(): string {
	ob_start();
	?>
	<section class="mm-section mm-wrap" data-testid="home-cta">
		<div class="mm-cta-dark mm-dots">
			<div class="mm-orb mm-orb-teal" aria-hidden="true"></div>
			<h2>Ready to mint something <em>great?</em></h2>
			<p>Grab a plugin, say hello, or just poke around. The door is always open.</p>
			<a class="mm-btn mm-btn-light" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" data-testid="cta-contact-button">Talk to us</a>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
