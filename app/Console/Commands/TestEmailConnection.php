<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;

class TestEmailConnection extends Command
{
    protected $signature = 'test:email';
    protected $description = 'Test email connection and OTP sending';

    public function handle()
    {
        $this->info('Testing email configuration...');
        
        try {
            // Test 1: Basic email sending
            $this->info('Test 1: Testing basic email sending...');
            Mail::raw('This is a test email from Tazen.', function ($message) {
                $message->to('sknadim6297@gmail.com')
                        ->subject('Test Email Connection');
            });
            $this->info('✓ Basic email sent successfully!');
            
            // Test 2: OTP email template
            $this->info('Test 2: Testing OTP verification email...');
            $testOtp = '123456';
            Mail::to('sknadim6297@gmail.com')->send(new OtpVerificationMail($testOtp));
            $this->info('✓ OTP email sent successfully!');
            
            $this->info('All email tests passed! Your email configuration is working.');
            
        } catch (\Exception $e) {
            $this->error('Email test failed: ' . $e->getMessage());
            $this->error('Full error: ' . $e->getTraceAsString());
            
            // Show mail configuration
            $this->info('Current mail configuration:');
            $this->info('MAIL_MAILER: ' . config('mail.default'));
            $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
            $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
            $this->info('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
            $this->info('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
            
            return 1;
        }
        
        return 0;
    }
}
