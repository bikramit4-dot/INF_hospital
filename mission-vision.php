<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;

$page_title = "Mission & Vision";
View::render('pages/mission-vision', compact('page_title', 'nav_menu'));