<template>
  <div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col d-flex">
            <h1 class="mr-3">Intervals</h1>

            <button
              type="button"
              class="btn btn-outline-primary"
              @click="createTimerInterval"
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
            :rows="timerIntervals"
            :pagination-options="{enabled: true}"
            >
              <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'tools'">
                    <button type="button" class="btn btn-info mr-3"
                      @click="editTimerInterval(props.row['id'])">
                      Edit
                    </button>
                    <a @click.prevent="deleteTimerInterval(props.row['id'])"
                      class="btn  btn-danger" href="#">
                      Delete
                    </a>
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

import TimerIntervalCreate from "~/views/timerIntervals/TimerIntervalCreate";
import TimerIntervalEdit from "~/views/timerIntervals/TimerIntervalEdit";

export default {
  data() {
    return {
      gridColumns: [{
          label: 'ID',
          field: 'id',
          type: 'number'
        }, {
          label: 'Timer',
          field: 'timer.name',
        }, {
          label: 'Title',
          field: 'title',
        }, {
          label: 'Duration',
          field: 'duration',
        }, {
          label: 'Date',
          field: 'created_at',
          type: 'date',
          dateInputFormat: 'yyyy-MM-dd',
          dateOutputFormat: 'dd MMMM yyyy',
        },
        {
          label: 'Tools',
          sortable: false,
          field: 'tools'
        }
      ]
    }
  },
  components: {
    TimerIntervalCreate,
    TimerIntervalEdit
  },
  mounted() {
    this.FULL_PAGE_LOADING(true);
    this.getAll()
      .then(() => {
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
    createTimerInterval() {
      this.$modal.show(TimerIntervalCreate, {}, { width: "80%", height: "auto", pivotY: 0.1, scrollable: true });
    },
    editTimerInterval(id) {
      this.$modal.show(TimerIntervalEdit, { id }, { width: "80%", height: "auto", pivotY: 0.1, scrollable: true });
    },
    deleteTimerInterval(id) {
      this.$alertify.confirmWithTitle(
        "Are you sure ?",
        "This will delete selected interval",
        () => {
          this.LOADING(true);
          this.destroy(id)
            .then(() => {
              this.LOADING(false);

              this.$alertify.success("Interval deleted");
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
