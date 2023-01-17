<template>
  <Header header="CREATE_BLOG" />
  <div class="container blog-create">
    <div class="row">
      <div class="col-md-8 blog-post-container">
        <div class="post-blog">
          <div class="blog-image">
            <img v-if="previewImage" class="border-bottom" :src="previewImage" />
            <img v-else class="border-bottom" src="/assets/images/empty.jpg" />
            <div class="image-upload">
              <label class="icon" for="image">
                <i class="fa fa-camera"></i>
              </label>
              <label
                @click="deleteImage"
                v-if="uploadedImage"
                class="icon text-secondary px-2"
              >
                <i class="fa fa-times text-danger" aria-hidden="true"></i>
              </label>
              <input
                @change="uploadImage"
                accept="image/apng, image/avif, image/gif, image/jpeg, image/png, image/svg+xml, image/webp"
                type="file"
                id="image"
              />
            </div>
          </div>
          <div class="blog-content">
            <form @submit.prevent="store">
              <div class="form-group">
                <label for="exampleFormControlSelect1">{{ $t("CATEGORY") }}</label>
                <div class="select-wrapper">
                  <select
                    v-model="v$.category_id.$model"
                    class="form-control"
                    id="exampleFormControlSelect1"
                  >
                    <option
                      v-for="category in categories"
                      :key="category"
                      :value="category.id"
                    >
                      {{ $i18n.locale == "ar" ? category.nameAr : category.nameEn }}
                    </option>
                  </select>
                  <div class="invalid-feedback">
                    <div v-for="error in v$.category_id.$errors" :key="error">
                      {{ $t("CATEGORY") + " " + $t(error.$validator) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">{{ $t("TITLE") }}</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="v$.title.$model"
                  :class="{
                    'is-invalid': v$.title.$error,
                  }"
                />
                <div class="invalid-feedback">
                  <div v-for="error in v$.title.$errors" :key="error">
                    {{ $t("TITLE") + " " + $t(error.$validator) }}
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">{{ $t("CONTEXT") }}</label>
                <textarea
                  rows="6"
                  type="text"
                  class="form-control"
                  v-model="v$.context.$model"
                  :class="{
                    'is-invalid': v$.context.$error,
                  }"
                >
                </textarea>
                <div class="invalid-feedback">
                  <div v-for="error in v$.context.$errors" :key="error">
                    {{ $t("CONTEXT") + " " + $t(error.$validator) }}
                  </div>
                </div>
              </div>
              <button class="submit btn btn-primary">{{ $t("SUBMIT") }}</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="sidebar">
          <RecentBlogs />
        </div>
      </div>
    </div>
  </div>
  <!-- /.container -->
</template>

<script>
import { inject, onMounted, reactive, toRefs } from "vue-demi";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import blogClient from "../../../shared/http-clients/blog-client";
import { useI18n } from "vue-i18n";
import RecentBlogs from "./partial-components/recent-blogs";
import Header from "./partial-components/header";
export default {
  components: {
    RecentBlogs,
    Header,
  },
  setup(context, props) {
    const { t, locale } = useI18n({ useScope: "global" });
    let data = reactive({
      uploadedImage: null,
      previewImage: "",
      categories: [],
    });
    let form = reactive({
      title: "",
      context: "",
      category_id: null,
    });
    const rules = {
      category_id: { required },
      title: { required },
      context: { required },
    };
    const v$ = useVuelidate(rules, form);
    const toast = inject("toast");
    onMounted(() => {
      getCategories();
    });
    //Methods
    function store() {
      if (v$.value.$invalid) {
        v$.value.$touch();
        return;
      }
      if (!data.uploadedImage) {
        toast.error(t("IMAGE") + " " + t("required"));
        return;
      }
      blogClient.store(getForm()).then((response) => {
        resetForm();
        toast.success(t("CREATED_SUCCESSFULLY"));
      });
    }
    function uploadImage(e) {
      const image = e.target.files[0];
      data.uploadedImage = image;
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        data.previewImage = e.target.result;
      };
    }
    function deleteImage() {
      data.uploadedImage = null;
      data.previewImage = "";
    }
    //Commons
    function getCategories() {
      blogClient.getCategories().then((response) => {
        data.categories = response.data;
      });
    }
    function getForm() {
      let formData = new FormData();
      formData.append("image", data.uploadedImage);
      formData.append("context", form.context);
      formData.append("title", form.title);
      formData.append("category_id", form.category_id);
      return formData;
    }
    function resetForm() {
      v$.value.$reset();
      data.uploadedImage = null;
      data.previewImage = "";
      form.title = "";
      form.context = "";
      form.category_id = null;
    }
    return { v$, ...toRefs(form), ...toRefs(data), store, uploadImage, deleteImage };
  },
};
</script>

<style lang="scss">
.blog-create {
  .blog-content{
    margin-top: 8px;
  }
  .text-danger {
    color: #b94a48 !important;
  }
  .blog-image {
    margin-bottom: 0 !important;
  }
  .blog-post-container,
  .sidebar {
    @media (min-width: 992px) {
      margin-top: 45px !important;
    }
    @media (max-width: 991px) {
      margin-top: 35px !important;
    }
    margin-bottom: 0 !important;
  }
  .blog-post-container {
    .post-blog {
      margin-bottom: 0 !important;
    }
  }
  .submit {
    width: 150px;
    color: #fff;
    background-color: #00a8d6 !important;
    padding: 12px;
  }
  select,
  input {
    height: 50px;
  }
  select,
  .form-control {
    background: none;
  }
  .image-upload {
    display: flex;
    justify-content: center;
    i {
      margin-top: 7px;
      color: #888888;
    }
    .icon {
      &:hover {
        cursor: pointer !important;
      }
      i {
        margin: 0 5px;
        font-size: 14px;
        position: relative;
      }
    }
    input[type="file"] {
      display: none;
    }
        padding: 18px 0 15px 0;
    text-align: center;
    box-shadow: rgb(0 0 0 / 5%) 0px 0px 0px 1px, rgb(209 213 219) 0px 0px 0px 1px inset;
    button {
      font-size: 14px;
      color: gray;
      background: none;
    }
  }
  select {
    -webkit-appearance: none;
    appearance: none;
    border: 1px solid #f1f4f5;
    color: #777777;
  }
  .select-wrapper {
    position: relative;
    &::after {
      content: "▼";
      font-size: 1.2rem;
      top: 14px;
      position: absolute;
      color: #aeaeae;
    }
  }
  body[dir="ltr"] & {
    .select-wrapper::after {
      right: 10px;
    }
  }
  body[dir="rtl"] & {
    .select-wrapper::after {
      left: 10px;
    }
  }
}
</style>
