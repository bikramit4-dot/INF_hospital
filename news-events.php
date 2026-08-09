<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;

$page_title = "News and Events";
View::render('pages/news-events', compact('page_title', 'news_events', 'nav_menu'));