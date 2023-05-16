<template>
  <v-row justify="center">
    <v-dialog v-model="modalVisible" persistent width="1024">
      <v-card>
        <v-card-title>
          <span class="text-h5">{{
            isNewProduct ? "New Product" : "Edit Product"
          }}</span>
        </v-card-title>
        <v-form @submit.prevent="emitSaveProduct">
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    label="Name*"
                    required
                    v-model="product.name"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-select
                    :items="categories"
                    label="Category*"
                    required
                    v-model="product.category_id"
                  ></v-select>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="Description"
                    v-model="product.description"
                  ></v-text-field>
                </v-col>
                <v-col cols="4" md="4" sm="12">
                  <v-text-field
                    label="Purchase Price*"
                    required
                    v-model="product.purchase_price"
                  ></v-text-field>
                </v-col>
                <v-col cols="4" md="4" sm="12">
                  <v-text-field
                    label="Sales Price*"
                    required
                    v-model="product.sale_price"
                  ></v-text-field>
                </v-col>
                <v-col cols="4" md="4" sm="12">
                  <v-text-field
                    label="Tax*"
                    required
                    v-model="product.tax"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
            <small class="text-red">*indicates required field</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn class="bg-grey" variant="text" @click="closeModal">
              Close
            </v-btn>
            <v-btn type="submit" class="bg-green" variant="text">
              {{ isNewProduct ? "Save" : "Update" }}
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
  
<script setup>
import { ref, watch, defineProps, defineEmits } from "vue";

const props = defineProps(["product", "isNewProduct"]);
const categories = ref(["Electronics", "Fashion", "Sports"]);
const emit = defineEmits(["closeModal", "emitSaveProduct"]);
const modalVisible = true;

const closeModal = () => {
  emit("closeModal");
};

const product = ref({});

const emitSaveProduct = () => {
  console.log("save on child");
  console.log(product.value);
  emit("emitSaveProduct", product.value);
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