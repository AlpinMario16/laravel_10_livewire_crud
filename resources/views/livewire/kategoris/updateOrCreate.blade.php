<div x-data="{ showForm: false, isProcessing: false, inputs: [], initializeEditor: () => {
    setTimeout(() => {
        if (!ClassicEditor.instances['description']) {
            ClassicEditor
                .create(document.querySelector('#description'))
                .catch(error => console.error(error));
        }
    }, 50); // Tunda untuk memastikan elemen sudah di-render
}}" class="row justify-content-center mt-3 mb-3">
    <div class="col-md-12">

        <!-- Tombol untuk membuka atau menutup formulir -->
        <button @click="showForm = !showForm; if (showForm) initializeEditor();" class="btn btn-primary mb-3">
            <span x-show="!showForm">Show Form</span>
            <span x-show="showForm">Hide Form</span>
        </button>

        <!-- Formulir -->
        <div x-show="showForm" class="card">
            <div class="card-header">
                <div class="float-start">
                    {{ $title }}
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="isProcessing = true; $wire.save().then(() => { isProcessing = false; success(); })">

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Kategori Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <button type="submit" class="col-md-3 offset-md-5 btn btn-success" :disabled="isProcessing">
                            Simpan
                        </button>
                    </div>

                    @if($isEdit)
                        <div class="mb-3 row">
                            <button @click="showForm = false" wire:click="cancel" class="col-md-3 offset-md-5 btn btn-danger">
                                Cancel
                            </button>
                        </div>
                    @endif

                    <!-- Tombol Add More -->
                    @if($isAdd)
                        <div class="mb-3 row">
                            <button type="button" class="col-md-3 offset-md-5 btn btn-primary" @click="inputs.push({ name: '' })">
                                Add More
                            </button>
                        </div>

                        <template x-for="(input, index) in inputs" :key="index">
                            <div class="mb-3 row">
                                <input type="text" class="form-control" x-model="input.name" placeholder="Enter name">
                            </div>
                        </template>
                    @endif

                    <div class="mb-3 row">
                        <span x-show="isProcessing" class="col-md-3 offset-md-5 text-primary">Processing...</span>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>

<script>
    function success() {
        Swal.fire({
            position: 'center',
            icon: "success",
            title: "Success",
            text: "Data Kategori disimpan",
            showConfirmButton: false,
            timer: 1500
        });
    }

    function deleteConfirmed(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('deleteConfirmed', id)
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    }
</script>
