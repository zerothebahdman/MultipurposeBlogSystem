<template>
  <nav>
    <v-navigation-drawer
      v-model="primaryDrawer.model"
      :clipped="primaryDrawer.clipped"
      app
      dark
      src="../img/4884.jpg"
      overflow
    >
      <v-list-item class="px-2 mt-4">
        <span>
          <v-list-item-avatar size="70">
            <v-img
              src="https://img.icons8.com/plasticine/200/000000/user-male.png"
              style="border: thin solid #fff"
            ></v-img>
          </v-list-item-avatar>
        </span>
        <span>
          <v-list-item-content>
            <v-list-item-title class="title">Admin</v-list-item-title>
            <v-list-item-subtitle>admin@me.com</v-list-item-subtitle>
          </v-list-item-content>
        </span>
      </v-list-item>

      <!-- <v-list-item link>

      </v-list-item>-->

      <v-divider></v-divider>
      <v-list dense nav>
        <v-list-item v-for="item in items" :key="item.title" router :to="item.route">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar :clipped-left="primaryDrawer.clipped" app flat class="nav">
      <v-toolbar flat>
        <v-app-bar-nav-icon
          v-if="primaryDrawer.type !== 'permanent'"
          @click.stop="primaryDrawer.model = !primaryDrawer.model"
        ></v-app-bar-nav-icon>
        <v-toolbar-title>Munch Express</v-toolbar-title>
        <v-spacer></v-spacer>
        <!-- <v-col cols="3" sm="2">
                    <v-text-field
                        class="mt-5"
                        label="Search"
                        append-icon="mdi-magnify"
                    ></v-text-field>
        </v-col>-->

        <v-btn icon>
          <v-icon>mdi-bell</v-icon>
        </v-btn>

        <span>
          <v-btn icon>
            <v-icon>mdi-account</v-icon>
          </v-btn>
        </span>
        <span>Admin</span>
      </v-toolbar>
    </v-app-bar>
  </nav>
</template>

<script>
export default {
  data: () => ({
    drawers: ["Default (no property)"],
    items: [
      { title: "Dashboard", icon: "mdi-view-dashboard", route: "/" },
      { title: "Tags", icon: "mdi-tag-plus", route: "/tags" },
      { title: "About", icon: "mdi-help-box" },
    ],
    primaryDrawer: {
      model: null,
      type: "default (no property)",
      clipped: false,
      floating: false,
      mini: false,
    },
    methods: {},
    footer: {
      inset: true,
    },
  }),
};
</script>

<style>
.nav {
  background: #fff !important;
}
</style>
