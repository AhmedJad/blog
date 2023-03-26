<template>
  <Header header="CREATE_BLOG" />
  <div class="container blog-edit">
    <div class="row">
      <div class="col-md-8 blog-post-container">
        <div class="post-blog">
          <div class="blog-image">
            <img v-if="previewImage" class="border-bottom" :src="previewImage" />
            <img v-else class="border-bottom" src="/assets/images/empty.jpg" />
            <div class="image-upload">
              <label v-if="!uploadedImage" class="icon" for="image">
                <i class="fa fa-camera"></i>
              </label>
              <label @click="deleteImage" v-if="uploadedImage" class="icon text-secondary px-2">
                <i class="fa fa-times text-danger" aria-hidden="true"></i>
              </label>
              <input @change="uploadImage"
                accept="image/apng, image/avif, image/gif, image/jpeg, image/png, image/svg+xml, image/webp" type="file"
                id="image" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="padding: 0;">
              <div class="contact-form">
                <h3>{{ $t("Edit blog data") }}</h3>
                <div class="widget-inner">
                  <template v-if="blog">
                    <form style="border:none" @submit.prevent="update">
                      <div class="col-md-6" style="padding:0;">
                        <p>
                          <label for="exampleFormControlSelect1">{{ $t("TITLE") }}</label>
                          <input type="text" v-model="v$.title.$model" :class="{
                            'is-invalid': v$.title.$error,
                          }" />
                        <div class="invalid-feedback">
                          <div v-for="error in v$.title.$errors" :key="error">
                            {{ $t("TITLE") + " " + $t(error.$validator) }}
                          </div>
                        </div>
                        </p>
                      </div>
                      <div class="col-md-6" style="padding:0">
                        <p class="category">
                          <label for="exampleFormControlSelect1">{{ $t("CATEGORY") }}</label>
                        <div class="select-wrapper">
                          <select v-model="v$.category_id.$model" id="exampleFormControlSelect1">
                            <option v-for="category in categories" :key="category" :value="category.id">
                              {{ $i18n.locale == "ar" ? category.nameAr : category.nameEn }}
                            </option>
                          </select>
                        </div>
                        <div class="invalid-feedback">
                          <div v-for="error in v$.category_id.$errors" :key="error">
                            {{ $t("CATEGORY") + " " + $t(error.$validator) }}
                          </div>
                        </div>
                        </p>
                      </div>
                      <div class="col-md-12">
                        <p>
                          <label for="exampleFormControlSelect1">{{ $t("CONTEXT") }}</label>
                          <textarea rows="6" type="text" v-model="v$.context.$model" :class="{
                            'is-invalid': v$.context.$error,
                          }">
                              </textarea>
                        <div class="invalid-feedback">
                          <div v-for="error in v$.context.$errors" :key="error">
                            {{ $t("CONTEXT") + " " + $t(error.$validator) }}
                          </div>
                        </div>
                        </p>
                      </div>
                      <div class="col-md-12">
                        <button class="submit btn btn-primary">{{ $t("Edit blog") }}</button>
                      </div>
                    </form>
                    <Comments mode="edit" :onRecentBlogSelected="onRecentBlogSelected" :blog="blog" />
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="sidebar">
          <RecentBlogs @blogSelected="onBlogSelected" />
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
import Comments from "./comments";
import { useRoute } from "vue-router";
export default {
  components: {
    RecentBlogs,
    Header,
    Comments,
  },
  setup(context, props) {
    const { t, locale } = useI18n({ useScope: "global" });
    const route = useRoute();
    let data = reactive({
      uploadedImage: null,
      previewImage: "",
      blog: null,
      categories: [],
      onRecentBlogSelected: false,
    });
    let form = reactive({
      id: null,
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
      setForm();
      getCategories();
    });
    //Methods
    function update() {
      if (v$.value.$invalid) {
        v$.value.$touch();
        return;
      }
      blogClient.update(getForm()).then((response) => {
        toast.success(t("UPDATED_SUCCESSFULLY"));
        data.uploadedImage = null;
        data.blog.image = response.data.image; //Update Image
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
      data.previewImage = data.blog.image;
    }
    function onBlogSelected() {
      data.onRecentBlogSelected = !data.onRecentBlogSelected;
    }
    //Commons
    function getCategories() {
      blogClient.getCategories().then((response) => {
        data.categories = response.data;
      });
    }
    function setForm() {
      blogClient.show(route.params.id).then((response) => {
        data.blog = response.data;
        form.id = data.blog.id;
        form.title = data.blog.title;
        form.context = data.blog.context;
        form.category_id = data.blog.category_id;
        data.previewImage = data.blog.image;
      });
    }
    function getForm() {
      let formData = new FormData();
      if (data.uploadedImage) {
        formData.append("image", data.uploadedImage);
      }
      formData.append("id", form.id);
      formData.append("context", form.context);
      formData.append("title", form.title);
      formData.append("category_id", form.category_id);
      return formData;
    }
    return {
      v$,
      ...toRefs(form),
      ...toRefs(data),
      update,
      uploadImage,
      deleteImage,
      onBlogSelected,
    };
  },
};
</script>

<style lang="scss">
@media (min-width:992px) {
  body[dir=ltr] {
    p.category {padding-left: 10px;}
  }
  body[dir=rtl] {
    p.category {padding-right: 10px;}
  }
}
.blog-edit {
  select,
  input {
    height: 50px;
    width: 100%;

  }

  select {
    color: #777777;
    background-color: #f1f4f5;
    border: 1px solid #f1f4f5;
    border-radius: 3px;
    padding: 0 15px
  }


  form:first-child {
    padding-bottom: 25px;
    border-bottom: 1px solid #dce4e6;
  }

  .col-md-12 {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  .text-danger {
    color: #b94a48 !important;
  }

  .blog-image {
    position: relative;
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

  .image-upload {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 30px;
    width: 38px;
    background: white;
    position: absolute;
    bottom: 0;
    text-align: center;

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

    text-align: center;

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
      // content: "▼";
      // font-size: 1.2rem;
      // top: 12px;
      // position: absolute;
      // color: #aeaeae;
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

  body[dir="ltr"] & {
    .select-wrapper::after {
      right: 10px;
    }

    .image-upload {
      right: 0;
    }
  }

  body[dir="rtl"] & {
    .select-wrapper::after {
      left: 10px;
    }

    .image-upload {
      left: 0;
    }
  }
}
</style>
