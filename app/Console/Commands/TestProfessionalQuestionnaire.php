<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Professional\BookingController;
use App\Models\Booking;

class TestProfessionalQuestionnaire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:professional-questionnaire {bookingId=15}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the professional questionnaire API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookingId = $this->argument('bookingId');
        $this->info('Testing professional questionnaire API...');
        
        // Get the specified booking
        $booking = Booking::find($bookingId);
        
        if (!$booking) {
            $this->error("No booking found with ID {$bookingId}");
            return 1;
        }
        
        $this->info("Testing with booking ID: {$booking->id}");
        
        // Instantiate the controller
        $controller = new BookingController();
        
        try {
            // Call the getQuestionnaireAnswers method
            $response = $controller->getQuestionnaireAnswers($booking->id);
            
            // Convert response to array
            $responseData = $response->getData(true);
            
            $this->info('API Response:');
            $this->info('Success: ' . ($responseData['success'] ? 'true' : 'false'));
            
            if ($responseData['success']) {
                $this->info('Message: ' . ($responseData['message'] ?? 'N/A'));
                $this->info('Answers count: ' . count($responseData['answers'] ?? []));
                
                if (!empty($responseData['answers'])) {
                    $this->info('Sample answers:');
                    foreach (array_slice($responseData['answers'], 0, 3) as $index => $answer) {
                        $this->info("  " . ($index + 1) . ". Q: " . substr($answer['question'], 0, 50) . '...');
                        $this->info("     A: " . substr($answer['answer'], 0, 30) . '...');
                    }
                }
                
                $bookingDetails = $responseData['booking_details'] ?? [];
                $this->info('Customer: ' . ($bookingDetails['customer_name'] ?? 'N/A'));
                $this->info('Service: ' . ($bookingDetails['service_name'] ?? 'N/A'));
            } else {
                $this->error('Message: ' . ($responseData['message'] ?? 'Unknown error'));
                if (!empty($responseData['debug_info'])) {
                    $this->info('Debug info: ' . json_encode($responseData['debug_info']));
                }
            }
            
        } catch (\Exception $e) {
            $this->error('Exception occurred: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
