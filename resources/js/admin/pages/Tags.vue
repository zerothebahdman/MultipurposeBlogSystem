<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0">
            Tags
            <v-dialog v-model="dialog" persistent max-width="400px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  small
                  @click="addTagDialog"
                  outlined
                  class="ml-3"
                  color="indigo"
                  dark
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon>mdi-tag-plus-outline</v-icon>Add Tag
                </v-btn>
              </template>
              <!-- Add Tag Modal -->
              <v-card>
                <v-card-title>
                  <span v-show="editmode" class="headline">Edit Tag</span>
                  <span v-show="!editmode" class="headline">Add Tag</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row justify="center">
                      <ValidationObserver ref="observer">
                        <v-form>
                          <v-row justify="center">
                            <v-col cols="12" sm="12" md="12" v-show="!editmode">
                              <ValidationProvider
                                rules="required"
                                v-slot="{
                                                                    errors
                                                                }"
                                name="Tag Name"
                              >
                                <v-text-field
                                  v-model="
                                                                        data.tagName
                                                                    "
                                  :rules="
                                                                        rules
                                                                    "
                                  :error-messages="
                                                                        errors
                                                                    "
                                  hide-details="auto"
                                  label="Tag Name*"
                                  color="purple darken-2"
                                  required
                                  hint="This is a required field"
                                ></v-text-field>
                              </ValidationProvider>
                            </v-col>
                            <v-col cols="12" sm="12" md="12" v-show="editmode">
                              <ValidationProvider
                                rules="required"
                                v-slot="{
                                                                    errors
                                                                }"
                                name="Tag Name"
                              >
                                <v-text-field
                                  v-model="
                                                                        editData.tagName
                                                                    "
                                  :rules="
                                                                        rules
                                                                    "
                                  :error-messages="
                                                                        errors
                                                                    "
                                  hide-details="auto"
                                  label="Tag Name*"
                                  color="purple darken-2"
                                  required
                                  hint="This is a required field"
                                ></v-text-field>
                              </ValidationProvider>
                            </v-col>
                          </v-row>
                        </v-form>
                      </ValidationObserver>
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
                                            editmode ? updateTag() : addTag();
                                            loader = 'isAdding';
                                        "
                    :loading="isAdding"
                    :disabled="isAdding"
                    v-show="!editmode"
                  >
                    Add Tag
                    <template v-slot:loader>
                      <span class="custom-loader">
                        <v-icon light>mdi-cached</v-icon>
                      </span>
                    </template>
                  </v-btn>

                  <v-btn
                    color="success darken-4"
                    @click="
                                            editmode ? updateTag() : addTag();
                                            loader = 'isAdding';
                                        "
                    :loading="isAdding"
                    :disabled="isAdding"
                    v-show="editmode"
                  >
                    Edit Tag
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
                <th>Tag Name</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr v-for="(tag, i) in tags" :key="i">
                <td>{{ tag.id }}</td>
                <td class="_table_name">{{ tag.tagName | upText }}</td>
                <td>{{ tag.created_at | myDate }}</td>
                <td>
                  <v-btn
                    small
                    color="primary darken-4"
                    class="ma-1 flat"
                    @click="editTagDialog(tag, i)"
                  >Edit</v-btn>
                  <v-btn
                    small
                    color="error darken-4"
                    @click="
                                            deleteTag(tag, i);
                                            loader = 'tag.isDeleting';
                                        "
                    :loading="tag.isDeleting"
                    :disabled="tag.isDeleting"
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
import { required, max } from "vee-validate/dist/rules";
import {
  extend,
  ValidationObserver,
  ValidationProvider,
  setInteractionMode
} from "vee-validate";
setInteractionMode("eager");

extend("required", {
  ...required,
  message: "{_field_} can not be empty"
});

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
      data: {
        tagName: ""
      },
      editData: {
        tagName: ""
      },
      dialog: false,
      isAdding: false,
      isDeleting: false,
      loader: null,
      tags: [],
      index: -1,
      deleteItem: {},
      i: -1
    };
  },

  methods: {
    editTagDialog(tag, index) {
      this.editmode = true;
      this.data.tagName = "";
      this.dialog = true;
      this.data.tagName = tag.tagName;
      this.editData = Object.assign({}, tag);
      this.index = index;
    },
    addTagDialog() {
      this.editmode = false;
      this.data.tagName = "";
      this.dialog = true;
    },
    async updateTag() {
      this.$refs.observer.validate();
      console.log("Editing Data");
      this.$refs.observer.validate();
      const res = await this.callApi(
        "post",
        "api/edit_tag",
        this.editData
      );
      if (res.status === 200) {
        this.tags[this.index].tagName = this.editData.tagName;
        Toast.fire({
          icon: "success",
          title: "Tag Updated Successfully"
        });
        this.dialog = false;
        this.data.tagName = "";
      } else {
        Toast.fire({
          icon: "error",
          title: "An Error Occured"
        });
      }
    },
    async addTag() {
      this.$refs.observer.validate();
      if (this.data.tagName.trim() == "") return Toast.fire({
        icon: "error",
        title: "Tag Name is Required"
      });
      const res = await this.callApi("post", "api/tag", this.data);
      if (res.status === 201) {
        this.tags.unshift(res.data);
        Toast.fire({
          icon: "success",
          title: "Tag Created Successfully"
        });
        this.dialog = false;
        this.data.tagName = "";
      } else {
        Toast.fire({
          icon: "error",
          title: "An Error Occured."
        });
      }
    },
    async deleteTag(tag, i) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          this.callApi("post", "api/delete_tag", tag).then(() => {
            Swal.fire(
              "Deleted!",
              "Tag has been deleted Successfully.",
              "success"
            ),
              this.tags.splice(i, 1);
          });
        }
      });
    }
  },
  async created() {
    const res = await this.callApi("get", "api/tag", {
      tagName: "testtag"
    });
    if (res.status == 200) {
      this.tags = res.data;
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
