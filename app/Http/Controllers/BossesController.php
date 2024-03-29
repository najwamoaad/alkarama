<?php

namespace App\Http\Controllers;
use App\Models\Posse;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Http\Resources\BossesRessource;
use App\Http\Resources\BossesCollection;
use Illuminate\Http\Request;

class BossesController extends Controller
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
            $posse = Posse::all();
          
            if ( $posse->isEmpty()) {
                $data['message'] = 'No posse found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['posse']= BossesRessource::collection($posse);
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
                'start_date'=>'required',
              
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $folder = 'bosse_images';
                $bosses=Posse::create([
                    
                    'uuid'=>Str::uuid(),
                    'image'=> $this->storeImage($file, $folder),
                    'name'=>$request->name,
                    'start_date'=>$request->start_date,
                ]);}
            
            $data['bosses'] = new  BossesRessource($bosses);
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
    public function show(Request $request)
    {
        try {
            $posse = Posse::where('uuid',$request->uuid)->firstOrFail();
          
            if (!$posse) {
                $data['message'] = 'No posse found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['posse']=new BossesRessource($posse);
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
    public function update(Request $request )
    {
        try { $validator = Validator::make($request->all(), [
            'name'=>'required|string',
                'start_date'=>'required ',
            
            
        ]);
        $posse = Posse::where('uuid',$request->uuid)->firstOrFail();
        $currentImagePath =  $posse->image;

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'posse_images';
                $posse->update([
                    'image'=> $this->updateImage($file, $folder, $currentImagePath),
                    'name'=>$request->name,
                    'start_date'=>$request->start_date,
            ]);
        }
        
        $data['posse'] = new  BossesRessource( $posse );
      
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
