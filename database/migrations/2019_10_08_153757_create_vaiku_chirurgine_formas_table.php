<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaikuChirurgineFormasTable extends Migration
{

    public function up()
    {
        Schema::create('vaiku_chirurgine_forma', function (Blueprint $table) {
            $table->increments('id');
            $table->text("coments")->nullable();
            $table->text("BirthDay")->nullable();
            $table->text("Name")->nullable();
            $table->text("MedicalNrID")->nullable();
            $table->text("CheckDate")->nullable();
            $table->text("GoingStationary")->nullable();
            $table->text("MandatoryHelp")->nullable();
            $table->text("NeededHelpCategory")->nullable();
            $table->text("ComplainsAndAnamnisis")->nullable();
            $table->text("Alergy")->nullable();
            $table->text("AlergyToWhom")->nullable();
            $table->text("EpidemicAnamnisis")->nullable();
            $table->text("EpidemicAnamnisisHurts")->nullable();
            $table->text("Epidemic")->nullable();
            $table->text("EpidemicWas")->nullable();
            $table->text("OperationSelection")->nullable();
            $table->text("OperationSimptoms")->nullable();
            $table->text("Diagnosis")->nullable();
            $table->text("CommonState")->nullable();
            $table->text("Temperature")->nullable();
            $table->text("Pain")->nullable();
            $table->text("slime")->nullable();
            $table->text("slimeOther")->nullable();
            $table->text("turgor")->nullable();
            $table->text("KLP")->nullable();
            $table->text("pulse")->nullable();
            $table->text("breathing")->nullable();
            $table->text("breathingRight")->nullable();
            $table->text("breathingLeft")->nullable();
            $table->text("Heart")->nullable();
            $table->text("SSD")->nullable();
            $table->text("AKS")->nullable();
            $table->text("belly")->nullable();
            $table->text("bellySlightlyPainful")->nullable();
            $table->text("bellyPainful")->nullable();
            $table->text("Abdomen")->nullable();
            $table->text("AbdomenIfIs")->nullable();
            $table->text("Voids")->nullable();
            $table->text("VoidDayCount")->nullable();
            $table->text("Peristalsis")->nullable();
            $table->text("Urination")->nullable();
            $table->text("UrinationWhen")->nullable();
            $table->text("Organs")->nullable();
            $table->text("OrgansChanges")->nullable();
            $table->text("menstruation")->nullable();
            $table->text("SpecialCondition")->nullable();
            $table->text("InvestigationPlan")->nullable();
            $table->text("CommonBlodTest")->nullable();
            $table->text("UraneTest")->nullable();
            $table->text("CRB")->nullable();
            $table->text("BellyEchoscopy")->nullable();
            $table->text("AnesthesiologistConsultation")->nullable();
            $table->text("InvestigationOther")->nullable();
            $table->text("FinalDiagnosis")->nullable();
            $table->text("conclusion")->nullable();
            $table->text("conclusionDepartment")->nullable();
            $table->text("recomendations")->nullable();
            $table->text("Diet")->nullable();
            $table->text("Mode")->nullable();
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
        Schema::dropIfExists('vaiku_chirurgine_formas');
    }
}
