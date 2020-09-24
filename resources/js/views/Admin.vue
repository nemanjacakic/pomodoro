<template>
  <div>
    <div class="wrapper">
      <Header />

      <Sidebar />

      <Main />

      <Footer />
    </div>

    <modals-container />
    <!-- /.modal -->
  </div>
</template>

<script>
import Header from "~/views/Header";
import Sidebar from "~/views/Sidebar";
import Main from "~/views/Main";
import Footer from "~/views/Footer";

export default {
  components: {
    Header,
    Sidebar,
    Main,
    Footer
  }
};
</script>
