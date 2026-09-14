<?php
/**
 * Page-level blocks: About, Contact, Journal archive.
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	mm_register_block( 'about-page', 'About Page (full)', 'mm_block_about_page' );
	mm_register_block( 'contact-page', 'Contact Page (full)', 'mm_block_contact_page' );
	mm_register_block( 'journal-archive', 'Journal Archive (full)', 'mm_block_journal_archive' );
} );

function mm_block_about_page(): string {
	$timeline = [
		[ '2024', 'Metamint is born out of one too many bloated plugins. We start building the tools we wanted to buy.' ],
		[ '2025', 'Metamint Helpdesk ships for WordPress. First hundred customers, first all-hands support weekend, first five-star streak.' ],
		[ '2026', 'Metamint SEO lands on the Shopify App Store. Two products, one promise: software with soul.' ],
	];
	ob_start();
	?>
	<main data-testid="about-page">
		<section class="mm-hero mm-dots">
			<div class="mm-orb mm-orb-teal" aria-hidden="true"></div>
			<div class="mm-wrap mm-hero-inner">
				<span class="mm-pill mm-pill-tan" data-testid="about-hero-badge">The studio</span>
				<h1 class="mm-display">Small studio,<br><span class="mm-teal-text">mighty</span> plugins.</h1>
				<p class="mm-lede">Metamint Apps is an independent software studio. We make tools for the platforms half the internet runs on — WordPress and Shopify — and we make them the old-fashioned way: carefully, honestly, and with a slightly unhealthy obsession over the details.</p>
			</div>
		</section>
		<section class="mm-section mm-wash">
			<div class="mm-wrap mm-narrow">
				<h2 class="mm-h2">The story so far</h2>
				<div class="mm-stack">
					<?php foreach ( $timeline as [ $y, $t ] ) : ?>
						<div class="mm-card mm-timeline" data-testid="timeline-<?php echo esc_attr( $y ); ?>">
							<span class="mm-timeline-y"><?php echo esc_html( $y ); ?></span>
							<p class="mm-muted"><?php echo esc_html( $t ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php echo mm_block_home_manifesto(); // Reuse the shared manifesto section. ?>
		<section class="mm-section mm-wrap">
			<div class="mm-cta-dark mm-dots">
				<div class="mm-orb mm-orb-teal" aria-hidden="true"></div>
				<h2>Like how we think? <em>Say hi.</em></h2>
				<a class="mm-btn mm-btn-light" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" data-testid="about-contact-button">Get in touch</a>
			</div>
		</section>
	</main>
	<?php
	return ob_get_clean();
}

function mm_block_contact_page(): string {
	$sent      = isset( $_GET['sent'] ) ? sanitize_key( wp_unslash( $_GET['sent'] ) ) : '';
	$interests = [ 'Metamint Helpdesk', 'Metamint SEO', 'Something else' ];
	ob_start();
	?>
	<main data-testid="contact-page">
		<section class="mm-section mm-wrap">
			<span class="mm-pill mm-pill-coral" data-testid="contact-hero-badge">Say hello</span>
			<h1 class="mm-display mm-left">Talk to a<br><span class="mm-teal-text">real human.</span></h1>
			<div class="mm-contact-grid">
				<div class="mm-card mm-contact-card">
					<h2 class="mm-h4">Drop us a line</h2>
					<p class="mm-muted">Support question, feature idea, partnership — all welcome.</p>
					<?php if ( $sent === 'ok' ) : ?>
						<div class="mm-notice mm-notice-ok" data-testid="contact-success" role="status">Message sent! We usually reply within a day.</div>
					<?php elseif ( $sent === 'invalid' || $sent === 'error' ) : ?>
						<div class="mm-notice mm-notice-err" data-testid="contact-error" role="alert">Please fill in your name, a valid email and a message.</div>
					<?php endif; ?>
					<form id="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="mm-form">
						<input type="hidden" name="action" value="mm_contact">
						<?php wp_nonce_field( 'mm_contact', 'mm_contact_nonce' ); ?>
						<p class="mm-hp" aria-hidden="true"><label>Company <input type="text" name="mm_company" tabindex="-1" autocomplete="off"></label></p>
						<div class="mm-form-row">
							<input type="text" name="mm_name" placeholder="Your name" required data-testid="contact-name-input">
							<input type="email" name="mm_email" placeholder="you@shop.com" required data-testid="contact-email-input">
						</div>
						<div class="mm-chips" data-testid="contact-interest-picker">
							<?php foreach ( $interests as $i => $opt ) : ?>
								<label class="mm-chip">
									<input type="radio" name="mm_interest" value="<?php echo esc_attr( $opt ); ?>" <?php checked( $i, 0 ); ?>>
									<span data-testid="contact-interest-<?php echo esc_attr( strtolower( str_replace( ' ', '-', $opt ) ) ); ?>"><?php echo esc_html( $opt ); ?></span>
								</label>
							<?php endforeach; ?>
						</div>
						<textarea name="mm_message" rows="5" placeholder="What's on your mind?" required data-testid="contact-message-input"></textarea>
						<button class="mm-btn mm-btn-ink mm-btn-block" type="submit" data-testid="contact-submit-button">Send message</button>
					</form>
				</div>
				<div class="mm-stack">
					<div class="mm-card">
						<h3 class="mm-h4">Direct lines</h3>
						<p class="mm-muted mm-sm">SUPPORT<br><a class="mm-link" href="mailto:support@metamintapps.com" data-testid="contact-email-support">support@metamintapps.com</a></p>
						<p class="mm-muted mm-sm">HELLO<br><a class="mm-link" href="mailto:hello@metamintapps.com" data-testid="contact-email-hello">hello@metamintapps.com</a></p>
					</div>
					<div class="mm-card">
						<h3 class="mm-h4">House rules</h3>
						<ul class="mm-rules">
							<li>Replies within one business day, usually faster.</li>
							<li>You talk to the developers. No ticket ping-pong.</li>
							<li>Feature wishes go straight onto the roadmap board.</li>
						</ul>
					</div>
					<div class="mm-badges">
						<span class="mm-pill mm-pill-teal" data-testid="contact-badge-human">Humans only</span>
						<span class="mm-pill mm-pill-coral" data-testid="contact-badge-nobots">No bots reply</span>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php
	return ob_get_clean();
}

function mm_block_journal_archive(): string {
	$filter = isset( $_GET['product'] ) ? sanitize_key( wp_unslash( $_GET['product'] ) ) : 'all';
	$filter = in_array( $filter, [ 'helpdesk', 'seo' ], true ) ? $filter : 'all';

	$q = new WP_Query( [
		'post_type'      => 'journal_entry',
		'posts_per_page' => 50,
		'orderby'        => 'date',
		'order'          => 'DESC',
	] );

	$demo = [
		[ 'title' => 'Keyword Engine launches', 'product' => 'seo', 'version' => 'v1.1.0', 'tag' => 'New feature', 'date' => 'Jun 28, 2026', 'changes' => [ 'Track up to 500 keywords with daily rank updates', "Competitor gap view shows searches they're sleeping on", 'Weekly email digest of your biggest movers' ] ],
		[ 'title' => 'Metamint SEO arrives on Shopify', 'product' => 'seo', 'version' => 'v1.0.0', 'tag' => 'Release', 'date' => 'May 15, 2026', 'changes' => [ 'One-click audits across products, collections and pages', 'Automatic meta titles, descriptions and JSON-LD schema', 'Core Web Vitals monitoring with Shopify-specific fixes' ] ],
		[ 'title' => 'AI Agent 2.0', 'product' => 'helpdesk', 'version' => 'v1.3.0', 'tag' => 'Improvement', 'date' => 'Mar 2, 2026', 'changes' => [ 'Resolution rate up 40% with multi-turn memory', 'Softer human handoff with full conversation context', 'New tone controls: friendly, formal, or playful' ] ],
		[ 'title' => 'WooCommerce order lookups', 'product' => 'helpdesk', 'version' => 'v1.2.0', 'tag' => 'New feature', 'date' => 'Nov 20, 2025', 'changes' => [ "Customers can ask 'where is my order?' in chat", 'Agents see order history inline in every thread', 'Refund request flow with one-click approval' ] ],
		[ 'title' => 'Metamint Helpdesk goes live', 'product' => 'helpdesk', 'version' => 'v1.0.0', 'tag' => 'Release', 'date' => 'Aug 1, 2025', 'changes' => [ 'Native WordPress install in under a minute', 'Live chat, tickets and contact forms in one inbox', 'AI agent trained on your docs from day one' ] ],
	];

	$entries = [];
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$changes   = (string) mm_field( 'changes', '' );
			$entries[] = [
				'title'   => get_the_title(),
				'product' => mm_field( 'product', 'helpdesk' ),
				'version' => mm_field( 'version', '' ),
				'tag'     => mm_field( 'tag', 'Release' ),
				'date'    => get_the_date( 'M j, Y' ),
				'changes' => array_filter( array_map( 'trim', explode( "\n", $changes ) ) ),
			];
		}
		wp_reset_postdata();
	} else {
		$entries = $demo;
	}

	$entries   = array_values( array_filter( $entries, fn( $e ) => $filter === 'all' || $e['product'] === $filter ) );
	$tag_class = [ 'New feature' => 'mm-pill-teal', 'Improvement' => 'mm-pill-coral', 'Release' => 'mm-pill-tan' ];
	$archive   = get_post_type_archive_link( 'journal_entry' );
	ob_start();
	?>
	<main data-testid="journal-page">
		<section class="mm-section mm-wrap mm-narrow">
			<span class="mm-pill mm-pill-teal" data-testid="journal-hero-badge">Changelog</span>
			<h1 class="mm-display mm-left">The Journal</h1>
			<p class="mm-lede mm-left">Release notes and product updates for both apps — every version, every fix, every shiny new thing.</p>
			<div class="mm-chips mm-left" data-testid="journal-filter-picker">
				<?php foreach ( [ 'all' => 'All', 'helpdesk' => 'Helpdesk', 'seo' => 'SEO' ] as $val => $label ) : ?>
					<a class="mm-chip-link <?php echo $filter === $val ? 'is-active' : ''; ?>" href="<?php echo esc_url( $val === 'all' ? $archive : add_query_arg( 'product', $val, $archive ) ); ?>" data-testid="journal-filter-<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</div>
			<div class="mm-stack mm-journal">
				<?php foreach ( $entries as $e ) : ?>
					<?php $accent = $e['product'] === 'seo' ? '#F05D5E' : '#0F7173'; ?>
					<article class="mm-card mm-entry" data-testid="journal-entry-<?php echo esc_attr( $e['product'] . '-' . str_replace( '.', '-', (string) $e['version'] ) ); ?>">
						<div class="mm-entry-head">
							<b style="color:<?php echo esc_attr( $accent ); ?>">Metamint <?php echo esc_html( ucfirst( $e['product'] ) ); ?></b>
							<span class="mm-ver"><?php echo esc_html( $e['version'] ); ?></span>
							<span class="mm-pill <?php echo esc_attr( $tag_class[ $e['tag'] ] ?? 'mm-pill-teal' ); ?>"><?php echo esc_html( $e['tag'] ); ?></span>
							<time class="mm-date"><?php echo esc_html( $e['date'] ); ?></time>
						</div>
						<h2 class="mm-h3"><?php echo esc_html( $e['title'] ); ?></h2>
						<ul class="mm-changes">
							<?php foreach ( $e['changes'] as $c ) : ?>
								<li style="--mm-accent:<?php echo esc_attr( $accent ); ?>"><?php echo esc_html( $c ); ?></li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
	</main>
	<?php
	return ob_get_clean();
}
