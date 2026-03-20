<?php

namespace Database\Seeders;

use App\Models\Protocol;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProtocolSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        $protocols = [
            [
                'title' => 'COVID-19 Treatment Protocol',
                'description' => 'Comprehensive guidelines for COVID-19 patient management and treatment strategies.',
                'status' => 'active',
            ],
            [
                'title' => 'Surgical Sterilization Protocol',
                'description' => 'Standard operating procedures for surgical instrument sterilization and safety protocols.',
                'status' => 'active',
            ],
            [
                'title' => 'Emergency Response Protocol',
                'description' => 'Emergency response procedures and crisis management guidelines.',
                'status' => 'active',
            ],
            [
                'title' => 'Patient Care Protocol',
                'description' => 'Best practices for patient care and discharge procedures.',
                'status' => 'active',
            ],
            [
                'title' => 'Infection Control Protocol',
                'description' => 'Guidelines for preventing and controlling healthcare-associated infections.',
                'status' => 'active',
            ],
            [
                'title' => 'Medication Administration Protocol',
                'description' => 'Safe medication administration practices and dosage guidelines.',
                'status' => 'active',
            ],
            [
                'title' => 'Lab Testing Protocol',
                'description' => 'Standardized laboratory testing procedures and quality assurance.',
                'status' => 'active',
            ],
            [
                'title' => 'Patient Privacy Protocol',
                'description' => 'HIPAA compliance and patient data protection guidelines.',
                'status' => 'active',
            ],
            [
                'title' => 'Equipment Maintenance Protocol',
                'description' => 'Regular maintenance and inspection schedules for medical equipment.',
                'status' => 'active',
            ],
            [
                'title' => 'Staff Training Protocol',
                'description' => 'Mandatory staff training and certification requirements.',
                'status' => 'active',
            ],
            [
                'title' => 'Quality Assurance Protocol',
                'description' => 'QA processes and performance measurement standards.',
                'status' => 'archived',
            ],
            [
                'title' => 'Research Ethics Protocol',
                'description' => 'Ethical guidelines for clinical research and patient studies.',
                'status' => 'active',
            ],
        ];

        foreach ($protocols as $protocol) {
            Protocol::create([
                'user_id' => $users->random()->id,
                'title' => $protocol['title'],
                'description' => $protocol['description'],
                'status' => $protocol['status'],
                'views' => rand(10, 500),
            ]);
        }
    }
}
