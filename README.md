Name: IP to Flags 
Author: Destroy666
Version: 1.0
Info: Plugin for MyBB forum software, coded for versions 1.6.x (may also work in 1.8.x/1.4.x)
It adds flags based on registration/last visit/additional IP to several places - postbit, memberlist, profile, who's online, ACP edit user, globally (need to add manually).
0 new templates, 5 template edits, 5 new settings
Released under Creative Commons Attribution-ShareAlike 3.0 Unported license: 
http://creativecommons.org/licenses/by-sa/3.0/

© 2014 - date("Y")

Support/bug reports: official MyBB forum http://community.mybb.com/ or my github https://github.com/Destroy666x

Changelog:
1.0 - initial release

Installation:
1. Upload everything from upload folder to your forum root (where index.php, forumdisplay.php etc. are).
2. Activate plugin in ACP -> Configuration -> Plugins.
3. Click Configuration to edit settings.

Templates troubleshooting:
Globally - add {$mybb->user['flag']} to any template
Memberlist - edit memberlist_user template - add {$user['flag']}
Profile - edit member_profile template - add {$memprofile['flag']}
Postbit - edit postbit and/or postbit_classic template(s) - add {$post['flag']}
Who's Online - edit online_row template - add {$user['flag']}

NOTE: You can add flag images for specific themes by creating flags folder in theme directory. If there is no folder, it will use default images/flags.

This product includes GeoLite data created by MaxMind, available from
<a href="http://www.maxmind.com">http://www.maxmind.com</a>. 

Flag icons in package made by:
Copyright (c) 2013 Go Squared Ltd. http://www.gosquared.com/

You can download any other icons which use ISO 3166-1 alpha-2 country codes, for example:
http://www.famfamfam.com/lab/icons/flags/