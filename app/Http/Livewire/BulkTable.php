<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class BulkTable extends Component
{
    public Collection $selectedProducts;

    public bool $bulkDisabled = true;

    public Collection $products;

    public Collection $categories;

    public ?int $selectedCategory = null;

    public bool $modalOpen = false;

    public function mount()
    {
        $this->categories = Category::get();
        $this->reloadData();
    }

    public function render()
    {
        $this->selectedCategory = $this->products
            ->filter(fn($product) => $this->getSelectedProducts()->contains($product->id))
            ->map(fn($product) => $product->category->id)
            ->unique()
            ->pipe(fn($categories) => $categories->count() === 1 ? $categories->first() : null);

        $this->bulkDisabled = $this->selectedProducts->filter(fn($p) => $p)->count() < 2;

        return view('livewire.bulk-table');
    }

    public function changeCategory()
    {
        Product::query()
            ->whereIn('id', $this->selectedProducts->filter(fn($product) => $product)->keys()->toArray())
            ->update(['category_id' => $this->selectedCategory]);

        $this->reloadData();
    }

    public function reloadData()
    {
        $this->selectedCategory = null;
        $this->products = Product::with('category')->get();
        $this->selectedProducts = $this->products
            ->map(fn($product) => $product->id)
            ->flip()
            ->map(fn($product) => false);
    }

    private function getSelectedProducts()
    {
        return $this->selectedProducts->filter(fn($p) => $p)->keys();
    }
}
