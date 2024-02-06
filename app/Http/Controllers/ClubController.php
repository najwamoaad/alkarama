<?php

namespace App\Http\Controllers;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Http\Resources\ClubResource;
 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
 

class ClubController extends Controller
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
            'name' =>'required|string',
           'address'=>'required|string',
           'sport_id'=>'required|string|exists:sports,id',
            
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $folder = 'clubs_images';
            $Club=Club::create([
                'uuid'=>Str::uuid(),
                'name'=>$request->name,
                'address'=>$request->address,
              
                'logo'=> $this->storeImage($file, $folder),
                'sport_id'=>$request->sport_id
            ])->information()->create([

                
            ]);
        }
        
         
            $data['Club'] = new ClubResource($Club);

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
    public function update(Request $request, $id)
    {
        //
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
