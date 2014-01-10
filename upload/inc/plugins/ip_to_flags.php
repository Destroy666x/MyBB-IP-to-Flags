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

if(!defined("IN_MYBB"))
{
    die("You Cannot Access This File Directly. Please Make Sure IN_MYBB Is Defined.");
} 

$plugins->add_hook('global_start', 'ip_to_flags_global');
$plugins->add_hook('memberlist_user', 'ip_to_flags_memberlist');
$plugins->add_hook('member_profile_end', 'ip_to_flags_profile');
$plugins->add_hook("postbit", "ip_to_flags_postbit");
$plugins->add_hook("postbit_pm", "ip_to_flags_postbit");
$plugins->add_hook("postbit_announcement", "ip_to_flags_postbit");
$plugins->add_hook("postbit_prev", "ip_to_flags_postbit");
$plugins->add_hook("online_user", "ip_to_flags_whosonline");
$plugins->add_hook("admin_user_users_edit", "ip_to_flags_acp_edit");

function ip_to_flags_info() 
{
    global $lang;
	
	$lang->load("ip_to_flags_acp");
	
	$ip_to_flags_cfg = '<br />';
	$gid = ip_to_flags_settings_gid();	
	if (!empty($gid)) $ip_to_flags_cfg = '<a href="index.php?module=config&amp;action=change&amp;gid='.$gid.'">'.$lang->configuration.'</a><br /><br />'; 
	
	return array(
        "name"           => $lang->ip_to_flags,
        "description"    => $lang->ip_to_flags_info.'<br />' 
		                    . $ip_to_flags_cfg .
							'<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="ZRC6HPQ46HPVN">
                            <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Donate">
                            <img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
                            </form>',
        "website"        => "http://community.mybb.com/user-58253.html",
        "author"         => "Destroy666",
        "authorsite"     => "http://community.mybb.com/user-58253.html",
        "version"        => "1.0",
        "guid"           => "",
        "compatibility"  => "16*"
    );
}

