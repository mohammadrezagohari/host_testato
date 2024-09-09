<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kavenegar;
use Illuminate\Support\Facades\Log;

class ForgetPasswordSMSCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $password;
    private $user;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($password, $user)
    {
        $this->password = $password;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $username = $user->name ?? $user->mobile;
        $receptor = $user->mobile;
        $password = $this->password;
        $type = "sms";//env("KAVEHNEGAR_DATA_TYPE_PASS");
        $template = "forgetpassword";//env("KAVEHNEGAR_OTP_NAME");
        Kavenegar::VerifyLookup($receptor, $username, $password, null, $template, $type);
    }
}
