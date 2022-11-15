<template>
  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="footer-nav clearfix">
            <ul class="footer-menu">
              <li><router-link to="/home">{{$t("HOME")}}</router-link></li>
              <li><router-link to="/profile">{{$t("PROFILE")}}</router-link></li>
              <li><router-link to="/blogs">{{$t("BLOGS")}}</router-link></li>
              <li><router-link to="/users">{{$t("USERS")}}</router-link></li>
              <li><router-link to="/login">{{$t("LOGIN")}}</router-link></li>
            </ul>
            <!-- /.footer-menu -->
          </nav>
          <!-- /.footer-nav -->
        </div>
        <!-- /.col-md-12 -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <p class="copyright-text">
            Copyright &copy; 2084 Company Name | Design: templatemo
          </p>
        </div>
        <!-- /.col-md-12 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </footer>
  <!-- /.site-footer -->
</template>

<script>
export default {};
</script>

<style></style>
