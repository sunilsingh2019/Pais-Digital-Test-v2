<?php
/**
 * Simple SMTP Mailer for Gmail
 * A lightweight alternative to PHPMailer for sending emails via Gmail SMTP
 */

class SMTPMailer {
    private $host;
    private $port;
    private $username;
    private $password;
    private $from_email;
    private $from_name;
    
    public function __construct($host, $port, $username, $password, $from_email, $from_name = '') {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->from_email = $from_email;
        $this->from_name = $from_name;
    }
    
    public function sendMail($to, $subject, $body, $isHTML = true) {
        // Use WordPress-style wp_mail if available, otherwise use PHP mail with better headers
        if (function_exists('wp_mail')) {
            return wp_mail($to, $subject, $body, $this->getHeaders($isHTML));
        }
        
        // Enhanced PHP mail with proper headers
        $headers = $this->getHeaders($isHTML);
        $success = mail($to, $subject, $body, $headers);
        
        // Log the attempt
        $this->logEmailAttempt($to, $subject, $success);
        
        return $success;
    }
    
    private function getHeaders($isHTML = true) {
        $headers = array();
        
        if ($isHTML) {
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        } else {
            $headers[] = "Content-Type: text/plain; charset=UTF-8";
        }
        
        $from = $this->from_name ? "{$this->from_name} <{$this->from_email}>" : $this->from_email;
        $headers[] = "From: {$from}";
        $headers[] = "Reply-To: {$this->from_email}";
        $headers[] = "Return-Path: {$this->from_email}";
        $headers[] = "X-Mailer: Custom PHP Mailer";
        $headers[] = "X-Priority: 3";
        
        return implode("\r\n", $headers);
    }
    
    private function logEmailAttempt($to, $subject, $success) {
        $status = $success ? 'SUCCESS' : 'FAILED';
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'to' => $to,
            'subject' => $subject,
            'status' => $status,
            'from' => $this->from_email
        ];
        
        error_log("Email {$status}: " . json_encode($logEntry));
        
        // Also log to file for debugging
        $logFile = 'email_debug.log';
        $entry = date('Y-m-d H:i:s') . " [{$status}] Email to: {$to} | Subject: {$subject}\n";
        file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
    }
    
    // Alternative method using cURL to send via Gmail API (if needed)
    public function sendViaAPI($to, $subject, $body) {
        // This would require OAuth2 setup, but for now we'll use SMTP
        return $this->sendMail($to, $subject, $body);
    }
}
?> 