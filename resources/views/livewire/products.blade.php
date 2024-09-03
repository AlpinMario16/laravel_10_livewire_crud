<div class="row justify-content-center mt-3">
    <div class="col-md-12">

    @if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK'
    });
</script>
@endif



        @include('livewire.updateOrCreate')


        <div class="row justify-content-center text-center mt-3">
            <div class="col-md-12">
                <p>Back to Tutorial: 
                    <a href="https://www.allphptricks.com/laravel-10-livewire-crud-application-tutorial/"><strong>Tutorial Link</strong></a>
                </p>
                <p>
                    For More Web Development Tutorials Visit: <a href="https://www.allphptricks.com/"><strong>AllPHPTricks.com</strong></a>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Product List</div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr wire:key="{{ $product->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <button wire:click="edit({{ $product->id }})" 
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>   

                                    <button wire:click="$emit('triggerDelete', {{ $product->id }})" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                    </button>
                                    

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <span class="text-danger">
                                        <strong>No Product Found!</strong>
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div>
