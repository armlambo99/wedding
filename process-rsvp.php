<?php
// RSVP Form Processor
// Configuration
$to_email = "mlamboaaron0@gmail.com";
$subject = "New RSVP - Themba & Nontokozo Lobola Luncheon";

// Get form data
$fullName = htmlspecialchars($_POST['fullName'] ?? '');
$attending = htmlspecialchars($_POST['attending'] ?? '');
$reason = htmlspecialchars($_POST['reason'] ?? '');
$guests = htmlspecialchars($_POST['guests'] ?? '1');
$dietary = htmlspecialchars($_POST['dietary'] ?? 'None specified');

// Validate required fields
if (empty($fullName) || empty($attending)) {
    die(json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields.'
    ]));
}

// Build email content
$email_body = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #8B0000, #C41E3A); color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 0 0 10px 10px; }
        .field { margin-bottom: 15px; padding: 10px; background: #f9f9f9; border-left: 3px solid #C41E3A; }
        .label { font-weight: bold; color: #8B0000; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2 style='margin: 0;'>💌 New RSVP Received</h2>
            <p style='margin: 5px 0 0 0;'>Themba & Nontokozo · Lobola Luncheon</p>
        </div>
        <div class='content'>
            <div class='field'>
                <span class='label'>👤 Full Name:</span><br>
                {$fullName}
            </div>
            <div class='field'>
                <span class='label'>✅ Attendance:</span><br>
                {$attending}
            </div>";

if (!empty($reason)) {
    $email_body .= "
            <div class='field'>
                <span class='label'>💬 Reason:</span><br>
                {$reason}
            </div>";
}

$email_body .= "
            <div class='field'>
                <span class='label'>👥 Number of Guests:</span><br>
                {$guests}
            </div>
            <div class='field'>
                <span class='label'>🍽️ Dietary Restrictions:</span><br>
                {$dietary}
            </div>
        </div>
        <div class='footer'>
            <p>Sent from Themba & Nontokozo Wedding Website</p>
            <p>11 July 2026 · 13:00 · Mahlangu home</p>
        </div>
    </div>
</body>
</html>
";

// Email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: RSVP Form <noreply@thembanontokozo.com>" . "\r\n";
$headers .= "Reply-To: " . $to_email . "\r\n";

// Send email
if (mail($to_email, $subject, $email_body, $headers)) {
    echo json_encode([
        'success' => true,
        'message' => "Thank you, {$fullName}! Your RSVP has been sent successfully."
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, something went wrong. Please try again later.'
    ]);
}
?>