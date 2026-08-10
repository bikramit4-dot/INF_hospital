-- ============================================================
-- Home Hospital - Complete Database Schema
-- SQLite (supports FOREIGN KEY constraints when PRAGMA is set)
-- ============================================================

-- --------------------------------------------------
-- Administrators
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS admins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Departments
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS departments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    icon TEXT NOT NULL DEFAULT '🏥',
    image_url TEXT DEFAULT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Doctors
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS doctors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    department_id INTEGER NOT NULL,
    specialty TEXT NOT NULL,
    experience TEXT NOT NULL,
    days TEXT NOT NULL,
    time_slot TEXT NOT NULL,
    photo_url TEXT DEFAULT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- Health Packages
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS health_packages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price TEXT NOT NULL,
    includes_text TEXT NOT NULL,
    is_active INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- News & Events
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS news_events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    event_date TEXT NOT NULL,
    category TEXT NOT NULL,
    excerpt TEXT NOT NULL,
    content TEXT DEFAULT NULL,
    is_published INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Services (previously hardcoded in services.php)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    slug TEXT NOT NULL UNIQUE,
    icon TEXT NOT NULL DEFAULT '🚑',
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    image_url TEXT DEFAULT NULL,
    sort_order INTEGER NOT NULL DEFAULT 0,
    is_active INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Team Members (previously hardcoded in management-team.php)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS team_members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    role TEXT NOT NULL,
    photo_url TEXT DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    sort_order INTEGER NOT NULL DEFAULT 0,
    is_active INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Patients (registered users)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS patients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    phone TEXT NOT NULL,
    password_hash TEXT DEFAULT NULL,
    date_of_birth TEXT DEFAULT NULL,
    gender TEXT DEFAULT NULL,
    address TEXT DEFAULT NULL,
    is_active INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Appointments
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS appointments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    booking_ref TEXT NOT NULL UNIQUE,
    patient_id INTEGER DEFAULT NULL,
    department_id INTEGER NOT NULL,
    doctor_id INTEGER NOT NULL,
    patient_name TEXT NOT NULL,
    patient_age INTEGER DEFAULT NULL,
    patient_gender TEXT DEFAULT NULL,
    patient_phone TEXT NOT NULL,
    patient_email TEXT DEFAULT NULL,
    appointment_date TEXT NOT NULL,
    appointment_time TEXT NOT NULL,
    reason TEXT DEFAULT NULL,
    status TEXT NOT NULL DEFAULT 'pending',
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- Contact Messages
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS contacts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    subject TEXT DEFAULT NULL,
    message TEXT NOT NULL,
    is_read INTEGER NOT NULL DEFAULT 0,
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Online Consultation Requests
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS online_consultations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER DEFAULT NULL,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT DEFAULT NULL,
    department_id INTEGER NOT NULL,
    issue TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'pending',
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- Career Applications
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS career_applications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT DEFAULT NULL,
    position TEXT NOT NULL,
    cv_path TEXT DEFAULT NULL,
    cover_letter TEXT DEFAULT NULL,
    status TEXT NOT NULL DEFAULT 'pending',
    created_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- --------------------------------------------------
-- Lab Reports
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS lab_reports (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    report_id TEXT NOT NULL UNIQUE,
    patient_id INTEGER DEFAULT NULL,
    patient_name TEXT NOT NULL,
    patient_phone TEXT NOT NULL,
    test_name TEXT NOT NULL,
    report_date TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'pending',
    notes TEXT DEFAULT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL
);

-- --------------------------------------------------
-- Lab Report Results (individual test parameters)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS lab_report_results (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lab_report_id INTEGER NOT NULL,
    parameter_name TEXT NOT NULL,
    result_value TEXT NOT NULL,
    reference_range TEXT NOT NULL,
    is_abnormal INTEGER NOT NULL DEFAULT 0,
    sort_order INTEGER NOT NULL DEFAULT 0,
    FOREIGN KEY (lab_report_id) REFERENCES lab_reports(id) ON DELETE CASCADE
);

-- --------------------------------------------------
-- Editable Page Content (managed via admin panel -> Pages)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS page_content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page TEXT NOT NULL,
    section TEXT NOT NULL,
    content TEXT,
    updated_at TEXT NOT NULL DEFAULT (datetime('now')),
    UNIQUE (page, section)
);

-- --------------------------------------------------
-- Login Attempts (for brute-force protection)
-- --------------------------------------------------
CREATE TABLE IF NOT EXISTS login_attempts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip TEXT NOT NULL,
    username TEXT NOT NULL DEFAULT '',
    attempted_at INTEGER NOT NULL,
    success INTEGER NOT NULL DEFAULT 0
);

-- --------------------------------------------------
-- Indexes for performance
-- --------------------------------------------------
CREATE INDEX IF NOT EXISTS idx_doctors_department_id ON doctors(department_id);
CREATE INDEX IF NOT EXISTS idx_appointments_doctor_id ON appointments(doctor_id);
CREATE INDEX IF NOT EXISTS idx_appointments_date ON appointments(appointment_date);
CREATE INDEX IF NOT EXISTS idx_appointments_status ON appointments(status);
CREATE INDEX IF NOT EXISTS idx_contacts_is_read ON contacts(is_read);
CREATE INDEX IF NOT EXISTS idx_online_consultations_status ON online_consultations(status);
CREATE INDEX IF NOT EXISTS idx_career_applications_status ON career_applications(status);
CREATE INDEX IF NOT EXISTS idx_lab_reports_report_id ON lab_reports(report_id);
CREATE INDEX IF NOT EXISTS idx_login_attempts_ip ON login_attempts(ip);
CREATE INDEX IF NOT EXISTS idx_login_attempts_attempted_at ON login_attempts(attempted_at);
CREATE INDEX IF NOT EXISTS idx_news_events_event_date ON news_events(event_date);
CREATE INDEX IF NOT EXISTS idx_services_slug ON services(slug);