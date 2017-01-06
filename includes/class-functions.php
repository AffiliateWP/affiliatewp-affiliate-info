<?php

class AffiliateWP_Affiliate_Info_Functions {

	public function __construct() {}

	/**
	 * Get the affiliate ID
	 *
	 * @since 1.0.0
	 */
	public function get_affiliate_id() {

		// credit last referrer enabled
		$credit_last_referrer = affiliate_wp()->settings->get( 'referral_credit_last' );

		// get referral variable (eg ref)
		$referral_var = affiliate_wp()->tracking->get_referral_var();

		// if credit last referrer is enabled it needs to get the affiliate ID from the URL straight away
		if ( $credit_last_referrer ) {

			if ( $this->get_the_affiliate_id() ) {
				$affiliate_id = $this->get_the_affiliate_id();
			} elseif ( affiliate_wp()->tracking->get_affiliate_id() ) {
				// get affiliate ID from cookies
				$affiliate_id = affiliate_wp()->tracking->get_affiliate_id();
			} else {
				// no affiliate ID
				$affiliate_id = '';
			}

		} else {

			// get affiliate from cookie first
			if ( affiliate_wp()->tracking->get_affiliate_id() ) {
				$affiliate_id = affiliate_wp()->tracking->get_affiliate_id();
			} elseif ( $this->get_the_affiliate_id() ) {
				$affiliate_id = $this->get_the_affiliate_id();
			} else {
				// no affiliate ID
				$affiliate_id = '';
			}

		}

		// finally, check if they are a valid affiliate
		if ( $affiliate_id && affwp_is_affiliate( affwp_get_affiliate_user_id( $affiliate_id ) ) && affwp_is_active_affiliate( $affiliate_id ) ) {
			return $affiliate_id;
		}

		return false;

	}

	/**
	 * Get the affiliate ID from the referral value
	 *
	 * @since 1.0.3
	 * @param string $referral_value
	 * @return $affiliate_id, false otherwise
	 */
	private function get_affiliate_id_from_referral_value( $referral_value = '' ) {

		if ( ! is_numeric( $referral_value ) ) {
			// username used instead of user ID

			// get user by WP username
			$user = get_user_by( 'login', $referral_value );

			if ( $user ) {
				// get the affiliate ID from the user ID
				$affiliate_id = affwp_get_affiliate_id( $user->ID );

			} elseif ( class_exists( 'AffiliateWP_Custom_Affiliate_Slugs' ) ) {

				// try and get the affiliate ID based on the custom slug
				$custom_affiliate_slugs = new AffiliateWP_Custom_Affiliates_Slugs_Base;

				if ( method_exists( $custom_affiliate_slugs, 'get_affiliate_id_from_slug' ) ) {
					$affiliate_id = $custom_affiliate_slugs->get_affiliate_id_from_slug( $referral_value );
				}

			}

		} else {
			// affiliate ID was used instead of username
			// Usernames must have at least 4 characters
			$affiliate_id = $referral_value;
		}

		if ( $affiliate_id ) {
			return $affiliate_id;
		}

		return false;

	}

	/**
	 * Get the affiliate ID
	 *
	 * @since 1.0.3
	 */
	private function get_the_affiliate_id() {

		global $wp_query;

		$referral_var = affiliate_wp()->tracking->get_referral_var();

		/**
		 * Gets the affiliate ID for instances where we're on the homepage, a static front page has been set
		 * AffiliateWP removes the query var from the homepage (see unset_query_arg)
		 * so the site's blog is not shown when a static page is used with a referral link
		 * This is due to a core WordPress bug: https://core.trac.wordpress.org/ticket/25143
		 *
		 * @since 1.0.3
		 */
		if ( is_front_page() && get_option( 'page_on_front' ) ) {

			if ( isset( $_GET[$referral_var] ) && $_GET[$referral_var] ) {

				// non-pretty affiliate referral URLs
				$affiliate_id = $this->get_affiliate_id_from_referral_value( $_GET[$referral_var] );

			} else {
				// pretty affiliate URLs

				// get the path of the current URL. eg /ref/john
				$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

				// explode the string into an array
				$path_components = explode( '/', trim( $path, '/' ) );

				// the first path component (eg ref) must match the referral variable set in Affiliates -> Settings -> General
				$affiliate_id = $path_components[0] === $referral_var ? $this->get_affiliate_id_from_referral_value( $path_components[1] ) : '';

			}

			return $affiliate_id;

		} else {

			/**
			 * Gets the affiliate ID when a cookie is not present, based on the query string, either ?ref=john or /ref/john
			 *
			 * @since 1.0.3
			 */

			if ( isset( $wp_query->query[$referral_var] ) ) {

				$affiliate_id = $this->get_affiliate_id_from_referral_value( $wp_query->query[$referral_var] );

				return $affiliate_id;

			}

		}

		return false;
	}

