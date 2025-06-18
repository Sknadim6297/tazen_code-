<?php


namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\Log;
use Exception;

class OtpService
{
    /**
     * Generate a new OTP for the given email
     * 
     * @param string $email
     * @return string
     */
    public function generate(string $email): string
    {
        try {
            // Generate a random 6-digit code
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Set expiry time (10 minutes from now)
            $expiresAt = now()->addMinutes(10);
            
            Log::info("Generating new OTP for email: {$email}");
            
            // First, mark any existing OTP for this email as invalid by setting it to expired
            // This ensures old OTPs can't be used even if they were verified
            OtpVerification::where('email', $email)
                ->update(['expires_at' => now()->subMinute()]);
        
            // Now create a fresh OTP record
            OtpVerification::create([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => $expiresAt,
                'verified_at' => null
            ]);
        
            // Verify OTP was stored correctly
            $verification = OtpVerification::where('email', $email)
                ->where('otp', $otp)
                ->first();
                
            if (!$verification) {
                Log::error("Failed to save OTP for email: {$email}");
            }
            
            // Send OTP email
            Mail::to($email)->send(new OtpVerificationMail($otp));
            
            Log::info("New OTP generated and sent for email: {$email}");
            return $otp;
        } catch (Exception $e) {
            Log::error("Error generating OTP: " . $e->getMessage(), [
                'email' => $email,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw the exception to be handled by the controller
            throw $e;
        }
    }
    
    /**
     * Verify the OTP for the given email
     * 
     * @param string $email
     * @param string $otp
     * @return array
     */
    public function verify(string $email, string $otp): array
    {
        try {
            Log::info("Verifying OTP for email: {$email}, OTP: {$otp}");
            
            // Get the latest OTP for this email
            $otpRecord = OtpVerification::where('email', $email)
                ->orderBy('created_at', 'desc')
                ->first();
        
            // If no record exists
            if (!$otpRecord) {
                Log::warning("No OTP record found for email: {$email}");
                return [
                    'success' => false,
                    'message' => 'No OTP was generated for this email. Please request a new code.',
                    'error_type' => 'no_record'
                ];
            }
            
            // Check if OTP matches
            if ($otpRecord->otp !== $otp) {
                Log::warning("OTP mismatch for email: {$email}. Expected: {$otpRecord->otp}, Received: {$otp}");
                return [
                    'success' => false, 
                    'message' => 'Invalid OTP. Please check and try again.',
                    'error_type' => 'invalid'
                ];
            }
            
            // Check if OTP is expired
            if ($otpRecord->expires_at <= now()) {
                Log::warning("OTP expired for email: {$email}. Expired at: {$otpRecord->expires_at}");
                return [
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new code.',
                    'error_type' => 'expired'
                ];
            }
            
            // Check if OTP is already verified
            if (!is_null($otpRecord->verified_at)) {
                // If it's verified but still within the last minute, allow it
                // This handles cases where user might submit the form multiple times
                if ($otpRecord->verified_at->diffInMinutes(now()) < 1) {
                    Log::info("Recently verified OTP being reused: {$email}. Allowing it.");
                    return [
                        'success' => true,
                        'message' => 'OTP verified successfully.',
                        'recently_verified' => true
                    ];
                }
                
                Log::warning("OTP already verified for email: {$email} at: {$otpRecord->verified_at}");
                return [
                    'success' => false,
                    'message' => 'This OTP has already been used. Please request a new code if needed.',
                    'error_type' => 'already_verified'
                ];
            }
            
            // Mark as verified
            $otpRecord->verified_at = now();
            $otpRecord->save();
            
            Log::info("OTP verified successfully for email: {$email}");
            
            return [
                'success' => true,
                'message' => 'OTP verified successfully.'
            ];
        } catch (Exception $e) {
            Log::error("Error verifying OTP: " . $e->getMessage(), [
                'email' => $email,
                'otp' => $otp,
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'An error occurred while verifying the OTP. Please try again.',
                'error_type' => 'system_error'
            ];
        }
    }
    
    /**
     * Check if the email has a verified OTP
     * 
     * @param string $email
     * @return bool
     */
    public function isVerified(string $email): bool
    {
        try {
            $isVerified = OtpVerification::where('email', $email)
                ->whereNotNull('verified_at')
                ->exists();
                
            Log::info("Checking if email is verified: {$email}, Result: " . ($isVerified ? 'Yes' : 'No'));
            
            return $isVerified;
        } catch (Exception $e) {
            Log::error("Error checking verification status: " . $e->getMessage(), [
                'email' => $email,
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
    
    /**
     * Get diagnostic information about an OTP for troubleshooting
     * 
     * @param string $email
     * @return array|null
     */
    public function getOtpDiagnostics(string $email): ?array
    {
        $record = OtpVerification::where('email', $email)->first();
        
        if (!$record) {
            return null;
        }
        
        return [
            'email' => $record->email,
            'otp' => $record->otp,
            'created_at' => $record->created_at->format('Y-m-d H:i:s'),
            'expires_at' => $record->expires_at->format('Y-m-d H:i:s'),
            'is_expired' => $record->expires_at <= now(),
            'is_verified' => !is_null($record->verified_at),
            'verified_at' => $record->verified_at ? $record->verified_at->format('Y-m-d H:i:s') : null,
        ];
    }
}