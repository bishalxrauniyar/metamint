<?php
/**
 * Product page section blocks (server-rendered, arrange/remove in the Site Editor).
 * Content via SCF "Product Page" group with baked-in defaults; buy buttons resolve
 * through mm_buy_url() (SCF override → WooCommerce straight-to-checkout → marketplace fallback).
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	mm_register_block( 'product-hero', 'Product: Hero', 'mm_block_product_hero' );
	mm_register_block( 'product-features', 'Product: Feature Matrix', 'mm_block_product_features' );
	mm_register_block( 'product-steps', 'Product: How It Works', 'mm_block_product_steps' );
	mm_register_block( 'product-demo', 'Product: Live Demo', 'mm_block_product_demo' );
	mm_register_block( 'product-pricing', 'Product: Pricing', 'mm_block_product_pricing' );
	mm_register_block( 'product-faq', 'Product: FAQ', 'mm_block_product_faq' );
} );

function mm_product_key(): string {
	$key = mm_field( 'product_key', '' );
	if ( ! in_array( $key, [ 'helpdesk', 'seo' ], true ) ) {
		$key = get_post_field( 'post_name' ) === 'metamint-seo' ? 'seo' : 'helpdesk';
	}
	return $key;
}

function mm_product_defaults(): array {
	return [
		'helpdesk' => [
			'name' => 'Metamint Helpdesk', 'hl' => 'Helpdesk', 'accent' => '#0F7173',
			'badge' => 'WordPress Plugin', 'buy' => 'https://wordpress.org/plugins/metamint-helpdesk', 'buy_l' => 'Get it on WordPress.org',
			'desc' => 'Support, live chat and an AI agent in one native WordPress plugin. Your customers get instant answers; you get your evenings back.',
			'features_title' => 'Your new favorite coworker',
			'how_title' => 'Live in three steps',
			'features' => [
				[ 'AI Agent on Duty', 'Resolves common questions instantly using your own docs and past replies.' ],
				[ 'Live Chat + Tickets', 'One inbox for chat, email and contact forms. Nothing slips through.' ],
				[ 'Native to WordPress', 'Installs in a minute, styled by your theme, zero external dashboards.' ],
				[ 'Human Handoff', 'The AI knows its limits — tricky threads land softly in your queue.' ],
			],
			'steps' => [
				[ 'Install in a minute', 'Plugins → Add New → Metamint Helpdesk → Activate. The widget inherits your theme automatically.' ],
				[ 'Train your agent', 'Point it at your docs, product pages and past replies. It learns your voice, not a generic script.' ],
				[ 'Watch tickets vanish', 'The AI resolves the routine 70% on the spot and hands the rest to you with full context.' ],
			],
			'plans' => [
				[ 'label' => 'Single Site', 'price' => 49, 'tagline' => 'For one WordPress site', 'popular' => 0, 'features' => "AI agent + live chat\nUnlimited conversations\nEmail ticketing\n1 year of updates" ],
				[ 'label' => '5 Sites', 'price' => 99, 'tagline' => 'For growing portfolios', 'popular' => 1, 'features' => "Everything in Single Site\nUp to 5 WordPress sites\nWooCommerce order lookups\nPriority support" ],
				[ 'label' => 'Unlimited', 'price' => 149, 'tagline' => 'For agencies & builders', 'popular' => 0, 'features' => "Everything in 5 Sites\nUnlimited sites\nWhite-label widget\nRoadmap voting rights" ],
			],
			'faqs' => [
				[ 'q' => 'How long does installation take?', 'a' => 'About a minute. Install from the WordPress plugin directory, activate, and the chat widget appears on your site styled by your theme.' ],
				[ 'q' => 'What does the AI agent train on?', 'a' => 'Your own content: docs, product pages, FAQs and past ticket replies you approve. Nothing is shared with other customers.' ],
				[ 'q' => 'Does it work with WooCommerce?', 'a' => "Yes. Customers can ask 'where is my order?' in chat, and agents see full order history inline — including a one-click refund flow." ],
				[ 'q' => "What happens when the AI doesn't know an answer?", 'a' => 'It says so honestly and hands the conversation to a human with the full transcript and a suggested reply.' ],
				[ 'q' => 'Can I get a refund?', 'a' => 'Every license comes with a 30-day, no-questions-asked money-back guarantee.' ],
			],
			'demo' => 'chat',
		],
		'seo' => [
			'name' => 'Metamint SEO', 'hl' => 'SEO', 'accent' => '#F05D5E',
			'badge' => 'Shopify App', 'buy' => 'https://apps.shopify.com/metamint-seo', 'buy_l' => 'Get it on Shopify App Store',
			'desc' => 'The SEO power-suite Shopify stores deserve. Audit, optimize and outrank — without hiring an agency.',
			'features_title' => 'Rank like you mean it',
			'how_title' => 'Rank higher in three steps',
			'features' => [
				[ 'One-Click Audits', 'Scan every product, collection and page. Get a fix list, not a lecture.' ],
				[ 'Meta & Schema Magic', 'Titles, descriptions and rich-result JSON-LD generated for your whole catalog.' ],
				[ 'Keyword Engine', 'Track rankings and spot the searches your competitors are sleeping on.' ],
				[ 'Speed Guardian', 'Core Web Vitals monitoring with Shopify-specific fixes baked in.' ],
			],
			'steps' => [
				[ 'Run your first audit', 'One click scans every product, collection and page. You get a prioritized fix list in minutes.' ],
				[ 'Apply one-click fixes', 'Meta tags, schema, alt texts and speed wins — approve each fix or bulk-apply the whole list.' ],
				[ 'Track your climb', 'The Keyword Engine watches your rankings daily and celebrates every position you gain.' ],
			],
			'plans' => [
				[ 'label' => 'Basic', 'price' => 29, 'tagline' => 'For new stores', 'popular' => 0, 'features' => "One-click store audits\nMeta titles & descriptions\nJSON-LD schema\n1 year of updates" ],
				[ 'label' => 'Pro', 'price' => 59, 'tagline' => 'For scaling brands', 'popular' => 1, 'features' => "Everything in Basic\nKeyword Engine (500 keywords)\nCore Web Vitals monitoring\nPriority support" ],
				[ 'label' => 'Agency', 'price' => 119, 'tagline' => 'For many stores', 'popular' => 0, 'features' => "Everything in Pro\nUp to 10 stores\nBulk fixes across catalogs\nRoadmap voting rights" ],
			],
			'faqs' => [
				[ 'q' => 'Will it work with my Shopify theme?', 'a' => 'Yes. Metamint SEO uses Shopify app embeds, so it works with every Online Store 2.0 theme — no code edits, and it uninstalls cleanly.' ],
				[ 'q' => 'How fast will I see results?', 'a' => 'Technical fixes (meta, schema, speed) apply immediately. Ranking improvements typically show within 4–8 weeks as Google recrawls your store.' ],
				[ 'q' => 'Does it slow my store down?', 'a' => 'No. The app does its work server-side; the storefront footprint is under 50ms and Core Web Vitals-safe.' ],
				[ 'q' => 'How many keywords can I track?', 'a' => 'The Pro plan tracks 500 keywords with daily updates; Agency tracks 2,000 across up to 10 stores.' ],
				[ 'q' => 'Can I cancel anytime?', 'a' => 'Yes. Licenses are yearly with no lock-in — cancel anytime and keep using the app until the year ends.' ],
			],
			'demo' => 'score',
		],
	];
}

function mm_product_data(): array {
	$key      = mm_product_key();
	$d        = mm_product_defaults()[ $key ];
	$features = mm_field( 'features', [] );
	$steps    = mm_field( 'steps', [] );
	$plans    = mm_field( 'plans', [] );
	$faqs     = mm_field( 'faqs', [] );

	return [
		'key'      => $key,
		'd'        => $d,
		'badge'    => mm_field( 'hero_badge', $d['badge'] ),
		'desc'     => mm_field( 'hero_desc', $d['desc'] ),
		'buy_url'  => mm_buy_url( $key, $d['buy'] ),
		'buy_l'    => mm_field( 'buy_label', mm_wc_product_id( $key ) ? 'Add to cart' : $d['buy_l'] ),
		'hero_img' => mm_field( 'hero_image', '' ),
		'features' => $features ? array_map( fn( $r ) => [ $r['title'], $r['desc'] ], $features ) : $d['features'],
		'steps'    => $steps ? array_map( fn( $r ) => [ $r['title'], $r['desc'] ], $steps ) : $d['steps'],
		'plans'    => $plans ? array_map( fn( $r ) => [ 'label' => $r['label'], 'price' => (int) $r['price'], 'tagline' => $r['tagline'], 'popular' => (int) $r['popular'], 'features' => $r['features'] ], $plans ) : $d['plans'],
		'faqs'     => $faqs ? array_map( fn( $r ) => [ 'q' => $r['q'], 'a' => $r['a'] ], $faqs ) : $d['faqs'],
	];
}

/**
 * Buy button URL/attributes: when a WooCommerce product exists the button adds
 * it to the cart (fallback links straight to checkout?add-to-cart), otherwise it
 * opens the marketplace page. An SCF "Marketplace URL" override always wins.
 */
