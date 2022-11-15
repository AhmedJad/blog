<template>
  <div class="responsive_menu">
    <ul class="main_menu">
      <li class="active">
        <router-link to="/home">{{ $t("HOME") }}</router-link>
      </li>
      <li v-show="currentUser">
        <a href="#">
          {{ `${currentUser?.first_name} ${currentUser?.last_name}` }}
        </a>
        <ul>
          <li>
            <router-link to="/profile">{{ $t("PROFILE_SETTINGS") }}</router-link>
          </li>
          <li>
            <router-link :to="`/user-blogs/${currentUser?.id}`">{{
              $t("MY_BLOGS")
            }}</router-link>
          </li>
          <li>
            <router-link to="/blogs/create">{{ $t("ADD_BLOG") }}</router-link>
          </li>
          <li>
            <a href="#" @click.prevent="logout">
              {{ $t("LOGOUT") }}
            </a>
          </li>
        </ul>
      </li>
      <li v-show="!currentUser">
        <router-link to="/login">
          {{ $t("LOGIN") }}
        </router-link>
      </li>
      <li>
        <router-link to="/blogs">{{ $t("BLOGS") }}</router-link>
      </li>
      <li>
        <router-link to="/users">{{ $t("USERS") }}</router-link>
      </li>
      <li><Lang /></li>
    </ul>
    <!-- /.main_menu -->
  </div>
  <!-- /.responsive_menu -->
</template>
<script>
import { inject, toRefs } from "vue-demi";
import Lang from "../../../shared/components/lang";
import authClient from "../../../shared/http-clients/auth-client";
import global from "../../../shared/global";
import TokenUtil from "../../../shared/utils/token-util";
import { useRouter } from "vue-router";
export default {
  components: {
    Lang,
  },
  setup() {
    const store = inject("store");
    const router = useRouter();
    //Methods
    function logout() {
      authClient
        .logout()
        .then((response) => {
          TokenUtil.remove();
          store.currentUser = null;
          router.push(global.GUEST_REDIRECT);
        })
        .catch((error) => {});
    }
    return { ...toRefs(store), logout };
  },
};
</script>

<style lang="scss" scoped>
.responsive_menu {
  z-index: 1 !important;
}
</style>
