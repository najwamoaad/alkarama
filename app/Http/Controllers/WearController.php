<?php

namespace App\Http\Controllers;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Http\Request;
use App\Models\Wear;
use App\Models\Sport;
use App\Models\Seasone;
use App\Http\Resources\WearResource;
use App\Http\Resources\WearCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;

class WearController extends Controller
{ use GeneralTrait;
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
    {  try {
        $validator = Validator::make($request->all(), [
        
            'sport_name'=>'required|string',
            'seasone_name'=>'required|string',
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
        $sportName = $request->input('sport_name');
        $seasoneName = $request->input('seasone_name');
       
        $sport = Sport::where('name', $sportName)->first();
        $Seasone = Seasone::where('name', $seasoneName)->first();
        if( (!$sport||!$Seasone) ) {
           
            $data['message'] = 'Sport || Seasone not found';
            return $this->apiResponse($data, true, null, 200);
        }
       
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'Wear_images';
            $Wear=Wear::create([
                'uuid'=>Str::uuid(),
                'image'=> $this->storeImage($file, $folder),
                'sport_id'=>$sport->id,
                'seasone_id'=>$Seasone->id,
            ]);
        
            }
         
            $data['Wear'] = new WearResource($Wear);

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
            'sport_name'=>'required|string',
            'seasone_name'=>'required|string',
            
        ]);
            $Wear = Wear::where('uuid',$request->uuid)->firstOrFail();
            $sportName = $request->input('sport_name');
            $seasoneName = $request->input('seasone_name');
           
            $sport = Sport::where('name', $sportName)->first();
            $Seasone = Seasone::where('name', $seasoneName)->first();
            if(  ( !$sport||!$Seasone) ) {
               
                $data['message'] = 'Sport || Seasone not found';
                return $this->apiResponse($data, true, null, 200);
            }
        $currentImagePath = $Wear->image;
       
        

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'Wear_images';
            $Wear->update([
                'sport_id'=>$sport->id,
                'seasone_id'=>$Seasone->id,
                'image'=> $this->updateImage($file, $folder, $currentImagePath),
                 
            ]);
        }
        
         
            $data['Wear'] = new WearResource($Wear);

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

    public function showPlayerClothings(Request $request)
    { try{
        
        $seasonName=$request->seasonName;
        $sportName=$request->sportName;
        $playerClothings = Wear::whereHas('sport', function ($query) use ($sportName) {
            $query->where('name', $sportName);
        })->whereHas('seasone', function ($query) use ($seasonName) {
            $query->where('name', $seasonName);
        })->get();

        
        
            if (!$playerClothings) {
                $data['message'] = 'No playerClothings found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['playerClothings'] =WearResource::collection($playerClothings);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
}
