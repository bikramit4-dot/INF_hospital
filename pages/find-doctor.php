<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\Doctor;
use App\Models\Department;

$page_title = "Find a Doctor";

$allowed_by = ['name', 'department', 'specialty'];
$by = in_array($_GET['by'] ?? '', $allowed_by, true) ? $_GET['by'] : 'name';
$q = mb_substr(trim($_GET['q'] ?? ''), 0, 100);
$dept_filter = (int)trim($_GET['dept'] ?? '');

$results = Doctor::allWithDepartment();
if ($by === 'name' && $q !== '') {
    $results = Doctor::search('name', $q);
} elseif ($by === 'department' && $dept_filter > 0) {
    $results = Doctor::search('department', '', $dept_filter);
} elseif ($by === 'specialty' && $q !== '') {
    $results = Doctor::search('specialty', $q);
}

$departments = Department::all('id');

View::render('pages/find-doctor', compact('page_title', 'by', 'q', 'dept_filter', 'results', 'departments', 'nav_menu'));