<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
 
use App\Models\Statistic;
use App\Http\Resources\StatisticResource;
use App\Http\Resources\StatisticCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Models\Matche;
class StatisticController extends Controller
{use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{$s=Matche::where('uuid',$request->uuid)->value('id');
            $Statistic = Statistic::where('matche_id', $s)->get();
           
            $data['Statistic'] = StatisticResource::collection($Statistic);
    
                return $this->apiResponse($data, true, null, 200);
            }
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                
               'name'=>'required|string',
               'value'=>'required',
               'matche_datetime'=>'required',
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
    
            
              
                $matcheDatetime= $request->input('matche_datetime');
               
            
                $matche = Matche::where('datetime', $matcheDatetime)->first();
                if(!$matche){
                       
                    $data['message'] = '  matche not found';
                    return $this->apiResponse($data, true, null, 200);
                }
                $Statistic=Statistic::create([
                    'uuid'=>Str::uuid(),
                
                    'matche_id'=>$matche->id,
                    'name'=>$request->name,
                    'value'=>$request->value,
                  
                ]);
            
            
             
                $data['Statistic'] = new StatisticResource($Statistic);
    
                return $this->apiResponse($data, true, null, 200);
            }
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                
               'name'=>'required|string',
               'value'=>'required',
               'matche_datetime'=>'required',
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
    
            $Statistic = Statistic::where('uuid',$request->uuid)->firstOrFail();
              
                $matcheDatetime= $request->input('matche_datetime');
               
            
                $matche = Matche::where('datetime', $matcheDatetime)->first();
                if(!$matche){
                       
                    $data['message'] = '  matche not found';
                    return $this->apiResponse($data, true, null, 200);
                }
                $Statistic->update([
                   
                
                    'matche_id'=>$matche->id,
                    'name'=>$request->name,
                    'value'=>$request->value,
                  
                ]);
            
            
             
                $data['Statistic'] = new StatisticResource($Statistic);
    
                return $this->apiResponse($data, true, null, 200);
            }
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
