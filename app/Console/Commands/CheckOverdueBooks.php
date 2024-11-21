<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverdueBookReminder;
use Exception;
use App\Models\BookBorrow;

class CheckOverdueBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:remainder-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email reminder to the borrower...!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueBooks = BookBorrow::whereDate('due_date', '<', now())
            ->whereNull('returned_at')
            ->with('borrower')
            ->get();

        foreach ($overdueBooks as $borrow) {
            try {
                Log::info("Overdue Book: {$borrow->book->title}");
                
                Mail::to($borrow->borrower->email)
                    ->send(new OverdueBookReminder($borrow->book, $borrow->borrower, $borrow));

                $borrow->update(['returned_at' => now()->format('Y-m-d')]);
                
            } catch (Exception $e) {
                Log::error("Error sending email for book '{$borrow->book->title}' to borrower '{$borrow->borrower->name}': {$e->getMessage()}");
            }
        }
        $this->info('Send an email reminder to the borrower...!');
    }
}
