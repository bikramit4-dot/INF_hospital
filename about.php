<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;

$page_title = "About Us";
View::render('pages/about', compact('page_title', 'nav_menu'));