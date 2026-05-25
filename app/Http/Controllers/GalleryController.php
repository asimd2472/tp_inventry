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
        $installationImages = Gallery::where('type', 'installation_images')->get();
        return view('admin.gallery.index', compact('dealers', 'brochure', 'installationImages'));
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
                $file->move(public_path('gallery'), $fileName);

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
                $file->move(public_path('gallery'), $fileName);
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
        $filePath = public_path('gallery/' . $brochure->file_name);
        if ($brochure->file_name && file_exists($filePath)) {
            unlink($filePath);
        }
        $brochure->delete();

        return redirect()->back()->with('success', 'Brochure deleted successfully');
    }

    public function dealers_delete($id)
    {
        $brochure = Gallery::findOrFail($id);
        $filePath = public_path('gallery/' . $brochure->file_name);
        if ($brochure->file_name && file_exists($filePath)) {
            unlink($filePath);
        }
        $brochure->delete();

        return redirect()->back()->with('success', 'Dealer deleted successfully');
    }

    public function product_installation_images(Request $request){
        $request->validate([
            'file_name' => 'required|array',
            'file_name.*' => 'mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('file_name')) {

            foreach ($request->file('file_name') as $file) {

                $filename = time() . '_' . rand(1000,9999) . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('uploads/dealers'), $filename);

                
                Gallery::create([
                    'file_name' => $filename,
                    'type' => 'installation_images',
                ]);
            }
        }
        return redirect()->back()->with('success', 'Files uploaded successfully');
    }

    public function installation_images_delete($id)
    {
        $brochure = Gallery::findOrFail($id);
        $filePath = public_path('uploads/dealers/' . $brochure->file_name);
        if ($brochure->file_name && file_exists($filePath)) {
            unlink($filePath);
        }
        $brochure->delete();

        return redirect()->back()->with('success', 'Image deleted successfully');
    }
}
