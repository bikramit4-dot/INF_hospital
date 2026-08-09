<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;

$page_title = "International Patients";

$blocks = [
    ['id' => 'services', 'icon' => '🌍', 'title' => 'International Patient Services', 'desc' => 'A dedicated desk to assist international patients with appointment scheduling, doctor selection, medical record transfer, and coordination throughout their treatment journey.'],
    ['id' => 'packages', 'icon' => '📦', 'title' => 'Medical Packages', 'desc' => 'All-inclusive treatment packages covering consultation, surgery, hospital stay, and follow-up care, tailored for international patients seeking treatment abroad.'],
    ['id' => 'visa', 'icon' => '🛂', 'title' => 'Visa Assistance', 'desc' => 'Support with medical visa invitation letters and documentation required for entry, in coordination with local authorities.'],
    ['id' => 'travel', 'icon' => '✈️', 'title' => 'Travel Support', 'desc' => 'Assistance with flight coordination, airport pickup, and local transportation for patients and their families.'],
    ['id' => 'accommodation', 'icon' => '🏨', 'title' => 'Accommodation', 'desc' => 'Guidance on nearby hotels and guest houses offering comfortable stays for patients and accompanying family members.'],
    ['id' => 'interpreter', 'icon' => '🗣️', 'title' => 'Interpreter Services', 'desc' => 'Multilingual interpreters available to help patients communicate clearly with doctors and hospital staff.'],
    ['id' => 'insurance', 'icon' => '📄', 'title' => 'Insurance Information', 'desc' => 'Assistance in understanding coverage, processing insurance claims, and coordinating with international insurance providers.'],
];

View::render('pages/international-patients', compact('page_title', 'blocks', 'nav_menu'));