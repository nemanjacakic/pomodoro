<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content" v-show="!fullPageLoading">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <router-view></router-view>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <Loader v-show="fullPageLoading" />
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
import { mapState } from "vuex";
import Loader from "~/components/Loader";
export default {
  components: {
    Loader
  },
  computed: {
    ...mapState(["fullPageLoading"])
  }
};
</script>
