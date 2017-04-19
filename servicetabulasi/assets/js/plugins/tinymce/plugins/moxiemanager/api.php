<?php
$action = isset($_GET['action'])?$_GET['action']:'';
switch ($action) {
	case 'language':
		echo 'test';
	break;
}
?>