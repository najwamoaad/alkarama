<?php

namespace App\Http\Controllers;
use App\Http\Resources\PrimesRessource ;
use App\Http\Resources\PrimesCollection;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Models\Prime;
use App\Models\Sport;
use App\Models\Seasone;
use Illuminate\Http\Request;

class PrimesController extends Controller
{use GeneralTrait;
    use FileUploader1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
           // $prime = Prime::all();
           $prime  = Prime::where('type',"personal")->get();
          
            if (!$prime) {
                $data['message'] = 'No  prime found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['prime']= PrimesRessource::collection($prime);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
    public function index1()
    {
        try {
           // $prime = Prime::all();
           $prime  = Prime::where('type',"club")->get();
          
            if (!$prime) {
                $data['message'] = 'No  prime found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['prime']= PrimesRessource::collection($prime);
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
                'description'=>'required|string',
                'type'=>'in:personal,club',
               
                'sportname' => 'required',
                'seasonename' => 'required'
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
            $sportName = $request->input('sportname');
            $seasoneName = $request->input('seasonename');
            $Seasone = Seasone::where('name', $seasoneName)->first();
            $sport = Sport::where('name', $sportName)->first();
            
            if(  ( !$sport ||!$Seasone) ) {
               
                $data['message'] = 'Sport not found';
                return $this->apiResponse($data, true, null, 200);
            }
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $folder = 'prime_images';
                $prime=Prime::create([
                    
            
                 'uuid'=>Str::uuid(),   
                'name'=>$request->name,
                'image'=> $this->storeImage($file, $folder),
                'description'=>$request->description,
                'type'=>$request->type,
                
                //'personal,club',sport
                'sport_id' =>$sport->id,
                'seasone_id'=>$Seasone->id,
              
                    
                ]);}
            
            $data['prime'] = new PrimesRessource( $prime);
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
                'description'=>'required|string',
                'type'=>'in:personal,club',
               
                'sportname' => 'required',
                'seasonename' => 'required'
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
            $sportName = $request->input('sportname');
            $seasoneName = $request->input('seasonename');
            $Seasone = Seasone::where('name', $seasoneName)->first();
            $sport = Sport::where('name', $sportName)->first();
            $prime = Prime::where('uuid',$request->uuid)->firstOrFail();
            if(  ( !$sport ||!$Seasone) ) {
               
                $data['message'] = 'Sport not found';
                return $this->apiResponse($data, true, null, 200);
            }
            $currentImagePath = $prime->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'prime_images';
                $prime->update([
                //'personal,club',
                    'name'=>$request->name,
                    'type'=>$request->type,
                    'description'=>$request->description,
                    'sport_id' =>$sport->id,
                    'seasone_id'=>$Seasone->id,
                    'image'=> $this->updateImage($file, $folder, $currentImagePath),
                ]);
            }
            
             
                $data['prime'] = new PrimesRessource($prime);
    
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
