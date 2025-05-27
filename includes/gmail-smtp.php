<?php
/**
 * Gmail SMTP Mailer
 * Proper SMTP implementation for Gmail using socket connection
 */

class GmailSMTP {
    private $host = 'smtp.gmail.com';
    private $port = 587;
    private $username;
    private $password;
    private $from_email;
    private $from_name;
    private $socket;
    
    public function __construct($username, $password, $from_name = '') {
        $this->username = $username;
        $this->password = $password;
        $this->from_email = $username;
        $this->from_name = $from_name;
    }
    
    public function sendEmail($to, $subject, $body, $isHTML = true) {
        try {
            // Connect to Gmail SMTP
            if (!$this->connect()) {
                return false;
            }
            
            // Authenticate
            if (!$this->authenticate()) {
                $this->disconnect();
                return false;
            }
            
            // Send email
            $result = $this->sendMessage($to, $subject, $body, $isHTML);
            
            // Disconnect
            $this->disconnect();
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Gmail SMTP Error: " . $e->getMessage());
            return false;
        }
    }
    
    private function connect() {
        $this->socket = fsockopen($this->host, $this->port, $errno, $errstr, 30);
        
        if (!$this->socket) {
            error_log("SMTP Connection failed: $errstr ($errno)");
            return false;
        }
        
        // Read greeting
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '220') {
            error_log("SMTP Greeting failed: $response");
            return false;
        }
        
        // Send EHLO
        $this->sendCommand("EHLO " . $_SERVER['HTTP_HOST']);
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '250') {
            error_log("SMTP EHLO failed: $response");
            return false;
        }
        
        // Start TLS
        $this->sendCommand("STARTTLS");
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '220') {
            error_log("SMTP STARTTLS failed: $response");
            return false;
        }
        
        // Enable crypto
        if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            error_log("SMTP TLS encryption failed");
            return false;
        }
        
        // Send EHLO again after TLS
        $this->sendCommand("EHLO " . $_SERVER['HTTP_HOST']);
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '250') {
            error_log("SMTP EHLO after TLS failed: $response");
            return false;
        }
        
        return true;
    }
    
    private function authenticate() {
        // Send AUTH LOGIN
        $this->sendCommand("AUTH LOGIN");
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '334') {
            error_log("SMTP AUTH LOGIN failed: $response");
            return false;
        }
        
        // Send username
        $this->sendCommand(base64_encode($this->username));
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '334') {
            error_log("SMTP Username failed: $response");
            return false;
        }
        
        // Send password
        $this->sendCommand(base64_encode($this->password));
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '235') {
            error_log("SMTP Password failed: $response");
            return false;
        }
        
        return true;
    }
    
    private function sendMessage($to, $subject, $body, $isHTML) {
        // MAIL FROM
        $this->sendCommand("MAIL FROM:<{$this->from_email}>");
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '250') {
            error_log("SMTP MAIL FROM failed: $response");
            return false;
        }
        
        // RCPT TO
        $this->sendCommand("RCPT TO:<$to>");
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '250') {
            error_log("SMTP RCPT TO failed: $response");
            return false;
        }
        
        // DATA
        $this->sendCommand("DATA");
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '354') {
            error_log("SMTP DATA failed: $response");
            return false;
        }
        
        // Email headers and body
        $email_data = $this->buildEmailData($to, $subject, $body, $isHTML);
        $this->sendCommand($email_data);
        
        // End data with .
        $this->sendCommand(".");
        $response = $this->readResponse();
        if (substr($response, 0, 3) != '250') {
            error_log("SMTP Email send failed: $response");
            return false;
        }
        
        return true;
    }
    
    private function buildEmailData($to, $subject, $body, $isHTML) {
        $headers = [];
        $headers[] = "From: {$this->from_name} <{$this->from_email}>";
        $headers[] = "To: $to";
        $headers[] = "Subject: $subject";
        $headers[] = "Date: " . date('r');
        $headers[] = "Message-ID: <" . md5(uniqid()) . "@{$_SERVER['HTTP_HOST']}>";
        
        if ($isHTML) {
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        } else {
            $headers[] = "Content-Type: text/plain; charset=UTF-8";
        }
        
        $headers[] = "X-Mailer: Pais Digital SMTP Mailer";
        $headers[] = "X-Priority: 3";
        
        return implode("\r\n", $headers) . "\r\n\r\n" . $body;
    }
    
    private function sendCommand($command) {
        fwrite($this->socket, $command . "\r\n");
    }
    
    private function readResponse() {
        $response = '';
        while (($line = fgets($this->socket, 515)) !== false) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') {
                break;
            }
        }
        return trim($response);
    }
    
    private function disconnect() {
        if ($this->socket) {
            $this->sendCommand("QUIT");
            fclose($this->socket);
        }
    }
    
    public function testConnection() {
        if ($this->connect() && $this->authenticate()) {
            $this->disconnect();
            return true;
        }
        return false;
    }
} 