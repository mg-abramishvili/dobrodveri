@if(session('recentlyViewed'))
<div class="recently-viewed pt-1 pb-1">
    <div class="container">
        <h5 class="title-header title-header-center">Вы недавно смотрели</h5>

        <div class="recently-viewed-list">
            @each('product-list-item', array_reverse(session('recentlyViewed')), 'product')
        </div>
    </div>
</div>
@endif