<?php

class AffiliateWP_Affiliate_Info_Shortcodes {

	public function __construct() {

		add_shortcode( 'affiliate_info_referred', array( $this, 'shortcode_affiliate_referred' ) );
		add_shortcode( 'affiliate_info_not_referred', array( $this, 'shortcode_affiliate_not_referred' ) );
        add_shortcode( 'affiliate_info_bio', array( $this, 'shortcode_bio' ) );
		add_shortcode( 'affiliate_info_name', array( $this, 'shortcode_affiliate_name' ) );
		add_shortcode( 'affiliate_info_email', array( $this, 'shortcode_affiliate_email' ) );
		add_shortcode( 'affiliate_info_username', array( $this, 'shortcode_affiliate_username' ) );
		add_shortcode( 'affiliate_info_website', array( $this, 'shortcode_affiliate_website' ) );
		add_shortcode( 'affiliate_info_gravatar', array( $this, 'shortcode_affiliate_gravatar' ) );
		add_shortcode( 'affiliate_info_twitter', array( $this, 'shortcode_affiliate_twitter_username' ) );
		add_shortcode( 'affiliate_info_facebook', array( $this, 'shortcode_affiliate_facebook' ) );
		add_shortcode( 'affiliate_info_googleplus', array( $this, 'shortcode_affiliate_googleplus' ) );

	}

	/**
    * [affiliate_info_referred] shortcode
    *1
    * @since  1.0.1
    */
    public function shortcode_affiliate_referred( $atts, $content = null ) {

		$affiliate_id = affiliatewp_affiliate_info()->functions->get_affiliate_id();

		if ( ! $affiliate_id ) {
			return;
		}

    	return do_shortcode( $content );
    }

	/**
    * [affiliate_info_not_referred] shortcode
    *
    * @since  1.0.1
    */
    public function shortcode_affiliate_not_referred( $atts, $content = null ) {

		$affiliate_id = affiliatewp_affiliate_info()->functions->get_affiliate_id();

		if ( $affiliate_id ) {
			return;
		}

    	return do_shortcode( $content );
    }

    /**
    * [affiliate_info_bio] shortcode
    *
    * @since  1.0.0
    */
    public function shortcode_bio( $atts, $content = null ) {

    	$content = affiliatewp_affiliate_info()->functions->get_affiliate_bio();

    	return do_shortcode( $content );
    }

	/**
    * [affiliate_info_name] shortcode
    *
    * @since  1.0.0
    */
    public function shortcode_affiliate_name( $atts, $content = null ) {

    	$content = affiliatewp_affiliate_info()->functions->get_affiliate_name();

    	return do_shortcode( $content );
    }

	/**
    * [affiliate_info_twitter] shortcode
    *
    * @since  1.0.0
    */
    public function shortcode_affiliate_twitter_username( $atts, $content = null ) {

    	$content = affiliatewp_affiliate_info()->functions->get_twitter_username();

    	return do_shortcode( $content );
    }

	/**
    * [affiliate_info_facebook] shortcode
    *
    * @since  1.0.0
    */
    public function shortcode_affiliate_facebook( $atts, $content = null ) {

    	$content = affiliatewp_affiliate_info()->functions->get_facebook_url();

    	return do_shortcode( $content );
    }

	/**
    * [affiliate_info_googleplus] shortcode
    *
    * @since  1.0.0
    */
    public function shortcode_affiliate_googleplus( $atts, $content = null ) {

    	$content = affiliatewp_affiliate_info()->functions->get_googleplus_url();

    	return do_shortcode( $content );
    }

	/**
	 * [affiliate_info_username] shortcode
	 *
	 * @since  1.0.0
	 */
	public function shortcode_affiliate_username( $atts, $content = null ) {

		$content = affiliatewp_affiliate_info()->functions->get_affiliate_username();

		return do_shortcode( $content );
	}

	/**
	* [affiliate_info_email] shortcode
	*
	* @since  1.0.0
	*/
	public function shortcode_affiliate_email( $atts, $content = null ) {

		$content = affiliatewp_affiliate_info()->functions->get_affiliate_email();

		return do_shortcode( $content );
	}

	/**
    * [affiliate_info_website] shortcode
    *
    * @since  1.0.0
    */
    public function shortcode_affiliate_website( $atts, $content = null ) {

    	$content = affiliatewp_affiliate_info()->functions->get_affiliate_website();

    	return do_shortcode( $content );
    }

	/**
    * [affiliate_info_gravatar] shortcode
    *
    * @since  1.0.0
    */
    public function shortcode_affiliate_gravatar( $atts, $content = null ) {

        $atts = array_change_key_case( (array) $atts, CASE_LOWER );

        $content = affiliatewp_affiliate_info()->functions->get_affiliate_gravatar( $atts );

    	return do_shortcode( $content );
    }

}
new AffiliateWP_Affiliate_Info_Shortcodes;
