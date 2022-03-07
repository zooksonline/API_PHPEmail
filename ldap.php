<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$json = json_decode(file_get_contents('php://input'), true);

// // production
// if ($json) {
// 	$user_login = $json['buasri_id'];
// 	$user_password = $json['password'];
// 	$ldaprdn = "uid={$user_login},dc=swu,dc=ac,dc=th";
// 	$ldapconn = ldap_connect("ldap://ldap.swu.ac.th") or die ("Could not connect to LDAP server.");

// 	if ($ldapconn) {
// 		$ldapbind = ldap_bind($ldapconn, $ldaprdn, $user_password);
// 		if ($ldapbind) {
// 			$output = 
// 					[
// 					"Result" => true

// 					];
// 			echo json_encode($output);
// 		} else {
// 			 echo json_encode([ "Result" => false ]);
// 		}
// 	}
// }else{
// 		echo json_encode([ "Result" => false ]);
// }

// สำหรับ dep
if ($json) {
	echo json_encode(["Result" => true]);
}else{
	echo json_encode([ "Result" => false ]);
}
