<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;

$page_title = "Research & Education";
View::render('pages/research-education', compact('page_title', 'nav_menu'));