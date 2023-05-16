<template>
  <v-row justify="center">
    <v-dialog v-model="modalVisible" persistent width="1024">
      <v-card>
        <v-card-title>
          <span class="text-h5">Delete Product</span>
        </v-card-title>
        <v-card-text class="mt-2">
          Confirm delete product
          <span class="text-red">{{ product.name }}</span>
          ?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="bg-grey" variant="text" @click="closeModal">
            Cancel
          </v-btn>
          <v-btn
            type="submit"
            class="bg-green"
            variant="text"
            @click="emitDeleteProduct"
          >
            Confirm
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
  
<script setup>
import { ref, watch, defineProps, defineEmits } from "vue";

const props = defineProps(["product", "isNewProduct"]);
const emit = defineEmits(["closeModal", "emitDeleteProduct"]);
const modalVisible = true;

const closeModal = () => {
  emit("closeModal");
};

const product = ref({});

const emitDeleteProduct = () => {
  console.log("delete on child");
  console.log(product.value);
  emit("emitDeleteProduct", product.value);
};

watch(
  () => props.product,
  (newValue) => {
    if (props.isNewProduct) {
      product.value = {
        name: "",
        category_id: "",
        description: "",
        purchase_price: "",
        sale_price: "",
        tax: "",
      };
    } else {
      product.value = { ...newValue };
    }
  },
  { immediate: true }
);
</script>
  
  <style lang="scss" scoped>
</style>