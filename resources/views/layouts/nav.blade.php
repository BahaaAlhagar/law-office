<nav id="navigation-menu" class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark  print-hidden">
  <a class="navbar-brand" href="/">الرئيسية</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav navbar-right">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('people.index') }}"> الاشخاص </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('contracts.index') }}"> التوكيلات </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('issues.index') }}"> القضايا </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('todos.index') }}"> الاعمال الادارية </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('meetings.list') }}"> الجلســـات </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('office.records') }}"> ارقام الحصر </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          استكمال البيانات
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="{{ route('office.late') }}">قرارات الجلــسات</a>
          <a class="dropdown-item" href="{{ route('office.missingData') }}">بيانات القضايا وارقام الحصر</a>
        </div>
      </li>
    </ul>

    <form class="form-inline my-2 my-lg-0 mr-auto">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>

    <ul class="navbar-nav navbar-right">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/change_password">تغيير كلمة المرور</a>
          <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
              تسحيل الخروج
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
        </div>
      </li>
    </ul>

  </div>
</nav>