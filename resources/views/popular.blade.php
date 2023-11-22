@php
    $popularProducts = json_decode($popularProducts, true);
@endphp

<div class="container pt-1 pb-1">
    <h5 class="title-header title-header-center">Популярные позиции</h5>

    <div class="category-products-list">
        @foreach($popularProducts as $product)
            <div class="products-list-item">
                <a href="/product/{{ $product['slug'] }}">
                    @if($product['image'])
                        <div class="products-list-item-image">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                        </div>
                    @endif

                    <div class="products-list-item-price">
                        @php echo number_format($product['price'],0,","," "); @endphp <small>₽</small>
                    </div>

                    <p class="products-list-item-name">
                        {{ $product['name'] }}
                    </p>
                </a>
            </div>
        @endforeach
    </div>
</div>