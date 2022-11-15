<template>
  <div class="forget-password">
    <div class="forget-password-box">
      <div class="row">
        <!--Header-->
        <div class="header">
          <h4>{{ $t("RESET_PASSWORD") }}</h4>
          <router-link to="/login">
            {{ $t("CANCEL") }}
          </router-link>
        </div>
        <!--Form-->
        <form @submit.prevent="forgetPassword">
          <div class="row">
            <div class="mb-3 col-12">
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
          </div>
          <button type="submit" class="btn confirm">
            {{ $t("SEND") }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import { required, email } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import authClient from "../../../shared/http-clients/auth-client";
export default {
  setup() {
    return { v$: useVuelidate() };
  },
  data: function () {
    return {
      email: "",
    };
  },
  methods: {
    forgetPassword() {
      if (this.v$.$invalid) {
        this.v$.$touch();
        return;
      }
      authClient
        .forgetPassword(this.email)
        .then((response) => {
          this.$toast.success(this.$t("EMAIL_SENT_SUCCESSFULLY"));
        })
        .catch((error) => {
          this.$toast.error(this.$t("EMAIL_NOT_FOUND"));
        });
    },
  },
  inject: ["store"],
  validations() {
    return {
      email: { required, email },
    };
  },
  created() {},
};
</script>

<style lang="scss" scoped>
.forget-password {
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
  .forget-password-box {
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
    .confirm {
      width: 150px;
      color: #fff;
      background-color: #00a8d6 !important;
      padding: 12px;
    }
    .form-control {
      background: none !important;
      padding: 25px !important;
    }
    .col-12 {
      margin-bottom: 15px;
    }
  }
}
</style>
