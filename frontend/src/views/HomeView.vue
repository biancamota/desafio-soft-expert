<template>
  <div class="flex">
    <Sidebar></Sidebar>
    <div class="container flex p-8 mx-auto mt-12 bg-slate-600">
      <div class="flex flex-col w-full bg-blue-700">
        <div class="p-3">
          <input
          type="text"
          class="w-full px-2 py-1 text-sm text-gray-800 border border-gray-300 rounded bg-gray-50"
        />
          <table class="table-auto">
            <thead>
              <tr>
                <th class="text-start">Item</th>
                <th class="text-center">Quantity</th>
                <th class="text-end">$</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                <td>Malcolm Lockyer</td>
                <td>1961</td>
              </tr>
              <tr>
                <td>Total</td>
                <td></td>
                <td>1961</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// import { ref } from "vue";
import Sidebar from "@/components/Sidebar.vue";

async function getProducts() {
  //   try {
  //     const { data } = await api.get("/products");
  //     console.log(data);
  //   } catch (error) {
  //     console.log(error);
  //   }
  // }
  // async function getSales() {
  //   try {
  //     const { data } = await api.get("/products");
  //     console.log(data);
  //   } catch (error) {
  //     console.log(error);
  //   }
}
</script>

<style lang="scss" scoped></style>