<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import { ElButton } from "element-plus";

import {
  MoreFilled,
  ArrowLeftBold,
  ArrowRightBold,
} from "@element-plus/icons-vue";

import ListAccounts from "@/api/accounts";
import { useRouter } from "vue-router";

export default defineComponent({
  name: "list-accounts-component",
  components: { ElButton },

  setup() {
    const accounts = ref<Array<any> | null>(null);
    const scrollContent = ref<HTMLElement | null>(null);

    const getAccounts = async () => {
      const response = await ListAccounts.listAccounts();
      accounts.value = response.data;
    };

    const scrollToStart = () => {
      (scrollContent.value as HTMLElement).scrollTo({
        left: 0,
        behavior: "smooth",
      });
    };

    const scrollToEnd = () => {
      (scrollContent.value as HTMLElement).scrollTo({
        left: scrollContent.value?.scrollWidth,
        behavior: "smooth",
      });
    };

    onMounted(async () => {
      await getAccounts();
    });

    const router = useRouter();

    const selectedAccount = (id: number) => {
      localStorage.setItem("account_id", id.toString());
      router.push({ path: `/transactions/${id}` });
    };
    return {
      MoreFilled,
      ArrowLeftBold,
      ArrowRightBold,
      accounts,
      getAccounts,
      scrollContent,
      scrollToStart,
      scrollToEnd,
      selectedAccount,
    };
  },
});
</script>

<template>
  <div v-if="accounts">
    <div class="container-list col-12 shadow-sm">
      <div class="scroll-container d-flex justify-content" ref="scrollContent">
        <div
          class="col-4 user-account-card shadow-sm"
          v-for="account in accounts"
          :key="account.id"
        >
          <div class="col-12 text-end pt-1">
            <el-button class="mx-0 MoreFilled" :icon="MoreFilled"></el-button>
          </div>
          <div class="col-12 d-flex justify-content-center">
            <div class="col-6 rounded-circle add-new-button mb-2 text-center">
              <img src="../assets/userAvator.png" width="72" height="72" />
            </div>
          </div>
          <div class="col-12 text-center font-bold" style="color: black">
            {{ account.name }}
          </div>
          <div class="col-12 py-4">
            <div class="row">
              <div class="col-12 text-center">
                Balancae<br />
                <span class="font-bold"
                  >{{ account.account.balance }}
                  {{ account.account.currency }}</span
                >
              </div>
              <div class="col-12 text-center pt-4">
                Account Number<br />
                <span class="font-bold">{{ account.id }}</span>
              </div>
            </div>
          </div>
          <div class="col-12 text-center pb-4">
            <el-button
              class="view-account-button"
              @click="selectedAccount(account.id)"
              >View Account</el-button
            >
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 py-2 text-center">
      <el-button
        @click="scrollToStart"
        class="mx-0 rounded-circle controls shadow-sm"
        :icon="ArrowLeftBold"
      ></el-button>

      <el-button
        @click="scrollToEnd"
        class="mx-0 rounded-circle controls shadow-sm"
        :icon="ArrowRightBold"
      ></el-button>
    </div>
  </div>
  <div v-else class="loading col-12 text-center">
    <img src="../assets/loading-gif2.gif" height="300" />
  </div>
</template>

<style scoped>
.add-new-container {
  border: 2px solid #ffff;
  border-radius: 5px;
  color: #157eab;
  font-weight: 500;
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
  color: #157eab;
}
.font-bold {
  font-weight: 500;
}

.view-account-button {
  background-color: #157eab;
  color: #ffff;
  border-radius: 15px;
}
.MoreFilled {
  border: none;
  color: #157eab;
  font-size: 13px;
}

/* .container-list {
  display: flex;
  flex-direction: column;
  align-items: center;
} */

.scroll-container {
  width: 100%;
}

.controls {
  width: 40px;
  height: 40px;
}

.scroll-container {
  overflow-x: scroll;
  overflow-y: hidden;
  white-space: nowrap;
  /* Hide the scrollbar */
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE and Edge */
}
/* Hide the scrollbar for webkit browsers */
.scroll-container::-webkit-scrollbar {
  display: none;
}
</style>
