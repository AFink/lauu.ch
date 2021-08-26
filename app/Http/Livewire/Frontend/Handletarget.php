<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain;
use App\Models\LinklistTarget;
use App\Models\LinkTarget;
use App\Models\CodeTarget;
use Carbon\Carbon;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class Handletarget extends Component
{

    public $shortlink;
    public $type;

    //Form
    public $password = "";

    public $solvedPassword = false;

    public function mount($code, $type = null)
    {
        $domain = Domain::all()->filter(function ($model) {
            return parse_url($model->name)['host'] == parse_url(url('/'))['host'];
        })->first();

        // Verify domain
        if ($domain == null) {
            return abort(404, __('This domain is not usable.'));
        }

        $shortlink = $domain->shortlinks()->where(['code' => $code])->withCount(['visits', 'visits as user_visits_count' => function ($query) {
            $query->where('bot', 0);
        }])->with('target')->first();

        // Verify shortlink
        if ($shortlink == null) {
            return abort(404, __('This shortlink doesn\'t exist.'));
        }

        if (!$type) {
            $type = $shortlink->type;
        }

        // Verify disabled
        if ($shortlink->disabled) {
            return abort(404, __('This shortlink was disabled by its creator.'));
        }

        // Verify suspended
        if ($shortlink->suspended) {
            return abort(404, __('This shortlink has been suspended by the team.'));
        }

        // Verify starting date
        if ($shortlink->valid_from && (Carbon::now()->lessThanOrEqualTo($shortlink->valid_from))) {
            return abort(404, __('This shortlink is not visitable yet.'));
        }

        // Verify expiration date
        if ($shortlink->valid_until && (Carbon::now()->greaterThanOrEqualTo($shortlink->valid_until))) {
            return abort(404, __('This shortlink has already expired.'));
        }

        // Verify maxvists only from non-bots
        if (!empty($shortlink->maxvisits) && $shortlink->maxvisits > -1  && $shortlink->user_visits_count >= $shortlink->maxvists) {
            return abort(404, __('This shortlink has reached its maximum visits. This limit can be increased in the dashboard.'));
        }

        $this->shortlink = $shortlink;
        $this->type = $type;
    }

    public function submit()
    {
        $this->validate([
            'password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, $this->shortlink->password)) {
                    $fail('The password is wrong.');
                }
            }]
        ]);
        $this->solvedPassword = true;
    }


    public function clone()
    {
        session()->flash('pasteTarget', $this->shortlink->target->id);
        return redirect('pastebin');
    }


    public function render()
    {
        if (!empty($this->shortlink->password)) {
            if (!$this->solvedPassword) {
                return view('livewire.frontend.passwordform')->layout('layouts.frontend');
            }
        }

        $visit = $this->shortlink->visits()->create([
            'platform' => Browser::platformName(),
            'browser' => Browser::browserName(),
            'deviceFamily' => Browser::deviceFamily(),
            'deviceModel' => Browser::deviceModel(),
            'bot' => Browser::isBot()
        ]);

        if ($this->shortlink->target instanceof LinkTarget) {
            switch ($this->type) {
                case 'direct':
                    $this->redirect($this->shortlink->target->url);
                case 'secure':
                    return view('livewire.frontend.secure')->layout('layouts.frontend');
            }
        } else if ($this->shortlink->target instanceof LinklistTarget) {
            return view('livewire.frontend.linklist')->layout('layouts.frontend');
        } else if ($this->shortlink->target instanceof CodeTarget) {
            switch ($this->type) {
                case 'raw':
                    return  view('livewire.frontend.raw')->layout('layouts.raw');
                default:
                    return view('livewire.frontend.code')->layout('layouts.frontend');
            }
        } else {
            dd($this->shortlink);
        }
    }
}