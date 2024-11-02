<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstagramController extends Controller
{
    public function getLatestImages(Request $request)
    {
        try {
            $url = "https://graph.instagram.com/me/media";
            $token = config('app.instagram_access_token');
            $fields = "id,media_type,media_url,shortcode";
            $limit = 15;

            $response = Http::get($url, ['fields' => $fields,'access_token' => $token, 'limit' => $limit]);

            if ($response->successful()) {

                $data = collect($response->json('data', null));

                $images = $data->filter(function ($media) {
                    return $media['media_type'] === 'IMAGE';

                })->take(1);

                return response()->json($images->values());
            }

        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
