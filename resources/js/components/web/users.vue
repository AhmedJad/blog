<template>
  <div class="container users-container">
    <div class="team-members">
      <div class="row">
        <div v-for="user in users" :key="user.id" class="col-lg-4 col-md-6">
          <div class="team-member">
            <div class="thumb-post">
              <router-link :to="`/user-blogs/${user.id}`">
                <img v-if="user.image" :src="user.image" alt="" />
                <img v-else class="border-bottom" src="/assets/images/empty.jpg" />
              </router-link>
            </div>
            <div class="member-content">
              <h4 class="member-name">
                <router-link :to="`/user-blogs/${user.id}`">
                  {{ `${user.first_name} ${user.last_name}` }}
                </router-link>
              </h4>
              <p>{{ user.about_me ? user.about_me : $t("NO_ABOUT_ME") }}</p>
            </div>
          </div>
          <!-- /.team-member -->
        </div>
      </div>
    </div>
    <div class="paginate">
      <paginate v-model="page" :pageCount="pageCounts" :clickHandler="getUsers">
      </paginate>
    </div>
  </div>
</template>

<script>
import { onMounted, reactive, toRefs } from "vue-demi";
import blogClient from "../../shared/http-clients/blog-client";
import Paginate from "vuejs-paginate-next";
export default {
  components: {
    Paginate,
  },
  setup() {
    const data = reactive({
      pageSize: 6,
      page: 1,
      users: [],
      pageCounts: 0,
    });
    onMounted(() => {
      getUsers();
    });
    //Commons
    function getUsers() {
      blogClient
        .getUsers(data.page, data.pageSize)
        .then((response) => {
          data.users = response.data.data;
          console.log(data.users)
          data.pageCounts = Math.ceil(response.data.total / data.pageSize);
        })
        .catch((error) => {});
    }
    return { ...toRefs(data), getUsers };
  },
};
</script>

<style lang="scss">
.users-container {
  .team-members {
    @media (min-width: 992px) {
      margin-top: 135px !important;
    }
    @media (max-width: 991px) {
      margin-top: 40px !important;
    }
    .paginate {
      margin-top: 15px;
    }
    border-bottom: 1px solid #dce4e6;
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
