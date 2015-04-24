=== WooCommerce Payment Methods ===
Contributors:      vendocrat, AlexanderPoellmann
Donate link:       http://vendocr.at/donate/
Tags:              woocommerce, credit card, logo, payment
Requires at least: 3.5
Tested up to:      4.2
Stable tag:        1.1.2
License:           GNU General Public License v3.0
License URI:       http://www.gnu.org/licenses/gpl-3.0.html

Easily display your accepted payment methods via shortcode, widget or template tag. Of course, it also works without WooCommerce ;)

== Description ==

WooCommerce Payment Methods allows you to display your accepted payment methods. By default the plugin shows all available payment methods, but you can also specify or override them manually.

You can display them via shortcode, widget or template tag in three available styles (default, inverse and outline). We`ve added several classes, so you can easily style the output to your pleasure.

You are using the famous Bootstrap framework? Awesome, cause we`ve added the markup for tooltips, so that users can see the payment methods name on hover.

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

= We`d love to hear from you! =

Follow us on [Twitter](https://twitter.com/vendocrat), like us on [Facebook](https://www.facebook.com/vendocrat), circle us on [Google+](https://plus.google.com/+vendocrat) or fork us on [GitHub](https://github.com/vendocrat)!

== Installation ==

1. Upload `woocommerce-payment-methods` to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Display your accepted methods via: Shortcode [wc_payment_methods], Widget or template tag `<?php wc_payment_methods(); ?>.
4. Done!

== Frequently Asked Questions ==

= Why is payment method {XYZ} missing? =

Miss some payment methods? Let me have a look at it by opening an issue on <a href="https://github.com/vendocrat/WooCommerce-Payment-Methods"><strong>GitHub</strong></a> or hit us at <a href="http://twitter.com/vendocrat">@vendocrat</a>.

= How to display the payment methods? =

You can use the function `wc_payment_methods( $atts )`, the shortcode `[wc_payment_methods]` or the widget.

= What function/shortcode attributes are available? =

1. `methods` => Comma separated list of payment methods icon slugs to be displayed, see http://paymentfont.io for available icons, defaults to false
2. `style` => How shall the icons be displayed? Available options are default, inverse and outline.
3. `tooltip` => Adds data attributes to icon to be used for diplaying tooltips (made for Bootstrap), defaults to false
4. `placement` => Set tooltip placement, defaults to bottom
5. `xclass` => Add any extra classes, seperated by a space, defaults to false

= How can I manually specify or override the displayed methods? =

In the function and the shortcode use the attribute `methods`. In the widget there is a field for that. If you don`t specify any methods manually, the plugin will try to fetch the available payment methods from WooCommerce. Oh, and there are also two filters available (see beneath).

= Are Filters/Hooks available? =

Yep, there is first of all the filter `vendocrat_filter_wc_payment_methods` which expects an array. Use this to specify/override the methods to be shown globally.

With the filter `vendocrat_filter_wc_payment_methods_icons` you can modify the html markup for all icons to be displayed. This will look somehow like `<li><i class="pf pf-paypal"></i></li><li><i class="pf pf-visa"></i></li><li><i class="pf pf-mastercard"></i></li>` for the icons PayPal, Visa and MasterCard.

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

= 1.1.0 =
Minor fixes, added multiselect to widget to manually pick payment methods, update to PaymentFont v1.1.1 for better performance.

= 1.1.1 =
Minor fixes, enhanced widget.

= 1.1.2 =
Updated language files for German.