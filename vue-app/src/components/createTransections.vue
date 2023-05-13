<template>
  <div class="col-12 text-center pt-3">
    <div class="d-flex justify-content-center">
      <div class="col-6 text-center pb-4" v-if="successAlert">
        <el-alert
          title="Transaction successful"
          type="success"
          show-icon
          v-show="successAlert"
        />
      </div>
      <div class="col-6 text-center pb-4" v-if="errorAlert">
        <el-alert
          title="Transaction unsuccessful, Please resolve errors"
          type="error"
          show-icon
          :closable="false"
          v-show="errorAlert"
        />
      </div>
    </div>
    <form>
      <div v-if="displayform">
        <div class="col-12 text-center py-4" v-if="error_source_account_number">
          <span class="text-danger font-weight-light errorText py-4">{{
            error_source_account_number[0]
          }}</span>
        </div>
        <div class="d-flex justify-content-center">
          <div class="col-4">
            <div class="label">Amount</div>
            <el-input v-model="depositAmount" class="" />
            <span
              class="text-danger font-weight-light errorText"
              v-if="error_deposit_amount"
              >{{ error_deposit_amount[0] }}</span
            >
          </div>
          <div class="col-4">
            <div class="label">Account Number</div>
            <el-input v-model="account_number" class="" />
            <span
              class="text-danger font-weight-light errorText"
              v-if="error_account_number"
              >{{ error_account_number[0] }}</span
            >
          </div>
        </div>

        <div class="col-12 d-flex justify-content-center">
          <div class="col-4 pt-2">
            <el-button class="deposit-button" plain @click="save"
              >Deposit Money</el-button
            >
          </div>
        </div>
      </div>
      <div v-else class="col-12">Sending data....</div>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { ElInput, ElButton, ElAlert } from "element-plus";
import type { Ref } from "vue";

import Transactions from "@/api/accounts";

export default defineComponent({
  components: { ElInput, ElButton, ElAlert },
  emits: ["refresh-transaction"],

  setup(props, { emit }) {
    const depositAmount: Ref<string> = ref("");
    const account_number: Ref<string> = ref("");

    const error_account_number: Ref<string> = ref("");
    const error_deposit_amount: Ref<string> = ref("");
    const error_source_account_number: Ref<string> = ref("");
    const source_account_id = localStorage.getItem("account_id");
    const successAlert: Ref<boolean> = ref(false);
    const errorAlert: Ref<boolean> = ref(false);
    const displayform: Ref<boolean> = ref(true);

    const save = async (): Promise<void> => {
      displayform.value = false;

      try {
        await Transactions.createTransaction({
          account_number: account_number.value,
          amount: depositAmount.value,
          source_account_number: source_account_id,
        });
        depositAmount.value = "";
        account_number.value = "";
        error_account_number.value = "";
        error_deposit_amount.value = "";
        error_source_account_number.value = "";
        successAlert.value = true;
        errorAlert.value = false;
        emit("refresh-transaction");
      } catch (error: any) {
        const { response } = error as {
          response: {
            data: {
              errors: {
                account_number: string;
                amount: string;
                source_account_number: string;
              };
            };
          };
        };
        error_account_number.value = response.data.errors.account_number;
        error_deposit_amount.value = response.data.errors.amount;
        error_source_account_number.value =
          response.data.errors.source_account_number;
        successAlert.value = false;
        errorAlert.value = true;
      }
      displayform.value = true;
    };

    return {
      depositAmount,
      account_number,
      save,
      error_deposit_amount,
      error_account_number,
      error_source_account_number,
      successAlert,
      errorAlert,
      displayform,
    };
  },
});
</script>

<style scoped>
.balance-label {
  font-weight: 500;
  color: #595d8a;
}
.balance-amount {
  font-size: 25px;
}
.label {
  font-size: 15px;
  color: #595d8a;
}

.deposit-button {
  background-color: #157eab;
  color: #ffff;
  border-radius: 15px;
}

.errorText {
  font-size: 14px;
}
</style>
