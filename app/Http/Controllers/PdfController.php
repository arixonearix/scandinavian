<?php

namespace App\Http\Controllers;

use App\Models\PageConfig;
use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PdfController extends Controller
{
    const MAIN_PAGE_CONFIG = 'mainPage';

    /**
     * @return false|string
     */
    public function getMainPagePdfList()
    {
        $mainPageConfig = $this->getMainPageConfig();
        $pdfList = Pdf::where('active', Pdf::ACTIVE)
                    ->orderBy('id')
                    ->take($mainPageConfig->thumbCount)
                    ->get()
                    ->toArray();

        return json_encode(['config' => $mainPageConfig, 'pdfList' => $pdfList]);
    }

    /**
     * Get from Redis(set if is missed) config to tell UI in how much
     * rows and cols should be shown pdf thumbnails
     * @property integer $rows how much thumbnails shown in a row
     * @property integer $cols how much thumbnails shown in a row
     * @property integer $thumbCount how much thumbnails shown in a row
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
