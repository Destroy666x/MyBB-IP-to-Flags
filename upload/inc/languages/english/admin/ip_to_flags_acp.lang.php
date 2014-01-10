<?php

/*
Name: IP to Flags 
Author: Destroy666
Version: 1.0
Info: Plugin for MyBB forum software, coded for versions 1.6.x (may also work in 1.8.x/1.4.x)
0 new templates, 5 template edits, 5 new settings
Released under Creative Commons Attribution-ShareAlike 3.0 Unported license: 
http://creativecommons.org/licenses/by-sa/3.0/
Support/bug reports: official MyBB forum http://community.mybb.com/ or my github https://github.com/Destroy666x

© 2014 - date("Y")

This product includes GeoLite data created by MaxMind, available from
<a href="http://www.maxmind.com">http://www.maxmind.com</a>. 
*/

$l['ip_to_flags'] = "IP to Flags";
$l['ip_to_flags_info'] = "Shows flags based on IP in several places: postbit, memberlist, profile, who's online, ACP edit user, globally (need to add \$mybb->user['flag'] manually to templates).";

$l['ip_to_flags_settings'] = "Settings For IP to Flags Plugin";
$l['ip_to_flags_matching_method'] = "Matching Method";
$l['ip_to_flags_matching_method_desc'] = "How should be the IP matched?";
$l['ip_to_flags_matching_method_opt1'] = "MaxMind .dat file (requires maxmind_geoip folder)";
$l['ip_to_flags_matching_method_opt2'] = "PHP PECL (requires PECL geoip extension)";
$l['ip_to_flags_matching_method_opt3'] = "geoplugin.net (site should be available)";
$l['ip_to_flags_ip_source'] = "IP Source";
$l['ip_to_flags_ip_source_desc'] = "On which IP should be the flags based?
<br />Note: it doesn't apply to Who's Online and ACP.";
$l['ip_to_flags_ip_source_opt1'] = "Last visit IP";
$l['ip_to_flags_ip_source_opt2'] = "Registration IP";
$l['ip_to_flags_additional_ip'] = "Use Additional IP";
$l['ip_to_flags_additional_ip_desc'] = "Should additional IP be used if it's provided? (for example post IP) 
<br />Note: it will override previous setting.";
$l['ip_to_flags_disallowed_gids'] = "Disallowed Groups";
$l['ip_to_flags_disallowed_gids_desc'] = "Comma separated list of group IDs which shouldn't see flags. If blank, everyone will be able to see flags.";
$l['ip_to_flags_city'] = "City in Title";
$l['ip_to_flags_city_desc'] = "Should city be shown in flags' titles? (may be inaccurate or unavailable)";

$l['ip_to_flags_unknown'] = "Unknown";
$l['ip_to_flags_no_pecl'] = "No PECL geoip extension installed.\nChanging IP matching method in settings is recommended.";
$l['ip_to_flags_no_geoplugin'] = "geoplugin.net is currently unavailable.\nChanging IP matching method in settings is recommended.";

?>