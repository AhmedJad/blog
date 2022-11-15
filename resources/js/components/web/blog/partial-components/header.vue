<template>
  <div class="first-widget parallax" id="blog">
    <div class="parallax-overlay">
      <div class="container pageTitle">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <h2 class="page-title">{{ $t(header) }}</h2>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-md-6 col-sm-6 text-right">
            <router-link to="/home">{{$t("HOME")}}</router-link>
            /
            <span>{{$t(header)}}</span>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.parallax-overlay -->
  </div>
  <!-- /.pageTitle -->
</template>

<script>
export default {
  setup(props) {
    return { header: props.header };
  },
  props: ["header"],
};
</script>

<style></style>
