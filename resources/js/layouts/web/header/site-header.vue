<template>
  <header class="site-header clearfix">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="pull-left logo">
            <router-link to="/home">
              <img src="/assets/images/logo.png" alt="Medigo by templatemo" />
            </router-link>
          </div>
          <!-- /.logo -->

          <div class="main-navigation pull-right">
            <nav class="main-nav visible-md visible-lg">
              <ul class="sf-menu">
                <li
                  @click="currentLink = 'home'"
                  :class="{ active: currentLink == 'home' }"
                >
                  <router-link to="/home">{{ $t("HOME") }}</router-link>
                </li>
                <li v-show="currentUser">
                  <a href="#">
                    {{ `${currentUser?.first_name} ${currentUser?.last_name}` }}
                  </a>
                  <ul>
                    <li>
                      <router-link to="/profile">{{
                        $t("PROFILE_SETTINGS")
                      }}</router-link>
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
                <li
                  @click="currentLink = 'login'"
                  :class="{ active: currentLink == 'login' }"
                  v-show="!currentUser"
                >
                  <router-link to="/login">
                    {{ $t("LOGIN") }}
                  </router-link>
                </li>
                <li
                  @click="currentLink = 'blogs'"
                  :class="{ active: currentLink == 'blogs' }"
                >
                  <router-link to="/blogs">{{ $t("BLOGS") }}</router-link>
                </li>
                <li><Lang /></li>
              </ul>
              <!-- /.sf-menu -->
            </nav>
            <!-- /.main-nav -->

            <!-- This one in here is responsive menu for tablet and mobiles -->
            <div class="responsive-navigation visible-sm visible-xs">
              <a href="#nogo" class="menu-toggle-btn">
                <i class="fa fa-bars"></i>
              </a>
            </div>
            <!-- /responsive_navigation -->
          </div>
          <!-- /.main-navigation -->
        </div>
        <!-- /.col-md-12 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </header>
  <!-- /.site-header -->
</template>

<script>
import { inject, onMounted, onUpdated, reactive, toRefs } from "vue-demi";
import Lang from "../../../shared/components/lang.vue";
import global from "../../../shared/global";
import TokenUtil from "../../../shared/utils/token-util";
import authClient from "../../../shared/http-clients/auth-client";
import { useRouter } from "vue-router";
import { initSuperFish } from "../../../custom";
import { responsiveHeaderToggle } from "../../../custom";
export default {
  components: {
    Lang,
  },
  setup() {
    const router = useRouter();
    const store = inject("store");
    const data = reactive({
      currentLink: "home",
    });
    onUpdated(() => {
      initSuperFish();
    });
    onMounted(() => {
      responsiveHeaderToggle();
      initSuperFish();
    });
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
    return { ...toRefs(inject("store")), ...toRefs(data), logout };
  },
};
</script>

<style lang="scss" scoped>
ul li:focus {
  color: red !important;
}
</style>
