@extends('dashboard.layouts.master')
@section('title', trans('productlist.Product Details'))
@section('Product', 'active')
@section('productlist', 'active')
@section('head')
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/owlcarousel/owl.theme.default.min.css') }}">

@endsection
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('productlist.Product Details') }}</h4>
            <h6>{{ __('productlist.Full details of a product') }}</h6>
        </div>
    </div>





    <div class="row">
        <div class="col-lg-8 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="bar-code-view">
                        {{ $qrcode }}
                        <a id="print" data-id="{{ $product->id }}" class="printimg">
                            <img src="{{ asset('dashboard/assets/img/icons/printer.svg') }}" alt="print">
                        </a>
                    </div>
                    <div class="productdetails">
                        <ul class="product-bar">
                            <li>
                                <h4>{{ __('productlist.Product') }}</h4>
                                <h6>{{ $product->name }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Category') }}</h4>
                                <h6>{{ $product->category->name }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Level') }}</h4>
                                <h6>{{ $product->level->name }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Brand') }}</h4>
                                <h6>{{ $product->brand->name }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Unit') }}</h4>
                                <h6>{{ $product->unit->name }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Code') }}</h4>
                                <h6>{{ $product->code }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Minimum Qty') }}</h4>
                                <h6>{{ $product->minimum_Qty }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Qty') }}</h4>
                                <h6>{{ $product->quantity }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Expiration Date') }}</h4>
                                <h6>{{ $product->expiration_date }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Description') }}</h4>
                                <h6>{{ $product->description }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Tax') }}</h4>
                                <h6>{{ $product->tax }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Discount') }}</h4>
                                <h6>{{ $product->discount }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Price') }}</h4>
                                <h6>{{ $product->price }}</h6>
                            </li>
                            <li>
                                <h4>{{ __('productlist.Status') }}</h4>
                                <h6>{{ $product->status->name }}</h6>
                            </li>



                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="slider-product-details">
                        <div class=" owl-rtl owl-carousel owl-theme product-slide">


                            @foreach ($product->images as $image)
                                <div class="slider-product">
                                    <img class="" src="{{ asset($image->url) }}" alt="img">
                                    <h4>{{ $image->name }}</h4>
                                </div>
                            @endforeach





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('dashboard/assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function() {







            $("#print").click(function() {
                var id = $(this).data('id');
                axios.post('{{ route('printProduct') }}', {
                    "_token": '{{ csrf_token() }}',
                    "id": id
                }).then(function(response) {
                    var iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    document.body.appendChild(iframe);
                    var iframeDoc = iframe.contentWindow.document;
                    iframeDoc.open();
                    iframeDoc.write(response.data);
                    iframeDoc.close();
                    iframe.contentWindow.print();
                }).catch(function(error) {
                    var title = error.response.data.title;
                    var message = error.response.data.message;
                    Swal.fire({
                        icon: "error",
                        title: message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                });
            });

        });
    </script>
@endsection
