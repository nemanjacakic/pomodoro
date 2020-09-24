<style lang="scss" scoped>
.title {
  margin-bottom: 1rem;
  color: #bd2130;
}

.message {
  margin-bottom: 0.5rem;
}
</style>
<template>
  <div class="callout callout-danger" v-if="!isObjectEmpty(errors)">
    <h5 class="title">Error</h5>
    <template class="message" v-for="error in errors">
      <p class="message" v-for="(message, index) in error" :key="index">
        {{ message }}
      </p>
    </template>
  </div>
</template>

<script>
export default {
  props: ["errors"],
  methods: {
    isObjectEmpty(object) {
      return Object.keys(object).length === 0;
    }
  }
};
</script>
