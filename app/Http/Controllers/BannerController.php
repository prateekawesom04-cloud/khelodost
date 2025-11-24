<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    //
    public function add_banner(Request $request){
        $banners = Banner::all();
        return view('admin.pages.add_banner',compact('banners'));
    }

    public function addBanner(Request $request){
        
        if (!empty($request->allFiles())) {
            $file = $request->file('image');
            $request->image = '/img/'.time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('', $request->image, 'public'); // Store in 'public/uploads'

            $banners = new Banner();
            $banners->image = $request->image;
            $banners->save();
            
            return response()->json([
                'message'=> 'Banner Added Successfully',
                'response_code'=> '200',
            ]);

        } else{
            return response()->json([
                'message'=> 'Upload not available',
                'response_code'=> '101',
            ]);
        }
    }
    
    public function bannerUpdate(Request $request){
        $banner = Banner::where('id',$request->id)->first();
        $banner->status = $banner->status?0:1;
        $banner->save();
        
        return response()->json([
            'message'=> 'Banner Updated Successfully',
            'response_code'=> '200',
        ]);
    }
}
