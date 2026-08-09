<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\Doctor;

$page_title = "Doctor Schedule";
$doctors = Doctor::allWithDepartment();
View::render('pages/doctor-schedule', compact('page_title', 'doctors', 'nav_menu'));