function mm_buy_attrs( array $p ): string {
	$pid = mm_wc_product_id( $p['key'] );
	if ( $pid ) {
		$checkout  = wc_get_checkout_url();
		$cart      = wc_get_cart_url();
		$add_to_cart = add_query_arg( 'add-to-cart', $pid, wc_get_cart_url() );
		return sprintf(
			'data-mm-add-to-cart="%d" data-mm-checkout-url="%s" data-mm-cart-url="%s" href="%s"',
			(int) $pid,
			esc_url( $checkout ),
			esc_url( $cart ),
			esc_url( $add_to_cart )
		);
	}
	return 'href="' . esc_url( $p['buy_url'] ) . '" target="_blank" rel="noreferrer"';
}

function mm_block_product_hero(): string {
	$p = mm_product_data();
	ob_start();
	?>
	<section class="mm-hero mm-hero-product" data-testid="<?php echo esc_attr( $p['key'] ); ?>-page" style="--mm-accent:<?php echo esc_attr( $p['d']['accent'] ); ?>">
		<div class="mm-orb" style="background:<?php echo esc_attr( $p['d']['accent'] ); ?>1f" aria-hidden="true"></div>
		<div class="mm-wrap mm-hero-product-grid">
			<div>
				<span class="mm-pill" style="background:<?php echo esc_attr( $p['d']['accent'] ); ?>1a;color:<?php echo esc_attr( $p['d']['accent'] ); ?>" data-testid="<?php echo esc_attr( $p['key'] ); ?>-hero-badge"><?php echo esc_html( $p['badge'] ); ?></span>
				<h1 class="mm-display mm-left">Metamint <span style="color:var(--mm-accent)"><?php echo esc_html( $p['d']['hl'] ); ?></span></h1>
				<p class="mm-lede mm-left"><?php echo esc_html( $p['desc'] ); ?></p>
				<div class="mm-btnrow mm-left">
					<a class="mm-btn" style="background:var(--mm-accent);color:#fff" <?php echo mm_buy_attrs( $p ); // phpcs:ignore ?> data-testid="buy-<?php echo esc_attr( $p['key'] ); ?>-button"><?php echo esc_html( $p['buy_l'] ); ?></a>
					<button class="mm-btn mm-btn-outline" data-mm-checkout data-mm-product="<?php echo esc_attr( $p['key'] ); ?>" data-testid="mock-checkout-<?php echo esc_attr( $p['key'] ); ?>-button" type="button">Demo checkout</button>
				</div>
			</div>
			<?php if ( $p['hero_img'] ) : ?>
				<img class="mm-hero-img" src="<?php echo esc_url( $p['hero_img'] ); ?>" alt="<?php echo esc_attr( $p['d']['name'] ); ?> preview">
			<?php endif; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_product_features(): string {
	$p = mm_product_data();
	ob_start();
	?>
	<section class="mm-section mm-wrap" style="--mm-accent:<?php echo esc_attr( $p['d']['accent'] ); ?>">
		<p class="mm-eyebrow" style="color:var(--mm-accent)">Feature matrix</p>
		<h2 class="mm-h2"><?php echo esc_html( $p['d']['features_title'] ); ?></h2>
		<div class="mm-grid-2">
			<?php foreach ( $p['features'] as $i => [ $t, $fd ] ) : ?>
				<div class="mm-card mm-feature" data-testid="<?php echo esc_attr( $p['key'] ); ?>-feature-0<?php echo (int) $i + 1; ?>">
					<span class="mm-chapter-n" style="color:var(--mm-accent)">0<?php echo (int) $i + 1; ?></span>
					<h3 class="mm-h4"><?php echo esc_html( $t ); ?></h3>
					<p class="mm-muted"><?php echo esc_html( $fd ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_product_steps(): string {
	$p = mm_product_data();
	ob_start();
	?>
	<section class="mm-section mm-wrap" style="--mm-accent:<?php echo esc_attr( $p['d']['accent'] ); ?>">
		<p class="mm-eyebrow" style="color:var(--mm-accent)">How it works</p>
		<h2 class="mm-h2"><?php echo esc_html( $p['d']['how_title'] ); ?></h2>
		<div class="mm-grid-3" data-testid="<?php echo esc_attr( $p['key'] ); ?>-how-it-works">
			<?php foreach ( $p['steps'] as $i => [ $t, $sd ] ) : ?>
				<div class="mm-card mm-step" data-testid="<?php echo esc_attr( $p['key'] ); ?>-step-<?php echo (int) $i + 1; ?>">
					<span class="mm-step-n" style="background:var(--mm-accent)"><?php echo (int) $i + 1; ?></span>
					<h3 class="mm-h4"><?php echo esc_html( $t ); ?></h3>
					<p class="mm-muted"><?php echo esc_html( $sd ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_product_demo(): string {
	$p = mm_product_data();
	ob_start();
	?>
	<section class="mm-section mm-wash" style="--mm-accent:<?php echo esc_attr( $p['d']['accent'] ); ?>">
		<div class="mm-wrap mm-narrow mm-center">
			<span class="mm-pill" style="background:<?php echo esc_attr( $p['d']['accent'] ); ?>1a;color:<?php echo esc_attr( $p['d']['accent'] ); ?>" data-testid="<?php echo esc_attr( $p['key'] ); ?>-demo-badge">Live demo</span>
			<?php if ( $p['d']['demo'] === 'chat' ) : ?>
				<h2 class="mm-h2">Take the AI agent for a spin</h2>
				<div class="mm-chat" data-mm-chat data-testid="helpdesk-chat-simulator">
					<div class="mm-chat-head"><i></i><i></i><i></i><span>Metamint Agent — online</span></div>
					<div class="mm-chat-log" data-mm-chat-log>
						<div class="mm-bubble mm-bubble-bot">Hey! I'm the Metamint AI agent. Ask me anything about your store — refunds, pricing, setup…</div>
					</div>
					<div class="mm-chat-bar">
						<input type="text" placeholder="Ask about refunds, pricing, setup…" data-mm-chat-input data-testid="chat-input">
						<button type="button" style="background:var(--mm-accent)" data-mm-chat-send data-testid="chat-send-button">Send</button>
					</div>
				</div>
			<?php else : ?>
				<h2 class="mm-h2">Instant SEO score inspector</h2>
				<div class="mm-card mm-score" data-mm-score data-testid="seo-score-simulator">
					<div class="mm-score-inputs">
						<input type="text" placeholder="myshop.com/products/cool-mug" data-mm-score-url data-testid="seo-url-input">
						<input type="text" placeholder="target keyword" data-mm-score-kw data-testid="seo-keyword-input">
					</div>
					<button type="button" class="mm-btn" style="background:var(--mm-accent);color:#fff;width:100%" data-mm-score-run data-testid="seo-audit-button">Run audit</button>
					<div class="mm-score-result" data-mm-score-result hidden>
						<div class="mm-score-num" data-mm-score-num data-testid="seo-score-value">0</div>
						<div class="mm-score-track"><div class="mm-score-fill" data-mm-score-fill></div></div>
						<ul class="mm-score-checks" data-mm-score-checks></ul>
						<p class="mm-fineprint">Demo result — the real app audits your entire store</p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_product_pricing(): string {
	$p = mm_product_data();
	ob_start();
	?>
	<section id="pricing" class="mm-section mm-wrap" data-testid="<?php echo esc_attr( $p['key'] ); ?>-pricing" style="--mm-accent:<?php echo esc_attr( $p['d']['accent'] ); ?>">
		<p class="mm-eyebrow mm-center" style="color:var(--mm-accent)">Pricing</p>
		<h2 class="mm-h2 mm-center">Simple, yearly, honest</h2>
		<p class="mm-lede">No monthly drip. No per-seat surprises. Cancel anytime, keep the plugin forever.</p>
		<div class="mm-grid-3">
			<?php foreach ( $p['plans'] as $i => $plan ) : ?>
				<?php $pair = ( 0 === $i ) ? mm_price_pair( $p['key'], (int) $plan['price'] ) : null; ?>
				<div class="mm-card mm-plan <?php echo $plan['popular'] ? 'mm-plan-popular' : ''; ?>" data-testid="pricing-plan-<?php echo esc_attr( $p['key'] ); ?>-<?php echo (int) $i; ?>" <?php echo $plan['popular'] ? 'style="border-color:var(--mm-accent)"' : ''; ?>>
					<?php if ( $plan['popular'] ) : ?><span class="mm-plan-flag" style="background:var(--mm-accent)">Most popular</span><?php endif; ?>
					<h3 class="mm-h4"><?php echo esc_html( $plan['label'] ); ?></h3>
					<p class="mm-muted mm-sm"><?php echo esc_html( $plan['tagline'] ); ?></p>
					<?php if ( $pair && $pair['discounted'] !== '' ) : ?>
						<div class="mm-price-sale">
							<p class="mm-price"><span class="mm-price-current"><?php echo $pair['discounted']; // phpcs:ignore ?></span><span class="mm-price-suffix"> / year</span></p>
							<p class="mm-price-meta">
								<s class="mm-price-old"><?php echo $pair['actual']; // phpcs:ignore ?></s>
								<?php if ( $pair['save'] ) : ?><span class="mm-price-save">Save <?php echo (int) $pair['save']; ?>%</span><?php endif; ?>
							</p>
						</div>
					<?php else : ?>
						<p class="mm-price"><span class="mm-price-current">$<?php echo (int) $plan['price']; ?></span><span class="mm-price-suffix"> / year</span></p>
					<?php endif; ?>
					<ul class="mm-checklist">
						<?php foreach ( array_filter( array_map( 'trim', explode( "\n", (string) $plan['features'] ) ) ) as $f ) : ?>
							<li><?php echo esc_html( $f ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a class="mm-btn <?php echo $plan['popular'] ? '' : 'mm-btn-outline'; ?> mm-btn-block" <?php echo $plan['popular'] ? 'style="background:var(--mm-accent);color:#fff"' : ''; ?> <?php echo mm_buy_attrs( $p ); // phpcs:ignore ?> data-testid="pricing-buy-<?php echo esc_attr( $p['key'] ); ?>-<?php echo (int) $i; ?>"><?php echo esc_html( $p['buy_l'] ); ?></a>
					<button class="mm-plan-demo" type="button" data-mm-checkout data-mm-product="<?php echo esc_attr( $p['key'] ); ?>" data-testid="pricing-demo-<?php echo esc_attr( $p['key'] ); ?>-<?php echo (int) $i; ?>">Try demo checkout</button>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function mm_block_product_faq(): string {
	$p = mm_product_data();
	ob_start();
	?>
	<section class="mm-section mm-wash" style="--mm-accent:<?php echo esc_attr( $p['d']['accent'] ); ?>">
		<div class="mm-wrap mm-narrow">
			<p class="mm-eyebrow mm-center" style="color:var(--mm-accent)">FAQ</p>
			<h2 class="mm-h2 mm-center">Asked, answered</h2>
			<div class="mm-faq" data-mm-faq data-testid="<?php echo esc_attr( $p['key'] ); ?>-faq">
				<?php foreach ( $p['faqs'] as $i => $f ) : ?>
					<div class="mm-faq-item">
						<button class="mm-faq-q" type="button" data-testid="<?php echo esc_attr( $p['key'] ); ?>-faq-question-<?php echo (int) $i; ?>">
							<?php echo esc_html( $f['q'] ); ?><span class="mm-faq-icon" aria-hidden="true"></span>
						</button>
						<div class="mm-faq-a" data-testid="<?php echo esc_attr( $p['key'] ); ?>-faq-answer-<?php echo (int) $i; ?>" hidden>
							<p><?php echo esc_html( $f['a'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
