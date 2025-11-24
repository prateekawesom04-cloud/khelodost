<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market;

class MarketController extends Controller
{
    //
    public function block_market(){
        $markets = Market::all();
        return view('admin.pages.block_market',compact('markets'));
    }

    public function marketUpdate(Request $request){
        $market = Market::where('name',$request->name)->first();
        $market->status = $market->status?0:1;
        $market->save();
        
        return response()->json([
            'message'=> 'Market Updated Successfully',
            'response_code'=> '200',
        ]);
    }
}
