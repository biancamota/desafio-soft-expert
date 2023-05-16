
<template>
  <div>
    <v-row>
      <v-col align-self="end">
        <v-btn prepend-icon="mdi-plus" @click="addProduct"> New Product </v-btn>
      </v-col>
    </v-row>

    <v-table density="compact" class="mt-4 border rounded">
      <thead>
        <tr>
          <th class="text-left">ID</th>
          <th class="text-left">Name</th>
          <th class="text-left">Description</th>
          <th class="text-left">Category</th>
          <th class="text-left">Purchase price</th>
          <th class="text-left">Sale price</th>
          <th class="text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>{{ product.description }}</td>
          <td>{{ product.category_id }}</td>
          <td>{{ product.purchase_price }}</td>
          <td>{{ product.sale_price }}</td>
          <td>
            <v-btn
              size="small"
              icon="mdi-pencil"
              title="Edit"
              @click="editProduct(product)"
            ></v-btn>
            <v-btn
              size="small"
              icon="mdi-delete"
              title="Delete"
              @click="removeProduct(product)"
            ></v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
    <FormModal
      v-if="showModal"
      :product="selectedProduct"
      @closeModal="close"
      :isNewProduct="isNewProduct"
      @emitSaveProduct="saveProduct"
    />
    <ConfirmDelete
      v-if="showConfirm"
      :product="selectedProduct"
      @closeModal="close"
      @emitDeleteProduct="deleteProduct"
    />
  </div>
</template>

<script setup>
import FormModal from "@/components/modal/FormModal.vue";
import ConfirmDelete from "@/components/modal/ConfirmDelete.vue";
import api from "@/services/api.js";
import { onMounted, ref } from "vue";

const showModal = ref(false);
const showConfirm = ref(false);
const products = ref([]);
const isNewProduct = ref(false);
const selectedProduct = ref({
  name: "",
  category_id: "",
  description: "",
  purchase_price: "",
  sale_price: "",
  tax: "",
});

const editProduct = (product) => {
  selectedProduct.value = product;
  isNewProduct.value = false;
  showModal.value = true;
};

const removeProduct = (product) => {
  selectedProduct.value = product;
  isNewProduct.value = false;
  showConfirm.value = true;
};

const addProduct = () => {
  isNewProduct.value = true;
  showModal.value = true;
};

const saveProduct = async (product) => {
  try {
    let response;
    if (isNewProduct.value) {
      response = await api.post("/products", product);
    } else {
      response = await api.put(`/products/${product.id}`, product);
    }
    console.log(response);
    await getProducts();
    close();
  } catch (error) {
    console.log(error);
  }
};

const deleteProduct = async (product) => {
  try {
    let response;
    response = await api.delete(`/products/${product.id}`);
    console.log(response);
    await getProducts();
    close();
  } catch (error) {
    console.log(error);
  }
};

const close = () => {
  showModal.value = false;
  showConfirm.value = false;
};

async function getProducts() {
  try {
    const { data } = await api.get("/products");
    products.value = data.data.products;
  } catch (error) {
    console.log(error);
  }
}

onMounted(() => {
  getProducts();
});
</script>

<style lang="scss" scoped>
</style>

