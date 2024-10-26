<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
  public function store(Request $request){
    $request->validate([
        'url'=> 'required|url'
    ]);
  
    $shortCode = ShortUrl::generateShortCode();
    $shortUrl = ShortUrl::create([
        'original_url'=>$request->input('url'),
        'short_code'=>$shortCode
    ]);

    return response()->json([
        'original_url'=>$shortUrl->original_url,
        'short_url'=> url('/'. $shortCode)
    ]);

  }

  public function redirect($code){
    $shortUrl = ShortUrl::where('short_code',$code)->first();
    return redirect()->to($shortUrl->original_url);
  }
}
