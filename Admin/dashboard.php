<?php
$pageTitle = 'Dashboard';
include '../includes/header.php';
include '../includes/db.php';
include '../includes/auth.php';
requireAdmin();

// ── Placeholder stats ─────────────────────────────────────
// TODO: replace each with a real DB query, e.g.:
// $total_movies = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM movies WHERE status='active'"))['c'];

$stats = [
    'movies'   => 12,
    'shows'    => 34,
    'bookings' => 210,
    'users'    => 87,
    'revenue'  => 52500,
];

// ── Placeholder recent bookings ───────────────────────────
// TODO: replace with:
// $result = mysqli_query($conn, "
//     SELECT b.reference_code, u.name AS user_name, m.title AS movie,
//            b.total_amount, b.status, b.booked_at
//     FROM bookings b
//     JOIN users u  ON b.user_id  = u.id
//     JOIN shows s  ON b.show_id  = s.id
//     JOIN movies m ON s.movie_id = m.id
//     ORDER BY b.booked_at DESC LIMIT 10
// ");

$recent_bookings = [
    ['reference_code' => 'OMBS-A3X9K', 'user_name' => 'Ram Sharma',    'movie' => 'Shershaah',  'total_amount' => 800,  'status' => 'confirmed', 'booked_at' => '2025-06-01 14:32'],
    ['reference_code' => 'OMBS-B7YQ2', 'user_name' => 'Sita Thapa',    'movie' => 'The Batman',  'total_amount' => 1200, 'status' => 'confirmed', 'booked_at' => '2025-06-01 13:10'],
    ['reference_code' => 'OMBS-C2ZP5', 'user_name' => 'Hari Adhikari', 'movie' => 'RRR',         'total_amount' => 600,  'status' => 'cancelled', 'booked_at' => '2025-05-31 18:45'],
    ['reference_code' => 'OMBS-D4WR8', 'user_name' => 'Gita Karki',    'movie' => 'Shershaah',  'total_amount' => 400,  'status' => 'pending',   'booked_at' => '2025-05-31 11:20'],
];
?>

<div class="admin-layout">

    <?php include '../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <!-- Page header -->
        <div class="d-flex justify-between align-center mb-4">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Overview of your cinema system</p>
            </div>
            <a href="<?= $base ?>/admin/movies.php" class="btn btn-primary">+ Add Movie</a>
        </div>

        <!-- Stat cards -->
        <div class="stats-grid">

            <div class="stat-card">
                <p class="stat-label">Active Movies</p>
                <p class="stat-value stat-accent"><?= $stats['movies'] ?></p>
            </div>

            <div class="stat-card">
                <p class="stat-label">Total Shows</p>
                <p class="stat-value stat-amber"><?= $stats['shows'] ?></p>
            </div>

            <div class="stat-card">
                <p class="stat-label">Total Bookings</p>
                <p class="stat-value"><?= $stats['bookings'] ?></p>
            </div>

            <div class="stat-card">
                <p class="stat-label">Registered Users</p>
                <p class="stat-value stat-green"><?= $stats['users'] ?></p>
            </div>

            <div class="stat-card">
                <p class="stat-label">Total Revenue</p>
                <p class="stat-value stat-green">NPR <?= number_format($stats['revenue']) ?></p>
            </div>

        </div>

        <!-- Recent bookings -->
        <div class="d-flex justify-between align-center mb-2">
            <h2 class="card-title">Recent Bookings</h2>
            <a href="<?= $base ?>/admin/reports.php" class="text-sm text-accent">View all →</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Movie</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_bookings)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding: 32px;">
                                No bookings yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_bookings as $b): ?>
                        <tr>
                            <td><span class="text-accent font-bold"><?= htmlspecialchars($b['reference_code']) ?></span></td>
                            <td><?= htmlspecialchars($b['user_name']) ?></td>
                            <td><?= htmlspecialchars($b['movie']) ?></td>
                            <td>NPR <?= number_format($b['total_amount']) ?></td>
                            <td>
                                <?php
                                $badge = match($b['status']) {
                                    'confirmed' => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                    default     => 'badge-amber',
                                };
                                ?>
                                <span class="badge <?= $badge ?>"><?= ucfirst($b['status']) ?></span>
                            </td>
                            <td class="text-muted text-sm"><?= htmlspecialchars($b['booked_at']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div><!-- /.admin-content -->
</div><!-- /.admin-layout -->

<?php include '../includes/footer.php'; ?>