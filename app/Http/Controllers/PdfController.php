<?php

namespace App\Http\Controllers;

use App\Models\PageConfig;
use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PdfController extends Controller
{
    const MAIN_PAGE_COUNT = 20;
    const MAIN_PAGE_CONFIG = 'mainPage';
    /**
     * @var Pdf
     */
    protected $pdfModel;

    public function __construct()
    {
        $this->pdfModel = new Pdf();
    }

    /**
     * @return false|string
     */
    public function getMainPagePdfList()
    {
        $pdfList = Pdf::where('active', Pdf::ACTIVE)
                    ->orderBy('id')
                    ->take(self::MAIN_PAGE_COUNT)
                    ->get()
                    ->toArray();
        $mainPageConfig = $this->getMainPageConfig();

        return json_encode(['config' => $mainPageConfig, 'pdfList' => $pdfList]);
    }

    /**
     * Get from Redis(set if is missed) config to tell UI in how much
     * rows and cols should be shown pdf thumbnails
     * @return object config
     */
    public function getMainPageConfig()
    {
        $mainPageConfig = Redis::get(self::MAIN_PAGE_CONFIG);
        if (!$mainPageConfig) {
            $mainPageConfig = PageConfig
                ::where('name', self::MAIN_PAGE_CONFIG)
                ->get()
                ->toArray();
            Redis::set(self::MAIN_PAGE_CONFIG, $mainPageConfig);
        }

        return json_decode($mainPageConfig);
    }

    /**
     * Uploads pdf to file storage and writes path in table
     * @param Request $request
     * @return false|string
     */
    public function upload(Request $request)
    {
        $path = $request->file('pdf_upload')->store('pdf_storage');
        Pdf::create([
            'filename' => $path,
            'active' => Pdf::ACTIVE
        ]);

        return $path;
    }
}
