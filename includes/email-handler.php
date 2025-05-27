<?php
/**
 * Email Handler for Pais Digital Contact Form
 * Handles form processing, validation, and email sending
 */

class ContactFormHandler {
    private $smtpHost = 'smtp.gmail.com';
    private $smtpPort = 587;
    private $smtpUsername = 'sunil.singh.programmer@gmail.com';
    private $smtpPassword = 'gudk esno zwya xqkn';
    private $fromEmail = 'sunil.singh.programmer@gmail.com';
    private $toEmail = 'sunil.singh.programmer@gmail.com';
    
    public $errors = [];
    public $success = false;
    
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processForm();
        }
    }
    
    private function processForm() {
        // Get and sanitize form data
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $country = $_POST['country'] ?? '';
        $message = trim($_POST['message'] ?? '');
        
        // Validate form data
        $this->validateForm($fullName, $email, $phone, $country, $message);
        
        // If no errors, send email
        if (empty($this->errors)) {
            $emailSubject = "New Contact Form Submission - Pais Digital";
            $emailBody = $this->createEmailTemplate($fullName, $email, $phone, $country, $message);
            
            $emailSent = $this->sendEmail($this->toEmail, $emailSubject, $emailBody);
            
            if ($emailSent) {
                $this->success = true;
                $this->logSubmission($fullName, $email, $phone, $country, $message);
            } else {
                $this->errors['general'] = 'Failed to send email. Please try again later.';
            }
        }
    }
    
    private function validateForm($fullName, $email, $phone, $country, $message) {
        // Full name validation
        if (empty($fullName)) {
            $this->errors['full_name'] = 'Full name is required';
        } elseif (strlen($fullName) < 2) {
            $this->errors['full_name'] = 'Full name must be at least 2 characters';
        } elseif (!preg_match('/^[a-zA-Z\s\-\'\.]+$/', $fullName)) {
            $this->errors['full_name'] = 'Please enter a valid full name (letters, spaces, hyphens, apostrophes only)';
        }
        
        // Email validation
        if (empty($email)) {
            $this->errors['email'] = 'Email address is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Please enter a valid email address';
        }
        
        // Phone validation
        if (empty($phone)) {
            $this->errors['phone'] = 'Phone number is required';
        } elseif (!preg_match('/^[\+]?[0-9\s\-\(\)]{10,}$/', $phone)) {
            $this->errors['phone'] = 'Please enter a valid phone number (minimum 10 digits)';
        }
        
        // Country validation
        if (empty($country)) {
            $this->errors['country'] = 'Please select your country';
        }
        
        // Message validation
        if (empty($message)) {
            $this->errors['message'] = 'Message is required';
        } elseif (strlen($message) < 10) {
            $this->errors['message'] = 'Message must be at least 10 characters long';
        } elseif (strlen($message) > 1000) {
            $this->errors['message'] = 'Message must be less than 1000 characters';
        }
        
        // Security: Basic spam protection
        if (strpos($message, 'http://') !== false || strpos($message, 'https://') !== false) {
            $this->errors['message'] = 'URLs are not allowed in the message';
        }
    }
    
    private function createEmailTemplate($name, $email, $phone, $country, $message) {
        $template = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>New Contact Form Submission</title>
            <style>
                body {
                    font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    background-color: #f8fafc;
                    margin: 0;
                    padding: 20px;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: #ffffff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                }
                .email-header {
                    background: linear-gradient(135deg, #2c5aa0 0%, #4a90e2 100%);
                    color: white;
                    padding: 30px;
                    text-align: center;
                }
                .email-header h1 {
                    margin: 0;
                    font-size: 24px;
                    font-weight: 700;
                }
                .email-header p {
                    margin: 10px 0 0 0;
                    opacity: 0.9;
                    font-size: 16px;
                }
                .email-body {
                    padding: 30px;
                }
                .contact-info {
                    background: #f8fafc;
                    border-radius: 8px;
                    padding: 20px;
                    margin-bottom: 20px;
                }
                .info-row {
                    display: flex;
                    margin-bottom: 15px;
                    align-items: center;
                }
                .info-row:last-child {
                    margin-bottom: 0;
                }
                .info-label {
                    font-weight: 600;
                    color: #2c5aa0;
                    min-width: 100px;
                    margin-right: 15px;
                }
                .info-value {
                    color: #333;
                    flex: 1;
                }
                .message-section {
                    background: #ffffff;
                    border: 2px solid #e2e8f0;
                    border-radius: 8px;
                    padding: 20px;
                    margin-top: 20px;
                }
                .message-section h3 {
                    margin: 0 0 15px 0;
                    color: #2c5aa0;
                    font-size: 18px;
                }
                .message-content {
                    color: #555;
                    line-height: 1.7;
                    white-space: pre-wrap;
                }
                .email-footer {
                    background: #1e3d6f;
                    color: white;
                    padding: 20px 30px;
                    text-align: center;
                    font-size: 14px;
                }
                .timestamp {
                    color: #64748b;
                    font-size: 12px;
                    margin-top: 20px;
                    text-align: center;
                    padding: 15px;
                    background: #f1f5f9;
                    border-radius: 6px;
                }
                .priority-badge {
                    display: inline-block;
                    background: #10b981;
                    color: white;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <h1>🚀 New Contact Form Submission</h1>
                    <p>Pais Digital - Digital Innovation</p>
                    <span class="priority-badge">New Lead</span>
                </div>
                
                <div class="email-body">
                    <div class="contact-info">
                        <div class="info-row">
                            <div class="info-label">👤 Name:</div>
                            <div class="info-value"><strong>' . htmlspecialchars($name) . '</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">📧 Email:</div>
                            <div class="info-value"><a href="mailto:' . htmlspecialchars($email) . '" style="color: #2c5aa0; text-decoration: none;">' . htmlspecialchars($email) . '</a></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">📱 Phone:</div>
                            <div class="info-value"><a href="tel:' . htmlspecialchars($phone) . '" style="color: #2c5aa0; text-decoration: none;">' . htmlspecialchars($phone) . '</a></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">🌍 Country:</div>
                            <div class="info-value">' . htmlspecialchars($country) . '</div>
                        </div>
                    </div>
                    
                    <div class="message-section">
                        <h3>💬 Project Details & Message</h3>
                        <div class="message-content">' . htmlspecialchars($message) . '</div>
                    </div>
                    
                    <div class="timestamp">
                        📅 Received: ' . date('F j, Y \a\t g:i A T') . '
                    </div>
                </div>
                
                <div class="email-footer">
                    <p><strong>Pais Digital</strong> - Digital Excellence & Innovation</p>
                    <p style="margin: 5px 0 0 0; opacity: 0.8;">This email was automatically generated from your website contact form.</p>
                </div>
            </div>
        </body>
        </html>';
        
        return $template;
    }
    
    private function sendEmail($to, $subject, $body) {
        // Headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: Pais Digital Contact Form <{$this->fromEmail}>\r\n";
        $headers .= "Reply-To: {$this->fromEmail}\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "X-Priority: 1\r\n";
        
        // Use PHP's built-in mail function
        return mail($to, $subject, $body, $headers);
    }
    
    private function logSubmission($name, $email, $phone, $country, $message) {
        $logData = [
            'name' => htmlspecialchars($name),
            'email' => htmlspecialchars($email),
            'phone' => htmlspecialchars($phone),
            'country' => htmlspecialchars($country),
            'message' => htmlspecialchars($message),
            'timestamp' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ];
        error_log("Contact Form Submission: " . json_encode($logData));
    }
    
    public function getFormValue($field) {
        return htmlspecialchars($_POST[$field] ?? '');
    }
    
    public function hasError($field) {
        return isset($this->errors[$field]);
    }
    
    public function getError($field) {
        return $this->errors[$field] ?? '';
    }
    
    public function isSelected($field, $value) {
        return ($_POST[$field] ?? '') === $value ? 'selected' : '';
    }
}
?> 