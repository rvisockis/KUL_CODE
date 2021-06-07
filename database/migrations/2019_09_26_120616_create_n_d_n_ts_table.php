<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNDNTsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NDNT', function (Blueprint $table) {
            $table->increments('id');
            $table ->string("Sending_Date",200);
            $table ->string("Sending_Number",200);
            $table ->string("Person_Info_Personal_ID",11);
            $table ->string("Person_Info_Name",200);
            $table ->string("Person_Info_Living_Location",200);
            $table ->string("Person_Info_Phone_Number",200);
            $table ->string("Person_Info_Mobile_Phone_Number",12);
            $table ->string("Person_Info_Email",50);
            $table ->string("Work_Place",200);
            $table ->string("Position",200);
            $table ->string("Full_Anamnisis",200);
            $table ->string("Applied_Treatment",200);
            $table ->string("Condition_And_Life",200);
            $table ->string("Health_Condition_Summary_Consultation_Date",200);
            $table ->string("Health_Condition_Summary_Doctors_Speciality",200);
            $table ->string("Health_Condition_Summary_Comments",200);
            $table ->string("Health_Condition_Summary_Accessories",200);
            $table ->string("Barthel_index",200);
            $table ->string("Duration_Of_Incapacity",200);
            $table ->string("Main_Diagnosis_TLK10",5);
            $table ->string("Main_Diagnosis_Functional_Class",200);
            $table ->string("Main_Diagnosis_Degree",200);
            $table ->string("Main_Diagnosis_stage",200);
            $table ->string("Main_Diagnosis_Progress",200);
            $table ->string("Other_Diagnosis",200);
            $table ->string("Sending_To_Disability_What_Kind",200);
            $table ->string("Sending_To_Disability_For_What",200);
            $table ->string("Sending_To_Disability_For_Younger",200);
            $table ->string("Sending_To_Disability_What_Time",200);
            $table ->string("Sending_To_Disability_Forced_To_DO",200);
            $table ->string("State",20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('n_d_n_ts');
    }
}
