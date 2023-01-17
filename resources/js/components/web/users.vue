<template>
  <div class="users-container container">
    <template v-if="users.length">
      <div class="row">
        <div class="users row">
          <div
            v-for="user in users"
            :key="user.id"
            class="user-wrapper col-lg-3 col-md-4 col-sm-6"
          >
            <div class="avatar text-center">
              <router-link :to="`/user-blogs/${user.id}`">
                <img v-if="user.image" :src="user.image" alt="" />
                <img v-else class="border-bottom" src="/assets/images/empty.jpg" />
              </router-link>
              <div class="body">
                <div class="name">
                  <router-link :to="`/user-blogs/${user.id}`">
                    {{ `${user.first_name} ${user.last_name}` }}
                  </router-link>
                </div>
                <div class="text-secondary">{{ user.email }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="paginate">
          <paginate v-model="page" :pageCount="pageCounts" :clickHandler="getUsers">
          </paginate>
        </div>
      </div>
    </template>
    <div v-else class="users-empty text-center">
      {{ $t("NO_USERS_FOUND") }}
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
          console.log(data.users);
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
  .users-empty {
    height: 300px;
  }
  .user-wrapper {
    padding: 10px;
    .avatar {
      padding: 30px 0;
      img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 1px solid #dee2e6 !important;
        margin-bottom: 10px;
      }
      box-shadow: #0000002e 0 2px 4px;
      border: 1px solid #dee2e6 !important;
    }
  }
  @media (min-width: 992px) {
    margin-top: 140px !important;
  }
  @media (max-width: 991px) {
    margin-top: 35px !important;
  }
  margin-bottom: 50px;
  .paginate {
    margin-top: 15px;
  }
  .pagination {
    li:first-child,
    li:last-child {
      display: none;
    }
    .page-item.active a {
      background-color: #00a8d6 !important;
      border-color: #00a8d6 !important;
    }
    .page-link {
      &:hover {
        cursor: pointer;
      }
      & {
        margin: 0 7px;
      }
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  }
}
</style>
