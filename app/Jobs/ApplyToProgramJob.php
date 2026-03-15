<?php
namespace App\Jobs;

use App\Models\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ApplyToProgramJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $beneficiaryId;
    protected $programId;

    public function __construct($beneficiaryId, $programId)
    {
        $this->beneficiaryId = $beneficiaryId;
        $this->programId = $programId;
    }

    public function handle()
    {
        DB::transaction(function () {

            $count = DB::table('program_beneficiary')
                ->where('program_id', $this->programId)
                ->count();

            if ($count >= 1200) {
                return;
            }

            DB::table('program_beneficiary')->insert([
                'program_id' => $this->programId,
                'beneficiary_id' => $this->beneficiaryId,
                'applied_at' => now()
            ]);

        });
    }
}
