<div class="title">
    <p><i class="iconfont icon-shouyedashboard"></i><span>管理中心</span></p>
</div>
<div class="user_cent">
    <img class="avatar" src="{{ $data->avatar }}" alt="">
    <p class="nick">欢迎您,在路上</p>
</div>
<div class="m_wp">
    <ul class="menu_list">
        <li class="item">
            <a class="log {{ request()->route()->getName() == 'Admin::index' ? 'active' : '' }}" href="{{ route('Admin::index') }}"><i class="iconfont icon-dashboard"></i><span>后台首页</span></a>
        </li>
        <li class="item">
            <a class="log {{ request()->route()->getName() == 'Admin::article.index' ? 'active' : '' }}" href="{{ route('Admin::article.index') }}"><i class="iconfont icon-svgwrite"></i><span>文章管理</span></a>
        </li>
        <li class="item">
            <a class="log {{ request()->route()->getName() == 'Admin::category.index' ? 'active' : '' }}" href="{{ route('Admin::category.index') }}"><i class="iconfont icon-categories"></i><span>分类管理</span></a>
        </li>
        <li class="item">
            <a class="log {{ request()->route()->getName() == 'Admin::tag.index' ? 'active' : '' }}" href="{{ route('Admin::tag.index') }}"><i class="iconfont icon-tag"></i><span>标签管理</span></a>
        </li>
        <li class="item">
            <a class="log" href="#"><i class="iconfont icon-setting"></i><span>系统管理</span></a>
        </li>


    </ul>

</div>
<dic class="cy">
    <p>&copy;Qin500 All rights reserved</p>
</dic>
