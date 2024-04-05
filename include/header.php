<nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Store</a>
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
              <a class="nav-link active" aria-current="page" href="#">Home</a>
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
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="login.php"
                >Connection</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="registre.php"
                >Register</a
              >
            </li>
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
        </div>
      </div>
    </nav>