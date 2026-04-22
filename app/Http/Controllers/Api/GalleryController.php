<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function send_brochures(Request $request)
    {
        set_time_limit(600);    
        $user_mail = $request->email;
        $brochures = Gallery::where('type', 'brochure')->get();

        if ($brochures->count() > 0) {

            $body = "<p>Dear Team,</p><p>Please find attached brochures.</p>";

            \Mail::html($body, function ($message) use ($brochures, $user_mail) {

                $message->to($user_mail)
                    ->subject('Tata Pravesh Brochures');

                foreach ($brochures as $file) {

                    $filePath = public_path('gallery/' . $file->file_name);

                    if (file_exists($filePath)) {
                        $message->attach($filePath, [
                            'as' => $file->file_name,
                            'mime' => mime_content_type($filePath),
                        ]);
                    }
                }
            });
        }

        return response()->json([
            'status' => 1,
            'msg' => 'Email sent with brochures'
        ]);
    }

    public function get_brochures(){
        $brochures = Gallery::where('type', 'brochure')->get();
        return response()->json([
            'status' => 1,
            'brochures' => $brochures
        ]);
    }
}
