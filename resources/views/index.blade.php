<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    {{-- CSS --}}
    @include('layouts.css')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Start Content --}}
    <div class="container">
        <!-- Basic Tables start -->
        <section class="section mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
						<div class="col-11 d-flex align-items-center">
							<h5 class="text-title">{{ $titleTable }}</h5>
						</div>
                        @auth
                            <div class="col-1 d-flex justify-content-start align-items-center">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i></button>
                            </div>
                        @endauth
					</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    @auth
                                        <th>Status</th>
                                    @endauth
                                </tr>
                            </thead>
                            @foreach ($todos as $td)
                                <tbody>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $td->title }}</td>
                                        <td> {!! nl2br($td->description) !!}</td>
                                        @auth
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#default{{ $td->id }}"><i class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $td->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $td->id }}" action="{{ route('todos.destroy', $td->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        @endauth
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="default{{ $td->id }}" tabindex="-1" aria-labelledby="defaultModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="defaultModalLabel">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('todos.update', $td->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title" name="title" value="{{ $td->title }}">
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="helperText">Description :</label>
                                                            <textarea name="description" id="default" cols="30" rows="10">{{ $td->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Modal --}}
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- End Content --}}

    {{-- Modal Insert --}}
    <div class="modal fade {{ $errors->any() ? 'show' : '' }}" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true"
        @if($errors->any()) style="display: block; padding-right: 17px;" @endif>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add New Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('todos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter your title" id="title" name="title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Enter your description" name="description" id="default">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="submitForm()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="modal-backdrop fade show"></div>
    @endif
    {{-- End Modal Insert --}}


    {{-- JS --}}
    @include('layouts.js')
    @if(Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ Session::get('success') }}",
        });
        </script>
    @endif

    @if(Session::has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ Session::get('error') }}",
        });
        </script>
    @endif

    @if(Session::has('error') || $errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ Session::get('error') ?? 'Invalid credentials!' }}"
        });
        </script>
    @endif

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!this.checkValidity()) {
                e.stopPropagation();
                return false;
            }

            Swal.fire({
                title: 'Saving...',
                html: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            this.submit();
        });

        function submitForm() {
            Swal.fire({
                title: 'Saving...',
                html: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            document.getElementById('createForm').submit();
        }

        document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });

        document.getElementById('createModal').addEventListener('shown.bs.modal', function () {
            if (tinymce.get('default')) {
                tinymce.get('default').setContent('{{ old('description') }}');
            } else {
                tinymce.init({
                    selector: '#default',
                    plugins: 'lists link image code table',
                    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist',
                    height: 300,
                    setup: function (editor) {
                        editor.on('change', function () {
                            editor.save();
                        });
                    }
                });
            }
        });

        // Destroy TinyMCE instance when modal is hidden
        document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
            if (tinymce.get('default')) {
                tinymce.get('default').remove();
            }
        });
    </script>

    @if($errors->any())
        <script>
            document.body.classList.add('modal-open');
        </script>
    @endif
</body>

</html>
