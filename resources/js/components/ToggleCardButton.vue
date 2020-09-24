<template>
  <button
    type="button"
    class="btn btn-tool"
    data-card-widget="collapse"
    @click="updateIcon"
  >
    <i
      class="fas"
      :class="{
        'fa-caret-down': !isExpanded,
        'fa-caret-up': isExpanded
      }"
    ></i>
  </button>
</template>

<script>
export default {
  props: {
    expanded: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      isExpanded: false
    };
  },
  mounted() {
    this.isExpanded = this.expanded;
  },
  methods: {
    updateIcon() {
      this.isExpanded = !this.isExpanded;
    }
  }
};
</script>

<style></style>
