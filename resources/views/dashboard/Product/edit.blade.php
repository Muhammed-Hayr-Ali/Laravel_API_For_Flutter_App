@extends('dashboard.layouts.master')
@section('title', trans('addProduct.Product Edit'))
@section('Product', 'active')
@section('addProduct', 'active')
@section('head')
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')


    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('addProduct.Product Edit') }}</h4>
            <h6>{{ __('addProduct.Update your product') }}</h6>
        </div>
    </div>

    <form id="form" action="{{ route('/update') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Product Name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}">
                            <p id="nameError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Category') }}</label>
                            <select class="select" name="category_id" id="category_id">
                                <option>{{ __('addProduct.Choose Category') }}</option>
                                @foreach ($categories as $category)
                                    @if ($category->id == old('category_id', $product->category_id))
                                        {
                                        <option selected value="{{ $category->id }}">{{ __('category.' . $category->name) }}
                                        </option>
                                        }
                                    @endif
                                    <option value="{{ $category->id }}">{{ __('category.' . $category->name) }}
                                    </option>
                                @endforeach

                            </select>
                            <p id="category_idError"></p>


                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Choose Level') }}</label>
                            <select class="select" name="level_id" id="level_id">
                                <option>{{ __('addProduct.Choose Level') }}</option>
                                @foreach ($levels as $level)
                                    @if ($level->id == old('level_id', $product->level_id))
                                        {
                                        <option selected value="{{ $level->id }}">{{ __('levels.' . $level->name) }}
                                        </option>

                                        }
                                    @endif
                                    <option value="{{ $level->id }}">{{ __('levels.' . $level->name) }}</option>
                                @endforeach
                            </select>
                            <p id="level_idError"></p>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Brand') }}</label>
                            <select class="select" name="brand_id" id="brand_id">
                                <option value="1">{{ __('addProduct.Choose Brand') }}</option>
                                @foreach ($brands as $brand)
                                    @if ($brand->id == old('brand_id', $product->brand_id))
                                        {
                                        <option selected value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        }
                                    @endif
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <p id="brand_idError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Unit') }}</label>
                            <select class="select" name="unit_id" id="unit_id">
                                <option>{{ __('addProduct.Choose Unit') }}</option>
                                @foreach ($units as $unit)
                                    @if ($unit->id == old('unit_id', $product->unit_id))
                                        {
                                        <option selected value="{{ $unit->id }}">{{ __('unit.' . $unit->name) }}
                                        </option>}
                                    @endif
                                    <option value="{{ $unit->id }}">{{ __('unit.' . $unit->name) }}</option>
                                @endforeach
                            </select>
                            <p id="unit_idError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Code') }}</label>
                            <input type="text" name="code" id="code" value="{{ old('code', $product->code) }}">
                            <p id="codeError"></p>
                        </div>

                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Minimum Qty') }}</label>
                            <input type="text" name="minimum_Qty" id="minimum_Qty"
                                value="{{ old('minimum_Qty', $product->minimum_Qty) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p id="minimum_QtyError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Quantity') }}</label>
                            <input type="text" name="quantity" id="quantity"
                                value="{{ old('quantity', $product->quantity) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p id="quantityError"></p>
                        </div>
                    </div>


                    <div class="col-lg-3 col-sm-6 col-12">

                        <div class="form-group">
                            <label>{{ __('addProduct.Expiration Date') }}</label>
                            <div class="input-groupicon">
                                <input type="text" placeholder="YYYY-MM-DD" id="expiration_date" name="expiration_date"
                                    value="{{ old('expiration_date', $product->expiration_date) }}">
                                <div class="addonset">
                                    <img src="{{ asset('dashboard/assets/img/icons/calendars.svg') }}" alt="img">
                                </div>
                                <p id="expiration_dateError"></p>

                            </div>
                        </div>

                    </div>




                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Description') }}</label>
                            <textarea class="form-control" name="description" id="description">{{ old('description', $product->description) }}"</textarea>
                            <p id="descriptionError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Tax') }}</label>
                            <input type="text" name="tax" id="tax" value="{{ old('tax', $product->tax) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p id="taxError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Discount') }}</label>
                            <input type="text" name="discount" id="discount"
                                value="{{ old('discount', $product->discount) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p id="discountError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Price') }}</label>
                            <input type="text" name="price" id="price"
                                value="{{ old('price', $product->price) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p id="priceError"></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Status') }}</label>
                            <select class="select" name="status_id" id="status_id">
                                <option>{{ __('addProduct.Choose Status') }}</option>
                                @foreach ($statuses as $status)
                                    @if ($status->id == old('status_id', $product->status_id))
                                        <option selected value="{{ $status->id }}">
                                            {{ __('status.' . $status->name) }}
                                        </option>
                                    @endif
                                    <option value="{{ $status->id }}">{{ __('status.' . $status->name) }}</option>
                                @endforeach
                            </select>
                            <p id="status_idError"></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>{{ __('addProduct.Product Image') }}</label>
                            <div class="image-upload" id="images">
                                <input type="file" name="images[]"accept=".jpg, .jpeg, .png" multiple>
                                <div class="image-uploads flex flex-col items-center">
                                    <img src="{{ asset('dashboard/assets/img/icons/upload.svg') }}" alt="img">
                                    <h4>{{ __('addProduct.Drag and drop a file to upload') }}</h4>
                                </div>
                            </div>
                            <p id="imagesError"></p>
                        </div>
                    </div>




                    @if (isset($product->images) && count($product->images) > 0)
                        <div class="col-12">
                            <div class="product-list">
                                <ul class="row">


                                    @foreach ($product->images as $key => $image)
                                        <li>
                                            <div id="{{ $image->id }}" class="productviews">
                                                <div class="productviewsimg">
                                                    <img src="{{ asset($image->url) }}" alt="img">
                                                </div>
                                                <div class="productviewscontent">
                                                    <div class="productviewsname">
                                                        <h2>{{ $image->name }}</h2>
                                                    </div>
                                                    <a data-name="{{ $image->name }}"
                                                        data-id="{{ $image->id }}">x</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    @endif



                    <div class="col-lg-12">
                        <button id="submit" type="submit"
                            class="btn btn-submit me-2 bg-[#ff9f43]">{{ __('addProduct.Submit') }}</button>
                        {{-- <button href="productlist.html" class="btn btn-cancel">{{ __('addProduct.Cancel') }}</button> --}}
                    </div>

                </div>
            </div>
        </div>
    </form>


