<?php
require_once "main.php";
require_once "include/header.php";
?>

<body>

  <div id="colorlib-page">
    <aside id="colorlib-aside" role="complementary" class="js-fullheight">
      <nav id="colorlib-main-menu" role="navigation">
        <?= $menu->give_html() ?>
      </nav>
    </aside> <!-- END COLORLIB-ASIDE -->
    <div id="colorlib-main">
      <section class="ftco-about img ftco-section ftco-no-pt ftco-no-pb" id="about-section">
        <div class="container-fluid px-0">
          <div class="row d-flex mt-5">
            <div class="col-md-6 d-flex align-items-center">
              <div class="text px-4 pt-5 pt-md-0 px-md-4 pr-md-5 ftco-animate">
                <h2 class="mb-4">I'm <span>Andrea Moore</span> a Scotish Blogger &amp; Explorer</h2>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a
                  paradisematic country, in which roasted parts of sentences fly into your mouth. It is a paradisematic
                  country, in which roasted parts of sentences fly into your mouth.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div><!-- END COLORLIB-MAIN -->
  </div><!-- END COLORLIB-PAGE -->

  <!-- loader -->
  <?php
  include "include/loader.php";
  ?>


  <?php
  include "include/script.php";
  ?>

</body>

</html>