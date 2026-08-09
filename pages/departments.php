<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;

$page_title = "Departments";
View::render('pages/departments', compact('page_title', 'departments', 'nav_menu'));