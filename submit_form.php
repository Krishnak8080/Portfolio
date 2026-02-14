<?php
// Simple form handler: sanitize input and send email using PHP mail().
// Note: For reliable delivery configure a proper SMTP server or use an external mail service.
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = trim(strip_tags($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST['message'] ?? '');
    $location = trim($_POST['location'] ?? '');

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.html?status=error');
        exit;
    }

    $to = 'khandelwalkrishna8080@gmail.com';
    $subject = "New message from portfolio: " . $name;
    $body = "You received a new message from your portfolio contact form:\n\n";
    $body .= "Name: " . $name . "\n";
    $body .= "Email: " . $email . "\n";
    $body .= "Location: " . $location . "\n\n";
    $body .= "Message:\n" . $message . "\n";

    $headers = "From: " . $name . " <" . $email . ">\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";

    if (mail($to, $subject, $body, $headers)) {
        header('Location: index.html?status=sent');
        exit;
    } else {
        header('Location: index.html?status=error');
        exit;
    }
}

// If not POST, redirect back
header('Location: index.html');
exit;

?>
