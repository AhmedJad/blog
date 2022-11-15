<template>
  <section id="homeIntro" class="parallax first-widget">
    <div class="parallax-overlay">
      <div class="container home-intro-content">
        <div class="row">
          <div class="col-md-12">
            <h2>{{ $t("HOME_BANNER_HEADER") }}</h2>
            <p>
              {{ $t("HOME_BANNER_FIRST_TEXT") }}
              <br />
              {{ $t("HOME_BANNER_SECOND_TEXT") }}
            </p>
            <router-link to="/register" class="large-button white-color">
              {{ $t("REGISTER_FREE") }} <i class="icon-button fa fa-arrow-right"></i>
            </router-link>
          </div>
          <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.parallax-overlay -->
  </section>
  <!-- /#homeIntro -->
  <section class="cta clearfix">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="cta-title">
            <strong>{{ $t("YOU_HAVE_ACCOUNT") }}</strong>
            {{ $t("LETS_START_YOUR_JOURNEY") }}
          </h4>
          <router-link  to="/login" class="main-button accent-color"
            >{{ $t("LOGIN") }}<i class="icon-button fa fa-arrow-right"></i
          ></router-link>
        </div>
        <!-- /.col-md-12 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </section>
  <!-- /.cta -->
</template>

<script>
export default {
};
</script>

<style></style>
