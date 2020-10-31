<template>
  <div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col d-flex">
            <h1 class="mr-3">Timers</h1>

            <button
              type="button"
              class="btn btn-outline-primary"
              @click="createTimer"
            >
              Add new
            </button>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="card">
        <div class="card-body">
          <vue-good-table
            :columns="gridColumns"
            :rows="timers"
            :pagination-options="{enabled: true}"
            >
              <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'tools'">
                    <button type="button" class="btn btn-info mr-3"
                      @click="editTimer(props.row['id'])">
                      Edit
                    </button>
                    <a @click.prevent="deleteTimer(props.row['id'])"
                      class="btn  btn-danger" href="#">
                      Delete
                    </a>
                </span>
                <span v-else-if="props.column.field == 'duration'">
                    {{ formatTime(props.formattedRow[props.column.field]) }}
                </span>
              </template>
          </vue-good-table>
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

import TimerCreate from "~/views/timers/TimerCreate";
import TimerEdit from "~/views/timers/TimerEdit";

import time from "~/mixins/time";

export default {
    data() {
      return {
        gridColumns: [{
            label: 'ID',
            field: 'id',
            type: 'number',
          }, {
            label: 'Name',
            field: 'name',
          }, {
            label: 'Duration',
            field: 'duration',
          }, {
            label: 'Tools',
            sortable: false,
            field: 'tools'
          }
        ]
      }
  },
  components: {
    TimerCreate,
    TimerEdit
  },
  mixins: [
      time
  ],
  mounted() {
    this.FULL_PAGE_LOADING(true);
    this.getAll()
      .then(() => {
        this.FULL_PAGE_LOADING(false);
      })
      .catch(() => this.FULL_PAGE_LOADING(false));
  },
  computed: {
    ...mapState("timers", ["timers"])
  },
  methods: {
    ...mapMutations([LOADING, FULL_PAGE_LOADING]),
    ...mapActions("timers", ["getAll", "destroy"]),
    createTimer() {
      this.$modal.show(TimerCreate, {}, { width: "80%", height: "auto", pivotY: 0.1, scrollable: true });
    },
    editTimer(id) {
      this.$modal.show(TimerEdit, { id }, { width: "80%", height: "auto", pivotY: 0.1, scrollable: true });
    },
    deleteTimer(id) {
      this.$alertify.confirmWithTitle(
        "Are you sure ?",
        "This will delete selected timer",
        () => {
          this.LOADING(true);
          this.destroy(id)
            .then(() => {
              this.LOADING(false);

              this.$alertify.success("Timer deleted");
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
