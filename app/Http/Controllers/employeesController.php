<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\employeesRessource;
use App\Http\Resources\employeeCollection;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use  App\Models\Employee;
use App\Models\Sport;


class employeesController extends Controller
{
    use GeneralTrait;
    use FileUploader1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
           // $employee = Employee::all();
            $employee = Employee::where('jop_type',$request->jop_type)->get();
          
            if (!$employee) {
                $data['message'] = 'No  employee found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['employee']= employeesRessource::collection($employee);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
                'work'=>'required|string',
                'jop_type'=>'in:manager,coach',
                
                'sportName' => 'required',
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
            $sportName = $request->input('sportName');
            $sport = Sport::where('name', $sportName)->first();
            
            if(  ( !$sport) ) {
                $data['message'] = 'Sport not found';
                return $this->apiResponse($data, true, null, 200);
            }
                $employee=Employee::create([
                 'uuid'=>Str::uuid(),   
                'name'=>$request->name,
                'work'=>$request->work,
                'jop_type'=>$request->jop_type,
                'sport_id' =>$sport->id,     
                ]);
            
            $data['employee'] = new employeesRessource($employee);
            return $this->apiResponse($data, true, null, 200);     }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
                'work'=>'required|string',
                'jop_type'=>'in:manager,coach',
               
                'sportName' => 'required ',
                
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
            $sportName = $request->input('sportName');
            $sport = Sport::where('name', $sportName)->first();
            $employee = Employee::where('uuid',$request->uuid)->firstOrFail();
            if(  ( !$sport ) ) {
               
                $data['message'] = 'Sport not found';
                return $this->apiResponse($data, true, null, 200);
            }
            $employee->update([
                
                    'name'=>$request->name,
                    'work'=>$request->work,
                    'jop_type'=>$request->jop_type,
                    'sport_id' =>$sport->id,
                ]);
            
            
             
                $data['employee'] = new  employeesRessource( $employee);
    
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
