-- ============================================================
-- Home Hospital - MySQL / MariaDB Schema + Seed Data
--
-- Compatible with: MySQL 5.7+ / 8.0, MariaDB 10.3+
-- Import this file in phpMyAdmin (Import tab). It creates the
-- database itself, so you do NOT need to select one first.
-- Re-importing: existing tables are NOT overwritten (IF NOT EXISTS),
-- but the seed rows would cause duplicate-key errors — drop the
-- tables first if you want a clean re-seed.
-- ============================================================

CREATE DATABASE IF NOT EXISTS hospital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hospital;
SET NAMES utf8mb4;

-- --------------------------------------------------
-- Administrators
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS admins (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_admins_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Departments
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS departments (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(20) NOT NULL DEFAULT '🏥',
    image_url VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Doctors
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS doctors (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    department_id INT NOT NULL,
    specialty VARCHAR(150) NOT NULL,
    experience VARCHAR(50) NOT NULL,
    days VARCHAR(100) NOT NULL,
    time_slot VARCHAR(100) NOT NULL,
    photo_url VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_doctors_department_id (department_id),
    CONSTRAINT fk_doctors_department FOREIGN KEY (department_id)
        REFERENCES departments (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Health Packages
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS health_packages (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    price VARCHAR(50) NOT NULL,
    includes_text TEXT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- News & Events
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS news_events (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    event_date DATE NOT NULL,
    category VARCHAR(100) NOT NULL,
    excerpt TEXT NOT NULL,
    content TEXT DEFAULT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_news_events_event_date (event_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Services
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
    id INT NOT NULL AUTO_INCREMENT,
    slug VARCHAR(100) NOT NULL,
    icon VARCHAR(20) NOT NULL DEFAULT '🚑',
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_services_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Team Members
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS team_members (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    role VARCHAR(150) NOT NULL,
    photo_url VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Patients (registered users)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS patients (
    id INT NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    password_hash VARCHAR(255) DEFAULT NULL,
    date_of_birth DATE DEFAULT NULL,
    gender VARCHAR(20) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_patients_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Appointments
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS appointments (
    id INT NOT NULL AUTO_INCREMENT,
    booking_ref VARCHAR(30) NOT NULL,
    patient_id INT DEFAULT NULL,
    department_id INT NOT NULL,
    doctor_id INT NOT NULL,
    patient_name VARCHAR(150) NOT NULL,
    patient_age INT DEFAULT NULL,
    patient_gender VARCHAR(20) DEFAULT NULL,
    patient_phone VARCHAR(30) NOT NULL,
    patient_email VARCHAR(150) DEFAULT NULL,
    appointment_date DATE NOT NULL,
    appointment_time VARCHAR(50) NOT NULL,
    reason TEXT DEFAULT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_appointments_booking_ref (booking_ref),
    KEY idx_appointments_date (appointment_date),
    KEY idx_appointments_status (status),
    CONSTRAINT fk_appointments_patient FOREIGN KEY (patient_id)
        REFERENCES patients (id) ON DELETE SET NULL,
    CONSTRAINT fk_appointments_department FOREIGN KEY (department_id)
        REFERENCES departments (id) ON DELETE CASCADE,
    CONSTRAINT fk_appointments_doctor FOREIGN KEY (doctor_id)
        REFERENCES doctors (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Contact Messages
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS contacts (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200) DEFAULT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_contacts_is_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Online Consultation Requests
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS online_consultations (
    id INT NOT NULL AUTO_INCREMENT,
    patient_id INT DEFAULT NULL,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    department_id INT NOT NULL,
    issue TEXT NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_consultations_status (status),
    CONSTRAINT fk_consultations_patient FOREIGN KEY (patient_id)
        REFERENCES patients (id) ON DELETE SET NULL,
    CONSTRAINT fk_consultations_department FOREIGN KEY (department_id)
        REFERENCES departments (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Career Applications
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS career_applications (
    id INT NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    position VARCHAR(150) NOT NULL,
    cv_path VARCHAR(255) DEFAULT NULL,
    cover_letter TEXT DEFAULT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_applications_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Lab Reports
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS lab_reports (
    id INT NOT NULL AUTO_INCREMENT,
    report_id VARCHAR(50) NOT NULL,
    patient_id INT DEFAULT NULL,
    patient_name VARCHAR(150) NOT NULL,
    patient_phone VARCHAR(30) NOT NULL,
    test_name VARCHAR(150) NOT NULL,
    report_date DATE NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    notes TEXT DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_lab_reports_report_id (report_id),
    CONSTRAINT fk_lab_reports_patient FOREIGN KEY (patient_id)
        REFERENCES patients (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Lab Report Results
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS lab_report_results (
    id INT NOT NULL AUTO_INCREMENT,
    lab_report_id INT NOT NULL,
    parameter_name VARCHAR(150) NOT NULL,
    result_value VARCHAR(100) NOT NULL,
    reference_range VARCHAR(150) NOT NULL,
    is_abnormal TINYINT(1) NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    CONSTRAINT fk_results_lab_report FOREIGN KEY (lab_report_id)
        REFERENCES lab_reports (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Login Attempts (brute-force protection)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT NOT NULL AUTO_INCREMENT,
    ip VARCHAR(45) NOT NULL,
    username VARCHAR(100) NOT NULL DEFAULT '',
    attempted_at INT NOT NULL,
    success TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_login_attempts_ip (ip),
    KEY idx_login_attempts_attempted_at (attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------
-- Editable Page Content (managed via admin panel -> Pages)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS page_content (
    id INT NOT NULL AUTO_INCREMENT,
    page VARCHAR(60) NOT NULL,
    section VARCHAR(60) NOT NULL,
    content TEXT,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_page_content_page_section (page, section)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SEED DATA
-- ============================================================

-- Default admin. Password: ChangeMe@2026!
-- CHANGE THIS IMMEDIATELY after first login (admin panel -> Change Password).
-- When you run `php database/migrate.php` instead, a random password is
-- generated automatically and saved to storage/admin-password.txt.
INSERT INTO admins (username, password_hash) VALUES
('admin', '$2y$12$7KgXsyUcHU9Jsj7Z//Ly4uK6vtfngsmc4oxN9SSmSCpcmdNX0eNAG');

INSERT INTO departments (name, description, icon) VALUES
('Cardiology', 'Comprehensive heart care including diagnostics, angiography and cardiac surgery.', '💚'),
('Neurology', 'Treatment of brain, spine and nervous system disorders.', '🧠'),
('Orthopedics', 'Bone, joint and muscle care including trauma and joint replacement.', '🦴'),
('Pediatrics', 'Specialized healthcare for infants, children and adolescents.', '👶'),
('Gynecology', 'Women''s health services including pregnancy care and reproductive health.', '👩'),
('Dermatology', 'Diagnosis and treatment of skin, hair and nail conditions.', '🔬'),
('Ophthalmology', 'Eye care services including vision testing and surgical treatments.', '👁️'),
('ENT', 'Ear, Nose and Throat specialist care for adults and children.', '👂');

INSERT INTO doctors (name, department_id, specialty, experience, days, time_slot, photo_url) VALUES
('Dr. Anisha Sharma', 1, 'Interventional Cardiologist', '15 years', 'Sun - Thu', '10:00 AM - 2:00 PM', NULL),
('Dr. Bikash Thapa', 2, 'Neurophysiologist', '12 years', 'Mon - Fri', '11:00 AM - 3:00 PM', NULL),
('Dr. Priya Gurung', 3, 'Joint Replacement Surgeon', '10 years', 'Sun - Fri', '9:00 AM - 1:00 PM', 'images/doctors/priya-gurung.jpg'),
('Dr. Sagar Adhikari', 4, 'Pediatrician', '8 years', 'Sun - Thu', '10:00 AM - 2:00 PM', 'images/doctors/sagar-adhikari.jpg'),
('Dr. Mamta Dhakal', 5, 'Obstetrician & Gynecologist', '14 years', 'Mon - Fri', '9:00 AM - 1:00 PM', 'images/doctors/mamta-dhakal.jpg'),
('Dr. Rajesh Poudel', 6, 'Dermatologist', '9 years', 'Sun - Thu', '1:00 PM - 5:00 PM', 'images/doctors/rajesh-poudel.jpg'),
('Dr. Sneha Karki', 7, 'Ophthalmologist', '11 years', 'Mon - Fri', '10:00 AM - 2:00 PM', 'images/doctors/sneha-karki.jpg'),
('Dr. Arun Bastola', 8, 'ENT Specialist', '13 years', 'Sun - Fri', '10:00 AM - 3:00 PM', NULL);

INSERT INTO health_packages (name, price, includes_text) VALUES
('Basic Health Checkup', 'NPR 2,500', 'CBC, Blood Sugar, Urine Routine, BMI, Physician Consultation'),
('Executive Health Checkup', 'NPR 7,500', 'Full Body Checkup, Lipid Profile, LFT, KFT, ECG, X-Ray, USG Abdomen'),
('Cardiac Health Package', 'NPR 6,000', 'ECG, 2D Echo, Lipid Profile, Cardiology Consultation'),
('Full Body Checkup', 'NPR 12,000', 'All Executive tests + CT Scan, Stress Test, Nutrition Counseling'),
('Diabetes Care Package', 'NPR 3,500', 'FBS, HbA1c, Lipid Profile, Kidney Function Test, Diet Consultation');

INSERT INTO news_events (title, event_date, category, excerpt) VALUES
('Free Health Camp in Pokhara', '2026-08-15', 'Health Campaign', 'Home Hospital organizes a free general health checkup camp for the local community.'),
('New Cardiac Catheterization Lab Inaugurated', '2026-07-20', 'Hospital News', 'State-of-the-art cath lab now operational for advanced cardiac diagnostics and treatment.'),
('Community Health Awareness Program', '2026-09-10', 'Health Campaign', 'Monthly health awareness session on diabetes management and prevention.'),
('New MRI Machine Installed', '2026-06-15', 'Hospital News', 'Latest 3T MRI scanner installed for high-resolution diagnostic imaging.');

INSERT INTO services (slug, icon, title, description, image_url, sort_order) VALUES
('emergency', '🚑', 'Emergency Services', 'Our Emergency Department operates 24/7, staffed with trained emergency physicians, nurses, and support staff ready to handle trauma, cardiac events, and other critical conditions. Equipped with rapid triage, resuscitation bays, and a dedicated ambulance fleet.', 'images/services/emergency.jpg', 1),
('opd', '🩺', 'Outpatient Services (OPD)', 'Our OPD offers consultations across all major specialties including cardiology, orthopedics, pediatrics, gynecology, and more — with convenient scheduling and minimal wait times.', 'images/services/opd.jpg', 2),
('ipd', '🛏️', 'Inpatient Services (IPD)', 'Comfortable, well-equipped patient rooms with round-the-clock nursing care, monitored recovery, and coordinated treatment plans for admitted patients.', 'images/services/ipd.jpg', 3),
('pharmacy', '💊', 'Pharmacy', 'Our in-house pharmacy is stocked with a wide range of medications, open 24/7, ensuring patients have quick access to prescribed treatments.', 'images/services/pharmacy.jpg', 4),
('diagnostic', '🧪', 'Diagnostic Services', 'Comprehensive diagnostic services including blood tests, imaging, cardiac diagnostics, and specialized screenings — all under one roof.', 'images/services/diagnostic.jpg', 5),
('laboratory', '🔬', 'Laboratory Services', 'State-of-the-art laboratory offering fast, accurate testing with results accessible online through our Lab Report portal.', 'images/services/laboratory.jpg', 6),
('radiology', '📷', 'Radiology & Imaging', 'Advanced imaging services including X-ray, ultrasound, CT scan, and MRI, interpreted by experienced radiologists.', 'images/services/radiology.jpg', 7),
('ambulance', '🚐', 'Ambulance Services', 'Fully-equipped ambulances with trained paramedics available 24/7 for emergency transport and inter-facility transfers.', 'images/services/ambulance.jpg', 8),
('preventive', '🛡️', 'Preventive Healthcare', 'Health checkup packages, vaccination programs, and wellness screenings designed to detect and prevent illness early.', 'images/services/preventive.jpg', 9),
('patient-rooms', '🏨', 'Patient Rooms', 'A range of room categories — general wards, semi-private, private, and deluxe suites — designed for patient comfort and privacy during recovery.', 'images/services/patient-rooms.jpg', 10);

INSERT INTO team_members (name, role, sort_order) VALUES
('Mr. Deepak Shrestha', 'Chief Executive Officer', 1),
('Dr. Anisha Sharma', 'Chief Medical Director', 2),
('Ms. Kabita Poudel', 'Director of Nursing', 3),
('Mr. Rohan Karki', 'Chief Financial Officer', 4),
('Ms. Sarita Bhandari', 'Head of Human Resources', 5),
('Mr. Prakash Neupane', 'Head of Administration', 6);

INSERT INTO lab_reports (report_id, patient_name, patient_phone, test_name, report_date, status) VALUES
('HH-LAB-1001', 'Ramesh Bhandari', '9800000001', 'Complete Blood Count (CBC)', '2026-07-20', 'Verified'),
('HH-LAB-1002', 'Sita Gurung', '9800000002', 'Lipid Profile', '2026-07-25', 'Verified'),
('HH-LAB-0998', 'Hari Sharma', '9800000003', 'Liver Function Test', '2026-06-10', 'Verified');

INSERT INTO lab_report_results (lab_report_id, parameter_name, result_value, reference_range, is_abnormal, sort_order) VALUES
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-1001'), 'Hemoglobin', '14.2 g/dL', '13.5 - 17.5 g/dL', 0, 1),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-1001'), 'WBC Count', '7,200 /µL', '4,500 - 11,000 /µL', 0, 2),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-1001'), 'Platelet Count', '250,000 /µL', '150,000 - 450,000 /µL', 0, 3),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-1002'), 'Total Cholesterol', '185 mg/dL', '< 200 mg/dL', 0, 1),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-1002'), 'LDL', '110 mg/dL', '< 130 mg/dL', 0, 2),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-1002'), 'HDL', '48 mg/dL', '> 40 mg/dL', 0, 3),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-0998'), 'ALT (SGPT)', '32 U/L', '10 - 40 U/L', 0, 1),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-0998'), 'AST (SGOT)', '28 U/L', '10 - 40 U/L', 0, 2),
((SELECT id FROM lab_reports WHERE report_id = 'HH-LAB-0998'), 'Alkaline Phosphatase', '85 U/L', '44 - 147 U/L', 0, 3);
