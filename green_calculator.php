<?php
$page_title = 'Green Calculator';
session_start();
require('connect_db.php'); // Ensure the database connection settings are correct
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;  
}

// Check if company_id is set in the session
if (!isset($_SESSION['company_id'])) {
    echo "<p>Error: No associated company found. Please complete your registration.</p>";
    exit;  // Or redirect to complete registration
}

$companyId = $_SESSION['company_id'];

// Fetch measures and activities from the databases
function getSustainabilityMeasures($link) {
    $measures = array();
    $query = "SELECT sm.measure_id, sm.measure_type, sm.image_path, sa.activity_description
              FROM sustainable_measures sm
              JOIN sustainability_activities sa ON sm.measure_id = sa.measure_id";
    $result = mysqli_query($link, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        if (!isset($measures[$row['measure_id']])) {
            $measures[$row['measure_id']] = [
                'measure_type' => $row['measure_type'],
                'image_path' => $row['image_path'],
                'activities' => []  // Initialize activities as an array
            ];
        }
        $measures[$row['measure_id']]['activities'][] = $row['activity_description'];
    }
    return $measures;
}

$goldThreshold = 100;
$silverThreshold = 75;
$bronzeThreshold = 50;

$certificateType = null;
$totalScore = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $totalScore = 0;
    foreach ($_POST['ratings'] as $measureId => $rating) {
        $totalScore += (int)$rating;
        $measureDescription = $_POST['descriptions'][$measureId];  // Capture the measure description
    }

    // Determine certificate type based on the total score
    if ($totalScore >= $goldThreshold) {
        $certificateType = 'gold';
    } elseif ($totalScore >= $silverThreshold) {
        $certificateType = 'silver';
    } elseif ($totalScore >= $bronzeThreshold) {
        $certificateType = 'bronze';
    }

    // Insert the results into the company_achievements table
    $achievementDescription = $measureDescription; // Example: 'Achieved Gold Certificate in Sustainability
    $measure_id = 0; // Set to 0 as this is a calculated achievement
    $achievementType = 'measure'; // Specify the type of achievement

    $insertQuery = "INSERT INTO company_achievements (company_id, achievement_type, measure_id, 
                    achievement_description, points_earned, date_achieved) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($link, $insertQuery);
    if (!$stmt) {
        die('MySQL prepare error: ' . mysqli_error($link));
    }
    
    mysqli_stmt_bind_param($stmt, 'isisi', $companyId, $achievementType, $measureId, $achievementDescription, $totalScore);
    if (mysqli_stmt_execute($stmt)) {
        // Successful insert
        $_SESSION['total_score'] = $totalScore;
        $_SESSION['certificate_type'] = $certificateType;
        $_SESSION['show_modal'] = true;  // Set the flag to show the modal
    } else {
        // Handle possible SQL execution errors
        die('Execute failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);    
}

$measures = getSustainabilityMeasures($link);


include('navigation_map.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>
<div class="container">
    <h1>Green Calculator</h1>
    <p><strong>Use these ten measures to assess your company sustainability practices. 
        Each measure includes a scoring system where you select either RED, AMBER, or GREEN, 
        corresponding to your level of compliance with the sustainability activities listed under each measure. 
        This rating reflects the following:</strong></p>
<ul>
    <li><strong>RED (0 points)</strong>: If your company has not implemented any of the listed activities for the measure.</li>
    <li><strong>AMBER (5 points)</strong>: If your company has started to implement one or more of the listed activities but has not fully integrated them.</li>
    <li><strong>GREEN (10 points)</strong>: If your company has fully implemented one or more of the listed activities and integrated them into your operations effectively.</li>
</ul>
<p>Select the highest level your company has achieved for each measure based on the activities you comply with. Only one activity needs to be met to qualify for the corresponding level.</p>
    <form action="green_calculator.php" method="post">
        <?php foreach ($measures as $measure_id => $measure): ?>
            <fieldset>
                <legend><h3><?= htmlspecialchars($measure['measure_type']) ?></h3></legend><br>
                <div style="display: flex; ">
                <img src="<?= htmlspecialchars($measure['image_path']) ?>" alt="Measure Image" class="img-responsive" style="max-width: 600px; align-items: center">
                <input type="hidden" name="descriptions[<?= $measure_id ?>]" value="<?= htmlspecialchars($measure['measure_type']) ?>"></input>
                <div class="form-group">
                    <ul>
                        <?php if (!empty($measure['activities'])): ?>
                            <?php foreach ($measure['activities'] as $activity): ?>
                                <li><?= htmlspecialchars($activity) ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    
                        <label>Level achieved:</label>
                        <select name="ratings[<?= $measure_id ?>]" class="form-control">
                            <option value="" disabled selected>Select ↓</option>
                            <option value="0" style="background-color: #FFCCCC; ">0%</option>
                            <option value="5" style="background-color: #FFE0B2; ">50%</option>
                            <option value="10" style="background-color: #CCFFCC;">100%</option>
                        </select>
                    </div>
                </div>                    
            </fieldset><br><br>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-success" style="display: block; margin-left: auto; margin-right: 0;">Submit Your Ratings</button>
    </form>
</div>
</body>

<?php if (isset($_SESSION['total_score'])): ?>
<div class="modal" tabindex="-1" role="dialog" id="resultsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sustainability Results</h5>
            </div>
            <div class="modal-body">
                <p>Your sustainability score is: <?= $_SESSION['total_score'] ?></p>
                <?php if (isset($_SESSION['certificate_type'])): ?>
                    <p>Congratulations! You have earned a <?= $certificateType ?> certificate.</p>
                    <img src="img/certificates/<?= $certificateType ?>.jpg" alt="Certificate Image" class="img-fluid">
                <?php else: ?>
                    <p>Consider purchasing green points to improve your sustainability score.</p>
                    <a href="green_points.php" class="btn btn-primary">Purchase Green Points</a>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function() {
    // Check if a specific session flag is set before showing the modal
    <?php if (isset($_SESSION['show_modal']) && $_SESSION['show_modal'] === true): ?>
        var myModal = new bootstrap.Modal(document.getElementById('resultsModal'));
        myModal.show();
        <?php unset($_SESSION['show_modal']); // Reset the flag ?>
    <?php endif; ?>
});
</script>

<?php include('footer.php'); ?>
</body>
</html>
