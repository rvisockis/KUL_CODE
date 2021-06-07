<?php

namespace App\Traits;

use App\OracleLivingSubject;
use App\OracleLivingSubjectName;
use App\OracleSicknessCase;
use Validator;
use Carbon;
use Illuminate\Support\Facades\DB;

trait FilterPaginateOrder {

    protected $operators = [
        'equal_to' => '=',
        'not_equal' => '<>',
        'less_than' => '<',
        'greater_than' => '>',
        'less_than_or_equal_to' => '<=',
        'greater_than_or_equal_to' => '>=',
        'in' => 'IN',
        'not_in' => 'NOT_IN',
        'like' => 'LIKE',
        'between' => 'BETWEEN'
    ];

    public function scopeFilterPaginateOrder($query)
    {
        $request = request();

        $v = Validator::make($request->all(), [
            'column' => 'required|in:'.implode(',', $this->filter),
            'direction' => 'required|in:asc,desc',
            'per_page' => 'required|integer|min:1',
            'search_operator' => 'required|in:'.implode(',', array_keys($this->operators)),
            'search_column' => 'required|in:'.implode(',', $this->filter),
            'validateMore14' => 'required|in:true,false',
            'searchableText' => 'max:255',
            'search_query_2' => 'max:255',
        ]);
//        dd(mb_strtoupper($request->searchableText));
//        sleep(2);


        if($v->fails()) {

            //for debug
            dd($v->messages());
        }

//        /$sicknessCases=
//        return $query->with(['sicknessCaseWithVisit'=> function($query){
//            $query->where('visit_status_dova_code','=','OPENED');
//            $query->where('visit_type_dova_code','=','STAT');
//            $query->addSelect('visit_type_dova_code');
//        }])
//            ->where('sickness_case_status_dova_code','=','OPENED')
//            ->where('sickness_case_type_dova_code','=','STAT')
//            ->GET();

        $patientNames = DB::connection('oracle')->table('LIVING_SUBJECT_LINK as patientLink')
            ->join('LIVING_SUBJECT_NAME as patientName', 'patientLink.correct_living_subject_id','=','patientName.living_subject_id')
//            ->where('patientLink.status_dova_code','=','ACTIVE')
                ->whereNull('patientName.end_date')
            ->selectRaw("patientLink.living_subject_id as patientid, patientName.first||' '||patientName.last as fullName");

        $wardClassificator = DB::connection('oracle')->table('STRUCTURE_UNIT as unit')
            ->join('STUN_CURE_TYPE as unitType', function($join) {
                $join->on('unitType.structure_unit_id', '=', 'unit.id')
                    ->where('unitType.cure_type_dova_code', '=', 'STAT')
                    ->whereNull('unitType.end_date');
                    })
            ->join('ORGANIZATION as org', function($join){
                $join->on('org.id', '=', 'unit.id')
                    ->whereNull('org.end_date')
                    ->where('org.scoping_organization_id','=','1');
            })
        ->select('unit.id as unit_id', 'org.display_name as org_name');
        //Visit information for sickness case
        $visitInformation = DB::connection('oracle')->table('VISIT as visit')
            ->joinSub($wardClassificator,'ward_names', function($join){
                $join->on('ward_names.unit_id','=','visit.structure_unit_id');
            })
            ->where('visit.visit_status_dova_code','=','OPENED')
              ->select('visit.sickness_case_id as case_number', 'ward_names.org_name as ward_name');
            //        ----
            //       General case
        $allSicknessCases = DB::connection('oracle')->table('SICKNESS_CASE as sickness')
            ->joinSub($patientNames,'patient_names', function($join){
                $join->on('patient_names.patientid','=','sickness.person_link_id');
            })
            ->joinSub($visitInformation,'visit_information', function($join){
                $join->on('visit_information.case_number','=','sickness.id');
            })
            ->select('sickness.case_number as case_number','patient_names.fullName as full_name','visit_information.ward_name as ward_name','sickness.start_date')
            ->selectRaw('TRUNC(SYSDATE-start_date)+1 AS days_in_hospital')
            ->where(function($query) use ($request){
                if($request->validateMore14=="true"){
                    $query->whereRaw('TRUNC(SYSDATE-start_date)+1>14');
                }
                if($request->searchableText!=''){
                    $query->whereRaw("UPPER(ward_name) LIKE '%".mb_strtoupper($request->searchableText)."%'");
                }
            })
//            ->select('sickness.case_number','patient_names.fullName')
            ->orderBy($request->column, $request->direction)
            ->orderBy('start_date', 'ASC')
            ->paginate($request->per_page);
        return $allSicknessCases;

//        $sicknessCases = $query->where('sickness_case_type_dova_code','=','STAT')->where('sickness_case_status_dova_code','=','OPENED')->selectRaw('case_number,person_link_id,TRUNC(SYSDATE-start_date)+1 AS days_in_hospital')->get();
//                //return $sicknessCases;
//                            return DB::connection('oracle')->table('living_subject_name as patient')
//                ->paginate(10);
//        //dd($request);
//        return $query->selectRaw('case_number as case_number, start_date as start_date, trunc(sysdate-start_date)+1 as days_in_hospital, b.sickness_case_id')
//            ->whereRaw("id in(select b.sickness_case_id from visit b where b.visit_status_dova_code='OPENED')")->paginate($request->per_page);
//        return DB::connection('oracle')->select(DB::connection('oracle')->selectRaw('select d.display_name as ward_name, a.case_number as case_number, g.first ||\' \'|| g.last as full_name, a.start_date as start_date, trunc(sysdate-a.start_date)+1 as days_in_hospital
//from sickness_case a, visit b, structure_unit c,  organization d, living_subject e, living_subject_link f, living_subject_name g
//where (a.sickness_case_type_dova_code=\'STAT\' and a.sickness_case_status_dova_code=\'OPENED\' and  b.visit_status_dova_code=\'OPENED\')
//and a.id = b.sickness_case_id
//and b.structure_unit_id = c.id
//and (c.end_date is null)
//and c.id = d.id
//and a.person_link_id = e.id
//and (e.id = f.correct_living_subject_id and f.status_dova_code=\'ACTIVE\')
//and (f.correct_living_subject_id = g.living_subject_id)'))->paginate($request->per_page);
//            return $query
//            ->with(['sicknessCaseWithVisit' => function($query) use($request){
//                    $query->where('visit_status_dova_code','=','OPENED');
//                    $query->orderBy('visit_status_dova_code',$request->direction);
//                    $query->with(['visitWithStructureUnit'=>function($query){
//                    $query->with(['structureUnitWithOrganization']);
//                    }]);
//            }])
//            ->with(['sicknessCaseWithLivingSubject' => function($query) use($request){
//                $query->with(['livingSubjectWithLivingSubjecLink'=>function($query)  use($request){
//                    $query->where('status_dova_code','ACTIVE');
//                    $query->with(['livingSubjectLinkWithLivingSubjectName'=>function($query)  use($request){
//                        $query->select('livingSubjectLinkWithLivingSubjectName.last');
//                        $query->orderBy('last', $request->direction);
//                    }]);
//                }]);
//            }])
//                ->join('VISIT as v', function($join){
//                    $join->on('v.sickness_case_id','=','SICKNESS_CASE.id')
//                        ->where('v.visit_status_dova_code','=','OPENED');
//                    $join('STRUCTURE_UNIT as str', function($join){
//                        $join->on('str.structure_unit_id','=','id');
//                        $join('ORGANIZATION as org',function($join){
//                           $join->on('org.id','=','str.id');
//                        });
//                    });
//        })
//                ->select('v.start_date')
//                ->select('id','case_number','t.start_date','person_link_id')
                //->selectRaw('TRUNC(SYSDATE-start_date)+1 AS days_in_hospital')
                //->where('sickness_case_type_dova_code','=','STAT')
                //->where('sickness_case_status_dova_code','=','OPENED')
//            ->orderBy($request->column, $request->direction)
//            ->orderBy($request->column, $request->direction)
//                ->paginate($request->per_page);

//        return $query->orderBy($request->column, $request->direction)
//            ->where(function($query) use ($request) {
//                // check if search query is empty
//                if($request->has('search_query_1')) {
//                    // determine the type of search_column
//                    // check if its related model, eg: customer.id
//                    if($this->isRelatedColumn($request)) {
//                        list($relation, $relatedColumn) = explode('.', $request->search_column);
//                        return $query->whereHas($relation, function($query) use ($relatedColumn, $request) {
//                            return $this->buildQuery(
//                                $relatedColumn,
//                                $request->search_operator,
//                                $request,
//                                $query
//                            );
//                        });
//                    } else {
//                        // regular column
//                        return $this->buildQuery(
//                            $request->search_column,
//                            $request->search_operator,
//                            $request,
//                            $query
//                        );
//                    }
//                }
//            })
//            ->paginate($request->per_page);

    }

    protected function isRelatedColumn($request)
    {
        return strpos($request->search_column, '.') !== false;
    }

    protected function getFullName($request)
    {
        return $fullNamePatient = DB::connection('oracle')
            ->table('LIVING_SUBJECT_NAME as t1')
            ->where('living_subject_id','=',$request)
            ->select('t1.last')->get();
    }

    protected function buildQuery($column, $operator, $request, $query)
    {
        switch ($operator) {
            case 'equal_to':
            case 'not_equal':
            case 'less_than':
            case 'greater_than':
            case 'less_than_or_equal_to':
            case 'greater_than_or_equal_to':
                $query->where($column, $this->operators[$operator], $request->search_query_1);
                break;
            case 'in':
                $query->whereIn($column, explode(',', $request->search_query_1));
                break;
            case 'not_in':
                $query->whereNotIn($column, explode(',', $request->search_query_1));
                break;
            case 'like':
                $query->where($column, 'like', '%'.$request->search_query_1.'%');
                break;
            case 'between':
                $query->whereBetween($column, [
                    $request->search_query_1,
                    $request->search_query_2
                ]);
                break;
            default:
                throw new Exception('Invalid Search Operator', 1);
                break;
        }

        return $query;
    }
}