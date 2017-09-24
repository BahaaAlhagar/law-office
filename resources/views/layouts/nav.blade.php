<!-- navigtaion bar start -->
        <nav id="navigation-menu" class="navbar navbar-inverse">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">الرئيسية</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="/dates"> الجـلــســات <span class="sr-only"></span></a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">المــوكلــــين <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/clients">عــرض الموكلــين</a></li>
                    <li><a href="/clients/create">اضــافة مــوكــل</a></li>
                    <li><a href="/clients/">تـعـديل مـوكــل</a></li>
                  </ul>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="/records">أرقــام الحـصــر</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">استكمال البيانات <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/completedata">ارقام القضايا والحصر</a></li>
                    <li><a href="/olddates">قرارات الجلـــسات</a></li>
                  </ul>
                </li>
                <li><a href="/timeout">مواعــيد الطـعـــون</a></li>
                <li><a href="/officebackup">النسخ الاحتياطى</a></li>
              </ul>
              <form class="navbar-form navbar-left" method="post" action="/">
              {{ CSRF_field() }}
                <div class="form-group">
                  <input type="text" name="searchinput" class="form-control" placeholder="اسم الموكل او الخصم او رقم الدعوى">
                </div>
                <button type="submit" class="btn btn-default"><b>ابـــحـــث</b></button>
              </form>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <!-- end of navigation -->