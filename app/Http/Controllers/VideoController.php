<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Http\Traits\FileUploader1;
use App\Http\Traits\GeneralTrait;
use  App\Http\Resources\videoRessource;
use  App\Http\Resources\VideoCollection;
use App\Models\Video;
use App\Models\Club;
use App\Models\Matche;
use App\Models\association;
class VideoController extends Controller
{use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexvideoclub(Request $request)
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
         
           'informations' => $Club->informvideo()->get(['url','description']),];
       return $this->apiResponse($data, true, null, 200);
       }
   }
   catch (\Exception $ex) {
       return $this->apiResponse(null, false, $ex->getMessage(), 500);
   }
    
    }
    public function indexvideoMeche(Request $request)
    {
        try{
           $Matche = Matche::where('uuid', $request->uuid)->first();
     //      $Club = Club::where('uuid',$request->uuid)->first();
          
       if (!$Matche) {
           $data['message'] = 'No Club found';
           return $this->apiResponse($data, true, null, 200);
       }
       else{
     //   $mm = $Club->information()->get();
     
        $data['Matche'] =[
         
           'informations' => $Matche->informvideo()->get(['url','description']),];
       return $this->apiResponse($data, true, null, 200);
       }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
        public function show(Request $request)
    {
        $Video = Video::where('uuid',$request->uuid)->firstOrFail();
        try{
        
        if (!$Video) {
            $data['message'] = 'No Video found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['Video'] =new videoRessource($Video);
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
        try{ 
            $validator = Validator::make($request->all(), [
                'url' =>'required|string',
             'description'=>'required|string',
             ]);

             if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
             }
             $Video= Video::where('uuid',$request->uuid)->firstOrFail();
           
             
           $Video->update([
                'description'=>$request->description,
                'url'=>$request->url,
               ]) ;
               
               
                $data['Video'] = new videoRessource($Video);

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
    public function storeVideoClubs(Request $request)
    {    try{ 
            $validator = Validator::make($request->all(), [
             'url' =>'required|string',
             'description'=>'required|string',
             ]);

             if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
             }
            $Club = Club::where('uuid', $request->uuid)->first();
             if (!$Club) {
            $data['message'] = 'No Club found';
            return $this->apiResponse($data, true, null, 200);
              }
            else{
           
           $u= $Club->informvideo()->create([
                'uuid'=>Str::uuid(),
             
                'description'=>$request->description,
                'url'=> $request->url,
               ]) ;
              
               }
                $data['Video '] = new videoRessource($u);

                 return $this->apiResponse($data, true, null, 200);
        }  
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
        }
        public function storeVideoAssociation(Request $request)
        {    try{ 
                $validator = Validator::make($request->all(), [
                 'url' =>'required|string',
                 'description'=>'required|string',
                 ]);
    
                 if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
                 }
                $association = association::where('uuid', $request->uuid)->first();
                 if (!$association) {
                $data['message'] = 'No association found';
                return $this->apiResponse($data, true, null, 200);
                  }
                else{
            
               $u= $association->informvideo()->create([
                    'uuid'=>Str::uuid(),
                    'description'=>$request->description,
                    'url'=> $request->url,
                   ]) ;
                  
                   }
                    $data['Video'] = new videoRessource($u);
    
                     return $this->apiResponse($data, true, null, 200);
            }  
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
            }
            public function storeVideoMatche(Request $request)
        {    try{ 
                $validator = Validator::make($request->all(), [
                 'url' =>'required|string',
                 'description'=>'required|string',
                 ]);
    
                 if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
                 }
                $matche=Matche::where('uuid', $request->uuid)->first();
                 if (!$matche) {
                $data['message'] = 'No matche found';
                return $this->apiResponse($data, true, null, 200);
                  }
                else{
              
               $u= $matche->informvideo()->create([
                    'uuid'=>Str::uuid(),
                    'description'=>$request->description,
                    'url'=> $request->url,
                   ]) ;
          
                   }
                    $data['Video'] = new videoRessource($u);
    
                     return $this->apiResponse($data, true, null, 200);
            }  
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
            }
    }
