<?php
$page_title = 'Sustainability';
session_start();
require('connect_db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;  
}

// Fetch sustainability-related content from site_content
$query = "SELECT * FROM site_content 
        WHERE active = 1 
        AND type IN ('promo_message', 'sustainability_intro', 'video', 'podcast', 'article')";
$contentResult = mysqli_query($link, $query);
$contentItems = mysqli_fetch_all($contentResult, MYSQLI_ASSOC);

// Fetch updates
$updateQuery = "SELECT title, summary FROM updates ORDER BY posted_date DESC LIMIT 3";
$updateResult = mysqli_query($link, $updateQuery);
$updates = mysqli_fetch_all($updateResult, MYSQLI_ASSOC);

mysqli_close($link);

include('navigation_map.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>
<div class="container">
    <h1>Sustainability Initiatives</h1>

    <!-- Sustainability Intro -->
    <?php foreach ($contentItems as $item): ?>
        <?php if ($item['type'] === 'sustainability_intro' || $item['type'] === 'promo_message'): ?>
            <section class="message">
                <h2><?= htmlspecialchars($item['heading']); ?></h2>
                <p><?= htmlspecialchars($item['text_content']); ?></p>
                <?php if (!empty($item['image_url'])): ?>
                    <img src="<?= htmlspecialchars($item['image_url']); ?>" alt="<?= htmlspecialchars($item['alt_text']); ?>">
                <?php endif; ?>
            </section>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Multimedia content: Videos and Podcasts -->
    <section class="media">
        <h2>Learn More Through Our Media</h2>
        <?php foreach ($contentItems as $item): ?>
            <?php if ($item['type'] === 'video'): ?>
                <div class="video">
                    <h4><?= htmlspecialchars($item['heading']); ?></h4>
                    <p><?= htmlspecialchars($item['text_content']); ?></p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= 
                    htmlspecialchars($item['video_url']); ?>" frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen></iframe>
                </div>
            <?php elseif ($item['type'] === 'podcast'): ?>
                <div class="podcast">
                    <h4><?= htmlspecialchars($item['heading']); ?></h4>
                    <p><?= htmlspecialchars($item['text_content']); ?></p>
                    <iframe width="100%" height="152" src="https://open.spotify.com/embed/episode/<?= 
                    htmlspecialchars($item['podcast_url']); ?>" frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowtransparency></iframe>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>

    <!-- Articles -->
    <section class="articles">
        <h2>Informative Articles</h2>
        <?php foreach ($contentItems as $item): ?>
            <?php if ($item['type'] === 'article'): ?>
                <a href="<?= htmlspecialchars($item['podcast_url']); ?>" target="_blank"><?= 
                    htmlspecialchars($item['heading']); ?></a> <p><?= htmlspecialchars($item['text_content']); ?></p>
                
            <?php endif; ?>
        <?php endforeach; ?>
    </section>

    <!-- Updates and news -->
    <section class="updates">
        <h2>Latest Updates</h2>
        <?php foreach ($updates as $update): ?>
            <div class="update">
                <h5><?= htmlspecialchars($update['title']); ?></h5>
                <p><?= htmlspecialchars($update['summary']); ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</div>
<?php include('footer.php'); ?>
</body>
</html>
