<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\Service;

$page_title = "Our Services";
$services = Service::allActive();
View::render('pages/services', compact('page_title', 'services', 'nav_menu'));