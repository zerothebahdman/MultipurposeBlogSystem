<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0">
            Users
            <v-dialog v-model="dialog" persistent max-width="400px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  small
                  @click="addUserDialog"
                  outlined
                  class="ml-3"
                  color="indigo"
                  dark
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon>mdi-account-multiple-plus</v-icon>Add Users
                </v-btn>
              </template>
              <!-- Add User Modal -->
              <v-card>
                <v-card-title>
                  <span v-show="editmode" class="headline">Edit Users</span>
                  <span v-show="!editmode" class="headline">Add Users</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row justify="center">
                      <validation-observer ref="observer">
                        <v-form>
                          <v-row justify="center">
                            <v-col cols="12" sm="12" md="12" v-show="!editmode">
                              <validation-provider
                                rules="required"
                                v-slot="{errors}"
                                name="Full Name"
                              >
                                <v-text-field
                                  v-model="data.name"
                                  :rules="rules"
                                  :error-messages="errors"
                                  hide-details="auto"
                                  label="Full Name*"
                                  color="primary darken-4"
                                  required
                                  outlined
                                  hint="This is a required field"
                                ></v-text-field>
                              </validation-provider>
                            </v-col>

                            <v-col cols="12" sm="12" md="12" v-show="!editmode">
                              <validation-provider
                                rules="required|email"
                                v-slot="{errors}"
                                name="Email"
                              >
                                <v-text-field
                                  v-model="data.email"
                                  :rules="rules"
                                  :error-messages="errors"
                                  hide-details="auto"
                                  label="Email *"
                                  color="primary darken-4"
                                  required
                                  outlined
                                  hint="This is a required field"
                                ></v-text-field>
                              </validation-provider>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" v-show="!editmode">
                              <validation-provider
                                rules="required"
                                v-slot="{errors}"
                                name="Password"
                              >
                                <v-text-field
                                  v-model="data.password"
                                  :rules="rules"
                                  :type="show ? 'text' : 'password'"
                                  :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                                  @click:append="show = !show"
                                  :error-messages="errors"
                                  hide-details="auto"
                                  label="Password *"
                                  color="primary darken-4"
                                  required
                                  outlined
                                  hint="This is a required field"
                                ></v-text-field>
                              </validation-provider>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" v-show="!editmode">
                              <validation-provider
                                rules="required"
                                v-slot="{errors}"
                                name="User Type"
                              >
                                <v-select
                                  v-model="data.userType"
                                  outlined
                                  :error-messages="errors"
                                  :items="['Admin','Editor']"
                                  label="Select User Type"
                                  data-vv-name="select"
                                  hint="This is a required field"
                                  color="primary darken-4"
                                  required
                                ></v-select>
                              </validation-provider>
                            </v-col>

                            <v-col cols="12" sm="12" md="12" v-show="editmode">
                              <validation-provider
                                rules="required"
                                v-slot="{errors}"
                                name="Full Name"
                              >
                                <v-text-field
                                  v-model="editData.name"
                                  :rules="rules"
                                  :error-messages="errors"
                                  hide-details="auto"
                                  label="Full Name*"
                                  color="purple darken-4"
                                  required
                                  outlined
                                  hint="This is a required field"
                                ></v-text-field>
                              </validation-provider>
                            </v-col>

                            <v-col cols="12" sm="12" md="12" v-show="editmode">
                              <validation-provider
                                rules="required|email"
                                v-slot="{errors}"
                                name="Email"
                              >
                                <v-text-field
                                  v-model="editData.email"
                                  :rules="rules"
                                  :error-messages="errors"
                                  hide-details="auto"
                                  label="Email *"
                                  color="primary darken-4"
                                  required
                                  outlined
                                  hint="This is a required field"
                                ></v-text-field>
                              </validation-provider>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" v-show="editmode">
                              <v-text-field
                                v-model="editData.password"
                                :type="show ? 'text' : 'password'"
                                :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show = !show"
                                hide-details="auto"
                                label="Password *"
                                color="primary darken-4"
                                required
                                outlined
                                hint="This is a required field"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" v-show="editmode">
                              <validation-provider
                                rules="required"
                                v-slot="{errors}"
                                name="User Type"
                              >
                                <v-select
                                  v-model="editData.userType"
                                  :error-messages="errors"
                                  :items="['Admin','Editor']"
                                  label="Select User Type"
                                  data-vv-name="select"
                                  hint="This is a required field"
                                  required
                                  color="primary darken-4"
                                  outlined
                                ></v-select>
                              </validation-provider>
                            </v-col>
                          </v-row>
                        </v-form>
                      </validation-observer>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <small>*indicates required field</small>
                  <v-spacer></v-spacer>
                  <v-btn color="error darken-4" @click="dialog = false">Close</v-btn>
                  <v-btn
                    color="primary darken-4"
                    @click="
                                            editmode ? updateUser() : addUser();
                                            loader = 'isAdding';
                                        "
                    :loading="isAdding"
                    :disabled="isAdding"
                    v-show="!editmode"
                  >
                    Add User
                    <template v-slot:loader>
                      <span class="custom-loader">
                        <v-icon light>mdi-cached</v-icon>
                      </span>
                    </template>
                  </v-btn>

                  <v-btn
                    color="success darken-4"
                    @click="
                                            editmode ? updateUser() : addUser();
                                            loader = 'isAdding';
                                        "
                    :loading="isAdding"
                    :disabled="isAdding"
                    v-show="editmode"
                  >
                    Edit User
                    <template v-slot:loader>
                      <span class="custom-loader">
                        <v-icon light>mdi-cached</v-icon>
                      </span>
                    </template>
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr v-for="(user, i) in users" :key="i">
                <td>{{ user.id }}</td>
                <td class="_table_name">{{ user.name | upText }}</td>
                <td>{{ user.email}}</td>
                <td>{{ user.userType}}</td>
                <td>{{ user.created_at | myDate }}</td>
                <td>
                  <v-btn
                    small
                    color="primary darken-4"
                    class="ma-1 flat"
                    @click="editUserDialog(user, i)"
                  >Edit</v-btn>
                  <v-btn
                    small
                    color="error darken-4"
                    @click="
                                            deleteUser(user, i);
                                            loader = 'user.isDeleting';
                                        "
                    :loading="user.isDeleting"
                    :disabled="user.isDeleting"
                    class="ma-1 flat"
                  >
                    Delete
                    <template v-slot:loader>
                      <span class="custom-loader">
                        <v-icon light>mdi-cached</v-icon>
                      </span>
                    </template>
                  </v-btn>
                </td>
              </tr>
              <!-- ITEMS -->
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { required, email, max } from "vee-validate/dist/rules";
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate';
setInteractionMode("eager");

