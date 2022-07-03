=== Database Cleaner and Optimizer (Built for 2022+) ===
Contributors: TigrouMeow
Tags: database, db, clean, cleaner, optimize, table, orphan, draft
Donate link: https://meowapps.com/donation/
Requires at least: 5.0
Tested up to: 6.0
Requires PHP: 7.0
Stable tag: 0.5.1

Clean and optimize your database, for real! Lot of features, handle oversized databases, built on latest WP and PHP evolutions.

== Description ==

Clean your database for real, whatever its size is, while focusing on what can make it faster. An user-friendly UI will help you to make everything perfect. If there are too many issues to delete, it will use asynchronous requests to avoid timeouts. You will more information here: [Database Cleaner on Meow Apps](https://meowapps.com/database-cleaner/).

== Features ==

There are others database cleaners on the market, but since I felt like there were rather incomplete and old, based on my experiences with modern UIs and ways of coding plugins, I had to create this new one. Here are the current features:

- The **Auto Clean** Button. It will clean everything you set on Auto in Database Cleaner. That will make your life easier, once everything is set up.
- **Clean the Usual Items**: Revisions, drafts, trash, useless metas, useless comments, useless users, transients, etc. If I missed something, let me know: I can add support for new items right away.
- **Clean your Post Types**. List your post types, and help you getting rid of data in unimportant post types such as the ones used for temporary data such as logs. Those slow down your WordPress more than anything else!
- **Clean your Tables**. Display all your tables, their sizes, and help you getting rid of the useless ones.
- **Clean your Options**. Display all your options, their sizes, and help you getting rid of the useless ones. You can also set your options as being not autoloaded.
- **Clean your Cron Jobs**. Display all your jobs, their schedules, and help you getting rid of the useless ones.

***For Post Types, Tables, Options and Cron Jobs, Database Cleaner has its own references in order to tell you by which plugins or themes they are use. For full support of this, you will need the Pro Version.***

**IMPORTANT:** Please prepare a backup of your database before using this plugin! Better be safe than sorry :)

== Why this plugin? ==

There are other similar cleaners on the market. I used them, but I always felt they were imperfect, with old UI, somehow frozen in time. There were also missing Post Types support, but I could handle this manually. At the end of 2021, I had issues with my databases (which were too big) and all those plugins simply failed; this was the last straw: I started to develop a fresh and new database cleaner plugin, with a PHP 7 base, modern concepts, and build to actually speed-up WordPress. I am now resolved to make it work for everyone, adding all the features you absolutely need.  

== Installation ==

1. Upload the plugin to WordPress.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Meow Apps -> Database Cleaner in the sidebar and check the appropriate options.
4. Click on the button to clean your database automatically.

== Screenshots ==

1. No screenshot yet.

== Changelog ==

