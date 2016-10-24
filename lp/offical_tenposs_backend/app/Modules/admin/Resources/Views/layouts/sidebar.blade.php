  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <!-- Optionally, you can add icons to the links -->
        <!-- <li class=""><a href=""><i class="fa fa-photo"></i> <span>Thống kê</span></a></li> -->
        <li class="{{Active::setActive(2,'dashboard')}}"><a href="{{url('admincms/dashboard')}}"><i class="fa fa-home"></i><span>Trang Chủ</span></a></li>
        <li class="{{Active::setActive(2,'blog')}}"><a href="{{route('admin.blog.index')}}"><i class="fa fa-check-circle"></i> <span>Blog</span></a></li>
        <li class="{{Active::setActive(2,'intergration')}}"><a href="{{route('admin.intergration.index')}}"><i class="fa fa-pencil-square"></i> <span>Intergration</span></a></li>
        <li class="{{Active::setActive(2,'news')}}"><a href="{{route('admin.news.index')}}"><i class="fa fa-newspaper-o"></i> <span>News</span></a></li>
        <li class="{{Active::setActive(2,'partnership')}}"><a href="{{route('admin.partnership.index')}}"> <i class="fa fa-link"></i> <span>Partnership</span></a></li>
        <li class="{{Active::setActive(2,'startguide')}}"><a href="{{route('admin.startguide.index')}}"><i class="fa fa-tasks"></i> <span>Start Guide</span></a></li>
        <li class="{{Active::setActive(2,'faq')}}"><a href="{{route('admin.faq.index')}}"><i class="fa fa-question-circle"></i> <span>FAQ</span></a></li>
        <li class="{{Active::setActive(2,'introduction')}}"><a href="{{route('admin.introduction.index')}}"><i class="fa fa-briefcase"></i> <span>Introduction Case</span></a></li>
        <li class="{{Active::setActive(2,'contact')}}"><a href="{{route('admin.contact.index')}}"><i class="fa fa-comments"></i> <span>Contact</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>