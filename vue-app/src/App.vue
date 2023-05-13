<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({});
</script>

<template>
  <div class="col-12 d-flex justify-content-center">
    <div class="col-8 pt-2">
      <router-view />
    </div>
  </div>
</template>

<style>
body {
  background-color: #f1f3fa !important;
}
</style>
