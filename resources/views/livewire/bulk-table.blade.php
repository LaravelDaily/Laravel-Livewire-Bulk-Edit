<div>
    <button data-toggle="modal" data-target="#categories-modal" class="btn btn-success" {{ $bulkDisabled ? 'disabled' : null }}>Bulk edit</button>
    <table class="table table-stripped mt-3">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Category</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <th>
                    <input type="checkbox" wire:model="selectedProducts.{{ $product->id }}">
                </th>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
            </tr>
        @endforeach
    </table>

    <div id="categories-modal" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select wire:model.defer="selectedCategory" class="form-control">
                        <option value="null">Please select</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="changeCategory">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function () {

    })
</script>

