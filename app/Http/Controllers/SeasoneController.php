<?php

namespace App\Http\Controllers;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Http\Resources\SeasoneResource;
use App\Models\Seasone;
use Illuminate\Http\Request;

class SeasoneController extends Controller
{use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
              
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ],[
               
                'end_date.after' => ' the to Date must be after the start date',
             
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
             
                $Seasone=Seasone::create([
                    
                    'uuid'=>Str::uuid(),
                   
                    'name'=>$request->name,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                ]);
            
            $data['Seasone'] = new  SeasoneResource($Seasone);
            return $this->apiResponse($data, true, null, 200);     }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

   
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
        try { $validator = Validator::make($request->all(), [
            'name'=>'required|string',
              
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ],[
               
                'end_date.after' => ' the to Date must be after the start date',
             
                
            ]);
        $Seasone = Seasone::where('uuid',$request->uuid)->firstOrFail();
       

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
          
                $Seasone->update([
                    'name'=>$request->name,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
            ]);
      
        
            $data['Seasone'] = new  SeasoneResource($Seasone);
      
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
