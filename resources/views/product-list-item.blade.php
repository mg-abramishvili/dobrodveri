<div class="products-list-item">
    <a href="/product/{{ $product['slug'] }}">
        <div class="products-list-item-image">
            <img src="{{ $product['image'] ? $product['image'] : '/img/no-image.jpg' }}" alt="{{ $product['name'] }}">
        </div>

        <div class="products-list-item-price">
            @php echo number_format($product['price'],0,","," "); @endphp <small>₽</small>
        </div>

        <p class="products-list-item-name">
            {{ $product['name'] }}
        </p>

        @if($product['colors'] && count($product['colors']) > 0)
            <div class="products-list-item-colors">
                <ul>
                    @foreach($product['colors'] as $color)
                        <li>
                            <img src="{{ $color['image']}}" />
                        </li>
                    @endforeach
                </ul>

                @if($product['other_colors'] && count($product['other_colors']) > 0)
                    <span class="products-list-item-colors-more">
                        +{{ count($product['other_colors']) }}
                    </span>
                @endif
            </div>
        @endif
    </a>
</div>