<?php
/**
 * SCF (Secure Custom Fields) / ACF field groups, registered in PHP.
 * Works with both SCF and ACF — they share the acf_* API.
 * Every template also ships default content, so the theme works with the plugin inactive.
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/include_fields', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( [
		'key'      => 'group_mm_product',
		'title'    => 'Product Page',
		'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'product' ] ] ],
		'fields'   => [
			[ 'key' => 'field_mm_product_key', 'label' => 'Product', 'name' => 'product_key', 'type' => 'select', 'choices' => [ 'helpdesk' => 'Metamint Helpdesk', 'seo' => 'Metamint SEO' ], 'required' => 1 ],
			[ 'key' => 'field_mm_hero_badge', 'label' => 'Hero Badge', 'name' => 'hero_badge', 'type' => 'text' ],
			[ 'key' => 'field_mm_hero_desc', 'label' => 'Hero Description', 'name' => 'hero_desc', 'type' => 'textarea', 'rows' => 3 ],
			[ 'key' => 'field_mm_buy_url', 'label' => 'Marketplace URL', 'name' => 'buy_url', 'type' => 'url' ],
			[ 'key' => 'field_mm_buy_label', 'label' => 'Buy Button Label', 'name' => 'buy_label', 'type' => 'text' ],
			[ 'key' => 'field_mm_hero_image', 'label' => 'Hero Image', 'name' => 'hero_image', 'type' => 'image', 'return_format' => 'url' ],
			[
				'key' => 'field_mm_features', 'label' => 'Features', 'name' => 'features', 'type' => 'repeater', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_mm_feature_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
					[ 'key' => 'field_mm_feature_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 2 ],
				],
			],
			[
				'key' => 'field_mm_steps', 'label' => 'How It Works Steps', 'name' => 'steps', 'type' => 'repeater', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_mm_step_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
					[ 'key' => 'field_mm_step_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 2 ],
				],
			],
			[
				'key' => 'field_mm_plans', 'label' => 'Pricing Plans', 'name' => 'plans', 'type' => 'repeater', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_mm_plan_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ],
					[ 'key' => 'field_mm_plan_price', 'label' => 'Price (USD/year)', 'name' => 'price', 'type' => 'number' ],
					[ 'key' => 'field_mm_plan_tagline', 'label' => 'Tagline', 'name' => 'tagline', 'type' => 'text' ],
					[ 'key' => 'field_mm_plan_features', 'label' => 'Features (one per line)', 'name' => 'features', 'type' => 'textarea', 'rows' => 5 ],
					[ 'key' => 'field_mm_plan_popular', 'label' => 'Most popular?', 'name' => 'popular', 'type' => 'true_false', 'ui' => 1 ],
				],
			],
			[
				'key' => 'field_mm_faqs', 'label' => 'FAQ', 'name' => 'faqs', 'type' => 'repeater', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_mm_faq_q', 'label' => 'Question', 'name' => 'q', 'type' => 'text' ],
					[ 'key' => 'field_mm_faq_a', 'label' => 'Answer', 'name' => 'a', 'type' => 'textarea', 'rows' => 3 ],
				],
			],
		],
	] );

	acf_add_local_field_group( [
		'key'      => 'group_mm_home',
		'title'    => 'Home Page',
		'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
		'fields'   => [
			[ 'key' => 'field_mm_home_hero_title_1', 'label' => 'Hero Line 1', 'name' => 'hero_line_1', 'type' => 'text', 'default_value' => 'Plugins with punch.' ],
			[ 'key' => 'field_mm_home_hero_title_2', 'label' => 'Hero Line 2', 'name' => 'hero_line_2', 'type' => 'text', 'default_value' => 'Software with soul.' ],
			[ 'key' => 'field_mm_home_hero_sub', 'label' => 'Hero Subtitle', 'name' => 'hero_sub', 'type' => 'textarea', 'rows' => 2 ],
			[
				'key' => 'field_mm_testimonials', 'label' => 'Testimonials', 'name' => 'testimonials', 'type' => 'repeater', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_mm_t_quote', 'label' => 'Quote', 'name' => 'quote', 'type' => 'textarea', 'rows' => 3 ],
					[ 'key' => 'field_mm_t_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text' ],
					[ 'key' => 'field_mm_t_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text' ],
					[ 'key' => 'field_mm_t_product', 'label' => 'Product', 'name' => 'product', 'type' => 'select', 'choices' => [ 'Metamint Helpdesk' => 'Metamint Helpdesk', 'Metamint SEO' => 'Metamint SEO' ] ],
				],
			],
		],
	] );

	acf_add_local_field_group( [
		'key'      => 'group_mm_journal',
		'title'    => 'Journal Entry Details',
		'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'journal_entry' ] ] ],
		'fields'   => [
			[ 'key' => 'field_mm_j_product', 'label' => 'Product', 'name' => 'product', 'type' => 'select', 'choices' => [ 'helpdesk' => 'Metamint Helpdesk', 'seo' => 'Metamint SEO' ], 'required' => 1 ],
			[ 'key' => 'field_mm_j_version', 'label' => 'Version', 'name' => 'version', 'type' => 'text', 'placeholder' => 'v1.0.0' ],
			[ 'key' => 'field_mm_j_tag', 'label' => 'Tag', 'name' => 'tag', 'type' => 'select', 'choices' => [ 'New feature' => 'New feature', 'Improvement' => 'Improvement', 'Release' => 'Release' ] ],
			[ 'key' => 'field_mm_j_changes', 'label' => 'Changes (one per line)', 'name' => 'changes', 'type' => 'textarea', 'rows' => 5 ],
		],
	] );
} );
