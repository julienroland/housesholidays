
<body id="admin">

  <nav class=" navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Admin - {{Auth::user()->prenom}}</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">

        <li {{Helpers::IsNotok(Request::segment(2))? 'class="active"' :''}} >
          {{link_to_route('getIndexAdmin','Accueil admin')}}
          </li>
          <li {{Helpers::isActive('pages', Request::segment(2))}}>
          {{link_to_route('admin.pages.index','Pages')}}
          </li>
          <li {{Helpers::isActive('users', Request::segment(2))}}>
          {{link_to_route('listUsers','Utilisateurs')}}
          </li>
          <li {{Helpers::isActive('locations', Request::segment(2))}}>
            {{link_to_route('listLocations','Locations')}}
          </li>
          <li {{Helpers::isActive('traductions', Request::segment(2))}}>
            {{link_to_route('listTraductions','Traductions')}}
          </li>
            <li {{Helpers::isActive('traductions', Request::segment(2))}}>
            {{link_to('admin/traductions/statiques','Traductions statiques')}}
          </li>
          <li {{Helpers::isActive('databases', Request::segment(2))}}>
            {{link_to_route('listDatabases','Ajout à la base de donnée')}}
          </li>
        </ul>
       <!--  <form class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form> -->
        <ul class="nav navbar-nav navbar-right">
          <li>{{link_to_route('deconnexion','Déconnecter')}}</li>
          <li>{{link_to_route('leaveAdmin','Quitter l\'admin')}}</li>
         <!--  <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li> -->
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>