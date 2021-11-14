<?php

namespace App\Http\Livewire\Admin;

use App\Models\Catagory;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryComponent extends Component
{
    public function deleteCategory($id)
    {
        $category = Catagory::find($id);
        $category->delete();
        session()->flash('message', 'Category has been deleted!');
    }
    public function render()
    {
        $categories = Catagory::paginate(10);
        return view('livewire.admin.admin-category-component', ['categories'=>$categories])->layout('layouts.base');
    }
}
