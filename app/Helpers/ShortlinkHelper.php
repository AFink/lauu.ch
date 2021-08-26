<?php

namespace App\Helpers;

use App\Models\Shortlink;
use App\Models\Domain;
use Illuminate\Support\Str;
use App\Models\LinkTarget;
use App\Models\LinklistTarget;
use App\Models\LinklistItem;
use App\Models\CodeTarget;


class ShortlinkHelper
{
    static public function addScheme($url, $scheme = 'https://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
            $scheme . $url : $url;
    }

    static public function codeExists(Domain $domain, $code)
    {
        $link = Shortlink::where([['code', $code], ['domain_id', $domain->id]])
            ->first();

        if ($link != null) {
            return true;
        } else {
            return false;
        }
    }

    static public function generateCode(Domain $domain, $count = 0)
    {
        if ($count < 1) {
            $count = env('CODE_LENGTH');
        }

        $code = '';
        $in_use = true;

        while ($in_use) {
            $code = Str::random($count);
            $in_use = ShortlinkHelper::codeExists($domain, $code);
        }

        return $code;
    }


    public static function createLinklist($validatedData, $user = null)
    {
        if (false) {
            throw new \Exception('Sorry, but your link already
                looks like a shortened URL.');
        }


        $domain = Domain::findOrFail($validatedData['domain']);

        if ($validatedData['code'] == null || $validatedData['code'] == "") {
            $validatedData['code'] = ShortlinkHelper::generateCode($domain);
        }

        $shortlink = $domain->shortlinks()->create($validatedData);

        $target = LinklistTarget::create($validatedData);

        $shortlink->target()->associate($target);

        if ($user) {
            $shortlink->user()->associate($user);
        }

        if ($shortlink->isDirty()) {
            $shortlink->save();
        }

        $target->items()->createMany($validatedData['items']);

        return $shortlink;
    }

    public static function createShortlink($validatedData, $user = null)
    {
        if (strlen($validatedData['url']) > 65535) {
            throw new \Exception('Sorry, but your link is longer than the
                maximum length allowed.');
        }

        if (false) {
            throw new \Exception('Sorry, but your link already
                looks like a shortened URL.');
        }

        $domain = Domain::findOrFail($validatedData['domain']);

        if ($validatedData['code'] == null || $validatedData['code'] == "") {
            $validatedData['code'] = ShortlinkHelper::generateCode($domain);
        }

        $shortlink = $domain->shortlinks()->create($validatedData);

        $target = LinkTarget::create(['url' => $validatedData['url']]);

        $shortlink->target()->associate($target);



        if ($user) {
            $shortlink->user()->associate($user);
        }

        if ($shortlink->isDirty()) {
            $shortlink->save();
        }

        //dd($target, $shortlink, $shortlink->target);


        return $shortlink;
    }


    public static function createPaste($validatedData, $user = null)
    {
        $domain = Domain::findOrFail($validatedData['domain']);

        if ($validatedData['code'] == null || $validatedData['code'] == "") {
            $validatedData['code'] = ShortlinkHelper::generateCode($domain);
        }

        $shortlink = $domain->shortlinks()->create($validatedData);

        $target = CodeTarget::create(['code' => $validatedData['text']]);

        $shortlink->target()->associate($target);

        if ($user) {
            $shortlink->user()->associate($user);
        }

        if ($shortlink->isDirty()) {
            $shortlink->save();
        }

        //dd($target, $shortlink, $shortlink->target);

        return $shortlink;
    }
}