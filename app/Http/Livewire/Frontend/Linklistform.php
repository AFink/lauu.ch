<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Shortlink;
use App\Models\Domain;
use App\Helpers\ShortlinkHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Linklistform extends Component
{
    //Form
    public $code = '';
    public $items = [];
    public $domain;
    public $password;
    public $title;
    public $subtitle;

    protected $shortlink;
    public $domains;


    protected function rules()
    {
        $regex1 = '%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
        $regex2 = '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/';
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.url' => ['required', 'regex:' . $regex1],
            'items.*.color' => ['required', 'regex:' . $regex2],
            'items.*.name' => ['required'],
            'code' => ['max:100', 'alpha_dash', 'unique:App\Models\Shortlink,code'],
            'domain' => ['required', Rule::exists('domains', 'id')->where(function ($query) {
                return $query->where(['active' => true, 'suspended' => false, 'public' => true]);
            })],
            'password' => [],
            'title' => ['nullable', 'max:100'],
            'subtitle' => ['nullable', 'max:500']
        ];
    }

    protected $messages = [
        'items.*.url.regex' => 'The URL is invalid.',
        'items.*.url.required' => 'The URL is required.',
        'items.*.name.required' => 'A name is required.',
        'items.required' => 'You need at least one link.',
    ];


    public function addItem()
    {
        $this->items[] = ['name' => '', 'url' => '', 'color' => $this->getColor()];
    }

    public function removeItem($index)
    {
        //  if (count($this->items) > 1) {
        unset($this->items[$index]);
        //}
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateOrder($data)
    {
        $new = [];

        foreach ($data as $d) {
            $new[$d['order']] = $this->items[$d['value']];
        }

        $this->items = $new;
        $this->emit('updateColor');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $user = Auth::user();

        $this->shortlink = ShortlinkHelper::createLinklist($validatedData, $user);

        $this->items = [['name' => '', 'url' => '', 'color' => $this->getColor()]];
        $this->reset(['password', 'title', 'subtitle']);

        $this->emit('triggerModal', $this->shortlink->getURL());
    }



    public function mount()
    {
        $this->domains = Domain::where(['active' => true, 'suspended' => false, 'public' => true])->get();
        $this->domain = $this->domains->first()->id;
        $this->items = [['name' => '', 'url' => '', 'color' => $this->getColor()]];
    }

    public function render()
    {
        return view('livewire.frontend.linklistform')->layout('layouts.frontend');
    }


    private static function getColor()
    {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
        return $color;
    }
}