<template>
  <div class="sidebar-widget">
    <h5 class="widget-title">{{ $t("RECENT_BLOGS") }}</h5>
    <template v-if="blogs.length">
      <div v-for="blog in blogs" :key="blog.id" class="last-post clearfix">
        <div class="thumb pull-left">
          <router-link @click="onBlogSelected(blog)" :to="`/blogs/${blog.id}`"
            ><img :src="blog.image" alt=""
          /></router-link>
        </div>
        <div class="content">
          <span>{{ blog.created_at }}</span>
          <h4>
            <router-link @click="onBlogSelected(blog)" :to="`/blogs/${blog.id}`">{{
              blog.title
            }}</router-link>
          </h4>
        </div>
      </div>
    </template>
    <div v-else class="text-center">
      {{ $t("NO_BLOGS_FOUND") }}
    </div>
  </div>
</template>

<script>
import { onMounted, reactive, toRefs } from "vue-demi";
import blogClient from "../../../../shared/http-clients/blog-client";
export default {
  setup(props, context) {
    const data = reactive({
      blogs: [],
    });
    onMounted(() => {
      getRecentBlogs();
    });
    //Methods
    function onBlogSelected(blog) {
      context.emit("blogSelected", blog.id);
    }
    //Commons
    function getRecentBlogs() {
      blogClient.getRecentBlogs().then((response) => {
        data.blogs = response.data;
      });
    }
    return { ...toRefs(data), onBlogSelected };
  },
};
</script>

<style lang="scss" scoped>
.thumb {
  img {
    width: 100px !important;
    height: 70px;
  }
}
</style>
