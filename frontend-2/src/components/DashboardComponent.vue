<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" app class="bg-indigo">
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6"> BMDev </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
      <v-list>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :value="item.value"
          link
          :prepend-icon="item.icon"
          :to="item.route"
        >
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn block class="text-black"> Logout </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <v-app-bar v-model="navigation">
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

    <v-main class="ma-5">
      <router-view
        :drawer="drawer"
        :navigation="navigation"
        @update-drawer="drawer = $event"
        @update-navigation="navigation = $event"
      />
    </v-main>
  </v-app>
</template>

<script setup>
import { ref, watch } from "vue";

const drawer = ref(false);
const navigation = ref(true);
const group = ref(null);
const items = ref([
  {
    title: "Sales",
    value: "sales",
    route: "/sales",
    icon: "mdi-view-dashboard",
  },
  {
    title: "Products",
    value: "products",
    route: "/products",
    icon: "mdi-view-dashboard",
  },
]);

watch(group, () => {
  drawer.value = false;
});
</script>
