<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollment_records', function (Blueprint $table) {
            $table->id();
            $table->string('student_id_no', 50);
            $table->string('last_name', 80);
            $table->string('first_name', 80);
            $table->string('middle_name', 80)->nullable();

            // Simplified Criteria
            $table->string('department'); // Basic Education, College, Graduate
            $table->string('grade_level')->nullable(); // Grade 1, 1st Year, etc.
            $table->string('strand_course')->nullable(); // STEM, BSIT, etc.
            $table->string('major')->nullable();

            $table->string('school_year', 30)->nullable();
            $table->string('semester', 30)->nullable();

            // Status for enrollment logic
            $table->string('enrollment_status', 20)->default('Pending');

            // JSON metadata for extraneous fields
            $table->json('extras')->nullable();

            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Data Migration from old tables
        $this->migrateOldData();
    }

    private function migrateOldData(): void
    {
        if (Schema::hasTable('basic_education')) {
            $records = DB::table('basic_education')->get();
            foreach ($records as $r) {
                DB::table('enrollment_records')->insert([
                    'student_id_no' => $r->id_no,
                    'last_name' => $r->last_name ?? '',
                    'first_name' => $r->first_name ?? '',
                    'middle_name' => $r->middle_name ?? null,
                    'department' => 'Basic Education',
                    'grade_level' => $r->grade_level ?? null,
                    'strand_course' => $r->strand ?? null,
                    'school_year' => $r->school_year ?? null,
                    'semester' => $r->semester ?? null,
                    'extras' => json_encode([
                        'birthdate' => $r->birthdate ?? null,
                        'sex' => $r->sex ?? null,
                        'age' => $r->age ?? null,
                        'father_name' => $r->father_name ?? null,
                        'mother_name' => $r->mother_name ?? null,
                        'guardian_name' => $r->guardian_name ?? null,
                        'guardian_contact' => $r->guardian_contact ?? null,
                        'address' => $r->address ?? null,
                        'credentials' => json_decode($r->credentials ?? '[]', true),
                        'is_balik_aral' => $r->is_balik_aral ?? false,
                        'is_senior_high' => $r->is_senior_high ?? false,
                        'lrn' => $r->lrn ?? null,
                        'ecs' => $r->ecs ?? null,
                    ]),
                    'recorded_by' => $r->recorded_by ?? null,
                    'created_at' => $r->created_at ?? now(),
                    'updated_at' => $r->updated_at ?? now(),
                ]);
            }
        }

        if (Schema::hasTable('cg_studies')) {
            $records = DB::table('cg_studies')->get();
            foreach ($records as $r) {
                DB::table('enrollment_records')->insert([
                    'student_id_no' => $r->id_no,
                    'last_name' => $r->last_name ?? '',
                    'first_name' => $r->first_name ?? '',
                    'middle_name' => $r->middle_name ?? null,
                    'department' => 'College',
                    'grade_level' => $r->year_level ?? null,
                    'strand_course' => $r->course ?? null,
                    'major' => $r->major ?? null,
                    'school_year' => $r->school_year ?? null,
                    'semester' => $r->semester ?? null,
                    'extras' => json_encode([
                        'birthdate' => $r->birthdate ?? null,
                        'sex' => $r->sex ?? null,
                        'age' => $r->age ?? null,
                        'father_name' => $r->father_name ?? null,
                        'mother_name' => $r->mother_name ?? null,
                        'guardian_name' => $r->guardian_name ?? null,
                        'guardian_contact' => $r->guardian_contact ?? null,
                        'address' => $r->address ?? null,
                        'credentials' => json_decode($r->credentials ?? '[]', true),
                        'is_freshman' => $r->is_freshman ?? false,
                        'is_transferee' => $r->is_transferee ?? false,
                        'approvals' => json_decode($r->approvals ?? '{}', true),
                    ]),
                    'recorded_by' => $r->recorded_by ?? null,
                    'created_at' => $r->created_at ?? now(),
                    'updated_at' => $r->updated_at ?? now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_records');
    }
};
