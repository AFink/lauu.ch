<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Helpers\ShortlinkHelper;
use App\Models\CodeTarget;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class Pastebin extends Component
{
    //Form
    public $code = '';
    public $text = '';
    public $domain;
    public $password;

    public $domains;

    protected $shortlink;

    protected function rules()
    {
        return [
            'text' => ['required'],
            'code' => ['nullable', 'max:100', 'alpha_dash', 'unique:App\Models\Shortlink,code,NULL,id,domain_id,' . $this->domain],
            'domain' => ['required', Rule::exists('domains', 'id')->where(function ($query) {
                return $query->where(['active' => true, 'suspended' => false, 'public' => true]);
            })],
            'password' => ['nullable', 'string'],
        ];
    }

    public function updated($propertyName)
    {
        if ($propertyName == "text") {
            if ($this->text == "") {
                return;
            }
        }
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
        $validatedData = $this->validate();

        $user = Auth::user();

        $this->shortlink = ShortlinkHelper::createPaste($validatedData, $user);

        $this->reset(['text', 'code', 'password']);

        $this->emit('resetCode');
        $this->emit('triggerModal', $this->shortlink->getURL());
    }


    public function mount()
    {
        $this->domains = Domain::where(['active' => true, 'suspended' => false, 'public' => true])->get();
        $this->domain = $this->domains->first()->id;

        if (session()->has('pasteTarget')) {
            $old = CodeTarget::where(['id' => session('pasteTarget')])->firstOrFail();
            $this->text = $old->code;
        }
    }

    public function render()
    {
        return view('livewire.frontend.pastebin')->layout('layouts.frontend');
    }
}