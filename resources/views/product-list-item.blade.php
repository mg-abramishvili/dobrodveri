<div class="products-list-item">
    <a href="/product/{{ $product['slug'] }}">
        <div class="products-list-item-image">
            <img src="{{ $product['image'] ? $product['image'] : '/img/no-image.jpg' }}" alt="{{ $product['name'] }}">
        </div>

        <div class="products-list-item-price">
            @php echo number_format($product['price'],0,","," "); @endphp<small>₽</small>
            
            @if($product['old_price'])
                <div class="products-list-item-price-old">
                    @php echo number_format($product['old_price'],0,","," "); @endphp<small>₽</small>
                </div>
            @endif
        </div>

        @if($product['percent'])
            <div class="products-list-item-percent">
                {{ $product['percent'] }}
            </div>
        @endif

        <p class="products-list-item-name">
            {{ $product['name'] }}
        </p>

        <div class="products-list-item-tags">
            @if($product['hit'])
                <div class="products-list-item-tag products-list-item-tag-hit">Хит</div>
            @endif
            @if($product['discount'])
                <div class="products-list-item-tag products-list-item-tag-discount">Скидка</div>
            @endif
            @if($product['sale'])
                <div class="products-list-item-tag products-list-item-tag-sale">Распродажа</div>
            @endif
            @if($product['special'])
                <div class="products-list-item-tag products-list-item-tag-special">Акция</div>
            @endif
        </div>

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

    <div class="products-list-item-buttons">
        <a href="tel:+79378504040">Заказать</a>
        <a href="/product/{{ $product['slug'] }}">Подробнее</a>
    </div>
</div>