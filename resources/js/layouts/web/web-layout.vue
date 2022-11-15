<template>
  <Header />
  <router-view />
  <Footer />
</template>
<script>
import Header from "./header/header";
import Footer from "./footer";
export default {
  components: {
    Header,
    Footer,
  },
};
</script>
<style scoped></style>
