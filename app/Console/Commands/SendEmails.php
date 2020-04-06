<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\EmailQueue;

/**
 * Class SendEmails
 *
 * @package App\Console\Commands
 */
class SendEmails extends Command
{
    const LIMIT_FOR_BATCH = 20;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails from DB queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $emails = EmailQueue::orderBy('id', 'ASC')->take(self::LIMIT_FOR_BATCH)->get();
        /** @var EmailQueue $email */
        foreach ($emails as $email) {
            try {
                Mail::to($email->email)->send(unserialize($email->payload));
            } catch (\Throwable $e) {
                Log::error($e);
            }
            $email->delete();
        }
    }
}
