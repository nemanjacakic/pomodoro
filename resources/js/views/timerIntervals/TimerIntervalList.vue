<template>
  <div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col d-flex">
            <h1 class="mr-3">Timer intervals</h1>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="card">
        <div class="card-body">
          <table
            id="gridList"
            class="table table-bordered table-striped dataTable"
          >
            <thead>
              <tr>
                <th style="width: 1%">ID</th>
                <th>Title</th>
                <th>Duration</th>
                <th>Date</th>
                <th style="width: 20%">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="interval in timerIntervals" :key="interval.id">
                <td>{{ interval.id }}</td>
                <td>{{ interval.title }}</td>
                <td>{{ interval.duration }}</td>
                <td>{{ interval.updated_at }}</td>
                <td>
                  <a
                    @click.prevent="deleteInterval(interval.id)"
                    class="btn  btn-danger"
                    href="#"
                  >
                    Delete
                  </a>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Duration</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";

import { FULL_PAGE_LOADING, LOADING } from "~/store/mutation-types";

export default {
  mounted() {
    this.FULL_PAGE_LOADING(true);
    this.getAll()
      .then(() => {
        $("#gridList").DataTable({
          order: [0, "desc"]
        });
        this.FULL_PAGE_LOADING(false);
      })
      .catch(() => this.FULL_PAGE_LOADING(false));
  },
  computed: {
    ...mapState("timerIntervals", ["timerIntervals"])
  },
  methods: {
    ...mapMutations([LOADING, FULL_PAGE_LOADING]),
    ...mapActions("timerIntervals", ["getAll", "destroy"]),
    deleteInterval(id) {
      this.$alertify.confirmWithTitle(
        "Are you sure ?",
        "This will delete selected timer interval",
        () => {
          this.LOADING(true);
          this.destroy(id)
            .then(() => {
              this.LOADING(false);

              this.$alertify.success("Timer interval deleted");
            })
            .catch(error => {
              this.LOADING(false);

              this.$alertify.error(error.message)
            });
        },
        () => {}
      );
    }
  }
};
</script>
