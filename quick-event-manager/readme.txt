=== Quick Event Manager ===
Contributors: brightvesseldev, kleinmannbrightvessel
Tags: event manager, calendar, events, event booking, event calendar
Tested up to: 6.8.3
Stable tag: 9.17
Requires at least: 5.6
Requires PHP: 7.4
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Simple event manager. No messing about, just add events and a shortcode and the plugin does the rest for you.

== Description ==

A lightweight event manager for WordPress. Add events from your dashboard and display them however you want — calendar, list, or shortcode. No fuss. Just works.
The settings panel lets you decide how your events should look and behave.

= Features =

*   Event posts added directly from your dashboard
*   Multiple layout and styling options
*   Display as list or calendar
*   Built-in registration form
*   Payment support via IPN
*   Download attendee reports to CSV or email
*   One-click add to calendar
*   Google Maps support for locations
*   Widgets and shortcodes to embed events anywhere

= Developers plugin page =

[Quick Event Manager](https://brightplugins.com/product/quick-event-manager/).

= Pro Version =

The Pro upgrade unlocks a truckload of extras:
*   Stripe payment integration
*   Mailchimp sync
*   Event imports (CSV)
*   Advanced reporting
*   Guest events — let visitors submit their own
*   Sliding scale pricing via donation fields
*   Discount codes (global or per-event)
*   Link to third-party platforms (Eventbrite, Ticket Tailor, Zoom, Facebook Events, etc.)
*   Merge with Eventbrite feeds via Display Eventbrite Events Plugin
*   Control when registration opens and closes
*   Set end dates and visibility rules
*   Priority support

= Support =

**Using the free version?**
    Post your issue on the [support tab](https://brightplugins.com/support/) . We read every message and improve regularly.
**Using the Pro version?**
    Due to policy, we can't offer direct forum support for paid versions. Get help [on our site](https://brightplugins.com/support/).

= What people are saying= 

>   “Easy to install and configure. Works as expected.”
>   – Every person who hates bloated event plugins

>   “I moved to this after two other event plugins failed. Setup took 5 minutes. No regrets.”
>   – Smart move, random stranger

>   “Had an issue, sent a message, got a fix in less than 24 hours. That’s service.”
>   – Not making this up, either

## 🔥 ALL ACCESS MEMBERSHIP 🔥 ##

Unlock all 19 premium WooCommerce plugins with one club membership. [Join the Club](https://brightplugins.com/product/club-membership/?utm_source=freemium&utm_medium=wp_org_page&utm_campaign=upgrade_club_membership)

## SOME OF OUR PREMIUM PLUGINS ##

[Additional Variation Images for WooCommerce](https://brightplugins.com/additional-variation-images-for-woocommerce/)
[Min/Max Quantities for WooCommerce](https://brightplugins.com/min-max-quantities-for-woocommerce-review/)
[Preorders for WooCommerce PRO](https://brightplugins.com/woocommerce-preorder-plugin-review/)
[Deposits for WooCommerce PRO](https://brightplugins.com/deposits-for-woocommerce/)

## SOME OF OUR FREE PLUGINS ##

[Custom Order Status Manager for WooCommerce](https://wordpress.org/plugins/bp-custom-order-status-for-woocommerce/) allows you to create, delete and edit order statuses to control the flow of your orders better.
[Order Delivery Date Time & Pickup for WooCommerce](https://wordpress.org/plugins/bp-order-date-time-for-woocommerce/) During the checkout process, customers can effortlessly choose a delivery date and time for their orders.
[Show Stock for WooCommerce](https://wordpress.org/plugins/woo-show-stock/)
[Order Status Control for WooCommerce](https://wordpress.org/plugins/order-status-control-for-woocommerce/)
[Disable Email Notifications for WooCommerce](https://wordpress.org/plugins/woo-disable-email-notifications/)

== Screenshots ==

1. This is an example of an event post.
2. This is the list of events.
3. This the event editor.
4. The styling editor.
5. Setting up the calendar.

== Installation ==

1.  Login to your WordPress dashboard.
2.  Go to 'Plugins', 'Add New' then search for 'quick event manager'.
4.  Select the plugin then 'Install Now'.
5.  Activate the plugin.
6.  Go to the plugin 'Settings' page to change how the events display.
7.  Go to your permalinks page and re-save to activate the custom posts.
8.  Add new events using the event editor on your dashboard
9.  To use the form in your posts and pages add the shortcode `[qem]`.

== Frequently Asked Questions ==

= How do I add a new event? =
In the main dashboard, click on 'event' then 'add new'.

= What's the shortcode? =
[qem]
If you just want a calendar use the shortcode [qemcalendar]

= How do I change the colours and things? =
Use the plugin settings page. You can't style individual events, they all look the same.
But you can change lots of colours on the calendar

= Can I add more fields? =
No.

= Why not? =
Well OK yes you can add more fields if you want but you are going to have to fiddle about with the php file which needs a bit of care and attention. Everything you need to know is in the [wordpress codex](http://codex.wordpress.org/Writing_a_Plugin).

= How can I report security bugs? =
You can report security bugs through the Patchstack Vulnerability Disclosure Program. The Patchstack team help validate, triage and handle any security vulnerabilities. [Report a security vulnerability.](https://patchstack.com/database/vdp/quick-event-manager)

== Changelog ==

= 9.17 - 28 Oct 2025 =  
* Support for WordPress 6.8.3

= 9.14.1 =  
* Improve image upload to guest events and fix some minor bugs in it ( Pro only )  

= 9.14 =  
* Add class to active categories buttons  

= 9.13 =  
* Enable optin in custom forms  

= 9.12.2 =  
* Improve guest registration form ( Pro only )  
* Update libraries  

= 9.12.1 =  
* Update libraries  

= 9.12 =  
* Improve Display Eventbrite integration ( Pro only )  

= 9.11.2 =  
* Add extra field to integration with Display Eventbrite ( Pro only )  

= 9.11.1 =  
* Update Stripe library ( Pro only )  

= 9.11 =  
* Fix to the auto option ( Pro Only )  
* Better handling of free when installing pro  

= 9.10.1 =  
* Update Stripe library ( Pro only )  

= 9.10 =  
* Add option for calendar to auto start on first future month when there is an event ( Pro only )  

= 9.9.10 =  
* Fix broken images  

= 9.9.9 =  
* Further fix to post IPN processing  

= 9.9.8 =  
* Fix issue with PHP 8.2 cutoff date  

= 9.9.7 =  
* Fix missing image issue  

= 9.9.6 =  
* Update Italian translations  

= 9.9.5 =  
* Fix post PayPal IPN message when variable tickets used  
* Fix date in cutoff date message  

= 9.9.4 =  
* Fix issue with admin notification on PayPal IPN  

= 9.9.3 =  
* Enable submit to work on multiple forms on same page  

= 9.9.2 =  
* Ensure string cost is converted properly to avoid possibility of issues on PHP 8.+  

= 9.9.1 =  
* Improve settings description  

= 9.9.0 =  
* Fix cutoff date not displaying on event list  
* Add total value and donation amount shortcodes for auto responders (Pro Only)  

= 9.8.9 =  
* Fix style on wait list attendees  

= 9.8.8 =  
* Fix fatal error for some scenarios on PHP 8.1 and various notices  

= 9.8.7 =  
* Fix Thank you page message on grid layout  

= 9.8.6 =  
* Fix for shortcode qemsendemail (Pro Only)  

= 9.8.5.9 =  
* Remove attempt to load missing un-needed files  

= 9.8.5.8 =  
* Check for not null freemius when detecting plugin already installed  

= 9.8.5.7 =  
* JavaScript fix for incompatible themes  
* Fix for 8.1 compatibility  

= 9.8.5.6 =  
* Fix pay later logic  
* Add notification if a user re-registers for a pending payment  

= 9.8.5.5 =  
* Fix pay later thank you  

= 9.8.5.4 =  
* Improve data feed to Display Eventbrite plugin ( Pro Only )  
* Fix rounding on Stripe prices ( Pro Only )  

= 9.8.5.3 =  
* Allow HTML in payment auto responder  

= 9.8.5.2 =  
* Fix registration form not showing  

= 9.8.5.1 =  
* Fix individual email sending and sort into date (Pro Only)  
* Fix missing form preview  
* Make popup responsive  

= 9.8.5 =  
* Permit multiple guest notification emails (Pro Only)  
* Fix some missing columns on reports  

= 9.8.4 =  
* Fix end date when blank in Guest Post email (Pro Only)  
* Fix CSV example link (Pro Only)  
* Set print CSS to print all QEM admin pages  

= 9.8.3 =  
* Fix dates in Guest Post email (Pro Only)  

= 9.8.2 =  
* Change registration nonce checking due to cache issues  

= 9.8.1 =  
* Fix licence levels functionality ( Pro Only )  

= 9.8.0 =  
* Add ticket number generation ( Pro Only)  
* Fix HTML in some emails  
* Add email header to stop grouping as conversations  

= 9.7.8 =  
* Fix category link on lists  
* Remove extra calendar nonce validation, not required  
* Namespace Mailchimp library to avoid conflicts ( Pro only )  

= 9.7.7 =  
* Fix JavaScript issue with lightbox  

= 9.7.6 =  
* Fix commas on blank cells in CSV  

= 9.7.5 =  
* Improve nonce checking and sanitization  

= 9.7.4 =  
* Set default sort on event edit table to event date descending  
* Add extra report options to premium reports dashboard to make finding them easier ( Pro only )  

= 9.7.3 =  
* Fix number validation  
* Restructure JS file to avoid conflicts  

= 9.7.2 =  
* Removed legacy code causing edge case error  

= 9.7.1 =  
* Updated further sanitization  

= 9.7.0 =  
* Updated escaping and sanitization and restructured legacy code to meet current wp.org guidelines  

= 9.6.5 =  
* Improve sanitization of inputs in admin settings  

= 9.6.4 =  
* Remove some warnings and fix 8.1 issue  

= 9.6.3 =  
* Add filter for CPT creation  

= 9.6.2 =  
* Fix external link issue ( Pro Only )  

= 9.6.1 =  
* Minor fix to new feature of adding option to manually add attendee via the admin interface  

= 9.6.0 =  
* Add new features cutoff time and ticket start date time ( Pro Only )  
* Keep tags on calendar title shortener so translation plugins work  
* Add option to manually add attendee via the admin interface  

= 9.5.1 =  
* Fix for 5.6 compatibility  
* Add unsupported notice if less than PHP 7.1  

= 9.5.0 =  
* Add option to change Options from checkbox to radio  
* Add ability for events to have custom Drop Downs and Options in registration forms ( Pro only )  
* Improve handling of places, enabling to set places to zero to force unavailability  
* Add option to style calendar categories to match list categories – border style  
* Allow CSV to download custom registration form fields if custom form used  
* Fix issue so attendee counts consistent between reports and plugin list  
* Allow Stripe to handle zero decimal currencies such as JPY and improve Stripe config error display to admins ( Pro Only )  
* Fix issue with repeating guest events ( Pro Only )  

= 9.4.2 =  
* Fix links to registrations  
* Add options field to CSV download  

= 9.4.1 =  
* Fix issue with multiple categories and category drop down  
* Update Freemius library  
* Update Stripe library ( Pro only )  

= 9.4.0 =  
* Add Social icons & calendar icon instead of buttons  
* Improve reports option for Event Manager role ( Pro only )  

= 9.3.11 =  
* Fix repeating event start date/time issue  
* Fix issue with start/end days in repeating events/edge case  
* Fix Calendar warning  
* Fix issue with dates on Eventbrite Integration ( Pro only )  

= 9.3.10 =  
* Fix some PHP 8.0 type errors  
* Fix issue where first attendee cannot be deleted  
* Fix timezone issues with feed to Display Eventbrite plugin ( Pro only )  
* Make merge with Display Eventbrite optional ( Pro only )  

= 9.3.9 =  
* Fix some PHP 8.0 type error issues  

= 9.3.8 =  
* Fix notice message  

= 9.3.7 =  
* Fix decoding of HTML entities in subject title of emails  

= 9.3.6 =  
* Allow multiple notification emails (Pro)  

= 9.3.5 =  
* Tweak to default sort on registration ( Pro )  

= 9.3.4 =  
* Correct deletion on sorted registration  

= 9.3.3 =  
* Change calendar ICS header  
* Add print-friendly CSS to registration report page  
* Add registration page sort options ( Pro only )  

= 9.3.2 =  
* Fix bug when editing attendees with not-attending set  

= 9.3.1 =  
* Check if role has been removed (e.g. editor role) before trying to apply capabilities  

= 9.3 =  
* Link to external Events ( Pro )  
* Integration into Display Eventbrite plugin ( Pro )  

= 9.2.18.2 =  
* Change code to remove deprecated notices PHP 8.0  

= 9.2.18.1 =  
* Added extra options to attending list (Pro only)  

= 9.2.17 =  
* Security updates  

= 9.2.16 =  
* Add clear:none CSS to event list heading for better theme compatibility  

= 9.2.15 =  
* Improve Stripe API validation ( Pro only)  
* Fix issue with empty categories ( Pro only )  

= 9.2.14 =  
* Properly localize  

= 9.2.13 =  
* Allow redirect when PayPal enabled after PayPal payment  

= 9.2.12 =  
* Fix globals issue  
* Fix sort order of registrations  
* Improve email header for registrations  

= 9.2.11 =  
* Fix pay on arrival issue  
* Combine pay on arrivals with payment data on Registration Report  
* Add payment status to CSV export ( Pro only )  

= 9.2.10 =  
* Remove Warning when no calendar icons used  
* Fix multi-name sanitization issue  

= 9.2.9 =  
* Improve stability for PHP 8.0  
* Add Date to Stripe & PayPal feed descriptions  
* If user opt-in – add opt-in message to payment records on Stripe & PayPal  

= 9.2.8 =  
* Add description to Stripe feed ( Pro Only )  
