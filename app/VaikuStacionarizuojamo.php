<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaikuStacionarizuojamo extends Model
{
    protected $table ='traumatologine_forma';
    protected $fillable=['Name','BirthDay','Name','CheckDate','HospitalizationDiagnosis','SendingTo','Treatment','CommonState','Temperature','PainScale',
        'KPL','Pulse','Skin','Rash',
        'Rashis','MucousMembranesOther','Turgon','SkinElasticly',
        'MucousMembranes','tongue','PhenomenaInQatar','PhenomenaInQatarYes','tonsils','breathing','KD',
        'Spo2','auscultation','HeartActivity','SSD','AKS','HeartActivitySpecialCondition','Feed','LiquidConsuption',
        'Belly','BellyHurst','Liver','Spleen','CharmPeristalsis',
        'Defecating','DefecatingLiquid','DefecatingObstipation','Urinating','Limbs','LimbsConfused','ConsciousnessState',
        'Meninges','MeningesIs','Fireplace','FireplaceIs','BblodTest','CRB',
        'Urinate','lye','glucose','OtherTest','BblodTestInfo','CRBInfo','UrinateInfo',
        'lyeInfo','glucoseInfo','OtherTestInfo','WhichChildInFamily','HasLittleKid','Pregnancy','PregnancyComplications',
        'WasBorn','NewlyBorn','NewlyBornpremature','NewlyBornOverCarried','BornWeight','bornComplications',
        'BornCoplicationsWas','ATMisFeededBy','evolved','vaccinated','vaccinatedReason','Complaints','Illnessanamneeze',
        ];
    protected $connection = 'phpMyAdmin';
}