= 0.5.1 (2022/06/24) =
* Update: My library Neko UI was improved (that will impact the UI positively).
* Info: Database Cleaner is perfectly stable now 🤟 If you have any feedback, features you miss or anything else, [contact me](https://meowapps.com/contact).
* Info: You are also welcome to leave a review [here](https://wordpress.org/support/plugin/database-cleaner/).

= 0.4.9 (2022/06/03) =
* Update: Enhanced the loading of the data of the first tab, for a smoother and nicer experience.
* Update: Additional support for other plugins.

= 0.4.7 (2022/05/25) =
* Update: Lot of little UI enhancements.
* Update: Additional support for other plugins.

= 0.4.6 (2022/05/19) =
* Fix: The handling of the _user_roles option was wrong.
* Update: Icons have been updated; the trash means some data will be removed, while the cross means the item will be entirely removed (in a case of a table, it means it will be dropped).

= 0.4.5 (2022/05/16) =
* Update: Better handling of the Used By column with support of regexp.
* Update: Little UI enhancements to avoid extra clicks.
* Fix: Retrieve better option value for the modal.

= 0.4.4 (2022/05/10) =
* Add: We can now check what is the data stored by an option.

= 0.4.3 (2022/05/03) =
* Fix: Better UI for handling the Used By.

= 0.4.2 (2022/04/29) =
* Fix: Better support for ACF and various other plugins.
* Fix: Little UI enhancements to handle the "Used By" data.

= 0.4.1 (2022/04/24) =
* Add: Support for item used by frameworks.
* Fix: Better support for Elementor.
* Update: Lot of UI enhancements. More to come next week!

= 0.3.9 (2022/04/18) =
* Fix: Removed some warnings on the PHP side which were sometimes breaking the asynchronous requests.
* Add: We can now copy/paste the whole customized data related to Used By.

= 0.3.8 (2022/04/15) =
* Add: Sort by name, size, used by, etc.
* Add: Search for name, used by, etc.
* Fix: There was an issue with the count for transients.
* Update: Better filters, improved UI.

= 0.3.7 (2022/04/13) =
* Add: User can now choose a plugin for the "Used By" column.
* Fix: Removed a few warnings and enhanced the filters.

= 0.3.6 (2022/04/10) =
* Fix: The count was wrong for Post Types.

= 0.3.4 (2022/04/08) =
* Fix: Better handling of "Used By" overrides (to make sure we get some better information about how an item is used).
* Add: Checkbox to hide the items "Used by WordPress".
* Add: Paging for Post Types, Tables.
* Fix: Statistics were not updated after Auto Clean.
* Update: Again, many UI enhancements.

= 0.3.0 (2022/04/05) =
* Update: Many UI enhancements, buttons were simplified and actions moved on the left (to make it clearer which item it is linked to), smoother busy statuses.
* Add: Autoload is now a checkbox (which we can enabled/disabled).

= 0.2.9 (2022/03/30) =
* Update: Changed the way (and filters) the items can be selected in bulk.

= 0.2.8 (2022/03/29) =
* Fix: There was some issues with deleting cron jobs.
* Fix: Little UI issues.
* Update: Possibility to select more than one item at the time.

= 0.2.7 (2022/03/22) =
* Add: Cron Tabs.

= 0.2.6 (2022/03/18) =
* Fix: The percentage was sometimes off.
* Add: Support for Meow Apps plugins.

= 0.2.5 (2022/03/15) =
* Add: Ability to see how much the DB increased or decreased over time.
* Add: Checkbox to select tables.
* Update: Improved UI.

= 0.2.4 (2022/03/11) =
* Fix: Compatibility with MariaDB.
* Add: Optimize for tables.
* Update: Better UI for Options.
* Update: UI enhancements.

= 0.2.1 (2022/03/08) =
* Add: Support for "Used By" for WordPress Core, WooCommerce, and the whole system behind it (actions, filters).
* Update: Better SQL queries.
* Update: Better UI.

= 0.1.5 (2022/03/04) =
* Add: A way to look into the data which is going to be removed.
* Add: More ways to delete in bulk.
* Fix: A few UI bugs related to refreshing.
* Update: The UI is always evolving! Better and better! (and we are not done)

= 0.1.2 (2022/02/21) =
* Update: Better buffered deletions.
* Update: Dynamicity of the UI has improved a lot.

= 0.1.1 (2022/02/15) =
* Add: Finally, support for big installs, with buffered deletions!
* Update: A bunch of fixes and enhancements.
= 0.1.0 (2022/01/26) =
* Update: Doesn't work with risk level anymore, but a simpler option.
* Update: UI improvements.

= 0.0.7 (2022/01/11) =
* Add: Logging.
* Update: More information about what the plugin is cleaning after clicking the Clean DB button.

= 0.0.6 (2021/12/20) =
* Update: Nice UI improvements.

= 0.0.5 (2021/12/14) =
* Add: Support for removing tables, and check by which plugins they are used.
* Add: Ignore status for Risk column.
* Info: Additional and various enhancements.

= 0.0.4 =
* Fix: The default Risk Treshold was too high.

= 0.0.3 =
* Update: Small improvements, tables percentages, etc.

= 0.0.2 =
* Add: Table statistics.
* Update: Improve UI (buttons, organization, etc).

= 0.0.1 =
* Info: First release.
