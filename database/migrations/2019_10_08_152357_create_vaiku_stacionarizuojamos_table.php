<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaikuStacionarizuojamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaiku_stacionarizuojamos', function (Blueprint $table) {
            $table->increments('id');
            $table ->string("Name",200);
            $table ->string("BirthDay",200);
            $table ->string("CheckDate",200);
            $table ->string("HospitalizationDiagnosis",200);
            $table ->string("SendingTo",200);
            $table ->string("Treatment",200);
            $table ->string("CommonState",200);
            $table ->string("Temperature",200);
            $table ->string("PainScale",200);
            $table ->string("KPL",200);
            $table ->string("Pulse",200);
            $table ->string("Skin",200);
            $table ->string("Rash",200);
            $table ->string("Rashis",200);
            $table ->string("MucousMembranesOther",200);
            $table ->string("Turgon",200);
            $table ->string("SkinElasticly",200);
            $table ->string("MucousMembranes",200);
            $table ->string("tongue",200);
            $table ->string("PhenomenaInQatar",200);
            $table ->string("PhenomenaInQatarYes",200);
            $table ->string("tonsils",200);
            $table ->string("breathing",200);
            $table ->string("KD",200);
            $table ->string("Spo2",200);
            $table ->string("auscultation",200);
            $table ->string("HeartActivity",200);
            $table ->string("SSD",200);
            $table ->string("AKS",200);
            $table ->string("HeartActivitySpecialCondition",200);
            $table ->string("Feed",200);
            $table ->string("LiquidConsuption",200);
            $table ->string("Belly",200);
            $table ->string("BellyHurst",200);
            $table ->string("Liver",200);
            $table ->string("Spleen",200);
            $table ->string("CharmPeristalsis",200);
            $table ->string("Defecating",200);
            $table ->string("DefecatingLiquid",200);
            $table ->string("DefecatingObstipation",200);
            $table ->string("Urinating",200);
            $table ->string("Limbs",200);
            $table ->string("LimbsConfused",200);
            $table ->string("ConsciousnessState",200);
            $table ->string("Meninges",200);
            $table ->string("MeningesIs",200);
            $table ->string("Fireplace",200);
            $table ->string("FireplaceIs",200);
            $table ->string("BblodTest",200);
            $table ->string("CRB",200);
            $table ->string("Urinate",200);
            $table ->string("lye",200);
            $table ->string("glucose",200);
            $table ->string("OtherTest",200);
            $table ->string("BblodTestInfo",200);
            $table ->string("CRBInfo",200);
            $table ->string("UrinateInfo",200);
            $table ->string("lyeInfo",200);
            $table ->string("glucoseInfo",200);
            $table ->string("OtherTestInfo",200);
            $table ->string("WhichChildInFamily",200);
            $table ->string("HasLittleKid",200);
            $table ->string("Pregnancy",200);
            $table ->string("PregnancyComplications",200);
            $table ->string("WasBorn",200);
            $table ->string("NewlyBorn",200);
            $table ->string("NewlyBornpremature",200);
            $table ->string("NewlyBornOverCarried",200);
            $table ->string("BornWeight",200);
            $table ->string("bornComplications",200);
            $table ->string("BornCoplicationsWas",200);
            $table ->string("FeededMothersMilk",200);
            $table ->string("ATMisFeededBy",200);
            $table ->string("evolved",200);
            $table ->string("vaccinated",200);
            $table ->string("vaccinatedReason",200);
            $table ->string("Complaints",200);
            $table ->string("Illnessanamneeze",200);
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
        Schema::dropIfExists('vaiku_stacionarizuojamos');
    }
}
