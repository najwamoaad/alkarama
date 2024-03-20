<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Models\Sport;
use App\Http\Resources\SportResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Http\Traits\FileUploader1;
class SportController extends Controller
{use GeneralTrait;
    use FileUploader1;
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
        $validator = Validator::make($request->all(), [
            'name' =>'required|string|unique:sports',
          
            
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'sport_images';
            $Sport=Sport::create([
                'uuid'=>Str::uuid(),
                'name'=>$request->name,
                'image'=> $this->storeImage($file, $folder),
               
            ]);
        }
        
         
            $data['Sport'] = new SportResource($Sport);

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
    public function show(Request $request)
    {
        $Sport = Sport::where('name',$request->name)->firstOrFail();
        try{
        
        if (!$Sport) {
            $data['message'] = 'No Sport found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['Sport'] =new SportResource($Sport);
        return $this->apiResponse($data, true, null, 200);
    }
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
    public function update(Request $request)
    {
        try {
            $Sport = Sport::where('uuid',$request->uuid)->firstOrFail();
        $currentImagePath = $Sport->image;
    
        $validator = Validator::make($request->all(), [
            'name' =>'required|string',
          
            
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'sport_images';
            $Sport->update([
                'name'=>$request->name,
                'image'=> $this->updateImage($file, $folder, $currentImagePath),
                 
            ]);
        }
        
         
            $data['Sport'] = new SportResource($Sport);

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
    public function destroy(Request $request)
    {
        try
{      
    $Sport = Sport::where('uuid',$request->uuid)->firstOrFail();
     if (!$Sport) {
        return $this->notFoundResponse('Sport not found.');
    }
        $Sport->delete();
        return $this->apiResponse([], true, null, 200);
}
catch (\Exception $ex) {
    return $this->apiResponse(null, false, $ex->getMessage(), 500);
}
    }
}
