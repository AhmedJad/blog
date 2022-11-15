<template>
  <div class="sidebar-widget">
    <h5 class="widget-title">
      <span>{{ $t("CATEGORIES") }}</span> <a href="" @click.prevent="onCategorySelected">({{$t("ALL")}})</a>
    </h5>
    <div class="row categories">
      <div class="col-md-6">
        <ul>
          <li v-for="category in firstCategories" :key="category.id">
            <a
              @click.prevent="onCategorySelected(category)"
              href=""
              >{{ $i18n.locale == "ar" ? category.nameAr : category.nameEn }}</a
            >
          </li>
        </ul>
      </div>
      <div class="col-md-6">
        <ul>
          <li v-for="category in secondCategories" :key="category.id">
            <a @click.prevent="onCategorySelected(category)" href="">{{
              $i18n.locale == "ar" ? category.nameAr : category.nameEn
            }}</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
import { onMounted, reactive, toRefs } from "vue-demi";
import blogClient from "../../../../shared/http-clients/blog-client";
export default {
  setup(props, context) {
    const data = reactive({
      firstCategories: [],
      secondCategories: [],
      categoryId: null,
    });
    onMounted(() => {
      getCategories();
    });
    //Methods
    function onCategorySelected(category) {
      data.categoryId = category?category.id:null;
      context.emit("categorySelected", data.categoryId);
    }
    //Commons
    function getCategories() {
      blogClient.getCategories().then((response) => {
        data.firstCategories = response.data.slice(0, 4);
        data.secondCategories = response.data.slice(4, 8);
      });
    }
    return { ...toRefs(data), onCategorySelected };
  },
};
</script>

<style scoped lang="scss">
</style>