extend("required", {
  ...required,
  message: "{_field_} can not be empty"
});

extend('email', {
  ...email,
  message: 'Email must be valid',
})

extend("max", {
  ...max,
  message: "{_field_} may not be greater than {length} characters"
});
export default {
  components: {
    ValidationProvider,
    ValidationObserver
  },
  watch: {
    loader() {
      const l = this.loader;
      this[l] = !this[l];

      setTimeout(() => (this[l] = false), 4000);

      this.loader = null;
    }
  },
  data() {
    return {
      editmode: false,
      rules: [
        value => !!value || "Required.",
        value => (value && value.length >= 2) || "Min 2 characters"
      ],
      password: 'Password',
      show: false,
      data: {
        name: "",
        email: "",
        password: "",
        userType: "",
      },
      editData: {
        name: "",
        email: "",
        password: "",
        userType: "",
      },
      dialog: false,
      isAdding: false,
      isDeleting: false,
      loader: null,
      users: [],
      index: -1,
      deleteItem: {},
      i: -1
    };
  },

  methods: {
    editUserDialog(user, index) {
      this.editmode = true;
      this.data.name = "";
      this.dialog = true;
      this.editData = user;
      this.editData = Object.assign({}, user);
      this.index = index;
    },
    addUserDialog() {
      this.editmode = false;
      this.data.name = "";
      this.dialog = true;
    },
    async updateUser() {
      this.$refs.observer.validate();
      if (this.editData.name.trim() == "") return Toast.fire({
        icon: "error",
        title: "Full Name is Required"
      });
      if (this.editData.email.trim() == "") return Toast.fire({
        icon: "error",
        title: "Email is Required"
      });
      if (this.editData.userType.trim() == "") return Toast.fire({
        icon: "error",
        title: "User Type is Required"
      });
      console.log("Editing Data");
      const res = await this.callApi(
        "post",
        "api/edit_user",
        this.editData
      );
      if (res.status === 200) {
        this.users[this.index] = this.editData;
        Toast.fire({
          icon: "success",
          title: "User Updated Successfully"
        });
        this.dialog = false;
        this.editData.name = "";
        this.editData.email = "";
        this.editData.password = "";
        this.editData.userType = "";
      } else {
        if (res.status == 422) {
          console.log(res.data.errors)
          for (let i in res.data.errors) {
            Toast.fire({
              icon: "error",
              title: res.data.errors[i][0]
            });
            // this.e(res.data.errors[i][0])
          }
        }
        else {
          Toast.fire({
            icon: "error",
            title: "Something Went wrong"
          });
        }
      }
    },

    async addUser() {

      if (this.data.name.trim() == "") return Toast.fire({
        icon: "error",
        title: "Full Name is Required"
      });
      if (this.data.email.trim() == "") return Toast.fire({
        icon: "error",
        title: "Email is Required"
      });
      if (this.data.password.trim() == "") return Toast.fire({
        icon: "error",
        title: "Password is Required"
      });
      if (this.data.userType.trim() == "") return Toast.fire({
        icon: "error",
        title: "User Type is Required"
      });
      this.$refs.observer.validate();
      const res = await this.callApi("post", "api/create_users", this.data);
      if (res.status === 201) {
        this.users.unshift(res.data);
        Toast.fire({
          icon: "success",
          title: "User Created Successfully"
        });
        this.dialog = false;
        this.data.name = "";
        this.data.email = "";
        this.data.password = "";
        this.data.userType = "";
      } else {
        if (res.status == 422) {
          console.log(res.data.errors)
          for (let i in res.data.errors) {
            this.e(res.data.errors[i][0])
          }
        }
        else {
          Toast.fire({
            icon: "error",
            title: "Something Went wrong"
          });
        }
      }
    },
    // async deleteUser(user, i) {
    //   Swal.fire({
    //     title: "Are you sure?",
    //     text: "You won't be able to revert this!",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "Yes, delete it!"
    //   }).then(result => {
    //     if (result.value) {
    //       this.callApi("post", "api/delete_user", user).then(() => {
    //         Swal.fire(
    //           "Deleted!",
    //           "User has been deleted Successfully.",
    //           "success"
    //         ),
    //           this.users.splice(i, 1);
    //       });
    //     }
    //   });
    // }
  },
  async created() {
    const res = await this.callApi("get", "api/get_users", {
      name: "testname"
    });
    if (res.status == 200) {
      this.users = res.data;
    } else {
      this.snackbarError = true;
    }
  }
};
</script>
<style>
.custom-loader {
  animation: loader 1s infinite;
  display: flex;
}
@-moz-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-o-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
