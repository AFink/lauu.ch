<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Shortlink;
use App\Models\Domain;
use App\Helpers\ShortlinkHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Createform extends Component
{
    //Form
    public $code = '';
    public $url;
    public $domain;
    public $password;


    public $domains;

    protected $shortlink;

    protected function rules()
    {
        $regex = '%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
        return [
            'url' => ['required', 'regex:' . $regex],
            'code' => ['nullable', 'max:100', 'alpha_dash', 'unique:App\Models\Shortlink,code,NULL,id,domain_id,' . $this->domain],
            'domain' => ['required', Rule::exists('domains', 'id')->where(function ($query) {
                return $query->where(['active' => true, 'suspended' => false, 'public' => true]);
            })],
            'password' => ['nullable', 'string']
        ];
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($propertyName == "domain") {
            if ($this->code != null) {
                $this->validateOnly("code");
            }
        }
    }

    public function generate()
    {
        $validatedData = $this->validateOnly('domain');

        $domain = Domain::findOrFail($validatedData['domain']);

        $this->code = ShortlinkHelper::generateCode($domain);

        $this->validateOnly("code");
    }


    public function submit()
    {
        $this->url = ShortlinkHelper::addScheme($this->url);

        $validatedData = $this->validate();

        $user = Auth::user();

        $this->shortlink = ShortlinkHelper::createShortlink($validatedData, $user);

        $this->reset(['code', 'url', 'password']);

        $this->emit('triggerModal', $this->shortlink->getURL());
    }


    public function mount()
    {
        $this->domains = Domain::where(['active' => true, 'suspended' => false, 'public' => true])->get();
        $this->domain = $this->domains->first()->id;
    }

    public function render()
    {
        return view('livewire.frontend.createform')->layout('layouts.frontend');
    }
}