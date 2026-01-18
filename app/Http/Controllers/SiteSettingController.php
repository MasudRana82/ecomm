<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    /**
     * Display the site settings form
     */
    public function index()
    {
        $logo = SiteSetting::get('site_logo', 'storage/logo/logo.png');

        return view('admin.settings.index', compact('logo'));
    }

    /**
     * Update the site logo
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            // Get the current logo path
            $currentLogo = SiteSetting::get('site_logo');

            // Delete old logo if it exists and is not the default
            if ($currentLogo && $currentLogo !== 'storage/logo/logo.png') {
                $oldPath = str_replace('storage/', '', $currentLogo);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Store the new logo
            $logoPath = $request->file('logo')->store('logo', 'public');

            // Update the setting
            SiteSetting::set('site_logo', 'storage/' . $logoPath);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Logo updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Failed to update logo: ' . $e->getMessage());
        }
    }
}
