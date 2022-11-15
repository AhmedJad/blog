<template>
  <div class="comments-container row">
    <div class="col-md-12">
      <div id="blog-comments" class="blog-post-comments">
        <h3>{{ `${blog.comments_count} ${$t("COMMENTS")}` }}</h3>
        <form @submit.prevent="createComment">
          <textarea
            v-model="content"
            class="form-contorl"
            :placeholder="$t('WIRTE_COMMNET')"
          ></textarea>
          <div v-if="content" class="actions">
            <button class="btn btn-primary">
              {{ $t("COMMENT") }}
            </button>
            <a href="" @click.prevent="content = ''">{{ $t("CANCEL") }}</a>
          </div>
        </form>
        <div class="blog-comments-content">
          <div v-for="(comment, index) in comments" :key="comment.id" class="media">
            <div class="pull-left">
              <router-link :to="`/user-blogs/${comment.user.id}`">
                <img
                  v-if="comment.user.image"
                  class="media-object"
                  :src="comment.user.image"
                  alt=""
                />
                <img
                  v-else
                  class="media-object"
                  src="/assets/images/empty.jpg"
                  alt=""
                />
              </router-link>
            </div>
            <div class="media-body">
              <div class="media-heading">
                <div class="start">
                  <router-link :to="`/user-blogs/${comment.user.id}`">
                    <h4>
                      {{ `${comment.user.first_name} ${comment.user.last_name} ` }}
                    </h4>
                  </router-link>
                  <span>{{
                    $i18n.locale == "en" ? comment.en_created_at : comment.ar_created_at
                  }}</span>
                  <span
                    v-if="blog.user.id == comment.user.id"
                    class="label label-primary"
                    >{{ $t("BLOG_OWNER") }}</span
                  >
                </div>
                <div
                  v-if="
                    mode == 'edit' || (currentUser && currentUser.id == comment.user.id)
                  "
                  class="end"
                >
                  <span @click="deleteComment(comment, index)" class="delete">
                    <i class="fa fa-times text-danger"></i>
                  </span>
                </div>
              </div>
              <p>
                {{ comment.content }}
              </p>
            </div>
          </div>
        </div>
        <!-- /.blog-comments-content -->
      </div>
      <!-- /.blog-post-comments -->
    </div>
    <!-- /.col-md-12 -->
  </div>
  <!-- /.row -->
</template>

<script>
import { inject, reactive, toRefs, watch } from "vue-demi";
import commentClient from "../../../shared/http-clients/comment-client";
import { useRouter } from "vue-router";
export default {
  setup(props, context) {
    let data = reactive({
      page: 1,
      pageSize: 5,
      comments: [],
      hasNext: true,
    });
    let form = reactive({
      content: "",
    });
    let store = inject("store");
    let router = useRouter();
    watch(
      () => props.onRecentBlogSelected,
      () => {
        data.page = 1;
        data.hasNext = true;
        data.comments = [];
        getComments(true);
      },
      { deep: true, immediate: true }
    );
    //Methods
    function deleteComment(comment, index) {
      commentClient.deleteComment(comment.id).then((response) => {
        data.comments.splice(index, 1);
        props.blog.comments_count--;
      });
    }
    function createComment() {
      if (!store.currentUser) {
        router.push(global.GUEST_REDIRECT);
      }
      commentClient.createComment(getForm()).then((response) => {
        form.content = "";
        props.blog.comments_count++;
        data.comments.unshift({ ...response.data, user: store.currentUser });
      });
    }
    //Commons
    function getComments(withScroll) {
      if (!data.hasNext) return;
      commentClient
        .getComments(data.page, data.pageSize, props.blog.id)
        .then((response) => {
          data.comments = [...data.comments, ...response.data.data];
          data.hasNext = response.data.next_page_url ? true : false;
          data.page++;
          if (withScroll) onScroll();
        });
    }
    function onScroll() {
      $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() == $(document).height()) {
          getComments(false);
        }
      });
    }
    function getForm() {
      return {
        blog_id: props.blog.id,
        content: form.content,
      };
    }
    return {
      ...toRefs(form),
      ...toRefs(store),
      ...toRefs(data),
      createComment,
      deleteComment,
    };
  },
  props: ["blog", "onRecentBlogSelected", "mode"],
};
</script>

<style lang="scss" scoped>
.comments-container {
  img {
    width: 60px;
    height: 60px;
  }
  form {
    .form-contorl {
      width: 100%;
      background: none;
    }
    margin-top: 25px;
    .actions {
      button {
        margin-top: 25px;
        background-color: #00a8d6 !important;
      }
      a {
        position: relative;
        top: 28px;
        margin: 0 30px;
      }
      display: flex;
      justify-content: flex-end;
    }
  }
  .media-heading {
    display: flex;
    justify-content: space-between;
    span {
      &.label {
        margin: 0 10px;
        color: #fff;
        display: inline-block;
        background-color: #00a8d6 !important;
      }
      &.delete {
        i {
          font-size: 14px;
        }
        &:hover {
          cursor: pointer;
        }
      }
    }
  }
}
</style>
