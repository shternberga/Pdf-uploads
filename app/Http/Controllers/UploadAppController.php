<?php
namespace App\Http\Controllers;

use App\Pdf_file;
use Illuminate\Http\Request;
use Imagick;

class UploadAppController extends Controller
{
    public function index(Request $request)
    {
        $pdf_files = Pdf_file::query()->orderBy('created_at', 'desc')->paginate(8);
        return view('uploadApp.index', compact('pdf_files'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('uploadApp.form');
        else {
            $rules = [
                'description' => 'required',
            ];
            $this->validate($request, $rules);

            $pdf_file = new Pdf_file();
            if ($request->hasFile('pdf_file')) {
                $dir = 'uploads/';
                $extension = strtolower($request->file('pdf_file')->getClientOriginalExtension()); // get pdf_file extension
                $fileName = strtolower($request->file('pdf_file')->getClientOriginalName()); // rename pdf_file
                $request->file('pdf_file')->move($dir, $fileName);
                $this->makeThumbnail($dir, $fileName);
                $pdf_file->pdf_file = $fileName;
            }
            $pdf_file->description = $request->description;
            $pdf_file->save();
            return redirect('/laravel-app');
        }
    }

    public function makeThumbnail($dir, $fileName)
    {
        $im = new Imagick($dir.$fileName);
        $im->setIteratorIndex(0);
        $im->setCompression(Imagick::COMPRESSION_JPEG);
        $im->setCompressionQuality(100);
        $im->setImageFormat("jpeg");
        $im->cropImage(650,450, 30,10);
        $im->writeImage($dir."thumbnails/".$fileName.".jpg");
    }

    public function delete($id)
    {
        Pdf_file::destroy($id);
        return redirect('/laravel-app');
    }

}
