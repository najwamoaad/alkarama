<?php

namespace App\Http\Controllers;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Http\Resources\ClubResource;
use App\Http\Resources\ClubCollection;
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
            ]) ;
        
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
    public function showRegular(Request $request)
    {
        $dataa = [];
         try{
            $Club = Club::where('uuid', $request->uuid)->first();
      //      $Club = Club::where('uuid',$request->uuid)->first();
           
        if (!$Club) {
            $data['message'] = 'No Club found';
            return $this->apiResponse($data, true, null, 200);
        }
        else{
      //   $mm = $Club->information()->get();
      
         $data['Club'] =[
            'clubname' => $Club->name,
            'clubadd' => $Club->address,
            'clublogo' => $Club->logo,
            'informations' => $Club->informations()->where('type', 'regular')->get(['title', 'content','image']),];
        return $this->apiResponse($data, true, null, 200);
        }
    }
    catch (\Exception $ex) {
        return $this->apiResponse(null, false, $ex->getMessage(), 500);
    }
    }
    public function showStrategy(Request $request)
    {
        $dataa = [];
         try{
            $Club = Club::where('uuid', $request->uuid)->first();
      //      $Club = Club::where('uuid',$request->uuid)->first();
           
        if (!$Club) {
            $data['message'] = 'No Club found';
            return $this->apiResponse($data, true, null, 200);
        }
        else{
      //   $mm = $Club->information()->get();
      
         $data['Club'] =[
             
           
            'clublogo' => $Club->logo,
            'informations' => $Club->informations()->where('type', 'strategy')->get(['title', 'content']),];
        return $this->apiResponse($data, true, null, 200);
        }
    }
    catch (\Exception $ex) {
        return $this->apiResponse(null, false, $ex->getMessage(), 500);
    }
    }
   
    public function showSlider(Request $request)
    {
        
         try{
            $Club = Club::where('uuid', $request->uuid)->first();
      //      $Club = Club::where('uuid',$request->uuid)->first();
           
        if (!$Club) {
            $data['message'] = 'No Club found';
            return $this->apiResponse($data, true, null, 200);
        }
        else{
      //   $mm = $Club->information()->get();
      
         $data['Club'] =[
          
            'informations' => $Club->informations()->where('type', 'slider')->get(['image']),];
        return $this->apiResponse($data, true, null, 200);
        }
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
