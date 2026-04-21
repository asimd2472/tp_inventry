<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function gallery()
    {   
        $dealers = Gallery::where('type', 'dealers')->get();
        $brochure = Gallery::where('type', 'brochure')->get();
        return view('admin.gallery.index', compact('dealers', 'brochure'));
    } 
    
    public function brochure_upload(Request $request)
    {
        $request->validate([
            'file_name' => 'required|array',
            'file_name.*' => 'file|mimes:pdf,doc,docx',
        ]);

        if ($request->hasFile('file_name')) {
            foreach ($request->file('file_name') as $file) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('public/gallery', $fileName);
                Gallery::create([
                    'type' => 'brochure',
                    'file_name' => $fileName
                ]);
            }
        }
        return response()->json([
            'status' => 1,
            'msg' => 'Brochures uploaded successfully.'
        ]);
    }
    public function dealers_upload(Request $request)
    {
        $request->validate([
            'file_name' => 'required|array',
        ]);

        if ($request->hasFile('file_name')) {
            foreach ($request->file('file_name') as $file) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('public/gallery', $fileName);
                Gallery::create([
                    'type' => 'dealers',
                    'file_name' => $fileName
                ]);
            }
        }
        return response()->json([
            'status' => 1,
            'msg' => 'Dealers uploaded successfully.'
        ]);
    }
    

    public function delete_brochure($id)
    {
        $brochure = Gallery::findOrFail($id);
        if ($brochure->file_name && Storage::disk('public')->exists('gallery/'.$brochure->file_name)) {
            Storage::disk('public')->delete('gallery/'.$brochure->file_name);
        }
        $brochure->delete();

        return redirect()->back()->with('success', 'Brochure deleted successfully');
    }

    public function dealers_delete($id)
    {
        $brochure = Gallery::findOrFail($id);
        if ($brochure->file_name && Storage::disk('public')->exists('gallery/'.$brochure->file_name)) {
            Storage::disk('public')->delete('gallery/'.$brochure->file_name);
        }
        $brochure->delete();

        return redirect()->back()->with('success', 'Dealer deleted successfully');
    }
}
