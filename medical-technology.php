<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;

$page_title = "Medical Technology";
View::render('pages/medical-technology', compact('page_title', 'nav_menu'));