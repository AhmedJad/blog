<template>
  <div class="users-container container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-header">
          <h2 class="section-title">{{ $t("MEET_NEW_BLOGGERS") }}</h2>
          <p class="section-desc">
            <router-link to="/users">{{ $t("SHOW_MORE_BLOGGERS") }}</router-link>
          </p>
        </div>
      </div>
      <template v-if="users.length">
        <div v-for="user in users" :key="user.id" class="user-wrapper col-lg-3 col-md-4 col-sm-6">
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
      </template>
    </div>
  </div>
</template>

<script>
import { onMounted, reactive, toRefs } from "vue-demi";
import blogClient from "../../../shared/http-clients/blog-client";
export default {
  setup() {
    const data = reactive({
      users: [],
    });
    onMounted(() => {
      getLatestUsers();
    });
    //Commons
    function getLatestUsers() {
      blogClient
        .getLatestUsers()
        .then((response) => {
          data.users = response.data;
        })
        .catch((error) => {});
    }
    return { ...toRefs(data) };
  },
};
</script>

<style lang="scss" scoped>
.users-container {
  .section-header {
    padding-bottom: 25px !important;
  }
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
}
</style>
