<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;
use App\Models\Doctor;
use App\Models\HealthPackage;
use App\Models\Service;

$page_title = "Home";
$doctors = Doctor::allWithDepartment();
$health_packages = HealthPackage::allActive();
$services = Service::allActive();

View::render('pages/home', compact('page_title', 'doctors', 'health_packages', 'services', 'nav_menu'));