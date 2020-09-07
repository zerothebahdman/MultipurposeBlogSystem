<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <v-snackbar
                    v-model="snackbarSuccess"
                    :timeout="5000"
                    color="success"
                    top
                    right
                    shaped
                >
                    <v-icon>mdi-party-popper</v-icon> Great ! Tag Added
                    Successfully

                    <template v-slot:action="{ attrs }">
                        <v-btn
                            color="white"
                            text
                            v-bind="attrs"
                            @click="snackbar = false"
                        >
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                </v-snackbar>
                <v-snackbar
                    v-model="snackbarError"
                    :timeout="5000"
                    color="error"
                    top
                    right
                >
                    An error occured

                    <template v-slot:action="{ attrs }">
                        <v-btn
                            color="white"
                            text
                            v-bind="attrs"
                            @click="snackbar = false"
                        >
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                </v-snackbar>
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Tags
                        <v-dialog v-model="dialog" persistent max-width="400px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    small
                                    outlined
                                    class="ml-3"
                                    color="indigo"
                                    dark
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon>mdi-plus</v-icon>Add Tag
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">Add Tag</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row justify="center">
                                            <ValidationObserver ref="observer">
                                                <v-form>
                                                    <v-row justify="center">
                                                        <v-col
                                                            cols="12"
                                                            sm="12"
                                                            md="12"
                                                        >
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
                                                        <v-col cols="12">
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
                                    <v-btn
                                        color="error darken-4"
                                        @click="dialog = false"
                                        >Close</v-btn
                                    >
                                    <v-btn
                                        color="success darken-4"
                                        @click="
                                            addTag();
                                            loader = 'isAdding';
                                        "
                                        :loading="isAdding"
                                        :disabled="isAdding"
                                    >
                                        Add Tag
                                        <template v-slot:loader>
                                            <span class="custom-loader">
                                                <v-icon light
                                                    >mdi-cached</v-icon
                                                >
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
                            <tr v-for="tag in tags" :key="tag.id">
                                <td>{{ tag.id }}</td>
                                <td class="_table_name">
                                    {{ tag.tagName }}
                                </td>
                                <td>{{ tag.created_at }}</td>
                                <td>
                                    <v-btn
                                        small
                                        color="primary darken-4"
                                        class="ma-1 flat"
                                        >Edit</v-btn
                                    >
                                    <v-btn
                                        small
                                        color="error darken-4"
                                        class="ma-1 flat"
                                        >Delete</v-btn
                                    >
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
            snackbarSuccess: false,
            snackbarError: false,
            rules: [
                value => !!value || "Required.",
                value => (value && value.length >= 2) || "Min 2 characters"
            ],
            data: {
                tagName: ""
            },
            dialog: false,
            isAdding: false,
            loader: null,
            tags: []
        };
    },
    methods: {
        async addTag() {
            const res = await this.callApi("post", "app/create_tag", this.data);
            if (res.status === 201) {
                this.tags.unshift(res.data);
                this.snackbarSuccess = true;
                this.dialog = false;
                this.data.tagName = "";
            } else {
                this.snackbarError = true;
            }
        }
    },
    async created() {
        const res = await this.callApi("get", "/app/get_tags", {
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
