<template>
  <v-app class="default">
    <navigation />
    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
import Navigation from "../components/pages/Navigation.vue";
export default {
  components: { Navigation },
};
</script>