	/**
	 * Get the affiliate's bio
	 *
	 * @since 1.0.0
	 */
	public function get_affiliate_bio() {

		$user_id = affwp_get_affiliate_user_id( $this->get_affiliate_id() );

		if ( $user_id ) {
			$bio = get_user_meta( $user_id, 'description', true );
			return $bio;
		}

		return false;

	}

	/**
	 * Get the affiliate's display name
	 *
	 * @since 1.0.0
	 */
	public function get_affiliate_name() {

		$affiliate_id = $this->get_affiliate_id();

		if ( $affiliate_id ) {
			return affiliate_wp()->affiliates->get_affiliate_name( $affiliate_id );
		}

		return false;

	}

	/**
	 * Get the affiliate's Twitter username
	 *
	 * @since 1.0.0
	 */
	public function get_twitter_username() {

		$affiliate_id = $this->get_affiliate_id();

		if ( $affiliate_id ) {
			return get_the_author_meta( 'twitter', affwp_get_affiliate_user_id( $affiliate_id ) );
		}

		return false;

	}

	/**
	 * Get the affiliate's Facebook URL
	 *
	 * @since 1.0.0
	 */
	public function get_facebook_url() {

		$affiliate_id = $this->get_affiliate_id();

		if ( $affiliate_id ) {
			return get_the_author_meta( 'facebook', affwp_get_affiliate_user_id( $affiliate_id ) );
		}

		return false;

	}

	/**
	 * Get the affiliate's Google + URL
	 *
	 * @since 1.0.0
	 */
	public function get_googleplus_url() {

		$affiliate_id = $this->get_affiliate_id();

		if ( $affiliate_id ) {
			return get_the_author_meta( 'googleplus', affwp_get_affiliate_user_id( $affiliate_id ) );
		}

		return false;

	}

	/**
	 * Get the affiliate's username
	 *
	 * @since 1.0.0
	 */
	public function get_affiliate_username() {

		$affiliate_id = $this->get_affiliate_id();

		if ( $affiliate_id ) {

			$user_info = get_userdata( affwp_get_affiliate_user_id( $affiliate_id ) );

			if ( $user_info ) {
				$username  = esc_html( $user_info->user_login );
				return esc_html( $username );
			}

		}

		return false;

	}

	/**
	 * Get the affiliate's website
	 *
	 * @since 1.0.0
	 */
	public function get_affiliate_website() {

		$affiliate_id = $this->get_affiliate_id();

		if ( $affiliate_id ) {
			return get_the_author_meta( 'user_url', affwp_get_affiliate_user_id( $affiliate_id ) );
		}

		return false;

	}

	/**
	 * Get the affiliate's email
	 *
	 * @since 1.0.0
	 */
	public function get_affiliate_email() {

		$affiliate_id = $this->get_affiliate_id();

		if ( $affiliate_id ) {
			return affwp_get_affiliate_email( $affiliate_id );
		}

		return false;

	}

	/**
	* Get the affiliate's gravatar
	*
	* @since 1.0.0
	*/
   public function get_affiliate_gravatar() {

	   $affiliate_id = $this->get_affiliate_id();

	   if ( $affiliate_id ) {

		   $args = apply_filters( 'affwp_affiliate_info_gravatar_defaults', array(
			   'size'    => 96,
			   'default' => '',
			   'alt'     => $this->get_affiliate_name()
		   ) );

		   $email = affwp_get_affiliate_email( $affiliate_id );

		   return get_avatar( affwp_get_affiliate_user_id( $affiliate_id ), $args['size'], $args['default'], $args['alt'] );

	   }

	   return false;

   }

}
