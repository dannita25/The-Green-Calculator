    <?php
    // Start the session and include necessary files
    require('connect_db.php');

    // Assume you have a session variable called 'username' set upon user login
    $userName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';

    // Query to fetch relevant content from the database
    $q = "SELECT type, text_content, image_url FROM site_content 
        WHERE type IN ('vision_message', 'home_image') 
        AND active = TRUE";
    $result = mysqli_query($link, $q);

    if (mysqli_num_rows($result) > 0) {
        $contents = [];  // Array to hold fetched content
        while ($row = mysqli_fetch_assoc($result)) {
            $contents[$row['type']] = $row;  // Store each row under its type
        }

        if (isset($contents['vision_message']) && isset($contents['home_image'])) {
            // Construct the hero section HTML if both contents are available
            $heroSectionHTML = "<div class='hero-section' style='background-image: 
                                url({$contents['home_image']['image_url']});'>
                                    <h4>{$contents['vision_message']['text_content']}</h4>
                                </div>";
        } else {
            $heroSectionHTML = '<p>Required content is missing. Please check the database.</p>';
        }
    }

    // Function to retrieve latest updates or news
    function getLatestUpdates($link) {
        $sql = "SELECT title, summary FROM updates ORDER BY posted_date DESC LIMIT 3";
        $result = mysqli_query($link, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    $latestUpdates = getLatestUpdates($link);

    ?>
<!doctype html>
<html lang="en">

<body>    
    <div class="container">
        <h1 class="text-center">Welcome to The Green Calculator</h1>
        <div class="row">
            <main>
        <?= $heroSectionHTML ?>  <!-- Output the hero section HTML -->
            <section class="introduction" style="text-align: center;">
                <h4>Welcome, <?= htmlspecialchars($userName); ?>! Discover new insights and improve your 
                business practices with our tools.</h4>
            </section>

            <section class="benefits">
                <h2>Benefits of your Subscription</h2>
                <ul>
                    <li>Access real-time sustainability data and analyses.</li>
                    <li>Receive continuous software updates and premium support.</li>
                    <li>Engage with a community of like-minded professionals.</li>
                </ul>
            </section>

            <section class="how-it-works">
                <h2>How It Works</h2>
                <div class="content" style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                    <img src="../img/work.gif" alt="GIF image of a sustainable society" title="Learn how to use the Green Calculator" style="flex: 1 1 50%; max-width: 50%; height: auto;">
                    <div class="text-content" style="flex: 1 1 50%; max-width: 100%;">
                        <p>
                        <i class="bi bi-tree-fill"></i> <strong>Assessment of Sustainability Practices:</strong> Businesses can evaluate their current sustainability practices using a series of measures and activities provided by the calculator.<br><br>
                        <i class="bi bi-graph-up-arrow"></i> <strong>Scoring System:</strong> Each sustainability measure includes a scoring system, where businesses can earn points based on their level of compliance with the listed activities.<br><br>
                        <i class="bi bi-award-fill"></i> <strong>Certificates of Achievement:</strong> Based on the total score achieved, businesses may qualify for Gold, Silver, or Bronze certificates, recognizing their commitment to sustainability.<br><br>
                        <i class="bi bi-arrow-clockwise"></i> <strong>Continuous Improvement:</strong> The Green Calculator offers suggestions and resources to help businesses continue to improve their practices and achieve higher levels of sustainability.
                        </p>
                    </div>
                </div>
            </section>

            <section class="testimonials">
                <h2>Success Stories</h2>
                <div class="testimonial">
                    <p>"The Green Calculator has been instrumental in transforming our approach to sustainability. We've not only reduced our carbon footprint but have also saved on operational costs significantly." <strong>— EcoFriendly Inc., CEO</strong></p>
                    <p>"Thanks to the Green Calculator, we have successfully implemented several green initiatives that have positively impacted our local community and enhanced our market presence." <strong>— GreenSolutions, Sustainability Officer</strong></p>
                    <p>"Our journey towards environmental stewardship was streamlined by the comprehensive tools and certifications provided by the Green Calculator. We are proud to be recognized as a leader in sustainable practices in our industry." <strong>— EcoTech Innovations, Director of Operations</strong></p>    
                </div>
            </section>

            <section class="latest-updates">
                <h2>Latest Updates</h2>
                <?php foreach ($latestUpdates as $update): ?>
                    <div class="update">
                        <h5><?= htmlspecialchars($update['title']); ?></h5>
                        <p><?= htmlspecialchars($update['summary']); ?></p>
                    </div>
                <?php endforeach; ?>
            </section>
            </main>
        </div>
    </div>
</body>
</html>


