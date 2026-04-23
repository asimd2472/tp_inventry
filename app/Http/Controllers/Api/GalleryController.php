<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // public function send_brochures(Request $request)
    // {
    //     set_time_limit(600);

    //     $user_mail = $request->email;
    //     $fileIds = $request->get('files', []);

    //     $brochures = Gallery::where('type', 'brochure')
    //         ->whereIn('id', $fileIds) // <-- filter by IDs
    //         ->get();

    //     if ($brochures->count() > 0) {

    //         $body = "<p>Dear Team,</p><p>Please find attached brochures.</p>";

    //         \Mail::html($body, function ($message) use ($brochures, $user_mail) {

    //             $message->to($user_mail)
    //                 ->subject('Tata Pravesh Brochures');

    //             foreach ($brochures as $file) {

    //                 $filePath = public_path('gallery/' . $file->file_name);

    //                 if (file_exists($filePath)) {
    //                     $message->attach($filePath, [
    //                         'as' => $file->file_name,
    //                         'mime' => mime_content_type($filePath),
    //                     ]);
    //                 }
    //             }
    //         });
    //     }

    //     return response()->json([
    //         'status' => 1,
    //         'msg' => 'Email sent with selected brochures'
    //     ]);
    // }

    public function send_brochures(Request $request)
    {
        set_time_limit(600);

        $user_mail = $request->email;
        $fileIds = $request->get('files', []);

        $brochures = Gallery::where('type', 'brochure')
            ->whereIn('id', $fileIds)
            ->get();

        // dd($brochures);

        if ($brochures->count() > 0) {

            $body = "<p>Dear Team,</p>";
            $body .= "<p>Please download brochures from below links:</p><ul>";

            foreach ($brochures as $file) {
                $url = url('gallery/' . $file->file_name);
                $body .= "<li style='margin-bottom: 5px;'>
                            <a href='{$url}' target='_blank'>Download {$file->file_name}</a>
                        </li>";
            }

            $body .= "</ul>";

            // ✅ Send email WITHOUT attachments
            \Mail::html($body, function ($message) use ($user_mail) {

                $message->to($user_mail)
                    ->subject('Tata Pravesh Brochures');
            });
        }

        return response()->json([
            'status' => 1,
            'msg' => 'Email sent with download links'
        ]);
    }

    public function send_dealers(Request $request)
    {
        set_time_limit(600);

        $user_mail = $request->email;

        $dealers = Gallery::where('type', 'dealers')
            ->orderBy('id', 'desc')
            ->first();

        if ($dealers->count() > 0) {

            $body = "<p>Dear Team,</p><p>Please find attached dealers.</p>";

            \Mail::html($body, function ($message) use ($dealers, $user_mail) {

                $message->to($user_mail)
                    ->subject('Tata Pravesh Dealers List');

                $filePath = public_path('gallery/' . $dealers->file_name);

                if (file_exists($filePath)) {
                    $message->attach($filePath, [
                        'as' => $dealers->file_name,
                        'mime' => mime_content_type($filePath),
                    ]);
                }
            });
        }

        return response()->json([
            'status' => 1,
            'msg' => 'Email sent with selected brochures'
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
