<script lang="ts">
import { defineComponent, ref } from "vue";

import listAccountsComponent from "../components/listAccounts.vue";

export default defineComponent({
  name: "Home",
  components: { listAccountsComponent },
  setup() {
    return {};
  },
});
</script>

<template>
  <div class="col-12 pt-5 mt-5">
    <div class="d-flex justify-content">
      <div class="col-12">
        <listAccountsComponent />
      </div>
    </div>
  </div>
</template>

<style scoped>
.add-new-container {
  border: 1px solid #ffff;
  border-radius: 5px;
  color: #b2acf3;
  font-weight: 500;
  height: 370px;
  padding-top: 100px;
  cursor: pointer;
}

.add-new-button {
  background-color: #ffff;
  width: 80px;
  height: 80px;
  border: 4px solid #e1e7fa;
}

.user-account-card {
  background-color: #ffff;
  border-radius: 5px;
  color: #b2acf3;
}
.font-bold {
  font-weight: 500;
}

.view-account-button {
  background-color: #b2acf3;
  color: #ffff;
  border-radius: 15px;
}
.MoreFilled {
  border: none;
  color: #b2acf3;
  font-size: 20px;
}
</style>
