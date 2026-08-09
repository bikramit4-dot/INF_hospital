<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;
use App\Models\HealthPackage;

$page_title = "Health Packages";
$health_packages = HealthPackage::allActive();
View::render('pages/health-packages', compact('page_title', 'health_packages', 'nav_menu'));