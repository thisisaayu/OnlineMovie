<?php
$pageTitle = 'Now Showing';
include 'includes/header.php';
include 'includes/db.php';
?>

<div class="container">

    <div class="page-header">
        <h1 class="page-title">Now Showing</h1>
        <p class="page-subtitle">Browse and book tickets for the latest movies</p>
    </div>

    <!-- Search & filter bar -->
    <div class="d-flex gap-2 flex-wrap mb-4">
        <input type="text" placeholder="Search by title or genre..." style="max-width: 300px;">
        <select style="max-width: 180px;">
            <option value="">All Languages</option>
            <option>Nepali</option>
            <option>Hindi</option>
            <option>English</option>
        </select>
    </div>

    <!-- ─────────────────────────────────────────────────────
         Movie grid
         TODO: replace static $movies array with a DB query:

         $result = mysqli_query($conn, "
             SELECT * FROM movies WHERE status = 'active'
             ORDER BY created_at DESC
         ");
         while ($movie = mysqli_fetch_assoc($result)) { ... }
    ───────────────────────────────────────────────────────── -->

    <?php
    // Static placeholder — remove once DB is connected
    $movies = [
        ['id' => 1, 'title' => 'Shershaah',       'genre' => 'Action',   'language' => 'Hindi',   'rating' => 'U/A',   'poster_url' => ''],
        ['id' => 2, 'title' => 'The Batman',       'genre' => 'Thriller', 'language' => 'English', 'rating' => 'PG-13', 'poster_url' => ''],
        ['id' => 3, 'title' => 'RRR',              'genre' => 'Action',   'language' => 'Telugu',  'rating' => 'U/A',   'poster_url' => ''],
        ['id' => 4, 'title' => 'Laapataa Ladies',  'genre' => 'Comedy',   'language' => 'Hindi',   'rating' => 'U/A',   'poster_url' => ''],
    ];
    ?>

    <?php if (empty($movies)): ?>
        <p class="text-muted text-center mt-4">No movies are currently showing. Check back soon.</p>
    <?php else: ?>
        <div class="movie-grid">
            <?php foreach ($movies as $movie): ?>
            <div class="movie-card">

                <div class="movie-poster">
                    <?php if (!empty($movie['poster_url'])): ?>
                        <img src="<?= $base ?>/Assets/images/<?= htmlspecialchars($movie['poster_url']) ?>"
                             alt="<?= htmlspecialchars($movie['title']) ?>">
                    <?php else: ?>
                        <span>No Poster</span>
                    <?php endif; ?>
                </div>

                <div class="movie-info">
                    <p class="movie-title"><?= htmlspecialchars($movie['title']) ?></p>
                    <div class="movie-meta">
                        <span class="badge"><?= htmlspecialchars($movie['genre']) ?></span>
                        <span class="badge"><?= htmlspecialchars($movie['language']) ?></span>
                        <span class="badge badge-amber"><?= htmlspecialchars($movie['rating']) ?></span>
                    </div>
                    <a href="<?= $base ?>/User/booking.php?movie_id=<?= (int)$movie['id'] ?>"
                       class="btn btn-primary btn-sm btn-block">
                        Book Now
                    </a>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>