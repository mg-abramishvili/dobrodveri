@if(session('recentlyViewed'))
<div class="recently-viewed pt-1 pb-1">
    <div class="container">
        <h5 class="title-header title-header-center">Вы недавно смотрели</h5>

        <div class="recently-viewed-list">
            @foreach(array_reverse(session('recentlyViewed')) as $product)
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
</div>
@endif