@endsection
@section('script')

    <script src="{{ asset('dashboard/assets/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#expiration_date').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-0d',
                zIndexOffset: 99999999,
            });

            $("a[data-id]").each(function() {

                var button = $(this);

                button.on('click', function() {
                    var id = button.data("id");
                    var name = button.data("name");

                    Swal.fire({
                        title: "{{ __('swal_fire.Delete') }}",
                        html: `{{ __('swal_fire.Are you sure you want to delete the image?') }} <br><br><b>${name}</b>`,
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "{{ __('swal_fire.Delete') }}",
                        cancelButtonText: "{{ __('swal_fire.Cancel') }}",

                    }).then((result) => {


                        if (result.isConfirmed) {
                            axios.post('{{ route('deleteImage') }}', {
                                "_token": '{{ csrf_token() }}',
                                "id": id
                            }).then(function(response) {
                                var message = response.data.message;
                                Swal.fire({
                                    icon: "success",
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $("#" + id).fadeOut(1000);



                            }).catch(function(error) {
                                Swal.fire({
                                    title: "{{ __('swal_fire.Error') }}",
                                    text: message,
                                    icon: "error",
                                    confirmButtonText: "{{ __('swal_fire.Ok') }}",
                                });

                            });

                        }

                    });
                });
            });




            $("#form").on("submit", function(event) {
                event.preventDefault();
                $('#submit').prop('disabled', true);
                var formData = new FormData(this);
                formData.append('id', {{ $product->id }});
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
                        $('#form')[0].reset();
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