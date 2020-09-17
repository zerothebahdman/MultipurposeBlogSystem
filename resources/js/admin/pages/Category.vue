<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0">
            Category
            <v-dialog v-model="dialog" persistent max-width="400px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  small
                  @click.prevent="addCategoryDialog"
                  outlined
                  class="ml-3"
                  color="indigo"
                  dark
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon>mdi-select-group</v-icon>Add
                  Category
                </v-btn>
              </template>
              <!-- Add Category Modal -->
              <v-card>
                <v-card-title>
                  <span v-show="editmode" class="headline">Edit Category</span>
                  <span v-show="!editmode" class="headline">Add Category</span>
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
                                v-slot="{errors}"
                                name="Category"
                              >
                                <v-text-field
                                  v-model="data.categoryName"
                                  :rules="rules"
                                  :error-messages="errors"
                                  hide-details="auto"
                                  label="Category Name*"
                                  color="primary darken-4"
                                  required
                                  hint="This is a required field"
                                ></v-text-field>
                              </ValidationProvider>
                            </v-col>
                            <v-col cols="12" sm="12" md="12" v-show="editmode">
                              <ValidationProvider
                                rules="required"
                                v-slot="{errors}"
                                name="Category Name"
                              >
                                <v-text-field
                                  v-model="editData.categoryName"
                                  :rules="rules"
                                  :error-messages="errors"
                                  hide-details="auto"
                                  label="Category Name*"
                                  color="primary darken-4"
                                  required
                                  hint="This is a required field"
                                ></v-text-field>
                              </ValidationProvider>
                            </v-col>
                            <v-col v-show="!editmode" cols="12" sm="12" md="12">
                              <Upload
                                multiple
                                ref="uploads"
                                :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :format="['jpg','jpeg','png']"
                                :max-size="2048"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                type="drag"
                                action="api/upload_file"
                              >
                                <div style="padding: 20px 0">
                                  <Icon type="ios-cloud-upload" size="52" style="color #3399ff"></Icon>
                                  <p>
                                    Click
                                    or
                                    drag
                                    here
                                    to
                                    upload
                                  </p>
                                </div>
                              </Upload>

                              <div class="demo-upload-list" v-if="data.image">
                                <img :src="`/img/uploads/${data.image}`" />
                                <div class="demo-upload-list-cover">
                                  <Icon type="ios-trash-outline" @click.prevent="deleteImage()"></Icon>
                                </div>
                              </div>
                            </v-col>
                            <v-col v-show="editmode" cols="12" sm="12" md="12">
                              <Upload
                                multiple
                                ref="uploads"
                                :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :format="['jpg','jpeg','png']"
                                :max-size="2048"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                type="drag"
                                action="api/upload_file"
                              >
                                <div style="padding: 20px 0">
                                  <Icon type="ios-cloud-upload" size="52" style="color #3399ff"></Icon>
                                  <p>
                                    Click
                                    or
                                    drag
                                    here
                                    to
                                    upload
                                  </p>
                                </div>
                              </Upload>

                              <div class="demo-upload-list" v-if="data.image">
                                <img :src="`/img/uploads/${data.image}`" />
                                <div class="demo-upload-list-cover">
                                  <Icon type="ios-trash-outline" @click.prevent="deleteImage()"></Icon>
                                </div>
                              </div>
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
                    @click.prevent="
                                            editmode
                                                ? updateCategory()
                                                : addCategory();
                                            loader = 'isAdding';
                                        "
                    :loading="isAdding"
                    :disabled="isAdding"
                    v-show="!editmode"
                  >
                    Add Category
                    <template v-slot:loader>
                      <span class="custom-loader">
                        <v-icon light>mdi-cached</v-icon>
                      </span>
                    </template>
                  </v-btn>

                  <v-btn
                    color="success darken-4"
                    @click.prevent="
                                            editmode
                                                ? updateCategory()
                                                : addCategory();
                                            loader = 'isAdding';
                                        "
                    :loading="isAdding"
                    :disabled="isAdding"
                    v-show="editmode"
                  >
                    Edit Category
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
                <th>Category Name</th>
                <th>Icon Image</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr v-for="(category, i) in categories" :key="i">
                <td>{{ category.id }}</td>
                <td class="_table_name">{{ category.categoryName | upText }}</td>
                <td class="table_image">
                  <img :src="category.image" />
                </td>
                <td>{{ category.created_at | myDate }}</td>
                <td>
                  <v-btn
                    small
                    color="primary darken-4"
                    class="ma-1 flat"
                    @click.prevent="
                                            editCategoryDialog(category, i)
                                        "
                  >Edit</v-btn>
                  <v-btn
                    small
                    color="error darken-4"
                    @click.prevent="
                                            deleteCategory(category, i);
                                            loader = 'category.isDeleting';
                                        "
                    :loading="category.isDeleting"
                    :disabled="category.isDeleting"
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
        categoryName: "",
        image: ""
      },
      editData: {
        categoryName: "",
        image: ""
      },
      dialog: false,
      isAdding: false,
      isDeleting: false,
      loader: null,
      categories: [],
      index: -1,
      deleteItem: {},
      i: -1,
      token: "",
    };
  },

  methods: {
    handleSuccess(res, file) {
      this.data.image = res;
    },
    handleError(res, file) {
      Swal.fire(
        "The File format is incorrect.",
        `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}`,
        "error"
      );
    },
    handleFormatError(file) {
      Swal.fire(
        "The File format is incorrect.",
        "File format of " + file.name + " is incorrect. Please select JPG or PNG file.",
        "error"
      );
    },
    handleMaxSize(file) {
      Swal.fire(
        "Exceeding File Size Limit",
        "File format of " + file.name + " is too large, no more than 2MB.",
        "error"
      );
    },
    async deleteImage() {
      console.log(this.data.image);
      let image = this.data.image
      this.data.image = ''
      this.$refs.uploads.clearFiles();
      const res = await this.callApi('post', 'api/delete_image', { imageName: image })
      if (res.status != 200) {
        this.data.image = image
        Toast.fire({
          icon: "error",
          title: "Something went wrong"
        });
      }
    },
    uploadImage(e) {
      console.log(e);
      let file = e.target.files[0];
      let reader = new FileReader();
      if (file["size"] < 3145728) {
        reader.onload = file => {
          this.data.image = reader.result;
          // console.log("RESULT", reader.result);
        };
        reader.readAsDataURL(file);
      } else {
        Swal.fire(
          "Opps!! File Too Large.",
          "Selected file is above 3MB.",
          "error"
        );
      }
    },
    editCategoryDialog(category, index) {
      this.editmode = true;
      this.editData.categoryName = "";
      this.dialog = true;
      this.editData.categoryName = category.categoryName;
      //   this.data.image = category.image;
      this.editData = Object.assign({}, category);
      this.index = index;
    },
    addCategoryDialog() {
      this.editmode = false;
      this.data.categoryName = "";
      this.data.image = "";
      this.dialog = true;
    },

    async updateCategory() {
      this.$refs.observer.validate();
      console.log("Editing Data");
      const res = await this.callApi(
        "put",
        "api/edit_category",
        this.editData
      );
      if (res.status === 200) {
        this.categories[
          this.index
        ].categoryName = this.editData.categoryName;
        Toast.fire({
          icon: "success",
          title: "Category Updated Successfully"
        });
        this.dialog = false;
        this.data.categoryName = "";
        this.data.image = "";
      } else {
        Toast.fire({
          icon: "error",
          title: "An Error Occured"
        });
      }
    },

    async addCategory() {
      this.$refs.observer.validate();
      if (this.data.categoryName.trim() == "") return Toast.fire({
        icon: "error",
        title: "Category Name is Required"
      });
      if (this.data.image.trim() == "") return Toast.fire({
        icon: "error",
        title: "Image is Required"
      });
      this.data.image = `/img/uploads/${this.data.image}`
      const res = await this.callApi("post", "api/category", this.data);
      if (res.status === 201) {
        this.categories.unshift(res.data);
        Toast.fire({
          icon: "success",
          title: "Category has been added Successfully"
        });
        this.dialog = false;
        this.data.categoryName = "";
        this.data.image = "";
      } else {
        if (res.status == 422) {
          if (res.data.errors.categoryName) {
            Toast.fire({
              icon: "error",
              title: res.data.errors.categoryName[0]
            });
          }
          if (res.data.errors.image) {
            Toast.fire({
              icon: "error",
              title: res.data.errors.image[0]
            });
          }
        } else {
          Toast.fire({
            icon: "error",
            title: "An Error Occured."
          });
        }
      }
    },
    async deleteCategory(category, i) {
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
          this.callApi("post", "api/delete_category", category).then(
            () => {
              Swal.fire(
                "Deleted!",
                "Category has been deleted Successfully.",
                "success"
              ),
                this.categories.splice(i, 1);
            }
          );
        }
      });
    }
  },
  async created() {
    this.token = window.Laravel.csrfToken
    const res = await this.callApi("get", "api/category", {
      categoryName: "testcategroy"
    });
    if (res.status == 200) {
      this.categories = res.data;
    } else {
      Toast.fire({
        icon: "error",
        title: "An Error Occured."
      });
    }
  }
};
</script>
<style>
.demo-upload-list {
  display: inline-block;
  width: 300px;
  height: 180px;
  text-align: center;
  line-height: 60px;
  border: 1px solid transparent;
  border-radius: 4px;
  overflow: hidden;
  background: #fff;
  position: relative;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  margin-right: 4px;
}
.demo-upload-list img {
  width: 100%;
  height: 100%;
}
.demo-upload-list-cover {
  display: none;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.541);
}
.demo-upload-list:hover .demo-upload-list-cover {
  display: block;
}
.demo-upload-list-cover i {
  color: #fff;
  font-size: 30px;
  cursor: pointer;
  margin: 5rem 30px 0px 30px;
}
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
