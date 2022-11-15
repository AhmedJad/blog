<template>
  <section id="blogPosts" class="parallax">
    <div class="parallax-overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-header">
              <h2 class="section-title">{{$t("RECENT_BLOGS")}}</h2>
              <p class="section-desc">
                {{$t("HOME_BLOGS_TEXT")}}
              </p>
            </div>
            <!-- /.section-header -->
          </div>
          <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
        <div class="row latest-posts">
          <template v-if="blogs.length">
            <div v-for="blog in blogs" :key="blog.id" class="col-md-4 col-sm-6">
              <div class="blog-post clearfix">
                <div class="thumb-post">
                  <router-link :to="`/blogs/${blog.id}`"
                    ><img :src="blog.image" alt="" />
                  </router-link>
                </div>
                <div class="blog-post-content">
                  <h4 class="post-title">
                    <router-link :to="`/blogs/${blog.id}`">{{ blog.title }}</router-link>
                  </h4>
                  <span class="meta-post-date">{{ blog.created_at }}</span>
                </div>
              </div>
              <!-- /.blog-post -->
            </div>
          </template>
          <div v-else class="text-center">
            {{ $t("NO_BLOGS_FOUND") }}
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.parallax-overlay -->
  </section>
  <!-- /#blogPosts -->
</template>

<script>
import { onMounted, reactive, toRefs } from "vue-demi";
import blogClient from "../../../shared/http-clients/blog-client";
export default {
  setup(props, context) {
    const data = reactive({
      blogs: [],
    });
    onMounted(() => {
      getRecentBlogs();
    });
    //Commons
    function getRecentBlogs() {
      blogClient.getRecentBlogs().then((response) => {
        data.blogs = response.data;
      });
    }
    return { ...toRefs(data) };
  },
};
</script>

<style></style>
