    <?php 
    $page_title = 'Certificates and Partnerships';
    session_start();
    require('connect_db.php');
    include('header.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php'); // Or redirect to index page
        exit;  
    }

    // Define page title before including header to ensure it's dynamically set
    $page_title = 'Certificates and Partnerships';

    //------------------------FUNCTION TO FETCH DATA------------------------------

    // Function to fetch certificates from the db
    function getCertificates() {
        global $link;  // database connection variable
        $sql = "SELECT * FROM certificates";
        $result = mysqli_query($link, $sql);
        // Check if the query was successful
        if ($result === false) {
            // Handle the error, display a message
            error_log("Error fetching partners: " . mysqli_error($link));
            echo "Error: Unable to fetch certificates.";
            return [];
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    

    // Function to fetch partners from the db
    function getPartners() {
        global $link;  // database connection variable
        $sql = "SELECT * FROM partners";
        $result = mysqli_query($link, $sql);
        // Check if the query was successful
        if ($result === false) {
            // Handle the error, display a message
            echo "Error: Unable to fetch partners.";
            return [];
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);    
    }

    // Fetch certificates and partners
    $certificates = getCertificates();
    $partners = getPartners();

// Include the header and navigation map

include('navigation_map.php');
?>

<!--------------------------CERTIFICATES--------------------------------------------->
<!DOCTYPE html>
<html lang="en">
    
<body>

<div class="container"> <!-- Container for Certificates and Partnerships -->
        <!-- Certificates Section -->
        <div class="certificates-section">
            <h1>Certificates</h1>
            <div class="certificates-container">
            <?php foreach ($certificates as $certificate): ?>
                <div class="certificate">
                    <h2><?= htmlspecialchars($certificate['type']) ?></h2>
                    <img src="<?= htmlspecialchars($certificate['img']) ?>"
                    alt="Image of <?= htmlspecialchars($certificate['type']) ?> Certificate"><br>
                    <p><?= htmlspecialchars($certificate['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
<!--------------------------PRTNERSHIPS--------------------------------------------->

    <!-- Partnerships Section -->
    <div class="partners-section">
        <h1>Our Partners</h1>
            <div class="partners-container">
                <?php foreach ($partners as $partner): ?>
                    <div class="partner">
                        <a href="<?= htmlspecialchars($partner['url']) ?>" target="_blank">
                            <img src="<?= htmlspecialchars($partner['img']) ?>" 
                            alt="Logo of <?= htmlspecialchars($partner['name']) ?>">
                        
                        <h5><?= htmlspecialchars($partner['name']) ?></h5>
                    </div>
                    </a>
                <?php endforeach; ?>
            </div>
</div>
</div> <!-- Closing the container div from the header -->

<?php include('footer.php'); ?>
</body>
</html>


 