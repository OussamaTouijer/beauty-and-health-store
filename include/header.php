<nav class="navbar navbar-expand-lg bg-body-tertiary " style=" position: fixed; top: 0;width: 100%;
z-index: 1000;">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Éclat & Vitalité</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarScroll"
          aria-controls="navbarScroll"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul
            class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll"
            style="--bs-scroll-height: 100px"
          >
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="client/home/home.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Categorise
              </a>
              <ul class="dropdown-menu">

              <?php
                   foreach($categories as  $Cat) {
                    print ' <li><a class="dropdown-item" href="#">'.$Cat['libelle'].'</a></li> ';
                    print '<li><hr class="dropdown-divider" /></li>';
                   }
              
              ?>

              </ul>
            </li>
              <?php if(isset($_SESSION['email'])){
                  print '<li class="nav-item">
              <a class="nav-link active" aria-current="page" href="profile.php">Profile</a >
            </li>
            ';
              }else{
                  print '            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="login.php"
                >Connection</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="registre.php"
                >Register</a
              >
            </li>';
              }?>
          </ul>
          <!-- serche -->
          <form class="d-flex" role="search" action="index.php" method="POST">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
              name="search"
            />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>

          </form>
            <?php if(isset($_SESSION['email'])){
                print '<a class="nav-link active btn btn-primary" aria-current="page" 
                 href="deconnexion.php">Deconnexion</a > ';
            }
                ?>
        </div>
      </div>
    </nav>
<div class="container mt-3" style="     width: 1px;
    height: 52px;
    background-color: #ffffff;">

</div>