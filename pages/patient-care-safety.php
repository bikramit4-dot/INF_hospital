<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;

$page_title = "Patient Care & Safety";
View::render('pages/patient-care-safety', compact('page_title', 'nav_menu'));