<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function guardSuperAdmin(): void
    {
        if (!Auth::check() || Auth::user()->id_level != 1) {
            abort(403, 'Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /** Show the settings form */
    public function index()
    {
        $this->guardSuperAdmin();
        $settings = LandingPageSetting::getSettings();
        return view('admin.landing_settings', compact('settings'));
    }

    /** Save / update settings */
    public function update(Request $request)
    {
        $this->guardSuperAdmin();

        $request->validate([
            // Theme colors
            'theme_primary_color'           => 'nullable|string|max:20',
            'theme_secondary_color'         => 'nullable|string|max:20',
            'theme_bg_color'                => 'nullable|string|max:20',
            'theme_dark_bg'                 => 'nullable|string|max:20',
            // Hero display mode
            'hero_display_mode'             => 'nullable|in:card,image',
            'hero_image'                    => 'nullable|image|mimes:jpeg,png,webp,gif|max:2048',
            'hero_image_alt'                => 'nullable|string|max:255',
            // Hero text
            'hero_badge_text'               => 'nullable|string|max:255',
            'hero_title'                    => 'nullable|string|max:500',
            'hero_highlight_text'           => 'nullable|string|max:255',
            'hero_description'              => 'nullable|string|max:1000',
            'hero_btn_primary_text'         => 'nullable|string|max:255',
            'hero_btn_primary_url'          => 'nullable|string|max:255',
            'hero_btn_secondary_text'       => 'nullable|string|max:255',
            'hero_btn_secondary_url'        => 'nullable|string|max:255',
            // Floating card
            'floating_card_title'           => 'nullable|string|max:255',
            'floating_card_desc'            => 'nullable|string|max:500',
            'floating_card_icon'            => 'nullable|string|max:100',
            'floating_card_icon_color'      => 'nullable|string|max:20',
            'floating_card_gradient_start'  => 'nullable|string|max:20',
            'floating_card_gradient_end'    => 'nullable|string|max:20',
            // About section
            'about_badge'                   => 'nullable|string|max:255',
            'about_title'                   => 'nullable|string|max:500',
            'about_description'             => 'nullable|string|max:1000',
            'about_why_title'               => 'nullable|string|max:500',
            'about_why_p1'                  => 'nullable|string|max:1000',
            'about_why_p2'                  => 'nullable|string|max:1000',
            'about_checklist_1'             => 'nullable|string|max:255',
            'about_checklist_2'             => 'nullable|string|max:255',
            'about_checklist_3'             => 'nullable|string|max:255',
            'about_checklist_4'             => 'nullable|string|max:255',
            'about_principles_title'        => 'nullable|string|max:255',
            'about_principle_1'             => 'nullable|string|max:255',
            'about_principle_2'             => 'nullable|string|max:255',
            'about_principle_3'             => 'nullable|string|max:255',
            'about_principle_4'             => 'nullable|string|max:255',
            'about_principle_5'             => 'nullable|string|max:255',
            // Fitur Section
            'features_badge'                => 'nullable|string|max:255',
            'features_title'                => 'nullable|string|max:500',
            'features_description'          => 'nullable|string|max:1000',
            'feature_card_gradient_start'  => 'nullable|string|max:20',
            'feature_card_gradient_end'    => 'nullable|string|max:20',
            'feature_card_icon_color'      => 'nullable|string|max:20',
            'feature_1_title'               => 'nullable|string|max:255',
            'feature_1_desc'                => 'nullable|string|max:500',
            'feature_2_title'               => 'nullable|string|max:255',
            'feature_2_desc'                => 'nullable|string|max:500',
            'feature_3_title'               => 'nullable|string|max:255',
            'feature_3_desc'                => 'nullable|string|max:500',
            'feature_4_title'               => 'nullable|string|max:255',
            'feature_4_desc'                => 'nullable|string|max:500',
            'feature_5_title'               => 'nullable|string|max:255',
            'feature_5_desc'                => 'nullable|string|max:500',
            'feature_6_title'               => 'nullable|string|max:255',
            'feature_6_desc'                => 'nullable|string|max:500',
            // Berita Acara Section
            'berita_badge'                  => 'nullable|string|max:255',
            'berita_title'                  => 'nullable|string|max:500',
            'berita_description'            => 'nullable|string|max:1000',
            'berita_btn_text'               => 'nullable|string|max:255',
            // Banner CTA & Footer Section
            'cta_title'                     => 'nullable|string|max:500',
            'cta_description'               => 'nullable|string|max:1000',
            'cta_btn_text'                  => 'nullable|string|max:255',
            'cta_bg_color'                  => 'nullable|string|max:20',
            'footer_about'                  => 'nullable|string|max:1000',
            'footer_copyright'              => 'nullable|string|max:500',
            'footer_bg_color'               => 'nullable|string|max:20',
        ]);

        // Collect all text/color fields
        $fields = $request->only([
            'theme_primary_color', 'theme_secondary_color', 'theme_bg_color', 'theme_dark_bg',
            'hero_display_mode', 'hero_image_alt',
            'hero_badge_text', 'hero_title', 'hero_highlight_text', 'hero_description',
            'hero_btn_primary_text', 'hero_btn_primary_url',
            'hero_btn_secondary_text', 'hero_btn_secondary_url',
            'floating_card_title', 'floating_card_desc',
            'floating_card_icon', 'floating_card_icon_color',
            'floating_card_gradient_start', 'floating_card_gradient_end',
            'about_badge', 'about_title', 'about_description',
            'about_why_title', 'about_why_p1', 'about_why_p2',
            'about_checklist_1', 'about_checklist_2', 'about_checklist_3', 'about_checklist_4',
            'about_principles_title', 'about_principle_1', 'about_principle_2', 'about_principle_3', 'about_principle_4', 'about_principle_5',
            'features_badge', 'features_title', 'features_description',
            'feature_card_gradient_start', 'feature_card_gradient_end', 'feature_card_icon_color',
            'feature_1_title', 'feature_1_desc',
            'feature_2_title', 'feature_2_desc',
            'feature_3_title', 'feature_3_desc',
            'feature_4_title', 'feature_4_desc',
            'feature_5_title', 'feature_5_desc',
            'feature_6_title', 'feature_6_desc',
            'berita_badge', 'berita_title', 'berita_description', 'berita_btn_text',
            'cta_title', 'cta_description', 'cta_btn_text', 'cta_bg_color',
            'footer_about', 'footer_copyright', 'footer_bg_color',
        ]);

        // Checkbox: animation toggles
        $fields['floating_card_animation'] = $request->has('floating_card_animation') ? '1' : '0';
        $fields['features_animation']      = $request->has('features_animation') ? '1' : '0';

        // Handle dynamic about_checklists array
        if ($request->has('about_checklists') && is_array($request->input('about_checklists'))) {
            $cleanChecklists = array_values(array_filter($request->input('about_checklists'), function($v) {
                return $v !== null && trim($v) !== '';
            }));
            $fields['about_checklists'] = json_encode($cleanChecklists);
        }

        // File upload: hero image
        if ($request->hasFile('hero_image') && $request->file('hero_image')->isValid()) {
            $file     = $request->file('hero_image');
            $filename = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('landing_images'), $filename);

            // Delete old file if exists
            $oldImage = LandingPageSetting::where('key', 'hero_image')->value('value');
            if ($oldImage && file_exists(public_path('landing_images/' . $oldImage))) {
                @unlink(public_path('landing_images/' . $oldImage));
            }

            $fields['hero_image'] = $filename;
        }

        LandingPageSetting::setSettings($fields, 'landing');

        return redirect()->route('admin.landing-settings.index')
            ->with('success', 'Pengaturan Web Profil berhasil disimpan!');
    }

    /** Reset all settings to factory defaults */
    public function reset()
    {
        $this->guardSuperAdmin();

        // Delete hero image file before truncating
        $oldImage = LandingPageSetting::where('key', 'hero_image')->value('value');
        if ($oldImage && file_exists(public_path('landing_images/' . $oldImage))) {
            @unlink(public_path('landing_images/' . $oldImage));
        }

        LandingPageSetting::truncate();

        return redirect()->route('admin.landing-settings.index')
            ->with('success', 'Pengaturan berhasil dikembalikan ke default!');
    }
}
