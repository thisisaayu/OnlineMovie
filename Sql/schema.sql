-- ============================================================
--  Online Movie Booking System — Database Schema
--  Tribhuvan University | CAPJ256
--  Engine: InnoDB (required for row-level locking & transactions)
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

-- ============================================================
-- 1. USERS
--    role: 'customer' = regular user, 'admin' = cinema operator
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,   -- bcrypt via password_hash()
    phone        VARCHAR(15),
    role         ENUM('customer','admin') NOT NULL DEFAULT 'customer',
    is_active    TINYINT(1)   NOT NULL DEFAULT 1,
    created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================================
-- 2. MOVIES
-- ============================================================
CREATE TABLE IF NOT EXISTS movies (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(200) NOT NULL,
    genre        VARCHAR(100),
    language     VARCHAR(50),
    duration_min INT,                     -- runtime in minutes
    rating       VARCHAR(10),             -- e.g. U/A, A, PG-13
    description  TEXT,
    poster_url   VARCHAR(255),
    status       ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================================
-- 3. HALLS
--    A hall is a physical screen/auditorium in the cinema.
-- ============================================================
CREATE TABLE IF NOT EXISTS halls (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,   -- e.g. "Hall 1", "IMAX"
    total_rows   INT          NOT NULL,
    seats_per_row INT         NOT NULL,
    status       ENUM('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB;


-- ============================================================
-- 4. SEATS
--    One row per physical seat in a hall.
--    row_label: A, B, C ...  |  seat_number: 1, 2, 3 ...
--    Together they give human-readable labels like "C4", "A12".
-- ============================================================
CREATE TABLE IF NOT EXISTS seats (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    hall_id      INT          NOT NULL,
    row_label    CHAR(2)      NOT NULL,
    seat_number  INT          NOT NULL,
    seat_type    ENUM('regular','vip') NOT NULL DEFAULT 'regular',
    UNIQUE KEY uq_seat (hall_id, row_label, seat_number),
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============================================================
-- 5. SHOWS
--    A show = a movie playing in a hall at a specific date/time.
-- ============================================================
CREATE TABLE IF NOT EXISTS shows (
    id           INT           AUTO_INCREMENT PRIMARY KEY,
    movie_id     INT           NOT NULL,
    hall_id      INT           NOT NULL,
    show_date    DATE          NOT NULL,
    show_time    TIME          NOT NULL,
    price        DECIMAL(10,2) NOT NULL,  -- base ticket price (NPR)
    status       ENUM('active','cancelled') NOT NULL DEFAULT 'active',
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (hall_id)  REFERENCES halls(id)  ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============================================================
-- 6. SHOW SEATS
--    Tracks per-seat availability FOR EACH SHOW.
--    Populated automatically when a show is created (see note).
--
--    status flow:
--      available → locked (user at checkout, 10-min window)
--      locked    → booked  (payment success)
--      locked    → available (payment fail / lock expired)
--      booked    → available (booking cancelled)
-- ============================================================
CREATE TABLE IF NOT EXISTS show_seats (
    id           INT  AUTO_INCREMENT PRIMARY KEY,
    show_id      INT  NOT NULL,
    seat_id      INT  NOT NULL,
    status       ENUM('available','locked','booked') NOT NULL DEFAULT 'available',
    UNIQUE KEY uq_show_seat (show_id, seat_id),
    FOREIGN KEY (show_id) REFERENCES shows(id)  ON DELETE CASCADE,
    FOREIGN KEY (seat_id) REFERENCES seats(id)  ON DELETE CASCADE
) ENGINE=InnoDB;

-- NOTE: When you INSERT a new show, immediately run:
--   INSERT INTO show_seats (show_id, seat_id)
--   SELECT <new_show_id>, id FROM seats WHERE hall_id = <hall_id>;
-- You can do this in your PHP shows.php admin page right after the show insert.


-- ============================================================
-- 7. SEAT LOCKS
--    Temporary lock held while a user is at the checkout step.
--    expires_at = locked_at + 10 minutes.
--    Your PHP checkout must check and delete expired rows.
-- ============================================================
CREATE TABLE IF NOT EXISTS seat_locks (
    id           INT       AUTO_INCREMENT PRIMARY KEY,
    show_id      INT       NOT NULL,
    seat_id      INT       NOT NULL,
    user_id      INT       NOT NULL,
    locked_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at   TIMESTAMP NOT NULL,
    UNIQUE KEY uq_lock (show_id, seat_id),   -- only one lock per seat per show
    FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE,
    FOREIGN KEY (seat_id) REFERENCES seats(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============================================================
-- 8. BOOKINGS
--    One booking record per transaction (can cover multiple seats).
--    reference_code is what gets emailed to the user.
-- ============================================================
CREATE TABLE IF NOT EXISTS bookings (
    id               INT           AUTO_INCREMENT PRIMARY KEY,
    user_id          INT           NOT NULL,
    show_id          INT           NOT NULL,
    reference_code   VARCHAR(20)   NOT NULL UNIQUE, -- e.g. OMBS-A3X9KL
    total_amount     DECIMAL(10,2) NOT NULL,
    status           ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
    payment_method   ENUM('esewa','khalti','cash'),
    payment_status   ENUM('unpaid','paid','refunded')        NOT NULL DEFAULT 'unpaid',
    cancelled_at     TIMESTAMP     NULL DEFAULT NULL,
    booked_at        TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (show_id)  REFERENCES shows(id)  ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============================================================
-- 9. BOOKING SEATS
--    Which seats belong to which booking (many-to-many).
-- ============================================================
CREATE TABLE IF NOT EXISTS booking_seats (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    booking_id   INT NOT NULL,
    seat_id      INT NOT NULL,
    UNIQUE KEY uq_booking_seat (booking_id, seat_id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (seat_id)    REFERENCES seats(id)    ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============================================================
-- 10. PAYMENTS
--     One payment record per booking attempt.
--     transaction_id = what eSewa/Khalti returns on success.
-- ============================================================
CREATE TABLE IF NOT EXISTS payments (
    id               INT           AUTO_INCREMENT PRIMARY KEY,
    booking_id       INT           NOT NULL,
    amount           DECIMAL(10,2) NOT NULL,
    method           ENUM('esewa','khalti','cash') NOT NULL,
    transaction_id   VARCHAR(150),               -- from payment gateway
    status           ENUM('pending','success','failed','refunded') NOT NULL DEFAULT 'pending',
    gateway_response TEXT,                        -- raw JSON from gateway (useful for debugging)
    paid_at          TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============================================================
-- SEED: default admin account
--   password = "admin123" (bcrypt hash — change in production)
-- ============================================================
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@onlinemovie.com',
 '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- "password" bcrypt
 'admin');

-- ============================================================
-- SEED: sample movie & hall (so you have something to test with)
-- ============================================================
INSERT INTO movies (title, genre, language, duration_min, rating, description, status) VALUES
('Shershaah', 'Action/Drama', 'Hindi', 135, 'U/A', 'Based on the life of Captain Vikram Batra.', 'active'),
('The Batman', 'Action/Thriller', 'English', 176, 'PG-13', 'Batman ventures into Gotham''s underworld.', 'active');

INSERT INTO halls (name, total_rows, seats_per_row, status) VALUES
('Hall 1', 8, 10, 'active'),   -- 80 seats
('Hall 2', 6, 8,  'active');   -- 48 seats

-- Seats for Hall 1 (rows A-H, seats 1-10)
INSERT INTO seats (hall_id, row_label, seat_number, seat_type)
SELECT 1, r.row_label, n.seat_number,
       IF(r.row_label IN ('A','B'), 'vip', 'regular')
FROM
    (SELECT 'A' AS row_label UNION SELECT 'B' UNION SELECT 'C' UNION SELECT 'D'
     UNION SELECT 'E' UNION SELECT 'F' UNION SELECT 'G' UNION SELECT 'H') r,
    (SELECT 1 AS seat_number UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
     UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n;

-- Seats for Hall 2 (rows A-F, seats 1-8)
INSERT INTO seats (hall_id, row_label, seat_number, seat_type)
SELECT 2, r.row_label, n.seat_number, 'regular'
FROM
    (SELECT 'A' AS row_label UNION SELECT 'B' UNION SELECT 'C'
     UNION SELECT 'D' UNION SELECT 'E' UNION SELECT 'F') r,
    (SELECT 1 AS seat_number UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
     UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8) n;

SET FOREIGN_KEY_CHECKS = 1;
