<template>
  <div class="container">
    <div class="team-members">
      <div class="row">
        <div class="col-md-12">
          <div class="section-header">
            <h2 class="section-title">{{ $t("MEET_NEW_BLOGGERS") }}</h2>
            <p class="section-desc">
              <router-link to="/users">{{ $t("SHOW_MORE_BLOGGERS") }}</router-link>
            </p>
          </div>
        </div>
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
.team-members {
  margin-top: 80px;
}
.section-header {
  margin-top: 25px;
}
</style>
