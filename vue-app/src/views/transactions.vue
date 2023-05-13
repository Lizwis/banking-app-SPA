<template>
  <div class="col-12 mt-2">
    <div class="col-2 text-start px-5 mx-4 pb-4">
      <el-button @click="back" :icon="ArrowLeftBold" class="back"
        >Back</el-button
      >
    </div>
    <div class="col-12 text-center">
      <div class="col-12 d-flex justify-content-center">
        <div class="col-10 user-account-card shadow-sm">
          <div class="d-flex">
            <div class="col-4 text-center font-bold pt-4" style="color: black">
              <span>Name</span> <br />
              <div v-if="accountDetails">{{ accountDetails?.user.name }}</div>
              <div v-else>Loading ..</div>
            </div>
            <div class="col-4 d-flex justify-content-center text-center pt-2">
              <div
                class="col-12 rounded-circle add-new-button mb-2 text-center"
              >
                <img src="../assets/userAvator.png" width="72" height="72" />
              </div>
            </div>
            <div class="col-4 text-center pt-4 font-bold" style="color: black">
              <span>Balance</span> <br />
              <div v-if="accountDetails">
                {{ accountDetails?.balance }} {{ accountDetails?.currency }}
              </div>
              <div v-else>Loading ..</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <createTransections @refresh-transaction="refreshEmit" />
    <div class="col-12 d-flex justify-content-center">
      <div class="col-10 py-2 my-4 px-4" style="background-color: #ffff">
        <div class="text-start balance-label fs-5">Transaction History</div>
        <div class="col-12" v-if="accountTransactionsList">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Type</th>
                <th scope="col">Acc. No</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="a in accountTransactionsList" :key="a.id">
                <td>{{ a.date }}</td>
                <td>
                  <span v-if="a.type == 'Credit'">+</span>
                  <span v-else>-</span>
                  {{ a.amount }}
                  {{ a.currency }}
                </td>
                <td>{{ a.type }}</td>
                <td v-if="a.type == 'Credit'">
                  {{ a.source_account.account_id }}
                </td>
                <td v-else>{{ a.destination_account.account_id }}</td>
              </tr>
            </tbody>
          </table>
          <div class="col-12 d-flex justify-content-center">
            <div
              v-for="(p, index) in pageCount"
              :key="index"
              @click="pagination(p)"
              v-bind:class="{ active: currentPage === p }"
              class="px-2 pagination-btn mx-2 rounded-circle py-1 text-center"
            >
              {{ p }}
            </div>
          </div>
        </div>
        <div v-else class="loading col-12 text-center">
          <img src="../assets/loading-gif2.gif" height="300" />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";

import { ElInput, ElButton, ElAlert } from "element-plus";
import Transactions from "@/api/accounts";

import { ArrowLeftBold } from "@element-plus/icons-vue";
import createTransections from "../components/createTransections.vue";
import { useRouter } from "vue-router";

export default defineComponent({
  name: "transections-component",
  components: {
    ElInput,
    ElButton,
    ElAlert,
    createTransections,
  },

  setup() {
    const account_id = localStorage.getItem("account_id");

    const accountTransactionsList = ref<Array<any> | null>(null);
    let pageCount: number[] = [];
    const currentPage = ref(1);

    const getTransactions = async () => {
      accountTransactionsList.value = null;

      pageCount.length = 0;
      const response = await Transactions.listTransection(account_id);
      accountTransactionsList.value = response.data.data;
      const lastPage = response.data.meta.last_page;

      for (let i = 0; i < lastPage; i++) {
        pageCount.push(i + 1);
      }
    };

    const router = useRouter();

    const back = async () => {
      router.push({ path: "/" });
    };

    const pagination = async (p: any) => {
      accountTransactionsList.value = null;
      const response = await Transactions.listTransectionPaginate(
        account_id,
        p
      );
      accountTransactionsList.value = response.data.data;
      currentPage.value = p;
    };

    const accountDetails = ref<Array<any> | null>(null);

    const getAccount = async () => {
      const response = await Transactions.singleAccount(account_id);
      accountDetails.value = response.data[0];
    };
    onMounted(async () => {
      getAccount();
      getTransactions();
    });

    const refreshEmit = async () => {
      await getAccount();
      await getTransactions();
    };

    return {
      getTransactions,
      accountTransactionsList,
      pageCount,
      pagination,
      accountDetails,
      getAccount,
      refreshEmit,
      currentPage,
      back,
      ArrowLeftBold,
    };
  },
});
</script>

<style scoped>
.pagination-btn {
  cursor: pointer;
  background-color: #b2acf3;
  height: 32px;
  width: 32px;
  color: #fff;
}
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
.back {
  color: #157eab;
  font-weight: bold;
  cursor: pointer;
}
.MoreFilled {
  border: none;
  color: #157eab;
  font-size: 13px;
}
.active {
  background-color: #157eab;
}
</style>
