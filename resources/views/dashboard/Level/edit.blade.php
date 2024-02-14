@extends('dashboard.layouts.master')
@section('title', trans('addLevel.Edit Product Level'))
@section('Add Level', 'active')
@section('content')

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('addLevel.Edit Product Level') }}</h4>
            <h6>{{ __('addLevel.Edit a product Level') }}</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="form" action="{{ route('/updateLevel') }}" method="POST" enctype="multipart/form-data">
                @csrf


                {{-- General Row --}}
                <div class="row">



                    {{-- NAME Col --}}
                    <div class="col-sm-8 col-12 ">



                        {{-- NAME ROW --}}
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Name') }}</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $level->name) }}">
                                    <p id="nameError"></p>
                                </div>
                            </div>
                        </div>


                        {{-- Description ROW --}}
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea class="form-control" name="description" id="description" maxlength="255">{{ old('description', $level->description) }}</textarea>
                            <p id="descriptionError"></p>
                        </div>





                        {{-- Button ROW --}}
                        <div class="col-lg-12">
                            <button id="submit" type="submit" class="btn btn-submit me-2">{{ __('Update') }}</button>
                        </div>
                    </div>





                    {{-- view Image --}}
                    <div class="col-lg-4 col-sm-4 col-12 mt-lg-0 mt-5">
                        {{-- Image ROW --}}
                        <div class="form-group">
                            <div class="form-group">
                                <label> {{ __('Image') }}</label>
                                <div class="image-upload" id="image">
                                    <input type="file" name="image"accept=".jpg, .jpeg, .png">
                                    <div class="image-uploads">
                                        <img src="{{ asset('dashboard/assets/img/icons/upload.svg') }}" alt="img">
                                        <h4>{{ __('Drag and drop a file to upload') }}</h4>
                                    </div>
                                </div>
                                <p id="imageError"></p>
                            </div>
                        </div>
                        <div id="Images"></div>
                    </div>




                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function() {




            getImages();

            function getImages() {
                axios.post('{{ route('getLevelImages') }}', {
                    "_token": '{{ csrf_token() }}',
                    "id": '{{ $level->id }}'
                }).then(function(response) {
                    $('#Images').html(response.data);
                    $(".delete").on('click', function(event) {
                        event.preventDefault();
                        var id = $(this).data("id");
                        var name = $(this).data("name");
                        deleteImage(id, name);
                    });
                }).catch(function(error) {
                    console.log(error);
                });
            }

            function deleteImage(id, name) {
                Swal.fire({
                    title: "{{ __('swal_fire.Delete') }}",
                    html: `{{ __('swal_fire.Are you sure you want to delete the image :value?', ['value' => '  ${name}  ']) }}`,
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: "{{ __('swal_fire.Delete') }}",
                    cancelButtonText: "{{ __('swal_fire.Cancel') }}",
                    confirmButtonColor: "#dc3545"
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('{{ route('deleteLevelImage') }}', {
                            "_token": '{{ csrf_token() }}',
                            "id": id
                        }).then(function(response) {
                            getImages();
                            var message = response.data.message;
                            Swal.fire({
                                icon: "success",
                                title: message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }).catch(function(error) {
                            Swal.fire({
                                title: "{{ __('swal_fire.Error') }}",
                                text: error.message,
                                icon: "error",
                                confirmButtonText: "{{ __('swal_fire.Ok') }}",
                            });
                        });
                    }
                });
            }





            $("#form").on("submit", function(event) {
                event.preventDefault();
                $('#submit').prop('disabled', true);
                var formData = new FormData(this);
                formData.append('id', {{ $level->id }});

                axios.post(this.action, formData)
                    .then(function(response) {
                        $('#submit').prop('disabled', false);
                        var message = response.data.message;
                        Swal.fire({
                            icon: "success",
                            title: message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        getImages();

                    }).catch(function(error) {
                        $('#submit').prop('disabled', false);

                        var title = error.response.data.title
                        var message = error.response.data.message;


                        if (title == 'error') {
                            Swal.fire({
                                title: "{{ __('swal_fire.Error') }}",
                                text: message,
                                icon: "error",
                                confirmButtonText: "{{ __('swal_fire.Ok') }}",
                            });
                        } else if (title.indexOf('images') !== -1) {
                            updateError('images', message);
                        } else {
                            updateError(title, message);
                        }


                    });
            });



            function updateError(elements, message) {
                const element = $('#' + elements);
                const error = $('#' + elements + 'Error');
                element.css('border', '1px solid #993333');
                error.css('color', 'brown');
                error.text(message);
                element.focus();
            }
        });
    </script>
@endsection
