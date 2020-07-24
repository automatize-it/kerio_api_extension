<?php
/**
 * Kerio Control - Sample Application.
 *
 * STATUS: In progress, might change in the future
 *
 * This api is currently under development.
 * The api is not intended for stable use yet.
 * Functionality might not be fully verified, documented, or even supported.
 *
 * Please note that changes can be made without further notice.
 *
 * @copyright    Copyright &copy; 2012-2012 Kerio Technologies s.r.o.
 * @version		1.4.0.234
 
 * Modified by third-party. No warranty at all, use at your own risk
 * (tested, works)
 */
 
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/ControlApiHelper.php');
require_once(dirname(__FILE__) . '/../class/HtmlHelper.php');
require_once(dirname(__FILE__) . '/../../src/KerioControlApi.php');

$name = 'Example: Set blacklist ip';
$api = new KerioControlApi($name, $vendor, $version);
$apiHelper = new ControlApiHelper($api);

$html = new HtmlHelper();
$html->printHeader($name);
$html->printInfo('Create an ip blacklist rule');

$tmpip = $_GET['blstdip'];
$grp = $_GET['group'];

$grpnm = "";
$comment = "";

$tdmy = date("d M, Y"); 

//if you need to add to more than one group
if ($grp == "111"){
	
	$grpnm = "groupname1";
	$comment = "Auto-ban (SPAM) on ".$tdmy;
}

if ($grp == "222"){
	
	$grpnm = "anothergroup";
	$comment = "Auto-ban (SMTP misuse) on ".$tdmy;
}


/* Main application */
try {

	$session = $api->login($hostname, $username, $password);
	
}
catch (KerioApiException $error) {
	$html->printError($error->getMessage());
}

try {
	
	$params = array(
		"groups" => array(array(
			
			"groupId" => $grp,
			"groupName" => $grpnm,
			"host" => $tmpip,
			"type" => "Host",
			"description" => $comment,
			"enabled" => "true"
		))
	);
	
	$result = $api->sendRequest('IpAddressGroups.create', $params);
}

catch (KerioApiException $error) {
	
	$html->printError($error->getMessage());
}

try {
		
	//$paramsRaw = ',"params":{"commandList":[{"method":"IpAddressGroups.apply"},{"method":"Session.getConfigTimestamp"}]}}';
	
	//only one case so far so params are hardcoded to function
	$result = $api->sendRequestRaw();

	$ts = $result[1]['result']['clientTimestamp'];
	
	dtc($ts);	
}

catch (KerioApiException $error) {
	
	$html->printError($error->getMessage());
}

try {
	
	$params = array(
		
		"clientTimestamp" => $ts
	);
	
	$result = $api->sendRequest('Session.confirmConfig', $params);
}

catch (KerioApiException $error) {
	
	$html->printError($error->getMessage());
}

/* Logout */
if (isset($session)) {
	
	$api->logout();
	return $result;
}

$html->printFooter();
