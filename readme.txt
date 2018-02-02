=== AffiliateWP - Affiliate Info ===
Contributors: sumobi, mordauk
Tags: AffiliateWP, affiliate, affiliates, Pippin Williamson, Andrew Munro, mordauk, pippinsplugins, sumobi, ecommerce, e-commerce, e commerce, selling, membership, referrals, marketing
Requires at least: 3.3
Tested up to: 4.9.2
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display information based on the affiliate's referral URL

== Description ==

Affiliate Info allows you to show affiliate information based on the affiliate
currently being tracked. When a user clicks an affiliate’s referral URL and
arrives on your website, the affiliate’s ID is stored by AffiliateWP.
Affiliate Info simply shows information based on the tracked affiliate.

Let’s say you have an affiliate named John who shares his referral URL.
Any user that clicks on John’s referral link can now see a variety of information
about John, anywhere on your website.

You can show:

- John’s WordPress display name
- John’s website URL
- John’s email address (be careful with this!)
- John’s gravatar image
- John’s WordPress username
- John’s biographical info (from his WordPress profile)
- John's Twitter username
- John's Facebook URL
- John's Google+ URL

There are currently 9 shortcodes to show the information above:

1. [affiliate_info_name]
2. [affiliate_info_website]
3. [affiliate_info_email]
4. [affiliate_info_gravatar]
5. [affiliate_info_username]
6. [affiliate_info_bio]
7. [affiliate_info_twitter]
8. [affiliate_info_facebook]
9. [affiliate_info_googleplus]

There's also 2 shortcodes that you can embed the above in:

1. [affiliate_info_referred] - show content only when an affiliate is being tracked
2. [affiliate_info_not_referred] - show content only when an affiliate is not being tracked. Useful for providing a fallback.

If you’re a developer you can access this information directly with some useful
PHP functions.

Affiliate Info also works in tandem with AffiliateWP’s Credit Last Referrer option
which means the information will change each time a new referral URL is used.

Some potential uses for this add-on include:

**Showing the customer who referred them**

Show a custom message based on the affiliate being tracked. For example,
“You’ve been referred by John” or “Your site representative is John”.

For example:

Your site representative is [affiliate_info_name]

If no affiliate is being tracked it will just show "Your site representative is "
so use the [affiliate_info_referred] shortcode to make sure nothing is shown when
no affiliate is being tracked.

For example:

[affiliate_info_referred]Your site representative is [affiliate_info_name][/affiliate_info_referred]

**Allow the site visitor to contact the affiliate**

There may be instances where your affiliates are in direct contact with your customers. Show the affiliate's email address, or add a form (Gravity Forms or another form plugin) which sends an email to the affiliate being tracked.

Note, if you're going to show any form of email address out in the wild, make sure you protect it using one of the many plugins available on the WordPress repo.

**Create a landing page**

Create a landing page for your products that show the current tracked affiliate's information. This is especially useful if an affiliate does not have a website, or you want more control over how your products are advertised. Affiliates can link directly to your landing page with their referral URL, and their information will be displayed.

**What is AffiliateWP?**

[AffiliateWP](https://affiliatewp.com/ "AffiliateWP") provides a complete affiliate management system for your WordPress website that seamlessly integrates with all major WordPress e-commerce and membership platforms. It aims to provide everything you need in a simple, clean, easy to use system that you will love to use.

== Installation ==

1. Unpack the entire contents of this plugin zip file into your `wp-content/plugins/` folder locally
1. Upload to your site
1. Navigate to `wp-admin/plugins.php` on your site (your WP Admin plugin page)
1. Activate this plugin

OR you can just install it with WordPress by going to Plugins >> Add New >> and type this plugin's name

== Upgrade Notice ==

== Changelog ==

= 1.0.5 =
* Fix: Compatibility with the Affiliate Landing Pages pro add-on, allowing affiliate info to be shown on first page load.

= 1.0.4 =
* New: Compatibility with the Custom Affiliate Slugs pro add-on
* Fix: Affiliate info not being retrieved on first page load due to a recent change in AffiliateWP

= 1.0.3 =
* Fix: Affiliate ID was not being retrieved correctly when a static front page is used.

= 1.0.2 =
* Fix: Removed old admin setting that was not needed.
* Fix: Affiliate ID was not being retrieved correctly on first page load when using usernames in the affiliate referral URLs

= 1.0.1 =
* New: [affiliate_info_referred] shortcode to show content only when an affiliate is being tracked
* New: [affiliate_info_not_referred] shortcode to show content only when an affiliate is not being tracked. Useful for providing a fallback.

= 1.0 =
* Initial release
