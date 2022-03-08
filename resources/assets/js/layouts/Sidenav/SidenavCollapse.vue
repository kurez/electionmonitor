<template>
  <router-link class="nav-link" :to="to" v-bind="$attrs">
  
    <span
      class="nav-link-text"
      :class="this.$store.state.isRTL ? ' me-1' : 'ms-1'"
      >{{ navText }}</span
    >
  </router-link>
</template>
<script>
export default {
  name: "sidenav-collapse",
  props: {
    to: {
      type: [Object, String],
      required: true,
    },
    navText: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      isExpanded: false,
    };
  },
};
</script>
