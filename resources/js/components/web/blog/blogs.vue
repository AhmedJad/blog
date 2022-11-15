<template>
  <Header header="BLOGS" />
  <div class="container blogs-container">
    <div class="row">
      <div class="col-md-8 blog-post-container">
        <template v-if="blogs.length">
          <div v-for="blog in blogs" :key="blog.id" class="post-blog">
            <div class="blog-image">
              <router-link :to="`/blogs/${blog.id}`">
                <img :src="blog.image" alt="" />
              </router-link>
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
                <router-link :to="`/blogs/${blog.id}`">{{ blog.title }}</router-link>
              </h3>
              <p>
                {{ blog.context.substr(0, 200) }}
                <router-link v-if="blog.context.length > 200" :to="`/blogs/${blog.id}`">{{
                  $t("CONTINUE_READING")
                }}</router-link>
              </p>
            </div>
          </div>
          <div class="paginate">
            <paginate v-model="page" :pageCount="pageCounts" :clickHandler="getBlogs">
            </paginate>
          </div>
        </template>
        <div v-else class="text-center">
          {{ $t("NO_BLOGS_FOUND") }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="sidebar">
          <RecentBlogs />
          <Categories @categorySelected="onCategorySelected" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import blogClient from "../../../shared/http-clients/blog-client";
import { onMounted, reactive, toRefs } from "vue-demi";
import Categories from "./partial-components/categories";
import RecentBlogs from "./partial-components/recent-blogs";
import Header from "./partial-components/header";
import Paginate from "vuejs-paginate-next";
export default {
  components: {
    Categories,
    RecentBlogs,
    Header,
    Paginate,
  },
  setup() {
    const data = reactive({
      pageSize: 4,
      page: 1,
      blogs: [],
      pageCounts: 0,
      categoryId: null,
    });
    onMounted(() => {
      getBlogs();
    });
    //Methods
    function getBlogs() {
      blogClient
        .getBlogs(data.page, data.pageSize, null, data.categoryId)
        .then((response) => {
          data.blogs = response.data.data;
          data.pageCounts = Math.ceil(response.data.total / data.pageSize);
        })
        .catch((error) => {});
    }
    function onCategorySelected(categoryId) {
      data.categoryId = categoryId;
      data.page = 1;
      getBlogs();
    }
    return { getBlogs, ...toRefs(data), onCategorySelected };
  },
};
</script>

<style lang="scss">
.blogs-container {
  .info {
    display: flex;
  }
  .paginate {
    margin-top: 15px;
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
  .sidebar-widget {
    margin-bottom: 33px !important;
  }
  .pagination {
    li:first-child,
    li:last-child {
      display: none;
    }
    .page-link {
      &:hover {
        cursor: pointer;
      }
      & {
        margin: 0 7px;
      }
    }
  }
}
</style>