function ip_to_flags_activate() {
    
	global $db, $lang;
	
	$lang->load("ip_to_flags_acp");
	
	require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
	find_replace_templatesets("memberlist_user", "#".preg_quote("{\$user['profilelink']}")."#i", "{\$user['profilelink']}{\$user['flag']}");
	find_replace_templatesets("member_profile", "#".preg_quote("{\$formattedname}</strong></span>")."#i", "{\$formattedname}</strong></span>{\$memprofile['flag']}");
	find_replace_templatesets("postbit", "#".preg_quote("{\$post['profilelink']}</span></strong>")."#i", "{\$post['profilelink']}</span></strong>{\$post['flag']}");
	find_replace_templatesets("postbit_classic", "#".preg_quote("{\$post['profilelink']}</span></strong>")."#i", "{\$post['profilelink']}</span></strong>{\$post['flag']}");
	find_replace_templatesets("online_row", "#".preg_quote("{\$online_name}")."#i", "{\$online_name}{\$user['flag']}");

    $ip_to_flags_settinggroup = array(
        'gid'            => "NULL",
        'name'           => "ip_to_flags",
        'title'          => $db->escape_string($lang->ip_to_flags),
        'description'    => $db->escape_string($lang->ip_to_flags_settings),
        'disporder'      => "1",
        'isdefault'      => "0",
    ); 
	
	$db->insert_query('settinggroups', $ip_to_flags_settinggroup);
    $gid = $db->insert_id(); 
	
	$d = 0;
	
	$ip_to_flags_settings[] = array(
        'sid'           => 'NULL',
        'name'          => 'ip_to_flags_method',
        'title'         => $db->escape_string($lang->ip_to_flags_matching_method),
        'description'   => $db->escape_string($lang->ip_to_flags_matching_method_desc),
        'optionscode'   => $db->escape_string('select
maxmind='.$lang->ip_to_flags_matching_method_opt1.'
pecl='.$lang->ip_to_flags_matching_method_opt2.'
geoplugin='.$lang->ip_to_flags_matching_method_opt3),
        'value'         => 'maxmind',
        'disporder'     => $d++,
        'gid'           => (int) $gid,
    );
    
	$ip_to_flags_settings[] = array(
        'sid'           => 'NULL',
        'name'          => 'ip_to_flags_whichip',
        'title'         => $db->escape_string($lang->ip_to_flags_ip_source),
        'description'   => $db->escape_string($lang->ip_to_flags_ip_source_desc),
        'optionscode'   => $db->escape_string('select
lastip='.$lang->ip_to_flags_ip_source_opt1.'
regip='.$lang->ip_to_flags_ip_source_opt2),
        'value'         => 'lastip',
        'disporder'     => $d++,
        'gid'           => (int) $gid,
    ); 
	
	$ip_to_flags_settings[] = array(
        'sid'           => 'NULL',
        'name'          => 'ip_to_flags_other',
        'title'         => $db->escape_string($lang->ip_to_flags_additional_ip),
        'description'   => $db->escape_string($lang->ip_to_flags_additional_ip_desc),
        'optionscode'   => 'yesno',
        'value'         => '1',
        'disporder'     => $d++,
        'gid'           => (int) $gid,
    );
	
	$ip_to_flags_settings[] = array(
        'sid'           => 'NULL',
        'name'          => 'ip_to_flags_disallowed',
        'title'         => $db->escape_string($lang->ip_to_flags_disallowed_gids),
        'description'   => $db->escape_string($lang->ip_to_flags_disallowed_gids_desc),
        'optionscode'   => 'text',
        'value'         => '',
        'disporder'     => $d++,
        'gid'           => (int) $gid,
    );
	
	$ip_to_flags_settings[] = array(
        'sid'           => 'NULL',
        'name'          => 'ip_to_flags_city',
        'title'         => $db->escape_string($lang->ip_to_flags_city),
        'description'   => $db->escape_string($lang->ip_to_flags_city_desc),
        'optionscode'   => 'yesno',
        'value'         => '0',
        'disporder'     => $d++,
        'gid'           => (int) $gid,
    );
	
	foreach($ip_to_flags_settings as $current_setting)
	{
        $db->insert_query('settings', $current_setting);
	}
	
	rebuild_settings();
}

function ip_to_flags_deactivate() {
    
	global $db;
	
	require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
	find_replace_templatesets("memberlist_user", "#".preg_quote("{\$user['flag']}")."#i", '', 0);
	find_replace_templatesets("member_profile", "#".preg_quote("{\$memprofile['flag']}")."#i", '', 0);
	find_replace_templatesets("postbit", "#".preg_quote("{\$post['flag']}")."#i", '', 0);
	find_replace_templatesets("postbit_classic", "#".preg_quote("{\$post['flag']}")."#i", '', 0);
	find_replace_templatesets("online_row", "#".preg_quote("{\$user['flag']}")."#i", '', 0);
	
    $db->delete_query("settings", "name LIKE ('ip\_to\_flags\_%')");
    $db->delete_query("settinggroups", "name='ip_to_flags'");
    
	rebuild_settings();
}

function ip_to_flags_settings_gid()
{
	static $settings_gid;
	global $db;

	if(isset($settings_gid)) {		
		$gid = $settings_gid;	
	} else {
		$query = $db->simple_select("settinggroups", "gid", "name='ip_to_flags'", array("order_dir" => 'DESC'));
		$gid = $db->fetch_field($query, 'gid');		
	}	
	
	return (int) $gid;
}

function ip_to_flags_global()
{
	global $mybb, $session;
	
	$mybb->user['flag'] = ip_to_flag($session->ipaddress, $mybb->user['regip']);
}

function ip_to_flags_memberlist($user)
{
    $user['flag'] = ip_to_flag($user['lastip'], $user['regip']); 

    return $user;
}

function ip_to_flags_profile()
{
    global $memprofile;
	
	$memprofile['flag'] = ip_to_flag($memprofile['lastip'], $memprofile['regip']); 
}

function ip_to_flags_postbit($post)
{
    $post['flag'] = ip_to_flag($post['lastip'], $post['regip'], $post['ipaddress']); 

    return $post;
}

function ip_to_flags_whosonline()
{
	global $user;

    $user['flag'] = ip_to_flag($user['ip']);
}

function ip_to_flags_acp_edit()
{
	global $lang, $db, $mybb;
	
	$query = $db->simple_select("users", "lastip, regip", "uid='".intval($mybb->input['uid'])."'");
	$user = $db->fetch_array($query);
	
	$lang->registration_ip .= ip_to_flag($user['regip']);
	$lang->last_known_ip .= ip_to_flag($user['lastip']);
}

function ip_to_flag($lastip, $regip = '', $otherip = '')
{
	global $mybb, $lang;
	
	if(empty($lang->ip_to_flags_unknown)) 
	{
		if(defined("IN_ADMINCP"))
		{
			$lang->load("ip_to_flags_acp");
		} else {
			$lang->load("ip_to_flags");
		}
	}
	
	if(in_array($mybb->user['usergroup'], explode(",", $mybb->settings['ip_to_flags_disallowed']))) return;
	
	$flagdir = $GLOBALS['theme']['imgdir']."/flags/";
	$dir = !empty($GLOBALS['theme']['imgdir']) && file_exists($flagdir) ? $flagdir : $mybb->settings['bburl']."/images/flags/";
	
	$unknownimg = $dir."unknown.png";
	
	if($mybb->settings['ip_to_flags_other'] && $otherip)
	{
		$whichip = $otherip;
	} else {
		$whichip = $mybb->settings['ip_to_flags_whichip'] == "lastip" || !$regip ? $lastip : $regip;
		if(empty($whichip)) return ' <img src="'.$unknownimg.'" alt="'.$lang->ip_to_flags_unknown.'" title="'.$lang->ip_to_flags_unknown.'" style="vertical-align: sub;" class="ip_to_flags" /> ';
	}

	if($mybb->settings['ip_to_flags_method'] == "maxmind")
	{
		include_once(MYBB_ROOT."maxmind_geoip/geoipcity.inc");
		include_once(MYBB_ROOT."maxmind_geoip/geoipregionvars.php");
		$gi = geoip_open(MYBB_ROOT."maxmind_geoip/GeoLiteCity.dat", GEOIP_STANDARD);
		$ip_array = geoip_record_by_addr($gi, $whichip);
		$code = $ip_array->country_code;
		$name = htmlspecialchars_uni(utf8_encode($ip_array->country_name));
		$city = htmlspecialchars_uni(utf8_encode($ip_array->city));
	} elseif($mybb->settings['ip_to_flags_method'] == "pecl") {
		if(function_exists('geoip_record_by_name'))
		{
			$ip_array = @geoip_record_by_name($whichip);
			$code = $ip_array['country_code'];
			$name = htmlspecialchars_uni(utf8_encode($ip_array['country_name']));
			$city = htmlspecialchars_uni(utf8_encode($ip_array['city']));
		} else {
		    $code = $name = $lang->ip_to_flags_no_pecl;
		}
	} else {
		$ip_array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$whichip));
		if(empty($ip_array))
		{
			$code = $name = $lang->ip_to_flags_no_geoplugin;
		} else {
			$code = $ip_array['geoplugin_countryCode'];
			$name = htmlspecialchars_uni(utf8_encode($ip_array['geoplugin_countryName']));
			$city = htmlspecialchars_uni(utf8_encode($ip_array['geoplugin_city']));
		}
	}
	
	if(!empty($code) && !empty($name))
	{
		$img = $dir.$code.".png";
		if($mybb->settings['ip_to_flags_city'] && !empty($city)) $name .= $lang->comma.$city;		
		if(@getimagesize($img))
		{
			return ' <img src="'.$img.'" alt="'.$name.'" title="'.$name.'" style="vertical-align: sub;" class="ip_to_flags" /> ';
		} else {			
			return ' <img src="'.$unknownimg.'" alt="'.$name.'" title="'.$name.'" style="vertical-align: sub;" class="ip_to_flags" /> ';
		}
	}

	return;
}
?>