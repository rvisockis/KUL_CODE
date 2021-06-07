<?php


Route::get('/test', 'GetDiagnosisController@index');
Route::get('/scanmed', 'ScanMed@index');
Route::get('/tryoauth', 'TestAuthController@index');
Route::get('/livingsubjectsinfo', function (){
    //return App\OracleLivingSubject::where('DISPLAY_CODE','38204231205')->get();
    //return App\OracleLivingSubject::chunk(100)->get();
    return App\OracleLivingSubject::take(20)->get();
});
Route::group(['prefix' => 'api/'], function() {
    Route::resource('patienthospitalization', 'InPatientHospitalizationController');
    Route::resource('genradpatientlistpdf', 'GenerationRadiologyPatientListInPdfController');
    Route::resource('verifySinglePack', 'SendCode');
    Route::resource('supplySinglePack', 'SendForSuplly');
    Route::resource('decommissionSinglePack', 'SendForDecommission');
    Route::resource('reactivateSinglePack', 'SendForReactivation');
    Route::resource('processingBulkPack', 'SendBulkPack');
    Route::resource('checkBulkStatus', 'CheckBulkPackAnswerController');
    //New information in new system
    Route::resource('getPatient', 'GetDiagnosisController');
    Route::resource('getPatientHistory', 'GetDiagnosisHistoryController');
    Route::resource('getDiagnosisList','GetDiagnosisListController');
    Route::resource('SendSelected_Diagnosis','Selected_DiagnosisController');
    Route::resource('SendInformation','Information_EpicrisisController');
    Route::resource('GetHistory','GetHistoryEpicrisisController');
    Route::resource('getDayPatient','DayPatientController');
    Route::resource('SendMedicalPost','MedicalPostingController');
    Route::resource('getSpeciality','SpecialityController');
    Route::resource('getTestControler','SiaipPaziurejimuiController');
    Route::resource('getCacheDiagnosis','DiagnosisCacheController');
    Route::resource('getCacheEpicrisis','EpicrisisCacheController');
    Route::resource('CheckPostings','CheckPostings');

    //F025
    Route::resource('getSpecialistName','GetSpecialistNameController');
    Route::resource('getSusijusioDokNr', 'GetSusijusioDokNrController');
    Route::resource('getKortelesNr', 'GetKortelesNrController');
    Route::resource('getPaskirtis', 'GetPaskirtisController');
    Route::resource('getApSiuntimas', 'GetApSiuntimasController');
    Route::resource('getApBrigada', 'GetApBrigadaController');
    Route::resource('getApButinoji', 'GetApButinojiController');
    Route::resource('getApPSDF', 'GetApPSDFController');
    Route::resource('getDraustumas', 'GetDraustumasController');
    Route::resource('getFullInfoID', 'GetFullInfoIDController');
    Route::resource('getF025Diagnosis', 'GetF025DiagnosisController');
    Route::resource('getAtidarymoData', 'GetAtidarymoDataController');
    Route::resource('getUzdarymoData', 'GetUzdarymoDataController');
    Route::resource('getAtsakingasAsmuo', 'GetAtsakingasAsmuoController');
    Route::resource('getApsilankymai', 'GetApsilankymaiController');
    Route::resource('getApsilankymoTipas', 'GetApsilankymoTipasController');
    Route::resource('getIntervencija', 'GetIntervencijaController');
    Route::resource('getPriemoka', 'GetPriemokaController');
    Route::resource('getTest', 'GetTestController');
    Route::resource('getVizitai', 'VizituController');
    Route::resource('getPaslaugosList', 'GetPaslaugosListController');
    Route::resource('getVisits', 'FullVisitController');
    Route::resource('getPaslaugosListPage', 'GetPaslaugosListPageController');
    Route::resource('getVisitType', 'FullVisitTypeController');
    Route::resource('getVisitIntervention', 'FullVisitInterventionController');
    Route::resource('getVisitPayment', 'FullVisitPaymentController');
    Route::resource('getFullDiagnosis', 'FullVisitDiagnosisController');
    Route::resource('getFullInfo', 'GetFullInfoController');
    Route::resource('getOperacijuPlanas', 'GetOperacijuPlanasController');

//Formos
    Route::resource('getTraumFormos', 'GetTraumFormosController');
    Route::resource('getTraumFormosData', 'GetTraumFormosDataController');

//    NDNT
    Route::resource('NDNT', 'NDNTController');


//Lab
    Route::resource('getLabTest', 'LabRequestsController');
    Route::resource('getLabTestAll', 'LabTestListController');
    Route::resource('getLabTestData', 'TestsDataController');
    Route::resource('getAnalites', 'LabAnalitesController');
    Route::resource('getTestsName', 'LabTestData');
    Route::resource('getLabTestAnalites','LabTestAnaliteController');

//Tel_nr
    Route::resource('getTelefonuNumeriai','GetTelefonuNumeriai');

//IPR
    Route::resource('getIPRRegistracijos', 'GetIPRRegistracijos');
    Route::resource('getClientIP', 'RequestIP');



});

Route::get('/{any}', function(){
    return view('welcome');
})->where('any', '.*');
