<?php
namespace App\Imports;

use App\Models\Donor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DonorsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    public function model(array $row)
    {
        return new Donor([
            'donor_id' => $row['donor_id'],
            'donor_name' => $row['donor_name'],
            'donor_type' => $row['donor_type'],
            'country' => $row['country'],
            'contact_person' => $row['contact_person'],
            'contact_email' => $row['email'],
            'contact_phone' => $row['phone'],
            'total_grants_usde' =>(float) str_replace(['$', ','], '', $row['total_grants_usd'])?? 0,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.email' => 'nullable|email',
            '*.phone' => 'nullable|string',
            '*.country' => 'nullable|string'
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
