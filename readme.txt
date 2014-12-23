=== WooCommerce Payment Methods ===
Contributors:      vendocrat, AlexanderPoellmann
Donate link:       http://vendocr.at/donate/
Tags:              woocommerce, credit card, logo, payment
Requires at least: 3.5
Tested up to:      4.1
Stable tag:        1.0.1
License:           GNU General Public License v3.0
License URI:       http://www.gnu.org/licenses/gpl-3.0.html

Easily display your accepted payment methods from WooCommerce via shortcode, widget or template tag.

== Description ==

WooCommerce Payment Methods allows you to display your accepted payment methods. By default the plugin shows all available payment methods, but you can also specify them manually.

You can display them via shortcode, widget or template tag in three available styles (default, inverse and outline). We've added several classes, so you can easily style the output to your pleasure.

You are using the famous Bootstrap framework? Awesome, cause we've added the markup for tooltips, so that users can see the payment methods name on hover.

**PaymentFont webfont**

This plugin uses the webfont [PaymentFont](https://github.com/vendocrat/PaymentFont) by [vendocrat](http://vendocr.at) to display the brand icons, making them look good on every screen.

**Contributions**

Contributions are warmly welcome via [GitHub](https://github.com/vendocrat/WooCommerce-Payment-Methods).

**Translations**

Translations included:

*   English
*   German
*   Italian
*   Greek (thanks to [Anestis Samourkasidis](https://wordpress.org/support/profile/samourkasidis))
*   Portuguese (thanks to [Luis Martins](https://github.com/lmartins))

All our plugins are fully localized/translateable by default and include a .pot-file! Please contact us via [Twitter](https://twitter.com/vendocrat) or hit us on [GitHub](https://github.com/vendocrat), if you have a translation you want to contribute!

= We'd love to hear from you! =

Follow us on [Twitter](https://twitter.com/vendocrat), like us on [Facebook](https://www.facebook.com/vendocrat), circle us on [Google+](https://plus.google.com/+vendocrat) or fork us on [GitHub](https://github.com/vendocrat)!

== Installation ==

1. Upload 'woocommerce-payment-methods' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Display your accepted methods via: Shortcode [wc_payment_methods], Widget or template tag '<?php wc_payment_methods(); ?>.
4. Done!

== Frequently Asked Questions ==

= Why is payment method {XYZ} missing? =

Miss some payment methods? Let me have a look at it by opening an issue on <a href="https://github.com/vendocrat/WooCommerce-Payment-Methods"><strong>GitHub</strong></a> or hit us at <a href="http://twitter.com/vendocrat">@vendocrat</a>.

== Screenshots ==

1. Shortcode output (top-down: default, inverse, outline style)
2. Widgets (top-down: default, inverse, outline style)
3. WooCommerce Checkout
3. WooCommerce Checkout in action

== Changelog ==

= 0.1.0 =
Initial release.

= 0.1.1 =
Fixed wrong url and typo in readme, updated shortcode and screenshots.

= 0.1.2 =
Fixed an error in widget class, added placement option to tooltips, updated language files.

= 0.2.0 =
Now using PaymentFont to display brand icons. Fixed textdomain issue plus some minor fixes and enhancements. Added new screenshots!

= 0.2.1 =
Fixed typo.

= 0.2.2 =
Added CSS to replace payment provider images on WooCommerce Checkout with PaymentFont icons (see screenshots).

= 0.3.0 =
Improved payment gateway function. Partial rewrite to fit our internal plugin standard. Improved l10n handling.

= 1.0.0 =
Minor fixes, updated PaymentFont and included Portuguese translation (thanks Luis Martins).

= 1.0.1 =
Minor fixes, added Greek translation (thanks to Anestis Samourkasidis).