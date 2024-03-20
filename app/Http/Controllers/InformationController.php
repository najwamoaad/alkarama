<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use App\Models\Information;
use App\Models\Club;
use App\Models\Matche;
use App\Models\Seasone;
use App\Http\Resources\InformationResource;
use App\Http\Resources\InformationCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
class InformationController extends Controller
{
    use GeneralTrait;
    use FileUploader1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        
        try {
            
            $information = Information::where('type','news')->orderBy('created_at', 'desc') ->limit(10)->get();
            if (!$information) {
                return $this->notFoundResponse('information not found');
            }

            $data['information']=  InformationResource::collection($information);
            return $this->apiResponse($data,true,null,200);

        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInormtionClub(Request $request)
    {    try{ 
            $validator = Validator::make($request->all(), [
             'title' =>'required|string',
            'content'=>'required|string',
            'type'=>'in:strategy,news,regular,slider',
             'reads'=>'required|integer',
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
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'informatonClub_images';
           $u= $Club->informations()->create([
                'uuid'=>Str::uuid(),
                'title'=>$request->title,
                'content'=>$request->content,
              
                'image'=> $this->storeImage($file, $folder),
                'type'=>$request->type,
                'reads'=>$request->reads,
               ]) ;
                }
               }
                $data['Information'] = new InformationResource($u);

                 return $this->apiResponse($data, true, null, 200);
        }  
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
        }
        public function storeInormtionSeasone(Request $request)
        {    try{ 
                $validator = Validator::make($request->all(), [
                 'title' =>'required|string',
                'content'=>'required|string',
                'type'=>'in:strategy,news,regular,slider',
                 'reads'=>'required|integer',
                 ]);
    
                 if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
                 }
                $Seasone = Seasone::where('uuid', $request->uuid)->first();
                 if (!$Seasone) {
                $data['message'] = 'No Seasone found';
                return $this->apiResponse($data, true, null, 200);
                  }
                else{
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $folder = 'informatonSeasone_images';
               $u= $Seasone->informations()->create([
                    'uuid'=>Str::uuid(),
                    'title'=>$request->title,
                    'content'=>$request->content,
                  
                    'image'=> $this->storeImage($file, $folder),
                    'type'=>$request->type,
                    'reads'=>$request->reads,
                   ]) ;
                    }
                   }
                    $data['Information'] = new InformationResource($u);
    
                     return $this->apiResponse($data, true, null, 200);
            }  
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
            }
            public function storeInormtionMetch(Request $request)
    {    try{ 
            $validator = Validator::make($request->all(), [
             'title' =>'required|string',
            'content'=>'required|string',
            'type'=>'in:strategy,news,regular,slider',
             'reads'=>'required|integer',
             ]);

             if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
             }
            $Matche = Matche::where('uuid', $request->uuid)->first();
             if (!$Matche) {
            $data['message'] = 'No Matche found';
            return $this->apiResponse($data, true, null, 200);
              }
            else{
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'informatonMatche_images';
           $u= $Matche->informations()->create([
                'uuid'=>Str::uuid(),
                'title'=>$request->title,
                'content'=>$request->content,
              
                'image'=> $this->storeImage($file, $folder),
                'type'=>$request->type,
                'reads'=>$request->reads,
               ]) ;
                }
               }
                $data['Information'] = new InformationResource($u);

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
    { $Information = Information::where('uuid',$request->uuid)->firstOrFail();
        try{
        
        if (!$Information) {
            $data['message'] = 'No Information found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['player'] =new InformationResource($Information);
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
        try{ 
            $validator = Validator::make($request->all(), [
             'title' =>'required|string',
            'content'=>'required|string',
            'type'=>'in:strategy,news,regular,slider',
             'reads'=>'required|integer',
             ]);

             if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
             }
             $Information = Information::where('uuid',$request->uuid)->firstOrFail();
           
             $currentImagePath = $Information->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'informatonMatche_images';
           $Information->update([
                 
                'title'=>$request->title,
                'content'=>$request->content,
              
                'image'=> $this->updateImage($file, $folder, $currentImagePath),
                'type'=>$request->type,
                'reads'=>$request->reads,
               ]) ;
                }
               
                $data['Information'] = new InformationResource($Information);

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
    $Information = Information::where('uuid',$request->uuid)->firstOrFail();
     if (!$Information) {
        return $this->notFoundResponse('Information not found.');
    }
        $Information->delete();
        return $this->apiResponse([], true, null, 200);
}
catch (\Exception $ex) {
    return $this->apiResponse(null, false, $ex->getMessage(), 500);
} 
    }
}
