<?php

class AffiliateWP_Affiliate_Info_Functions {

	public function __construct() {}

	/**
	 * Get the affiliate ID
	 *
	 * @since 1.0.0
	 * @since 1.0.5 Added an additional check for the Affiliate Landing Pages add-on.
	 */
	public function get_affiliate_id() {

		// Credit last referrer enabled.
		$credit_last_referrer = affiliate_wp()->settings->get( 'referral_credit_last' );

		// Get referral variable (eg ref).
		$referral_var = affiliate_wp()->tracking->get_referral_var();

		if ( class_exists( 'AffiliateWP_Affiliate_Landing_Pages' ) && $get_affiliate_id = affiliatewp_affiliate_landing_pages()->get_affiliate_id( get_the_ID() ) ) {
			/**
			 * If Affiliate Landing Pages is installed, try and retrieve an
			 * affiliate ID from the current page.
			 */
			$affiliate_id = $get_affiliate_id;

		} elseif ( $credit_last_referrer ) {
			// if credit last referrer is enabled it needs to get the affiliate ID from the URL straight away

			if ( $this->get_affiliate_id_or_username() ) {
				$affiliate_id = $this->get_affiliate_id_or_username();
			} elseif ( affiliate_wp()->tracking->get_affiliate_id() ) {
				// Get affiliate ID from cookies.
				$affiliate_id = affiliate_wp()->tracking->get_affiliate_id();
			} else {
				// No affiliate ID.
				$affiliate_id = '';
			}

		} else {

			// Get affiliate ID from cookie first.
			if ( $get_affiliate_id = affiliate_wp()->tracking->get_affiliate_id() ) {
				$affiliate_id = $get_affiliate_id;
			} elseif ( $get_affiliate_id_or_username = $this->get_affiliate_id_or_username() ) {
				$affiliate_id = $get_affiliate_id_or_username;
			} else {
				// No affiliate ID.
				$affiliate_id = '';
			}

		}

		// Finally, check if they are a valid affiliate.
		if ( $affiliate_id && affwp_is_affiliate( affwp_get_affiliate_user_id( $affiliate_id ) ) && affwp_is_active_affiliate( $affiliate_id ) ) {
			return $affiliate_id;
		}

		return false;

	}

	/**
	 * Get the affiliate ID or username
	 *
	 * @since 1.0.4
	 */
	public function get_affiliate_id_or_username() {

		$affiliate_id_or_username = affiliate_wp()->tracking->get_fallback_affiliate_id();

		/**
		 * If the referral variable's value is a string we need to do some additional checking.
		 * The get_fallback_affiliate_id() method does not account for a non-pretty affiliate link, in combination with a custom affiliate slug. E.g. /?ref=thecustomslug.
		 */

		// See if it's a string
		if ( intval( $affiliate_id_or_username ) < 1 || ! is_numeric( $affiliate_id_or_username ) ) {

			// Check if there's a WP username tied to the string.
			$user = get_user_by( 'login', $affiliate_id_or_username );

			if ( $user ) {

				// This is a WP username, we can return early.
				return $affiliate_id_or_username;

			} elseif ( class_exists( 'AffiliateWP_Custom_Affiliate_Slugs' ) ) {

				/**
				 * If Custom Affiliate Slugs is installed and active, try and retrieve the affiliate ID from the custom slug.
				 */
				$custom_affiliate_slugs = new AffiliateWP_Custom_Affiliates_Slugs_Base;

				if ( method_exists( $custom_affiliate_slugs, 'get_affiliate_id_from_slug' ) ) {
					$affiliate_id_or_username = $custom_affiliate_slugs->get_affiliate_id_from_slug( $affiliate_id_or_username );
				}

			}

		}

		// Return the affiliate ID or username.
		return $affiliate_id_or_username;

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
	* Gets the affiliate's gravatar
	*
	* @since 1.0.0
	*
	* @param array $atts Attributes passed from the shortcode.
	* @return string Image tag with src to gravatar.
	*/
   public function get_affiliate_gravatar( $atts ) {

	   $affiliate_id = $this->get_affiliate_id();

	   if ( $affiliate_id ) {

			$atts = shortcode_atts(
				array(
					'size' => 96,
				), $atts, 'affiliate_info_gravatar'
			);
			/**
			 * Filters the gravatar defaults.
			 *
			 * @since 1.0.0
			 *
			 * @param array $args {
			 *     Arguments for retrieving the affiliate avatar.
			 *
			 *     @type int    $size    Avatar display size.
			 *     @type string $default Absolute location of the default avatar to use (used when the
			 *                           person has no email address associated with them). Left blank
			 *                           will render placeholder image.
			 *     @type string $alt     Alt text. Defaults to affiliate name.
			 * }
			 */
		   $args = apply_filters( 'affwp_affiliate_info_gravatar_defaults', array(
			   'size'    => intval( $atts['size'] ),
			   'default' => '',
			   'alt'     => $this->get_affiliate_name()
		   ) );

		   $email = affwp_get_affiliate_email( $affiliate_id );

		   return get_avatar( affwp_get_affiliate_user_id( $affiliate_id ), $args['size'], $args['default'], $args['alt'] );

	   }

	   return false;

   }

}
