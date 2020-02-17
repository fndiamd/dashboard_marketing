  <?php include "header.php";?>

    <nav class="navbar navbar-expand-md navbar-white bg-white fixed-top">
      <div class="container">
          <a class="navbar-brand" href="#">Adm</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_navbar" aria-controls="main_navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="main_navbar">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Segmentation</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>

    <main role="main" class="container mb-5">
      <div id="admin">
        <div class="loading" style="display:none;" align="center"><img src="assets/img/loading.gif"></div>
        <div id="panel">
            <?php include 'fragment/list_segmentation.php';?>
        </div>
      </div>
    </main><!-- /.container -->
    <script type="text/javascript">
        function openform_segmentation(){
            $(".modal-body").load('fragment/form_segmentation.php');
        }
        function openform_segmentation(){
            $(".modal-body").load('fragment/form_segmentation.php');
        }
        function followup_segmentation(){
            $("#panel").load('fragment/followup_segmentation.php');
        }
    </script>

  <?php include "footer.php";?>
