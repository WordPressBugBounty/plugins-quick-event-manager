=== Quick Event Manager ===
Contributors: Fullworks
Tags: event manager, calendar, events, event booking, event calendar
Tested up to: 6.7
Stable tag: 9.12.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Type: freemium

Simple event manager. No messing about, just add events and a shortcode and the plugin does the rest for you.


== Description ==

A quick and easy to use event creator. Just add new events and publish. The shortcode lists all the events. The settings pages let you select how you want the event displayed.

= Features =

*   Event posts created from your dashboard
*   Loads of layout and styling options
*   Show events as a list or a calendar
*   Built in event registration form
*   Accepts payments and IPN
*   Download events to your calendar
*   Download attendee report to email/CSV
*   Event maps with Google Maps
*   Widgets and lots of shortcode options

= Developers plugin page =

[Quick Event Manager](https://fullworksplugins.com/products/quick-event-manager/).

= Pro Version =
lots of additional features
* Stripe payments
* Mailchimp Integration
* Event Imports
* Additional reports
* Guest Events, allow visitors to create their own events
* Use variable donation amounts for event pricing
* Allow discount coupons, overall or per event
* Link to Events ticketed elsewhere e.g. Eventbrite, Ticket Tailor, Ticket Master, Zoom Events, Facebook Events, Eventbee etc, so you can have a mixture with your own QEM events
* Merge QEM events into Eventbrite events and display through [Display Eventbrite Events Plugin](https://fullworksplugins.com/products/quick-event-manager/).
* Set time of registration ending
* Set date and time that registration opens
* Premium support

= Demo Pages =

[Event list](https://fullworksplugins.com/docs/quick-event-manager/demos-quick-event-manager/event-list-demo/).
[Calendar](https://fullworksplugins.com/docs/quick-event-manager/demos-quick-event-manager/event-calendar-demo/).
[Guest Events](https://fullworksplugins.com/docs/quick-event-manager/demos-quick-event-manager/).


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
= 9.12.1 =
* Update libraries

= 9.12 =
* Improve Display Eventbrite integration ( Pro only )

= 9.11.2 =
* Add extra field to integration with Display Eventbrite ( Pro only )

= 9.11.1 =
* update Stripe library ( Pro only )

= 9.11 =
* fix to the auto option ( Pro Only )
* better handling of free when installing pro

= 9.10.1 =
* update sStripe library ( Pro only )

= 9.10 =
* add option for calendar to auto start on first future month when there is an event ( Pro only )

= 9.9.10 =
* Fix broken images

= 9.9.9 =
* further fix to post IPN processing

= 9.9.8 =
* fix issue with php 8.2 cutoff date

= 9.9.7 =
* fix missing image issue

= 9.9.6 =
* update Italian translations

= 9.9.5 =
* Fix post PayPal IPN message when variable tickets used
* Fix date in cutoff date message


= 9.9.4 =
* Fix issue with admin notification on PayPal IPN

= 9.9.3 =
* Enable submit to work on multiple forms on same page

= 9.9.2 =
* Ensure string cost is converted properly to avoid possibility of issues on PHP8.+

= 9.9.1 =
* improve settings description

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
* remove attempt to load missing un-needed files

= 9.8.5.8 =
* check for not null freemius when detecting plugin already installed

= 9.8.5.7 =
* Javascript fix for incompatible themes
* Fix for 8.1 compatability

= 9.8.5.6 =
* Fix pay later logic
* Add notification if a user re registers for a pending payment

= 9.8.5.5 =
* Fix pay later thank you


= 9.8.5.4 =
* Improve data feed to Display Eventbrite plugin ( Pro Only )
* Fix rounding on Stripe prices ( Pro Only )

= 9.8.5.3 =
* Allow html in payment auto responder

= 9.8.5.2 =
* Fix registration form not showing

= 9.8.5.1 =
* Fix individual email sending and sort into date (Pro Only)
* Fix missing form preview
* Make popup responsive

= 9.8.5 =
* Permit multiple guest notification emails (Pro Only)
* Fix some missing columns on reports
* set print css to print all qem admin pages





[Full Change History](https://plugins.trac.wordpress.org/browser/quick-event-manager/trunk/changelog.txt)