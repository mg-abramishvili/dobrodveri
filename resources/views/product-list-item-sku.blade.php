<div class="products-list-item">
    <div class="product-list-item-inner">
        <a href="{{ $sku['link'] }}">
            <div class="products-list-item-image">
                <img src="{{ $sku['image'] ? $sku['image'] : '/img/no-image.jpg' }}" alt="{{ $sku['name'] }}">
            </div>
    
            <div class="products-list-item-price">
                @php echo number_format($sku['price'],0,","," "); @endphp <small>₽</small>
                
                @if($sku['old_price'])
                    <div class="products-list-item-price-old">
                        @php echo number_format($sku['old_price'],0,","," "); @endphp<small>₽</small>
                    </div>
                @endif
            </div>
    
            <div class="products-list-item-name">
                {{ $sku['name'] }}
            </div>

            @if($sku['percent'])
                <div class="products-list-item-percent">
                    {{ $sku['percent'] }}
                </div>
            @endif

            @if($sku['balance'])
                <div class="products-list-item-balance">
                    @if($sku['balance'] != 'В наличии в Уфе')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                        </svg>
                    @endif

                    {{ $sku['balance'] }}
                </div>
            @endif

            <div class="products-list-item-credit">
                Рассрочка 0%
            </div>
    
            <div class="products-list-item-tags">
                @if($sku['hit'])
                    <div class="products-list-item-tag products-list-item-tag-hit">Хит</div>
                @endif
                @if($sku['special'])
                    <div class="products-list-item-tag products-list-item-tag-special">Акция</div>
                @endif
            </div>
    
            @if($sku['colors'] && count($sku['colors']) > 0)
                <div class="products-list-item-colors">
                    <ul>
                        @foreach($sku['colors'] as $color)
                            <li>
                                <img src="{{ $color['image']}}" />
                            </li>
                        @endforeach
                    </ul>
    
                    @if($sku['other_colors'] && count($sku['other_colors']) > 0)
                        <span class="products-list-item-colors-more">
                            +{{ count($sku['other_colors']) }}
                        </span>
                    @endif
                </div>
            @endif
        </a>
    
        <div class="products-list-item-buttons">
            <a href="tel:+79378504040">Заказать</a>
            <a href="{{ $sku['link'] }}">Подробнее</a>
        </div>
    </div>
</div>