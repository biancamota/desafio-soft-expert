<template>
  <div class="flex">
    <Sidebar></Sidebar>
    <div class="container p-8 mx-auto mt-12 bg-gray-100">
      <h2 class="w-full">Lista de produtos</h2>
      <button @click="add">Adicionar</button>
      <Form v-if="showForm" v-on="cancel"></Form>
      <input type="text" v-model="searchTerm" placeholder="Search by name" />
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Purchase price</th>
            <th>Sale price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, index) in filteredProducts" :key="index">
            <td>{{ product.id }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.category }}</td>
            <td>{{ product.purchase_price }}</td>
            <td>{{ product.sale_price }}</td>
            <td>
              <button @click="edit(product)">Edit</button>
              <button @click="remove(product.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      
    </div>
  </div>
</template>

<script setup>
import Sidebar from "@/components/Sidebar.vue";
import Form from "@/components/ProductForm.vue";
import api from "@/services/api.js";
import { onMounted, reactive, ref, computed } from "vue";

const searchTerm = ref('');
let list = reactive({ products: [] });
const showForm = ref(false);

async function getProducts() {
  try {
    const { data } = await api.get("/products");
    list.products = data.data.products;
  } catch (error) {
    console.log(error);
  }
}

async function remove(id) {
  try {
    const { data } = await api.delete("/products/"+id);
    if (data.data.product) {
      getProducts();
    }
  } catch (error) {
    console.log(error);
  }
}

function add() {
  showForm.value = true;
}

onMounted(() => {
  getProducts();
});

const filteredProducts = computed(() => {
  return list.products.filter((product) => {
    return product.name.toLowerCase().includes(searchTerm.value.toLowerCase());
  });
});

</script>

<style lang="scss" scoped>
</style>