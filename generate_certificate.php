<?php
$page_title = 'Generate Certificate';
require_once('C:\\Program Files\\xampp\\phpMyAdmin\\vendor\\autoload.php'); // Ensure TCPDF is installed via Composer
session_start();
require('connect_db.php'); // Database connection

// Check for necessary session variables
if (!isset($_SESSION['company_id'], $_SESSION['certificate_type'])) {
    echo "Error: Required information is missing. Please go back to the dashboard.";
    exit;
}

$companyId = $_SESSION['company_id'];
$certificateType = $_SESSION['certificate_type'];

// Fetch company details
$companyQuery = "SELECT company_name FROM companies WHERE company_id = ?";
$stmt = mysqli_prepare($link, $companyQuery);
if (!$stmt) {
    die('MySQL prepare error: ' . mysqli_error($link));
}
mysqli_stmt_bind_param($stmt, 'i', $companyId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $companyName);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch certificate template based on the type
$templateQuery = "SELECT header_text, body_text, footer_text, img FROM certificate_templates WHERE template_name = ?";
$stmt = mysqli_prepare($link, $templateQuery);
if (!$stmt) {
    die('MySQL prepare error: ' . mysqli_error($link));
}
mysqli_stmt_bind_param($stmt, 's', $certificateType);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$template = mysqli_fetch_assoc($result);
$imagePath = $template['img'];  // Using 'img' column for the image path
mysqli_stmt_close($stmt);

// Fetch achievements
$achievementsQuery = "SELECT achievement_description, date_achieved FROM company_achievements WHERE company_id = ?";
$stmt = mysqli_prepare($link, $achievementsQuery);
if (!$stmt) {
    die('MySQL prepare error: ' . mysqli_error($link));
}
mysqli_stmt_bind_param($stmt, 'i', $companyId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $achievementDescription, $dateAchieved);

$achievementsText = "<ul>";
while (mysqli_stmt_fetch($stmt)) {
    $achievementsText .= "<li>" . $achievementDescription . " on " . date('F j, Y', strtotime($dateAchieved)) . "</li>";
}
$achievementsText .= "</ul>";
mysqli_stmt_close($stmt);

// Generate PDF using TCPDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Embedding the image within the HTML content
$imageHtml = '<div style="text-align: center;"><img src="' . $imagePath . '" width="200" /></div>'; 

// Construct the certificate content, dynamically replacing placeholders
$certificateContent = "<h1>{$template['header_text']}</h1><br><br>" .
                      "<p>{$companyName}</p>" . $imageHtml .
                      "<p>Achievements:</p>{$achievementsText}" .
                      "<br><br>" . str_replace(
                          ['[CompanyName]', '[Date]'],
                          [$companyName, date('F j, Y')],
                          $template['body_text']
                      ) . 
                      "<br><br><p>{$template['footer_text']}</p>" .
                      "<br><br><p>Issued on " . date('F j, Y') . "</p>";

$pdf->writeHTML($certificateContent, true, false, true, false, '');

// Output the PDF
$pdf->Output('certificate.pdf', 'I');
?>
