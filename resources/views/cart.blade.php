@extends('layouts.my-layout')

@section('content')
    <div class="container">
        <h1 class="text-center mt-5">Корзина</h1>
        <div class="row mb-4">
            <div class="col-12 col-lg-8">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                        <article class="card mt-4 overflow-hidden">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="img-wrap">
                                        <img class="w-100" src="{{ $product->image }}" alt="Изображение товара">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-8 d-flex align-items-center">
                                    <div class="p-3">
                                        <h3 class="fs-6 mb-2">
                                            {{ $product->name }}
                                        </h3>
                                        <p>Кол-во - {{ $cartProducts[$product->id] }} шт.
                                        </p>
                                        @if(isset($cartSummary[$product->id]))
                                            <p class="fw-bold fs-6 m-0">
                                                цена без скидки - {{ number_format($product->price, 0, '.', ' ') }} ₽ /
                                                шт.
                                            </p>
                                            <p class="fw-bold fs-6 m-0">
                                                с учётом скидки <span>{{ round($cartSummary[$product->id]['discount_percent']) }}%</span>
                                                - {{ number_format($cartSummary[$product->id]['final_price'], 0, '.', ' ') }}
                                                ₽ / шт.
                                            </p>
                                        @else
                                            <p class="fw-bold fs-6 m-0">
                                                цена - {{ number_format($product->price, 0, '.', ' ') }} ₽ / шт.
                                            </p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endif
            </div>
            <div class="col-12 col-lg-4">
                <div class="card p-3 mt-4">
                    <p class="fs-4">Общая сумма заказа:</p>
                    <p class="fw-bold">{{ isset($cartSummary['total']) ? number_format($cartSummary['total'], 0, '.', ' '): 0 }}
                        ₽</p>
                    @if($cartSummary && isset($cartSummary['total_discount_percent']))
                        <p class="fs-4">Общая сумма заказа c учётом скидки <span>{{ isset($cartSummary['total_discount_percent']) ? number_format($cartSummary['total_discount_percent'], 0, '.', ' '): 0 }}%</span>:
                        </p>
                        <p class="fw-bold">{{ isset($cartSummary['total_with_discount']) ? number_format($cartSummary['total_with_discount'], 0, '.', ' '): 0 }}
                            ₽</p>
                    @endif
                    <button class="btn btn-primary">Заказать</button>
                </div>
            </div>
        </div>
    </div>
@endsection
