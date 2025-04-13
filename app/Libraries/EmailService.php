<?php
namespace App\Libraries;

use CodeIgniter\Email\Email;
use Config\Services;

class EmailService
{
    protected $email;

    public function __construct()
    {
        $this->email = Services::email();
    }

    public function sendEmail($to, $subject, $message, $attachments = [])
    {
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        // Lampiran (jika ada)
        if (!empty($attachments)) {
            foreach ($attachments as $file) {
                $this->email->attach($file);
            }
        }

        // Kirim email
        if (!$this->email->send()) {
            return $this->email->printDebugger(['headers']);
        }

        return true;
    }
}
