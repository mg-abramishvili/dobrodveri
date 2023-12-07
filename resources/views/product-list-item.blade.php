<div class="products-list-item">
    <div class="product-list-item-inner">
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
    
            <div class="products-list-item-name">
                {{ $product['name'] }}
            </div>

            @if($product['balance'])
                <div class="products-list-item-balance">
                    @if($product['balance'] != 'В наличии в Уфе')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                        </svg>
                    @endif

                    {{ $product['balance'] }}
                </div>
            @endif
    
            <div class="products-list-item-tags">
                @if($product['hit'])
                    <div class="products-list-item-tag products-list-item-tag-hit">Хит</div>
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
</div>