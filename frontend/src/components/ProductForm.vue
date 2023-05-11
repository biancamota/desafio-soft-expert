<template>
  <div>
    <h3>{{ formTitle }}</h3>
    <form @submit.prevent="saveProduct">
      <label>
        name:
        <input type="text" v-model="product.name" />
      </label>
      <label>
        description:
        <input type="text" v-model="product.description" />
      </label>
      <label>
        category_id:
        <select id="category" v-model="product.category_id">
          <option
            v-for="category in list.categories"
            :value="category.id"
            :key="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </label>
      <label>
        purchase_price:
        <input type="text" v-model="product.purchase_price" />
      </label>
      <label>
        sale_price:
        <input type="number" v-model.number="product.sale_price" />
      </label>
      <label>
        tax:
        <input type="number" v-model.number="product.tax" />
      </label>
      <button v-if="!isUpdate" type="submit">Save</button>
      <button v-if="isUpdate" type="submit">Update</button>
      <button type="button" @click="cancel">Cancelar</button>
    </form>
  </div>
</template>
  
<script setup>
import api from "@/services/api.js";
import { ref, watch, defineEmits, reactive, onMounted } from "vue";

const props = defineEmits(["save", "cancel"]);
let list = reactive({ categories: [] });
const isUpdate = ref(false);

const product = ref({
  name: "",
  description: "",
  category_id: 0,
  purchase_price: 0,
  sale_price: 0,
  tax_value: 0,
});

watch(
  () => props.product,
  (value) => {
    product.value = value;
    isUpdate.value = Boolean(value.id);
  }
);

const saveProduct = async () => {
  try {
    let response;
    if (isUpdate.value) {
      response = await api.put(`/products/${product.value.id}`, product.value);
    } else {
      response = await api.post("/products", product.value);
    }
    const savedProduct = response.data;
    props.save(savedProduct);
  } catch (error) {
    console.error(error);
  }
};

async function getCategories() {
  try {
    const { data } = await api.get("/categories");
    list.categories = data.data.categories;
  } catch (error) {
    console.log(error);
  }
}

function cancel() {
    props('cancel');
}

onMounted(() => {
  getCategories();
});
</script>
  
<style lang="scss" scoped>
</style>