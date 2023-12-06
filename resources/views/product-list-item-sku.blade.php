<div class="products-list-item">
    <a href="{{ $sku['link'] }}">
        <div class="products-list-item-image">
            <img src="{{ $sku['image'] }}" alt="$sku['name']">
        </div>

        <div class="products-list-item-price">
        @php echo number_format($sku['price'],0,","," "); @endphp <small>₽</small>
        </div>

        <p class="products-list-item-name">
            {{ $sku['name'] }}
        </p>
    </a>
</div>