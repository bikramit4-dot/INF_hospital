<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;
use App\Models\TeamMember;

$page_title = "Management Team";
$team = TeamMember::allActive();
View::render('pages/management-team', compact('page_title', 'team', 'nav_menu'));