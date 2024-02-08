@extends('layouts.my-layout')

@section('content')

<div class="container">

    <div class="row">
        @if(isset($products))
            @foreach($products as $product)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <article
                        class="card mt-5 overflow-hidden @if($product->discountable) border-primary @endif">
                        <div class="img-wrap">
                            <img class="w-100" src="{{ asset($product->image) }}" alt="Изображение товара">
                        </div>
                        <div class="p-3">
                            <h3 class="fs-6 mb-3">
                                {{ $product->name }}
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="fw-bold fs-5 m-0">
                                    {{ number_format($product->price, 0, '.', ' ') }} ₽
                                </p>

                                @if($cartProducts && isset($cartProducts[$product->id]))
                                    <div class="d-flex align-items-center gap-3">
                                        <form method="POST" action="{{ route('remove-from-cart') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-outline-primary">-</button>
                                        </form>

                                        <span>{{ $cartProducts[$product->id] }}</span>
                                        <form method="POST" action="{{ route('add-to-cart') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-outline-primary">+</button>
                                        </form>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('add-to-cart') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary">
                                            В корзину
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        @endif
    </div>

    <nav aria-label="Page navigation">
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    </nav>

</div>
@endsection
