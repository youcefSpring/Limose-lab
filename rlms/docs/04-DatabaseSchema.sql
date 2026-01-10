-- 04-DatabaseSchema.sql
-- Research Laboratory Management System (RLMS)
-- MySQL 8.0+ Database Schema
-- Character Set: utf8mb4 (support multilingue ar, fr, en)
-- Collation: utf8mb4_unicode_ci

-- ==============================================
-- 1. USERS & AUTHENTICATION
-- ==============================================

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    avatar VARCHAR(255) NULL,
    research_group VARCHAR(255) NULL,
    bio TEXT NULL,
    status ENUM('pending', 'active', 'suspended', 'banned') NOT NULL DEFAULT 'pending',
    suspended_until TIMESTAMP NULL DEFAULT NULL,
    suspension_reason TEXT NULL,
    locale VARCHAR(5) NOT NULL DEFAULT 'ar',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    INDEX idx_users_email (email),
    INDEX idx_users_status (status),
    INDEX idx_users_locale (locale)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password resets
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_password_resets_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sessions (Laravel session driver = database)
CREATE TABLE sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,

    INDEX idx_sessions_user_id (user_id),
    INDEX idx_sessions_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 2. ROLES & PERMISSIONS (Spatie Laravel Permission)
-- ==============================================

CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL DEFAULT 'web',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_role_name (name, guard_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL DEFAULT 'web',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_permission_name (name, guard_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pivot: users <-> roles
CREATE TABLE model_has_roles (
    role_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (role_id, model_id, model_type),
    INDEX idx_model_has_roles_model (model_id, model_type),

    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pivot: users <-> permissions (direct)
CREATE TABLE model_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (permission_id, model_id, model_type),
    INDEX idx_model_has_permissions_model (model_id, model_type),

    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pivot: roles <-> permissions
CREATE TABLE role_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (permission_id, role_id),

    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 3. MATERIALS & EQUIPMENT
-- ==============================================

CREATE TABLE material_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_categories_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE materials (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    quantity INT UNSIGNED NOT NULL DEFAULT 1 CHECK (quantity >= 0),
    status ENUM('available', 'maintenance', 'retired') NOT NULL DEFAULT 'available',
    location VARCHAR(255) NOT NULL,
    serial_number VARCHAR(100) NULL UNIQUE,
    purchase_date DATE NULL,
    image VARCHAR(255) NULL,
    maintenance_schedule ENUM('weekly', 'monthly', 'quarterly', 'yearly') NULL,
    last_maintenance_date DATE NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    INDEX idx_materials_status (status),
    INDEX idx_materials_category (category_id),
    INDEX idx_materials_location (location),

    FOREIGN KEY (category_id) REFERENCES material_categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 4. RESERVATIONS
-- ==============================================

CREATE TABLE reservations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    material_id BIGINT UNSIGNED NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    quantity INT UNSIGNED NOT NULL DEFAULT 1 CHECK (quantity >= 1),
    purpose VARCHAR(1000) NOT NULL,
    notes TEXT NULL,
    status ENUM('pending', 'approved', 'rejected', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
    validated_by BIGINT UNSIGNED NULL,
    validated_at TIMESTAMP NULL,
    rejection_reason TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_reservations_user (user_id),
    INDEX idx_reservations_material (material_id),
    INDEX idx_reservations_status (status),
    INDEX idx_reservations_dates (start_date, end_date),
    INDEX idx_reservations_material_status (material_id, status),

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE CASCADE,
    FOREIGN KEY (validated_by) REFERENCES users(id) ON DELETE SET NULL,

    CHECK (end_date > start_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 5. PROJECTS & RESEARCH
-- ==============================================

CREATE TABLE projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    status ENUM('active', 'completed', 'archived') NOT NULL DEFAULT 'active',
    created_by BIGINT UNSIGNED NOT NULL,
    project_type ENUM('research', 'development', 'collaboration') NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    INDEX idx_projects_status (status),
    INDEX idx_projects_created_by (created_by),
    INDEX idx_projects_dates (start_date, end_date),

    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pivot: projects <-> users (members)
CREATE TABLE project_user (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    role ENUM('owner', 'member', 'viewer') NOT NULL DEFAULT 'member',
    joined_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_project_user (project_id, user_id),
    INDEX idx_project_user_user (user_id),

    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 6. EXPERIMENTS & SUBMISSIONS
-- ==============================================

CREATE TABLE experiments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    experiment_type ENUM('report', 'data', 'publication', 'other') NOT NULL,
    experiment_date DATE NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    INDEX idx_experiments_project (project_id),
    INDEX idx_experiments_user (user_id),
    INDEX idx_experiments_date (experiment_date),

    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Files attached to experiments
CREATE TABLE experiment_files (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    experiment_id BIGINT UNSIGNED NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT UNSIGNED NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    uploaded_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_experiment_files_experiment (experiment_id),

    FOREIGN KEY (experiment_id) REFERENCES experiments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Comments on experiments
CREATE TABLE experiment_comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    experiment_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    INDEX idx_experiment_comments_experiment (experiment_id),
    INDEX idx_experiment_comments_user (user_id),
    INDEX idx_experiment_comments_parent (parent_id),

    FOREIGN KEY (experiment_id) REFERENCES experiments(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES experiment_comments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 7. EVENTS & SEMINARS
-- ==============================================

CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    capacity INT UNSIGNED NULL,
    event_type ENUM('public', 'private') NOT NULL DEFAULT 'public',
    target_roles JSON NULL,
    image VARCHAR(255) NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    cancelled_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    INDEX idx_events_date (event_date),
    INDEX idx_events_type (event_type),
    INDEX idx_events_created_by (created_by),

    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event attendees (RSVP)
CREATE TABLE event_attendees (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    status ENUM('confirmed', 'cancelled') NOT NULL DEFAULT 'confirmed',
    registered_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_event_user (event_id, user_id),
    INDEX idx_event_attendees_user (user_id),
    INDEX idx_event_attendees_status (status),

    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 8. MAINTENANCE LOGS
-- ==============================================

CREATE TABLE maintenance_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    material_id BIGINT UNSIGNED NOT NULL,
    technician_id BIGINT UNSIGNED NOT NULL,
    maintenance_type ENUM('preventive', 'corrective', 'inspection') NOT NULL,
    description TEXT NOT NULL,
    scheduled_date DATE NOT NULL,
    completed_date DATE NULL,
    cost DECIMAL(10, 2) NULL CHECK (cost >= 0),
    notes TEXT NULL,
    status ENUM('scheduled', 'in_progress', 'completed') NOT NULL DEFAULT 'scheduled',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_maintenance_logs_material (material_id),
    INDEX idx_maintenance_logs_technician (technician_id),
    INDEX idx_maintenance_logs_status (status),
    INDEX idx_maintenance_logs_dates (scheduled_date, completed_date),

    FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE CASCADE,
    FOREIGN KEY (technician_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 9. NOTIFICATIONS
-- ==============================================

CREATE TABLE notifications (
    id CHAR(36) NOT NULL PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data TEXT NOT NULL,
    read_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_notifications_notifiable (notifiable_type, notifiable_id),
    INDEX idx_notifications_read (read_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 10. ACTIVITY LOGS (Optional - Laravel Activity Log)
-- ==============================================

CREATE TABLE activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_name VARCHAR(255) NULL,
    description TEXT NOT NULL,
    subject_type VARCHAR(255) NULL,
    event VARCHAR(255) NULL,
    subject_id BIGINT UNSIGNED NULL,
    causer_type VARCHAR(255) NULL,
    causer_id BIGINT UNSIGNED NULL,
    properties JSON NULL,
    batch_uuid CHAR(36) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_activity_log_subject (subject_type, subject_id),
    INDEX idx_activity_log_causer (causer_type, causer_id),
    INDEX idx_activity_log_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 11. JOBS & QUEUE (Laravel Queue)
-- ==============================================

CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,

    INDEX idx_jobs_queue (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job_batches (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_failed_jobs_uuid (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 12. CACHE (Laravel Cache)
-- ==============================================

CREATE TABLE cache (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL,

    INDEX idx_cache_expiration (expiration)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache_locks (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================
-- 13. INITIAL DATA SEEDING
-- ==============================================

-- Insert default roles
INSERT INTO roles (name, guard_name) VALUES
    ('admin', 'web'),
    ('material_manager', 'web'),
    ('researcher', 'web'),
    ('phd_student', 'web'),
    ('partial_researcher', 'web'),
    ('technician', 'web'),
    ('guest', 'web');

-- Insert default permissions
INSERT INTO permissions (name, guard_name) VALUES
    ('manage-users', 'web'),
    ('approve-users', 'web'),
    ('manage-materials', 'web'),
    ('view-materials', 'web'),
    ('create-reservations', 'web'),
    ('approve-reservations', 'web'),
    ('manage-projects', 'web'),
    ('view-projects', 'web'),
    ('submit-experiments', 'web'),
    ('manage-events', 'web'),
    ('view-events', 'web'),
    ('rsvp-events', 'web'),
    ('view-reports', 'web'),
    ('export-reports', 'web'),
    ('manage-maintenance', 'web'),
    ('view-maintenance', 'web');

-- Assign permissions to admin role (full access)
INSERT INTO role_has_permissions (role_id, permission_id)
SELECT
    (SELECT id FROM roles WHERE name = 'admin'),
    id
FROM permissions;

-- Assign permissions to material_manager role
INSERT INTO role_has_permissions (role_id, permission_id)
SELECT
    (SELECT id FROM roles WHERE name = 'material_manager'),
    id
FROM permissions
WHERE name IN (
    'view-materials',
    'manage-materials',
    'approve-reservations',
    'view-projects',
    'view-maintenance',
    'manage-maintenance'
);

-- Assign permissions to researcher role
INSERT INTO role_has_permissions (role_id, permission_id)
SELECT
    (SELECT id FROM roles WHERE name = 'researcher'),
    id
FROM permissions
WHERE name IN (
    'view-materials',
    'create-reservations',
    'manage-projects',
    'view-projects',
    'submit-experiments',
    'view-events',
    'rsvp-events',
    'view-reports'
);

-- Assign permissions to phd_student role (similar to researcher)
INSERT INTO role_has_permissions (role_id, permission_id)
SELECT
    (SELECT id FROM roles WHERE name = 'phd_student'),
    id
FROM permissions
WHERE name IN (
    'view-materials',
    'create-reservations',
    'view-projects',
    'submit-experiments',
    'view-events',
    'rsvp-events'
);

-- Assign permissions to technician role
INSERT INTO role_has_permissions (role_id, permission_id)
SELECT
    (SELECT id FROM roles WHERE name = 'technician'),
    id
FROM permissions
WHERE name IN (
    'view-materials',
    'manage-materials',
    'view-maintenance',
    'manage-maintenance',
    'view-events'
);

-- Insert default material categories
INSERT INTO material_categories (name, description) VALUES
    ('Microscopes', 'Microscopes optiques et électroniques'),
    ('Centrifugeuses', 'Équipements de centrifugation'),
    ('Spectromètres', 'Appareils de spectroscopie'),
    ('Équipements de sécurité', 'EPI et matériel de sécurité'),
    ('Verrerie', 'Verrerie de laboratoire'),
    ('Ordinateurs', 'Matériel informatique'),
    ('Logiciels', 'Licences logicielles'),
    ('Chimie', 'Réactifs et produits chimiques'),
    ('Biologie', 'Matériel et équipements biologiques'),
    ('Physique', 'Équipements de physique');

-- ==============================================
-- END OF SCHEMA
-- ==============================================
