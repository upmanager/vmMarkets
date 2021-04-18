<!-- Menu -->
<div class="menu">
    <ul class="list">
        <li class="q-menu-header">{{$lang->get(37)}}</li>  {{--MAIN NAVIGATION--}}

        <!-- Home -->
        @include('elements.menuItem', array('text' => $lang->get(0), 'href' => "home", 'icon' => 'home'))

        <!-- Orders -->
        @include('elements.menuItem', array('text' => $lang->get(14), 'href' => "orders", 'icon' => 'shopping_cart'))

        <!-- Transactions -->
        @include('elements.menuItem', array('text' => $lang->get(596), 'href' => "transactions", 'icon' => 'money'))

        <!-- Market -->
        @include('elements.menuItem', array('text' => $lang->get(47), 'href' => "vendormarket", 'icon' => 'business'))

        <!-- Categories -->
        @include('elements.menuItem', array('text' => $lang->get(2), 'href' => "categories", 'icon' => 'segment'))

        <!-- Products -->
        @include('elements.menuItem', array('text' => $lang->get(3), 'href' => "foods", 'icon' => 'redeem'))

        <!-- Bulk Upload -->
        @include('elements.menuItem', array('text' => $lang->get(584), 'href' => "bulkUpload", 'icon' => 'file_upload'))

        <!-- Products Tree-->
        @include('elements.menuItem', array('text' => $lang->get(572), 'href' => "productsTree", 'icon' => 'account_tree'))

        <!-- Products reviews-->
        @include('elements.menuItem', array('text' => $lang->get(6), 'href' => "foodsreviews", 'icon' => 'star_rate'))

        <!-- Reports -->
        @if (\Request::is('mostpopular')  OR \Request::is('mostpurchase'))
        <li class="q-menu-active active">
        @else
        <li class="q-menu-item">
        @endif
            <a href="javascript:void(0);" class="menu-toggle menu-text">
                <i class="material-icons">folder_open</i>
                <span class="menu-icon">{{$lang->get(16)}}</span>
            </a>
            <ul class="ml-menu">
                @include('elements.menuSubItem', array('text' => $lang->get(17), 'href' => "mostpopular"))
                @include('elements.menuSubItem', array('text' => $lang->get(18), 'href' => "mostpurchase"))
            </ul>
        </li>

        <!-- Coupons -->
        @include('elements.menuItem', array('text' => $lang->get(21), 'href' => "coupons", 'icon' => 'card_travel'))

        <!-- chat -->
        @include('elements.menuItem', array('text' => $lang->get(23), 'href' => "chat", 'icon' => 'chat_bubble_outline'))

        <!-- Banner -->
        @include('elements.menuItem', array('text' => $lang->get(505), 'href' => "vendorBanners", 'icon' => 'folder_open'))

        <!-- Media Library -->
        @include('elements.menuItem', array('text' => $lang->get(25), 'href' => "media", 'icon' => 'image'))

        <!-- Admin Panel Settings -->
        @include('elements.menuItem', array('text' => $lang->get(604), 'href' => "apSettings", 'icon' => 'settings'))

    </ul>
</div>
