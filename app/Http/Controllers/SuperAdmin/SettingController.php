<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function showFormSettings()
    {
        $is_form_enabled = Setting::where('key', 'is_form_enabled')->firstOrNew();
        return view('superadmin.settings.form', compact('is_form_enabled'));
    }

    public function showWebsiteSettings()
    {
        $website_name = Setting::where('key', 'website_name')->firstOrNew();
        $website_description = Setting::where('key', 'website_description')->firstOrNew();
        $website_logo = Setting::where('key', 'website_logo')->firstOrNew();
        $website_footer_description = Setting::where('key', 'website_footer_description')->firstOrNew();
        $website_made_by_text = Setting::where('key', 'website_made_by_text')->firstOrNew();
        return view('superadmin.settings.website', compact('website_name', 'website_description', 'website_logo', 'website_footer_description', 'website_made_by_text'));
    }

    public function showValidationSettings()
    {
        $min_height = Setting::where('key', 'min_height')->firstOrNew();
        $max_weight_tolerance = Setting::where('key', 'max_weight_tolerance')->firstOrNew();
        $min_age = Setting::where('key', 'min_age')->firstOrNew();
        $max_age = Setting::where('key', 'max_age')->firstOrNew();
        $required_education = Setting::where('key', 'required_education')->firstOrNew();
        $required_certifications = Setting::where('key', 'required_certifications')->firstOrNew();
        return view('superadmin.settings.validation', compact('min_height', 'max_weight_tolerance', 'min_age', 'max_age', 'required_education', 'required_certifications'));
    }

    public function showSmtpSettings()
    {
        $mail_mailer = Setting::where('key', 'MAIL_MAILER')->firstOrNew();
        $mail_host = Setting::where('key', 'MAIL_HOST')->firstOrNew();
        $mail_port = Setting::where('key', 'MAIL_PORT')->firstOrNew();
        $mail_username = Setting::where('key', 'MAIL_USERNAME')->firstOrNew();
        $mail_password = Setting::where('key', 'MAIL_PASSWORD')->firstOrNew();
        $mail_encryption = Setting::where('key', 'MAIL_ENCRYPTION')->firstOrNew();
        $mail_from_address = Setting::where('key', 'MAIL_FROM_ADDRESS')->firstOrNew();
        $mail_from_name = Setting::where('key', 'MAIL_FROM_NAME')->firstOrNew();
        return view('superadmin.settings.smtp', compact('mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'is_form_enabled' => 'nullable|boolean',
            'mail_mailer' => 'nullable|string',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
            'min_height' => 'nullable|integer',
            'max_weight_tolerance' => 'nullable|integer',
            'min_age' => 'nullable|integer',
            'max_age' => 'nullable|integer',
            'required_education' => 'nullable|string',
            'required_certifications' => 'nullable|string',
            'website_footer_description' => 'nullable|string',
            'website_made_by_text' => 'nullable|string',
        ]);

        // Update is_form_enabled
        $setting = Setting::firstOrNew(['key' => 'is_form_enabled']);
        $setting->value = $request->has('is_form_enabled') ? 'true' : 'false';
        $setting->save();

        // Update SMTP settings
        $smtpSettings = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
            'min_height',
            'max_weight_tolerance',
            'min_age',
            'max_age',
            'required_education',
            'required_certifications',
            'website_footer_description',
            'website_made_by_text',
            'website_name',
            'website_description',
        ];

        foreach ($smtpSettings as $key) {
            if ($request->has($key)) {
                $setting = Setting::firstOrNew(['key' => $key]);
                $setting->value = $request->input($key);
                $setting->save();
            }
        }

        // Handle website_logo upload
        if ($request->hasFile('website_logo')) {
            $logoPath = $request->file('website_logo')->store('website_settings', 'public');
            $setting = Setting::firstOrNew(['key' => 'website_logo']);
            $setting->value = $logoPath;
            $setting->save();
        }

        // Clear config cache to apply new mail settings
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

}