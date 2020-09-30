<template>
  <div>
    <div class="container">
      <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 loginpage">
        <h1>Login in to Dashboard</h1>
        <validation-observer ref="observer">
          <v-form>
            <validation-provider rules="required|email" v-slot="{errors}" name="Email">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="data.email"
                  hide-details="auto"
                  label="Email *"
                  :error-messages="errors"
                  color="primary darken-4"
                  required
                  outlined
                  hint="This is a required field"
                ></v-text-field>
              </v-col>
            </validation-provider>
            <validation-provider rules="required" v-slot="{errors}" name="Password">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="data.password"
                  :rules="rules"
                  :error-messages="errors"
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
            </validation-provider>
          </v-form>
        </validation-observer>
        <v-col cols="12">
          <div class="login_footer">
            <v-btn
              @click="login(); loader = 'isLogging';"
              :loading="isLogging"
              :disabled="isLogging"
              color="primary darken-4"
              large
              block
            >
              Login
              <template v-slot:loader>
                <span class="custom-loader">
                  <v-icon light>mdi-cached</v-icon>
                </span>
              </template>
            </v-btn>
          </div>
        </v-col>
      </div>
    </div>
  </div>
</template>

<script>
import { required, email } from "vee-validate/dist/rules";
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
export default {
  data() {
    return {
      password: 'Password',
      loader: null,
      show: false,
      isLogging: false,
      data: {
        email: '',
        password: '',
      },
      rules: [
        value => !!value || "Required.",
        value => (value && value.length >= 6) || "Min 6 characters"
      ],
    }
  },
  watch: {
    loader() {
      const l = this.loader;
      this[l] = !this[l];

      setTimeout(() => (this[l] = false), 4000);

      this.loader = null;
    }
  },
  methods: {
    async login() {
      this.$refs.observer.validate();
      if (this.data.email.trim() == "") return Toast.fire({
        icon: "error",
        title: "Email is Required"
      });
      if (this.data.password.trim() == "") return Toast.fire({
        icon: "error",
        title: "Password is Required"
      });
      if (this.data.password.length < 6) return Toast.fire({
        icon: "error",
        title: "Password must be atleast 6 characters long"
      });
      //   this.isLogging = true;
      const res = await this.callApi('post', 'api/admin_login', this.data)
      if (res.status === 200) {
        Toast.fire({
          icon: 'success',
          title: res.data.msg
        });
      } else {
        if (res.status === 401) {
          Toast.fire({
            icon: 'info',
            title: res.data.msg
          });
        } else if (res.status === 422) {
          for (let i in res.data.errors) {
            this.e(res.data.errors[i][0])
          }
        } else {
          Toast.fire({
            icon: 'error',
            title: 'Something went wrong'
          });
        }
      }
      //   this.isLogging = false;
    }
  },
  components: {
    ValidationProvider,
    ValidationObserver
  },
}
</script>

<style scoped>
@media (max-width: 768px) {
  .loginpage {
    text-align: center;
    margin-top: 200px;
    /* display: flex; */
    align-items: center;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
  }
}
@media (min-width: 768px) {
  .loginpage {
    text-align: center;
    margin-top: 200px;
    /* display: flex; */
    align-items: center;
    margin-left: auto;
    margin-right: auto;
    width: 60%;
  }
  ._box_shadow {
    box-shadow: 0 10px 20px rgba(73, 73, 75, 0.548);
  }
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
