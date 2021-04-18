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

        <!-- Markets -->
        @if (\Request::is('restaurants') OR \Request::is('marketsreviews'))
        <li class="q-menu-active active">
        @else
        <li class="q-menu-item">
        @endif
            <a href="javascript:void(0);" class="menu-toggle menu-text">
                <i class="material-icons">business</i>
                <span class="menu-icon">{{$lang->get(8)}}</span>
            </a>
            <ul class="ml-menu">
                @include('elements.menuSubItem', array('text' => $lang->get(8), 'href' => "restaurants"))
                @include('elements.menuSubItem', array('text' => $lang->get(9), 'href' => "marketsreviews"))
            </ul>
        </li>

        <!-- Vendors -->
        @include('elements.menuItem', array('text' => $lang->get(552), 'href' => "vendors", 'icon' => 'business'))

        <!-- Drivers -->
        @include('elements.menuItem', array('text' => $lang->get(20), 'href' => "drivers", 'icon' => 'directions_car'))

        <!-- Users -->
        @include('elements.menuItem', array('text' => $lang->get(11), 'href' => "users", 'icon' => 'account_circle'))

        <!-- Categories -->
        @include('elements.menuItem', array('text' => $lang->get(2), 'href' => "categories", 'icon' => 'segment'))

        <!-- Reports -->
        @if (\Request::is('mostpopular')  OR \Request::is('mostpurchase') OR \Request::is('toprestaurants'))
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
                @include('elements.menuSubItem', array('text' => $lang->get(19), 'href' => "toprestaurants"))
            </ul>
        </li>

        <!-- Notifications -->
        @include('elements.menuItem', array('text' => $lang->get(22), 'href' => "notify", 'icon' => 'notifications'))

        <!-- chat -->
        @include('elements.menuItem', array('text' => $lang->get(23), 'href' => "chat", 'icon' => 'chat_bubble_outline'))

        <!-- wallet -->
        @include('elements.menuItem', array('text' => $lang->get(24), 'href' => "wallet", 'icon' => 'credit_card'))

        <!-- Banner -->
        @include('elements.menuItem', array('text' => $lang->get(505), 'href' => "banners", 'icon' => 'folder_open'))

        <!-- Documents -->
        @include('elements.menuItem', array('text' => $lang->get(497), 'href' => "documents", 'icon' => 'content_paste'))

        <!-- FAQ -->
        @include('elements.menuItem', array('text' => $lang->get(26), 'href' => "faq", 'icon' => 'question_answer'))

        <li class="q-menu-header">{{$lang->get(27)}}</li>  {{--Settings--}}

        <!-- Media Library -->
        @include('elements.menuItem', array('text' => $lang->get(25), 'href' => "media", 'icon' => 'image'))

        <!-- Settings -->
        @if (\Request::is('payments') OR \Request::is('settings') OR \Request::is('currencies')
                                            OR \Request::is('topfoods') OR \Request::is('toprestaurants2'))
        <li class="q-menu-active active">
        @else
        <li class="q-menu-item">
        @endif
            <a href="javascript:void(0);" class="menu-toggle menu-text">
                <i class="material-icons">settings</i>
                <span class="menu-icon">{{$lang->get(27)}}</span>
            </a>
            <ul class="ml-menu">
                @include('elements.menuSubItem', array('text' => $lang->get(27), 'href' => "settings"))
                @include('elements.menuSubItem', array('text' => $lang->get(28), 'href' => "currencies"))
                @include('elements.menuSubItem', array('text' => $lang->get(29), 'href' => "payments"))
                @include('elements.menuSubItem', array('text' => $lang->get(7), 'href' => "topfoods"))
                @include('elements.menuSubItem', array('text' => $lang->get(10), 'href' => "toprestaurants2"))
            </ul>
        </li>

        <!-- Customer App Settings -->
        @if (\Request::is('caLayout') OR \Request::is('caLayoutColors') OR \Request::is('caTheme') OR \Request::is('caLayoutSizes')
                                                   OR \Request::is('caSkins') )
        <li class="q-menu-active active">
        @else
        <li class="q-menu-item">
        @endif
            <a href="javascript:void(0);" class="menu-toggle menu-text">
                <i class="material-icons">settings</i>
                <span class="menu-icon">{{$lang->get(30)}}</span>
            </a>
            <ul class="ml-menu">
                @include('elements.menuSubItem', array('text' => $lang->get(31), 'href' => "caTheme"))
                @include('elements.menuSubItem', array('text' => $lang->get(32), 'href' => "caLayout"))
                @include('elements.menuSubItem', array('text' => $lang->get(612), 'href' => "caSkins"))  {{--Select Skin--}}
                @include('elements.menuSubItem', array('text' => $lang->get(33), 'href' => "caLayoutColors"))
                @include('elements.menuSubItem', array('text' => $lang->get(34), 'href' => "caLayoutSizes"))
            </ul>
        </li>

        <!-- Admin Panel Settings -->
        @include('elements.menuItem', array('text' => $lang->get(604), 'href' => "apSettings", 'icon' => 'settings'))

        <!-- Web Site Settings -->
        @if (\Request::is('webSettings') OR \Request::is('webSeller')  )
            <li class="q-menu-active active">
        @else
            <li class="q-menu-item">
        @endif
            <a href="javascript:void(0);" class="menu-toggle menu-text">
                <i class="material-icons">settings</i>
                <span class="menu-icon">{{$lang->get(609)}}</span>
            </a>
            <ul class="ml-menu">
                <!-- General -->
                @include('elements.menuSubItem', array('text' => $lang->get(31), 'href' => "webSettings"))
                <!-- Seller Registration Page -->
                @include('elements.menuSubItem', array('text' => $lang->get(615), 'href' => "webSeller"))
            </ul>
        </li>

    </ul>
</div>
