<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Debug - Pais Digital</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .info { color: blue; }
        .debug-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>📧 Email Debug Tool - Pais Digital</h1>
    
    <?php
    // Check PHP mail configuration
    echo "<div class='debug-section'>";
    echo "<h2>📋 PHP Mail Configuration</h2>";
    
    if (function_exists('mail')) {
        echo "<p class='success'>✅ PHP mail() function is available</p>";
    } else {
        echo "<p class='error'>❌ PHP mail() function is NOT available</p>";
    }
    
    // Check sendmail path
    $sendmail_path = ini_get('sendmail_path');
    echo "<p><strong>Sendmail Path:</strong> " . ($sendmail_path ?: 'Not set') . "</p>";
    
    // Check SMTP settings
    $smtp = ini_get('SMTP');
    $smtp_port = ini_get('smtp_port');
    echo "<p><strong>SMTP Server:</strong> " . ($smtp ?: 'Not set') . "</p>";
    echo "<p><strong>SMTP Port:</strong> " . ($smtp_port ?: 'Not set') . "</p>";
    
    echo "</div>";
    
    // Test basic email
    echo "<div class='debug-section'>";
    echo "<h2>📤 Basic Email Test</h2>";
    
    $to = 'sunil.singh.programmer@gmail.com';
    $subject = 'Test Email from Pais Digital - ' . date('Y-m-d H:i:s');
    $message = 'This is a test email sent from the Pais Digital contact form debug tool.';
    $headers = 'From: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
               'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    
    $result = mail($to, $subject, $message, $headers);
    
    if ($result) {
        echo "<p class='success'>✅ Basic email test SUCCESSFUL</p>";
        echo "<p>Email sent to: $to</p>";
        echo "<p>Subject: $subject</p>";
    } else {
        echo "<p class='error'>❌ Basic email test FAILED</p>";
        $error = error_get_last();
        if ($error) {
            echo "<p class='error'>Last error: " . $error['message'] . "</p>";
        }
    }
    echo "</div>";
    
    // Test HTML email
    echo "<div class='debug-section'>";
    echo "<h2>🎨 HTML Email Test</h2>";
    
    $html_subject = 'HTML Test Email from Pais Digital - ' . date('Y-m-d H:i:s');
    $html_message = '
    <!DOCTYPE html>
    <html>
    <head><title>Test Email</title></head>
    <body>
        <h2 style="color: #2c5aa0;">Test Email from Pais Digital</h2>
        <p>This is a <strong>HTML test email</strong> to verify email functionality.</p>
        <p>Timestamp: ' . date('Y-m-d H:i:s') . '</p>
        <p style="color: #666;">If you received this email, the HTML email functionality is working correctly.</p>
    </body>
    </html>';
    
    $html_headers = 'MIME-Version: 1.0' . "\r\n";
    $html_headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $html_headers .= 'From: Pais Digital <noreply@' . $_SERVER['HTTP_HOST'] . '>' . "\r\n";
    $html_headers .= 'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n";
    
    $html_result = mail($to, $html_subject, $html_message, $html_headers);
    
    if ($html_result) {
        echo "<p class='success'>✅ HTML email test SUCCESSFUL</p>";
        echo "<p>HTML email sent to: $to</p>";
    } else {
        echo "<p class='error'>❌ HTML email test FAILED</p>";
    }
    echo "</div>";
    
    // Test contact form email
    echo "<div class='debug-section'>";
    echo "<h2>📝 Contact Form Email Test</h2>";
    
    try {
        require_once 'includes/email-handler.php';
        
        // Create a test submission
        $_POST = [
            'full_name' => 'Debug Test User',
            'email' => 'debug@test.com',
            'phone' => '+1234567890',
            'country' => 'Australia',
            'message' => 'This is a debug test message to verify the contact form email functionality is working correctly.'
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $contactForm = new ContactFormHandler();
        
        if ($contactForm->success) {
            echo "<p class='success'>✅ Contact form email test SUCCESSFUL</p>";
            echo "<p>Contact form email sent successfully!</p>";
        } else {
            echo "<p class='error'>❌ Contact form email test FAILED</p>";
            if (!empty($contactForm->errors)) {
                echo "<p class='error'>Errors:</p>";
                echo "<pre>" . print_r($contactForm->errors, true) . "</pre>";
            }
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Contact form test ERROR: " . $e->getMessage() . "</p>";
    }
    
    // Reset POST data
    $_POST = [];
    $_SERVER['REQUEST_METHOD'] = 'GET';
    
    echo "</div>";
    
    // Server information
    echo "<div class='debug-section'>";
    echo "<h2>🖥️ Server Information</h2>";
    echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
    echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
    echo "<p><strong>Host:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";
    echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
    
    // Check if we're in Docker
    if (file_exists('/.dockerenv')) {
        echo "<p class='info'>🐳 Running in Docker container</p>";
    }
    
    echo "</div>";
    
    // Email logs
    echo "<div class='debug-section'>";
    echo "<h2>📊 Email Logs</h2>";
    
    if (file_exists('email_debug.log')) {
        echo "<h3>Email Debug Log:</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents('email_debug.log')) . "</pre>";
    } else {
        echo "<p class='warning'>⚠️ No email debug log found</p>";
    }
    
    echo "</div>";
    
    // Troubleshooting tips
    echo "<div class='debug-section'>";
    echo "<h2>🔧 Troubleshooting Tips</h2>";
    echo "<ul>";
    echo "<li><strong>Check Spam Folder:</strong> Emails might be going to spam/junk folder</li>";
    echo "<li><strong>Server Configuration:</strong> Some hosting providers disable mail() function</li>";
    echo "<li><strong>Gmail App Password:</strong> Make sure the app password is correct and active</li>";
    echo "<li><strong>Firewall:</strong> Check if port 587 (SMTP) is blocked</li>";
    echo "<li><strong>DNS:</strong> Verify your domain has proper MX records</li>";
    echo "<li><strong>Alternative:</strong> Consider using a service like SendGrid, Mailgun, or Amazon SES</li>";
    echo "</ul>";
    echo "</div>";
    ?>
    
    <div class="debug-section">
        <h2>🔄 Actions</h2>
        <p><a href="email-debug.php">🔄 Refresh Tests</a></p>
        <p><a href="index.php">🏠 Back to Main Site</a></p>
        <p><a href="test-email.php">🧪 Run Advanced Email Test</a></p>
    </div>
</body>
</html> 