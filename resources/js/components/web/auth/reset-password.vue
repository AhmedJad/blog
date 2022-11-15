<template>
  <div class="reset-password">
    <div class="reset-password-box">
      <div class="row">
        <!--Header-->
        <div class="header">
          <h4>{{ $t("RESET_PASSWORD") }}</h4>
          <router-link to="/login">
            {{ $t("CANCEL") }}
          </router-link>
        </div>
        <!--Form-->
        <form @submit.prevent="resetPassword">
          <div class="row">
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
            </div>
            <div class="col-12">
              <label class="form-label"
                >{{ $t("PASSWORD_CONFIRMATION") }}
                <span class="text-danger">*</span></label
              >
              <input
                v-model="v$.password_confirmation.$model"
                :type="passwordHidden ? 'password' : 'text'"
                class="form-control"
                :class="{
                  'is-invalid': v$.password_confirmation.$error,
                }"
              />
              <div class="invalid-feedback">
                <div v-for="error in v$.password_confirmation.$errors" :key="error">
                  {{ $t("PASSWORD_CONFIRMATION") + " " + $t(error.$validator) }}
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-check mt-2 mb-4">
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
            {{ $t("SUBMIT") }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import strong from "../../../shared/validators/strong-password-validator";
import { required, sameAs } from "@vuelidate/validators";
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
      password: "",
      password_confirmation: "",
      passwordHidden: true,
    };
  },
  methods: {
    resetPassword() {
      if (this.v$.$invalid) {
        this.v$.$touch();
        return;
      }
      authClient
        .resetPassword(this.getForm())
        .then(() => {
          TokenUtil.set(response.data.access_token);
          this.$router.push(global.AUTH_REDIRECT);
          this.store.currentUser = TokenUtil.getUser();
        })
        .catch((error) => {
          this.$toast.error(this.$t("TOKEN") + " " + this.$t("INVALID"));
        });
    },
    //Commons
    getForm() {
      return {
        password: this.password,
        token: this.$route.params.token,
      };
    },
  },
  inject: ["store"],
  validations() {
    return {
      password: { required, strong },
      password_confirmation: {
        required,
        sameAsPassword: sameAs(this.password),
      },
    };
  },
  inject: ["store"],
  created() {},
};
</script>

<style lang="scss" scoped>
.reset-password {
  h4 {
    color: #00a8d6;
  }
  @media (min-width: 992px) {
    margin-top: 100px;
  }
  .logo {
    img {
      width: 135px;
      height: 124px;
      border-radius: 50%;
    }
  }
  .reset-password-box {
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
      display: flex;
      justify-content: space-between;
      align-items: center;
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
    .form-check {
      label {
        position: relative;
        bottom: 1px;
      }
      input {
        border-radius: 0;
      }
    }
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
}
</style>
