<?php


namespace App\Http\Controllers;

use App\SpecialistName;
class GetSpecialistNameController extends Controller
{
    public function index()
    {
        $Str= implode("",$_GET);
        $SpecialistName = SpecialistName::where('display_name', 'like', "%$Str%")->select('*')->take(10)->get();
        return $SpecialistName;
    }
}