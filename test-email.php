<?php
/**
 * Email Test Script
 * Use this to test if email functionality is working
 */

// Include the email handler
require_once 'includes/email-handler.php';

echo "<h2>Email Test Script</h2>";

// Test email sending
try {
    $contactForm = new ContactFormHandler();
    
    // Simulate a test email
    $testName = "Test User";
    $testEmail = "test@example.com";
    $testPhone = "+1234567890";
    $testCountry = "Australia";
    $testMessage = "This is a test message to verify email functionality is working correctly.";
    
    $emailSubject = "TEST: Contact Form Submission - Pais Digital";
    $emailBody = $contactForm->createEmailTemplate($testName, $testEmail, $testPhone, $testCountry, $testMessage);
    
    // Make the createEmailTemplate method public temporarily for testing
    $reflection = new ReflectionClass($contactForm);
    $method = $reflection->getMethod('createEmailTemplate');
    $method->setAccessible(true);
    $emailBody = $method->invoke($contactForm, $testName, $testEmail, $testPhone, $testCountry, $testMessage);
    
    $sendMethod = $reflection->getMethod('sendEmail');
    $sendMethod->setAccessible(true);
    $result = $sendMethod->invoke($contactForm, 'sunil.singh.programmer@gmail.com', $emailSubject, $emailBody);
    
    if ($result) {
        echo "<p style='color: green;'>✅ Email sent successfully!</p>";
        echo "<p>Check your email inbox: sunil.singh.programmer@gmail.com</p>";
    } else {
        echo "<p style='color: red;'>❌ Email failed to send.</p>";
        echo "<p>Check the email_debug.log file for details.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><strong>Email Configuration:</strong></p>";
echo "<ul>";
echo "<li>SMTP Host: smtp.gmail.com</li>";
echo "<li>SMTP Port: 587</li>";
echo "<li>From Email: sunil.singh.programmer@gmail.com</li>";
echo "<li>To Email: sunil.singh.programmer@gmail.com</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>Troubleshooting Tips:</strong></p>";
echo "<ul>";
echo "<li>Make sure your server has mail() function enabled</li>";
echo "<li>Check if your hosting provider allows email sending</li>";
echo "<li>Verify Gmail app password is correct</li>";
echo "<li>Check spam/junk folder</li>";
echo "<li>Look at email_debug.log for detailed logs</li>";
echo "</ul>";

// Check if mail function exists
if (function_exists('mail')) {
    echo "<p style='color: green;'>✅ PHP mail() function is available</p>";
} else {
    echo "<p style='color: red;'>❌ PHP mail() function is not available</p>";
}

// Test simple mail
echo "<hr>";
echo "<h3>Simple Mail Test</h3>";
$simple_result = mail(
    'sunil.singh.programmer@gmail.com',
    'Simple Test Email',
    'This is a simple test email to check basic mail functionality.',
    'From: test@' . $_SERVER['HTTP_HOST']
);

if ($simple_result) {
    echo "<p style='color: green;'>✅ Simple mail test successful</p>";
} else {
    echo "<p style='color: red;'>❌ Simple mail test failed</p>";
}
?> 