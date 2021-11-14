<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditHomeSliderComponent extends Component
{
    use WithFileUploads;
    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $image;
    public $status;
    public $newimage;
    public $slider_id;

    public function mount($slider_id)
    {
        $slider = HomeSlider::find($slider_id);
        $this->title = $slider->title;
        $this->subtitle = $slider->subtitle;
        $this->price = $slider->price;
        $this->link = $slider->link;
        $this->image = $slider->image;
        $this->status = $slider->status;
        $this->slider_id = $slider->id;
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'title' => 'required',
            'subtitle' => 'required',
            'price' => 'numeric',
            'link' => 'required',
            'newimage' => 'required|mimes:jpeg,png'
        ]);
    }

    public function updateslide()
    {
        $this->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'price' => 'numeric',
            'link' => 'required',
            'newimage' => 'required|mimes:jpeg,png'
        ]);
        $slider = HomeSlider::find($this->slider_id);
        $slider->title = $this->title;
        $slider->subtitle = $this->subtitle;
        $slider->price = $this->price;
        $slider->link = $this->link;
        if($this->newimage)
        {
            $imagename = Carbon::now()->timestamp. '.' .$this->newimage->extension();
            $this->newimage->storeAs('slider', $imagename);
            $slider->image = $imagename;
        }
        $slider->image = $this->image;
        $slider->status = $this->status;
        $slider->save();
        session()->flash('message', 'Slider has been updated ');
    }
    public function render()
    {
        return view('livewire.admin.admin-edit-home-slider-component')->layout('layouts.base');
    }
}
