<template>
  <Header header="BLOG_DETAILS" />
  <div class="container blog-details">
    <div class="row">
      <div class="col-md-8 blog-post-container">
        <template v-if="blog">
          <div class="post-blog">
            <div class="blog-image">
              <img class="border-bottom" :src="blog.image" />
            </div>
            <div class="blog-content">
              <div class="info">
                <span class="meta-date">{{ blog.created_at }}</span>
                <span class="meta-comments">{{
                  `${blog.comments_count} ${$t("COMMENTS")}`
                }}</span>
                <span class="meta-author">
                  {{ `${blog.user.first_name} ${blog.user.last_name}` }}
                </span>
              </div>
              <h3>
                {{ blog.title }}
              </h3>
              <p>
                {{ blog.context }}
              </p>
            </div>
          </div>
          <div class="col-md-12">
            <div id="blog-author" class="clearfix">
              <router-link
                :to="`/user-blogs/${blog.user.id}`"
                class="blog-author-img pull-left"
              >
                <img v-if="blog.user.image" :src="blog.user.image" alt="" />
                <img v-else class="border-bottom" src="/assets/images/empty.jpg" />
              </router-link>
              <div class="blog-author-info">
                <h4 class="author-name">
                  <router-link :to="`/user-blogs/${blog.user.id}`">
                    {{ `${blog.user.first_name} ${blog.user.last_name}` }}
                  </router-link>
                </h4>
                <p>{{ blog.user.about_me ? blog.user.about_me : $t("NO_ABOUT_ME") }}</p>
              </div>
            </div>
          </div>
          <Comments :onRecentBlogSelected="onRecentBlogSelected" :blog="blog" />
        </template>
      </div>
      <div class="col-md-4">
        <div class="sidebar">
          <RecentBlogs @blogSelected="onBlogSelected($event)" />
        </div>
      </div>
    </div>
  </div>
  <!-- /.container -->
</template>

<script>
import { onMounted, reactive, toRefs } from "vue-demi";
import blogClient from "../../../shared/http-clients/blog-client";
import RecentBlogs from "./partial-components/recent-blogs";
import Header from "./partial-components/header";
import { useRoute } from "vue-router";
import Comments from "./comments";
export default {
  components: {
    RecentBlogs,
    Header,
    Comments,
  },
  setup(context, props) {
    const route = useRoute();
    let data = reactive({
      blog: null,
      onRecentBlogSelected: false,
    });
    onMounted(() => {
      setBlog(route.params.id);
    });
    //Methods
    function onBlogSelected(blogId) {
      setBlog(blogId);
    }
    //Commons
    function setBlog(blogId) {
      blogClient.show(blogId).then((response) => {
        data.blog = response.data;
        data.onRecentBlogSelected = !data.onRecentBlogSelected;
      });
    }
    return { ...toRefs(data), onBlogSelected };
  },
};
</script>

<style lang="scss">
.blog-details {
  #blog-author {
    padding-top: 28px;
  }
  .col-md-12 {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
  .blog-owner {
    margin-top: 15px;
  }
  .blog-image {
    margin-bottom: 10px !important;
  }
  .info {
    display: flex;
  }
  .blog-post-container,
  .sidebar {
    @media (min-width: 992px) {
      margin-top: 45px !important;
    }
    @media (max-width: 991px) {
      margin-top: 35px !important;
    }
    margin-bottom: 0 !important;
  }
  .blog-post-container {
    .post-blog {
      margin-bottom: 0 !important;
    }
  }
  .submit {
    width: 100px;
  }
  select {
    background-color: #f1f4f5;
  }
  .image-upload {
    i {
      margin-top: 7px;
      color: #888888;
    }
    .icon {
      &:hover {
        cursor: pointer !important;
      }
      i {
        margin: 0 5px;
        font-size: 14px;
        position: relative;
      }
    }
    text-align: center;
    input[type="file"] {
      display: none;
    }
  }
  select {
    -webkit-appearance: none;
    appearance: none;
  }
  .select-wrapper {
    position: relative;
    &::after {
      content: "▼";
      font-size: 1.2rem;
      top: 4px;
      position: absolute;
    }
  }
  body[dir="ltr"] & {
    .select-wrapper::after {
      right: 10px;
    }
  }
  body[dir="rtl"] & {
    .select-wrapper::after {
      left: 10px;
    }
  }
}
</style>
