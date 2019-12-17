<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Mail\PasswordChanged;
use App\Currency;
use App\Tag;
use Auth;
use Image;
use Storage;
use Hash;
use Mail;

class SettingsController extends Controller {
    private $tagsValidationRules = [
        'name' => 'required|max:255',
        'color' => 'required|max:6'
    ];

    public function getIndex() {
        return redirect()->route('settings.profile');
    }

    public function postIndex(Request $request) {
        $request->validate([
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif',
            'password' => 'nullable|confirmed',
            'language' => 'nullable|in:' . implode(',', array_keys(config('app.locales'))),
            'theme' => 'nullable|in:light,dark',
            'weekly_report' => 'nullable|in:true,false'
        ]);

        $user = Auth::user();

        // Profile
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $fileName = $file->hashName();

            $image = Image::make($file)
                ->fit(500);

            Storage::put('public/avatars/' . $fileName, (string) $image->encode());

            $user->avatar = $fileName;
        }

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        // Account
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($password = $request->input('password')) {
            $user->password = Hash::make($password);
        }

        // Preferences
        if ($request->has('language')) {
            $user->language = $request->input('language');
        }

        if ($request->has('theme')) {
            $user->theme = $request->input('theme');
        }

        if ($request->has('weekly_report')) {
            $user->weekly_report = $request->input('weekly_report') == 'true' ? true : false;
        }

        $user->save();

        // Notify upon changing of password
        if ($request->has('password')) {
            Mail::to($user->email)->queue(new PasswordChanged($user->updated_at));
        }

        return back();
    }

    public function getProfile() {
        return view('settings.profile');
    }

    public function getAccount() {
        return view('settings.account');
    }

    public function getSpaces() {
        return view('settings.spaces.index', [
            'spaces' => Auth::user()->spaces
        ]);
    }

    public function getPreferences() {
        $languages = [];

        foreach (config('app.locales') as $key => $value) {
            $flag = $key;

            if ($key == 'en') {
                $flag = 'us';
            }

            $languages[] = ['key' => $key, 'label' => '<i class="twf twf-sm twf-' . $flag . '"></i> ' . $value];
        }

        return view('settings.preferences', compact('languages'));
    }

    public function getTags() {
        return view('settings.tags.index', [
            'tags' => session('space')->tags()->orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function getTagsCreate() {
        return view('settings.tags.create');
    }

    public function postTagsStore(Request $request) {
        $request->validate($this->tagsValidationRules);

        Tag::create([
            'space_id' => session('space')->id,
            'name' => $request->input('name'),
            'color' => $request->input('color')
        ]);

        return redirect()->route('settings.tags.index');
    }

    public function getTagsEdit(Tag $tag) {
        $this->authorize('edit', $tag);

        return view('settings.tags.edit', compact('tag'));
    }

    public function patchTags(Request $request, Tag $tag) {
        $this->authorize('update', $tag);

        $request->validate(array_slice($this->tagsValidationRules, 0, 1, true)); // Get rid of last entry in $validationRules as it's not required for updating

        $tag->fill([
            'name' => $request->input('name'),
            'color' => $request->input('color')
        ])->save();

        return redirect()->route('settings.tags.index');
    }

    public function deleteTags(Tag $tag) {
        $this->authorize('delete', $tag);

        if (!$tag->spendings->count()) {
            $tag->delete();
        }

        return redirect()->route('settings.tags.index');
    }
}
