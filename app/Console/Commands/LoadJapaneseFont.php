<?php

namespace App\Console\Commands;

use Dompdf\Adapter\CPDF;
use Dompdf\FontMetrics;
use Dompdf\Options;
use FontLib\Font;
use Illuminate\Console\Command;

class LoadJapaneseFont extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'font:load-japanese {font?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Japanese font into dompdf';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fontFile = $this->argument('font') ?? 'NotoSansJP-VariableFont_wght.ttf';
        $fontPath = storage_path('fonts/' . $fontFile);

        if (!file_exists($fontPath)) {
            $this->error("フォントファイルが見つかりません: {$fontPath}");
            return 1;
        }

        $this->info("フォントファイルを読み込んでいます: {$fontFile}");

        // フォントを読み込む
        $font = Font::load($fontPath);
        if (!$font) {
            $this->error("フォントファイルの読み込みに失敗しました");
            return 1;
        }

        $font->parse();

        // フォント名を取得
        $baseName = pathinfo($fontFile, PATHINFO_FILENAME);
        $fontName = 'notosansjp';

        // UFMファイルを生成
        $ufmPath = storage_path("fonts/{$fontName}.ufm");
        $font->saveAdobeFontMetrics($ufmPath);
        $font->close();

        if (!file_exists($ufmPath)) {
            $this->error("UFMファイルの生成に失敗しました");
            return 1;
        }

        // フォントファイルをリネーム（dompdfが認識しやすいように）
        $newFontPath = storage_path("fonts/{$fontName}.ttf");
        if (!copy($fontPath, $newFontPath)) {
            $this->error("フォントファイルのコピーに失敗しました");
            return 1;
        }

        // installed-fonts.jsonファイルを読み込むまたは作成
        $installedFontsPath = storage_path('fonts/installed-fonts.json');
        $installedFonts = [];
        
        if (file_exists($installedFontsPath)) {
            $installedFonts = json_decode(file_get_contents($installedFontsPath), true) ?? [];
        }

        // 日本語フォントを登録
        $installedFonts[$fontName] = [
            'normal' => $fontName,
            'bold' => $fontName,
            'italic' => $fontName,
            'bold_italic' => $fontName,
        ];

        // ファイルに保存
        file_put_contents($installedFontsPath, json_encode($installedFonts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info("フォントが正常に変換されました:");
        $this->info("  TTFファイル: {$newFontPath}");
        $this->info("  UFMファイル: {$ufmPath}");
        $this->info("  フォント登録ファイル: {$installedFontsPath}");
        $this->info("");
        $this->info("PDFテンプレートで以下のように使用してください:");
        $this->info("  font-family: {$fontName}, DejaVu Sans, sans-serif;");
        
        return 0;
    }
}
