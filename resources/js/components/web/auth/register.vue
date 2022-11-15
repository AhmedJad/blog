<template>
  <div class="signup">
    <div class="signup-box">
      <div class="row">
        <!--Header-->
        <div class="header">
          <h4>{{ $t("REGISTER_NEW_ACCOUNT") }}</h4>
          <router-link to="/login">
            {{ $t("CANCEL") }}
          </router-link>
        </div>
        <!--Form-->
        <form @submit.prevent="register">
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
                  'is-invalid': v$.email.$error || emailExist,
                }"
              />
              <div class="invalid-feedback">
                <div v-for="error in v$.email.$errors" :key="error">
                  {{ $t("EMAIL") + " " + $t(error.$validator) }}
                </div>
                <div v-if="!v$.email.$invalid && emailExist">
                  {{ $t("EMAIL") + " " + $t("EXIST") }}
                </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label">
                {{ $t("FIRST_NAME") }} <span class="text-danger">*</span></label
              >
              <input
                v-model="v$.first_name.$model"
                type="text"
                class="form-control"
                :class="{
                  'is-invalid': v$.first_name.$error,
                }"
              />
              <div class="invalid-feedback">
                <div v-for="error in v$.first_name.$errors" :key="error">
                  {{ $t("FIRST_NAME") + " " + $t(error.$validator) }}
                </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label"
                >{{ $t("LAST_NAME") }} <span class="text-danger">*</span></label
              >
              <input
                v-model="v$.last_name.$model"
                type="text"
                class="form-control"
                :class="{
                  'is-invalid': v$.last_name.$error,
                }"
              />
              <div class="invalid-feedback">
                <div v-for="error in v$.last_name.$errors" :key="error">
                  {{ $t("LAST_NAME") + " " + $t(error.$validator) }}
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
            {{ $t("REGISTER") }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import strong from "../../../shared/validators/strong-password-validator";
import { required, email, sameAs } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import authClient from "../../../shared/http-clients/auth-client";
import global from "../../../shared/global";
import TokenUtil from "../../../shared/utils/token-util";
export default {
  setup() {
    return { v$: useVuelidate() };
  },
  data: function () {
    return {
      first_name: "",
      last_name: "",
      email: "",
      password: "",
      password_confirmation: "",
      passwordHidden: true,
      emailExist: false,
    };
  },
  methods: {
    register() {
      if (this.v$.$invalid) {
        this.v$.$touch();
        return;
      }
      this.emailExist = false;
      authClient
        .register(this.getForm())
        .then((response) => {
          TokenUtil.set(response.data.access_token);
          this.$router.push("/verify-email");
          this.store.currentUser = TokenUtil.getUser();
        })
        .catch((error) => {
          this.emailExist = error.response.data.errors ? true : false;
        });
    },
    //Commons
    getForm() {
      return {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        password: this.password,
      };
    },
  },
  inject: ["store"],
  validations() {
    return {
      first_name: { required },
      last_name: { required },
      email: { required, email },
      password: { required, strong },
      password_confirmation: {
        required,
        sameAsPassword: sameAs(this.password),
      },
    };
  },
  created() {},
};
</script>

<style lang="scss" scoped>
.signup {
   @media (min-width: 992px) {
    margin-top: 100px;
  }
  h4 {
    color: #00a8d6;
  }
  .col-12 {
    margin-bottom: 15px;
  }
  .logo {
    img {
      width: 135px;
      height: 124px;
      border-radius: 50%;
    }
  }
  .signup-box {
    margin: 0 auto;
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
  .form-check-label {
    margin: 0 5px;
  }
  .form-control {
    background: none !important;
    padding: 25px !important;
  }
}
</style>
