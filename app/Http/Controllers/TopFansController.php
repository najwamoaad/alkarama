<?php

namespace App\Http\Controllers;
use App\Http\Resources\TopFansRessource ;
use App\Http\Resources\TopFansCollection;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Models\TopFans;
use App\Models\association;
use Illuminate\Http\Request;

class TopFansController extends Controller
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
            $topfans = TopFans::all();
          
            if ( $topfans->isEmpty()) {
                $data['message'] = 'No topfans found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['topfans']= TopFansRessource::collection($topfans);
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
                'associationName' => 'required'
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
            $associationName = $request->input('associationName');
            $association = association::where('boss', $associationName)->first();
            
            if(  ( ! $association) ) {
               
                $data['message'] = ' association not found';
                return $this->apiResponse($data, true, null, 200);
            }
                
                $TopFans =TopFans::create([
                    
                    'uuid'=>Str::uuid(),
                    'association_id'=>$association->id,
                    'name'=>$request->name,
                    
                ]);
            
            $data['TopFans'] = new TopFansRessource($TopFans);
            return $this->apiResponse($data, true, null, 200);  }
            catch (\Exception $ex) 
        {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
           
            $boss = $request->input('boss');
 
            $association = association::where('boss', $boss)->first();
            $topfans = TopFans::where('association_id',$association->id)->get();
            if ( $topfans->isEmpty()) {
                $data['message'] = 'No topfans found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['topfans']= TopFansRessource::collection($topfans);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
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
        try { $validator = Validator::make($request->all(), [
            'name'=>'required|string',
                'associationName' => 'required'
            
        ]);
        $TopFans = TopFans::where('uuid',$request->uuid)->firstOrFail();
        $associationName = $request->input('associationName');
        $association = association::where('boss',$associationName)->first();
     
            if(  ( !$association) ) {
               
                $data['message'] = 'association not found';
                return $this->apiResponse($data, true, null, 200);
            }
        $currentImagePath =  $TopFans->image;
   
        

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
             
                $TopFans->update([
                 
                    'association_id'=>$association->id,
                    'name'=>$request->name,
            ]);
       
        
        $data['TopFans'] = new TopFansRessource( $TopFans);
      
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
