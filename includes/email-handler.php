<?php
/**
 * Email Handler for Pais Digital Contact Form
 * Handles form processing, validation, and email sending
 */

// Include the Gmail SMTP class
require_once 'gmail-smtp.php';

class ContactFormHandler {
    private $errors = [];
    private $success = false;
    private $gmail_smtp;
    
    // Email configuration
    private $gmail_username = 'sunil.singh.programmer@gmail.com';
    private $gmail_password = 'gudk esno zwya xqkn';
    private $from_name = 'Pais Digital Contact Form';
    
    public function __construct() {
        $this->gmail_smtp = new GmailSMTP($this->gmail_username, $this->gmail_password, $this->from_name);
        
        // Debug logging
        error_log("ContactFormHandler initialized. Request method: " . $_SERVER['REQUEST_METHOD']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data received: " . print_r($_POST, true));
        }
    }
    
    public function processForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("Processing form submission...");
            $this->validateForm();
            
            if (empty($this->errors)) {
                error_log("Form validation passed, attempting to send email...");
                $this->sendEmail();
            } else {
                error_log("Form validation failed: " . print_r($this->errors, true));
            }
        }
    }
    
    private function validateForm() {
        // Validate full name
        $fullName = $this->sanitizeInput($_POST['fullName'] ?? '');
        if (empty($fullName)) {
            $this->errors['fullName'] = 'Full name is required';
        } elseif (strlen($fullName) < 2) {
            $this->errors['fullName'] = 'Full name must be at least 2 characters';
        } elseif (!preg_match('/^[a-zA-Z\s\'-]+$/', $fullName)) {
            $this->errors['fullName'] = 'Full name contains invalid characters';
        }
        
        // Validate email
        $email = $this->sanitizeInput($_POST['email'] ?? '');
        if (empty($email)) {
            $this->errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Please enter a valid email address';
        }
        
        // Validate phone
        $phone = $this->sanitizeInput($_POST['phone'] ?? '');
        if (empty($phone)) {
            $this->errors['phone'] = 'Phone number is required';
        } elseif (!preg_match('/^[\+]?[0-9\s\-\(\)]{8,20}$/', $phone)) {
            $this->errors['phone'] = 'Please enter a valid phone number';
        }
        
        // Validate country
        $country = $this->sanitizeInput($_POST['country'] ?? '');
        $validCountries = ['australia', 'new-zealand', 'other'];
        if (empty($country)) {
            $this->errors['country'] = 'Please select a country';
        } elseif (!in_array($country, $validCountries)) {
            $this->errors['country'] = 'Please select a valid country';
        }
        
        // Validate message
        $message = $this->sanitizeInput($_POST['message'] ?? '');
        if (empty($message)) {
            $this->errors['message'] = 'Message is required';
        } elseif (strlen($message) < 10) {
            $this->errors['message'] = 'Message must be at least 10 characters';
        } elseif (strlen($message) > 1000) {
            $this->errors['message'] = 'Message must not exceed 1000 characters';
        }
    }
    
    private function sendEmail() {
        $fullName = $this->sanitizeInput($_POST['fullName']);
        $email = $this->sanitizeInput($_POST['email']);
        $phone = $this->sanitizeInput($_POST['phone']);
        $country = $this->sanitizeInput($_POST['country']);
        $message = $this->sanitizeInput($_POST['message']);
        
        // Format country name
        $countryName = $this->formatCountryName($country);
        
        // Email subject
        $subject = "New Contact Form Submission - Pais Digital";
        
        // Email body
        $emailBody = $this->buildEmailTemplate($fullName, $email, $phone, $countryName, $message);
        
        // Send email using Gmail SMTP
        $emailSent = $this->gmail_smtp->sendEmail(
            $this->gmail_username,
            $subject,
            $emailBody,
            true // HTML email
        );
        
        if ($emailSent) {
            $this->success = true;
            $this->logEmail($email, $subject, 'SUCCESS');
            
            // Redirect to prevent form resubmission and show success message
            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1#contact');
            exit();
        } else {
            $this->errors['general'] = 'Failed to send email. Please try again later.';
            $this->logEmail($email, $subject, 'FAILED');
        }
    }
    
    private function buildEmailTemplate($fullName, $email, $phone, $country, $message) {
        $timestamp = date('Y-m-d H:i:s');
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Contact Form Submission</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
                .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
                .header { background: linear-gradient(135deg, #2c5aa0 0%, #1e3d6f 100%); color: white; padding: 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
                .header p { margin: 10px 0 0 0; opacity: 0.9; font-size: 16px; }
                .content { padding: 40px 30px; }
                .field-group { margin-bottom: 25px; }
                .field-label { font-weight: 600; color: #2c5aa0; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
                .field-value { background-color: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #2c5aa0; font-size: 16px; line-height: 1.5; }
                .message-field .field-value { min-height: 80px; white-space: pre-wrap; }
                .footer { background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef; }
                .footer p { margin: 0; color: #6c757d; font-size: 14px; }
                .timestamp { background-color: #e8f4fd; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center; color: #2c5aa0; font-weight: 500; }
                .logo { width: 120px; height: auto; margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>New Contact Form Submission</h1>
                    <p>Pais Digital - Digital Innovation</p>
                </div>
                
                <div class='content'>
                    <div class='field-group'>
                        <div class='field-label'>Full Name</div>
                        <div class='field-value'>" . htmlspecialchars($fullName) . "</div>
                    </div>
                    
                    <div class='field-group'>
                        <div class='field-label'>Email Address</div>
                        <div class='field-value'>" . htmlspecialchars($email) . "</div>
                    </div>
                    
                    <div class='field-group'>
                        <div class='field-label'>Phone Number</div>
                        <div class='field-value'>" . htmlspecialchars($phone) . "</div>
                    </div>
                    
                    <div class='field-group'>
                        <div class='field-label'>Country</div>
                        <div class='field-value'>" . htmlspecialchars($country) . "</div>
                    </div>
                    
                    <div class='field-group message-field'>
                        <div class='field-label'>Message</div>
                        <div class='field-value'>" . htmlspecialchars($message) . "</div>
                    </div>
                    
                    <div class='timestamp'>
                        Submitted on: " . $timestamp . "
                    </div>
                </div>
                
                <div class='footer'>
                    <p>This email was sent from the Pais Digital contact form.</p>
                    <p>Please respond to the customer at: " . htmlspecialchars($email) . "</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    private function formatCountryName($country) {
        switch ($country) {
            case 'australia':
                return 'Australia';
            case 'new-zealand':
                return 'New Zealand';
            case 'other':
                return 'Other';
            default:
                return ucfirst($country);
        }
    }
    
    private function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    private function logEmail($email, $subject, $status) {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$status] Email to: $email | Subject: $subject" . PHP_EOL;
        file_put_contents('email_log.txt', $logEntry, FILE_APPEND | LOCK_EX);
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function isSuccess() {
        return $this->success;
    }
    
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    public function getErrorsJson() {
        return json_encode($this->errors);
    }
    
    public function getFormData() {
        return [
            'fullName' => $_POST['fullName'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'country' => $_POST['country'] ?? '',
            'message' => $_POST['message'] ?? ''
        ];
    }
} 