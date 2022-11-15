<template>
  <div class="login">
    <div class="login-box">
      <div class="row">
        <!--Header-->
        <div class="header">
          <h4 class="text-muted">{{ $t("LOGIN") }}</h4>
        </div>
        <!--Form-->
        <form @submit.prevent="login">
          <div class="row">
            <div class="col-12">
              <label class="form-label"
                >{{ $t("EMAIL") }} <span class="text-danger">*</span></label
              >
              <input
                v-model="v$.email.$model"
                type="text"
                class="form-control"
                :class="{
                  'is-invalid': v$.email.$error,
                }"
              />
              <div class="invalid-feedback">
                <div v-for="error in v$.email.$errors" :key="error">
                  {{ $t("EMAIL") + " " + $t(error.$validator) }}
                </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label"
                >{{ $t("PASSWORD") }} <span class="text-danger">*</span></label
              >
              <input
                v-model="v$.password.$model"
                :type="passwordHidden ? 'password' : 'text'"
                class="form-control"
                :class="{
                  'is-invalid': v$.password.$error,
                }"
              />
              <div class="invalid-feedback">
                <div v-for="error in v$.password.$errors" :key="error">
                  {{ $t("PASSWORD") + " " + $t(error.$validator) }}
                </div>
              </div>
              <router-link to="/forget-password">{{
                $t("FORGET_PASSWORD_?")
              }}</router-link>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input
                  @change="passwordHidden = !passwordHidden"
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="flexCheckDefault"
                />
                <label class="form-check-label" for="flexCheckDefault">
                  {{ $t("SHOW_PASSWORD") }}
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="btn confirm">
            {{ $t("LOGIN") }}
          </button>
          <div class="footer">
            <h4 class="ps-form__title text-center">
              {{ $t("DONT_HAVE_ACCOUNT?") }}
            </h4>
            <div class="links">
              <router-link to="/register">{{ $t("REGISTER_NOW") }}</router-link>
              <router-link to="/home">{{ $t("CONTINUE_AS_GUEST") }}</router-link>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import { required, email } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import authClient from "../../../shared/http-clients/auth-client";
import TokenUtil from "../../../shared/utils/token-util";
import global from "../../../shared/global";
export default {
  setup() {
    return { v$: useVuelidate() };
  },
  data: function () {
    return {
      email: "",
      password: "",
      passwordHidden: true,
    };
  },
  methods: {
    login() {
      if (this.v$.$invalid) {
        this.v$.$touch();
        return;
      }
      authClient
        .login(this.getForm())
        .then((response) => {
          TokenUtil.set(response.data.access_token);
          this.$router.push(global.AUTH_REDIRECT);
          this.store.currentUser = TokenUtil.getUser();
        })
        .catch((error) => {
          this.$toast.error(this.$t("LOGIN_FAILED"));
        });
    },
    //Commons
    getForm() {
      return {
        email: this.email,
        password: this.password,
      };
    },
  },
  inject: ["store"],
  validations() {
    return {
      email: { required, email },
      password: { required },
    };
  },
  created() {},
};
</script>

<style lang="scss" scoped>
.login {
  h4 {
    color: #00a8d6;
  }
  @media (min-width: 992px) {
    margin-top: 100px;
  }
  .form-check-label {
    margin: 0 5px;
  }
  .form-control {
    background: none !important;
    padding: 25px !important;
  }
  .col-12 {
    margin-bottom: 15px;
  }
  .footer {
    margin-top: 35px;
    .ps-form__title {
      font-size: 20px;
    }
    .links {
      a {
        padding: 0 30px;
      }
      display: flex;
      justify-content: space-between;
    }
  }
  .logo {
    img {
      width: 135px;
      height: 124px;
      border-radius: 50%;
    }
  }
  .login-box {
    margin: 0 auto;
    padding: 10px;
    @media (min-width: 812px) {
      width: 60%;
    }
    input {
      border-radius: 0;
      padding: 8px;
    }
    padding: 36px;
    .header {
      margin-bottom: 22px;
    }
    .password-hint {
      font-size: 14px;
      color: #5f6368;
    }
    .confirm {
      width: 150px;
      color: #fff;
      background-color: #00a8d6 !important;
      padding: 12px;
    }
  }
  .form-check {
    margin-bottom: 15px;
    label {
      position: relative;
      bottom: 1px;
    }
    input {
      border-radius: 0 !important;
    }
  }
}
</style>
