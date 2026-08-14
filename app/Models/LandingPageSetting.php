<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * LandingPageSetting
 *
 * Simple key-value store for the public landing page (welcome.blade.php).
 * Only Super Admin (id_level == 1) can modify these values.
 *
 * Table columns: id, key, value, group, timestamps
 */
class LandingPageSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'group'];

    /* ──────────────────────────────────────────────
     |  Default values (returned when DB has no row)
     ────────────────────────────────────────────── */
    public static array $defaults = [
        // Theme
        'theme_primary_color'           => '#173F9E',
        'theme_secondary_color'         => '#F4A623',
        'theme_bg_color'                => '#F7F9FC',
        'theme_dark_bg'                 => '#0B1736',

        // Hero display mode
        'hero_display_mode'             => 'card',   // 'card' | 'image'
        'hero_image'                    => '',
        'hero_image_alt'                => '',

        // Hero text
        'hero_badge_text'               => 'SISTEM INFORMASI SPI',
        'hero_title'                    => 'Sistem Informasi Supervisi dan Pengawasan Internal',
        'hero_highlight_text'           => 'Pengawasan Internal',
        'hero_description'              => 'Solusi digital terpadu untuk manajemen audit internal, penilaian resiko, dan monitoring tindak lanjut yang efektif dan efesien.',
        'hero_btn_primary_text'         => 'Mulai Sekarang →',
        'hero_btn_primary_url'          => '/login',
        'hero_btn_secondary_text'       => 'Pelajari Lebih Lanjut',
        'hero_btn_secondary_url'        => '#tentang',

        // Floating card
        'floating_card_title'           => 'Audit Management',
        'floating_card_desc'            => 'Kelola seluruh proses audit internal dengan sistematis, dari perencanaan hingga pelaporan hasil audit.',
        'floating_card_icon'            => 'fas fa-clipboard-check',
        'floating_card_icon_color'      => '#173F9E',
        'floating_card_gradient_start'  => '#2557D6',
        'floating_card_gradient_end'    => '#173F9E',
        'floating_card_animation'       => '1',

        // About section
        'about_badge'                   => 'TENTANG KAMI',
        'about_title'                   => 'Transformasi Digital untuk Audit Internal',
        'about_description'             => 'SISPI hadir sebagai solusi komprehensif untuk meningkatkan efektivitas pengawasan internal organisasi Anda melalui digitalisasi proses audit.',
        'about_why_title'               => 'Mengapa Memilih SISPI?',
        'about_why_p1'                  => 'Sispi dirancang khusus untuk memenuhi kebutuhan audit internal yang modern dan efisien. Dengan fitur-fitur lengkap dan interface yang user-friendly, kami membantu tim audit Anda bekerja lebih produktif.',
        'about_why_p2'                  => 'Sistem kami mengintegrasikan seluruh proses pengawasan internal, mulai dari penyusunan peta resiko, pelaksanaan audit, hingga monitoring tindak lanjut rekomendasi.',

        // Fitur Section
        'features_badge'                => 'FITUR UNGGULAN',
        'features_title'                => 'Fitur Lengkap untuk Audit yang Efektif',
        'features_description'          => 'Berbagai fitur canggih yang dirancang untuk mendukung setiap tahapan proses audit internal Anda.',
        'feature_card_gradient_start'  => '#2557D6',
        'feature_card_gradient_end'    => '#173F9E',
        'feature_card_icon_color'      => '#173F9E',
        'features_animation'            => '1',
        'feature_1_title'               => 'Manajemen Audit',
        'feature_1_desc'                => 'Kelola kegiatan audit internal dengan sistematis, termasuk perencanaan, pelaksanaan, dan pelaporan.',
        'feature_2_title'               => 'Peta Risiko',
        'feature_2_desc'                => 'Identifikasi dan analisis risiko organisasi dengan visualisasi matriks risiko yang mudah dipahami.',
        'feature_3_title'               => 'Laporan & Dokumentasi',
        'feature_3_desc'                => 'Buat laporan audit yang profesional dan kelola seluruh dokumentasi dengan sistem penyimpanan digital.',
        'feature_4_title'               => 'Kolaborasi Tim',
        'feature_4_desc'                => 'Koordinasi antar tim audit dengan sistem approval, komentar, dan notifikasi yang terintegrasi.',
        'feature_5_title'               => 'Monitoring Tindak Lanjut',
        'feature_5_desc'                => 'Pantau dan evaluasi implementasi rekomendasi audit dengan sistem tracking yang efektif.',
        'feature_6_title'               => 'Keamanan Data',
        'feature_6_desc'                => 'Proteksi data dengan sistem keamanan berlapis, verifikasi email, dan kontrol akses berbasis role.',

        // Berita Acara Section
        'berita_badge'                  => 'Berita Acara',
        'berita_title'                  => 'Ringkasan Kegiatan Terbaru',
        'berita_description'            => 'Pantau berita acara terbaru lengkap dengan dokumentasi rapat dan bukti visual.',
        'berita_btn_text'               => 'Lihat Semua Berita Acara',

        // Banner CTA & Footer Section
        'cta_title'                     => 'Siap Meningkatkan Efektivitas Audit Internal Anda?',
        'cta_description'               => 'Bergabunglah dengan organisasi-organisasi yang telah mempercayai SISPI untuk transformasi digital audit internal mereka.',
        'cta_btn_text'                  => 'Mulai Sekarang',
        'cta_bg_color'                  => '#0B1736',
        'footer_about'                  => 'Sistem Informasi Supervisi dan Pengawasan Internal yang dirancang untuk meningkatkan efektivitas audit internal organisasi Anda.',
        'footer_copyright'              => 'SISPI. Sistem Informasi Supervisi dan Pengawasan Internal. All rights reserved.',
        'footer_bg_color'               => '#0B1736',
    ];

    /* ──────────────────────────────────────────────
     |  getSettings()
     |  Returns an associative array of key => value,
     |  falling back to defaults for any missing key.
     ────────────────────────────────────────────── */
    public static function getSettings(): array
    {
        $rows = static::all()->pluck('value', 'key')->toArray();
        return array_merge(static::$defaults, $rows);
    }

    /* ──────────────────────────────────────────────
     |  setSettings(array $data, string $group)
     |  Upserts each key=>value pair into the table.
     ────────────────────────────────────────────── */
    public static function setSettings(array $data, string $group = 'landing'): void
    {
        foreach ($data as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                ['value' => (string) $value, 'group' => $group]
            );
        }
    }
}
