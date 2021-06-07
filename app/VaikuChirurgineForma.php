<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaikuChirurgineForma extends Model
{
    protected $table ='vaiku_chirurgine_forma';
    protected $fillable=['coments','BirthDay','Name','MedicalNrID','CheckDate','GoingStationary','MandatoryHelp','NeededHelpCategory','ComplainsAndAnamnisis','Alergy',
        'AlergyToWhom','EpidemicAnamnisis','EpidemicAnamnisisHurts','Epidemic',
        'EpidemicWas','OperationSelection','OperationSimptoms','Diagnosis',
        'CommonState','Temperature','Pain','slime','slimeOther','turgor','KLP',
        'pulse','breathing','breathingRight','breathingLeft','Heart','SSD','AKS','belly',
        'bellySlightlyPainful','bellyPainful','Abdomen','AbdomenIfIs','Voids',
        'VoidDayCount','Peristalsis','Urination','UrinationWhen','Organs','OrgansChanges','menstruation',
        'SpecialCondition','InvestigationPlan','CommonBlodTest','UraneTest','CRB','BellyEchoscopy',
        'AnesthesiologistConsultation','FinalDiagnosis','conclusion','conclusionDepartment','recomendations','Diet','Mode'];
    protected $connection = 'phpMyAdmin';
}
