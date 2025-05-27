<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail SMTP Test - Pais Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #2c5aa0 0%, #1e3d6f 100%); min-height: 100vh; }
        .test-container { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .test-header { background: linear-gradient(135deg, #2c5aa0 0%, #4a90e2 100%); color: white; border-radius: 15px 15px 0 0; }
        .status-success { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .test-result { background: #f8f9fa; border-radius: 8px; padding: 15px; margin: 10px 0; }
        .btn-test { background: linear-gradient(135deg, #2c5aa0 0%, #4a90e2 100%); border: none; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="test-container">
                    <div class="test-header p-4 text-center">
                        <h1 class="mb-0">📧 Gmail SMTP Test</h1>
                        <p class="mb-0 mt-2">Pais Digital Email System</p>
                    </div>
                    
                    <div class="p-4">
                        <?php
                        require_once 'includes/gmail-smtp.php';
                        
                        $testResults = [];
                        $overallSuccess = true;
                        
                        // Gmail credentials
                        $gmail_username = 'sunil.singh.programmer@gmail.com';
                        $gmail_password = 'gudk esno zwya xqkn';
                        $from_name = 'Pais Digital Test';
                        
                        // Test 1: Connection Test
                        echo "<h3>🔌 Connection Tests</h3>";
                        
                        try {
                            $gmail = new GmailSMTP($gmail_username, $gmail_password, $from_name);
                            
                            echo "<div class='test-result'>";
                            echo "<strong>Test 1: Gmail SMTP Connection</strong><br>";
                            
                            if ($gmail->testConnection()) {
                                echo "<span class='status-success'>✅ SUCCESS: Connected to Gmail SMTP successfully!</span>";
                                $testResults['connection'] = true;
                            } else {
                                echo "<span class='status-error'>❌ FAILED: Could not connect to Gmail SMTP</span>";
                                $testResults['connection'] = false;
                                $overallSuccess = false;
                            }
                            echo "</div>";
                            
                        } catch (Exception $e) {
                            echo "<div class='test-result'>";
                            echo "<strong>Test 1: Gmail SMTP Connection</strong><br>";
                            echo "<span class='status-error'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</span>";
                            echo "</div>";
                            $testResults['connection'] = false;
                            $overallSuccess = false;
                        }
                        
                        // Test 2: Send Test Email
                        if ($testResults['connection']) {
                            echo "<h3 class='mt-4'>📤 Email Sending Tests</h3>";
                            
                            echo "<div class='test-result'>";
                            echo "<strong>Test 2: Send Test Email</strong><br>";
                            
                            $subject = "Gmail SMTP Test - " . date('Y-m-d H:i:s');
                            $body = "
                            <html>
                            <body style='font-family: Arial, sans-serif;'>
                                <h2 style='color: #2c5aa0;'>Gmail SMTP Test Email</h2>
                                <p>This is a test email sent using the Gmail SMTP class.</p>
                                <p><strong>Test Details:</strong></p>
                                <ul>
                                    <li>Sent from: Pais Digital Test System</li>
                                    <li>Time: " . date('Y-m-d H:i:s') . "</li>
                                    <li>Method: Direct Gmail SMTP Connection</li>
                                </ul>
                                <p style='color: #28a745;'><strong>✅ If you receive this email, the Gmail SMTP is working correctly!</strong></p>
                            </body>
                            </html>";
                            
                            try {
                                $emailSent = $gmail->sendEmail($gmail_username, $subject, $body, true);
                                
                                if ($emailSent) {
                                    echo "<span class='status-success'>✅ SUCCESS: Test email sent successfully!</span><br>";
                                    echo "<small>Check your inbox: $gmail_username</small>";
                                    $testResults['email'] = true;
                                } else {
                                    echo "<span class='status-error'>❌ FAILED: Could not send test email</span>";
                                    $testResults['email'] = false;
                                    $overallSuccess = false;
                                }
                            } catch (Exception $e) {
                                echo "<span class='status-error'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</span>";
                                $testResults['email'] = false;
                                $overallSuccess = false;
                            }
                            echo "</div>";
                            
                            // Test 3: Contact Form Email Template
                            echo "<div class='test-result'>";
                            echo "<strong>Test 3: Contact Form Email Template</strong><br>";
                            
                            $contactSubject = "Test Contact Form Submission - Pais Digital";
                            $contactBody = "
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <meta charset='UTF-8'>
                                <title>Contact Form Test</title>
                                <style>
                                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
                                    .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
                                    .header { background: linear-gradient(135deg, #2c5aa0 0%, #1e3d6f 100%); color: white; padding: 30px; text-align: center; }
                                    .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
                                    .content { padding: 40px 30px; }
                                    .field-group { margin-bottom: 25px; }
                                    .field-label { font-weight: 600; color: #2c5aa0; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
                                    .field-value { background-color: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #2c5aa0; font-size: 16px; line-height: 1.5; }
                                    .footer { background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef; }
                                    .timestamp { background-color: #e8f4fd; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center; color: #2c5aa0; font-weight: 500; }
                                </style>
                            </head>
                            <body>
                                <div class='container'>
                                    <div class='header'>
                                        <h1>🧪 Test Contact Form Submission</h1>
                                        <p>Pais Digital - Digital Innovation</p>
                                    </div>
                                    
                                    <div class='content'>
                                        <div class='field-group'>
                                            <div class='field-label'>Full Name</div>
                                            <div class='field-value'>John Test User</div>
                                        </div>
                                        
                                        <div class='field-group'>
                                            <div class='field-label'>Email Address</div>
                                            <div class='field-value'>test@example.com</div>
                                        </div>
                                        
                                        <div class='field-group'>
                                            <div class='field-label'>Phone Number</div>
                                            <div class='field-value'>+61 400 123 456</div>
                                        </div>
                                        
                                        <div class='field-group'>
                                            <div class='field-label'>Country</div>
                                            <div class='field-value'>Australia</div>
                                        </div>
                                        
                                        <div class='field-group'>
                                            <div class='field-label'>Message</div>
                                            <div class='field-value'>This is a test message to verify that the contact form email template is working correctly with the Gmail SMTP connection.</div>
                                        </div>
                                        
                                        <div class='timestamp'>
                                            Test submitted on: " . date('Y-m-d H:i:s') . "
                                        </div>
                                    </div>
                                    
                                    <div class='footer'>
                                        <p>This is a test email from the Pais Digital contact form system.</p>
                                        <p><strong>✅ Gmail SMTP is working correctly!</strong></p>
                                    </div>
                                </div>
                            </body>
                            </html>";
                            
                            try {
                                $contactEmailSent = $gmail->sendEmail($gmail_username, $contactSubject, $contactBody, true);
                                
                                if ($contactEmailSent) {
                                    echo "<span class='status-success'>✅ SUCCESS: Contact form template email sent!</span><br>";
                                    echo "<small>Check your inbox for the formatted contact form email</small>";
                                    $testResults['contact_form'] = true;
                                } else {
                                    echo "<span class='status-error'>❌ FAILED: Could not send contact form email</span>";
                                    $testResults['contact_form'] = false;
                                    $overallSuccess = false;
                                }
                            } catch (Exception $e) {
                                echo "<span class='status-error'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</span>";
                                $testResults['contact_form'] = false;
                                $overallSuccess = false;
                            }
                            echo "</div>";
                        }
                        
                        // Overall Results
                        echo "<h3 class='mt-4'>📊 Test Summary</h3>";
                        echo "<div class='test-result'>";
                        
                        if ($overallSuccess) {
                            echo "<h4 class='status-success'>🎉 ALL TESTS PASSED!</h4>";
                            echo "<p>Your Gmail SMTP configuration is working correctly. The contact form should now send emails successfully.</p>";
                            echo "<div class='alert alert-success mt-3'>";
                            echo "<strong>Next Steps:</strong><br>";
                            echo "1. Test the actual contact form on your website<br>";
                            echo "2. Check your Gmail inbox for the test emails<br>";
                            echo "3. Verify emails are not going to spam folder";
                            echo "</div>";
                        } else {
                            echo "<h4 class='status-error'>❌ SOME TESTS FAILED</h4>";
                            echo "<p>There are issues with your Gmail SMTP configuration. Please check the error messages above.</p>";
                            echo "<div class='alert alert-warning mt-3'>";
                            echo "<strong>Troubleshooting:</strong><br>";
                            echo "1. Verify Gmail app password is correct<br>";
                            echo "2. Check if 2-factor authentication is enabled<br>";
                            echo "3. Ensure 'Less secure app access' is configured<br>";
                            echo "4. Check server firewall settings for port 587";
                            echo "</div>";
                        }
                        
                        echo "</div>";
                        
                        // Technical Details
                        echo "<h3 class='mt-4'>🔧 Technical Details</h3>";
                        echo "<div class='test-result'>";
                        echo "<strong>Configuration:</strong><br>";
                        echo "SMTP Server: smtp.gmail.com<br>";
                        echo "Port: 587 (TLS)<br>";
                        echo "Username: " . htmlspecialchars($gmail_username) . "<br>";
                        echo "Authentication: LOGIN<br>";
                        echo "Encryption: STARTTLS<br>";
                        echo "PHP Version: " . phpversion() . "<br>";
                        echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
                        echo "Test Time: " . date('Y-m-d H:i:s T');
                        echo "</div>";
                        ?>
                        
                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-test btn-lg text-white">
                                🏠 Back to Website
                            </a>
                            <button onclick="location.reload()" class="btn btn-outline-primary btn-lg ms-2">
                                🔄 Run Tests Again
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 